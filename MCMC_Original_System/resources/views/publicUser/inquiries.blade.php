<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Inquiries - AuthenticityHub</title>
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
        }

        .inquiry-table td {
            padding: 1rem;
            background: #f8faff;
            margin-bottom: 0.5rem;
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

        .details-button {
            background: linear-gradient(145deg, #d1d9f0, #a6b1d7);
            border-radius: 0.75rem;
            box-shadow: 4px 4px 8px #9badcd, -4px -4px 8px #ffffff;
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
        }

        .details-button:hover {
            background: linear-gradient(145deg, #c3cbea, #9badcd);
            box-shadow: 2px 2px 6px #8a9ac4, -2px -2px 6px #e5eaf8;
            transform: translateY(-2px);
        }

        .bg-blue-50 {
            background-color: #eff6ff;
        }

        .bg-blue-50:hover td {
            background-color: #dbeafe !important;
        }

        .bg-blue-100 {
            background-color: #dbeafe;
        }

        .text-blue-800 {
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
            margin-right: 2rem;
            margin-left: 0;
            position: absolute;
            left: 2rem;
        }



        .top-bar nav {
            margin-left: 2rem;
            display: flex;
            align-items: center;
            gap: 1.2rem;
            position: absolute;
            right: 2rem;
        }

        .top-bar nav a {
            color: #283d63;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }

        .top-bar nav a:hover {
            color: #0057ff;
        }

        /* Standardized Sidebar Styling */
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

        /* User info in top bar - top right */
        .user-info-topbar {
            display: flex;
            flex-direction: row-reverse;
            align-items: center;
            position: absolute;
            right: 2rem;
            top: 50%;
            transform: translateY(-50%);
        }

        .user-info-topbar .user-pic {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            overflow: hidden;
            border: 2px solid #b9c8f6;
            margin-bottom: 0;
            margin-left: 0.7rem;
            background: #f3f4f6;
        }

        .user-info-topbar .user-pic img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .user-info-topbar .user-name {
            font-size: 1rem;
            color: #283d63;
            font-weight: 600;
            text-align: right;
            max-width: 120px;
            word-break: break-all;
        }

        /* Standardized Button Styles */
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

        .btn-secondary {
            background: #283d63;
            color: white;
            border-radius: 0.75rem;
            padding: 0.75rem 1.5rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 500;
        }

        .btn-secondary:hover {
            background: #1e2f54;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(40, 61, 99, 0.3);
        }

        /* Page Load Animation */
        body {
            opacity: 0;
            animation: fadeIn 0.8s ease-in-out forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }
    </style>
</head>

<body>
    <!-- Top Bar -->
    <header class="top-bar">
        <div class="logo">AuthenticityHub</div>

        <div class="user-info-topbar">
            @auth
                <div class="user-pic">
                    @if (Auth::user()->UserProfilePicture)
                        <img src="{{ asset('storage/' . Auth::user()->UserProfilePicture) }}" alt="Profile Picture">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->UserName) }}&background=cccccc&color=555555"
                            alt="Profile Picture">
                    @endif
                </div>
                <div class="user-name">{{ Auth::user()->UserName }}</div>
            @else
                <div class="user-pic">
                    <img src="https://ui-avatars.com/api/?name=Guest&background=cccccc&color=555555" alt="Profile Picture">
                </div>
                <div class="user-name">Guest</div>
            @endauth
        </div>
    </header>

    <!-- Sidebar -->
    <aside class="sidebar">
        <nav class="sidebar-nav">
            <a href="{{ route('public.user.home') }}" class="sidebar-link">
                <i class="fas fa-home"></i>
                <span>Home</span>
            </a>
            <a href="{{ route('inquiries.index') }}" class="sidebar-link active">
                <i class="fas fa-clipboard-list"></i>
                <span>Inquiry List</span>
            </a>
            <a href="{{ route('submit.inquiry') }}" class="sidebar-link">
                <i class="fas fa-edit"></i>
                <span>Submit Inquiry</span>
            </a>
            @auth
                <a href="{{ route('manage.profile') }}" class="sidebar-link">
                    <i class="fas fa-user"></i>
                    <span>Manage Profile</span>
                </a>
            @endauth
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
            <h2 class="text-2xl font-semibold text-[#283d63] mb-6">Inquiry List</h2>

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

            <table class="inquiry-table">
                <thead>
                    <tr>
                        <th>Inquiry ID</th>
                        <th>Inquiry Title</th>
                        <th>Submission Date</th>
                        <th>Status</th>
                        <th>Assigned Agency</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($userInquiries->count() > 0)
                        @foreach ($userInquiries as $inquiry)
                            <tr class="bg-blue-50">
                                <td>
                                    <div class="flex items-center gap-2">
                                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">Your
                                            Inquiry</span>
                                        {{ $inquiry->InquiryID }}
                                    </div>
                                </td>
                                <td>{{ $inquiry->InquiryTitle }}</td>
                                <td>{{ $inquiry->InquirySendDate ? $inquiry->InquirySendDate->format('Y-m-d') : 'N/A' }}
                                </td>
                                <td>
                                    <span class="status-badge status-{{ strtolower($inquiry->InquiryStatus) }}">
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
                                    <a href="{{ route('inquiries.show', $inquiry->InquiryID) }}"
                                        class="details-button">
                                        Details
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @endif

                    @foreach ($otherInquiries as $inquiry)
                        <tr>
                            <td>{{ $inquiry->InquiryID }}</td>
                            <td>{{ $inquiry->InquiryTitle }}</td>
                            <td>{{ $inquiry->InquirySendDate ? $inquiry->InquirySendDate->format('Y-m-d') : 'N/A' }}
                            </td>
                            <td>
                                <span class="status-badge status-{{ strtolower($inquiry->InquiryStatus) }}">
                                    {{ $inquiry->InquiryStatus }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('inquiries.show', $inquiry->InquiryID) }}" class="details-button">
                                    Details
                                </a>
                            </td>
                                    Details
                                </a>
                            </td>
                        </tr>
                    @endforeach

                    @if ($userInquiries->count() == 0 && $otherInquiries->count() == 0)
                        <tr>
                            <td colspan="5" class="text-center py-8 text-gray-500">
                                No inquiries found. <a href="{{ route('submit.inquiry') }}"
                                    class="text-blue-600 hover:underline">Submit your first inquiry</a>
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
