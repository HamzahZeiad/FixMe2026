<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\PublicUser;
use App\Models\Agency;
use App\Models\Inquiry;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class AdminController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Show all users (public users and agencies) with search functionality
     */
    public function showUsers(Request $request)
    {
        // Handle user search
        $query = PublicUser::query();
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where('UserName', 'like', "%{$searchTerm}%");
        }
        $users = $query->get();

        // Handle agency search
        $agencyQuery = Agency::query();
        if ($request->has('agency_search') && !empty($request->agency_search)) {
            $searchTerm = $request->agency_search;
            $agencyQuery->where('AgencyName', 'like', "%{$searchTerm}%")
                ->orWhere('AgencyUserName', 'like', "%{$searchTerm}%");
        }
        $agencies = $agencyQuery->get();

        return view('admin.viewUsersProfilePage', compact('users', 'agencies'));
    }

    /**
     * Show edit form for a public user
     */
    public function editUser($id)
    {
        $user = PublicUser::findOrFail($id);
        return view('admin.editUserPage', compact('user'));
    }

    /**
     * Update a public user
     */
    public function updateUser(Request $request, $id)
    {
        $user = PublicUser::findOrFail($id);

        $validated = $request->validate([
            'UserName' => 'required|string|max:50',
            'UserEmail' => 'required|email|max:50|unique:public_users,UserEmail,' . $id . ',UserID',
            'UserPhoneNum' => 'nullable|string|max:15',
        ]);

        $user->update($validated);

        return redirect()->route('admin.users')
            ->with('success', 'User updated successfully!');
    }

    /**
     * Show edit form for an agency
     */
    public function editAgency($id)
    {
        $agency = Agency::findOrFail($id);
        return view('admin.editAgencyPage', compact('agency'));
    }

    /**
     * Update an agency
     */
    public function updateAgency(Request $request, $id)
    {
        $agency = Agency::findOrFail($id);

        $validated = $request->validate([
            'AgencyName' => 'required|string|max:50',
            'AgencyUserName' => 'required|string|max:50|unique:agencies,AgencyUserName,' . $id . ',AgencyID',
            'AgencyEmail' => 'required|email|max:50|unique:agencies,AgencyEmail,' . $id . ',AgencyID',
            'AgencyPhoneNum' => 'nullable|string|max:15',
        ]);

        $agency->update($validated);

        return redirect()->route('admin.users')
            ->with('success', 'Agency updated successfully!');
    }

    /**
     * Show agency registration form
     */
    public function showAgencyRegistrationForm()
    {
        return view('admin.registerNewAgencyPage');
    }

    /**
     * Store a new agency
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

        Agency::createAgency([
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
     * Show reports page
     */
    public function showReports()
    {
        return view('admin.generateReportPage');
    }

    /**
     * Generate reports
     */
    public function generateReports(Request $request)
    {
        $request->validate([
            'report_type' => 'required|in:summary,detailed',
            'date_from' => 'required|date',
            'date_to' => 'required|date|after_or_equal:date_from',
            'user_type' => 'nullable|in:public,agency',
            'format' => 'required|in:pdf,excel'
        ]);

        // Build the query based on filters
        $publicUsersQuery = PublicUser::query();
        $agenciesQuery = Agency::query();

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
     * Generate PDF Report
     * Note: PDF generation temporarily disabled due to dependency conflicts
     */
    private function generatePDFReport($data)
    {
        // For now, return a simple response indicating PDF generation is not available
        // TODO: Fix Dompdf dependency conflicts and re-implement PDF generation
        return response()->json([
            'error' => 'PDF generation is temporarily unavailable. Please use Excel export instead.'
        ], 503);
    }

    /**
     * Generate Excel Report
     */
    private function generateExcelReport($data)
    {
        // Create CSV content directly
        $csv = "Users Report\n";
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
                    $csv .= '"' . $user->UserName . '",';
                    $csv .= '"' . $user->UserEmail . '",';
                    $csv .= '"' . ($user->UserPhoneNum ?? 'N/A') . '",';
                    $csv .= '"' . ($user->created_at ? $user->created_at->format('Y-m-d') : 'N/A') . '"' . "\n";
                }
                $csv .= "\n";
            }

            // Agencies section
            if ($data['agencies']->count() > 0) {
                $csv .= "AGENCIES\n";
                $csv .= "ID,Agency Name,Username,Email,Phone,Type,Created Date\n";

                foreach ($data['agencies'] as $agency) {
                    $csv .= $agency->AgencyID . ",";
                    $csv .= '"' . $agency->AgencyName . '",';
                    $csv .= '"' . $agency->AgencyUserName . '",';
                    $csv .= '"' . $agency->AgencyEmail . '",';
                    $csv .= '"' . ($agency->AgencyPhoneNum ?? 'N/A') . '",';
                    $csv .= '"' . $agency->AgencyType . '",';
                    $csv .= '"' . ($agency->created_at ? $agency->created_at->format('Y-m-d') : 'N/A') . '"' . "\n";
                }
            }
        }

        $filename = 'users_report_' . $data['date_from'] . '_to_' . $data['date_to'] . '.csv';

        return response($csv, 200)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    /**
     * Handle admin login (to be called from main login controller)
     */
    public function attemptLogin($loginInput, $password)
    {
        $admin = Admin::findByLogin($loginInput);

        if ($admin && $admin->checkPassword($password)) {
            // Store admin data in session
            session(['admin_id' => $admin->AdminID, 'admin_name' => $admin->AdminName]);
            return redirect()->route('admin.users');
        }

        return false;
    }

    /**
     * Show all inquiries for admin review
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
     * Show inquiry details for admin review
     */
    public function showInquiryDetails($id)
    {
        $inquiry = \App\Models\Inquiry::findOrFail($id);

        return view('admin.inquiryDetails', compact('inquiry'));
    }

    /**
     * Update inquiry status
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
}
