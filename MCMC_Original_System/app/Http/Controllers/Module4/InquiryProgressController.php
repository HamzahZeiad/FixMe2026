<?php

namespace App\Http\Controllers\Module4;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Request as RequestFacade;
use App\Models\Inquiry;
use App\Http\Controllers\Controller;

/**
 * Module 4 — Inquiry Progress Tracking
 * Handles public user views for tracking inquiry status and progress.
 * SDD-REQ-401, SDD-REQ-402, SDD-REQ-403
 */
class InquiryProgressController extends Controller
{
    /**
     * Show the public user's inquiry list with status (SDD-REQ-402 InquiryDashboardPage).
     */
    public function index(): View|RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to view your inquiries.');
        }

        if (URL::previous() !== RequestFacade::url()) {
            Session::put('previous_url', URL::previous());
        }

        $userInquiries = Inquiry::where('UserID', Auth::id())
            ->orderBy('InquirySendDate', 'desc')
            ->get();

        $otherInquiries = Inquiry::where('UserID', '!=', Auth::id())
            ->orWhereNull('UserID')
            ->orderBy('InquirySendDate', 'desc')
            ->limit(10)
            ->get();

        return view('Module4.publicUser.inquiries', compact('userInquiries', 'otherInquiries'));
    }

    /**
     * Show a single inquiry status detail page (SDD-REQ-401 ViewInquiryStatusPage).
     */
    public function show($id): View|RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to view inquiry details.');
        }

        if (URL::previous() !== RequestFacade::url()) {
            Session::put('previous_url', URL::previous());
        }

        $inquiry = Inquiry::with(['agency', 'statusLogs'])
            ->where(function ($query) {
                $query->where('UserID', Auth::id())
                    ->orWhereNull('UserID');
            })->findOrFail($id);

        return view('Module4.publicUser.inquiryDetails', compact('inquiry'));
    }

    /**
     * Store a new inquiry submitted by public user.
     * (Submission is Module 2, but status tracking starts here)
     */
    public function store(Request $request): RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to submit an inquiry.');
        }

        try {
            $request->validate([
                'InquiryTitle'       => 'required|string|max:50',
                'InquirySource'      => 'required|string|max:100',
                'InquiryDescription' => 'required|string|max:255',
                'InquiryEvidence'    => 'required|file|mimes:pdf,png,jpg,jpeg|max:2048',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }

        try {
            $evidencePath = $request->file('InquiryEvidence')->store('evidence', 'public');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'File upload failed. Please try again.');
        }

        try {
            Inquiry::create([
                'InquiryTitle'           => $request->InquiryTitle,
                'InquirySource'          => $request->InquirySource,
                'InquiryDescription'     => $request->InquiryDescription,
                'InquiryEvidence'        => $evidencePath,
                'InquiryStatus'          => 'Submitted',
                'VerificationDescription'=> $request->VerificationDescription ?? null,
                'InquirySendDate'        => now(),
                'UserID'                 => Auth::id() ?? null,
            ]);

            return redirect()->route('inquiries.index')->with('success', 'Inquiry submitted successfully!');
        } catch (\Exception $e) {
            Log::error('Inquiry creation failed', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to submit inquiry. Please try again.');
        }
    }
}
