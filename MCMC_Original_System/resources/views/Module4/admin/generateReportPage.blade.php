<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description"
        content="Admin panel for generating comprehensive reports for users and inquiries in the AuthenticityHub system" />
    <meta name="keywords" content="admin, reports, analytics, users, inquiries, statistics" />
    <meta name="author" content="AuthenticityHub" />
    <title>Admin – Generate Reports | AuthenticityHub</title>

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
            --card-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            --hover-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
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
                radial-gradient(circle at 20px 20px, rgba(200, 200, 200, 0.25) 2px, transparent 2px),
                radial-gradient(circle at 60px 60px, rgba(180, 180, 180, 0.2) 1px, transparent 1px);
            background-size: 80px 80px, 120px 120px;
            animation: floatPattern 40s linear infinite;
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
                radial-gradient(circle at 50% 80%, rgba(190, 190, 190, 0.25) 0%, transparent 50%);
            animation: moveOrbs 30s ease-in-out infinite alternate;
        }

        @keyframes floatPattern {
            0% {
                transform: translate(0, 0) rotate(0deg);
                opacity: 0.4;
            }

            50% {
                opacity: 0.6;
            }

            100% {
                transform: translate(-80px, -80px) rotate(360deg);
                opacity: 0.4;
            }
        }

        @keyframes moveOrbs {
            0% {
                transform: translate(0, 0) scale(1);
                opacity: 0.4;
            }

            25% {
                transform: translate(20px, -30px) scale(1.08);
                opacity: 0.6;
            }

            50% {
                transform: translate(-15px, -60px) scale(0.92);
                opacity: 0.5;
            }

            75% {
                transform: translate(-25px, -20px) scale(1.05);
                opacity: 0.7;
            }

            100% {
                transform: translate(10px, 15px) scale(1);
                opacity: 0.4;
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

        @keyframes scaleIn {
            from {
                transform: scale(0.95);
                opacity: 0;
            }

            to {
                transform: scale(1);
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

        .card {
            background: #ffffff;
            padding: 3rem;
            border-radius: 24px;
            box-shadow: var(--card-shadow);
            width: 100%;
            text-align: left;
            max-width: 900px;
            margin: 0 auto;
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            animation: slideInUp 0.6s ease-out;
            border: 1px solid rgba(220, 220, 220, 0.3);
            backdrop-filter: blur(15px);
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #6b7280, #4b5563);
            border-radius: 24px 24px 0 0;
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
            box-shadow: var(--hover-shadow);
            transform: translateY(-6px) scale(1.01);
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
            color: #374151;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            position: relative;
            display: inline-block;
            animation: fadeIn 0.8s ease-out 0.2s both;
            letter-spacing: -0.025em;
        }

        .form-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, #6b7280, #4b5563);
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

        .form-group label {
            display: block;
            margin-bottom: 0.75rem;
            font-weight: 600;
            color: #374151;
            font-size: 0.95rem;
            letter-spacing: 0.025em;
            transition: color 0.3s ease;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 1rem 1.25rem;
            border: 2px solid #e5e7eb;
            border-radius: 16px;
            font-size: 1rem;
            font-weight: 500;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            color: #374151;
        }

        .form-group input::placeholder,
        .form-group select::placeholder {
            color: #9ca3af;
            font-weight: 400;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #6b7280;
            box-shadow: 0 0 0 3px rgba(107, 114, 128, 0.1);
            background: rgba(255, 255, 255, 0.95);
            transform: translateY(-2px);
        }

        .form-group input:hover,
        .form-group select:hover,
        .form-group textarea:hover {
            border-color: #6b7280;
            transform: translateY(-1px);
        }

        .form-help {
            display: block;
            margin-top: 0.25rem;
            font-size: 0.875rem;
            color: #6b7280;
            font-style: italic;
            line-height: 1.4;
        }

        .btn-primary {
            background: linear-gradient(145deg, #ff5555, #ff3333);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
            font-weight: 600;
            cursor: pointer;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(255, 51, 51, 0.3);
        }

        .btn-primary:hover {
            background: linear-gradient(145deg, #ff3333, #ff1111);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 51, 51, 0.4);
        }

        .btn-secondary {
            background: #333;
            color: #fff;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
            font-weight: 600;
            cursor: pointer;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(51, 51, 51, 0.3);
        }

        .btn-secondary:hover {
            background: #555;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(51, 51, 51, 0.4);
        }

        /* Enhanced Format Buttons */
        .format-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 2.5rem;
            flex-wrap: wrap;
            justify-content: center;
            animation: slideInUp 0.6s ease-out 0.5s both;
        }

        .format-btn {
            padding: 1rem 2rem;
            border-radius: 16px;
            font-weight: 600;
            cursor: pointer;
            font-size: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            min-width: 160px;
            letter-spacing: 0.025em;
            backdrop-filter: blur(10px);
        }

        .format-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.6s;
        }

        .format-btn:hover::before {
            left: 100%;
        }

        .format-btn i {
            margin-right: 0.5rem;
            font-size: 1.1rem;
            transition: transform 0.3s ease;
        }

        .format-btn:hover i {
            transform: scale(1.1);
        }

        .pdf-btn {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            color: white;
            box-shadow: 0 8px 25px rgba(220, 38, 38, 0.3);
            border: 1px solid rgba(220, 38, 38, 0.2);
        }

        .pdf-btn:hover {
            background: linear-gradient(135deg, #b91c1c, #991b1b);
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 12px 35px rgba(220, 38, 38, 0.4);
        }

        .pdf-btn:active {
            transform: translateY(-1px) scale(1.01);
        }

        .excel-btn {
            background: linear-gradient(135deg, #059669, #047857);
            color: white;
            box-shadow: 0 8px 25px rgba(5, 150, 105, 0.3);
            border: 1px solid rgba(5, 150, 105, 0.2);
        }

        .excel-btn:hover {
            background: linear-gradient(135deg, #047857, #065f46);
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 12px 35px rgba(5, 150, 105, 0.4);
        }

        .excel-btn:active {
            transform: translateY(-1px) scale(1.01);
        }

        /* Enhanced Tab styling */
        .report-tabs {
            display: flex;
            margin-bottom: 2rem;
            border-bottom: 2px solid #e5e7eb;
            background: rgba(255, 255, 255, 0.7);
            padding: 0.5rem;
            border-radius: 16px 16px 0 0;
            backdrop-filter: blur(10px);
        }

        .report-tab {
            padding: 1rem 2rem;
            font-weight: 600;
            cursor: pointer;
            position: relative;
            color: #6b7280;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            margin-right: 0.5rem;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(5px);
            border: 1px solid rgba(107, 114, 128, 0.1);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.95rem;
            letter-spacing: 0.025em;
        }

        .report-tab::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(107, 114, 128, 0.1), transparent);
            border-radius: 12px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .report-tab:hover::before {
            opacity: 1;
        }

        .report-tab.active {
            color: #374151;
            background: rgba(255, 255, 255, 0.9);
            box-shadow: 0 4px 12px rgba(107, 114, 128, 0.15);
            transform: translateY(-2px);
            border-color: rgba(107, 114, 128, 0.2);
        }

        .report-tab.active::after {
            content: '';
            position: absolute;
            bottom: -12px;
            left: 50%;
            transform: translateX(-50%);
            width: 60%;
            height: 3px;
            background: linear-gradient(90deg, #6b7280, #4b5563);
            border-radius: 2px;
            animation: tabIndicator 0.4s ease-out;
        }

        @keyframes tabIndicator {
            from {
                width: 0%;
                opacity: 0;
            }

            to {
                width: 60%;
                opacity: 1;
            }
        }

        .report-tab:hover:not(.active) {
            color: #4b5563;
            background: rgba(255, 255, 255, 0.6);
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(107, 114, 128, 0.1);
        }

        /* Enhanced Success Message */
        .success-message {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(5, 150, 105, 0.05));
            border: 1px solid rgba(16, 185, 129, 0.3);
            color: #065f46;
            padding: 1rem 1.5rem;
            border-radius: 16px;
            margin-bottom: 2rem;
            position: relative;
            backdrop-filter: blur(10px);
            animation: slideInUp 0.6s ease-out;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.1);
        }

        .success-message::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #10b981, #059669);
            border-radius: 16px 16px 0 0;
        }

        .success-message strong {
            font-weight: 700;
            color: #047857;
        }

        /* Enhanced Error Message */
        .error-message {
            background: linear-gradient(135deg, rgba(220, 38, 38, 0.1), rgba(185, 28, 28, 0.05));
            border: 1px solid rgba(220, 38, 38, 0.3);
            color: #7f1d1d;
            padding: 1rem 1.5rem;
            border-radius: 16px;
            margin-bottom: 2rem;
            position: relative;
            backdrop-filter: blur(10px);
            animation: slideInUp 0.6s ease-out;
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.1);
        }

        .error-message::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #dc2626, #b91c1c);
            border-radius: 16px 16px 0 0;
        }

        .error-message strong {
            font-weight: 700;
            color: #991b1b;
        }

        .error-message ul {
            margin-top: 0.5rem;
            margin-bottom: 0;
            padding-left: 1.5rem;
        }

        .error-message li {
            margin-bottom: 0.25rem;
        }

        /* Form Report Sections */
        #users-report-form,
        #inquiry-report-form,
        #assignment-report-form {
            animation: fadeIn 0.6s ease-out;
        }

        #inquiry-report-form {
            animation-delay: 0.1s;
        }

        #assignment-report-form {
            animation-delay: 0.2s;
        }

        /* Enhanced Loading States */
        .format-btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none !important;
        }

        .format-btn.loading {
            position: relative;
            color: transparent;
        }

        .format-btn.loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin-left: -10px;
            margin-top: -10px;
            border: 2px solid transparent;
            border-top: 2px solid currentColor;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Mobile Sidebar Toggle */
        .mobile-menu-toggle {
            display: none;
            background: none;
            border: none;
            color: #ffffff;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .mobile-menu-toggle:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 98;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar-overlay.active {
            opacity: 1;
        }

        @media (max-width: 1024px) {
            .main-content {
                margin-left: 0;
                padding: 1.5rem;
            }

            .card {
                padding: 2rem;
            }

            .format-buttons {
                flex-direction: column;
                align-items: stretch;
            }

            .format-btn {
                min-width: auto;
            }
        }

        @media (max-width: 640px) {
            .report-tabs {
                flex-direction: column;
                gap: 0.5rem;
            }

            .report-tab {
                margin-right: 0;
                text-align: center;
            }

            .card {
                padding: 1.5rem;
                margin: 1rem;
            }

            .form-header {
                font-size: 1.5rem;
            }

            .format-buttons {
                gap: 0.75rem;
            }

            .format-btn {
                padding: 0.875rem 1.5rem;
                font-size: 0.95rem;
            }
        }

        @media (max-width: 480px) {
            .main-content {
                padding: 1rem;
            }

            .card {
                margin: 0.5rem;
                padding: 1rem;
            }

            .top-bar .logo {
                font-size: 1.1rem;
            }

            .user-info-topbar .welcome {
                font-size: 0.7rem;
            }
        }
    </style>
