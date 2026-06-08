<?php

namespace App\Http\Controllers\Module2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InquiryController extends Controller
{
    /**
     * Display the submit inquiry form page
     */
    public function submitInquiryForm()
    {
        return view('Module2.publicUser.submitInquiryFormPage');
    }

    /**
     * Store a new inquiry
     */
    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'category' => 'required|string',
            'priority' => 'required|in:low,medium,high',
            'contact_preference' => 'required|in:email,phone,sms',
        ]);

        try {
            // For now, just return success - later we'll implement actual storage
            return response()->json([
                'success' => true,
                'message' => 'Your inquiry has been submitted successfully. You will receive updates via your preferred contact method.',
                'inquiry_id' => rand(1000, 9999)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit inquiry: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display list of user's inquiries
     */
    public function listOfInquiries(Request $request)
    {
        // Sample data for demonstration
        $inquiries = collect([
            (object)[
                'id' => 1,
                'subject' => 'Product Authenticity Verification',
                'description' => 'Luxury handbag verification request',
                'category' => 'product_authenticity',
                'priority' => 'high',
                'status' => 'in-progress',
                'created_at' => now()->subDays(3),
                'assignedAgency' => (object)['name' => 'Premium Authentication Services'],
                'attachments' => collect([])
            ],
            (object)[
                'id' => 2,
                'subject' => 'Document Verification',
                'description' => 'Certificate authenticity check',
                'category' => 'document_verification',
                'priority' => 'medium',
                'status' => 'pending',
                'created_at' => now()->subDays(1),
                'assignedAgency' => null,
                'attachments' => collect([])
            ]
        ]);

        $stats = [
            'total' => 5,
            'pending' => 2,
            'in_progress' => 2,
            'completed' => 1
        ];

        return view('Module2.publicUser.listOfInquiriesPage', compact('inquiries', 'stats'));
    }

    /**
     * Display detailed view of a specific inquiry
     */
    public function inquiryDetails($inquiryId)
    {
        // Sample inquiry data
        $inquiry = (object)[
            'id' => $inquiryId,
            'subject' => 'Product Authenticity Verification',
            'description' => 'I need to verify the authenticity of a luxury handbag I recently purchased.',
            'category' => 'product_authenticity',
            'priority' => 'high',
            'status' => 'in-progress',
            'created_at' => now()->subDays(3),
            'assignedAgency' => (object)['name' => 'Premium Authentication Services'],
            'attachments' => collect([]),
            'activities' => collect([
                (object)[
                    'action' => 'Inquiry Submitted',
                    'description' => 'Initial inquiry submission by user',
                    'created_at' => now()->subDays(3),
                    'notes' => 'Inquiry created and pending review'
                ],
                (object)[
                    'action' => 'Inquiry Assigned',
                    'description' => 'Assigned to Premium Authentication Services',
                    'created_at' => now()->subDays(2),
                    'notes' => 'Agency contacted for initial review'
                ]
            ])
        ];

        return view('Module2.publicUser.inquiryDetailsPage', compact('inquiry'));
    }

    /**
     * Update inquiry details (placeholder)
     */
    public function update(Request $request, $inquiryId)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'priority' => 'required|in:low,medium,high',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Inquiry updated successfully.'
        ]);
    }

    /**
     * Cancel an inquiry (placeholder)
     */
    public function cancel($inquiryId)
    {
        return response()->json([
            'success' => true,
            'message' => 'Your inquiry has been cancelled successfully.'
        ]);
    }

    /**
     * Get user's inquiry statistics
     */
    public function getUserStats()
    {
        $stats = [
            'total_inquiries' => 5,
            'pending' => 2,
            'in_progress' => 2,
            'completed' => 1,
            'cancelled' => 0,
            'average_completion_time' => 7.5,
            'inquiries_this_month' => 3,
            'latest_inquiry' => (object)[
                'id' => 1,
                'subject' => 'Product Authenticity Verification',
                'created_at' => now()->subDays(1)
            ]
        ];

        return response()->json([
            'success' => true,
            'stats' => $stats
        ]);
    }

    /**
     * Search user's inquiries
     */
    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|string|max:255'
        ]);

        // Sample search results
        $inquiries = collect([
            (object)[
                'id' => 1,
                'subject' => 'Product Authenticity Verification',
                'description' => 'Luxury handbag verification request',
                'created_at' => now()->subDays(3)
            ]
        ]);

        return response()->json([
            'success' => true,
            'inquiries' => $inquiries,
            'query' => $request->query
        ]);
    }
}
