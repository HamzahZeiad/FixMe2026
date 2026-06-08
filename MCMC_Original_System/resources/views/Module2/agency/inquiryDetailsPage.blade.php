<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inquiry Details - AuthenticityHub Agency</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #6a7fd0, #6bc5f3);
            margin: 0;
            padding: 0;
        }

        .detail-container {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .detail-section {
            background: #f8faff;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            border: 1px solid #e2e8f0;
        }

        .detail-group {
            margin-bottom: 1.5rem;
        }

        .detail-label {
            color: #283d63;
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-size: 1rem;
            display: block;
        }

        .detail-value {
            background: white;
            padding: 1rem;
            border-radius: 8px;
            color: #4b5563;
            border: 1px solid #e5e7eb;
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 500;
            display: inline-block;
        }

        .status-assigned {
            background: #fef3c7;
            color: #92400e;
        }

        .status-in-progress {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .status-completed {
            background: #d1fae5;
            color: #065f46;
        }

        .status-rejected {
            background: #fee2e2;
            color: #dc2626;
        }

        .priority-high {
            color: #dc2626;
            font-weight: 600;
        }

        .priority-medium {
            color: #d97706;
            font-weight: 600;
        }

        .priority-low {
            color: #16a34a;
            font-weight: 600;
        }

        .action-btn {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.2s;
            display: inline-block;
            text-align: center;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: #3b82f6;
            color: white;
        }

        .btn-primary:hover {
            background: #2563eb;
        }

        .btn-success {
            background: #10b981;
            color: white;
        }

        .btn-success:hover {
            background: #059669;
        }

        .btn-warning {
            background: #f59e0b;
            color: white;
        }

        .btn-warning:hover {
            background: #d97706;
        }

        .btn-danger {
            background: #ef4444;
            color: white;
        }

        .btn-danger:hover {
            background: #dc2626;
        }

        .btn-secondary {
            background: #6b7280;
            color: white;
        }

        .btn-secondary:hover {
            background: #4b5563;
        }

        .timeline {
            position: relative;
            padding-left: 2rem;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 0.75rem;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #e5e7eb;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -1.75rem;
            top: 0.25rem;
            width: 0.75rem;
            height: 0.75rem;
            background: #3b82f6;
            border-radius: 50%;
            border: 2px solid white;
            box-shadow: 0 0 0 2px #3b82f6;
        }

        .timeline-content {
            background: white;
            padding: 1rem;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }

        .timeline-date {
            color: #6b7280;
            font-size: 0.875rem;
            margin-bottom: 0.25rem;
        }

        .timeline-action {
            font-weight: 600;
            color: #283d63;
            margin-bottom: 0.25rem;
        }

        .timeline-note {
            color: #4b5563;
            font-size: 0.9rem;
        }

        .attachment-item {
            display: flex;
            align-items: center;
            padding: 0.75rem;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            margin-bottom: 0.5rem;
        }

        .attachment-icon {
            color: #3b82f6;
            margin-right: 0.75rem;
            font-size: 1.25rem;
        }

        .attachment-info {
            flex: 1;
        }

        .attachment-name {
            font-weight: 500;
            color: #283d63;
        }

        .attachment-size {
            color: #6b7280;
            font-size: 0.875rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            color: #283d63;
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: block;
        }

        .form-input, .form-textarea, .form-select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            background: white;
            color: #4b5563;
        }

        .form-textarea {
            min-height: 100px;
            resize: vertical;
        }

        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }

        @media (max-width: 768px) {
            .grid-2 {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="min-h-screen p-4">
        <div class="max-w-6xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-white mb-2">Inquiry Details</h1>
                <p class="text-white opacity-90">Review and manage inquiry information</p>
            </div>

            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('agency.assigned-inquiries') }}" class="action-btn btn-secondary">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Assigned Inquiries
                </a>
            </div>

            <div class="grid-2">
                <!-- Left Column - Inquiry Details -->
                <div>
                    <!-- Basic Information -->
                    <div class="detail-container mb-6">
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">Basic Information</h2>

                        <div class="detail-group">
                            <label class="detail-label">Inquiry ID</label>
                            <div class="detail-value font-mono">
                                #{{ $inquiry->id ?? 'INQ001' }}
                            </div>
                        </div>

                        <div class="detail-group">
                            <label class="detail-label">Subject</label>
                            <div class="detail-value">
                                {{ $inquiry->subject ?? 'Product Authenticity Verification' }}
                            </div>
                        </div>

                        <div class="detail-group">
                            <label class="detail-label">Description</label>
                            <div class="detail-value">
                                {{ $inquiry->description ?? 'I need to verify the authenticity of a luxury handbag I recently purchased. The item appears to be genuine, but I want professional confirmation before proceeding with insurance or resale.' }}
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="detail-group">
                                <label class="detail-label">Priority</label>
                                <div class="detail-value">
                                    <span class="priority-{{ $inquiry->priority ?? 'high' }}">
                                        {{ ucfirst($inquiry->priority ?? 'High') }}
                                    </span>
                                </div>
                            </div>

                            <div class="detail-group">
                                <label class="detail-label">Status</label>
                                <div class="detail-value">
                                    <span class="status-badge status-{{ str_replace(' ', '-', strtolower($inquiry->status ?? 'in-progress')) }}">
                                        {{ $inquiry->status ?? 'In Progress' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="detail-group">
                                <label class="detail-label">Assigned Date</label>
                                <div class="detail-value">
                                    {{ $inquiry->assigned_at ? $inquiry->assigned_at->format('M d, Y g:i A') : 'Jan 15, 2024 2:30 PM' }}
                                </div>
                            </div>

                            <div class="detail-group">
                                <label class="detail-label">Due Date</label>
                                <div class="detail-value">
                                    <span class="{{ $inquiry->due_date && $inquiry->due_date->isPast() ? 'text-red-600 font-semibold' : '' }}">
                                        {{ $inquiry->due_date ? $inquiry->due_date->format('M d, Y g:i A') : 'Jan 22, 2024 5:00 PM' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Requester Information -->
                    <div class="detail-container mb-6">
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">Requester Information</h2>

                        <div class="detail-group">
                            <label class="detail-label">Name</label>
                            <div class="detail-value">
                                {{ $inquiry->user->name ?? 'John Doe' }}
                            </div>
                        </div>

                        <div class="detail-group">
                            <label class="detail-label">Email</label>
                            <div class="detail-value">
                                <a href="mailto:{{ $inquiry->user->email ?? 'john@example.com' }}" class="text-blue-600 hover:underline">
                                    {{ $inquiry->user->email ?? 'john@example.com' }}
                                </a>
                            </div>
                        </div>

                        <div class="detail-group">
                            <label class="detail-label">Phone</label>
                            <div class="detail-value">
                                {{ $inquiry->user->phone ?? '+1 (555) 123-4567' }}
                            </div>
                        </div>

                        <div class="detail-group">
                            <label class="detail-label">Submission Date</label>
                            <div class="detail-value">
                                {{ $inquiry->created_at ? $inquiry->created_at->format('M d, Y g:i A') : 'Jan 14, 2024 10:15 AM' }}
                            </div>
                        </div>
                    </div>

                    <!-- Attachments -->
                    <div class="detail-container mb-6">
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">Attachments</h2>

                        @if(isset($inquiry->attachments) && $inquiry->attachments->count() > 0)
                            @foreach($inquiry->attachments as $attachment)
                            <div class="attachment-item">
                                <i class="fas fa-file-image attachment-icon"></i>
                                <div class="attachment-info">
                                    <div class="attachment-name">{{ $attachment->name }}</div>
                                    <div class="attachment-size">{{ $attachment->size }}</div>
                                </div>
                                <a href="{{ $attachment->url }}" class="action-btn btn-primary" target="_blank">
                                    <i class="fas fa-download mr-1"></i>Download
                                </a>
                            </div>
                            @endforeach
                        @else
                        <!-- Sample Attachments -->
                        <div class="attachment-item">
                            <i class="fas fa-file-image attachment-icon"></i>
                            <div class="attachment-info">
                                <div class="attachment-name">handbag_front_view.jpg</div>
                                <div class="attachment-size">2.3 MB</div>
                            </div>
                            <a href="#" class="action-btn btn-primary">
                                <i class="fas fa-download mr-1"></i>Download
                            </a>
                        </div>

                        <div class="attachment-item">
                            <i class="fas fa-file-image attachment-icon"></i>
                            <div class="attachment-info">
                                <div class="attachment-name">handbag_serial_number.jpg</div>
                                <div class="attachment-size">1.8 MB</div>
                            </div>
                            <a href="#" class="action-btn btn-primary">
                                <i class="fas fa-download mr-1"></i>Download
                            </a>
                        </div>

                        <div class="attachment-item">
                            <i class="fas fa-file-pdf attachment-icon"></i>
                            <div class="attachment-info">
                                <div class="attachment-name">purchase_receipt.pdf</div>
                                <div class="attachment-size">456 KB</div>
                            </div>
                            <a href="#" class="action-btn btn-primary">
                                <i class="fas fa-download mr-1"></i>Download
                            </a>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Right Column - Actions & Timeline -->
                <div>
                    <!-- Status Update Form -->
                    <div class="detail-container mb-6">
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">Update Status</h2>

                        <form action="{{ route('agency.update-inquiry-status', $inquiry->id ?? '1') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select" required>
                                    <option value="assigned" {{ ($inquiry->status ?? 'assigned') == 'assigned' ? 'selected' : '' }}>Assigned</option>
                                    <option value="in-progress" {{ ($inquiry->status ?? 'assigned') == 'in-progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="under-review" {{ ($inquiry->status ?? 'assigned') == 'under-review' ? 'selected' : '' }}>Under Review</option>
                                    <option value="completed" {{ ($inquiry->status ?? 'assigned') == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="rejected" {{ ($inquiry->status ?? 'assigned') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Progress Notes</label>
                                <textarea name="notes" class="form-textarea" placeholder="Add notes about the current progress or findings..."></textarea>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Estimated Completion</label>
                                <input type="datetime-local" name="estimated_completion" class="form-input">
                            </div>

                            <button type="submit" class="action-btn btn-success w-full">
                                <i class="fas fa-save mr-2"></i>Update Status
                            </button>
                        </form>
                    </div>

                    <!-- Quick Actions -->
                    <div class="detail-container mb-6">
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">Quick Actions</h2>

                        <div class="space-y-3">
                            <button class="action-btn btn-primary w-full">
                                <i class="fas fa-phone mr-2"></i>Contact Requester
                            </button>

                            <button class="action-btn btn-warning w-full">
                                <i class="fas fa-clock mr-2"></i>Request Extension
                            </button>

                            <button class="action-btn btn-success w-full">
                                <i class="fas fa-check-circle mr-2"></i>Mark as Complete
                            </button>

                            <button class="action-btn btn-danger w-full">
                                <i class="fas fa-times-circle mr-2"></i>Reject Inquiry
                            </button>
                        </div>
                    </div>

                    <!-- Activity Timeline -->
                    <div class="detail-container">
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">Activity Timeline</h2>

                        <div class="timeline">
                            @if(isset($inquiry->activities) && $inquiry->activities->count() > 0)
                                @foreach($inquiry->activities as $activity)
                                <div class="timeline-item">
                                    <div class="timeline-content">
                                        <div class="timeline-date">{{ $activity->created_at->format('M d, Y g:i A') }}</div>
                                        <div class="timeline-action">{{ $activity->action }}</div>
                                        <div class="timeline-note">{{ $activity->notes }}</div>
                                    </div>
                                </div>
                                @endforeach
                            @else
                            <!-- Sample Timeline -->
                            <div class="timeline-item">
                                <div class="timeline-content">
                                    <div class="timeline-date">Jan 15, 2024 2:30 PM</div>
                                    <div class="timeline-action">Inquiry Assigned to Agency</div>
                                    <div class="timeline-note">Automatically assigned based on expertise and workload</div>
                                </div>
                            </div>

                            <div class="timeline-item">
                                <div class="timeline-content">
                                    <div class="timeline-date">Jan 15, 2024 3:15 PM</div>
                                    <div class="timeline-action">Status Updated to In Progress</div>
                                    <div class="timeline-note">Initial review of submitted materials completed</div>
                                </div>
                            </div>

                            <div class="timeline-item">
                                <div class="timeline-content">
                                    <div class="timeline-date">Jan 16, 2024 10:00 AM</div>
                                    <div class="timeline-action">Additional Information Requested</div>
                                    <div class="timeline-note">Requested clearer images of serial number and hardware details</div>
                                </div>
                            </div>

                            <div class="timeline-item">
                                <div class="timeline-content">
                                    <div class="timeline-date">Jan 14, 2024 10:15 AM</div>
                                    <div class="timeline-action">Inquiry Submitted</div>
                                    <div class="timeline-note">Initial inquiry submitted by {{ $inquiry->user->name ?? 'John Doe' }}</div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Final Actions -->
            <div class="mt-8 text-center">
                <a href="{{ route('agency.assigned-inquiries') }}" class="action-btn btn-secondary mr-4">
                    <i class="fas fa-list mr-2"></i>View All Inquiries
                </a>
                <a href="{{ route('agency.dashboard') }}" class="action-btn btn-primary">
                    <i class="fas fa-tachometer-alt mr-2"></i>Back to Dashboard
                </a>
            </div>
        </div>
    </div>
</body>

</html>
