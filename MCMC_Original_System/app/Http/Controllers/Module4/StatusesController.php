<?php

namespace App\Http\Controllers\Module4;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use App\Models\Inquiry;
use App\Models\InquiryStatusLog;
use App\Models\Agency;
use App\Models\Module1\Agency as Module1Agency;
use App\Http\Controllers\Controller;

/**
 * Module 4 — StatusesController
 *
 * Authoritative controller for all inquiry status changes.
 * Implements SDD requirements for status transitions, notes, and history.
 *
 * SDD Controllers: StatusesController
 * Methods: updateStatus(), showStatus(), statusHistory(), addStatusNote()
 *
 * Valid SDD status vocabulary:
 *   Submitted → Under Review → Assigned → In Progress
 *   → Pending Clarification → Resolved / Closed / Rejected
 */
class StatusesController extends Controller
{
    /**
     * Valid status values per SDD.
     */
    public const STATUSES = [
        'Submitted',
        'Under Review',
        'Assigned',
        'In Progress',
        'Pending Clarification',
        'Resolved',
        'Closed',
        'Rejected',
    ];

    /**
     * Statuses an Agency is allowed to set.
     */
    public const AGENCY_ALLOWED_STATUSES = [
        'In Progress',
        'Pending Clarification',
        'Resolved',
        'Closed',
        'Rejected',
    ];

    /**
     * Statuses an Admin is allowed to set.
     */
    public const ADMIN_ALLOWED_STATUSES = [
        'Under Review',
        'Assigned',
        'Rejected',
    ];

    // ─── Agency: Update Inquiry Status ──────────────────────────────────────────

