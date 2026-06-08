<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Dashboard - AuthenticityHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f0f0f0;
            margin: 0;
            padding: 0;
            min-height: 100vh;
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

        /* Sidebar Styling - Standardized Admin Design */
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

        /* Main Content Area */
        .content-area {
            margin-left: 14rem;
            margin-top: 56px;
            padding: 40px;
            min-height: calc(100vh - 56px);
            background: #f0f0f0;
        }

        /* Dashboard Header */
        .dashboard-header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 32px;
            margin-bottom: 32px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1), 0 8px 20px rgba(0, 0, 0, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .dashboard-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 8px;
            background: linear-gradient(135deg, #FF595A, #ff7b7c);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .dashboard-subtitle {
            font-size: 1.1rem;
            color: #718096;
            font-weight: 500;
        }

        /* Statistics Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px;
            margin-bottom: 32px;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 32px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1), 0 4px 12px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(135deg, #FF595A, #ff7b7c);
        }

        .stat-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15), 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 700;
            color: #FF595A;
            margin-bottom: 8px;
            text-shadow: 0 2px 4px rgba(255, 89, 90, 0.3);
        }

        .stat-label {
            font-size: 1.1rem;
            color: #4a5568;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-icon {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 2.5rem;
            color: rgba(255, 89, 90, 0.2);
        }

        /* Quick Actions Grid */
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 24px;
            margin-bottom: 32px;
        }

        .action-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 32px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1), 0 4px 12px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .action-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15), 0 6px 14px rgba(0, 0, 0, 0.1);
        }

        .action-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 89, 90, 0.05), transparent);
            transition: left 0.5s ease;
        }

        .action-card:hover::before {
            left: 100%;
        }

        .action-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #FF595A, #ff7b7c);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            font-size: 1.8rem;
            color: white;
            box-shadow: 0 8px 24px rgba(255, 89, 90, 0.3);
        }

        .action-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 8px;
        }

        .action-description {
            color: #718096;
            line-height: 1.6;
            font-size: 0.95rem;
        }

        /* Recent Activity Section */
        .recent-activity {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 32px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1), 0 4px 12px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .section-title i {
            color: #FF595A;
        }

        .activity-item {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 16px 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .activity-item:hover {
            background: rgba(255, 89, 90, 0.03);
            border-radius: 12px;
            padding-left: 16px;
            padding-right: 16px;
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #FF595A, #ff7b7c);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1rem;
        }

        .activity-content {
            flex: 1;
        }

        .activity-title {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 4px;
        }

        .activity-time {
            font-size: 0.85rem;
            color: #718096;
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .content-area {
                margin-left: 14rem;
                padding: 30px;
            }
        }

        @media (max-width: 900px) {
            .sidebar {
                width: 70px;
            }

            .sidebar span {
                display: none;
            }

            .content-area {
                margin-left: 70px;
            }

            .dashboard-title {
                font-size: 2rem;
            }

            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .top-bar {
                padding: 0 1rem;
                height: 56px;
            }

            .top-bar .logo {
                font-size: 1.2rem;
            }

            .user-info-topbar {
                gap: 12px;
                padding: 6px 12px;
            }

            .content-area {
                padding: 20px;
                margin-top: 56px;
            }

            .dashboard-header {
                padding: 24px;
                border-radius: 16px;
            }

            .dashboard-title {
                font-size: 1.8rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .quick-actions {
                grid-template-columns: 1fr;
                gap: 16px;
            }
        }

        @media (max-width: 480px) {
            .sidebar {
                display: none;
            }

            .content-area {
                margin-left: 0;
                padding: 16px;
            }
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInFromLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .content-area>* {
            animation: fadeInUp 0.6s ease-out;
        }

        .sidebar {
            animation: slideInFromLeft 0.5s ease-out;
        }

        .stat-card:nth-child(1) {
            animation-delay: 0.1s;
        }

        .stat-card:nth-child(2) {
            animation-delay: 0.2s;
        }

        .stat-card:nth-child(3) {
            animation-delay: 0.3s;
        }

        .stat-card:nth-child(4) {
            animation-delay: 0.4s;
        }
    </style>
</head>

<body> <!-- Top Bar -->
    <header class="top-bar">
        <div class="logo">AuthenticityHub</div>
        <div class="user-info-topbar">
            <div class="welcome">
                Welcome<br>{{ $admin->AdminName ?? 'Administrator' }}
            </div>
            <div class="user-icon">
                <i class="fas fa-user-circle"></i>
            </div>
        </div>
    </header> <!-- Sidebar -->
    <aside class="sidebar">
        <nav class="sidebar-nav">
            <a href="{{ route('admin.home') }}" class="sidebar-link active">
                <i class="fas fa-home"></i>
                <span>Home</span>
            </a>
            <a href="{{ route('admin.assign.inquiry') }}" class="sidebar-link">
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
    <div class="content-area">
        <!-- Dashboard Header -->
        <div class="dashboard-header">
            <h1 class="dashboard-title">Admin Dashboard</h1>
            <p class="dashboard-subtitle">Welcome back, {{ $admin->AdminName ?? 'Administrator' }}! Here's what's
                happening in your system today.</p>
        </div>

        <!-- Statistics Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <i class="stat-icon fas fa-clipboard-list"></i>
                <div class="stat-number">{{ $stats['total_inquiries'] }}</div>
                <div class="stat-label">Total Inquiries</div>
            </div>
            <div class="stat-card">
                <i class="stat-icon fas fa-clock"></i>
                <div class="stat-number">{{ $stats['pending_inquiries'] }}</div>
                <div class="stat-label">Pending Review</div>
            </div>
            <div class="stat-card">
                <i class="stat-icon fas fa-building"></i>
                <div class="stat-number">{{ $stats['total_agencies'] }}</div>
                <div class="stat-label">Active Agencies</div>
            </div>
            <div class="stat-card">
                <i class="stat-icon fas fa-users"></i>
                <div class="stat-number">{{ $stats['total_users'] }}</div>
                <div class="stat-label">Registered Users</div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions">
            <div class="action-card" onclick="location.href='{{ route('admin.assign.inquiry') }}'">
                <div class="action-icon">
                    <i class="fas fa-user-tie"></i>
                </div>
                <div class="action-title">Assign Inquiries</div>
                <div class="action-description">Assign pending inquiries to appropriate agencies for investigation and
                    review.</div>
            </div>

            <div class="action-card" onclick="location.href='{{ route('admin.inquiries') }}'">
                <div class="action-icon">
                    <i class="fas fa-search"></i>
                </div>
                <div class="action-title">Review Inquiries</div>
                <div class="action-description">Review and manage all submitted inquiries, update statuses, and track
                    progress.</div>
            </div>

            <div class="action-card" onclick="location.href='{{ route('admin.agency.register') }}'">
                <div class="action-icon">
                    <i class="fas fa-plus-circle"></i>
                </div>
                <div class="action-title">Register New Agency</div>
                <div class="action-description">Add new verification agencies to the system with proper credentials and
                    access.</div>
            </div>

            <div class="action-card" onclick="location.href='{{ route('admin.users') }}'">
                <div class="action-icon">
                    <i class="fas fa-cog"></i>
                </div>
                <div class="action-title">Manage Users</div>
                <div class="action-description">View, search, and manage all public users and agencies in the system.
                </div>
            </div>

            <div class="action-card" onclick="location.href='{{ route('admin.reports') }}'">
                <div class="action-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="action-title">Generate Reports</div>
                <div class="action-description">Create detailed reports on users, inquiries, and system activity for
                    analysis.</div>
            </div>

            <div class="action-card" onclick="location.href='{{ route('admin.users') }}'">
                <div class="action-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <div class="action-title">System Overview</div>
                <div class="action-description">Monitor system health, user activity, and security metrics across the
                    platform.</div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="recent-activity">
            <h2 class="section-title">
                <i class="fas fa-history"></i>
                Recent Activity
            </h2>

            @if ($recentActivities && count($recentActivities) > 0)
                @foreach ($recentActivities as $activity)
                    <div class="activity-item">
                        <div class="activity-icon">
                            <i class="fas {{ $activity['icon'] }}"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">{{ $activity['title'] }}</div>
                            <div class="activity-time">{{ $activity['time'] }}</div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <div class="activity-content">
                        <div class="activity-title">New inquiry submitted</div>
                        <div class="activity-time">2 hours ago</div>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <div class="activity-content">
                        <div class="activity-title">New agency registered</div>
                        <div class="activity-time">1 day ago</div>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <div class="activity-content">
                        <div class="activity-title">New user registered</div>
                        <div class="activity-time">2 days ago</div>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="activity-content">
                        <div class="activity-title">Inquiry verified as true</div>
                        <div class="activity-time">3 days ago</div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add loading animation
            const cards = document.querySelectorAll('.stat-card, .action-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';

                setTimeout(() => {
                    card.style.transition = 'all 0.6s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });

            // Add hover effects for action cards
            const actionCards = document.querySelectorAll('.action-card');
            actionCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.background = 'rgba(255, 255, 255, 0.98)';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.background = 'rgba(255, 255, 255, 0.95)';
                });
            });

            // Auto-refresh stats every 5 minutes
            setInterval(() => {
                // You can implement AJAX refresh here if needed
                console.log('Auto-refreshing dashboard stats...');
            }, 300000); // 5 minutes

            // Add keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                if (e.ctrlKey || e.metaKey) {
                    switch (e.key) {
                        case '1':
                            e.preventDefault();
                            location.href = '{{ route('admin.assign.inquiry') }}';
                            break;
                        case '2':
                            e.preventDefault();
                            location.href = '{{ route('admin.inquiries') }}';
                            break;
                        case '3':
                            e.preventDefault();
                            location.href = '{{ route('admin.users') }}';
                            break;
                        case '4':
                            e.preventDefault();
                            location.href = '{{ route('admin.reports') }}';
                            break;
                    }
                }
            });
        });
    </script>
</body>

</html>
break;
case '2':
e.preventDefault();
location.href = '{{ route('admin.inquiries') }}';
break;
case '3':
e.preventDefault();
location.href = '{{ route('admin.users') }}';
break;
case '4':
e.preventDefault();
location.href = '{{ route('admin.reports') }}';
break;
}
}
});
});
</script>
</body>

</html>
e.preventDefault();
location.href = '{{ route('admin.assign.inquiry') }}';
break;
case '2':
e.preventDefault();
location.href = '{{ route('admin.inquiries') }}';
break;
case '3':
e.preventDefault();
location.href = '{{ route('admin.users') }}';
break;
case '4':
e.preventDefault();
location.href = '{{ route('admin.reports') }}';
break;
}
}
});
});
</script>
</body>

</html>
':
' ' ' e.preventDefault();
location.href = '{{ route('admin.assign.inquiry') }}';
break;
case '2':
e.preventDefault();
location.href = '{{ route('admin.inquiries') }}';
break;
case '3':
e.preventDefault();
location.href = '{{ route('admin.users') }}';
break;
case '4':
e.preventDefault();
location.href = '{{ route('admin.reports') }}';
break;
}
}
});
});
</script>
</body>

</html>
