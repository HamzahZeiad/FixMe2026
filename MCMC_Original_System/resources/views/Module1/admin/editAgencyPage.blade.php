<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Admin panel for editing agency profile details in the AuthenticityHub system" />
    <meta name="keywords" content="admin, agency, profile, edit, management, authenticity" />
    <meta name="author" content="AuthenticityHub" />
    <title>Admin – Edit Agency Profile | AuthenticityHub</title>

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
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
            color: var(--text-primary);
        }

        /* Beautiful Animated Background Elements */
        .bg-elements {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            overflow: hidden;
            pointer-events: none;
        }

        /* Floating Geometric Shapes */
        .bg-elements::before {
            content: '';
            position: absolute;
            top: -10%;
            left: -10%;
            width: 120%;
            height: 120%;
            background-image:
                radial-gradient(circle at 20px 20px, rgba(200, 200, 200, 0.2) 2px, transparent 2px),
                radial-gradient(circle at 60px 60px, rgba(180, 180, 180, 0.15) 1px, transparent 1px);
            background-size: 80px 80px, 120px 120px;
            animation: floatPattern 35s linear infinite;
        }

        /* Moving Gradient Orbs */
        .bg-elements::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background:
                radial-gradient(circle at 25% 25%, rgba(220, 220, 220, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(200, 200, 200, 0.25) 0%, transparent 50%),
                radial-gradient(circle at 50% 80%, rgba(190, 190, 190, 0.2) 0%, transparent 50%);
            animation: moveOrbs 25s ease-in-out infinite alternate;
        }

        @keyframes floatPattern {
            0% {
                transform: translate(0, 0) rotate(0deg);
                opacity: 0.3;
            }

            50% {
                opacity: 0.5;
            }

            100% {
                transform: translate(-80px, -80px) rotate(360deg);
                opacity: 0.3;
            }
        }

        @keyframes moveOrbs {
            0% {
                transform: translate(0, 0) scale(1);
                opacity: 0.3;
            }

            25% {
                transform: translate(15px, -25px) scale(1.05);
                opacity: 0.5;
            }

            50% {
                transform: translate(-10px, -50px) scale(0.95);
                opacity: 0.4;
            }

            75% {
                transform: translate(-25px, -15px) scale(1.02);
                opacity: 0.6;
            }

            100% {
                transform: translate(5px, 5px) scale(1);
                opacity: 0.3;
            }
        }

        @keyframes slideInUp {
            from {
                transform: translateY(30px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
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

        .main-content {
            margin-left: 14rem;
            margin-top: 56px;
            padding: 2rem;
            min-height: calc(100vh - 56px);
            background: #f0f0f0;
            position: relative;
            z-index: 2;
            animation: fadeIn 0.6s ease-out;
        }

        .edit-container {
            max-width: 700px;
            margin: 2rem auto;
            background: white;
            border-radius: 20px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
            animation: slideInUp 0.6s ease-out;
            position: relative;
            z-index: 2;
        }

        .edit-header {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            padding: 2rem;
            text-align: center;
            position: relative;
        }

        .edit-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }

        .edit-header .content {
            position: relative;
            z-index: 2;
        }

        .edit-title {
            font-size: 2.25rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .edit-subtitle {
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-weight: 600;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .edit-content {
            padding: 3rem;
        }

        /* Section Header Styles */
        .section-header {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            margin-bottom: 3rem;
            padding: 1.5rem;
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.1), rgba(217, 119, 6, 0.1));
            border-radius: 16px;
            border: 1px solid rgba(245, 158, 11, 0.2);
        }

        .section-icon {
            width: 4rem;
            height: 4rem;
            background: linear-gradient(135deg, #f59e0b, #d97706);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
        }

        .section-info {
            flex: 1;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        .section-description {
            color: var(--text-secondary);
            font-size: 0.95rem;
            font-weight: 500;
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

        /* Enhanced Form styling */
        .form-group {
            margin-bottom: 2rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.75rem;
            font-weight: 600;
            color: var(--text-secondary);
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .form-group input {
            width: 100%;
            padding: 1rem 1.25rem;
            border: 2px solid var(--border-color);
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 500;
            background: rgba(255, 255, 255, 0.8);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            color: var(--text-primary);
        }

        .form-group input::placeholder {
            color: #9ca3af;
            font-weight: 400;
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
            background: rgba(255, 255, 255, 0.95);
            transform: translateY(-1px);
        }

        .form-group input:hover {
            border-color: #d1d5db;
        }

        /* Enhanced Button Styles */
        .btn {
            padding: 0.875rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            white-space: nowrap;
            font-size: 0.95rem;
            letter-spacing: 0.025em;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background: linear-gradient(145deg, var(--primary-color), var(--primary-dark));
            color: white;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }

        .btn-primary:hover {
            background: linear-gradient(145deg, var(--primary-dark), #3730a3);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-secondary {
            background: linear-gradient(145deg, #6b7280, #4b5563);
            color: white;
            box-shadow: 0 4px 12px rgba(107, 114, 128, 0.2);
        }

        .btn-secondary:hover {
            background: linear-gradient(145deg, #4b5563, #374151);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(107, 114, 128, 0.3);
        }

        .btn-secondary:active {
            transform: translateY(0);
        }

        .form-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid var(--border-color);
        }

        /* Error Messages */
        .error-message {
            color: var(--danger-color);
            font-size: 0.875rem;
            margin-top: 0.5rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .error-message::before {
            content: '⚠️';
            font-size: 0.75rem;
        }

        /* Success Messages */
        .success-toast {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: linear-gradient(135deg, var(--success-color), var(--accent-color));
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(5, 150, 105, 0.3);
            z-index: 1000;
            animation: slideInUp 0.5s ease-out;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .success-toast::before {
            content: '✓';
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            width: 1.5rem;
            height: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        /* Mobile Menu Toggle */
        .mobile-menu-toggle {
            display: none;
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0.5rem;
            margin-right: 1rem;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .main-content {
                margin-left: 12rem;
                padding: 1.5rem;
            }

            .sidebar {
                width: 12rem;
            }

            .edit-container {
                margin: 1rem auto;
            }

            .edit-content {
                padding: 2rem;
            }
        }

        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                margin-top: 56px;
                padding: 1rem;
            }

            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar.mobile-open {
                transform: translateX(0);
            }

            .edit-container {
                margin: 0.5rem;
                border-radius: 16px;
            }

            .edit-content {
                padding: 1.5rem;
            }

            .edit-title {
                font-size: 1.75rem;
            }

            .form-footer {
                flex-direction: column;
                gap: 1rem;
            }

            .mobile-menu-toggle {
                display: block;
            }

            /* Section header responsive */
            .section-header {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
                padding: 1rem;
                margin-bottom: 2rem;
            }

            .section-icon {
                width: 3rem;
                height: 3rem;
                font-size: 1.25rem;
            }

            .section-title {
                font-size: 1.25rem;
            }
        }

        @media (max-width: 480px) {
            .edit-content {
                padding: 1rem;
            }

            .edit-title {
                font-size: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <!-- Animated Background Elements -->
    <div class="bg-elements"></div>

    <!-- Top Bar -->
    <header class="top-bar">
        <button class="mobile-menu-toggle" onclick="toggleMobileMenu()">
            <i class="fas fa-bars"></i>
        </button>
        <div class="logo">AuthenticityHub</div>
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
    <aside class="sidebar" id="sidebar">
        <nav class="sidebar-nav">
            <a href="{{ route('admin.home') }}" class="sidebar-link">
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
            <a href="{{ route('admin.users') }}" class="sidebar-link active">
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
        <div class="edit-container">
            <div class="edit-header">
                <div class="content">
                    <h1 class="edit-title">Edit Agency Profile</h1>
                    <span class="edit-subtitle">{{ $agency->AgencyName ?? 'Agency' }}</span>
                </div>
            </div>

            <div class="edit-content">
                <!-- Section Header -->
                <div class="section-header">
                    <div class="section-icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <div class="section-info">
                        <h2 class="section-title">Agency User</h2>
                        <p class="section-description">Edit agency profile information</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('admin.agency.update', $agency->AgencyID) }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="AgencyName"><i class="fas fa-building mr-2"></i>Agency Name</label>
                        <input type="text" name="AgencyName" id="AgencyName" value="{{ $agency->AgencyName }}"
                            placeholder="Enter agency name" required>
                        @error('AgencyName')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="AgencyUserName"><i class="fas fa-user mr-2"></i>Username</label>
                        <input type="text" name="AgencyUserName" id="AgencyUserName"
                            value="{{ $agency->AgencyUserName }}" placeholder="Enter username" required>
                        @error('AgencyUserName')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="AgencyEmail"><i class="fas fa-envelope mr-2"></i>Email Address</label>
                        <input type="email" name="AgencyEmail" id="AgencyEmail" value="{{ $agency->AgencyEmail }}"
                            placeholder="Enter email address" required>
                        @error('AgencyEmail')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="AgencyPhoneNum"><i class="fas fa-phone mr-2"></i>Phone Number</label>
                        <input type="text" name="AgencyPhoneNum" id="AgencyPhoneNum"
                            value="{{ $agency->AgencyPhoneNum }}" placeholder="Enter phone number (optional)">
                        @error('AgencyPhoneNum')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-footer">
                        <a href="{{ route('admin.users') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i>
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Success message --}}
    @if (session('success'))
        <div class="success-toast" id="successToast">
            {{ session('success') }}
        </div>
        <script>
            setTimeout(function() {
                const toast = document.getElementById('successToast');
                if (toast) {
                    toast.style.transform = 'translateX(400px)';
                    toast.style.opacity = '0';
                    setTimeout(() => toast.remove(), 300);
                }
            }, 5000);
        </script>
    @endif

    <!-- JavaScript for Mobile Menu and Interactions -->
    <script>
        // Mobile menu toggle
        function toggleMobileMenu() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('mobile-open');
        }

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(e) {
            const sidebar = document.getElementById('sidebar');
            const toggle = document.querySelector('.mobile-menu-toggle');

            if (!sidebar.contains(e.target) && !toggle.contains(e.target)) {
                sidebar.classList.remove('mobile-open');
            }
        });

        // Form validation and enhancement
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const inputs = document.querySelectorAll('input');

            // Add smooth focus transitions
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('focused');
                });

                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('focused');
                });
            });

            // Form submission animation
            form.addEventListener('submit', function(e) {
                const submitBtn = document.querySelector('.btn-primary');
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
                submitBtn.disabled = true;
            });
        });
    </script>
</body>

</html>
