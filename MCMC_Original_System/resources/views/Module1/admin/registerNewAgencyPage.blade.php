<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Admin panel for registering new agencies in the AuthenticityHub system" />
    <meta name="keywords" content="admin, agency registration, authenticity, management" />
    <meta name="author" content="AuthenticityHub" />
    <title>Admin – Register Agency | AuthenticityHub</title>

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
            --gradient-bg: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --card-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            --hover-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            --input-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
            --error-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
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
                radial-gradient(circle at 20px 20px, rgba(200, 200, 200, 0.3) 2px, transparent 2px),
                radial-gradient(circle at 60px 60px, rgba(180, 180, 180, 0.2) 1px, transparent 1px);
            background-size: 80px 80px, 120px 120px;
            animation: floatPattern 30s linear infinite;
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
                radial-gradient(circle at 25% 25%, rgba(220, 220, 220, 0.4) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(200, 200, 200, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 50% 80%, rgba(190, 190, 190, 0.2) 0%, transparent 50%);
            animation: moveOrbs 20s ease-in-out infinite alternate;
        }

        /* Additional floating elements */
        .floating-shapes {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            pointer-events: none;
        }

        .floating-shapes .shape {
            position: absolute;
            background: rgba(180, 180, 180, 0.1);
            border-radius: 50%;
            animation: floatUp 15s infinite linear;
        }

        .floating-shapes .shape:nth-child(1) {
            width: 60px;
            height: 60px;
            left: 10%;
            animation-delay: 0s;
            animation-duration: 12s;
        }

        .floating-shapes .shape:nth-child(2) {
            width: 40px;
            height: 40px;
            left: 30%;
            animation-delay: 2s;
            animation-duration: 16s;
        }

        .floating-shapes .shape:nth-child(3) {
            width: 80px;
            height: 80px;
            left: 60%;
            animation-delay: 4s;
            animation-duration: 14s;
        }

        .floating-shapes .shape:nth-child(4) {
            width: 50px;
            height: 50px;
            left: 80%;
            animation-delay: 6s;
            animation-duration: 18s;
        }

        .floating-shapes .shape:nth-child(5) {
            width: 35px;
            height: 35px;
            left: 45%;
            animation-delay: 8s;
            animation-duration: 13s;
        }

        @keyframes floatPattern {
            0% {
                transform: translate(0, 0) rotate(0deg);
                opacity: 0.3;
            }

            50% {
                opacity: 0.6;
            }

            100% {
                transform: translate(-80px, -80px) rotate(360deg);
                opacity: 0.3;
            }
        }

        @keyframes moveOrbs {
            0% {
                transform: translate(0, 0) scale(1);
                opacity: 0.4;
            }

            25% {
                transform: translate(20px, -30px) scale(1.1);
                opacity: 0.6;
            }

            50% {
                transform: translate(-15px, -60px) scale(0.9);
                opacity: 0.5;
            }

            75% {
                transform: translate(-30px, -20px) scale(1.05);
                opacity: 0.7;
            }

            100% {
                transform: translate(10px, 10px) scale(1);
                opacity: 0.4;
            }
        }

        @keyframes floatUp {
            0% {
                transform: translateY(100vh) translateX(0px) rotate(0deg);
                opacity: 0;
            }

            10% {
                opacity: 0.6;
            }

            90% {
                opacity: 0.6;
            }

            100% {
                transform: translateY(-100px) translateX(100px) rotate(360deg);
                opacity: 0;
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
            padding: 3rem;
            min-height: calc(100vh - 56px);
            background: #f0f0f0;
            position: relative;
            z-index: 2;
        }

        .card {
            background: #ffffff;
            backdrop-filter: blur(25px);
            border-radius: 16px;
            padding: 3rem;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(220, 220, 220, 0.3);
            max-width: 800px;
            margin: 0 auto;
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            animation: slideInUp 0.6s ease-out;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #ddd, #bbb);
            border-radius: 16px 16px 0 0;
        }

        .card::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(240, 240, 240, 0.3), transparent);
            transition: left 0.6s;
        }

        .card:hover {
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
            transform: translateY(-4px) scale(1.01);
        }

        .card:hover::after {
            left: 100%;
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
        .form-header {
            color: #333;
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            position: relative;
            display: inline-block;
            animation: fadeIn 0.8s ease-out 0.2s both;
        }

        .form-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, #999, #666);
            border-radius: 2px;
            transform: scaleX(0);
            animation: scaleX 0.6s ease-out 0.8s forwards;
        }

        @keyframes scaleX {
            to {
                transform: scaleX(1);
            }
        }

        .form-group {
            margin-bottom: 2rem;
            position: relative;
            animation: slideInUp 0.6s ease-out both;
        }

        .form-group:nth-child(2) {
            animation-delay: 0.1s;
        }

        .form-group:nth-child(3) {
            animation-delay: 0.2s;
        }

        .form-group:nth-child(4) {
            animation-delay: 0.3s;
        }

        .form-group:nth-child(5) {
            animation-delay: 0.4s;
        }

        .form-group:nth-child(6) {
            animation-delay: 0.5s;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.75rem;
            font-weight: 600;
            color: var(--text-primary);
            font-size: 0.95rem;
            letter-spacing: 0.025em;
            transition: color 0.3s ease;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 1rem 1.25rem;
            border: 2px solid #ddd;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 500;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            color: #333;
        }

        .form-group input::placeholder {
            color: #999;
            font-weight: 400;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #999;
            box-shadow: 0 0 0 3px rgba(150, 150, 150, 0.1);
            background: rgba(255, 255, 255, 0.95);
            transform: translateY(-2px);
        }

        .form-group input:hover,
        .form-group select:hover,
        .form-group textarea:hover {
            border-color: #999;
            transform: translateY(-1px);
        }

        /* Enhanced Error Styling */
        .form-group input.error,
        .form-group select.error,
        .form-group textarea.error {
            border-color: #e74c3c;
            background: rgba(231, 76, 60, 0.05);
            box-shadow: 0 0 0 3px rgba(231, 76, 60, 0.1);
        }

        .error-message {
            color: #e74c3c;
            font-size: 0.875rem;
            font-weight: 500;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            animation: slideInUp 0.3s ease-out;
        }

        .error-message::before {
            content: '⚠';
            font-size: 1rem;
        }

        /* Success Message Styling */
        .success-message {
            background: rgba(46, 204, 113, 0.1);
            border: 2px solid #2ecc71;
            color: #27ae60;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            animation: slideInUp 0.5s ease-out;
            backdrop-filter: blur(10px);
        }

        .success-message::before {
            content: '✓';
            font-size: 1.25rem;
            background: #2ecc71;
            color: white;
            border-radius: 50%;
            width: 1.5rem;
            height: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        /* Enhanced Submit Button */
        .submit-btn {
            background: linear-gradient(145deg, #666, #333);
            color: #ffffff;
            border: none;
            padding: 1rem 3rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            position: relative;
            overflow: hidden;
            letter-spacing: 0.025em;
            min-width: 200px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 1rem;
            animation: slideInUp 0.6s ease-out 0.6s both;
        }

        .submit-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.6s;
        }

        .submit-btn:hover {
            background: linear-gradient(145deg, #333, #555);
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.25);
        }

        .submit-btn:hover::before {
            left: 100%;
        }

        .submit-btn:active {
            transform: translateY(-1px) scale(1.02);
        }

        .submit-btn:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .submit-btn.loading {
            pointer-events: none;
        }

        .submit-btn.loading::after {
            content: '';
            width: 20px;
            height: 20px;
            border: 2px solid transparent;
            border-top: 2px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-left: 0.5rem;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Enhanced Responsive Design */
        @media (max-width: 1024px) {
            .main-content {
                margin-left: 12rem;
                padding: 2rem;
            }

            .sidebar {
                width: 12rem;
            }

            .card {
                padding: 2.5rem;
            }
        }

        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                margin-top: 56px;
                padding: 1.5rem;
            }

            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar.mobile-open {
                transform: translateX(0);
            }

            .card {
                padding: 2rem;
                border-radius: 24px;
                margin: 1rem 0;
            }

            .form-header {
                font-size: 1.75rem;
            }

            .submit-btn {
                width: 100%;
                padding: 1.25rem;
            }
        }

        @media (max-width: 480px) {
            .card {
                padding: 1.5rem;
                margin: 0.5rem 0;
            }

            .main-content {
                padding: 1rem;
            }

            .form-header {
                font-size: 1.5rem;
                margin-bottom: 1.5rem;
            }

            .form-group {
                margin-bottom: 1.5rem;
            }
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

        @media (max-width: 768px) {
            .mobile-menu-toggle {
                display: block;
            }
        }

        /* Focus Indicators for Accessibility */
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus,
        .submit-btn:focus,
        .sidebar-link:focus {
            outline: 2px solid #666;
            outline-offset: 2px;
        }

        /* Loading Spinner */
        .spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }

        /* Password Strength Indicator */
        .password-strength {
            margin-top: 0.5rem;
            font-size: 0.875rem;
        }

        .strength-bar {
            height: 4px;
            background: var(--border-color);
            border-radius: 2px;
            overflow: hidden;
            margin-top: 0.25rem;
        }

        .strength-fill {
            height: 100%;
            transition: all 0.3s ease;
            border-radius: 2px;
        }

        .strength-weak {
            width: 25%;
            background: var(--danger-color);
        }

        .strength-fair {
            width: 50%;
            background: var(--warning-color);
        }

        .strength-good {
            width: 75%;
            background: var(--accent-color);
        }

        .strength-strong {
            width: 100%;
            background: var(--success-color);
        }

        /* Floating Label Effect */
        .floating-label {
            position: relative;
        }

        .floating-label input {
            padding-top: 1.5rem;
            padding-bottom: 0.5rem;
        }

        .floating-label label {
            position: absolute;
            top: 1rem;
            left: 1.25rem;
            color: var(--text-secondary);
            transition: all 0.3s ease;
            pointer-events: none;
            background: rgba(255, 255, 255, 0.9);
            padding: 0 0.25rem;
        }

        .floating-label input:focus+label,
        .floating-label input:not(:placeholder-shown)+label {
            top: -0.5rem;
            left: 1rem;
            font-size: 0.75rem;
            color: var(--primary-color);
            font-weight: 600;
        }

        /* Smooth Page Transitions */
        .page-transition {
            animation: pageLoad 0.8s ease-out;
        }

        @keyframes pageLoad {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <!-- Animated Background Elements -->
    <div class="bg-elements"></div>

    <!-- Floating Shapes -->
    <div class="floating-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

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
            <a href="{{ route('admin.agency.register') }}" class="sidebar-link active">
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
    <div class="main-content page-transition">
        <div class="card">
            <h2 class="form-header">Register New Agency</h2>

            @if (session('success'))
                <div class="success-message" role="alert">
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <form action="{{ route('admin.agency.store') }}" method="POST" id="agencyForm">
                @csrf

                <div class="form-group">
                    <label for="AgencyName">Agency Name</label>
                    <input type="text" id="AgencyName" name="AgencyName" placeholder="Enter agency name" required
                        value="{{ old('AgencyName') }}" class="{{ $errors->has('AgencyName') ? 'error' : '' }}">
                    @error('AgencyName')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="AgencyEmail">Agency Email</label>
                    <input type="email" id="AgencyEmail" name="AgencyEmail" placeholder="Enter agency email address"
                        required value="{{ old('AgencyEmail') }}"
                        class="{{ $errors->has('AgencyEmail') ? 'error' : '' }}">
                    @error('AgencyEmail')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="AgencyUserName">Agency Username</label>
                    <input type="text" id="AgencyUserName" name="AgencyUserName" placeholder="Enter unique username"
                        required value="{{ old('AgencyUserName') }}"
                        class="{{ $errors->has('AgencyUserName') ? 'error' : '' }}">
                    @error('AgencyUserName')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="AgencyPassword">Agency Password</label>
                    <input type="password" id="AgencyPassword" name="AgencyPassword"
                        placeholder="Create a strong password" required
                        class="{{ $errors->has('AgencyPassword') ? 'error' : '' }}">
                    @error('AgencyPassword')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="AgencyPassword_confirmation">Confirm Password</label>
                    <input type="password" id="AgencyPassword_confirmation" name="AgencyPassword_confirmation"
                        placeholder="Confirm your password" required>
                </div>

                <button type="submit" class="submit-btn" id="submitBtn">
                    <i class="fas fa-plus-circle"></i>
                    Register Agency
                </button>
            </form>

            <script>
                // Enhanced Form Handling
                document.addEventListener('DOMContentLoaded', function() {
                    const form = document.getElementById('agencyForm');
                    const submitBtn = document.getElementById('submitBtn');
                    const inputs = form.querySelectorAll('input');

                    // Mobile menu toggle
                    window.toggleMobileMenu = function() {
                        const sidebar = document.getElementById('sidebar');
                        sidebar.classList.toggle('mobile-open');
                    };

                    // Close mobile menu when clicking outside
                    document.addEventListener('click', function(e) {
                        const sidebar = document.getElementById('sidebar');
                        const toggle = document.querySelector('.mobile-menu-toggle');

                        if (!sidebar.contains(e.target) && !toggle.contains(e.target)) {
                            sidebar.classList.remove('mobile-open');
                        }
                    });

                    // Enhanced form validation
                    inputs.forEach(input => {
                        input.addEventListener('blur', validateField);
                        input.addEventListener('input', clearErrors);
                    });

                    function validateField(e) {
                        const field = e.target;
                        const value = field.value.trim();

                        // Remove existing error styling
                        field.classList.remove('error');

                        // Basic validation
                        if (field.hasAttribute('required') && !value) {
                            showFieldError(field, 'This field is required');
                            return false;
                        }

                        // Email validation
                        if (field.type === 'email' && value) {
                            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                            if (!emailRegex.test(value)) {
                                showFieldError(field, 'Please enter a valid email address');
                                return false;
                            }
                        }

                        // Password validation
                        if (field.name === 'AgencyPassword' && value) {
                            if (value.length < 8) {
                                showFieldError(field, 'Password must be at least 8 characters long');
                                return false;
                            }
                        }

                        // Password confirmation
                        if (field.name === 'AgencyPassword_confirmation' && value) {
                            const password = document.getElementById('AgencyPassword').value;
                            if (value !== password) {
                                showFieldError(field, 'Passwords do not match');
                                return false;
                            }
                        }

                        return true;
                    }

                    function showFieldError(field, message) {
                        field.classList.add('error');

                        // Remove existing error message
                        const existingError = field.parentNode.querySelector('.error-message.dynamic');
                        if (existingError) {
                            existingError.remove();
                        }

                        // Add new error message
                        const errorDiv = document.createElement('div');
                        errorDiv.className = 'error-message dynamic';
                        errorDiv.textContent = message;
                        field.parentNode.appendChild(errorDiv);
                    }

                    function clearErrors(e) {
                        const field = e.target;
                        field.classList.remove('error');

                        const dynamicError = field.parentNode.querySelector('.error-message.dynamic');
                        if (dynamicError) {
                            dynamicError.remove();
                        }
                    }

                    // Form submission with loading state
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();

                        // Validate all fields
                        let isValid = true;
                        inputs.forEach(input => {
                            if (!validateField({
                                    target: input
                                })) {
                                isValid = false;
                            }
                        });

                        if (!isValid) {
                            return;
                        }

                        // Show loading state
                        submitBtn.classList.add('loading');
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Registering...';

                        // Store form submission flag
                        sessionStorage.setItem('formSubmitted', 'true');

                        // Submit form
                        setTimeout(() => {
                            form.submit();
                        }, 500);
                    });

                    // Check if we're returning after a submission
                    if (sessionStorage.getItem('formSubmitted')) {
                        form.reset();
                        sessionStorage.removeItem('formSubmitted');
                    }

                    // Smooth scroll animations for error elements
                    const errorElements = document.querySelectorAll('.error-message');
                    errorElements.forEach((element, index) => {
                        element.style.animationDelay = `${index * 0.1}s`;
                    });
                });
            </script>
        </div>
    </div>
</body>

</html>
