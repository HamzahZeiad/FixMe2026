<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuthenticityHub - Your Trusted Verification Platform</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #6a7fd0, #6bc5f3);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
            opacity: 0;
            animation: pageLoad 1s ease-in-out forwards;
        }

        /* Enhanced gradient background with moving animation */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background:
                radial-gradient(circle at 20% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(107, 197, 243, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(79, 140, 255, 0.1) 0%, transparent 50%);
            z-index: -1;
            animation: backgroundMove 20s ease-in-out infinite;
            pointer-events: none;
        }

        @keyframes backgroundMove {

            0%,
            100% {
                transform: translate(0, 0) rotate(0deg);
            }

            33% {
                transform: translate(-5%, -5%) rotate(120deg);
            }

            66% {
                transform: translate(5%, -5%) rotate(240deg);
            }
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

        /* Main Content */
        .main-content {
            margin-left: 14rem;
            margin-top: 56px;
            padding: 2rem;
            min-height: calc(100vh - 56px);
            background: transparent;
        }

        /* Hero Section */
        .hero-section {
            padding: 4rem 2rem;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .hero-content {
            max-width: 800px;
            margin: 0 auto;
            opacity: 0;
            animation: slideInUp 0.8s ease-out forwards 0.3s;
        }

        .hero-title {
            font-size: 3rem;
            font-weight: 700;
            background: linear-gradient(135deg, #ffffff, #f8fafc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .hero-subtitle {
            font-size: 1.25rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .hero-cta {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .cta-button {
            padding: 1rem 2rem;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
        }

        .cta-primary {
            background: linear-gradient(145deg, #4f8cff, #357ae8);
            color: white;
            box-shadow: 0 4px 15px rgba(79, 140, 255, 0.3);
        }

        .cta-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(79, 140, 255, 0.4);
        }

        .cta-secondary {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
        }

        .cta-secondary:hover {
            background: rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-2px);
        }

        /* Features Section */
        .features-section {
            padding: 4rem 2rem;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
        }

        .features-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .section-title {
            text-align: center;
            font-size: 2.5rem;
            font-weight: 700;
            color: white;
            margin-bottom: 3rem;
            opacity: 0;
            animation: fadeInScale 0.8s ease-out forwards 0.6s;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
            opacity: 0;
            animation: slideInUp 0.6s ease-out forwards;
        }

        .feature-card:nth-child(1) {
            animation-delay: 0.9s;
        }

        .feature-card:nth-child(2) {
            animation-delay: 1.1s;
        }

        .feature-card:nth-child(3) {
            animation-delay: 1.3s;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.5rem;
            color: white;
        }

        .feature-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #283d63;
            margin-bottom: 0.5rem;
        }

        .feature-description {
            color: #6b7280;
            line-height: 1.6;
        }

        /* Stats Section */
        .stats-section {
            padding: 4rem 2rem;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }

        .stats-container {
            max-width: 1000px;
            margin: 0 auto;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
        }

        .stat-card {
            text-align: center;
            padding: 2rem;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            opacity: 0;
            animation: fadeInScale 0.6s ease-out forwards;
        }

        .stat-card:nth-child(1) {
            animation-delay: 1.5s;
        }

        .stat-card:nth-child(2) {
            animation-delay: 1.7s;
        }

        .stat-card:nth-child(3) {
            animation-delay: 1.9s;
        }

        .stat-card:nth-child(4) {
            animation-delay: 2.1s;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: white;
            display: block;
        }

        .stat-label {
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.8);
            margin-top: 0.5rem;
        }

        /* Quick Actions */
        .quick-actions {
            padding: 4rem 2rem;
        }

        .actions-container {
            max-width: 800px;
            margin: 0 auto;
            text-align: center;
        }

        .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .action-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 16px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
            text-decoration: none;
            color: inherit;
            opacity: 0;
            animation: slideInUp 0.6s ease-out forwards;
        }

        .action-card:nth-child(1) {
            animation-delay: 2.3s;
        }

        .action-card:nth-child(2) {
            animation-delay: 2.5s;
        }

        .action-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
        }

        .action-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.25rem;
            color: white;
        }

        .action-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #283d63;
            margin-bottom: 0.5rem;
        }

        .action-description {
            color: #6b7280;
            font-size: 0.9rem;
        }

        /* Footer */
        .footer {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 2rem;
            text-align: center;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            color: rgba(255, 255, 255, 0.8);
        }

        /* Animation Keyframes */
        @keyframes pageLoad {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideInUp {
            from {
                transform: translateY(40px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2rem;
            }

            .hero-subtitle {
                font-size: 1rem;
            }

            .hero-cta {
                flex-direction: column;
                align-items: center;
            }

            .cta-button {
                width: 100%;
                max-width: 300px;
            }

            .features-grid,
            .stats-grid,
            .actions-grid {
                grid-template-columns: 1fr;
            }

            .sidebar {
                display: none;
            }

            .main-content {
                margin-left: 0;
            }

            .top-bar {
                padding: 0 1rem;
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
                    <img src="https://ui-avatars.com/api/?name=Guest&background=cccccc&color=555555" alt="Guest User">
                </div>
                <div class="user-name">Guest User</div>
            @endauth
        </div>
    </header>

    <!-- Sidebar -->
    <aside class="sidebar">
        <nav class="sidebar-nav">
            <a href="{{ route('public.user.home') }}" class="sidebar-link active">
                <i class="fas fa-home"></i>
                <span>Home</span>
            </a>

            <a href="{{ route('inquiries.index') }}" class="sidebar-link">
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

                <div style="flex:1"></div>
                <a href="{{ route('logout') }}" class="sidebar-link"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            @else
                <div style="flex:1"></div>
                <a href="{{ route('login') }}" class="sidebar-link">
                    <i class="fas fa-sign-in-alt"></i>
                    <span>Sign In</span>
                </a>
            @endauth
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="hero-content">
                <h1 class="hero-title">Welcome to AuthenticityHub</h1>
                <p class="hero-subtitle">
                    Your trusted platform for secure verification and authentication services.
                    Experience seamless, reliable, and professional verification solutions.
                </p>
                <div class="hero-cta">
                    <a href="{{ route('profile.manage') }}" class="cta-button cta-primary">
                        <i class="fas fa-user-cog"></i>
                        Manage Profile
                    </a>
                    <a href="{{ route('submit.inquiry') }}" class="cta-button cta-secondary">
                        <i class="fas fa-edit"></i>
                        Submit Your Inquiry
                    </a>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="features-section" id="services">
            <div class="features-container">
                <h2 class="section-title">Our Key Features</h2>
                <div class="features-grid">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h3 class="feature-title">Secure Verification</h3>
                        <p class="feature-description">
                            Advanced security protocols ensure your data and verification processes are completely
                            secure and encrypted.
                        </p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <h3 class="feature-title">Fast Processing</h3>
                        <p class="feature-description">
                            Quick turnaround times with automated systems that process your requests efficiently and
                            accurately.
                        </p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h3 class="feature-title">24/7 Support</h3>
                        <p class="feature-description">
                            Round-the-clock customer support to assist you with any questions or issues you may
                            encounter.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="stats-section">
            <div class="stats-container">
                <div class="stats-grid">
                    <div class="stat-card">
                        <span class="stat-number">10K+</span>
                        <span class="stat-label">Verified Users</span>
                    </div>
                    <div class="stat-card">
                        <span class="stat-number">99.9%</span>
                        <span class="stat-label">Uptime</span>
                    </div>
                    <div class="stat-card">
                        <span class="stat-number">50K+</span>
                        <span class="stat-label">Verifications</span>
                    </div>
                    <div class="stat-card">
                        <span class="stat-number">24/7</span>
                        <span class="stat-label">Support</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Quick Actions -->
        <section class="quick-actions">
            <div class="actions-container">
                <h2 class="section-title">Quick Actions</h2>
                <div class="actions-grid">
                    <a href="{{ route('profile.manage') }}" class="action-card">
                        <div class="action-icon">
                            <i class="fas fa-user-edit"></i>
                        </div>
                        <h3 class="action-title">Update Profile</h3>
                        <p class="action-description">
                            Manage your personal information and account settings
                        </p>
                    </a>
                    <a href="{{ route('password.edit') }}" class="action-card">
                        <div class="action-icon">
                            <i class="fas fa-lock"></i>
                        </div>
                        <h3 class="action-title">Security Settings</h3>
                        <p class="action-description">
                            Update your password and security preferences
                        </p>
                    </a>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <p>&copy; 2025 AuthenticityHub. All rights reserved. | Secure • Reliable • Professional</p>
        </div>
    </footer>

    <script>
        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add some interactive effects
        document.addEventListener('DOMContentLoaded', function() {
            // Parallax effect for hero section
            window.addEventListener('scroll', function() {
                const scrolled = window.pageYOffset;
                const heroSection = document.querySelector('.hero-section');
                if (heroSection) {
                    heroSection.style.transform = `translateY(${scrolled * 0.5}px)`;
                }
            });

            // Add hover effects to cards
            const cards = document.querySelectorAll('.feature-card, .action-card');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-5px) scale(1.02)';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });
        });
    </script>
</body>

</html>
;
if (heroSection) {
heroSection.style.transform = `translateY(${scrolled * 0.5}px)`;
}
});

// Add hover effects to cards
const cards = document.querySelectorAll('.feature-card, .action-card');
cards.forEach(card => {
card.addEventListener('mouseenter', function() {
this.style.transform = 'translateY(-5px) scale(1.02)';
});

card.addEventListener('mouseleave', function() {
this.style.transform = 'translateY(0) scale(1)';
});
});
});
</script>
</body>

</html>
