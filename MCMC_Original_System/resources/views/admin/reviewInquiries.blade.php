<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Inquiries - Admin Panel</title>
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
            background: #fef3c7;
            color: #d97706;
        }

        .status-verifiedastrue {
            background: #dcfce7;
            color: #15803d;
        }

        .status-identifiedasfake {
            background: #fee2e2;
            color: #dc2626;
        }

        .status-rejected {
            background: #f3f4f6;
            color: #6b7280;
        }

        .review-button {
            background: #ff3333;
            color: white;
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 500;
        }

        .review-button:hover {
            background: #e62e2e;
        }

        .reviewed-button {
            background: rgba(255, 51, 51, 0.15);
            color: #cc2828;
            border: 1px solid rgba(255, 51, 51, 0.4);
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
            opacity: 0.8;
            text-decoration: none;
            position: relative;
            overflow: hidden;
            transition: all 0.2s ease;
        }

        .reviewed-button:hover {
            opacity: 1;
            background: rgba(255, 51, 51, 0.25);
        }

        .reviewed-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }

        .reviewed-button:hover::before {
            left: 100%;
        }

        .action-button {
            background: #ff3333;
            color: white;
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 500;
            margin-left: 0.5rem;
        }

        .action-button:hover {
            background: #e62e2e;
        }

        /* Top Bar Styling */
        .top-bar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            width: 100vw;
            height: 56px;
            background: #111111;
            display: flex;
            align-items: center;
            padding: 0 1rem;
            z-index: 100;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
        }

        .top-bar .logo {
            font-weight: 700;
            font-size: 1.3rem;
            color: #ffffff;
            margin-right: 2rem;
        }

        /* Sidebar Styling - Admin Theme */
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
            box-sizing: border-box;
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

        .main-container {
            display: flex;
            width: 100vw;
            min-height: 100vh;
            position: relative;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 14rem;
            margin-top: 56px;
            padding: 2rem;
            min-height: calc(100vh - 56px);
            background: #f0f0f0;
            width: calc(100vw - 14rem);
            max-width: calc(100vw - 14rem);
            box-sizing: border-box;
            overflow-x: hidden;
        }

        /* Filter section */
        .filter-section {
            background: white;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
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
            background: white;
        }

        .filter-form button {
            background: #ff3333;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
        }

        .filter-form button:hover {
            background: #e62e2e;
        }

        .clear-button {
            background: #dddddd !important;
            color: #333 !important;
        }

        .clear-button:hover {
            background: #cccccc !important;
        }

        /* Additional layout fixes */
        .main-container * {
            box-sizing: border-box;
        }

        /* Ensure no elements exceed viewport width */
        .main-content>* {
            max-width: 100%;
        }
    </style>
</head>

<body>
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="logo">AuthenticityHub</div>
        <div class="user-info-topbar">
            <div class="welcome">
                Welcome<br>{{ DB::table('administrators')->first()->AdminName ?? 'Administrator' }}
            </div>
        </div>
    </div>

    <div class="main-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <nav class="sidebar-nav">
                <a href="{{ route('admin.home') }}" class="sidebar-link">
                    <i class="fas fa-home"></i>
                    <span>Home</span>
                </a>
                <a href="{{ route('admin.assign.inquiry') }}" class="sidebar-link">
                    <i class="fas fa-tasks"></i>
                    <span>Assign Inquiry</span>
                </a>
                <a href="{{ route('admin.inquiries') }}" class="sidebar-link active">
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
            <div class="inquiry-list">
                <h2 class="text-2xl font-semibold text-[#333] mb-6">Review Inquiries</h2>

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
                                - In Progress</option>
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

                <table class="inquiry-table">
                    <thead>
                        <tr>
                            <th>Inquiry ID</th>
                            <th>Title</th>
                            <th>Source</th>
                            <th>Submitter</th>
                            <th>Submission Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($inquiries->count() > 0)
                            @foreach ($inquiries as $inquiry)
                                <tr>
                                    <td>
                                        <span class="text-sm font-mono">#{{ $inquiry->InquiryID }}</span>
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
                                <td colspan="7" class="text-center py-8 text-gray-500">
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
</body>

</html>