</head>

<body>
    <!-- Animated Background Elements -->
    <div class="bg-elements"></div>

    <!-- Top Bar -->
    <header class="top-bar">
        <button class="mobile-menu-toggle" id="mobile-menu-toggle">
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

    <!-- Sidebar Overlay for Mobile -->
    <div class="sidebar-overlay" id="sidebar-overlay"></div>

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
            <a href="{{ route('admin.users') }}" class="sidebar-link">
                <i class="fas fa-search"></i>
                <span>Search For User</span>
            </a>
            <a href="{{ route('admin.reports') }}" class="sidebar-link active">
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
        <div class="card">
            <div class="report-tabs">
                <a href="#" class="report-tab active" id="users-tab">
                    <i class="fas fa-users"></i>
                    Generate User Reports
                </a>
                <a href="#" class="report-tab" id="inquiries-tab">
                    <i class="fas fa-clipboard-list"></i>
                    Generate Submitted Inquiry Reports
                </a>
                <a href="#" class="report-tab" id="assignments-tab">
                    <i class="fas fa-tasks"></i>
                    Generate Assigned Inquiry Reports
                </a>
            </div>

            <!-- Users Report Form -->
            <div id="users-report-form">
                <h2 class="form-header">Generate User Reports</h2>

                @if (session('success'))
                    <div class="success-message" role="alert">
                        <strong>Success!</strong>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="error-message" role="alert">
                        <strong>Error!</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('error'))
                    <div class="error-message" role="alert">
                        <strong>Error!</strong>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                <form action="{{ route('admin.reports.generate') }}" method="POST" id="usersReportForm">
                    @csrf
                    <input type="hidden" name="report_category" value="users">
                    <input type="hidden" name="format" id="users-format" value="">

                    <div class="form-group">
                        <label for="report_type">Report Type</label>
                        <select id="report_type" name="report_type" required>
                            <option value="">Select Report Type</option>
                            <option value="summary">Summary Report</option>
                            <option value="detailed">Detailed Report</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="date_from">Date From</label>
                        <input type="date" id="date_from" name="date_from" required>
                    </div>

                    <div class="form-group">
                        <label for="date_to">Date To</label>
                        <input type="date" id="date_to" name="date_to" required>
                    </div>

                    <div class="form-group">
                        <label for="user_type">User Type</label>
                        <select id="user_type" name="user_type">
                            <option value="">All Users</option>
                            <option value="public">Public Users</option>
                            <option value="agency">Agency Users</option>
                        </select>
                    </div>

                    <div class="format-buttons">
                        <button type="button" data-format="pdf" class="format-btn pdf-btn"
                            onclick="submitUserReport('pdf')">
                            <i class="fas fa-file-pdf"></i> Download PDF
                        </button>
                        <button type="button" data-format="excel" class="format-btn excel-btn"
                            onclick="submitUserReport('excel')">
                            <i class="fas fa-file-excel"></i> Download Excel
                        </button>
                    </div>
                </form>
            </div>

            <!-- Inquiry Reports Form -->
            <div id="inquiry-report-form" style="display: none;">
                <h2 class="form-header">Generate Submitted Inquiry Reports</h2>

                @if (session('success'))
                    <div class="success-message" role="alert">
                        <strong>Success!</strong>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="error-message" role="alert">
                        <strong>Error!</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('error'))
                    <div class="error-message" role="alert">
                        <strong>Error!</strong>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                <form action="{{ route('admin.reports.generate') }}" method="POST" id="inquiriesReportForm">
                    @csrf
                    <input type="hidden" name="report_category" value="inquiries">
                    <input type="hidden" name="format" id="inquiry-format" value="">

                    <div class="form-group">
                        <label for="inquiry_report_type">Report Type</label>
                        <select id="inquiry_report_type" name="report_type" required>
                            <option value="">Select Report Type</option>
                            <option value="summary">Summary Report (Overview with Charts)</option>
                            <option value="detailed">Detailed Report (Complete Data with Charts)</option>
                            <option value="statistics">Statistics Report (Submission Analytics)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="inquiry_date_from">Date From (Optional)</label>
                        <input type="date" id="inquiry_date_from" name="date_from">
                        <small style="display: block; color: #666; margin-top: 5px;">Leave blank to include all inquiries regardless of submission date</small>
                    </div>

                    <div class="form-group">
                        <label for="inquiry_date_to">Date To (Optional)</label>
                        <input type="date" id="inquiry_date_to" name="date_to">
                        <small style="display: block; color: #666; margin-top: 5px;">Leave blank to include all inquiries regardless of submission date</small>
                    </div>

                    <div class="form-group">
                        <label for="inquiry_review_status">Review Status</label>
                        <select id="inquiry_review_status" name="review_status">
                            <option value="">All Inquiries</option>
                            <option value="reviewed">Reviewed Inquiries</option>
                            <option value="not_reviewed">Not Reviewed Inquiries</option>
                            <option value="pending_review">Pending Review</option>
                            <option value="rejected">Rejected Inquiries</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="inquiry_status">Processing Status</label>
                        <select id="inquiry_status" name="status">
                            <option value="">All Statuses</option>
                            <option value="Pending">Pending</option>
                            <option value="Under Investigation">Under Investigation</option>
                            <option value="Verified as True">Verified as True</option>
                            <option value="Identified as Fake">Identified as Fake</option>
                            <option value="Rejected">Rejected</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="include_charts">Include Graphical Representations</label>
                        <select id="include_charts" name="include_charts">
                            <option value="yes">Yes - Include Charts and Graphs</option>
                            <option value="no">No - Data Only</option>
                        </select>
                        <small class="form-help">Charts include: Submission trends, Review status breakdown, Processing status overview</small>
                    </div>

                    <div class="format-buttons">
                        <button type="button" data-format="pdf" class="format-btn pdf-btn"
                            onclick="submitInquiryReport('pdf')">
                            <i class="fas fa-file-pdf"></i> Download PDF
                        </button>
                        <button type="button" data-format="excel" class="format-btn excel-btn"
                            onclick="submitInquiryReport('excel')">
                            <i class="fas fa-file-excel"></i> Download Excel
                        </button>
                    </div>
                </form>
            </div>

            <!-- Assignment Reports Form -->
            <div id="assignment-report-form" style="display: none;">
                <h2 class="form-header">Generate Assigned Inquiry Reports</h2>

                @if (session('success'))
                    <div class="success-message" role="alert">
                        <strong>Success!</strong>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="error-message" role="alert">
                        <strong>Error!</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('error'))
                    <div class="error-message" role="alert">
                        <strong>Error!</strong>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                <form action="{{ route('admin.reports.generate') }}" method="POST" id="assignmentReportForm">
                    @csrf
                    <input type="hidden" name="report_category" value="assignments">
                    <input type="hidden" name="format" id="assignment-format" value="">

                    <div class="form-group">
                        <label for="assignment_report_type">Report Type</label>
                        <select id="assignment_report_type" name="report_type" required>
                            <option value="">Select Report Type</option>
                            <option value="summary">Summary Report (Overview with Charts)</option>
                            <option value="detailed">Detailed Report (Complete Assignment Data)</option>
                            <option value="statistics">Statistics Report (Assignment Analytics)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="assignment_date_from">Assignment Date From (Optional)</label>
                        <input type="date" id="assignment_date_from" name="date_from">
                        <small style="display: block; color: #666; margin-top: 5px;">Leave blank to include all assignments regardless of date</small>
                    </div>

                    <div class="form-group">
                        <label for="assignment_date_to">Assignment Date To (Optional)</label>
                        <input type="date" id="assignment_date_to" name="date_to">
                        <small style="display: block; color: #666; margin-top: 5px;">Leave blank to include all assignments regardless of date</small>
                    </div>

                    <div class="form-group">
                        <label for="agency_filter">Agency</label>
                        <select id="agency_filter" name="agency_id">
                            <option value="">All Agencies</option>
                            @php
                                $agencies = \App\Models\Agency::orderBy('AgencyName')->get();
                            @endphp
                            @foreach($agencies as $agency)
                                <option value="{{ $agency->AgencyID }}">{{ $agency->AgencyName }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="assignment_status">Assignment Status</label>
                        <select id="assignment_status" name="status">
                            <option value="">All Statuses</option>
                            <option value="Pending">Pending</option>
                            <option value="Under Investigation">Under Investigation</option>
                            <option value="Verified as True">Verified as True</option>
                            <option value="Identified as Fake">Identified as Fake</option>
                            <option value="Rejected">Rejected</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="include_assignment_charts">Include Graphical Representations</label>
                        <select id="include_assignment_charts" name="include_charts">
                            <option value="yes">Yes - Include Charts and Graphs</option>
                            <option value="no">No - Data Only</option>
                        </select>
                        <small class="form-help">Charts include: Assignment trends over time, Assignments per agency, Status distribution, Processing performance</small>
                    </div>

                    <div class="format-buttons">
                        <button type="button" data-format="pdf" class="format-btn pdf-btn"
                            onclick="submitAssignmentReport('pdf')">
                            <i class="fas fa-file-pdf"></i> Download PDF
                        </button>
                        <button type="button" data-format="excel" class="format-btn excel-btn"
                            onclick="submitAssignmentReport('excel')">
                            <i class="fas fa-file-excel"></i> Download Excel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Tab switching functionality with smooth transitions
        document.addEventListener('DOMContentLoaded', function() {
            // Form submission functions
            window.submitUserReport = function(format) {
                const form = document.getElementById('usersReportForm');
                const formatInput = document.getElementById('users-format');
                const button = document.querySelector(`[data-format="${format}"]`);

                // Set format value
                formatInput.value = format;

                // Add loading state
                if (button) {
                    button.classList.add('loading');
                    button.disabled = true;

                    // Store original button content
                    const originalContent = button.innerHTML;

                    // Reset button state after download completes
                    const resetButton = () => {
                        button.classList.remove('loading');
                        button.disabled = false;
                        button.innerHTML = originalContent;
                    };

                    // Try to detect when download starts using multiple methods
                    let downloadStarted = false;

                    // Method 1: Reset after a reasonable timeout
                    const timeout = setTimeout(() => {
                        if (!downloadStarted) {
                            resetButton();
                        }
                    }, 3000);

                    // Method 2: Use focus/blur events to detect download
                    const onFocus = () => {
                        if (!downloadStarted) {
                            downloadStarted = true;
                            clearTimeout(timeout);
                            setTimeout(resetButton, 1000); // Reset shortly after focus returns
                        }
                        window.removeEventListener('focus', onFocus);
                    };

                    // Add focus listener after a short delay
                    setTimeout(() => {
                        window.addEventListener('focus', onFocus);
                    }, 500);
                }

                console.log('Submitting user report with format:', format);

                // Submit form
                form.submit();
            };

            window.submitInquiryReport = function(format) {
                const form = document.getElementById('inquiriesReportForm');
                const formatInput = document.getElementById('inquiry-format');
                const button = document.querySelector(`#inquiry-report-form [data-format="${format}"]`);

                // Set format value
                formatInput.value = format;

                // Add loading state
                if (button) {
                    button.classList.add('loading');
                    button.disabled = true;

                    // Store original button content
                    const originalContent = button.innerHTML;

                    // Reset button state after download completes
                    const resetButton = () => {
                        button.classList.remove('loading');
                        button.disabled = false;
                        button.innerHTML = originalContent;
                    };

                    // Try to detect when download starts using multiple methods
                    let downloadStarted = false;

                    // Method 1: Reset after a reasonable timeout
                    const timeout = setTimeout(() => {
                        if (!downloadStarted) {
                            resetButton();
                        }
                    }, 3000);

                    // Method 2: Use focus/blur events to detect download
                    const onFocus = () => {
                        if (!downloadStarted) {
                            downloadStarted = true;
                            clearTimeout(timeout);
                            setTimeout(resetButton, 1000); // Reset shortly after focus returns
                        }
                        window.removeEventListener('focus', onFocus);
                    };

                    // Add focus listener after a short delay
                    setTimeout(() => {
                        window.addEventListener('focus', onFocus);
                    }, 500);
                }

                console.log('Submitting inquiry report with format:', format);

                // Submit form
                form.submit();
            };

            window.submitAssignmentReport = function(format) {
                const form = document.getElementById('assignmentReportForm');
                const formatInput = document.getElementById('assignment-format');
                const button = document.querySelector(`#assignment-report-form [data-format="${format}"]`);

                // Set format value
                formatInput.value = format;

                // Add loading state
                if (button) {
                    button.classList.add('loading');
                    button.disabled = true;

                    // Store original button content
                    const originalContent = button.innerHTML;

                    // Reset button state after download completes
                    const resetButton = () => {
                        button.classList.remove('loading');
                        button.disabled = false;
                        button.innerHTML = originalContent;
                    };

                    // Try to detect when download starts using multiple methods
                    let downloadStarted = false;

                    // Method 1: Reset after a reasonable timeout
                    const timeout = setTimeout(() => {
                        if (!downloadStarted) {
                            resetButton();
                        }
                    }, 3000);

                    // Method 2: Use focus/blur events to detect download
                    const onFocus = () => {
                        if (!downloadStarted) {
                            downloadStarted = true;
                            clearTimeout(timeout);
                            setTimeout(resetButton, 1000); // Reset shortly after focus returns
                        }
                        window.removeEventListener('focus', onFocus);
                    };

                    // Add focus listener after a short delay
                    setTimeout(() => {
                        window.addEventListener('focus', onFocus);
                    }, 500);
                }

                console.log('Submitting assignment report with format:', format);

                // Submit form
                form.submit();
            };

            // Mobile menu functionality
            const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebar-overlay');

            function toggleSidebar() {
                sidebar.classList.toggle('active');
                sidebarOverlay.classList.toggle('active');

                const icon = mobileMenuToggle.querySelector('i');
                if (sidebar.classList.contains('active')) {
                    icon.classList.remove('fa-bars');
                    icon.classList.add('fa-times');
                } else {
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-bars');
                }
            }

            if (mobileMenuToggle) {
                mobileMenuToggle.addEventListener('click', toggleSidebar);
            }
            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', toggleSidebar);
            }

            // Close sidebar when clicking on sidebar links (mobile)
            const sidebarLinks = sidebar?.querySelectorAll('.sidebar-link');
            sidebarLinks?.forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth <= 1024) {
                        toggleSidebar();
                    }
                });
            });

            const usersTab = document.getElementById('users-tab');
            const inquiriesTab = document.getElementById('inquiries-tab');
            const assignmentsTab = document.getElementById('assignments-tab');
            const usersForm = document.getElementById('users-report-form');
            const inquiryForm = document.getElementById('inquiry-report-form');
            const assignmentForm = document.getElementById('assignment-report-form');

            function switchTab(activeTab, activeForm) {
                // Update tab states
                [usersTab, inquiriesTab, assignmentsTab].forEach(tab => {
                    tab.classList.remove('active');
                });
                activeTab.classList.add('active');

                // Hide all forms
                [usersForm, inquiryForm, assignmentForm].forEach(form => {
                    if (form !== activeForm) {
                        form.style.opacity = '0';
                        form.style.transform = 'translateY(20px)';
                        setTimeout(() => {
                            form.style.display = 'none';
                        }, 200);
                    }
                });

                // Show active form
                setTimeout(() => {
                    activeForm.style.display = 'block';
                    activeForm.style.opacity = '0';
                    activeForm.style.transform = 'translateY(20px)';

                    // Trigger reflow
                    activeForm.offsetHeight;

                    activeForm.style.transition = 'all 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
                    activeForm.style.opacity = '1';
                    activeForm.style.transform = 'translateY(0)';
                }, 200);
            }

            usersTab.addEventListener('click', function(e) {
                e.preventDefault();
                if (!usersTab.classList.contains('active')) {
                    switchTab(usersTab, usersForm);
                }
            });

            inquiriesTab.addEventListener('click', function(e) {
                e.preventDefault();
                if (!inquiriesTab.classList.contains('active')) {
                    switchTab(inquiriesTab, inquiryForm);
                }
            });

            assignmentsTab.addEventListener('click', function(e) {
                e.preventDefault();
                if (!assignmentsTab.classList.contains('active')) {
                    switchTab(assignmentsTab, assignmentForm);
                }
            });

            // Date validation
            function setupDateValidation() {
                const dateFromInputs = document.querySelectorAll('[name="date_from"]');
                const dateToInputs = document.querySelectorAll('[name="date_to"]');

                dateFromInputs.forEach((dateFrom, index) => {
                    const dateTo = dateToInputs[index];
                    if (!dateTo) return;

                    dateFrom.addEventListener('change', function() {
                        dateTo.min = dateFrom.value;
                        if (dateTo.value && dateTo.value < dateFrom.value) {
                            dateTo.value = dateFrom.value;
                        }
                    });

                    dateTo.addEventListener('change', function() {
                        dateFrom.max = dateTo.value;
                        if (dateFrom.value && dateFrom.value > dateTo.value) {
                            dateFrom.value = dateTo.value;
                        }
                    });
                });
            }

            setupDateValidation();

            // Auto-set today's date as default
            const today = new Date().toISOString().split('T')[0];
            const dateInputs = document.querySelectorAll('input[type="date"]');
            dateInputs.forEach(input => {
                if (!input.value) {
                    input.value = today;
                }
            });

            // Enhanced form field interactions
            const formGroups = document.querySelectorAll('.form-group');
            formGroups.forEach((group, index) => {
                group.style.animationDelay = `${0.1 * index}s`;

                const input = group.querySelector('input, select, textarea');
                const label = group.querySelector('label');

                if (input && label) {
                    input.addEventListener('focus', function() {
                        label.style.color = '#6b7280';
                        label.style.transform = 'translateY(-2px)';
                    });

                    input.addEventListener('blur', function() {
                        label.style.color = '#374151';
                        label.style.transform = 'translateY(0)';
                    });
                }
            });

            // Smooth scrolling for any anchor links
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
        });

        // Add some entrance animations
        window.addEventListener('load', function() {
            const elements = document.querySelectorAll('.card, .report-tab, .form-group');
            elements.forEach((el, index) => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(20px)';

                setTimeout(() => {
                    el.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
</body>

</html>
