<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inquiry Details - Admin Panel</title>
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

        .inquiry-details {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .detail-group {
            margin-bottom: 2rem;
        }

        .detail-label {
            color: #333;
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-size: 1.1rem;
        }

        .detail-value {
            background: #fafafa;
            padding: 1rem;
            border-radius: 8px;
            color: #555;
            border: 1px solid #eee;
        }

        .evidence-file {
            display: flex;
            align-items: center;
            gap: 1rem;
            background: #fafafa;
            padding: 1rem;
            border-radius: 8px;
            border: 1px solid #eee;
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

        .sidebar-link svg {
            width: 1.2rem;
            height: 1.2rem;
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

        /* Buttons */
        .btn-secondary {
            background: #dddddd;
            color: #333;
            border: 1px solid #ccc;
            border-radius: 0.5rem;
            padding: 0.75rem 1.5rem;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 500;
        }

        .btn-secondary:hover {
            background: #cccccc;
            border-color: #bbb;
        }

        .btn-primary {
            background: #ff3333;
            color: white;
            border-radius: 0.5rem;
            padding: 0.75rem 1.5rem;
            border: none;
            cursor: pointer;
            transition: background-color 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 500;
        }

        .btn-primary:hover {
            background: #e62e2e;
        }

        /* Status Update Form */
        .status-form {
            background: #fafafa;
            border: 1px solid #eee;
            border-radius: 8px;
            padding: 1.5rem;
            margin-top: 2rem;
        }

        .status-form select,
        .status-form textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-top: 0.5rem;
        }

        .status-form label {
            color: #333;
            font-weight: 600;
            display: block;
            margin-bottom: 0.5rem;
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
            <div class="welcome">Welcome<br>{{ DB::table('administrators')->first()->AdminName ?? 'Administrator' }}
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
            <div class="flex space-x-4 mb-4">
                <a href="{{ route('admin.inquiries') }}" class="btn-secondary">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                            clip-rule="evenodd" />
                    </svg>
                    <span>Back to Inquiries</span>
                </a>
            </div>

            <div class="inquiry-details">
                <h2 class="text-2xl font-semibold text-[#333] mb-6">Inquiry Details - Admin Review</h2>

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

                <div class="detail-group">
                    <div class="detail-label">Inquiry ID</div>
                    <div class="detail-value">#{{ $inquiry->InquiryID }}</div>
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
                    <div class="detail-label">Submitter Information</div>
                    <div class="detail-value">
                        @if ($inquiry->UserID)
                            @php
                                $user = \App\Models\PublicUser::find($inquiry->UserID);
                            @endphp
                            <strong>User:</strong> {{ $user ? $user->UserName : 'User not found' }}<br>
                            <strong>Email:</strong> {{ $user ? $user->UserEmail : 'N/A' }}<br>
                            <strong>User ID:</strong> #{{ $inquiry->UserID }}
                        @else
                            <span class="text-gray-500">Anonymous submission</span>
                        @endif
                    </div>
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
                            <svg class="w-8 h-8 text-[#333]" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"
                                    clip-rule="evenodd" />
                            </svg>
                            <a href="{{ asset('storage/' . $inquiry->InquiryEvidence) }}"
                                class="text-red-600 hover:underline font-medium" target="_blank">
                                View Evidence Document
                            </a>
                        </div>
                    </div>
                @endif

                <div class="detail-group">
                    <div class="detail-label">Current Status</div>
                    <div class="status-badge status-{{ strtolower(str_replace(' ', '', $inquiry->InquiryStatus)) }}">
                        {{ $inquiry->InquiryStatus }}
                    </div>
                </div>

                @if ($inquiry->VerificationDescription)
                    <div class="detail-group">
                        <div class="detail-label">Admin Verification Notes</div>
                        <div class="detail-value">{{ $inquiry->VerificationDescription }}</div>
                    </div>
                @endif

                <!-- Status Update Form -->
                <div class="status-form">
                    <h3 class="text-lg font-semibold text-[#333] mb-4">Update Inquiry Status</h3>

                    <form method="POST" action="{{ route('admin.inquiry.update.status', $inquiry->InquiryID) }}">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="status">Status</label>
                            <select name="status" id="status" required>
                                <option value="Pending"
                                    {{ $inquiry->InquiryStatus == 'Pending' ? 'selected' : '' }}>Pending - Awaiting
                                    Review</option>
                                <option value="Under Investigation"
                                    {{ $inquiry->InquiryStatus == 'Under Investigation' ? 'selected' : '' }}>Under
                                    Investigation - In Progress</option>
                                <option value="Verified as True"
                                    {{ $inquiry->InquiryStatus == 'Verified as True' ? 'selected' : '' }}>Verified
                                    as True - Confirmed as genuine news</option>
                                <option value="Identified as Fake"
                                    {{ $inquiry->InquiryStatus == 'Identified as Fake' ? 'selected' : '' }}>
                                    Identified as Fake - False or misleading information</option>
                                <option value="Rejected"
                                    {{ $inquiry->InquiryStatus == 'Rejected' ? 'selected' : '' }}>Rejected -
                                    Declined due to lack of jurisdiction</option>
                            </select>
                        </div>

                        <div class="mt-4">
                            <label for="verification_description">Admin Notes / Verification Description</label>
                            <textarea name="verification_description" id="verification_description" rows="4"
                                placeholder="Add detailed notes about your investigation findings, verification process, or reasons for the status change...">{{ $inquiry->VerificationDescription }}</textarea>
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="btn-primary">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                Update Status
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
