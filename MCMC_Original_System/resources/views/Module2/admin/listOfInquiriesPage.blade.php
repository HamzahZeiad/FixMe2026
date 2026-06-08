<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Inquiries - AuthenticityHub Admin</title>
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

        .inquiry-list {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1.5rem;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 0.875rem;
            opacity: 0.9;
        }

        .inquiry-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 0.5rem;
        }

        .inquiry-table th {
            text-align: left;
            padding: 1rem;
            color: #283d63;
            font-weight: 600;
            border-bottom: 2px solid #d2dbf6;
            background: #f8faff;
        }

        .inquiry-table td {
            padding: 1rem;
            background: #f8faff;
            margin-bottom: 0.5rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .inquiry-table tr:hover td {
            background: #eef2ff;
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

        .status-resolved {
            background: #dcfce7;
            color: #15803d;
        }

        .status-progress {
            background: #dbeafe;
            color: #1e40af;
        }

        .status-rejected {
            background: #fee2e2;
            color: #dc2626;
        }

        .action-button {
            background: linear-gradient(145deg, #d1d9f0, #a6b1d7);
            border-radius: 0.5rem;
            box-shadow: 2px 2px 4px #9badcd, -2px -2px 4px #ffffff;
            color: #283d63;
            font-weight: 600;
            padding: 0.5rem 1rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
        }

        .action-button:hover {
            background: linear-gradient(145deg, #c3cbea, #9badcd);
            transform: translateY(-1px);
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

        .filter-section {
            background: #f1f5f9;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            border: 1px solid #e2e8f0;
        }

        .filter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
        }

        .filter-label {
            font-weight: 600;
            color: #283d63;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
        }

        .filter-select {
            padding: 0.5rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            background: white;
            color: #374151;
        }

        .priority-high {
            background: #fee2e2;
            border-left: 4px solid #dc2626;
        }

        .priority-medium {
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
        }

        .priority-low {
            background: #f0f9ff;
            border-left: 4px solid #3b82f6;
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
            <a href="{{ route('module2.admin.reviewInquiry') }}" class="sidebar-link">
                <i class="fas fa-search"></i>
                <span>Review Inquiry</span>
            </a>
            <a href="{{ route('module2.admin.listOfInquiries') }}" class="sidebar-link active">
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
        <div class="inquiry-list">
            <h1 class="text-2xl font-bold text-[#283d63] mb-6">List of Inquiries</h1>

            <!-- Statistics Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number">{{ $stats['total'] ?? 0 }}</div>
                    <div class="stat-label">Total Inquiries</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $stats['pending'] ?? 0 }}</div>
                    <div class="stat-label">Pending Review</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $stats['in_progress'] ?? 0 }}</div>
                    <div class="stat-label">In Progress</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $stats['resolved'] ?? 0 }}</div>
                    <div class="stat-label">Resolved</div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="filter-section">
                <h3 class="text-lg font-semibold text-[#283d63] mb-3">Filter Inquiries</h3>
                <form method="GET" action="{{ route('module2.admin.listOfInquiries') }}">
                    <div class="filter-grid">
                        <div class="filter-group">
                            <label class="filter-label">Status</label>
                            <select name="status" class="filter-select">
                                <option value="">All Statuses</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>
                        <div class="filter-group">
                            <label class="filter-label">Agency</label>
                            <select name="agency" class="filter-select">
                                <option value="">All Agencies</option>
                                @if(isset($agencies))
                                    @foreach($agencies as $agency)
                                        <option value="{{ $agency->AgencyID }}" {{ request('agency') == $agency->AgencyID ? 'selected' : '' }}>
                                            {{ $agency->AgencyName }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="filter-group">
                            <label class="filter-label">Date Range</label>
                            <select name="date_range" class="filter-select">
                                <option value="">All Time</option>
                                <option value="today" {{ request('date_range') == 'today' ? 'selected' : '' }}>Today</option>
                                <option value="week" {{ request('date_range') == 'week' ? 'selected' : '' }}>This Week</option>
                                <option value="month" {{ request('date_range') == 'month' ? 'selected' : '' }}>This Month</option>
                            </select>
                        </div>
                        <div class="filter-group">
                            <label class="filter-label">&nbsp;</label>
                            <button type="submit" class="action-button">
                                <i class="fas fa-filter"></i>
                                Apply Filters
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Inquiries Table -->
            <div class="overflow-x-auto">
                <table class="inquiry-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Submitted By</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Assigned Agency</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($inquiries) && $inquiries->count() > 0)
                            @foreach ($inquiries as $inquiry)
                                <tr class="{{ $inquiry->InquiryStatus == 'pending' ? 'priority-high' : ($inquiry->InquiryStatus == 'in_progress' ? 'priority-medium' : 'priority-low') }}">
                                    <td class="font-semibold">#{{ $inquiry->InquiryID }}</td>
                                    <td>
                                        <div class="max-w-xs">
                                            <div class="font-medium">{{ Str::limit($inquiry->InquiryTitle, 40) }}</div>
                                            <div class="text-sm text-gray-500">{{ Str::limit($inquiry->InquirySource, 30) }}</div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($inquiry->user)
                                            <div>
                                                <div class="font-medium">{{ $inquiry->user->UserName }}</div>
                                                <div class="text-sm text-gray-500">{{ $inquiry->user->UserEmail }}</div>
                                            </div>
                                        @else
                                            <span class="text-gray-400">Unknown User</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div>
                                            <div>{{ $inquiry->InquirySendDate ? $inquiry->InquirySendDate->format('M j, Y') : 'N/A' }}</div>
                                            <div class="text-sm text-gray-500">{{ $inquiry->InquirySendDate ? $inquiry->InquirySendDate->format('g:i A') : '' }}</div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="status-badge status-{{ strtolower($inquiry->InquiryStatus) }}">
                                            {{ ucfirst($inquiry->InquiryStatus) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($inquiry->agency)
                                            <div class="flex items-center gap-2">
                                                <div class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center text-white text-xs font-bold">
                                                    {{ substr($inquiry->agency->AgencyName, 0, 1) }}
                                                </div>
                                                <div class="text-sm">{{ $inquiry->agency->AgencyName }}</div>
                                            </div>
                                        @else
                                            <span class="text-gray-400 text-sm">Unassigned</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="flex gap-2">
                                            <a href="{{ route('module2.admin.reviewInquiry', $inquiry->InquiryID) }}" class="action-button">
                                                <i class="fas fa-eye"></i>
                                                Review
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="text-center py-8 text-gray-500">
                                    <div class="flex flex-col items-center gap-2">
                                        <i class="fas fa-inbox text-4xl text-gray-300"></i>
                                        <p>No inquiries found matching your criteria.</p>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if (isset($inquiries) && $inquiries->hasPages())
                <div class="mt-6">
                    {{ $inquiries->links() }}
                </div>
            @endif
        </div>
    </div>
</body>

</html>
