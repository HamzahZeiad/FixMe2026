<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agency;
use App\Models\Inquiry;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class AgencyController extends Controller
{

    /**
     * Show agency home dashboard
     */
    public function showHome()
    {
        if (!session('agency_id')) {
            return redirect()->route('login');
        }

        $agency = Agency::find(session('agency_id'));
        if (!$agency) {
            return redirect()->route('login');
        }

        // Get inquiry status counts for the agency
        $statusCounts = [
            'total' => Inquiry::where('AgencyID', $agency->AgencyID)->count(),
            'under_investigation' => Inquiry::where('AgencyID', $agency->AgencyID)
                                          ->where('InquiryStatus', 'Under Investigation')->count(),
            'verified_true' => Inquiry::where('AgencyID', $agency->AgencyID)
                                    ->where('InquiryStatus', 'Verified True')->count(),
            'identified_fake' => Inquiry::where('AgencyID', $agency->AgencyID)
                                       ->where('InquiryStatus', 'Identified Fake')->count(),
        ];

        return view('agency.agencyHome', compact('agency', 'statusCounts'));
    }

    /**
     * Handle agency login (to be called from main login controller)
     */
    public function attemptLogin($loginInput, $password)
    {
        $agency = Agency::findByLogin($loginInput);

        if ($agency && $agency->checkPassword($password)) {
            // Check if agency has phone number
            if (empty($agency->AgencyPhoneNum) || is_null($agency->AgencyPhoneNum)) {
                // Store agency ID in session for phone verification
                session(['phone_verification_agency_id' => $agency->AgencyID]);

                return redirect()->route('password.recovery')
                    ->with('phone_required', 'Please add your phone number and reset your password to complete account setup.');
            }

            // Store agency data in session
            session(['agency_id' => $agency->AgencyID, 'agency_name' => $agency->AgencyName]);
            return redirect()->route('agency.home');
        }

        return false;
    }

    /**
     * Update agency phone number and password
     */
    public function updatePhoneAndPassword(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Get agency ID from session
        $agencyId = session('phone_verification_agency_id');

        if (!$agencyId) {
            return redirect()->route('login')->with('error', 'Session expired. Please login again.');
        }

        $agency = Agency::find($agencyId);

        if (!$agency) {
            return redirect()->route('login')->with('error', 'Agency not found.');
        }

        // Update phone and password
        $agency->AgencyPhoneNum = $request->phone;
        $agency->AgencyPassword = Hash::make($request->password);
        $agency->save();

        // Clear the verification session
        session()->forget('phone_verification_agency_id');

        // Log the agency in
        session(['agency_id' => $agency->AgencyID, 'agency_name' => $agency->AgencyName]);

        return redirect()->route('agency.home')->with('success', 'Account setup completed successfully!');
    }

    /**
     * Show agency view and display inquiry page
     */
    public function showViewAndDisplayInquiry()
    {
        if (!session('agency_id')) {
            return redirect()->route('login');
        }

        $agency = Agency::find(session('agency_id'));
        if (!$agency) {
            return redirect()->route('login');
        }

        // Get status counts for dashboard
        $statusCounts = [
            'total' => Inquiry::where('AgencyID', $agency->AgencyID)->count(),
            'under_investigation' => Inquiry::where('AgencyID', $agency->AgencyID)->where('InquiryStatus', 'Under Investigation')->count(),
            'verified_true' => Inquiry::where('AgencyID', $agency->AgencyID)->where('InquiryStatus', 'Verified as True')->count(),
            'identified_fake' => Inquiry::where('AgencyID', $agency->AgencyID)->where('InquiryStatus', 'Identified as Fake')->count(),
        ];

        // Get inquiries with relationships, ordered by priority
        $inquiries = Inquiry::with(['user', 'agency', 'admin'])
            ->where('AgencyID', $agency->AgencyID)
            ->orderByRaw("CASE
                WHEN COALESCE(InquiryPriority, 'Normal') = 'Urgent' THEN 1
                WHEN COALESCE(InquiryPriority, 'Normal') = 'High' THEN 2
                WHEN COALESCE(InquiryPriority, 'Normal') = 'Normal' THEN 3
                ELSE 4 END")
            ->orderBy('assignment_date', 'desc')
            ->get();

        return view('Module 3.Agency.ViewAndDisplayInquiry', compact('agency', 'statusCounts', 'inquiries'));
    }

    /**
     * Show inquiry details (AJAX compatible)
     */
    public function showInquiryDetails($id)
    {
        if (!session('agency_id')) {
            return redirect()->route('login');
        }

        $agency = Agency::find(session('agency_id'));
        if (!$agency) {
            return redirect()->route('login');
        }

        // Get inquiry with relationships, ensuring it belongs to this agency
        $inquiry = Inquiry::with(['user', 'agency', 'admin'])
            ->where('InquiryID', $id)
            ->where('AgencyID', $agency->AgencyID)
            ->first();

        if (!$inquiry) {
            return redirect()->route('agency.view.display.inquiry')
                ->with('error', 'Inquiry not found or not assigned to your agency.');
        }

        // Handle AJAX requests
        if (request()->ajax() || request()->expectsJson()) {
            return response()->json([
                'inquiry' => $inquiry,
                'agency' => $agency
            ]);
        }

        return view('Module 3.Agency.ViewAndDisplayInquiry', compact('inquiry', 'agency'));
    }

    /**
     * Accept an inquiry
     */
    public function acceptInquiry(Request $request, $id)
    {
        if (!session('agency_id')) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $agency = Agency::find(session('agency_id'));
        if (!$agency) {
            return response()->json(['success' => false, 'message' => 'Agency not found'], 404);
        }

        // Find inquiry belonging to this agency
        $inquiry = Inquiry::where('InquiryID', $id)
            ->where('AgencyID', $agency->AgencyID)
            ->first();

        if (!$inquiry) {
            return response()->json(['success' => false, 'message' => 'Inquiry not found'], 404);
        }

        // Validate input
        $request->validate([
            'comments' => 'required|string|max:1000',
        ]);

        try {
            // Update inquiry status to 'Approved'
            $inquiry->InquiryStatus = 'Approved';
            $inquiry->StatusComments = $request->comments;
            $inquiry->ProcessedAt = now();
            $inquiry->save();

            return response()->json([
                'success' => true,
                'message' => 'Inquiry accepted successfully!',
                'inquiry' => $inquiry
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error accepting inquiry: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reject an inquiry
     */
    public function rejectInquiry(Request $request, $id)
    {
        if (!session('agency_id')) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $agency = Agency::find(session('agency_id'));
        if (!$agency) {
            return response()->json(['success' => false, 'message' => 'Agency not found'], 404);
        }

        // Find inquiry belonging to this agency
        $inquiry = Inquiry::where('InquiryID', $id)
            ->where('AgencyID', $agency->AgencyID)
            ->first();

        if (!$inquiry) {
            return response()->json(['success' => false, 'message' => 'Inquiry not found'], 404);
        }

        // Validate input
        $request->validate([
            'reason' => 'required|string|max:500',
            'comments' => 'required|string|max:1000',
        ]);

        try {
            // Update inquiry status to 'Rejected'
            $inquiry->InquiryStatus = 'Rejected';
            $inquiry->StatusComments = $request->reason . ' - ' . $request->comments;
            $inquiry->ProcessedAt = now();
            $inquiry->save();

            return response()->json([
                'success' => true,
                'message' => 'Inquiry rejected successfully!',
                'inquiry' => $inquiry
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error rejecting inquiry: ' . $e->getMessage()
            ], 500);
        }
    }
}
