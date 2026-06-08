<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Agency Dashboard - AuthenticityHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f1e8 0%, #ede7d9 50%, #f0ebe1 100%);
            background-attachment: fixed;
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }

        /* Top Bar Styling - Enhanced with gradient and shadows */
        .top-bar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 64px;
            background: linear-gradient(135deg, #4a4237 0%, #6b6860 50%, #5d5449 100%);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            z-index: 100;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            backdrop-filter: blur(10px);
        }

        .top-bar .logo {
            font-weight: 800;
            font-size: 1.4rem;
            color: #ffffff;
            letter-spacing: 0.5px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
            background: linear-gradient(135deg, #ffffff, #f0f0f0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* User area with enhanced styling */
        .user-area {
            display: flex;
            align-items: center;
            gap: 16px;
            color: #FFFFFF;
            background: rgba(255, 255, 255, 0.1);
            padding: 8px 16px;
            border-radius: 50px;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .user-area:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-1px);
        }

        .user-area .welcome {
            text-align: right;
            line-height: 1.3;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .profile-pic-container {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            overflow: hidden;
            border: 3px solid rgba(255, 255, 255, 0.8);
            background: #F9F9F9;
            position: relative;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .profile-pic-container:hover {
            border-color: rgba(255, 255, 255, 1);
            transform: scale(1.05);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.3);
        }

        .profile-pic-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Enhanced Sidebar Styling */
        .sidebar {
            position: fixed;
            top: 64px;
            left: 0;
            width: 16rem;
            height: calc(100vh - 64px);
            background: linear-gradient(180deg, #ffffff 0%, #f8f7f4 100%);
            border-top-right-radius: 24px;
            border-bottom-right-radius: 24px;
            box-shadow:
                0 10px 30px rgba(0, 0, 0, 0.1),
                inset -1px 0 0 rgba(255, 255, 255, 0.5);
            display: flex;
            flex-direction: column;
            padding: 2rem 0;
            z-index: 99;
            backdrop-filter: blur(10px);
        }

        .sidebar-nav {
            display: flex;
            flex-direction: column;
            gap: 8px;
            padding: 0 1.5rem;
            flex: 1;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: #4a4237;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            border-radius: 12px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .sidebar-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 89, 90, 0.1), transparent);
            transition: left 0.5s ease;
        }

        .sidebar-link:hover {
            color: #FF595A;
            background: rgba(255, 89, 90, 0.08);
            transform: translateX(8px);
            box-shadow: 0 4px 12px rgba(255, 89, 90, 0.2);
        }

        .sidebar-link:hover::before {
            left: 100%;
        }

        .sidebar-link.active {
            color: #FF595A;
            background: rgba(255, 89, 90, 0.12);
            font-weight: 600;
            box-shadow: 0 4px 16px rgba(255, 89, 90, 0.25);
        }

        .sidebar-link i {
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
        }

        .logout-link {
            margin-top: auto;
            margin-bottom: 1rem;
            color: #e74c3c !important;
            background: rgba(231, 76, 60, 0.08) !important;
            border: 1px solid rgba(231, 76, 60, 0.2);
        }

        .logout-link:hover {
            color: #c0392b !important;
            background: rgba(231, 76, 60, 0.15) !important;
            border-color: rgba(231, 76, 60, 0.3);
            box-shadow: 0 4px 12px rgba(231, 76, 60, 0.3);
        }

        /* Enhanced Content Area */
        .content-area {
            margin-left: 16rem;
            margin-top: 64px;
            padding: 40px;
            background: transparent;
            min-height: calc(100vh - 64px);
        }

        /* Dashboard Grid */
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px;
            margin-bottom: 32px;
        }

        /* Stats Cards */
        .stats-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 24px;
            box-shadow:
                0 10px 30px rgba(0, 0, 0, 0.08),
                0 4px 12px rgba(0, 0, 0, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.3);
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            animation: fadeInUp 0.6s ease-out;
            animation-fill-mode: both;
        }

        .stats-card:nth-child(1) {
            animation-delay: 0.1s;
        }

        .stats-card:nth-child(2) {
            animation-delay: 0.2s;
        }

        .stats-card:nth-child(3) {
            animation-delay: 0.3s;
        }

        .stats-card:nth-child(4) {
            animation-delay: 0.4s;
        }

        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--card-color);
            border-radius: 20px 20px 0 0;
        }

        .stats-card:hover {
            transform: translateY(-8px);
            box-shadow:
                0 20px 40px rgba(0, 0, 0, 0.12),
                0 8px 16px rgba(0, 0, 0, 0.08);
        }

        .stats-card .icon {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            margin-bottom: 16px;
            background: var(--card-color);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .stats-card .number {
            font-size: 2.5rem;
            font-weight: 800;
            color: #2d3748;
            margin-bottom: 8px;
            line-height: 1;
        }

        .stats-card .label {
            font-size: 0.95rem;
            color: #718096;
            font-weight: 500;
            margin-bottom: 12px;
        }

        .stats-card .change {
            font-size: 0.875rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .stats-card.total-inquiries {
            --card-color: #3182ce;
        }

        .stats-card.under-investigation {
            --card-color: #f56500;
        }

        .stats-card.verified-true {
            --card-color: #38a169;
        }

        .stats-card.identified-fake {
            --card-color: #e53e3e;
        }

        /* Welcome Section */
        .welcome-section {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 40px;
            margin-bottom: 32px;
            box-shadow:
                0 20px 60px rgba(0, 0, 0, 0.1),
                0 8px 20px rgba(0, 0, 0, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.3);
            position: relative;
            overflow: hidden;
            animation: fadeInUp 0.8s ease-out;
        }

        .welcome-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.8), transparent);
        }

        .welcome-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: #2d3748;
            margin-bottom: 12px;
            background: linear-gradient(135deg, #4a4237, #FF595A);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .welcome-subtitle {
            font-size: 1.1rem;
            color: #718096;
            margin-bottom: 24px;
            line-height: 1.6;
        }

        .current-time {
            font-size: 0.95rem;
            color: #a0aec0;
            font-weight: 500;
        }

        /* Quick Actions */
        .quick-actions {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 32px;
            margin-bottom: 32px;
            box-shadow:
                0 20px 60px rgba(0, 0, 0, 0.1),
                0 8px 20px rgba(0, 0, 0, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.3);
            animation: fadeInUp 1s ease-out;
        }

        .quick-actions h3 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
        }

        .action-btn {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px 20px;
            background: linear-gradient(135deg, #FF595A 0%, #ff7b7c 100%);
            color: white;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(255, 89, 90, 0.3);
            position: relative;
            overflow: hidden;
        }

        .action-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s ease;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 89, 90, 0.4);
        }

        .action-btn:hover::before {
            left: 100%;
        }

        .action-btn.secondary {
            background: linear-gradient(135deg, #e2e8f0, #cbd5e0);
            color: #4a5568;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .action-btn.secondary:hover {
            background: linear-gradient(135deg, #cbd5e0, #a0aec0);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        /* Chart Container */
        .chart-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 32px;
            box-shadow:
                0 20px 60px rgba(0, 0, 0, 0.1),
                0 8px 20px rgba(0, 0, 0, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.3);
            animation: fadeInUp 1.2s ease-out;
        }

        .chart-container h3 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
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

        .sidebar {
            animation: slideInFromLeft 0.5s ease-out;
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .content-area {
                margin-left: 16rem;
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

            .dashboard-grid {
                grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
                gap: 16px;
            }
        }

        @media (max-width: 768px) {
            .top-bar {
                padding: 0 1rem;
                height: 60px;
            }

            .top-bar .logo {
                font-size: 1.2rem;
            }

            .user-area {
                gap: 12px;
                padding: 6px 12px;
            }

            .profile-pic-container {
                width: 38px;
                height: 38px;
            }

            .content-area {
                padding: 20px;
                margin-top: 60px;
            }

            .welcome-title {
                font-size: 2rem;
            }

            .dashboard-grid {
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

            .welcome-section,
            .quick-actions,
            .chart-container {
                padding: 24px;
            }
        }
    </style>
</head>

<body>
    <!-- Top Bar -->
    <header class="top-bar">
        <div class="logo">AuthenticityHub</div>
        <div class="user-area">
            <div class="welcome">
                <div>{{ $agency->AgencyName ?? 'Agency' }}</div>
                <div style="font-size: 0.75rem; opacity: 0.8;">Welcome Back</div>
            </div>
            <div class="profile-pic-container">
                @if (isset($agency) && $agency->AgencyProfilePicture)
                    <img src="{{ asset('storage/' . $agency->AgencyProfilePicture) }}" alt="Profile Picture">
                @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($agency->AgencyName ?? 'Agency') }}&background=eeeeee&color=666666"
                        alt="Profile Picture">
                @endif
            </div>
        </div>
    </header>

    <!-- Sidebar -->
    <aside class="sidebar">
        <nav class="sidebar-nav">
            <a href="#" class="sidebar-link active"><i class="fas fa-home"></i> <span>Home</span></a>
            <a href="{{ route('agency.profile') }}" class="sidebar-link"><i class="fas fa-cog"></i>
                <span>Profile</span></a>
            <a href="{{ route('agency.security') }}" class="sidebar-link"><i class="fas fa-shield-alt"></i>
                <span>Security</span></a>
            <a href="{{ route('agency.view.display.inquiry') }}" class="sidebar-link"><i class="far fa-clipboard"></i>
                <span>Display and Approved</span></a>
            <a href="{{ route('login') }}" class="sidebar-link logout-link"><i class="fas fa-sign-out-alt"></i>
                <span>Logout</span></a>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="content-area">
        <!-- Welcome Section -->
        <div class="welcome-section">
            <h1 class="welcome-title">Welcome back, {{ $agency->AgencyName ?? 'Agency' }}!</h1>
            <p class="welcome-subtitle">
                Manage your inquiries, track verification progress, and maintain the integrity of information in your
                assigned cases.
            </p>
            <div class="current-time">
                <i class="fas fa-clock"></i>
                Today is <span id="current-date"></span>
            </div>
        </div>

        <!-- Statistics Dashboard -->
        <div class="dashboard-grid">
            <div class="stats-card total-inquiries">
                <div class="icon">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <div class="number">{{ $statusCounts['total'] ?? 0 }}</div>
                <div class="label">Total Inquiries</div>
                <div class="change" style="color: #3182ce;">
                    <i class="fas fa-arrow-up"></i>
                    All assigned cases
                </div>
            </div>

            <div class="stats-card under-investigation">
                <div class="icon">
                    <i class="fas fa-search"></i>
                </div>
                <div class="number">{{ $statusCounts['under_investigation'] ?? 0 }}</div>
                <div class="label">Under Investigation</div>
                <div class="change" style="color: #f56500;">
                    <i class="fas fa-clock"></i>
                    Pending review
                </div>
            </div>

            <div class="stats-card verified-true">
                <div class="icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="number">{{ $statusCounts['verified_true'] ?? 0 }}</div>
                <div class="label">Verified as True</div>
                <div class="change" style="color: #38a169;">
                    <i class="fas fa-arrow-up"></i>
                    Authentic content
                </div>
            </div>

            <div class="stats-card identified-fake">
                <div class="icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="number">{{ $statusCounts['identified_fake'] ?? 0 }}</div>
                <div class="label">Identified as Fake</div>
                <div class="change" style="color: #e53e3e;">
                    <i class="fas fa-shield-alt"></i>
                    Misinformation detected
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions">
            <h3>
                <i class="fas fa-bolt" style="color: #FF595A;"></i>
                Quick Actions
            </h3>
            <div class="actions-grid">
                <a href="{{ route('agency.view.display.inquiry') }}" class="action-btn">
                    <i class="fas fa-list"></i>
                    View All Inquiries
                </a>
                <a href="{{ route('agency.profile') }}" class="action-btn secondary">
                    <i class="fas fa-user-edit"></i>
                    Update Profile
                </a>
                <a href="{{ route('agency.security') }}" class="action-btn secondary">
                    <i class="fas fa-key"></i>
                    Security Settings
                </a>
            </div>
        </div>

        <!-- Statistics Chart -->
        <div class="chart-container">
            <h3>
                <i class="fas fa-chart-bar" style="color: #FF595A;"></i>
                Inquiry Status Overview
            </h3>
            <div style="position: relative; height: 300px;">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Update current date
            const currentDate = new Date().toLocaleDateString('en-US', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
            document.getElementById('current-date').textContent = currentDate;

            // Initialize Chart
            const ctx = document.getElementById('statusChart').getContext('2d');
            const statusChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Total Inquiries', 'Under Investigation', 'Verified as True',
                        'Identified as Fake'
                    ],
                    datasets: [{
                        data: [
                            {{ $statusCounts['total'] ?? 0 }},
                            {{ $statusCounts['under_investigation'] ?? 0 }},
                            {{ $statusCounts['verified_true'] ?? 0 }},
                            {{ $statusCounts['identified_fake'] ?? 0 }}
                        ],
                        backgroundColor: [
                            '#3182ce',
                            '#f56500',
                            '#38a169',
                            '#e53e3e'
                        ],
                        borderWidth: 3,
                        borderColor: '#ffffff',
                        hoverBorderWidth: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                font: {
                                    family: 'Poppins',
                                    size: 14,
                                    weight: '500'
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            titleFont: {
                                family: 'Poppins',
                                size: 14,
                                weight: '600'
                            },
                            bodyFont: {
                                family: 'Poppins',
                                size: 13
                            },
                            cornerRadius: 8,
                            displayColors: true
                        }
                    },
                    animation: {
                        animateRotate: true,
                        animateScale: true,
                        duration: 1000,
                        easing: 'easeOutQuart'
                    }
                }
            });

            // Add hover animations to stats cards
            const statsCards = document.querySelectorAll('.stats-card');
            statsCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-8px) scale(1.02)';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });

            // Add floating animation to cards on scroll
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.transform = 'translateY(0)';
                        entry.target.style.opacity = '1';
                    }
                });
            }, observerOptions);

            // Observe all animated elements
            document.querySelectorAll('.welcome-section, .stats-card, .quick-actions, .chart-container').forEach(
                el => {
                    observer.observe(el);
                });

            // Add real-time updates (simulate)
            setInterval(function() {
                const timeElement = document.getElementById('current-date');
                const now = new Date().toLocaleDateString('en-US', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
                timeElement.textContent = now;
            }, 60000); // Update every minute
        });
    </script>
</body>

</html>
