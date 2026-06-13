<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request as RequestFacade;
use Illuminate\Validation\ValidationException;
use App\Models\Inquiry;

/**
 * @phpstan-ignore-file
 */

class InquiryController extends Controller
{

    public function store(Request $request): RedirectResponse
    {
        // Ensure user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to submit an inquiry.');
        }

        // Debug information
        Log::info('Inquiry form submitted', [
            'request_data' => $request->except(['_token']), // Don't log the token
            'has_csrf_token' => $request->has('_token'),
            'csrf_token_length' => $request->has('_token') ? strlen($request->input('_token')) : 0,
            'session_token_length' => session()->token() ? strlen(session()->token()) : 0,
            'has_file' => $request->hasFile('InquiryEvidence'),
            'user_id' => Auth::id(),
        ]);

        // Check CSRF token explicitly
        if (!$request->has('_token') || empty($request->input('_token'))) {
            Log::error('CSRF token missing from request');
            return Redirect::back()->with('error', 'Security token missing. Please refresh the page and try again.');
        }

        try {
            $request->validate([
                'InquiryTitle'       => 'required|string|max:50',
                'InquirySource'      => 'required|string|max:100',
                'InquiryDescription' => 'required|string|max:255',
                'InquiryEvidence'    => 'required|file|mimes:pdf,png,jpg,jpeg|max:2048',
                'priority'           => 'nullable|in:low,medium,high,normal',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed', ['errors' => $e->errors()]);
            return Redirect::back()->withErrors($e->errors())->withInput();
        }

        // Handle file upload
        try {
            $evidencePath = $request->file('InquiryEvidence')->store('evidence', 'public');
        } catch (\Exception $e) {
            Log::error('File upload failed', ['error' => $e->getMessage()]);
            return Redirect::back()->with('error', 'File upload failed. Please try again.');
        }

        try {
            Inquiry::create([
                'InquiryTitle'            => $request->InquiryTitle,
                'InquirySource'           => $request->InquirySource,
                'InquiryDescription'      => $request->InquiryDescription,
                'InquiryEvidence'         => $evidencePath,
                'InquiryStatus'           => 'Submitted',
                'InquiryPriority'         => ucfirst(strtolower($request->input('priority', 'normal'))),
                'VerificationDescription' => $request->VerificationDescription ?? null,
                'InquirySendDate'         => now(),
                'UserID'                  => Auth::id() ?? null,
            ]);

            Log::info('Inquiry created successfully');
            // Redirect to inquiries list with success message
            return redirect()->route('inquiries.index')->with('success', 'Inquiry submitted successfully!');
        } catch (\Exception $e) {
            Log::error('Inquiry creation failed', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return Redirect::back()->with('error', 'Failed to submit inquiry. Please try again. Error: ' . $e->getMessage());
        }
    }

    public function index(): View|RedirectResponse
    {
        // Ensure user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to view your inquiries.');
        }

        // Store the previous URL for back button functionality
        if (URL::previous() !== RequestFacade::url()) {
            Session::put('previous_url', URL::previous());
        }

        // Get user's inquiries
        $userInquiries = Inquiry::where('UserID', Auth::id())
            ->orderBy('InquirySendDate', 'desc')
            ->get();

        // Get other public inquiries (you may want to modify this logic based on your requirements)
        $otherInquiries = Inquiry::where('UserID', '!=', Auth::id())
            ->orWhereNull('UserID')
            ->orderBy('InquirySendDate', 'desc')
            ->limit(10) // Limit to prevent showing too many
            ->get();

        return view('publicUser.inquiries', compact('userInquiries', 'otherInquiries'));
    }

    public function show($id): View|RedirectResponse
    {
        // Ensure user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to view inquiry details.');
        }

        // Store the previous URL for back button functionality
        if (URL::previous() !== RequestFacade::url()) {
            Session::put('previous_url', URL::previous());
        }

        // Allow users to view their own inquiries or public inquiries
        // Include agency relationship for assignment information
        $inquiry = Inquiry::with('agency')
            ->where(function ($query) {
                $query->where('UserID', Auth::id())
                    ->orWhereNull('UserID');
            })->findOrFail($id);

        return view('publicUser.inquiryDetails', compact('inquiry'));
    }
}
