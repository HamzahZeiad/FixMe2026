<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inquiry Details - AuthenticityHub</title>
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

        .inquiry-details {
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

        .evidence-file {
            display: flex;
            align-items: center;
            gap: 1rem;
            background: #f8faff;
            padding: 1rem;
            border-radius: 8px;
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
            <a href="{{ route('module2.publicUser.listOfInquiries') }}" class="sidebar-link">
                <i class="fas fa-clipboard-list"></i>
                <span>List of Inquiries</span>
            </a>
            <a href="{{ route('module2.publicUser.submitInquiryForm') }}" class="sidebar-link">
                <i class="fas fa-edit"></i>
                <span>Submit Inquiry Form</span>
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
        <div class="inquiry-details">
            <!-- Navigation Button -->
            <div class="mb-4">
                <a href="{{ route('module2.publicUser.listOfInquiries') }}" class="btn-primary">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back to List of Inquiries</span>
                </a>
            </div>

            <h2 class="text-2xl font-semibold text-[#283d63] mb-6">Inquiry Details</h2>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if (isset($inquiry))
                <div class="detail-group">
                    <div class="detail-label">Inquiry ID</div>
                    <div class="detail-value">{{ $inquiry->InquiryID }}</div>
                </div>

                <div class="detail-group">
                    <div class="detail-label">Inquiry Title</div>
                    <div class="detail-value">{{ $inquiry->InquiryTitle }}</div>
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

                @if ($inquiry->InquiryEvidence)
                    <div class="detail-group">
                        <div class="detail-label">Supporting Document</div>
                        <div class="evidence-file">
                            <svg class="w-8 h-8 text-[#283d63]" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"
                                    clip-rule="evenodd" />
                            </svg>
                            <a href="{{ asset('storage/' . $inquiry->InquiryEvidence) }}"
                                class="text-blue-600 hover:underline" target="_blank">
                                View Document
                            </a>
                        </div>
                    </div>
                @endif

                <div class="detail-group">
                    <div class="detail-label">Status</div>
                    <div class="status-badge status-{{ strtolower($inquiry->InquiryStatus) }}">
                        {{ $inquiry->InquiryStatus }}
                    </div>
                </div>

                <!-- Assignment Information -->
                <div class="detail-group">
                    <div class="detail-label">Assigned Agency</div>
                    <div class="detail-value">
                        @if ($inquiry->AgencyID && $inquiry->agency)
                            <div class="flex items-center gap-3 mb-3">
                                @if($inquiry->agency->AgencyProfilePicture)
                                    <img src="{{ asset('storage/' . $inquiry->agency->AgencyProfilePicture) }}"
                                         alt="{{ $inquiry->agency->AgencyName }}"
                                         class="w-10 h-10 rounded-full object-cover">
                                @else
                                    <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-semibold">
                                        {{ substr($inquiry->agency->AgencyName, 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <div class="font-semibold text-[#283d63]">{{ $inquiry->agency->AgencyName }}</div>
                                    <div class="text-sm text-gray-600">{{ $inquiry->agency->AgencyEmail }}</div>
                                </div>
                            </div>
                        @else
                            <div class="text-amber-700 bg-amber-50 p-3 rounded-lg border border-amber-200">
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="font-medium">No agency assigned yet</span>
                                </div>
                                <div class="text-sm mt-1">Your inquiry is pending review and agency assignment</div>
                            </div>
                        @endif
                    </div>
                </div>

                @if ($inquiry->VerificationDescription)
                    <div class="detail-group">
                        <div class="detail-label">Verification Notes</div>
                        <div class="detail-value">{{ $inquiry->VerificationDescription }}</div>
                    </div>
                @endif

                @if (Auth::check() && $inquiry->UserID === Auth::id())
                    <div class="detail-group">
                        <div class="detail-label">Owner</div>
                        <div class="detail-value">
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm">Your Inquiry</span>
                        </div>
                    </div>
                @endif
            @else
                <div class="text-center py-8 text-gray-500">
                    <p>Inquiry not found.</p>
                    <a href="{{ route('module2.publicUser.listOfInquiries') }}" class="text-blue-600 hover:underline">
                        Back to List of Inquiries
                    </a>
                </div>
            @endif
        </div>
    </div>
</body>

</html>
