<?php

namespace App\Http\Controllers\Module4;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Inquiry;
use App\Models\Agency;
use App\Http\Controllers\Controller;

/**
 * Module 4 — AgencyProgressController
 * Handles agency views: assigned inquiry list, details, and dashboard.
 * Status changes are delegated to StatusesController.
 * SDD-REQ-405, SDD-REQ-406, SDD-REQ-409, SDD-REQ-410, SDD-REQ-411
 */
class AgencyProgressController extends Controller
{
    /**
     * Shared helper to build statusCounts using SDD vocabulary.
     */
    private function buildStatusCounts($inquiries): array
    {
        return [
            'total'                => $inquiries->count(),
            'in_progress'          => $inquiries->where('InquiryStatus', 'In Progress')->count(),
            'pending_clarification'=> $inquiries->where('InquiryStatus', 'Pending Clarification')->count(),
            'resolved'             => $inquiries->where('InquiryStatus', 'Resolved')->count(),
            'closed'               => $inquiries->where('InquiryStatus', 'Closed')->count(),
            'rejected'             => $inquiries->where('InquiryStatus', 'Rejected')->count(),
            'assigned'             => $inquiries->where('InquiryStatus', 'Assigned')->count(),
        ];
    }

    /**
     * Shared inquiry query for this agency.
     */
    private function agencyInquiries(Agency $agency)
    {
        return Inquiry::with(['user', 'agency', 'statusLogs'])
            ->where('AgencyID', $agency->AgencyID)
            ->orderByRaw("
                CASE
                    WHEN COALESCE(InquiryPriority, 'Normal') = 'High'   THEN 3
                    WHEN COALESCE(InquiryPriority, 'Normal') = 'Medium' THEN 2
                    WHEN COALESCE(InquiryPriority, 'Normal') = 'Low' THEN 1
                    ELSE 4
                END
            ")
            ->orderByDesc('InquirySendDate')
            ->get();
    }

    /**
     * Show agency home dashboard with assigned inquiry stats (SDD-REQ-405).
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

        $inquiries    = $this->agencyInquiries($agency);
        $statusCounts = $this->buildStatusCounts($inquiries);

        return view('Module4.agency.agencyHome', compact('agency', 'statusCounts', 'inquiries'));
    }

    /**
     * Show assigned inquiries list for agency (SDD-REQ-409 ViewAssignedInquiriesPage).
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

        $inquiries    = $this->agencyInquiries($agency);
        $statusCounts = $this->buildStatusCounts($inquiries);

        return view('Module 3.Agency.ViewAndDisplayInquiry', compact('agency', 'statusCounts', 'inquiries'));
    }

    /**
     * Show inquiry details for agency (SDD-REQ-406 ViewAgencyNotesPage).
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

        $inquiry = Inquiry::with(['user', 'agency', 'statusLogs'])
            ->where('InquiryID', $id)
            ->where('AgencyID', $agency->AgencyID)
            ->first();

        if (!$inquiry) {
            return redirect()->route('agency.view.display.inquiry')
                ->with('error', 'Inquiry not found or not assigned to your agency.');
        }

        if (request()->ajax() || request()->expectsJson()) {
            return response()->json(['inquiry' => $inquiry, 'agency' => $agency]);
        }

        return view('Module 3.Agency.ViewAndDisplayInquiry', compact('inquiry', 'agency'));
    }

    /**
     * Reject an inquiry (SDD-REQ-410 UpdateInquiryStatusPage).
     * Delegates to StatusesController for the actual status change.
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

        $inquiry = Inquiry::where('InquiryID', $id)
            ->where('AgencyID', $agency->AgencyID)
            ->first();

        if (!$inquiry) {
            return response()->json(['success' => false, 'message' => 'Inquiry not found'], 404);
        }

        $request->validate([
            'reason'   => 'required|string|max:500',
            'comments' => 'required|string|max:1000',
        ]);
//          fixed(replced + with  - and added space) 
        try {
            $notes = $request->reason . ' - ' . $request->comments;
            $inquiry->changeStatus('Rejected', 'agency', $agency->AgencyID, $agency->AgencyName, $notes);
            $inquiry->StatusComments          = $notes;
            $inquiry->VerificationDescription = $notes;  // surface in all detail views
            $inquiry->save();

            return response()->json([
                'success' => true,
                'message' => 'Inquiry rejected successfully.',
            ]);
        } catch (\Exception $e) {
            Log::error('[Module4] rejectInquiry failed', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Error rejecting inquiry.'], 500);
        }
    }

    /**
     * Update inquiry status — delegates to StatusesController::agencyUpdateStatus().
     * Kept for backwards compatibility with the route added earlier today.
     */
    public function updateInquiryStatus(Request $request, $id)
    {
        return app(StatusesController::class)->agencyUpdateStatus($request, $id);
    }
}
