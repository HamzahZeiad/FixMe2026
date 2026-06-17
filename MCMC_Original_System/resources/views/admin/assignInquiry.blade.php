<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin – Inquiry Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            width: 100vw;
            height: 100vh;
            overflow-x: hidden;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f0f0f0;
            position: relative;
        }

        /* Top Bar Styling */
        .top-bar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 56px;
            background: #111111;
            display: flex;
            align-items: center;
            padding: 0 1rem;
            z-index: 100;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .top-bar .logo {
            font-weight: 700;
            font-size: 1.3rem;
            color: #ffffff;
            margin-right: 2rem;
        }

        .top-bar .search-container {
            flex: 1;
            max-width: 300px;
            margin: 0 auto;
        }

        .top-bar .search-container input {
            width: 100%;
            padding: 0.5rem 1rem;
            border-radius: 30px;
            border: none;
            background: #f4f4f4;
            color: #333;
            font-size: 0.9rem;
        }

        /* Sidebar Styling */
        .sidebar {
            position: fixed;
            top: 56px;
            left: 0;
            width: 14rem;
            height: calc(100vh - 56px);
            background: #e2e2e2;
            border-top-right-radius: 1.5rem;
            border-bottom-right-radius: 1.5rem;
            box-shadow: 0 4px 15px rgba(40, 61, 99, 0.1);
            display: flex;
            flex-direction: column;
            padding: 2rem 0;
            z-index: 99;
        }

        .sidebar-nav {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            padding: 0 1rem;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.7rem;
            padding: 0.75rem 1rem;
            color: #333;
            text-decoration: none;
            font-weight: 500;
            border-radius: 0.75rem;
            transition: all 0.3s ease;
        }

        .sidebar-link:hover {
            background: rgba(255, 255, 255, 0.6);
            color: #ff3333;
            transform: translateX(4px);
        }

        .sidebar-link.active {
            background: rgba(255, 255, 255, 0.8);
            color: #ff3333;
        }

        .sidebar-link i {
            width: 1.2rem;
            text-align: center;
        }

        /* User info in top bar */
        .user-info-topbar {
            display: flex;
            align-items: center;
            margin-left: auto;
        }

        .user-info-topbar .welcome {
            color: #ffffff;
            font-size: 0.8rem;
            text-align: right;
            margin-right: 0.5rem;
        }

        .user-info-topbar .user-icon {
            color: #ffffff;
            font-size: 1.5rem;
        }

        .main-content {
            margin-left: 14rem;
            margin-top: 56px;
            padding: 2rem;
            min-height: calc(100vh - 56px);
            background: #f0f0f0;
        }

        /* Icon selection page */
        .icon-selection {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 70vh;
            gap: 3rem;
            flex-wrap: wrap;
        }

        .icon-card {
            background: white;
            border-radius: 20px;
            padding: 3rem 2rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            min-width: 280px;
            max-width: 320px;
            border: 3px solid transparent;
            flex: 1;
        }

        .icon-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 16px 48px rgba(0, 0, 0, 0.15);
            border-color: #ff3333;
        }

        .icon-card i {
            font-size: 5rem;
            margin-bottom: 1.5rem;
            color: #ff3333;
        }

        .icon-card h3 {
            font-size: 1.8rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 1rem;
        }

        .icon-card p {
            color: #666;
            font-size: 1rem;
            line-height: 1.6;
        }

        /* Content pages - hidden by default */
        .content-page {
            display: none;
        }

        .content-page.active {
            display: block;
        }

        /* Back button */
        .back-button {
            background: #666;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            margin-bottom: 2rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .back-button:hover {
            background: #555;
        }

        /* Common styles for both pages */
        .card {
            background: #ffffff;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            width: 100%;
            text-align: left;
            margin-bottom: 2rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            text-align: center;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 600;
            color: #333;
        }

        .stat-label {
            color: #666;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        .profile-header {
            color: #333;
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        /* Assign inquiry specific styles */
        .assignment-section {
            margin-bottom: 1.5rem;
            padding: 1rem;
            background: #f0f9ff;
            border-radius: 8px;
            border: 1px solid #bae6fd;
        }

        .assignment-form {
            display: flex;
            gap: 1rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .form-select {
            padding: 0.5rem 1rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            min-width: 250px;
        }

        .assign-button {
            background: #dddddd;
            color: #333;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .assign-button:hover:not(:disabled) {
            background: #cccccc;
        }

        .assign-button:disabled {
            background: #9ca3af;
            cursor: not-allowed;
        }

        .selected-count {
            background: #059669;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .checkbox-cell {
            width: 40px;
            text-align: center;
        }

        .inquiry-checkbox {
            width: 1.25rem;
            height: 1.25rem;
            border-radius: 0.25rem;
            border: 2px solid #d1d5db;
            cursor: pointer;
        }

        .unassigned-badge {
            background: #fee2e2;
            color: #991b1b;
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        /* View submitted inquiries styles */
        .inquiry-list {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            width: 100%;
            max-width: 100%;
            box-sizing: border-box;
            overflow-x: auto;
            margin: 0;
        }

        .inquiry-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 0.5rem;
            table-layout: auto;
            min-width: 800px;
        }

        .inquiry-table th {
            text-align: left;
            padding: 1rem;
            color: #333;
            font-weight: 600;
            border-bottom: 2px solid #dddddd;
            background: #f8f8f8;
        }

        .inquiry-table td {
            padding: 1rem;
            background: #fafafa;
            margin-bottom: 0.5rem;
        }

        .inquiry-table tr:hover td {
            background: #f0f0f0;
        }

        .status-badge {
            padding: 0.25rem 1rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .status-pending {
            background: #fff3dc;
            color: #b25e09;
        }

        .status-underinvestigation {
            background: #dbeafe;
            color: #1e40af;
        }

        .status-verifiedastrue {
            background: #dcfce7;
            color: #166534;
        }

        .status-identifiedasfake {
            background: #fee2e2;
            color: #dc2626;
        }

        .status-rejected {
            background: #fef3c7;
            color: #d97706;
        }

        .review-button {
            background: #ff6b35;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            text-decoration: none;
            font-size: 0.875rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: background-color 0.2s;
        }

        .review-button:hover {
            background: #e55b2b;
        }

        .reviewed-button {
            background: #10b981;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            text-decoration: none;
            font-size: 0.875rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .reviewed-button:hover {
            background: #059669;
        }

        .new-badge {
            background: #ef4444;
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        .filter-section {
            margin-bottom: 2rem;
            padding: 1.5rem;
            background: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #e9ecef;
        }

        .filter-form {
            display: flex;
            gap: 1rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .filter-form input,
        .filter-form select {
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 0.875rem;
        }

        .filter-form button {
            background: #007bff;
            color: white;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.875rem;
        }

        .filter-form button:hover {
            background: #0056b3;
        }

        .clear-button {
            background: #6c757d !important;
        }

        .clear-button:hover {
            background: #545b62 !important;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 1rem;
            }

            .sidebar {
                display: none;
            }

            .icon-selection {
                flex-direction: column;
                gap: 2rem;
                padding: 1rem;
            }

            .icon-card {
                min-width: 250px;
                max-width: 100%;
            }
        }

        @media (max-width: 1200px) and (min-width: 769px) {
            .icon-selection {
                gap: 2rem;
            }
            
            .icon-card {
                min-width: 250px;
                max-width: 280px;
            }
        }
    </style>
</head>

<body>
    <!-- Top Bar -->
    <header class="top-bar">
        <div class="logo">AuthenticityHub</div>
        <div class="search-container">
            <input type="text" placeholder="Search...">
        </div>
        <div class="user-info-topbar">
            <div class="welcome">
                Welcome<br>{{ DB::table('administrators')->first()->AdminName ?? 'Admin' }}
            </div>
            <div class="user-icon">
                <i class="fas fa-user-circle"></i>
            </div>
        </div>
    </header>

    <!-- Sidebar -->
    <aside class="sidebar">
        <nav class="sidebar-nav">
            <a href="{{ route('admin.home') }}" class="sidebar-link">
                <i class="fas fa-home"></i>
                <span>Home</span>
            </a>
            <a href="{{ route('admin.assign.inquiry') }}" class="sidebar-link active">
                <i class="fas fa-tasks"></i>
                <span>Assign Inquiry</span>
            </a>
            <a href="{{ route('admin.inquiries') }}" class="sidebar-link">
                <i class="fas fa-clipboard-list"></i>
                <span>Review Inquiries</span>
            </a>
            <a href="{{ route('admin.agency.register') }}" class="sidebar-link">
                <i class="fas fa-cog"></i>
                <span>Agency Registration</span>
            </a>
            <a href="{{ route('admin.users') }}" class="sidebar-link">
                <i class="fas fa-search"></i>
                <span>Search For User</span>
            </a>
            <a href="{{ route('admin.reports') }}" class="sidebar-link">
                <i class="fas fa-chart-bar"></i>
                <span>Report</span>
            </a>

            <a href="{{ route('login') }}" class="sidebar-link">
                <i class="fas fa-sign-out-alt"></i>
                <span>Exit</span>
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Icon Selection Page -->
        <div id="iconSelection" class="icon-selection">
            <div class="icon-card" onclick="showPage('assignPage')">
                <i class="fas fa-user-tie"></i>
                <h3>Assign Inquiry</h3>
                <p>Assign pending inquiries to available agencies for investigation and review.</p>
            </div>
            <div class="icon-card" onclick="showPage('viewPage')">
                <i class="fas fa-eye"></i>
                <h3>View Submitted</h3>
                <p>View all submitted inquiries with their current status and assigned agencies.</p>
            </div>
            <div class="icon-card" onclick="showPage('notesPage')">
                <i class="fas fa-sticky-note"></i>
                <h3>Assignment Notes</h3>
                <p>Add notes and instructions to guide agencies when assigning inquiries for investigation.</p>
            </div>
        </div>

        <!-- Assign Inquiry Page -->
        <div id="assignPage" class="content-page">
            <button class="back-button" onclick="showPage('iconSelection')">
                <i class="fas fa-arrow-left"></i>
                Back to Menu
            </button>

            <!-- Statistics Dashboard -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number">{{ $inquiries->count() }}</div>
                    <div class="stat-label">Total Inquiries</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $inquiries->whereNull('AgencyID')->count() }}</div>
                    <div class="stat-label">Unassigned</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $inquiries->where('InquiryStatus', 'Pending')->count() }}</div>
                    <div class="stat-label">Pending Review</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $agencies->count() }}</div>
                    <div class="stat-label">Available Agencies</div>
                </div>
            </div>

            <div class="card">
                <h2 class="profile-header">Assign Inquiry to Agency</h2>

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

                <!-- Assignment Section -->
                <div class="assignment-section">
                    <h3 class="text-lg font-semibold text-[#333] mb-4">
                        <i class="fas fa-hand-point-right mr-2"></i>Bulk Assignment
                    </h3>
                    <form method="POST" action="{{ route('admin.assign.inquiries') }}" class="assignment-form" id="assignmentForm">
                        @csrf
                        <div class="flex items-center gap-4">
                            <div id="selectedCount" class="selected-count" style="display: none;">
                                0 inquiries selected
                            </div>
                            <select name="agency_id" required class="form-select">
                                <option value="">Select Agency to Assign</option>
                                @foreach($agencies as $agency)
                                    <option value="{{ $agency->AgencyID }}">{{ $agency->AgencyName }}</option>
                                @endforeach
                            </select>
                            <select name="priority" required class="form-select">
    <option value="">Select Priority</option>
    <option value="low">Low</option>
    <option value="medium">Medium</option>
    <option value="high">High</option>