    /**
     * Agency updates inquiry status (SDD UpdateInquiryStatusPage).
     * POST /agency/inquiry/{id}/status
     */
    public function agencyUpdateStatus(Request $request, $id): JsonResponse
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
            return response()->json(['success' => false, 'message' => 'Inquiry not found or not assigned to your agency'], 404);
        }

        $request->validate([
            'status' => 'required|string|in:' . implode(',', self::AGENCY_ALLOWED_STATUSES),
            'notes'  => 'nullable|string|max:2000',
        ]);

        try {
            $inquiry->changeStatus(
                $request->status,
                'agency',
                $agency->AgencyID,
                $agency->AgencyName,
                $request->notes
            );

            // Also save VerificationDescription for resolved/closed inquiries
            if (in_array($request->status, ['Resolved', 'Closed']) && $request->notes) {
                $inquiry->VerificationDescription = $request->notes;
                $inquiry->save();
            }

            return response()->json([
                'success' => true,
                'message' => 'Inquiry status updated to "' . $request->status . '".',
                'new_status' => $request->status,
            ]);
        } catch (\Exception $e) {
            Log::error('[Module4] StatusesController::agencyUpdateStatus failed', [
                'inquiry_id' => $id,
                'error' => $e->getMessage(),
            ]);
            return response()->json(['success' => false, 'message' => 'Failed to update status.'], 500);
        }
    }

    /**
     * Agency adds a note/clarification request without changing status (SDD AddDetailsPage / RequestClarificationPage).
     * POST /agency/inquiry/{id}/notes
     */
    public function addStatusNote(Request $request, $id): JsonResponse
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
            'notes'     => 'required|string|max:2000',
            'note_type' => 'required|in:clarification,details,general',
        ]);

        try {
            // If it's a clarification request, also change status
            $newStatus = $inquiry->InquiryStatus;
            if ($request->note_type === 'clarification' && $inquiry->InquiryStatus === 'In Progress') {
                $newStatus = 'Pending Clarification';
            }

            InquiryStatusLog::create([
                'InquiryID'       => $inquiry->InquiryID,
                'status'          => $newStatus,
                'previous_status' => $inquiry->InquiryStatus,
                'notes'           => '[' . strtoupper($request->note_type) . '] ' . $request->notes,
                'actor_type'      => 'agency',
                'actor_id'        => $agency->AgencyID,
                'actor_name'      => $agency->AgencyName,
            ]);

            if ($newStatus !== $inquiry->InquiryStatus) {
                $inquiry->InquiryStatus = $newStatus;
                $inquiry->save();
            }

            return response()->json([
                'success'    => true,
                'message'    => 'Note added successfully.',
                'new_status' => $newStatus,
            ]);
        } catch (\Exception $e) {
            Log::error('[Module4] StatusesController::addStatusNote failed', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Failed to add note.'], 500);
        }
    }

    /**
     * Admin updates inquiry status.
     * POST /admin/inquiry/{id}/status
     */
    public function adminUpdateStatus(Request $request, $id): JsonResponse
    {
        if (!session('admin_id')) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $inquiry = Inquiry::find($id);
        if (!$inquiry) {
            return response()->json(['success' => false, 'message' => 'Inquiry not found'], 404);
        }

        $request->validate([
            'status' => 'required|string|in:' . implode(',', self::ADMIN_ALLOWED_STATUSES),
            'notes'  => 'nullable|string|max:2000',
        ]);

        try {
            $inquiry->changeStatus(
                $request->status,
                'admin',
                session('admin_id'),
                session('admin_name', 'Administrator'),
                $request->notes
            );

            return response()->json([
                'success'    => true,
                'message'    => 'Status updated to "' . $request->status . '".',
                'new_status' => $request->status,
            ]);
        } catch (\Exception $e) {
            Log::error('[Module4] StatusesController::adminUpdateStatus failed', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Failed to update status.'], 500);
        }
    }

    /**
     * Return full status history for an inquiry (SDD statusHistory / InquiryCommunicationLogPage).
     * GET /inquiry/{id}/history
     */
    public function statusHistory($id): JsonResponse|View
    {
        $inquiry = Inquiry::with(['statusLogs', 'agency', 'user'])->find($id);
        if (!$inquiry) {
            return response()->json(['success' => false, 'message' => 'Inquiry not found'], 404);
        }

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'inquiry' => $inquiry,
                'logs'    => $inquiry->statusLogs,
            ]);
        }

        return view('Module4.publicUser.inquiryHistory', compact('inquiry'));
    }

    /**
     * Admin: Monitor agency progress dashboard (SDD MonitorAgencyProgressPage).
     * GET /admin/monitor
     */
    public function monitorAgencyProgress(): View|RedirectResponse
    {
        if (!session('admin_id')) {
            return redirect()->route('login');
        }

        $agencies = Module1Agency::withCount([
            'inquiries as total_inquiries',
            'inquiries as assigned_count'      => fn($q) => $q->where('InquiryStatus', 'Assigned'),
            'inquiries as in_progress_count'   => fn($q) => $q->where('InquiryStatus', 'In Progress'),
            'inquiries as clarification_count' => fn($q) => $q->where('InquiryStatus', 'Pending Clarification'),
            'inquiries as resolved_count'      => fn($q) => $q->where('InquiryStatus', 'Resolved'),
            'inquiries as closed_count'        => fn($q) => $q->where('InquiryStatus', 'Closed'),
            'inquiries as rejected_count'      => fn($q) => $q->where('InquiryStatus', 'Rejected'),
        ])->get();

        // Stalled inquiries: active status but not updated for 7+ days
        $stalledInquiries = Inquiry::with(['agency'])
            ->whereIn('InquiryStatus', ['In Progress', 'Pending Clarification', 'Assigned'])
            ->where('updated_at', '<', now()->subDays(7))
            ->orderBy('updated_at', 'asc')
            ->limit(50)
            ->get();

        // System-wide stats
        $stats = [
            'total'         => Inquiry::count(),
            'submitted'     => Inquiry::where('InquiryStatus', 'Submitted')->count(),
            'under_review'  => Inquiry::where('InquiryStatus', 'Under Review')->count(),
            'assigned'      => Inquiry::where('InquiryStatus', 'Assigned')->count(),
            'in_progress'   => Inquiry::where('InquiryStatus', 'In Progress')->count(),
            'clarification' => Inquiry::where('InquiryStatus', 'Pending Clarification')->count(),
            'resolved'      => Inquiry::where('InquiryStatus', 'Resolved')->count(),
            'closed'        => Inquiry::where('InquiryStatus', 'Closed')->count(),
            'rejected'      => Inquiry::where('InquiryStatus', 'Rejected')->count(),
        ];

        // Recent status activity
        $recentActivity = InquiryStatusLog::with('inquiry')
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        return view('Module4.admin.monitorAgencyProgress', compact(
            'agencies', 'stalledInquiries', 'stats', 'recentActivity'
        ));
    }
}
