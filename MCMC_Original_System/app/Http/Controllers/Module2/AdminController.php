<?php

namespace App\Http\Controllers\Module2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inquiry;
use App\Models\Agency;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard for Module2
     */
    public function index()
    {
        $stats = [
            'total_inquiries' => Inquiry::count(),
            'pending_review' => Inquiry::where('status', 'pending')->count(),
            'in_progress' => Inquiry::where('status', 'in-progress')->count(),
            'completed_today' => Inquiry::where('status', 'completed')
                ->whereDate('updated_at', today())
                ->count(),
            'assigned_inquiries' => Inquiry::whereNotNull('assigned_agency_id')->count(),
            'unassigned_inquiries' => Inquiry::whereNull('assigned_agency_id')
                ->where('status', 'pending')
                ->count()
        ];

        $recentInquiries = Inquiry::with(['user', 'assignedAgency'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('Module2.admin.dashboard', compact('stats', 'recentInquiries'));
    }

    /**
     * Display list of all inquiries for admin review
     */
    public function listOfInquiries(Request $request)
    {
        $query = Inquiry::with(['user', 'assignedAgency']);

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('agency_id')) {
            $query->where('assigned_agency_id', $request->agency_id);
        }

        if ($request->filled('date_range')) {
            $dateRange = $request->date_range;
            switch ($dateRange) {
                case 'today':
                    $query->whereDate('created_at', today());
                    break;
                case 'week':
                    $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'month':
                    $query->whereMonth('created_at', now()->month)
                          ->whereYear('created_at', now()->year);
                    break;
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('subject', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%")
                  ->orWhere('id', 'LIKE', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'LIKE', "%{$search}%")
                               ->orWhere('email', 'LIKE', "%{$search}%");
                  });
            });
        }

        $inquiries = $query
        // BUG-M2-003 Display inquiries in descending order based on created date (Fixed)
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        $agencies = Agency::where('status', 'active')->get();

        $stats = [
            'total' => Inquiry::count(),
            'pending' => Inquiry::where('status', 'pending')->count(),
            'assigned' => Inquiry::where('status', 'assigned')->count(),
            'in_progress' => Inquiry::where('status', 'in-progress')->count(),
            'completed' => Inquiry::where('status', 'completed')->count(),
            'rejected' => Inquiry::where('status', 'rejected')->count()
        ];

        return view('Module2.admin.listOfInquiriesPage', compact('inquiries', 'agencies', 'stats'));
    }

    /**
     * Display detailed view of a specific inquiry for review
     */
    public function reviewInquiry($inquiryId)
    {
        $inquiry = Inquiry::with(['user', 'assignedAgency', 'attachments', 'activities'])
            ->findOrFail($inquiryId);

        $agencies = Agency::where('status', 'active')->get();
          // Sample related inquiries data
        $relatedInquiries = collect([
            (object)['id' => 2, 'title' => 'Previous inquiry about healthcare', 'status' => 'completed', 'created_at' => now()->subDays(10)],
            (object)['id' => 3, 'title' => 'Another healthcare question', 'status' => 'in-progress', 'created_at' => now()->subDays(20)]
        ]);

        return view('Module2.admin.reviewInquiryPage', compact('inquiry', 'agencies', 'relatedInquiries'));
    }

    /**
     * Update inquiry status and details
     */
    public function updateInquiryStatus(Request $request, $inquiryId)
    {
        $request->validate([
            'status' => 'required|in:pending,assigned,in-progress,under-review,completed,rejected',
            'admin_notes' => 'nullable|string|max:1000',
            'priority' => 'nullable|in:low,medium,high',
            'due_date' => 'nullable|date|after:today'
        ]);

        DB::beginTransaction();
        
        try {
            $inquiry = Inquiry::findOrFail($inquiryId);
            $oldStatus = $inquiry->status;

            $updateData = [
                'status' => $request->status,
                'reviewed_by' => Auth::id(),
                'reviewed_at' => now()
            ];

            if ($request->filled('admin_notes')) {
                $updateData['admin_notes'] = $request->admin_notes;
            }

            if ($request->filled('priority')) {
                $updateData['priority'] = $request->priority;
            }

            if ($request->filled('due_date')) {
                $updateData['due_date'] = $request->due_date;
            }

            $inquiry->update($updateData);

            // Log the status update
            $inquiry->activities()->create([
                'action' => 'Status Updated',
                'description' => "Status changed from {$oldStatus} to {$request->status}",
                'performed_by' => Auth::id(),
                'notes' => $request->admin_notes
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Inquiry status updated successfully',
                'inquiry' => $inquiry->load(['user', 'assignedAgency'])
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to update inquiry status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate reports page
     */
    public function generateReport(Request $request)
    {
        $reportType = $request->get('report_type', 'summary');
        $startDate = $request->get('start_date', now()->subMonth());
        $endDate = $request->get('end_date', now());

        $data = [];

        switch ($reportType) {
            case 'summary':
                $data = $this->generateSummaryReport($startDate, $endDate);
                break;
            case 'agency_performance':
                $data = $this->generateAgencyPerformanceReport($startDate, $endDate);
                break;
            case 'inquiry_trends':
                $data = $this->generateInquiryTrendsReport($startDate, $endDate);
                break;
            case 'user_activity':
                $data = $this->generateUserActivityReport($startDate, $endDate);
                break;
        }

        if ($request->ajax() || $request->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => $data,
                'report_type' => $reportType,
                'period' => [
                    'start_date' => $startDate,
                    'end_date' => $endDate
                ]
            ]);
        }

        return view('Module2.admin.generateReportPage', compact('data', 'reportType', 'startDate', 'endDate'));
    }

    /**
     * Generate summary report
     */
    private function generateSummaryReport($startDate, $endDate)
    {
        return [
            'total_inquiries' => Inquiry::whereBetween('created_at', [$startDate, $endDate])->count(),
            'completed_inquiries' => Inquiry::where('status', 'completed')
                ->whereBetween('updated_at', [$startDate, $endDate])->count(),
            'pending_inquiries' => Inquiry::where('status', 'pending')->count(),
            'average_response_time' => $this->calculateAverageResponseTime($startDate, $endDate),
            'inquiries_by_status' => Inquiry::whereBetween('created_at', [$startDate, $endDate])
                ->selectRaw('status, COUNT(*) as count')
                ->groupBy('status')
                ->pluck('count', 'status'),
            'inquiries_by_priority' => Inquiry::whereBetween('created_at', [$startDate, $endDate])
                ->selectRaw('priority, COUNT(*) as count')
                ->groupBy('priority')
                ->pluck('count', 'priority'),
            'daily_submissions' => $this->getDailySubmissions($startDate, $endDate)
        ];
    }

    /**
     * Generate agency performance report
     */
    private function generateAgencyPerformanceReport($startDate, $endDate)
    {
        return Agency::with(['assignedInquiries' => function($query) use ($startDate, $endDate) {
            $query->whereBetween('assigned_at', [$startDate, $endDate]);
        }])->get()->map(function($agency) use ($startDate, $endDate) {
            $assignedInquiries = $agency->assignedInquiries;
            $completedInquiries = $assignedInquiries->where('status', 'completed');
            
            return [
                'agency_name' => $agency->name,
                'total_assigned' => $assignedInquiries->count(),
                'completed' => $completedInquiries->count(),
                'completion_rate' => $assignedInquiries->count() > 0 
                    ? round(($completedInquiries->count() / $assignedInquiries->count()) * 100, 2) 
                    : 0,
                'average_completion_time' => $this->calculateAverageCompletionTime($completedInquiries),
                'overdue_inquiries' => $assignedInquiries->where('due_date', '<', now())
                    ->whereIn('status', ['assigned', 'in-progress'])
                    ->count()
            ];
        });
    }

    /**
     * Generate inquiry trends report
     */
    private function generateInquiryTrendsReport($startDate, $endDate)
    {
        return [
            'monthly_trends' => $this->getMonthlyTrends($startDate, $endDate),
            'category_distribution' => $this->getCategoryDistribution($startDate, $endDate),
            'peak_hours' => $this->getPeakSubmissionHours($startDate, $endDate),
            'user_types' => $this->getUserTypeDistribution($startDate, $endDate)
        ];
    }

    /**
     * Generate user activity report
     */
    private function generateUserActivityReport($startDate, $endDate)    {
        // Sample analytics data
        return [
            'new_users' => 45,
            'active_users' => 123,
            'top_users' => collect([
                (object)['id' => 1, 'name' => 'John Doe', 'inquiries_count' => 12],
                (object)['id' => 2, 'name' => 'Jane Smith', 'inquiries_count' => 8],
                (object)['id' => 3, 'name' => 'Ahmed Ali', 'inquiries_count' => 6]
            ]),
            'user_satisfaction' => $this->calculateUserSatisfaction($startDate, $endDate)
        ];
    }

    // Helper methods for calculations
    private function calculateAverageResponseTime($startDate, $endDate)
    {
        return Inquiry::whereBetween('created_at', [$startDate, $endDate])
            ->whereNotNull('assigned_at')
            ->selectRaw('AVG(TIMESTAMPDIFF(HOUR, created_at, assigned_at)) as avg_hours')
            ->value('avg_hours') ?? 0;
    }

    private function calculateAverageCompletionTime($inquiries)
    {
        if ($inquiries->isEmpty()) return 0;
        
        $totalHours = $inquiries->sum(function($inquiry) {
            if ($inquiry->assigned_at && $inquiry->updated_at) {
                return $inquiry->assigned_at->diffInHours($inquiry->updated_at);
            }
            return 0;
        });

        return round($totalHours / $inquiries->count(), 2);
    }

    private function getDailySubmissions($startDate, $endDate)
    {
        return Inquiry::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date');
    }

    private function getMonthlyTrends($startDate, $endDate)
    {
        return Inquiry::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('year', 'month')
            ->orderBy('year', 'month')
            ->get();
    }

    private function getCategoryDistribution($startDate, $endDate)
    {
        return Inquiry::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('category, COUNT(*) as count')
            ->groupBy('category')
            ->pluck('count', 'category');
    }

    private function getPeakSubmissionHours($startDate, $endDate)
    {
        return Inquiry::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('HOUR(created_at) as hour, COUNT(*) as count')
            ->groupBy('hour')
            ->orderBy('count', 'desc')
            ->limit(5)
            ->pluck('count', 'hour');
    }

    private function getUserTypeDistribution($startDate, $endDate)
    {
        return Inquiry::with('user')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get()
            ->groupBy('user.user_type')
            ->map->count();
    }

    private function calculateUserSatisfaction($startDate, $endDate)
    {
        // This would typically be based on user feedback/ratings
        // For now, return a placeholder calculation
        return [
            'average_rating' => 4.2,
            'total_ratings' => 85,
            'satisfaction_rate' => 87.5
        ];
    }
}