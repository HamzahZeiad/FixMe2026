<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Admin panel for viewing agency profile details in the AuthenticityHub system" />
    <meta name="keywords" content="admin, agency, profile, view, management, authenticity" />
    <meta name="author" content="AuthenticityHub" />
    <title>Admin – View Agency Profile | AuthenticityHub</title>

    <!-- Preconnect to external resources -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">

    <!-- External resources -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        crossorigin="anonymous" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />
    <style>
        :root {
            --primary-color: #6366f1;
            --primary-dark: #4f46e5;
            --secondary-color: #f8fafc;
            --accent-color: #10b981;
            --success-color: #059669;
            --danger-color: #dc2626;
            --warning-color: #d97706;
            --text-primary: #111827;
            --text-secondary: #6b7280;
            --border-color: #e5e7eb;
            --card-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            --hover-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f0f0f0;
            color: var(--text-primary);
            line-height: 1.6;
        }

        .admin-container {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 280px;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            padding: 2rem 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.1);
        }

        .main-content {
            margin-left: 280px;
            flex: 1;
            padding: 2rem;
            background: #f8fafc;
            min-height: 100vh;
        }

        .profile-header {
            display: flex;
            align-items: center;
            margin-bottom: 2rem;
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
        }

        .profile-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent-color), var(--primary-color));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            font-weight: 600;
            margin-right: 1.5rem;
        }

        .profile-info h1 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .profile-info .subtitle {
            color: var(--text-secondary);
            font-size: 1rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            text-align: center;
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--accent-color);
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: var(--text-secondary);
            font-size: 0.9rem;
            font-weight: 500;
        }

        .info-section {
            background: white;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            margin-bottom: 2rem;
        }

        .section-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border-color);
            font-weight: 600;
            font-size: 1.1rem;
        }

        .section-content {
            padding: 1.5rem;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .info-item {
            display: flex;
            flex-direction: column;
        }

        .info-label {
            font-weight: 500;
            color: var(--text-secondary);
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .info-value {
            font-weight: 600;
            color: var(--text-primary);
        }

        .inquiry-list {
            list-style: none;
        }

        .inquiry-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        .inquiry-item:last-child {
            border-bottom: none;
        }

        .inquiry-title {
            font-weight: 600;
            color: var(--text-primary);
        }

        .inquiry-date {
            color: var(--text-secondary);
            font-size: 0.9rem;
        }

        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-completed {
            background: #d1fae5;
            color: #065f46;
        }

        .status-in-progress {
            background: #dbeafe;
            color: #1e40af;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: #e5e7eb;
            color: var(--text-primary);
        }

        .btn-secondary:hover {
            background: #d1d5db;
        }

        .sidebar-nav {
            list-style: none;
            padding: 0 1rem;
        }

        .sidebar-nav li {
            margin-bottom: 0.5rem;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .sidebar-nav a:hover,
        .sidebar-nav a.active {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .sidebar-nav i {
            margin-right: 0.75rem;
            width: 20px;
        }
    </style>
</head>

<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div style="padding: 0 2rem; margin-bottom: 2rem;">
                <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 0.5rem;">Admin Panel</h2>
                <p style="opacity: 0.8; font-size: 0.9rem;">AuthenticityHub</p>
            </div>

            <ul class="sidebar-nav">
                <li><a href="{{ route('admin.home') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="{{ route('admin.users') }}" class="active"><i class="fas fa-users"></i> Users & Agencies</a></li>
                <li><a href="{{ route('admin.inquiries') }}"><i class="fas fa-envelope"></i> Inquiries</a></li>
                <li><a href="{{ route('admin.assign.inquiry') }}"><i class="fas fa-tasks"></i> Assign Inquiries</a></li>
                <li><a href="{{ route('admin.reports') }}"><i class="fas fa-chart-bar"></i> Reports</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Back Navigation -->
            <div style="margin-bottom: 1.5rem;">
                <a href="{{ route('admin.users') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left" style="margin-right: 0.5rem;"></i>
                    Back to Users & Agencies
                </a>
            </div>

            <!-- Profile Header -->
            <div class="profile-header">
                <div class="profile-avatar">
                    <i class="fas fa-building"></i>
                </div>
                <div class="profile-info">
                    <h1>{{ $agency->AgencyName ?? 'Unknown Agency' }}</h1>
                    <p class="subtitle">Agency • Member since {{ $stats['member_since'] }}</p>
                </div>
            </div>

            <!-- Statistics -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number">{{ $stats['total_assigned'] }}</div>
                    <div class="stat-label">Total Assigned</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $stats['pending_inquiries'] }}</div>
                    <div class="stat-label">Pending Inquiries</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $stats['in_progress'] }}</div>
                    <div class="stat-label">In Progress</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $stats['completed_inquiries'] }}</div>
                    <div class="stat-label">Completed</div>
                </div>
            </div>

            <!-- Agency Information -->
            <div class="info-section">
                <div class="section-header">
                    <i class="fas fa-building" style="margin-right: 0.5rem;"></i>
                    Agency Information
                </div>
                <div class="section-content">
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">Agency Name</div>
                            <div class="info-value">{{ $agency->AgencyName ?? 'Not provided' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Email Address</div>
                            <div class="info-value">{{ $agency->AgencyEmail ?? 'Not provided' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Username</div>
                            <div class="info-value">{{ $agency->AgencyUserName ?? 'Not provided' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Phone Number</div>
                            <div class="info-value">{{ $agency->AgencyPhoneNum ?? 'Not provided' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Agency Type</div>
                            <div class="info-value">{{ $agency->AgencyType ?? 'Not specified' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Account Status</div>
                            <div class="info-value">
                                <span class="status-badge status-completed">Active</span>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Registration Date</div>
                            <div class="info-value">{{ $agency->created_at ? $agency->created_at->format('M d, Y') : 'Unknown' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Last Updated</div>
                            <div class="info-value">{{ $agency->updated_at ? $agency->updated_at->format('M d, Y') : 'Unknown' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Assigned Inquiries -->
            <div class="info-section">
                <div class="section-header">
                    <i class="fas fa-clipboard-list" style="margin-right: 0.5rem;"></i>
                    Recent Assigned Inquiries
                </div>
                <div class="section-content">
                    @if($inquiries && $inquiries->count() > 0)
                        <ul class="inquiry-list">
                            @foreach($inquiries as $inquiry)
                                <li class="inquiry-item">
                                    <div>
                                        <div class="inquiry-title">{{ $inquiry->InquiryTitle ?? 'No Title' }}</div>
                                        <div class="inquiry-date">{{ $inquiry->created_at ? $inquiry->created_at->format('M d, Y') : 'Unknown date' }}</div>
                                    </div>
                                    <div>
                                        @php
                                            $statusClass = 'status-pending';
                                            if ($inquiry->InquiryStatus === 'completed') {
                                                $statusClass = 'status-completed';
                                            } elseif (in_array($inquiry->InquiryStatus, ['assigned', 'in-progress'])) {
                                                $statusClass = 'status-in-progress';
                                            }
                                        @endphp
                                        <span class="status-badge {{ $statusClass }}">
                                            {{ ucfirst($inquiry->InquiryStatus ?? 'pending') }}
                                        </span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p style="color: var(--text-secondary); text-align: center; padding: 2rem;">
                            <i class="fas fa-inbox" style="font-size: 2rem; margin-bottom: 1rem; display: block;"></i>
                            No inquiries assigned to this agency yet.
                        </p>
                    @endif
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="{{ route('admin.agency.edit', $agency->AgencyID) }}" class="btn btn-primary">
                    <i class="fas fa-edit" style="margin-right: 0.5rem;"></i>
                    Edit Agency
                </a>
                <a href="{{ route('admin.users') }}" class="btn btn-secondary">
                    <i class="fas fa-list" style="margin-right: 0.5rem;"></i>
                    Back to Users & Agencies
                </a>
            </div>
        </div>
    </div>
</body>

</html>
