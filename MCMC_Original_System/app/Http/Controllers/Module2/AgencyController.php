<?php

namespace App\Http\Controllers\Module2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inquiry;
use App\Models\Agency;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AgencyController extends Controller
{
    /**
     * Display the agency dashboard
     */    public function index()
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        // For now, we'll get agency from user or use a default approach
        $agency = $user->agency ?? null;
        
        if (!$agency) {
            // If user doesn't have agency relation, we can either:
            // 1. Create a default agency assignment
            // 2. Show error
            // 3. Redirect to setup
            return view('Module2.agency.no-agency')->with('message', 'You are not associated with any agency. Please contact the administrator.');
        }

        $stats = [
            'total_assigned' => 12, // Sample data for now
            'in_progress' => 8,
            'completed' => 15,
            'overdue' => 3
        ];

        $recentInquiries = collect([]); // Empty for now

        return view('Module2.agency.dashboard', compact('stats', 'recentInquiries'));
    }

    /**
     * Display assigned inquiries page
     */    public function assignedInquiries(Request $request)
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        // Sample data for demonstration
        $inquiries = collect([
            (object)[
                'id' => 1,
                'subject' => 'Product Authenticity Verification',
                'description' => 'Request for authenticity verification of luxury handbag',
                'user' => (object)['name' => 'John Doe', 'email' => 'john@example.com'],
                'priority' => 'high',
                'status' => 'in-progress',
                'assigned_at' => now()->subDays(2),
                'due_date' => now()->addDays(5)
            ],
            (object)[
                'id' => 2,
                'subject' => 'Document Verification',
                'description' => 'Certificate of authenticity validation needed',
                'user' => (object)['name' => 'Sarah Smith', 'email' => 'sarah@example.com'],
                'priority' => 'medium',
                'status' => 'assigned',
                'assigned_at' => now()->subDays(1),
                'due_date' => now()->addDays(7)
            ]
        ]);

        $stats = [
            'total_assigned' => 12,
            'in_progress' => 8,
            'completed' => 15,
            'overdue' => 3
        ];

        return view('Module2.agency.assignedInquiriesPage', compact('inquiries', 'stats'));
    }

    /**
     * Display detailed view of an assigned inquiry
     */    public function inquiryDetails($inquiryId)
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        // Sample inquiry data
        $inquiry = (object)[
            'id' => $inquiryId,
            'subject' => 'Product Authenticity Verification',
            'description' => 'I need to verify the authenticity of a luxury handbag I recently purchased. The item appears to be genuine, but I want professional confirmation before proceeding with insurance or resale.',
            'user' => (object)[
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'phone' => '+1 (555) 123-4567'
            ],
            'priority' => 'high',
            'status' => 'in-progress',
            'created_at' => now()->subDays(5),
            'assigned_at' => now()->subDays(2),
            'due_date' => now()->addDays(5),
            'attachments' => collect([]),
            'activities' => collect([])
        ];

        return view('Module2.agency.inquiryDetailsPage', compact('inquiry'));
    }

    /**
     * Update inquiry status and progress
     */
    public function updateInquiryStatus(Request $request, $inquiryId)
    {
        $request->validate([
            'status' => 'required|in:assigned,in-progress,under-review,completed,rejected',
            'notes' => 'nullable|string|max:1000',
            'estimated_completion' => 'nullable|date|after:today',
            'completion_notes' => 'nullable|string|max:1000'        ]);

        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated.'
            ], 401);
        }

        $agency = $user->agency ?? null;
        
        if (!$agency) {
            return response()->json([
                'success' => false,
                'message' => 'Access denied. You are not associated with any agency.'
            ], 403);
        }

        DB::beginTransaction();
        
        try {
            $inquiry = $agency->assignedInquiries()->findOrFail($inquiryId);
            $oldStatus = $inquiry->status;

            $updateData = [
                'status' => $request->status,
                'last_updated_by' => Auth::id(),
                'updated_at' => now()
            ];

            if ($request->filled('estimated_completion')) {
                $updateData['estimated_completion'] = $request->estimated_completion;
            }

            if ($request->status === 'completed' && $request->filled('completion_notes')) {
                $updateData['completion_notes'] = $request->completion_notes;
                $updateData['completed_at'] = now();
            }

            $inquiry->update($updateData);

            // Log the status update
            $inquiry->activities()->create([
                'action' => 'Status Updated by Agency',
                'description' => "Status changed from {$oldStatus} to {$request->status}",
                'performed_by' => Auth::id(),
                'notes' => $request->notes
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Inquiry status updated successfully',
                'inquiry' => $inquiry->load('user')
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to update inquiry status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Add progress note to inquiry
     */
    public function addProgressNote(Request $request, $inquiryId)
    {        $request->validate([
            'note' => 'required|string|max:1000',
            'is_internal' => 'boolean'
        ]);

        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated.'
            ], 401);
        }

        $agency = $user->agency ?? null;
        
        if (!$agency) {
            return response()->json([
                'success' => false,
                'message' => 'Access denied.'
            ], 403);
        }

        try {
            $inquiry = $agency->assignedInquiries()->findOrFail($inquiryId);

            $inquiry->activities()->create([
                'action' => 'Progress Note Added',
                'description' => 'Agency added progress note',
                'performed_by' => Auth::id(),
                'notes' => $request->note,
                'is_internal' => $request->get('is_internal', false)
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Progress note added successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add progress note: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Request inquiry extension
     */
    public function requestExtension(Request $request, $inquiryId)
    {        $request->validate([
            'new_due_date' => 'required|date|after:today',
            'reason' => 'required|string|max:500'
        ]);

        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated.'
            ], 401);
        }

        $agency = $user->agency ?? null;
        
        if (!$agency) {
            return response()->json([
                'success' => false,
                'message' => 'Access denied.'
            ], 403);
        }

        try {
            $inquiry = $agency->assignedInquiries()->findOrFail($inquiryId);

            // Create extension request (this could be stored in a separate table)
            $inquiry->activities()->create([
                'action' => 'Extension Requested',
                'description' => "Extension requested until {$request->new_due_date}",
                'performed_by' => Auth::id(),
                'notes' => $request->reason
            ]);

            // You might want to notify admins about the extension request
            // $this->notifyAdminsAboutExtension($inquiry, $request->new_due_date, $request->reason);

            return response()->json([
                'success' => true,
                'message' => 'Extension request submitted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to request extension: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Upload additional files for inquiry
     */
    public function uploadFiles(Request $request, $inquiryId)
    {        $request->validate([
            'files.*' => 'required|file|max:10240|mimes:pdf,jpg,jpeg,png,doc,docx',
            'description' => 'nullable|string|max:500'
        ]);

        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated.'
            ], 401);
        }

        $agency = $user->agency ?? null;
        
        if (!$agency) {
            return response()->json([
                'success' => false,
                'message' => 'Access denied.'
            ], 403);
        }

        try {
            $inquiry = $agency->assignedInquiries()->findOrFail($inquiryId);
            $uploadedFiles = [];

            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $path = $file->storeAs('inquiry_attachments/' . $inquiryId, $filename, 'public');
                    
                    $attachment = $inquiry->attachments()->create([
                        'filename' => $file->getClientOriginalName(),
                        'path' => $path,
                        'size' => $file->getSize(),
                        'mime_type' => $file->getMimeType(),
                        'uploaded_by' => Auth::id(),
                        'description' => $request->description
                    ]);

                    $uploadedFiles[] = $attachment;
                }
            }

            // Log the file upload
            $inquiry->activities()->create([
                'action' => 'Files Uploaded by Agency',
                'description' => count($uploadedFiles) . ' file(s) uploaded',
                'performed_by' => Auth::id(),
                'notes' => $request->description
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Files uploaded successfully',
                'files' => $uploadedFiles
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload files: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get agency workload and statistics
     */    public function getWorkloadStats()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated.'
            ], 401);
        }

        $agency = $user->agency ?? null;
        
        if (!$agency) {
            return response()->json([
                'success' => false,
                'message' => 'Access denied.'
            ], 403);
        }

        $stats = [
            'total_assigned' => $agency->assignedInquiries()->count(),
            'pending' => $agency->assignedInquiries()->where('status', 'assigned')->count(),
            'in_progress' => $agency->assignedInquiries()->where('status', 'in-progress')->count(),
            'under_review' => $agency->assignedInquiries()->where('status', 'under-review')->count(),
            'completed_this_month' => $agency->assignedInquiries()->where('status', 'completed')
                ->whereMonth('updated_at', now()->month)
                ->count(),
            'overdue' => $agency->assignedInquiries()
                ->whereIn('status', ['assigned', 'in-progress'])
                ->where('due_date', '<', now())
                ->count(),
            'avg_completion_time' => $this->calculateAverageCompletionTime($agency),
            'completion_rate' => $this->calculateCompletionRate($agency)
        ];

        return response()->json([
            'success' => true,
            'stats' => $stats
        ]);
    }

    /**
     * Calculate average completion time for agency
     */
    private function calculateAverageCompletionTime($agency)
    {
        $completedInquiries = $agency->assignedInquiries()
            ->where('status', 'completed')
            ->whereNotNull('completed_at')
            ->whereNotNull('assigned_at')
            ->get();

        if ($completedInquiries->isEmpty()) {
            return 0;
        }

        $totalHours = $completedInquiries->sum(function($inquiry) {
            return $inquiry->assigned_at->diffInHours($inquiry->completed_at);
        });

        return round($totalHours / $completedInquiries->count(), 2);
    }

    /**
     * Calculate completion rate for agency
     */
    private function calculateCompletionRate($agency)
    {
        $totalAssigned = $agency->assignedInquiries()->count();
        $completed = $agency->assignedInquiries()->where('status', 'completed')->count();

        return $totalAssigned > 0 ? round(($completed / $totalAssigned) * 100, 2) : 0;
    }

    /**
     * Contact requester about inquiry
     */
    public function contactRequester(Request $request, $inquiryId)
    {        $request->validate([
            'message' => 'required|string|max:1000',
            'contact_method' => 'required|in:email,phone,sms'
        ]);

        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated.'
            ], 401);
        }

        $agency = $user->agency ?? null;
        
        if (!$agency) {
            return response()->json([
                'success' => false,
                'message' => 'Access denied.'
            ], 403);
        }

        try {
            $inquiry = $agency->assignedInquiries()->findOrFail($inquiryId);

            // Log the contact attempt
            $inquiry->activities()->create([
                'action' => 'Requester Contacted',
                'description' => "Agency contacted requester via {$request->contact_method}",
                'performed_by' => Auth::id(),
                'notes' => $request->message
            ]);

            // Here you would implement the actual contact logic
            // (send email, SMS, etc.)

            return response()->json([
                'success' => true,
                'message' => 'Contact attempt logged successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to contact requester: ' . $e->getMessage()
            ], 500);
        }
    }
}