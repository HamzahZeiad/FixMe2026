<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Inquiry - AuthenticityHub Admin</title>
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

        .review-container {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .detail-group {
            margin-bottom: 2rem;
        }

        .detail-label {
            color: #283d63;
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-size: 1.1rem;
        }

        .detail-value {
            background: #f8faff;
            padding: 1rem;
            border-radius: 8px;
            color: #4b5563;
        }

        .status-badge {
            padding: 0.25rem 1rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 500;
            display: inline-block;
        }

        .status-pending {
            background: #fff3dc;
            color: #b25e09;
        }

        .status-resolved {
            background: #dcfce7;
            color: #15803d;
        }

        .status-progress {
            background: #dbeafe;
            color: #1e40af;
        }

        /* Top Bar Styling */
        .top-bar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 56px;
            background: #d2dbf6;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 2rem;
            z-index: 100;
            box-shadow: 0 2px 8px rgba(59, 130, 246, 0.07);
        }

        .top-bar .logo {
            font-weight: 700;
            font-size: 1.3rem;
            color: #283d63;
            letter-spacing: 0.02em;
            position: absolute;
            left: 2rem;
        }

        .admin-info-topbar {
            display: flex;
            flex-direction: row-reverse;
            align-items: center;
            position: absolute;
            right: 2rem;
            top: 50%;
            transform: translateY(-50%);
        }

        .admin-info-topbar .admin-pic {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            overflow: hidden;
            border: 2px solid #b9c8f6;
            margin-left: 0.7rem;
            background: #f3f4f6;
        }

        .admin-info-topbar .admin-pic img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .admin-info-topbar .admin-name {
            font-size: 1rem;
            color: #283d63;
            font-weight: 600;
            text-align: right;
            max-width: 120px;
        }

        /* Sidebar Styling */
        .sidebar {
            position: fixed;
            top: 56px;
            left: 0;
            width: 14rem;
            height: calc(100vh - 56px);
            background: #d2dbf6;
            box-shadow: 0 4px 15px rgba(40, 61, 99, 0.1);
            border-top-right-radius: 1.5rem;
            border-bottom-right-radius: 1.5rem;
            padding: 2rem 0;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            z-index: 99;
        }

        .sidebar-nav {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            padding: 0 1.5rem;
            flex: 1;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: #283d63;
            text-decoration: none;
            font-weight: 500;
            border-radius: 0.75rem;
            transition: all 0.3s ease;
            background: transparent;
        }

        .sidebar-link:hover {
            background: #b9c8f6;
            color: #0057ff;
            transform: translateX(4px);
        }

        .sidebar-link.active {
            background: #b9c8f6;
            color: #0057ff;
            font-weight: 600;
        }

        .sidebar-link i {
            width: 1.25rem;
            height: 1.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .main-content {
            margin-left: 14rem;
            margin-top: 56px;
            padding: 2rem;
            min-height: calc(100vh - 56px);
            background: transparent;
        }

        .btn-primary {
            background: linear-gradient(145deg, #d1d9f0, #a6b1d7);
            border-radius: 0.75rem;
            box-shadow: 4px 4px 8px #9badcd, -4px -4px 8px #ffffff;
            color: #283d63;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary:hover {
            background: linear-gradient(145deg, #c3cbea, #9badcd);
            box-shadow: 2px 2px 6px #8a9ac4, -2px -2px 6px #e5eaf8;
            transform: translateY(-2px);
        }

        .btn-success {
            background: #10b981;
            color: white;
            border-radius: 0.5rem;
            padding: 0.75rem 1.5rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-success:hover {
            background: #059669;
            transform: translateY(-1px);
        }

        .btn-danger {
            background: #ef4444;
            color: white;
            border-radius: 0.5rem;
            padding: 0.75rem 1.5rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-danger:hover {
            background: #dc2626;
            transform: translateY(-1px);
        }

        .action-section {
            background: #f1f5f9;
            border-radius: 10px;
            padding: 1.5rem;
            margin-top: 2rem;
            border: 2px solid #e2e8f0;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            color: #283d63;
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: block;
            font-size: 1rem;
        }

        .form-select, .form-textarea {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            color: #374151;
            font-size: 1rem;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-select:focus, .form-textarea:focus {
            outline: none;
            border-color: #0057ff;
            box-shadow: 0 0 0 3px rgba(0, 87, 255, 0.1);
        }
    </style>
</head>

<body>
    <!-- Top Bar -->
    <header class="top-bar">
        <div class="logo">AuthenticityHub - Admin</div>

        <div class="admin-info-topbar">
            <div class="admin-pic">
                <img src="https://ui-avatars.com/api/?name=Admin&background=4f46e5&color=ffffff" alt="Admin">
            </div>
            <div class="admin-name">Administrator</div>
        </div>
    </header>

    <!-- Sidebar -->
    <aside class="sidebar">
        <nav class="sidebar-nav">
            <a href="{{ route('admin.home') }}" class="sidebar-link">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('module2.admin.reviewInquiry') }}" class="sidebar-link active">
                <i class="fas fa-search"></i>
                <span>Review Inquiry</span>
            </a>
            <a href="{{ route('module2.admin.listOfInquiries') }}" class="sidebar-link">
                <i class="fas fa-clipboard-list"></i>
                <span>List of Inquiries</span>
            </a>
            <a href="{{ route('module2.admin.generateReport') }}" class="sidebar-link">
                <i class="fas fa-chart-bar"></i>
                <span>Generate Report</span>
            </a>
            <div style="flex:1"></div>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="sidebar-link"
                    style="background: none; border: none; width: 100%; text-align: left; cursor: pointer;">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </button>
            </form>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <div class="review-container">
            <h1 class="text-2xl font-bold text-[#283d63] mb-6">Review Inquiry</h1>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    {{ session('error') }}
                </div>
            @endif

            @if (isset($inquiry))
                <!-- Inquiry Information -->
                <div class="detail-group">
                    <div class="detail-label">Inquiry ID</div>
                    <div class="detail-value">{{ $inquiry->InquiryID }}</div>
                </div>

                <div class="detail-group">
                    <div class="detail-label">Inquiry Title</div>
                    <div class="detail-value">{{ $inquiry->InquiryTitle }}</div>
                </div>

                <div class="detail-group">
                    <div class="detail-label">Submitted by</div>
                    <div class="detail-value">
                        @if($inquiry->user)
                            {{ $inquiry->user->UserName }} ({{ $inquiry->user->UserEmail }})
                        @else
                            Unknown User
                        @endif
                    </div>
                </div>

                <div class="detail-group">
                    <div class="detail-label">News Source</div>
                    <div class="detail-value">{{ $inquiry->InquirySource }}</div>
                </div>

                <div class="detail-group">
                    <div class="detail-label">Description</div>
                    <div class="detail-value">{{ $inquiry->InquiryDescription }}</div>
                </div>

                <div class="detail-group">
                    <div class="detail-label">Submission Date</div>
                    <div class="detail-value">
                        {{ $inquiry->InquirySendDate ? $inquiry->InquirySendDate->format('Y-m-d H:i:s') : 'N/A' }}
                    </div>
                </div>

                <div class="detail-group">
                    <div class="detail-label">Current Status</div>
                    <div class="status-badge status-{{ strtolower($inquiry->InquiryStatus) }}">
                        {{ $inquiry->InquiryStatus }}
                    </div>
                </div>

                @if ($inquiry->InquiryEvidence)
                    <div class="detail-group">
                        <div class="detail-label">Supporting Document</div>
                        <div class="detail-value">
                            <a href="{{ asset('storage/' . $inquiry->InquiryEvidence) }}"
                                class="text-blue-600 hover:underline flex items-center gap-2" target="_blank">
                                <i class="fas fa-file-alt"></i>
                                View Document
                            </a>
                        </div>
                    </div>
                @endif

                <!-- Admin Actions Section -->
                <div class="action-section">
                    <h3 class="text-lg font-semibold text-[#283d63] mb-4">Admin Actions</h3>

                    <form method="POST" action="{{ route('module2.admin.updateInquiry', $inquiry->InquiryID) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="form-group">
                                <label class="form-label" for="status">Update Status</label>
                                <select id="status" name="status" class="form-select" required>
                                    <option value="pending" {{ $inquiry->InquiryStatus == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="in_progress" {{ $inquiry->InquiryStatus == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="resolved" {{ $inquiry->InquiryStatus == 'resolved' ? 'selected' : '' }}>Resolved</option>
                                    <option value="rejected" {{ $inquiry->InquiryStatus == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="agency">Assign to Agency</label>
                                <select id="agency" name="agency_id" class="form-select">
                                    <option value="">Select Agency...</option>
                                    @if(isset($agencies))
                                        @foreach($agencies as $agency)
                                            <option value="{{ $agency->AgencyID }}"
                                                {{ $inquiry->AgencyID == $agency->AgencyID ? 'selected' : '' }}>
                                                {{ $agency->AgencyName }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="admin_notes">Admin Notes</label>
                            <textarea id="admin_notes" name="admin_notes" rows="4" class="form-textarea"
                                placeholder="Add administrative notes or comments...">{{ $inquiry->admin_notes ?? '' }}</textarea>
                        </div>

                        <div class="flex gap-4 mt-6">
                            <button type="submit" class="btn-success">
                                <i class="fas fa-save"></i>
                                Update Inquiry
                            </button>

                            <a href="{{ route('module2.admin.listOfInquiries') }}" class="btn-primary">
                                <i class="fas fa-arrow-left"></i>
                                Back to List
                            </a>
                        </div>
                    </form>
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <p>No inquiry selected for review.</p>
                    <a href="{{ route('module2.admin.listOfInquiries') }}" class="text-blue-600 hover:underline">
                        Go to Inquiries List
                    </a>
                </div>
            @endif
        </div>
    </div>
</body>

</html>
