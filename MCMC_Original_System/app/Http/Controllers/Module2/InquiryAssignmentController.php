<?php

namespace App\Http\Controllers\Module2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inquiry;
use App\Models\Agency;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InquiryAssignmentController extends Controller
{
    /**
     * Display the inquiry assignment dashboard for admins
     */
    public function index()
    {
        $unassignedInquiries = Inquiry::where('status', 'pending')
            ->whereNull('assigned_agency_id')
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        $agencies = Agency::where('status', 'active')
            ->withCount(['assignedInquiries' => function($query) {
                $query->whereIn('status', ['assigned', 'in-progress']);
            }])
            ->get();

        $stats = [
            'total_unassigned' => $unassignedInquiries->count(),
            'total_agencies' => $agencies->count(),
            'pending_assignments' => Inquiry::where('InquiryStatus', 'assigned')->count(),
            'completed_today' => Inquiry::where('InquiryStatus', 'completed')
                ->whereDate('updated_at', today())
                ->count()
        ];

        return view('Module2.admin.assignInquiryPage', compact(
            'unassignedInquiries',
            'agencies',
            'stats'
        ));
    }

    /**
     * Assign an inquiry to an agency
     */
    public function assignInquiry(Request $request)
    {
        $request->validate([
            'inquiry_id' => 'required|exists:inquiries,id',
            'agency_id' => 'required|exists:agencies,id',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'required|date|after_or_equal:today',
            'notes' => 'nullable|string|max:1000'
        ]);

        DB::beginTransaction();
        
        try {
            $inquiry = Inquiry::findOrFail($request->inquiry_id);
            $agency = Agency::findOrFail($request->agency_id);

            // Update inquiry with assignment details
            $inquiry->update([
    'assigned_agency_id' => $request->agency_id,
    'AgencyID' => $request->agency_id,
    'InquiryStatus' => 'Under Investigation',
    'priority' => $request->priority,
    'due_date' => $request->due_date,
    'assigned_at' => now(),
    'assigned_by' => Auth::id(),
    'assignment_notes' => $request->notes
]);      // Log the assignment activity
            $inquiry->activities()->create([
                'action' => 'Inquiry Assigned',
                'description' => "Assigned to {$agency->name} by " . (Auth::user()->name ?? 'Unknown'),
                'performed_by' => Auth::id(),
                'notes' => $request->notes
            ]);

            // Send notification to agency (implement as needed)
            // $this->notifyAgency($agency, $inquiry);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Inquiry assigned successfully',
                'inquiry' => $inquiry->load('assignedAgency')
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to assign inquiry: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk assign multiple inquiries
     */
    public function bulkAssign(Request $request)
    {
        $request->validate([
            'inquiry_ids' => 'required|array',
            'inquiry_ids.*' => 'exists:inquiries,id',
            'agency_id' => 'required|exists:agencies,id',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'required|date|after:today'
        ]);

        DB::beginTransaction();
        
        try {
            $agency = Agency::findOrFail($request->agency_id);
            $assignedCount = 0;

            foreach ($request->inquiry_ids as $inquiryId) {
                $inquiry = Inquiry::find($inquiryId);
                
                if ($inquiry && $inquiry->InquiryStatus === 'pending' && !$inquiry->assigned_agency_id) {
                    $inquiry->update([
                        'assigned_agency_id' => $request->agency_id,
                        'InquiryStatus' => 'assigned',
                        'priority' => $request->priority,
                        'due_date' => $request->due_date,
                        'assigned_at' => now(),
                        'assigned_by' => Auth::id()
                    ]);                    $inquiry->activities()->create([
                        'action' => 'Inquiry Assigned (Bulk)',
                        'description' => "Assigned to {$agency->name} by " . (Auth::user()->name ?? 'Unknown'),
                        'performed_by' => Auth::id()
                    ]);

                    $assignedCount++;
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "{$assignedCount} inquiries assigned successfully",
                'assigned_count' => $assignedCount
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to assign inquiries: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reassign an inquiry to a different agency
     */
    public function reassignInquiry(Request $request, $inquiryId)
    {
        $request->validate([
            'new_agency_id' => 'required|exists:agencies,id',
            'reason' => 'required|string|max:500',
            'priority' => 'nullable|in:low,medium,high',
            'due_date' => 'nullable|date|after:today'
        ]);

        DB::beginTransaction();
        
        try {
            $inquiry = Inquiry::findOrFail($inquiryId);
            $oldAgency = $inquiry->assignedAgency;
            $newAgency = Agency::findOrFail($request->new_agency_id);

            // Update assignment
            $updateData = [
                'assigned_agency_id' => $request->new_agency_id,
                'InquiryStatus' => 'assigned',
                'assigned_at' => now(),
                'assigned_by' => Auth::id(),
                'reassignment_reason' => $request->reason
            ];

            if ($request->priority) {
                $updateData['priority'] = $request->priority;
            }

            if ($request->due_date) {
                $updateData['due_date'] = $request->due_date;
            }

            $inquiry->update($updateData);            // Log the reassignment
            $inquiry->activities()->create([
                'action' => 'Inquiry Reassigned',
                'description' => "Reassigned from {$oldAgency->name} to {$newAgency->name} by " . (Auth::user()->name ?? 'Unknown'),
                'performed_by' => Auth::id(),
                'notes' => $request->reason
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Inquiry reassigned successfully',
                'inquiry' => $inquiry->load('assignedAgency')
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to reassign inquiry: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get agency workload statistics
     */
    public function getAgencyWorkload($agencyId = null)
    {
        $query = Agency::query();
        
        if ($agencyId) {
            $query->where('id', $agencyId);
        }

        $agencies = $query->withCount([
    'assignedInquiries as active_inquiries_count' => function($q) {
        $q->whereIn('InquiryStatus', ['Pending', 'Under Investigation']);
    },
    'assignedInquiries as completed_this_month_count' => function($q) {
        $q->whereIn('InquiryStatus', ['Verified as True', 'Identified as Fake', 'Rejected'])
          ->whereMonth('updated_at', now()->month)
          ->whereYear('updated_at', now()->year);
    },
    'assignedInquiries as overdue_count' => function($q) {
        $q->whereIn('InquiryStatus', ['Pending', 'Under Investigation'])
          ->where('due_date', '<', now());
    }
])->get();

        return response()->json([
            'success' => true,
            'agencies' => $agencies
        ]);
    }

    /**
     * Get assignment history and analytics
     */
    public function getAssignmentAnalytics(Request $request)
    {
        $startDate = $request->get('start_date', now()->subMonth());
        $endDate = $request->get('end_date', now());

        $analytics = [
            'total_assignments' => Inquiry::whereBetween('assigned_at', [$startDate, $endDate])->count(),
            'avg_assignment_time' => Inquiry::whereBetween('assigned_at', [$startDate, $endDate])
                ->selectRaw('AVG(TIMESTAMPDIFF(HOUR, created_at, assigned_at)) as avg_hours')
                ->value('avg_hours'),
            'assignments_by_priority' => Inquiry::whereBetween('assigned_at', [$startDate, $endDate])
                ->selectRaw('priority, COUNT(*) as count')
                ->groupBy('priority')
                ->pluck('count', 'priority'),
            'assignments_by_agency' => Inquiry::with('assignedAgency')
                ->whereBetween('assigned_at', [$startDate, $endDate])
                ->get()
                ->groupBy('assignedAgency.name')
                ->map->count(),
            'completion_rate' => $this->calculateCompletionRate($startDate, $endDate)
        ];

        return response()->json([
            'success' => true,
            'analytics' => $analytics,
            'period' => [
                'start_date' => $startDate,
                'end_date' => $endDate
            ]
        ]);
    }

    /**
     * Calculate completion rate for assigned inquiries
     */
    private function calculateCompletionRate($startDate, $endDate)
    {
        $totalAssigned = Inquiry::whereBetween('assigned_at', [$startDate, $endDate])->count();
        $completed = Inquiry::whereBetween('assigned_at', [$startDate, $endDate])
            ->where('InquiryStatus', 'completed')
            ->count();

        return $totalAssigned > 0 ? round(($completed / $totalAssigned) * 100, 2) : 0;
    }

    /**
     * Send notification to agency about new assignment
     */
    private function notifyAgency($agency, $inquiry)
    {
        // Implement notification logic (email, SMS, in-app notification)
        // This could use Laravel's notification system
    }
}
