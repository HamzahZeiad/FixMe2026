<?php

namespace App\Http\Controllers\Module1;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use App\Models\Module1\Administrator as Module1Administrator;
use App\Models\Module1\PublicUsers as Module1PublicUsers;
use App\Models\Module1\Agency as Module1Agency;
use App\Models\Inquiry;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class AdminController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Show admin home dashboard - Module1
     */
    public function showHome()
    {
        // Get admin data using Module1 model - session is guaranteed by middleware
        $admin = Module1Administrator::find(session('admin_id'));

        // Get dashboard statistics using Module1 models
        $stats = [
            'total_inquiries' => \App\Models\Inquiry::count(),
            'pending_inquiries' => \App\Models\Inquiry::whereNull('AgencyID')->count(), // Inquiries not yet assigned to an agency
            'total_agencies' => Module1Agency::count(),
            'total_users' => Module1PublicUsers::count(),
        ];

        // Get recent inquiries for activity feed
        $recentActivities = \App\Models\Inquiry::with('agency')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.adminHome', compact('admin', 'stats', 'recentActivities'));
    }

    /**
     * Show all public users and agencies with search functionality - Module1
     */
    public function showUsers(Request $request)
    {
        // Handle user search using Module1 model
        $users = [];
        if ($request->has('search') && !empty($request->search)) {
            $users = Module1PublicUsers::search($request->search);
        } else {
            $users = Module1PublicUsers::all();
        }

        // Handle agency search using Module1 model
        $agencies = [];
        if ($request->has('agency_search') && !empty($request->agency_search)) {
            $agencies = Module1Agency::search($request->agency_search);
        } else {
            $agencies = Module1Agency::all();
        }

        return view('Module1.admin.viewUsersProfilePage', compact('users', 'agencies'));
    }

    /**
     * Show edit form for a public user - Module1
     */
    public function editUser($id)
    {
        $user = Module1PublicUsers::findOrFail($id);
        return view('Module1.admin.editUserPage', compact('user'));
    }

    /**
     * Update a public user - Module1
     */
    public function updateUser(Request $request, $id)
    {
        $user = Module1PublicUsers::findOrFail($id);

        $validated = $request->validate([
            'UserName' => 'required|string|max:50',
            'UserEmail' => 'required|email|max:50|unique:public_users,UserEmail,' . $id . ',UserID',
            'UserPhoneNum' => 'nullable|string|max:15',
        ]);

        $user->updateProfile($validated);

        return redirect()->route('admin.users')
            ->with('success', 'User updated successfully!');
    }

    /**
     * Show edit form for an agency - Module1
     */
    public function editAgency($id)
    {
        $agency = Module1Agency::findOrFail($id);
        return view('Module1.admin.editAgencyPage', compact('agency'));
    }

    /**
     * Update an agency - Module1
     */
    public function updateAgency(Request $request, $id)
    {
        $agency = Module1Agency::findOrFail($id);

        $validated = $request->validate([
            'AgencyName' => 'required|string|max:50',
            'AgencyUserName' => 'required|string|max:50|unique:agencies,AgencyUserName,' . $id . ',AgencyID',
            'AgencyEmail' => 'required|email|max:50|unique:agencies,AgencyEmail,' . $id . ',AgencyID',
            'AgencyPhoneNum' => 'nullable|string|max:15',
        ]);

        $agency->updateProfile($validated);

        return redirect()->route('admin.users')
            ->with('success', 'Agency updated successfully!');
    }

    /**
     * Show agency registration form - Module1
     */
    public function showAgencyRegistrationForm()
    {
        return view('Module1.admin.registerNewAgencyPage');
    }

    /**
     * Store a new agency - Module1
     */
    public function storeAgency(Request $request)
    {
        $validated = $request->validate([
            'AgencyName' => 'required|string|max:50',
            'AgencyEmail' => 'required|email|max:50|unique:agencies,AgencyEmail',
            'AgencyUserName' => 'required|string|max:50|unique:agencies,AgencyUserName',
            'AgencyPassword' => 'required|string|min:6|confirmed',
        ]);

        // Hash the password before storing
        $validated['AgencyPassword'] = Hash::make($validated['AgencyPassword']);

        Module1Agency::create([
            'AgencyName' => $validated['AgencyName'],
            'AgencyEmail' => $validated['AgencyEmail'],
            'AgencyUserName' => $validated['AgencyUserName'],
            'AgencyPassword' => $validated['AgencyPassword'],
            'AgencyPhoneNum' => '',
            'AgencyType' => 'Default',
        ]);

        return redirect()->route('admin.agency.register')
            ->with('success', 'Agency registered successfully!');
    }

    /**
     * Delete a user - Module1
     */
    public function deleteUser($id)
    {
        $user = Module1PublicUsers::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users')
            ->with('success', 'User deleted successfully!');
    }

    /**
     * Delete an agency - Module1
     */
    public function deleteAgency($id)
    {
        $agency = Module1Agency::findOrFail($id);
        $agency->delete();

        return redirect()->route('admin.users')
            ->with('success', 'Agency deleted successfully!');
    }

    /**
     * Show all inquiries for admin review - Module1
     */
    public function showInquiries(Request $request)
    {
        $query = \App\Models\Inquiry::query();

        // Handle search functionality
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where('InquiryTitle', 'like', "%{$searchTerm}%")
                ->orWhere('InquirySource', 'like', "%{$searchTerm}%")
                ->orWhere('InquiryID', 'like', "%{$searchTerm}%");
        }

        // Handle status filter
        if ($request->has('status') && !empty($request->status)) {
            $query->where('InquiryStatus', $request->status);
        }

        // Sort inquiries: Pending first, then others by date
        $inquiries = $query
            ->orderByRaw("CASE WHEN InquiryStatus = 'Pending' THEN 0 ELSE 1 END")
            ->orderBy('InquirySendDate', 'desc')
            ->get();

        return view('admin.reviewInquiries', compact('inquiries'));
    }

    /**
     * Show inquiry details for admin review - Module1
     */
    public function showInquiryDetails($id)
    {
        $inquiry = \App\Models\Inquiry::findOrFail($id);
        return view('admin.inquiryDetails', compact('inquiry'));
    }

    /**
     * Update inquiry status - Module1
     */
    public function updateInquiryStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Pending,Under Investigation,Verified as True,Identified as Fake,Rejected',
            'verification_description' => 'nullable|string'
        ]);

        $inquiry = \App\Models\Inquiry::findOrFail($id);
        $inquiry->InquiryStatus = $request->status;
        if ($request->verification_description) {
            $inquiry->VerificationDescription = $request->verification_description;
        }
        $inquiry->save();

        return redirect()->route('admin.inquiries')->with('success', 'Inquiry status updated successfully!');
    }

    /**
     * Show assign inquiry page - Module1
     */
    public function showAssignInquiry()
    {
        // BUG-M2-003 FIX: Added orderBy to display newest inquiries first
        $inquiries = \App\Models\Inquiry::with(['agency', 'user'])
            ->orderBy('InquirySendDate', 'desc')
            ->get();
        $agencies = Module1Agency::all();
        return view('admin.assignInquiry', compact('inquiries', 'agencies'));
    }

    /**
     * Assign inquiries to agencies - Module1
     */
    public function assignInquiries(Request $request)
    {
        $request->validate([
            'inquiry_ids' => 'required|array',
            'agency_id' => 'required|exists:agencies,AgencyID'
        ]);

        \App\Models\Inquiry::whereIn('InquiryID', $request->inquiry_ids)
            ->update(['AgencyID' => $request->agency_id]);

        return redirect()->route('admin.assign.inquiry')
            ->with('success', 'Inquiries assigned successfully!');
    }

    /**
     * Assign inquiries with notes - Module1
     */
    public function assignInquiriesWithNotes(Request $request)
    {
        $request->validate([
            'inquiry_ids' => 'required|array',
            'agency_id' => 'required|exists:agencies,AgencyID',
            'notes' => 'nullable|string'
        ]);

        foreach ($request->inquiry_ids as $inquiryId) {
            $inquiry = \App\Models\Inquiry::find($inquiryId);
            if ($inquiry) {
                $inquiry->AgencyID = $request->agency_id;
                if ($request->notes) {
                    $inquiry->AdminNotes = $request->notes;
                }
                $inquiry->save();
            }
        }

        return redirect()->route('admin.assign.inquiry')
            ->with('success', 'Inquiries assigned with notes successfully!');
    }

    /**
     * Show reports page - Module1
     */
    public function showReports()
    {
        $agencies = Module1Agency::select(['AgencyID', 'AgencyName'])->get();
        return view('admin.generateReportPage', compact('agencies'));
    }

    /**
     * Generate reports - Module1
     */
    public function generateReports(Request $request)
    {
        // Debug: Log that the method is being called
        Log::info('generateReports method called', ['request_data' => $request->all()]);

        // Simple test - just return a basic CSV to test if the route works
        if ($request->has('test_mode')) {
            $csv = "Test Report\nGenerated at: " . now() . "\nThis is a test";
            return response($csv, 200)
                ->header('Content-Type', 'text/csv')
                ->header('Content-Disposition', 'attachment; filename="test_report.csv"');
        }

        $request->validate([
            'report_type' => 'required|in:summary,detailed,statistics',
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from',
            'format' => 'required|in:pdf,excel',
            'report_category' => 'required|in:users,inquiries,assignments',
            // Additional validation for user reports
            'user_type' => 'nullable|in:public,agency',
            // Additional validation for inquiry reports
            'status' => 'nullable|in:Pending,Under Investigation,Verified as True,Identified as Fake,Rejected',
            'review_status' => 'nullable|in:reviewed,not_reviewed,pending_review,rejected',
            'include_charts' => 'nullable|in:yes,no',
            // Additional validation for assignment reports
            'agency_id' => 'nullable|exists:agencies,AgencyID'
        ]);

        try {
            if ($request->report_category === 'users') {
                return $this->generateUserReports($request);
            } elseif ($request->report_category === 'assignments') {
                return $this->generateAssignmentReports($request);
            } else {
                return $this->generateInquiryReports($request);
            }
        } catch (\Exception $e) {
            Log::error('Error in generateReports: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return Redirect::back()->with('error', 'Failed to generate report: ' . $e->getMessage());
        }
    }

    /**
     * Generate User Reports - Module1
     */
    private function generateUserReports(Request $request)
    {
        // Build the query based on filters using Module1 models
        $publicUsersQuery = Module1PublicUsers::query();
        $agenciesQuery = Module1Agency::query();

        // Apply date filters
        $publicUsersQuery->whereBetween('created_at', [$request->date_from, $request->date_to]);
        $agenciesQuery->whereBetween('created_at', [$request->date_from, $request->date_to]);

        // Apply user type filter
        if ($request->user_type === 'public') {
            $agenciesQuery = null;
        } elseif ($request->user_type === 'agency') {
            $publicUsersQuery = null;
        }

        // Get the data
        $publicUsers = $publicUsersQuery ? $publicUsersQuery->get() : collect([]);
        $agencies = $agenciesQuery ? $agenciesQuery->get() : collect([]);

        // Prepare report data
        $reportData = [
            'report_type' => $request->report_type,
            'date_from' => $request->date_from,
            'date_to' => $request->date_to,
            'user_type' => $request->user_type,
            'public_users' => $publicUsers,
            'agencies' => $agencies,
            'total_public_users' => $publicUsers->count(),
            'total_agencies' => $agencies->count(),
            'total_users' => $publicUsers->count() + $agencies->count(),
            'generated_at' => now(),
            'generated_by' => session('admin_name', 'Admin')
        ];

        // Generate report based on format
        if ($request->format === 'pdf') {
            return $this->generatePDFReport($reportData);
        } else {
            return $this->generateExcelReport($reportData);
        }
    }

    /**
     * Generate Inquiry Reports - Module1
     */
    private function generateInquiryReports(Request $request)
    {
        // Build the query based on filters
        $inquiriesQuery = Inquiry::query();

        // Apply date filters - handle NULL dates properly
        if ($request->date_from && $request->date_to) {
            $inquiriesQuery->where(function($query) use ($request) {
                $query->whereBetween('created_at', [$request->date_from, $request->date_to])
                      ->orWhereNull('created_at'); // Include inquiries with NULL created_at
            });
        }

        // Apply status filter
        if ($request->status) {
            $inquiriesQuery->where('InquiryStatus', $request->status);
        }

        // Apply review status filter (based on processing status only)
        if ($request->review_status) {
            switch ($request->review_status) {
                case 'reviewed':
                    // Inquiries that have been processed for truth/falsehood (verified or identified as fake only)
                    $inquiriesQuery->whereIn('InquiryStatus', ['Verified as True', 'Identified as Fake']);
                    break;
                case 'not_reviewed':
                    // Inquiries that are still pending
                    $inquiriesQuery->where('InquiryStatus', 'Pending');
                    break;
                case 'pending_review':
                    // Inquiries that are under investigation
                    $inquiriesQuery->where('InquiryStatus', 'Under Investigation');
                    break;
                case 'rejected':
                    // Inquiries that were rejected (declined due to lack of jurisdiction)
                    $inquiriesQuery->where('InquiryStatus', 'Rejected');
                    break;
            }
        }

        // Get the inquiries with relationships
        $inquiries = $inquiriesQuery->with(['user'])->get();

        // Calculate submission and review statistics
        $totalInquiries = $inquiries->count();
        $reviewedInquiries = $inquiries->filter(function($inquiry) {
            return in_array($inquiry->InquiryStatus, ['Verified as True', 'Identified as Fake']);
        })->count();
        $notReviewedInquiries = $inquiries->filter(function($inquiry) {
            return $inquiry->InquiryStatus === 'Pending';
        })->count();
        $pendingReviewInquiries = $inquiries->filter(function($inquiry) {
            return $inquiry->InquiryStatus === 'Under Investigation';
        })->count();
        $rejectedInquiries = $inquiries->filter(function($inquiry) {
            return $inquiry->InquiryStatus === 'Rejected';
        })->count();

        // Get status counts for summary
        $statusCounts = [
            'Pending' => $inquiries->where('InquiryStatus', 'Pending')->count(),
            'Under Investigation' => $inquiries->where('InquiryStatus', 'Under Investigation')->count(),
            'Verified as True' => $inquiries->where('InquiryStatus', 'Verified as True')->count(),
            'Identified as Fake' => $inquiries->where('InquiryStatus', 'Identified as Fake')->count(),
            'Rejected' => $inquiries->where('InquiryStatus', 'Rejected')->count(),
        ];

        // Calculate review statistics
        $reviewStats = [
            'total_submitted' => $totalInquiries,
            'reviewed' => $reviewedInquiries,
            'not_reviewed' => $notReviewedInquiries,
            'pending_review' => $pendingReviewInquiries,
            'rejected' => $rejectedInquiries,
            'review_percentage' => $totalInquiries > 0 ? round(($reviewedInquiries / $totalInquiries) * 100, 2) : 0
        ];

        // Prepare report data
        $reportData = [
            'report_type' => $request->report_type,
            'report_category' => 'inquiries',
            'date_from' => $request->date_from,
            'date_to' => $request->date_to,
            'status_filter' => $request->status,
            'review_status_filter' => $request->review_status,
            'include_charts' => $request->include_charts ?? 'yes',
            'inquiries' => $inquiries,
            'total_inquiries' => $totalInquiries,
            'status_counts' => $statusCounts,
            'review_stats' => $reviewStats,
            'generated_at' => now(),
            'generated_by' => session('admin_name', 'Admin')
        ];

        // Generate report based on format
        if ($request->format === 'pdf') {
            return $this->generateInquiryPDFReport($reportData);
        } else {
            return $this->generateInquiryExcelReport($reportData);
        }
    }

    /**
     * Generate PDF Report - Module1
     */
    private function generatePDFReport($data)
    {
        try {
            Log::info('Attempting to generate PDF report', ['data_keys' => array_keys($data)]);

            // Check if PDF view exists
            if (!view()->exists('admin.reports.pdf')) {
                throw new \Exception('PDF template not found: admin.reports.pdf');
            }

            $pdf = Pdf::loadView('admin.reports.pdf', $data);
            $filename = 'users_report_' . $data['date_from'] . '_to_' . $data['date_to'] . '.pdf';

            Log::info('PDF generated successfully', ['filename' => $filename]);

            return $pdf->download($filename);
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('PDF generation failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'data' => $data
            ]);

            // Return back with error message instead of JSON
            return Redirect::back()->with('error', 'PDF generation failed: ' . $e->getMessage());
        }
    }

    /**
     * Generate Excel Report - Module1
     */
    private function generateExcelReport($data)
    {
        try {
            Log::info('Attempting to generate Excel report', ['data_keys' => array_keys($data)]);

            // Create CSV content directly with BOM for better Excel compatibility
            $csv = "\xEF\xBB\xBF"; // UTF-8 BOM
            $csv .= "Users Report\n";
            $csv .= "Generated on: " . $data['generated_at']->format('F j, Y g:i A') . "\n";
            $csv .= "Date Range: " . $data['date_from'] . " to " . $data['date_to'] . "\n";
            $csv .= "Report Type: " . ucfirst($data['report_type']) . "\n";
            $csv .= "\n";

            // Add summary
            $csv .= "SUMMARY\n";
            $csv .= "Total Public Users," . $data['total_public_users'] . "\n";
            $csv .= "Total Agencies," . $data['total_agencies'] . "\n";
            $csv .= "Total Users," . $data['total_users'] . "\n";
            $csv .= "\n";

            if ($data['report_type'] === 'detailed') {
                // Public Users section
                if ($data['public_users']->count() > 0) {
                    $csv .= "PUBLIC USERS\n";
                    $csv .= "ID,Username,Email,Phone,Created Date\n";

                    foreach ($data['public_users'] as $user) {
                        $csv .= $user->UserID . ",";
                        $csv .= '"' . str_replace('"', '""', $user->UserName) . '",';
                        $csv .= '"' . str_replace('"', '""', $user->UserEmail) . '",';
                        $csv .= '"' . str_replace('"', '""', ($user->UserPhoneNum ?? 'N/A')) . '",';
                        // Ensure proper date formatting and handle null values - force as text
                        if ($user->created_at && !is_null($user->created_at)) {
                            try {
                                $createdDate = $user->created_at->format('n/j/Y g:i A');
                            } catch (\Exception $e) {
                                $createdDate = 'Invalid Date';
                            }
                        } else {
                            $createdDate = 'N/A';
                        }
                        $csv .= '"' . $createdDate . '"' . "\n";
                    }
                    $csv .= "\n";
                }

                // Agencies section
                if ($data['agencies']->count() > 0) {
                    $csv .= "AGENCIES\n";
                    $csv .= "ID,Agency Name,Username,Email,Phone,Type,Created Date\n";

                    foreach ($data['agencies'] as $agency) {
                        $csv .= $agency->AgencyID . ",";
                        $csv .= '"' . str_replace('"', '""', $agency->AgencyName) . '",';
                        $csv .= '"' . str_replace('"', '""', $agency->AgencyUserName) . '",';
                        $csv .= '"' . str_replace('"', '""', $agency->AgencyEmail) . '",';
                        // Format phone number properly - handle very long numbers
                        $phoneNum = $agency->AgencyPhoneNum ?? 'N/A';
                        // Prevent Excel from converting long numbers to scientific notation
                        if (strlen($phoneNum) > 10 && is_numeric($phoneNum)) {
                            $phoneNum = $phoneNum . " "; // Add space to force text treatment
                        }
                        $csv .= '"' . str_replace('"', '""', $phoneNum) . '",';
                        $csv .= '"' . str_replace('"', '""', $agency->AgencyType) . '",';
                        // Ensure proper date formatting and handle null values - force as text
                        if ($agency->created_at && !is_null($agency->created_at)) {
                            try {
                                // Use Excel-friendly format
                                $createdDate = $agency->created_at->format('n/j/Y g:i A');
                            } catch (\Exception $e) {
                                $createdDate = 'Invalid Date';
                            }
                        } else {
                            $createdDate = 'N/A';
                        }
                        $csv .= '"' . $createdDate . '"' . "\n";
                    }
                }
            }

            $filename = 'users_report_' . $data['date_from'] . '_to_' . $data['date_to'] . '.csv';

            Log::info('Excel/CSV generated successfully', ['filename' => $filename]);

            return response($csv, 200)
                ->header('Content-Type', 'application/vnd.ms-excel; charset=UTF-8')
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
                ->header('Content-Transfer-Encoding', 'binary');

        } catch (\Exception $e) {
            Log::error('Excel generation failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'data' => $data
            ]);

            return Redirect::back()->with('error', 'Excel generation failed: ' . $e->getMessage());
        }
    }

    /**
     * Generate Inquiry PDF Report - Module1
     */
    private function generateInquiryPDFReport($data)
    {
        try {
            Log::info('Attempting to generate Inquiry PDF report', ['data_keys' => array_keys($data)]);

            // Check if PDF view exists
            if (!view()->exists('admin.reports.inquiry_pdf')) {
                throw new \Exception('PDF template not found: admin.reports.inquiry_pdf');
            }

            $pdf = Pdf::loadView('admin.reports.inquiry_pdf', $data);
            $filename = 'inquiry_report_' . $data['date_from'] . '_to_' . $data['date_to'] . '.pdf';

            Log::info('Inquiry PDF generated successfully', ['filename' => $filename]);

            return $pdf->download($filename);
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Inquiry PDF generation failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'data' => $data
            ]);

            // Return back with error message
            return Redirect::back()->with('error', 'PDF generation failed: ' . $e->getMessage());
        }
    }

    /**
     * Generate Inquiry Excel Report - Module1
     */
    private function generateInquiryExcelReport($data)
    {
        try {
            Log::info('Attempting to generate Inquiry Excel report', ['data_keys' => array_keys($data)]);

            // Create CSV content for inquiry reports
            $csv = "Inquiry Report\n";
            $csv .= "Generated on: " . $data['generated_at']->format('F j, Y g:i A') . "\n";
            $csv .= "Date Range: " . $data['date_from'] . " to " . $data['date_to'] . "\n";
            $csv .= "Report Type: " . ucfirst($data['report_type']) . "\n";

            // Add filters
            if ($data['status_filter']) {
                $csv .= "Status Filter: " . ucfirst($data['status_filter']) . "\n";
            }
            if (isset($data['review_status_filter']) && $data['review_status_filter']) {
                $csv .= "Review Status Filter: " . ucfirst(str_replace('_', ' ', $data['review_status_filter'])) . "\n";
            }
            $csv .= "Include Charts: " . ($data['include_charts'] ?? 'yes') . "\n";
            $csv .= "\n";

            // Add submission and review statistics
            if (isset($data['review_stats'])) {
                $csv .= "SUBMISSION & REVIEW STATISTICS\n";
                $csv .= "Metric,Count,Percentage\n";
                $csv .= "Total Submitted Inquiries," . $data['review_stats']['total_submitted'] . ",100%\n";
                $csv .= "Reviewed Inquiries," . $data['review_stats']['reviewed'] . "," .
                        ($data['review_stats']['total_submitted'] > 0 ?
                         round(($data['review_stats']['reviewed'] / $data['review_stats']['total_submitted']) * 100, 2) : 0) . "%\n";
                $csv .= "Not Reviewed Inquiries," . $data['review_stats']['not_reviewed'] . "," .
                        ($data['review_stats']['total_submitted'] > 0 ?
                         round(($data['review_stats']['not_reviewed'] / $data['review_stats']['total_submitted']) * 100, 2) : 0) . "%\n";
                $csv .= "Pending Review," . $data['review_stats']['pending_review'] . "," .
                        ($data['review_stats']['total_submitted'] > 0 ?
                         round(($data['review_stats']['pending_review'] / $data['review_stats']['total_submitted']) * 100, 2) : 0) . "%\n";
                $csv .= "Review Completion Rate," . $data['review_stats']['review_percentage'] . "%,N/A\n";
                $csv .= "\n";
            }

            // Add processing status summary
            $csv .= "PROCESSING STATUS SUMMARY\n";
            $csv .= "Status,Count,Percentage\n";
            $totalInquiries = $data['total_inquiries'] > 0 ? $data['total_inquiries'] : 1;
            foreach ($data['status_counts'] as $status => $count) {
                $percentage = round(($count / $totalInquiries) * 100, 2);
                $csv .= ucfirst(str_replace('-', ' ', $status)) . "," . $count . "," . $percentage . "%\n";
            }
            $csv .= "\n";

            if ($data['report_type'] === 'detailed') {
                // Detailed inquiries section
                if ($data['inquiries']->count() > 0) {
                    $csv .= "DETAILED INQUIRIES DATA\n";
                    $csv .= "ID,Title,Source,Submitter,Submission Date,Status,Review Status\n";

                    foreach ($data['inquiries'] as $inquiry) {
                        // Determine review status based on actual inquiry status
                        $reviewStatus = 'Not Reviewed';
                        if (in_array($inquiry->InquiryStatus, ['Verified as True', 'Identified as Fake'])) {
                            $reviewStatus = 'Reviewed';
                        } elseif ($inquiry->InquiryStatus === 'Under Investigation') {
                            $reviewStatus = 'Pending Review';
                        } elseif ($inquiry->InquiryStatus === 'Rejected') {
                            $reviewStatus = 'Rejected';
                        }

                        $csv .= $inquiry->InquiryID . ",";
                        $csv .= '"' . str_replace('"', '""', $inquiry->InquiryTitle) . '",';
                        $csv .= '"' . ($inquiry->InquirySource ?? 'N/A') . '",';
                        $csv .= '"' . ($inquiry->user ? $inquiry->user->UserName : 'N/A') . '",';
                        $csv .= '"' . ($inquiry->created_at ? $inquiry->created_at->format('Y-m-d H:i') : 'N/A') . '",';
                        $csv .= '"' . ($inquiry->InquiryStatus ?? 'N/A') . '",';
                        $csv .= '"' . $reviewStatus . '"' . "\n";
                    }
                }
            }

            // Add chart data note
            if (($data['include_charts'] ?? 'yes') === 'yes') {
                $csv .= "\nCHART DATA NOTE\n";
                $csv .= "This report includes data suitable for creating the following charts:\n";
                $csv .= "1. Submission & Review Statistics (above)\n";
                $csv .= "2. Processing Status Distribution (above)\n";
                $csv .= "3. Review Status Pie Chart (Review Stats section)\n";
                $csv .= "Use the data above to create visual charts in your preferred tool.\n";
            }

            $filename = 'inquiry_report_' . $data['date_from'] . '_to_' . $data['date_to'] . '.csv';

            Log::info('Inquiry Excel/CSV generated successfully', ['filename' => $filename]);

            return response($csv, 200)
                ->header('Content-Type', 'text/csv')
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');

        } catch (\Exception $e) {
            Log::error('Inquiry Excel generation failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'data' => $data
            ]);

            return Redirect::back()->with('error', 'Excel generation failed: ' . $e->getMessage());
        }
    }

    /**
     * Generate Assignment Reports - Module1
     */
    private function generateAssignmentReports(Request $request)
    {
        // Build the query for assigned inquiries
        $assignedInquiriesQuery = Inquiry::whereNotNull('AgencyID');

        // Apply assignment date filters
        if ($request->date_from && $request->date_to) {
            $assignedInquiriesQuery->where(function($query) use ($request) {
                $query->whereBetween('assignment_date', [$request->date_from, $request->date_to])
                      ->orWhereNull('assignment_date'); // Include assignments with NULL assignment_date
            });
        }

        // Apply agency filter
        if ($request->agency_id) {
            $assignedInquiriesQuery->where('AgencyID', $request->agency_id);
        }

        // Apply status filter
        if ($request->status) {
            $assignedInquiriesQuery->where('InquiryStatus', $request->status);
        }

        // Get the assigned inquiries with relationships
        $assignedInquiries = $assignedInquiriesQuery->with(['user', 'agency'])->get();

        // Calculate assignment statistics
        $totalAssignments = $assignedInquiries->count();
        $agencyStats = $assignedInquiries->groupBy('AgencyID')->map(function ($group) {
            return [
                'agency' => $group->first()->agency,
                'count' => $group->count(),
                'pending' => $group->where('InquiryStatus', 'Pending')->count(),
                'under_investigation' => $group->where('InquiryStatus', 'Under Investigation')->count(),
                'verified_true' => $group->where('InquiryStatus', 'Verified as True')->count(),
                'identified_fake' => $group->where('InquiryStatus', 'Identified as Fake')->count(),
                'rejected' => $group->where('InquiryStatus', 'Rejected')->count(),
            ];
        });

        // Calculate status distribution
        $statusStats = [
            'pending' => $assignedInquiries->where('InquiryStatus', 'Pending')->count(),
            'under_investigation' => $assignedInquiries->where('InquiryStatus', 'Under Investigation')->count(),
            'verified_true' => $assignedInquiries->where('InquiryStatus', 'Verified as True')->count(),
            'identified_fake' => $assignedInquiries->where('InquiryStatus', 'Identified as Fake')->count(),
            'rejected' => $assignedInquiries->where('InquiryStatus', 'Rejected')->count(),
        ];

        // Calculate assignment trends (group by date)
        $assignmentTrends = $assignedInquiries->groupBy(function($inquiry) {
            return $inquiry->assignment_date ? $inquiry->assignment_date->format('Y-m-d') : 'Unknown';
        })->map(function($group) {
            return $group->count();
        });

        // Prepare data for the report
        $data = [
            'report_type' => $request->report_type,
            'date_from' => $request->date_from,
            'date_to' => $request->date_to,
            'agency_filter' => $request->agency_id ? \App\Models\Agency::find($request->agency_id) : null,
            'status_filter' => $request->status,
            'include_charts' => $request->include_charts ?? 'yes',
            'generated_at' => now()->format('Y-m-d H:i:s'),
            'generated_by' => session('admin_id'),

            // Assignment Statistics
            'total_assignments' => $totalAssignments,
            'agency_stats' => $agencyStats,
            'status_stats' => $statusStats,
            'assignment_trends' => $assignmentTrends,

            // Raw data for detailed reports
            'assigned_inquiries' => $assignedInquiries,
        ];

        // Generate the report based on format
        if ($request->format === 'pdf') {
            return $this->generateAssignmentPDF($data);
        } else {
            return $this->generateAssignmentExcel($data);
        }
    }

    /**
     * Generate Assignment PDF Report
     */
    private function generateAssignmentPDF($data)
    {
        try {
            // Set memory limit for large datasets
            ini_set('memory_limit', '512M');

            $pdf = Pdf::loadView('admin.reports.assignment_pdf', $data);
            $pdf->setPaper('A4', 'portrait');

            $filename = 'assignment_report_' . now()->format('Y_m_d_His') . '.pdf';

            return $pdf->download($filename);
        } catch (\Exception $e) {
            Log::error('Assignment PDF generation failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'data' => $data
            ]);

            return Redirect::back()->with('error', 'PDF generation failed: ' . $e->getMessage());
        }
    }

    /**
     * Generate Assignment Excel Report
     */
    private function generateAssignmentExcel($data)
    {
        try {
            $csv = '';

            // Header
            $csv .= "Assignment Report\n";
            $csv .= "Generated on: " . $data['generated_at'] . "\n";
            $csv .= "Report Type: " . ucfirst($data['report_type']) . "\n";

            if ($data['date_from'] && $data['date_to']) {
                $csv .= "Assignment Date Range: " . $data['date_from'] . " to " . $data['date_to'] . "\n";
            }

            if ($data['agency_filter']) {
                $csv .= "Agency Filter: " . $data['agency_filter']->AgencyName . "\n";
            }

            if ($data['status_filter']) {
                $csv .= "Status Filter: " . $data['status_filter'] . "\n";
            }

            $csv .= "\n";

            // Summary Statistics
            $csv .= "ASSIGNMENT SUMMARY\n";
            $csv .= "Total Assignments," . $data['total_assignments'] . "\n";
            $csv .= "\nSTATUS DISTRIBUTION\n";
            $csv .= "Status,Count,Percentage\n";

            foreach ($data['status_stats'] as $status => $count) {
                $percentage = $data['total_assignments'] > 0 ? round(($count / $data['total_assignments']) * 100, 1) : 0;
                $csv .= ucfirst(str_replace('_', ' ', $status)) . "," . $count . "," . $percentage . "%\n";
            }

            // Agency Statistics
            $csv .= "\nAGENCY ASSIGNMENT STATISTICS\n";
            $csv .= "Agency Name,Total Assignments,Pending,Under Investigation,Verified True,Identified Fake,Rejected\n";

            foreach ($data['agency_stats'] as $agencyId => $stats) {
                $agencyName = $stats['agency'] ? $stats['agency']->AgencyName : 'Unknown Agency';
                $csv .= '"' . str_replace('"', '""', $agencyName) . '",' .
                        $stats['count'] . ',' .
                        $stats['pending'] . ',' .
                        $stats['under_investigation'] . ',' .
                        $stats['verified_true'] . ',' .
                        $stats['identified_fake'] . ',' .
                        $stats['rejected'] . "\n";
            }

            // Detailed assignment data (for detailed reports)
            if ($data['report_type'] === 'detailed') {
                $csv .= "\nDETAILED ASSIGNMENT DATA\n";
                $csv .= "Inquiry ID,Title,Status,Agency,Assignment Date,User,Source,Description\n";

                foreach ($data['assigned_inquiries'] as $inquiry) {
                    $csv .= $inquiry->InquiryID . ',';
                    $csv .= '"' . str_replace('"', '""', $inquiry->InquiryTitle) . '",';
                    $csv .= '"' . str_replace('"', '""', $inquiry->InquiryStatus) . '",';
                    $csv .= '"' . str_replace('"', '""', ($inquiry->agency ? $inquiry->agency->AgencyName : 'N/A')) . '",';
                    $csv .= '"' . ($inquiry->assignment_date ? $inquiry->assignment_date->format('Y-m-d H:i:s') : 'N/A') . '",';
                    $csv .= '"' . str_replace('"', '""', ($inquiry->user ? $inquiry->user->UserName : 'N/A')) . '",';
                    $csv .= '"' . str_replace('"', '""', $inquiry->InquirySource) . '",';
                    $csv .= '"' . str_replace('"', '""', substr($inquiry->InquiryDescription, 0, 100)) . '..."' . "\n";
                }
            }

            $filename = 'assignment_report_' . now()->format('Y_m_d_His') . '.csv';

            return response($csv, 200)
                ->header('Content-Type', 'text/csv')
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');

        } catch (\Exception $e) {
            Log::error('Assignment Excel generation failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'data' => $data
            ]);

            return Redirect::back()->with('error', 'Excel generation failed: ' . $e->getMessage());
        }
    }

    /**
     * View a public user profile - Module1
     */
    public function viewUser($id)
    {
        $user = Module1PublicUsers::findOrFail($id);

        // Get user's inquiry history
        $inquiries = \App\Models\Inquiry::where('UserID', $id)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Get user statistics
        $stats = [
            'total_inquiries' => \App\Models\Inquiry::where('UserID', $id)->count(),
            'pending_inquiries' => \App\Models\Inquiry::where('UserID', $id)->where('InquiryStatus', 'pending')->count(),
            'completed_inquiries' => \App\Models\Inquiry::where('UserID', $id)->where('InquiryStatus', 'completed')->count(),
            'member_since' => $user->created_at->format('M Y'),
        ];

        return view('Module1.admin.viewUserDetailsPage', compact('user', 'inquiries', 'stats'));
    }

    /**
     * View a specific agency's profile details - Module1
     */
    public function viewAgency($id)
    {
        $agency = Module1Agency::findOrFail($id);

        // Get agency's assigned inquiries
        $inquiries = \App\Models\Inquiry::where('AgencyID', $id)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Get agency statistics
        $stats = [
            'total_assigned' => \App\Models\Inquiry::where('AgencyID', $id)->count(),
            'pending_inquiries' => \App\Models\Inquiry::where('AgencyID', $id)->where('InquiryStatus', 'pending')->count(),
            'completed_inquiries' => \App\Models\Inquiry::where('AgencyID', $id)->where('InquiryStatus', 'completed')->count(),
            'in_progress' => \App\Models\Inquiry::where('AgencyID', $id)->whereIn('InquiryStatus', ['assigned', 'in-progress'])->count(),
            'member_since' => $agency->created_at->format('M Y'),
        ];

        return view('Module1.admin.viewAgencyDetailsPage', compact('agency', 'inquiries', 'stats'));
    }
}
