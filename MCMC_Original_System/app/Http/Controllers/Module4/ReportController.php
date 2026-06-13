<?php

namespace App\Http\Controllers\Module4;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use App\Models\Module1\Agency as Module1Agency;
use App\Models\Module1\PublicUsers as Module1PublicUsers;
use App\Models\Inquiry;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;

/**
 * Module 4 — Report Dashboard & Generation
 * Handles admin report views, generation, and export.
 * SDD-REQ-407, SDD-REQ-408
 */
class ReportController extends Controller
{
    /**
     * Show the report dashboard page (SDD-REQ-408 ReportDashboardPage).
     */
    public function showReports()
    {
        $agencies = Module1Agency::select(['AgencyID', 'AgencyName'])->get();
        return view('Module4.admin.generateReportPage', compact('agencies'));
    }

    /**
     * Generate and export a report (SDD-REQ-407 GenerateAgencyReportPage).
     */
    public function generateReports(Request $request)
    {
        Log::info('[Module4] generateReports called', ['request_data' => $request->all()]);

        if ($request->has('test_mode')) {
            $csv = "Test Report\nGenerated at: " . now() . "\nThis is a test";
            return response($csv, 200)
                ->header('Content-Type', 'text/csv')
                ->header('Content-Disposition', 'attachment; filename="test_report.csv"');
        }

        $request->validate([
            'report_type'     => 'required|in:summary,detailed,statistics',
            'date_from'       => 'nullable|date',
            'date_to'         => 'nullable|date|after_or_equal:date_from',
            'format'          => 'required|in:pdf,excel',
            'report_category' => 'required|in:users,inquiries,assignments',
            'user_type'       => 'nullable|in:public,agency',
            'status'          => 'nullable|in:Submitted,Under Review,Assigned,In Progress,Pending Clarification,Resolved,Closed,Rejected',
            'review_status'   => 'nullable|in:reviewed,not_reviewed,in_progress,clarification,rejected',
            'include_charts'  => 'nullable|in:yes,no',
            'agency_id'       => 'nullable|exists:agencies,AgencyID',
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
            Log::error('[Module4] Error in generateReports: ' . $e->getMessage());
            return Redirect::back()->with('error', 'Failed to generate report: ' . $e->getMessage());
        }
    }

    // ─── Private Helpers ────────────────────────────────────────────────────────

    private function generateUserReports(Request $request)
    {
        $publicUsersQuery = Module1PublicUsers::query();
        $agenciesQuery    = Module1Agency::query();

        $publicUsersQuery->whereBetween('created_at', [$request->date_from, $request->date_to]);
        $agenciesQuery->whereBetween('created_at', [$request->date_from, $request->date_to]);

        if ($request->user_type === 'public')  { $agenciesQuery    = null; }
        if ($request->user_type === 'agency')   { $publicUsersQuery = null; }

        $publicUsers = $publicUsersQuery ? $publicUsersQuery->get() : collect([]);
        $agencies    = $agenciesQuery    ? $agenciesQuery->get()    : collect([]);

        $data = [
            'report_type'        => $request->report_type,
            'date_from'          => $request->date_from,
            'date_to'            => $request->date_to,
            'user_type'          => $request->user_type,
            'public_users'       => $publicUsers,
            'agencies'           => $agencies,
            'total_public_users' => $publicUsers->count(),
            'total_agencies'     => $agencies->count(),
            'total_users'        => $publicUsers->count() + $agencies->count(),
            'generated_at'       => now(),
            'generated_by'       => session('admin_name', 'Admin'),
        ];

        return $request->format === 'pdf'
            ? $this->generateUserPDF($data)
            : $this->generateUserExcel($data);
    }

    private function generateInquiryReports(Request $request)
    {
        $query = Inquiry::query();

        if ($request->date_from && $request->date_to) {
            $query->where(function ($q) use ($request) {
                $q->whereBetween('created_at', [$request->date_from, $request->date_to])
                  ->orWhereNull('created_at');
            });
        }
        if ($request->status) {
            $query->where('InquiryStatus', $request->status);
        }
        if ($request->review_status) {
            switch ($request->review_status) {
                case 'reviewed':      $query->whereIn('InquiryStatus', ['Resolved', 'Closed']); break;
                case 'not_reviewed':  $query->whereIn('InquiryStatus', ['Submitted', 'Under Review']); break;
                case 'in_progress':   $query->where('InquiryStatus', 'In Progress'); break;
                case 'clarification': $query->where('InquiryStatus', 'Pending Clarification'); break;
                case 'rejected':      $query->where('InquiryStatus', 'Rejected'); break;
            }
        }

        $inquiries      = $query->with(['user'])->get();
        $total          = $inquiries->count();
        $statusCounts   = [
            'Submitted'            => $inquiries->where('InquiryStatus', 'Submitted')->count(),
            'Under Review'         => $inquiries->where('InquiryStatus', 'Under Review')->count(),
            'Assigned'             => $inquiries->where('InquiryStatus', 'Assigned')->count(),
            'In Progress'          => $inquiries->where('InquiryStatus', 'In Progress')->count(),
            'Pending Clarification'=> $inquiries->where('InquiryStatus', 'Pending Clarification')->count(),
            'Resolved'             => $inquiries->where('InquiryStatus', 'Resolved')->count(),
            'Closed'               => $inquiries->where('InquiryStatus', 'Closed')->count(),
            'Rejected'             => $inquiries->where('InquiryStatus', 'Rejected')->count(),
        ];
        $reviewed = $inquiries->filter(fn($i) => in_array($i->InquiryStatus, ['Resolved', 'Closed']))->count();

        $data = [
            'report_type'          => $request->report_type,
            'report_category'      => 'inquiries',
            'date_from'            => $request->date_from,
            'date_to'              => $request->date_to,
            'status_filter'        => $request->status,
            'review_status_filter' => $request->review_status,
            'include_charts'       => $request->include_charts ?? 'yes',
            'inquiries'            => $inquiries,
            'total_inquiries'      => $total,
            'status_counts'        => $statusCounts,
            'review_stats'         => [
                'total_submitted'  => $total,
                'reviewed'         => $reviewed,
                'not_reviewed'     => $statusCounts['Submitted'] + $statusCounts['Under Review'],
                'in_progress'      => $statusCounts['In Progress'],
                'clarification'    => $statusCounts['Pending Clarification'],
                'rejected'         => $statusCounts['Rejected'],
                'review_percentage'=> $total > 0 ? round(($reviewed / $total) * 100, 2) : 0,
            ],
            'generated_at'  => now(),
            'generated_by'  => session('admin_name', 'Admin'),
        ];

        return $request->format === 'pdf'
            ? $this->generateInquiryPDF($data)
            : $this->generateInquiryExcel($data);
    }

    private function generateAssignmentReports(Request $request)
    {
        $query = Inquiry::whereNotNull('AgencyID');

        if ($request->date_from && $request->date_to) {
            $query->where(function ($q) use ($request) {
                $q->whereBetween('assignment_date', [$request->date_from, $request->date_to])
                  ->orWhereNull('assignment_date');
            });
        }
        if ($request->agency_id) { $query->where('AgencyID', $request->agency_id); }
        if ($request->status)    { $query->where('InquiryStatus', $request->status); }

        $assigned = $query->with(['user', 'agency'])->get();
        $total    = $assigned->count();

        $agencyStats = $assigned->groupBy('AgencyID')->map(fn($g) => [
            'agency'               => $g->first()->agency,
            'count'                => $g->count(),
            'assigned'             => $g->where('InquiryStatus', 'Assigned')->count(),
            'in_progress'          => $g->where('InquiryStatus', 'In Progress')->count(),
            'pending_clarification'=> $g->where('InquiryStatus', 'Pending Clarification')->count(),
            'resolved'             => $g->where('InquiryStatus', 'Resolved')->count(),
            'closed'               => $g->where('InquiryStatus', 'Closed')->count(),
            'rejected'             => $g->where('InquiryStatus', 'Rejected')->count(),
        ]);

        $data = [
            'report_type'        => $request->report_type,
            'date_from'          => $request->date_from,
            'date_to'            => $request->date_to,
            'agency_filter'      => $request->agency_id ? Module1Agency::find($request->agency_id) : null,
            'status_filter'      => $request->status,
            'include_charts'     => $request->include_charts ?? 'yes',
            'generated_at'       => now()->format('Y-m-d H:i:s'),
            'generated_by'       => session('admin_id'),
            'total_assignments'  => $total,
            'agency_stats'       => $agencyStats,
            'status_stats'       => [
                'assigned'             => $assigned->where('InquiryStatus', 'Assigned')->count(),
                'in_progress'          => $assigned->where('InquiryStatus', 'In Progress')->count(),
                'pending_clarification'=> $assigned->where('InquiryStatus', 'Pending Clarification')->count(),
                'resolved'             => $assigned->where('InquiryStatus', 'Resolved')->count(),
                'closed'               => $assigned->where('InquiryStatus', 'Closed')->count(),
                'rejected'             => $assigned->where('InquiryStatus', 'Rejected')->count(),
            ],
            'assignment_trends'  => $assigned->groupBy(fn($i) => $i->assignment_date ? $i->assignment_date->format('Y-m-d') : 'Unknown')->map->count(),
            'assigned_inquiries' => $assigned,
        ];

        return $request->format === 'pdf'
            ? $this->generateAssignmentPDF($data)
            : $this->generateAssignmentExcel($data);
    }

    // PDF helpers
    private function generateUserPDF($data)
    {
        try {
            $pdf = Pdf::loadView('Module4.admin.reports.pdf', $data);
            return $pdf->download('users_report_' . $data['date_from'] . '_to_' . $data['date_to'] . '.pdf');
        } catch (\Exception $e) {
            Log::error('[Module4] User PDF failed: ' . $e->getMessage());
            return Redirect::back()->with('error', 'PDF generation failed: ' . $e->getMessage());
        }
    }

    private function generateInquiryPDF($data)
    {
        try {
            $pdf = Pdf::loadView('Module4.admin.reports.inquiry_pdf', $data);
            return $pdf->download('inquiry_report_' . $data['date_from'] . '_to_' . $data['date_to'] . '.pdf');
        } catch (\Exception $e) {
            Log::error('[Module4] Inquiry PDF failed: ' . $e->getMessage());
            return Redirect::back()->with('error', 'PDF generation failed: ' . $e->getMessage());
        }
    }

    private function generateAssignmentPDF($data)
    {
        try {
            ini_set('memory_limit', '512M');
            $pdf = Pdf::loadView('Module4.admin.reports.assignment_pdf', $data);
            $pdf->setPaper('A4', 'portrait');
            return $pdf->download('assignment_report_' . now()->format('Y_m_d_His') . '.pdf');
        } catch (\Exception $e) {
            Log::error('[Module4] Assignment PDF failed: ' . $e->getMessage());
            return Redirect::back()->with('error', 'PDF generation failed: ' . $e->getMessage());
        }
    }

    // Excel/CSV helpers (same logic as Module1, kept in Module4)
    private function generateUserExcel($data)
    {
        $csv  = "\xEF\xBB\xBF";
        $csv .= "Users Report\n";
        $csv .= "Generated on: " . $data['generated_at']->format('F j, Y g:i A') . "\n";
        $csv .= "Date Range: " . $data['date_from'] . " to " . $data['date_to'] . "\n\n";
        $csv .= "SUMMARY\nTotal Public Users," . $data['total_public_users'] . "\nTotal Agencies," . $data['total_agencies'] . "\nTotal Users," . $data['total_users'] . "\n\n";

        $filename = 'users_report_' . $data['date_from'] . '_to_' . $data['date_to'] . '.csv';
        return response($csv, 200)
            ->header('Content-Type', 'application/vnd.ms-excel; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->header('Content-Transfer-Encoding', 'binary');
    }

    private function generateInquiryExcel($data)
    {
        $csv  = "Inquiry Report\n";
        $csv .= "Generated on: " . $data['generated_at']->format('F j, Y g:i A') . "\n\n";
        $csv .= "PROCESSING STATUS SUMMARY\nStatus,Count\n";
        foreach ($data['status_counts'] as $status => $count) {
            $csv .= ucfirst($status) . "," . $count . "\n";
        }
        $filename = 'inquiry_report_' . $data['date_from'] . '_to_' . $data['date_to'] . '.csv';
        return response($csv, 200)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    private function generateAssignmentExcel($data)
    {
        $csv  = "Assignment Report\nGenerated on: " . $data['generated_at'] . "\n\n";
        $csv .= "Total Assignments," . $data['total_assignments'] . "\n";
        $filename = 'assignment_report_' . now()->format('Y_m_d_His') . '.csv';
        return response($csv, 200)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
}