</select>
<input
    type="date"
    name="due_date"
    class="form-select"
    required
    min="{{ date('Y-m-d') }}"
>
                            <button type="submit" class="assign-button" id="assignButton" disabled>
                                <i class="fas fa-arrow-right"></i>
                                Assign Selected Inquiries
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Filter Section -->
                <div class="filter-section">
                    <form method="GET" action="{{ route('admin.assign.inquiry') }}" class="filter-form">
                        <input type="text" name="search" placeholder="Search by title, source, or ID..."
                            value="{{ request('search') }}" style="min-width: 250px;">
                        <select name="status">
                            <option value="">All Status</option>
                            <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Under Investigation" {{ request('status') == 'Under Investigation' ? 'selected' : '' }}>Under Investigation</option>
                            <option value="Verified as True" {{ request('status') == 'Verified as True' ? 'selected' : '' }}>Verified as True</option>
                            <option value="Identified as Fake" {{ request('status') == 'Identified as Fake' ? 'selected' : '' }}>Identified as Fake</option>
                            <option value="Rejected" {{ request('status') == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                        <select name="agency">
                            <option value="">All Agencies</option>
                            <option value="unassigned" {{ request('agency') == 'unassigned' ? 'selected' : '' }}>Unassigned</option>
                            @foreach($agencies as $agency)
                                <option value="{{ $agency->AgencyID }}" {{ request('agency') == $agency->AgencyID ? 'selected' : '' }}>
                                    {{ $agency->AgencyName }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit">Filter</button>
                        <a href="{{ route('admin.assign.inquiry') }}" class="filter-form button clear-button"
                            style="padding: 0.5rem 1rem; text-decoration: none; border-radius: 4px;">Clear</a>
                    </form>
                </div>

                <!-- Inquiries Table for Assignment -->
                <div class="overflow-x-auto">
                    <table class="inquiry-table">
                        <thead>
                            <tr>
                                <th class="checkbox-cell">
                                    <input type="checkbox" id="selectAll" title="Select All">
                                </th>
                                <th>Inquiry ID</th>
                                <th>Title</th>
                                <th>Source</th>
                                <th>Submitter</th>
                                <th>Submission Date</th>
                                <th>Status</th>
                                <th>Current Agency</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($inquiries->count() > 0)
                                @foreach ($inquiries as $inquiry)
                                    <tr>
                                        <td class="checkbox-cell">
                                            @if(!$inquiry->AgencyID)
                                                <input type="checkbox" name="inquiry_ids[]" value="{{ $inquiry->InquiryID }}" 
                                                       class="inquiry-checkbox" form="assignmentForm">
                                            @else
                                                <i class="fas fa-check text-green-500" title="Already assigned"></i>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="flex items-center gap-2">
                                                <span class="text-sm font-mono">#{{ $inquiry->InquiryID }}</span>
                                                @if(!$inquiry->AgencyID)
                                                    <span class="unassigned-badge">UNASSIGNED</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="font-medium">{{ $inquiry->InquiryTitle }}</div>
                                            <div class="text-sm text-gray-500">
                                                {{ Str::limit($inquiry->InquiryDescription, 50) }}</div>
                                        </td>
                                        <td>{{ $inquiry->InquirySource }}</td>
                                        <td>
                                            @if ($inquiry->UserID)
                                                @php
                                                    $user = \App\Models\PublicUser::find($inquiry->UserID);
                                                @endphp
                                                {{ $user ? $user->UserName : 'User not found' }}
                                            @else
                                                <span class="text-gray-500">Anonymous</span>
                                            @endif
                                        </td>
                                        <td>{{ $inquiry->InquirySendDate ? $inquiry->InquirySendDate->format('Y-m-d H:i') : 'N/A' }}</td>
                                        <td>
                                            <span class="status-badge status-{{ strtolower(str_replace(' ', '', $inquiry->InquiryStatus)) }}">
                                                {{ $inquiry->InquiryStatus }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($inquiry->agency)
                                                <div class="flex items-center gap-2">
                                                    <div class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center text-xs font-medium text-blue-800">
                                                        {{ substr($inquiry->agency->AgencyName, 0, 1) }}
                                                    </div>
                                                    <div>
                                                        <div class="font-medium text-sm">{{ $inquiry->agency->AgencyName }}</div>
                                                        @if($inquiry->assignment_date)
                                                            <div class="text-xs text-gray-500">
                                                                Assigned {{ $inquiry->assignment_date->format('M j, Y') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-gray-400 text-sm">Not Assigned</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="8" class="text-center py-8 text-gray-500">
                                        No inquiries found matching your criteria.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- View Submitted Inquiries Page -->
        <div id="viewPage" class="content-page">
            <button class="back-button" onclick="showPage('iconSelection')">
                <i class="fas fa-arrow-left"></i>
                Back to Menu
            </button>

            <!-- Statistics Dashboard -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number">{{ $inquiries->count() }}</div>
                    <div class="stat-label">Total Inquiries</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $inquiries->where('InquiryStatus', 'Pending')->count() }}</div>
                    <div class="stat-label">Pending Review</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $inquiries->where('InquiryStatus', 'Under Investigation')->count() }}</div>
                    <div class="stat-label">Under Investigation</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $inquiries->whereNull('AgencyID')->count() }}</div>
                    <div class="stat-label">Unassigned</div>
                </div>
            </div>

            <div class="inquiry-list">
                <h2 class="text-2xl font-semibold text-[#333] mb-6">View Submitted Inquiries</h2>

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

                <!-- Filter Section -->
                <div class="filter-section">
                    <form method="GET" action="{{ route('admin.inquiries') }}" class="filter-form">
                        <input type="text" name="search" placeholder="Search by title, source, or ID..."
                            value="{{ request('search') }}" style="min-width: 250px;">
                        <select name="status">
                            <option value="">All Status</option>
                            <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending -
                                Awaiting Review</option>
                            <option value="Under Investigation"
                                {{ request('status') == 'Under Investigation' ? 'selected' : '' }}>Under Investigation
                                - Agency Reviewing</option>
                            <option value="Verified as True"
                                {{ request('status') == 'Verified as True' ? 'selected' : '' }}>Verified as True -
                                Genuine News</option>
                            <option value="Identified as Fake"
                                {{ request('status') == 'Identified as Fake' ? 'selected' : '' }}>Identified as Fake -
                                False Information</option>
                            <option value="Rejected" {{ request('status') == 'Rejected' ? 'selected' : '' }}>Rejected -
                                No Jurisdiction</option>
                        </select>
                        <button type="submit">Filter</button>
                        <a href="{{ route('admin.inquiries') }}" class="filter-form button clear-button"
                            style="padding: 0.5rem 1rem; text-decoration: none; border-radius: 4px;">Clear</a>
                    </form>
                </div>

                <!-- Inquiries Table for Viewing -->
                <div class="overflow-x-auto">
                    <table class="inquiry-table">
                        <thead>
                            <tr>
                                <th>Inquiry ID</th>
                                <th>Title</th>
                                <th>Source</th>
                                <th>Submitter</th>
                                <th>Submission Date</th>
                                <th>Status</th>
                                <th>Assigned Agency</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($inquiries->count() > 0)
                                @foreach ($inquiries as $inquiry)
                                    <tr>
                                        <td>
                                            <div class="flex items-center gap-2">
                                                <span class="text-sm font-mono">#{{ $inquiry->InquiryID }}</span>
                                                @if($inquiry->InquiryStatus === 'Pending')
                                                    <span class="new-badge">NEW</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="font-medium">{{ $inquiry->InquiryTitle }}</div>
                                            <div class="text-sm text-gray-500">
                                                {{ Str::limit($inquiry->InquiryDescription, 50) }}</div>
                                        </td>
                                        <td>{{ $inquiry->InquirySource }}</td>
                                        <td>
                                            @if ($inquiry->UserID)
                                                @php
                                                    $user = \App\Models\PublicUser::find($inquiry->UserID);
                                                @endphp
                                                {{ $user ? $user->UserName : 'User not found' }}
                                            @else
                                                <span class="text-gray-500">Anonymous</span>
                                            @endif
                                        </td>
                                        <td>{{ $inquiry->InquirySendDate ? $inquiry->InquirySendDate->format('Y-m-d H:i') : 'N/A' }}
                                        </td>
                                        <td>
                                            <span
                                                class="status-badge status-{{ strtolower(str_replace(' ', '', $inquiry->InquiryStatus)) }}">
                                                {{ $inquiry->InquiryStatus }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($inquiry->agency)
                                                <div class="flex items-center gap-2">
                                                    <div class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center text-xs font-medium text-blue-800">
                                                        {{ substr($inquiry->agency->AgencyName, 0, 1) }}
                                                    </div>
                                                    <div>
                                                        <div class="font-medium text-sm">{{ $inquiry->agency->AgencyName }}</div>
                                                        @if($inquiry->assignment_date)
                                                            <div class="text-xs text-gray-500">
                                                                Assigned {{ $inquiry->assignment_date->format('g:i A') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-gray-400 text-sm">Unassigned</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($inquiry->InquiryStatus === 'Pending')
                                                <a href="{{ route('admin.inquiry.details', $inquiry->InquiryID) }}"
                                                    class="review-button">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                        <path fill-rule="evenodd"
                                                            d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    Review
                                                </a>
                                            @else
                                                <a href="{{ route('admin.inquiry.details', $inquiry->InquiryID) }}" class="reviewed-button">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    Reviewed
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="8" class="text-center py-8 text-gray-500">
                                        @if (request('search') || request('status'))
                                            No inquiries found matching your criteria. <a
                                                href="{{ route('admin.inquiries') }}"
                                                class="text-red-600 hover:underline">Clear filters</a>
                                        @else
                                            No inquiries submitted yet.
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Assignment Notes Page -->
        <div id="notesPage" class="content-page">
            <button class="back-button" onclick="showPage('iconSelection')">
                <i class="fas fa-arrow-left"></i>
                Back to Menu
            </button>

            <!-- Statistics Dashboard -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number">{{ $inquiries->count() }}</div>
                    <div class="stat-label">Total Inquiries</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $inquiries->whereNull('AgencyID')->count() }}</div>
                    <div class="stat-label">Unassigned</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $inquiries->where('InquiryStatus', 'Pending')->count() }}</div>
                    <div class="stat-label">Pending Review</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $agencies->count() }}</div>
                    <div class="stat-label">Available Agencies</div>
                </div>
            </div>

            <div class="card">
                <h2 class="profile-header">Add Assignment Notes & Instructions</h2>

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

                <!-- Assignment with Notes Section -->
                <div class="assignment-section">
                    <h3 class="text-lg font-semibold text-[#333] mb-4">
                        <i class="fas fa-sticky-note mr-2"></i>Assign with Custom Notes & Instructions
                    </h3>
                    <form method="POST" action="{{ route('admin.assign.inquiries.with.notes') }}" class="assignment-form" id="notesAssignmentForm">
                        @csrf
                        <div class="flex flex-col gap-4 w-full">
                            <div id="selectedCountNotes" class="selected-count" style="display: none;">
                                0 inquiries selected
                            </div>
                            
                            <div class="flex gap-4 items-start w-full">
                                <select name="agency_id" required class="form-select flex-1">
                                    <option value="">Select Agency to Assign</option>
                                    @foreach($agencies as $agency)
                                        <option value="{{ $agency->AgencyID }}">{{ $agency->AgencyName }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="w-full">
                                <label for="assignment_notes" class="block text-sm font-medium text-gray-700 mb-2">
                                    Assignment Notes & Instructions
                                </label>
                                <textarea 
                                    name="assignment_notes" 
                                    id="assignment_notes" 
                                    rows="4" 
                                    class="w-full p-3 border border-gray-300 rounded-md resize-vertical"
                                    placeholder="Enter specific instructions, priority level, expected timeline, or any special requirements for this assignment..."
                                    required></textarea>
                                <p class="text-sm text-gray-500 mt-1">
                                    Provide clear guidance to help agencies understand the context and requirements for investigating these inquiries.
                                </p>
                            </div>

                            <div class="flex gap-2">
                                <select name="priority_level" class="form-select">
                                    <option value="normal">Normal Priority</option>
                                    <option value="high">High Priority</option>
                                    <option value="urgent">Urgent</option>
                                </select>
                                
                                <input type="date" name="expected_completion" class="form-select" 
                                       min="{{ date('Y-m-d') }}" placeholder="Expected completion date">
                            </div>

                            <button type="submit" class="assign-button" id="notesAssignButton" disabled>
                                <i class="fas fa-paper-plane"></i>
                                Assign Selected Inquiries with Notes
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Filter Section -->
                <div class="filter-section">
                    <form method="GET" action="{{ route('admin.assign.inquiry') }}" class="filter-form">
                        <input type="text" name="search" placeholder="Search by title, source, or ID..."
                            value="{{ request('search') }}" style="min-width: 250px;">
                        <select name="status">
                            <option value="">All Status</option>
                            <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Under Investigation" {{ request('status') == 'Under Investigation' ? 'selected' : '' }}>Under Investigation</option>
                            <option value="Verified as True" {{ request('status') == 'Verified as True' ? 'selected' : '' }}>Verified as True</option>
                            <option value="Identified as Fake" {{ request('status') == 'Identified as Fake' ? 'selected' : '' }}>Identified as Fake</option>
                            <option value="Rejected" {{ request('status') == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                        <select name="agency">
                            <option value="">All Agencies</option>
                            <option value="unassigned" {{ request('agency') == 'unassigned' ? 'selected' : '' }}>Unassigned</option>
                            @foreach($agencies as $agency)
                                <option value="{{ $agency->AgencyID }}" {{ request('agency') == $agency->AgencyID ? 'selected' : '' }}>
                                    {{ $agency->AgencyName }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit">Filter</button>
                        <a href="{{ route('admin.assign.inquiry') }}" class="filter-form button clear-button"
                            style="padding: 0.5rem 1rem; text-decoration: none; border-radius: 4px;">Clear</a>
                    </form>
                </div>

                <!-- Inquiries Table for Assignment with Notes -->
                <div class="overflow-x-auto">
                    <table class="inquiry-table">
                        <thead>
                            <tr>
                                <th class="checkbox-cell">
                                    <input type="checkbox" id="selectAllNotes" title="Select All">
                                </th>
                                <th>Inquiry ID</th>
                                <th>Title</th>
                                <th>Source</th>
                                <th>Submitter</th>
                                <th>Submission Date</th>
                                <th>Status</th>
                                <th>Current Agency</th>
                                <th>Existing Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($inquiries->count() > 0)
                                @foreach ($inquiries as $inquiry)
                                    <tr>
                                        <td class="checkbox-cell">
                                            @if(!$inquiry->AgencyID)
                                                <input type="checkbox" name="inquiry_ids[]" value="{{ $inquiry->InquiryID }}" 
                                                       class="inquiry-checkbox-notes" form="notesAssignmentForm">
                                            @else
                                                <i class="fas fa-check text-green-500" title="Already assigned"></i>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="flex items-center gap-2">
                                                <span class="text-sm font-mono">#{{ $inquiry->InquiryID }}</span>
                                                @if(!$inquiry->AgencyID)
                                                    <span class="unassigned-badge">UNASSIGNED</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="font-medium">{{ $inquiry->InquiryTitle }}</div>
                                            <div class="text-sm text-gray-500">
                                                {{ Str::limit($inquiry->InquiryDescription, 50) }}</div>
                                        </td>
                                        <td>{{ $inquiry->InquirySource }}</td>
                                        <td>
                                            @if ($inquiry->UserID)
                                                @php
                                                    $user = \App\Models\PublicUser::find($inquiry->UserID);
                                                @endphp
                                                {{ $user ? $user->UserName : 'User not found' }}
                                            @else
                                                <span class="text-gray-500">Anonymous</span>
                                            @endif
                                        </td>
                                        <td>{{ $inquiry->InquirySendDate ? $inquiry->InquirySendDate->format('Y-m-d H:i') : 'N/A' }}</td>
                                        <td>
                                            <span class="status-badge status-{{ strtolower(str_replace(' ', '', $inquiry->InquiryStatus)) }}">
                                                {{ $inquiry->InquiryStatus }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($inquiry->agency)
                                                <div class="flex items-center gap-2">
                                                    <div class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center text-xs font-medium text-blue-800">
                                                        {{ substr($inquiry->agency->AgencyName, 0, 1) }}
                                                    </div>
                                                    <div>
                                                        <div class="font-medium text-sm">{{ $inquiry->agency->AgencyName }}</div>
                                                        @if($inquiry->assignment_date)
                                                            <div class="text-xs text-gray-500">
                                                                Assigned {{ $inquiry->assignment_date->format('M j, Y') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-gray-400 text-sm">Not Assigned</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($inquiry->assignment_notes)
                                                <div class="text-sm bg-yellow-50 p-2 rounded border-l-4 border-yellow-400">
                                                    <div class="font-medium text-yellow-800">Notes:</div>
                                                    <div class="text-yellow-700">{{ Str::limit($inquiry->assignment_notes, 100) }}</div>
                                                    @if($inquiry->priority_level && $inquiry->priority_level !== 'normal')
                                                        <div class="mt-1">
                                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                                                {{ $inquiry->priority_level === 'urgent' ? 'bg-red-100 text-red-800' : 'bg-orange-100 text-orange-800' }}">
                                                                {{ ucfirst($inquiry->priority_level) }} Priority
                                                            </span>
                                                        </div>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="text-gray-400 text-sm">No notes</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="9" class="text-center py-8 text-gray-500">
                                        No inquiries found matching your criteria.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Success message --}}
        @if (session('success'))
            <div
                style="position: fixed; bottom: 20px; right: 20px; background: #4CAF50; color: white; padding: 15px; border-radius: 5px; box-shadow: 0 2px 10px rgba(0,0,0,0.2);">
                {{ session('success') }}
            </div>
            <script>
                setTimeout(function() {
                    document.querySelector('div[style*="position: fixed"]').style.display = 'none';
                }, 5000);
            </script>
        @endif
    </div>

    <script>
        function showPage(pageId) {
            // Hide all pages
            document.getElementById('iconSelection').style.display = 'none';
            document.getElementById('assignPage').style.display = 'none';
            document.getElementById('viewPage').style.display = 'none';
            document.getElementById('notesPage').style.display = 'none';
            
            // Show selected page
            if (pageId === 'iconSelection') {
                document.getElementById('iconSelection').style.display = 'flex';
            } else {
                document.getElementById(pageId).style.display = 'block';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Regular assign page functionality
            const selectAllCheckbox = document.getElementById('selectAll');
            const inquiryCheckboxes = document.querySelectorAll('.inquiry-checkbox');
            const selectedCount = document.getElementById('selectedCount');
            const assignButton = document.getElementById('assignButton');

            function updateSelectedCount() {
                const selected = document.querySelectorAll('.inquiry-checkbox:checked').length;
                if (selected > 0) {
                    selectedCount.textContent = `${selected} inquiry${selected > 1 ? 'ies' : ''} selected`;
                    selectedCount.style.display = 'block';
                    assignButton.disabled = false;
                } else {
                    selectedCount.style.display = 'none';
                    assignButton.disabled = true;
                }
            }

            if (selectAllCheckbox) {
                selectAllCheckbox.addEventListener('change', function() {
                    inquiryCheckboxes.forEach(checkbox => {
                        checkbox.checked = this.checked;
                    });
                    updateSelectedCount();
                });
            }

            inquiryCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    if (selectAllCheckbox) {
                        const allChecked = Array.from(inquiryCheckboxes).every(cb => cb.checked);
                        selectAllCheckbox.checked = allChecked;
                    }
                    updateSelectedCount();
                });
            });

            // Notes page functionality
            const selectAllNotesCheckbox = document.getElementById('selectAllNotes');
            const inquiryNotesCheckboxes = document.querySelectorAll('.inquiry-checkbox-notes');
            const selectedCountNotes = document.getElementById('selectedCountNotes');
            const notesAssignButton = document.getElementById('notesAssignButton');

            function updateSelectedCountNotes() {
                const selected = document.querySelectorAll('.inquiry-checkbox-notes:checked').length;
                if (selected > 0) {
                    selectedCountNotes.textContent = `${selected} inquiry${selected > 1 ? 'ies' : ''} selected`;
                    selectedCountNotes.style.display = 'block';
                    notesAssignButton.disabled = false;
                } else {
                    selectedCountNotes.style.display = 'none';
                    notesAssignButton.disabled = true;
                }
            }

            if (selectAllNotesCheckbox) {
                selectAllNotesCheckbox.addEventListener('change', function() {
                    inquiryNotesCheckboxes.forEach(checkbox => {
                        checkbox.checked = this.checked;
                    });
                    updateSelectedCountNotes();
                });
            }

            inquiryNotesCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    if (selectAllNotesCheckbox) {
                        const allChecked = Array.from(inquiryNotesCheckboxes).every(cb => cb.checked);
                        selectAllNotesCheckbox.checked = allChecked;
                    }
                    updateSelectedCountNotes();
                });
            });
        });
    </script>
</body>

</html>
