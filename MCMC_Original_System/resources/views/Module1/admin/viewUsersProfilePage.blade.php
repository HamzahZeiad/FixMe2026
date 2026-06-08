<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description"
        content="Admin panel for viewing and managing all users and agencies in the AuthenticityHub system" />
    <meta name="keywords" content="admin, users, agencies, management, authenticity" />
    <meta name="author" content="AuthenticityHub" />
    <title>Admin – View Users & Agencies | AuthenticityHub</title>

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

        .card {
            background: #ffffff;
            padding: 2.5rem;
            border-radius: 20px;
            box-shadow: var(--card-shadow);
            width: 100%;
            text-align: left;
            position: relative;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            animation: slideInUp 0.6s ease-out;
            border: 1px solid rgba(220, 220, 220, 0.3);
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #ddd, #bbb);
            border-radius: 20px 20px 0 0;
        }

        .card:hover {
            box-shadow: var(--hover-shadow);
            transform: translateY(-4px);
        }

        .card+.card {
            margin-top: 2rem;
            animation-delay: 0.2s;
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

        /* Enhanced Content Area Styling */
        .card-header {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 2.5rem;
            position: relative;
        }

        .card-header .profile-header {
            color: #000000 !important;
            font-size: 2rem !important;
            font-weight: 900 !important;
            margin-bottom: 1.5rem;
            text-align: center;
            display: block;
            visibility: visible;
            z-index: 10;
            text-rendering: optimizeLegibility !important;
            -webkit-font-smoothing: antialiased !important;
            -moz-osx-font-smoothing: grayscale !important;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
            text-shadow: none !important;
            filter: none !important;
            backdrop-filter: none !important;
            transform: none !important;
            opacity: 1 !important;
        }

        .card-header::after {
            content: '';
            position: absolute;
            bottom: -1rem;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, #999, #666);
            border-radius: 2px;
        }

        .profile-header {
            color: #111827;
            font-size: 1.875rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            text-align: center;
            position: relative;
            letter-spacing: -0.025em;
            display: block;
            visibility: visible;
            text-rendering: optimizeLegibility;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            text-shadow: none;
        }

        .search-form {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin: 0 auto;
            width: 100%;
            max-width: 500px;
            position: relative;
        }

        .search-form form {
            display: flex;
            flex-grow: 1;
            gap: 0.75rem;
            align-items: center;
        }

        .search-form input {
            padding: 0.875rem 1.25rem;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            flex-grow: 1;
            font-size: 1rem;
            font-weight: 500;
            background: rgba(255, 255, 255, 0.8);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            color: #333;
        }

        .search-form input::placeholder {
            color: #9ca3af;
            font-weight: 400;
        }

        .search-form input:focus {
            outline: none;
            border-color: #6b7280;
            box-shadow: 0 0 0 3px rgba(107, 114, 128, 0.1);
            background: rgba(255, 255, 255, 0.95);
            transform: translateY(-1px);
        }

        .search-form button,
        .btn-show-all {
            background: linear-gradient(145deg, #6b7280, #4b5563);
            color: white;
            border: none;
            padding: 0.875rem 1.5rem;
            border-radius: 12px;
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            white-space: nowrap;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 0.95rem;
            letter-spacing: 0.025em;
            box-shadow: 0 4px 12px rgba(107, 114, 128, 0.2);
        }

        .search-form button:hover,
        .btn-show-all:hover {
            background: linear-gradient(145deg, #4b5563, #374151);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(107, 114, 128, 0.3);
        }

        .search-form button:active,
        .btn-show-all:active {
            transform: translateY(0);
        }

        /* Enhanced Table styling */
        .table-container {
            overflow-x: auto;
            border-radius: 16px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            background: white;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            background: white;
            overflow: hidden;
            border-radius: 16px;
        }

        th {
            background: linear-gradient(135deg, #f8fafc, #f1f5f9);
            padding: 1.25rem 1rem;
            text-align: left;
            font-weight: 700;
            font-size: 0.875rem;
            color: #374151;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 2px solid #e5e7eb;
            position: relative;
        }

        th:not(:last-child)::after {
            content: '';
            position: absolute;
            right: 0;
            top: 25%;
            bottom: 25%;
            width: 1px;
            background: #d1d5db;
        }

        td {
            padding: 1.25rem 1rem;
            border-bottom: 1px solid #f3f4f6;
            color: #374151;
            font-weight: 500;
            font-size: 0.95rem;
            transition: background-color 0.2s ease;
        }

        /* Actions column specific styling */
        td.actions-cell {
            white-space: nowrap;
            display: table-cell;
            vertical-align: middle;
        }

        td.actions-cell .action-btn {
            display: inline-block;
            margin-right: 0.5rem;
        }

        td.actions-cell .action-btn:last-child {
            margin-right: 0;
        }

        tbody tr {
            transition: all 0.2s ease;
        }

        tbody tr:hover {
            background: rgba(249, 250, 251, 0.8);
            transform: scale(1.001);
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        .action-btn {
            color: #6366f1;
            text-decoration: none;
            font-weight: 600;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
        }

        .action-btn::before {
            content: '✏️';
            font-size: 0.75rem;
        }

        .action-btn:hover {
            background: rgba(99, 102, 241, 0.1);
            color: #4f46e5;
            text-decoration: none;
            transform: translateX(2px);
        }

        /* Empty State Styling */
        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
            color: #6b7280;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .empty-state h3 {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #374151;
        }

        .empty-state p {
            font-size: 0.95rem;
            opacity: 0.8;
        }

        /* Enhanced Responsive Design */
        @media (max-width: 1024px) {
            .main-content {
                margin-left: 12rem;
                padding: 1.5rem;
            }

            .sidebar {
                width: 12rem;
            }

            .card {
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

            .card {
                padding: 1.5rem;
                border-radius: 16px;
                margin-bottom: 1.5rem;
            }

            .profile-header {
                font-size: 1.5rem;
            }

            .search-form {
                flex-direction: column;
                gap: 1rem;
            }

            .search-form form {
                width: 100%;
            }

            .table-container {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            table {
                min-width: 600px;
            }

            th,
            td {
                padding: 0.875rem 0.5rem;
                font-size: 0.875rem;
            }

            /* Profile page mobile styles */
            .profile-container {
                margin: 1rem;
            }

            .profile-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .profile-content {
                padding: 2rem;
            }

            .user-name,
            .agency-name {
                font-size: 2rem;
            }
        }

        @media (max-width: 480px) {
            .card {
                padding: 1rem;
                margin-bottom: 1rem;
            }

            .main-content {
                padding: 0.75rem;
            }

            .profile-header {
                font-size: 1.25rem;
                margin-bottom: 1rem;
            }

            .card-header {
                margin-bottom: 1.5rem;
            }

            th,
            td {
                padding: 0.75rem 0.375rem;
                font-size: 0.8rem;
            }

            /* Make action buttons stack vertically on mobile */
            td.actions-cell {
                white-space: normal;
            }

            td.actions-cell .action-btn {
                display: block;
                margin-bottom: 0.25rem;
                margin-right: 0;
                font-size: 0.75rem;
                padding: 0.375rem 0.75rem;
            }

            td.actions-cell .action-btn:last-child {
                margin-bottom: 0;
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

        /* Success Message Enhancement */
        .success-toast {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: linear-gradient(135deg, #059669, #10b981);
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(5, 150, 105, 0.3);
            z-index: 1000;
            animation: slideInUp 0.5s ease-out;
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

        /* Focus Indicators for Accessibility */
        .search-form input:focus,
        .search-form button:focus,
        .btn-show-all:focus,
        .back-button:focus,
        .action-btn:focus,
        .sidebar-link:focus {
            outline: 2px solid #6b7280;
            outline-offset: 2px;
        }

        /* Page Load Animation */
        .page-transition {
            animation: fadeIn 0.8s ease-out;
        }

        /* Statistics Cards Animation */
        .card:nth-child(1) {
            animation-delay: 0s;
        }

        .card:nth-child(2) {
            animation-delay: 0.2s;
        }

        /* Profile Container Styles */
        .profile-container {
            max-width: 800px;
            margin: 2rem auto;
            background: white;
            border-radius: 20px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
            animation: slideInUp 0.6s ease-out;
            position: relative;
            z-index: 2;
        }

        .profile-header {
            color: white;
            padding: 2rem;
            text-align: center;
            position: relative;
        }

        .profile-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.1);
        }

        .profile-header .content {
            position: relative;
            z-index: 2;
        }

        .user-name,
        .agency-name {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .user-type,
        .agency-type {
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

        .profile-content {
            padding: 3rem;
        }

        .profile-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }

        .profile-field {
            margin-bottom: 2rem;
        }

        .field-label {
            color: var(--text-secondary);
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.5rem;
        }

        .field-value {
            color: var(--text-primary);
            font-size: 1.125rem;
            font-weight: 500;
            padding: 0.75rem 0;
            border-bottom: 2px solid var(--border-color);
            transition: border-color 0.3s ease;
        }

        .field-value:hover {
            border-color: var(--primary-color);
        }

        .status-active {
            color: var(--success-color);
            font-weight: 600;
        }

        .status-inactive {
            color: var(--danger-color);
            font-weight: 600;
        }

        .back-button {
            background: linear-gradient(145deg, #6b7280, #4b5563);
            color: white;
            border: none;
            padding: 0.875rem 1.5rem;
            border-radius: 12px;
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            white-space: nowrap;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 0.95rem;
            letter-spacing: 0.025em;
            box-shadow: 0 4px 12px rgba(107, 114, 128, 0.2);
            margin-bottom: 2rem;
        }

        .back-button:hover {
            background: linear-gradient(145deg, #4b5563, #374151);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(107, 114, 128, 0.3);
        }

        .back-button:active {
            transform: translateY(0);
        }

        /* Profile View Specific Styles */
        .profile-container {
            margin-top: 1rem;
            padding: 2rem;
            border-radius: 1.5rem;
            background: #ffffff;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .profile-header {
            padding: 2rem;
            border-radius: 1.5rem 1.5rem 0 0;
            color: #ffffff;
            position: relative;
            overflow: hidden;
        }

        .profile-header .user-name {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .profile-header .user-type {
            font-size: 1rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }

        .profile-header::after {
            content: '';
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            height: 10px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 0 0 1.5rem 1.5rem;
        }

        .profile-content {
            margin-top: 1.5rem;
        }

        .back-button {
            background: linear-gradient(145deg, #6b7280, #4b5563);
            color: white;
            border: none;
            padding: 0.875rem 1.5rem;
            border-radius: 12px;
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            white-space: nowrap;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 0.95rem;
            letter-spacing: 0.025em;
            box-shadow: 0 4px 12px rgba(107, 114, 128, 0.2);
            margin-bottom: 2rem;
        }

        .back-button:hover {
            background: linear-gradient(145deg, #4b5563, #374151);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(107, 114, 128, 0.3);
        }

        .back-button:active {
            transform: translateY(0);
        }

        color: #4f46e5;
        }

        .profile-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .profile-field {
            background: #f9fafb;
            padding: 1.5rem;
            border-radius: 0.75rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .field-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: #6b7280;
            margin-bottom: 0.5rem;
        }

        .field-value {
            font-size: 1rem;
            font-weight: 500;
            color: #374151;
        }

        .status-active {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            border-radius: 1rem;
            background: rgba(5, 150, 105, 0.1);
            color: #059669;
            font-weight: 500;
            font-size: 0.875rem;
        }

        .status-inactive {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            border-radius: 1rem;
            background: rgba(220, 38, 38, 0.1);
            color: #dc2626;
            font-weight: 500;
            font-size: 0.875rem;
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
    <div class="main-content page-transition">
        {{-- Individual Profile View (conditionally displayed) --}}
        @if (isset($viewingProfile) && $viewingProfile)
            @if (isset($profileUser))
                {{-- User Profile View --}}
                <div class="profile-container">
                    <div class="profile-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <div class="content">
                            <h1 class="user-name">{{ $profileUser->UserName }}</h1>
                            <span class="user-type">Public User</span>
                        </div>
                    </div>

                    <div class="profile-content">
                        <a href="{{ route('admin.users') }}" class="back-button">
                            <i class="fas fa-arrow-left"></i>
                            Back to Users
                        </a>

                        <div class="profile-grid">
                            <div class="profile-field">
                                <div class="field-label">User ID</div>
                                <div class="field-value">{{ $profileUser->UserID }}</div>
                            </div>

                            <div class="profile-field">
                                <div class="field-label">Email Address</div>
                                <div class="field-value">{{ $profileUser->UserEmail }}</div>
                            </div>

                            <div class="profile-field">
                                <div class="field-label">Contact Number</div>
                                <div class="field-value">{{ $profileUser->UserPhoneNum ?? 'Not provided' }}</div>
                            </div>

                            <div class="profile-field">
                                <div class="field-label">Registration Date</div>
                                <div class="field-value">
                                    {{ $profileUser->created_at ? $profileUser->created_at->format('M d, Y') : 'Not available' }}
                                </div>
                            </div>

                            <div class="profile-field">
                                <div class="field-label">Last Login</div>
                                <div class="field-value">
                                    {{ $profileUser->updated_at ? $profileUser->updated_at->format('M d, Y H:i A') : 'Not available' }}
                                </div>
                            </div>

                            <div class="profile-field">
                                <div class="field-label">Account Status</div>
                                <div class="field-value">
                                    <span class="status-active">Active</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif(isset($profileAgency))
                {{-- Agency Profile View --}}
                <div class="profile-container">
                    <div class="profile-header" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                        <div class="content">
                            <h1 class="agency-name">{{ $profileAgency->AgencyName ?? 'Agency Name' }}</h1>
                            <span class="agency-type">Agency</span>
                        </div>
                    </div>

                    <div class="profile-content">
                        <a href="{{ route('admin.users') }}" class="back-button">
                            <i class="fas fa-arrow-left"></i>
                            Back to Users
                        </a>

                        <div class="profile-grid">
                            <div class="profile-field">
                                <div class="field-label">Agency ID</div>
                                <div class="field-value">{{ $profileAgency->AgencyID ?? '-' }}</div>
                            </div>

                            <div class="profile-field">
                                <div class="field-label">Username</div>
                                <div class="field-value">{{ $profileAgency->AgencyUserName ?? 'Not provided' }}</div>
                            </div>

                            <div class="profile-field">
                                <div class="field-label">Email Address</div>
                                <div class="field-value">{{ $profileAgency->AgencyEmail ?? 'Not provided' }}</div>
                            </div>

                            <div class="profile-field">
                                <div class="field-label">Contact Number</div>
                                <div class="field-value">{{ $profileAgency->AgencyPhoneNum ?? 'Not provided' }}</div>
                            </div>

                            <div class="profile-field">
                                <div class="field-label">Registration Date</div>
                                <div class="field-value">
                                    {{ $profileAgency->created_at ? $profileAgency->created_at->format('M d, Y') : 'Not available' }}
                                </div>
                            </div>

                            <div class="profile-field">
                                <div class="field-label">Last Login</div>
                                <div class="field-value">
                                    {{ $profileAgency->updated_at ? $profileAgency->updated_at->format('M d, Y H:i A') : 'Not available' }}
                                </div>
                            </div>

                            <div class="profile-field">
                                <div class="field-label">Account Status</div>
                                <div class="field-value">
                                    @if (isset($profileAgency->AgencyPhoneNum) && $profileAgency->AgencyPhoneNum)
                                        <span class="status-active">Active</span>
                                    @else
                                        <span class="status-inactive">Inactive</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @else
            {{-- Main Users/Agencies Listing View --}}
            <!-- Public Users Card -->
            <div class="card mb-8">
                <div class="card-header">
                    <h2 class="profile-header">All Public User</h2>
                    <div class="search-form">
                        <form action="{{ route('admin.users') }}" method="GET"
                            style="display:flex; flex-grow:1; gap:0.5rem;">
                            <input type="text" name="search" placeholder="Search user...">
                            <button type="submit">Search</button>
                        </form>
                        <a href="{{ route('admin.users') }}" class="btn-show-all">Show All</a>
                    </div>
                </div>

                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th><i class="fas fa-id-card mr-2"></i>ID</th>
                                <th><i class="fas fa-user mr-2"></i>Name</th>
                                <th><i class="fas fa-envelope mr-2"></i>Email</th>
                                <th><i class="fas fa-phone mr-2"></i>Phone</th>
                                <th><i class="fas fa-calendar-plus mr-2"></i>Created At</th>
                                <th><i class="fas fa-check-circle mr-2"></i>Status</th>
                                <th><i class="fas fa-cogs mr-2"></i>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td><strong>{{ $user->UserID }}</strong></td>
                                    <td>{{ $user->UserName }}</td>
                                    <td>{{ $user->UserEmail }}</td>
                                    <td>{{ $user->UserPhoneNum ?? '-' }}</td>
                                    <td>{{ $user->created_at ? $user->created_at->format('M d, Y') : '-' }}</td>
                                    <td><span style="color: #059669; font-weight: 600;">Active</span></td>
                                    <td class="actions-cell">
                                        <a href="{{ route('admin.user.edit', $user->UserID) }}" class="action-btn">
                                            Edit Profile
                                        </a>
                                        <a href="{{ route('admin.user.view', $user->UserID) }}" class="action-btn">
                                            View Profile
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="empty-state">
                                        <i class="fas fa-users"></i>
                                        <h3>No Users Found</h3>
                                        <p>There are currently no public users in the system.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Agency Users Card -->
            <div class="card mt-8">
                <div class="card-header">
                    <h2 class="profile-header">All Agency User</h2>
                    <div class="search-form">
                        <form action="{{ route('admin.users') }}" method="GET"
                            style="display:flex; flex-grow:1; gap:0.5rem;">
                            <input type="text" name="agency_search" placeholder="Search agency...">
                            <button type="submit">Search</button>
                        </form>
                        <a href="{{ route('admin.users') }}" class="btn-show-all">Show All</a>
                    </div>
                </div>

                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th><i class="fas fa-id-card mr-2"></i>ID</th>
                                <th><i class="fas fa-building mr-2"></i>Agency Name</th>
                                <th><i class="fas fa-user mr-2"></i>Username</th>
                                <th><i class="fas fa-envelope mr-2"></i>Email</th>
                                <th><i class="fas fa-phone mr-2"></i>Phone</th>
                                <th><i class="fas fa-calendar-plus mr-2"></i>Created At</th>
                                <th><i class="fas fa-check-circle mr-2"></i>Status</th>
                                <th><i class="fas fa-cogs mr-2"></i>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($agencies ?? [] as $agency)
                                @if ($agency && is_object($agency))
                                    <tr>
                                        <td><strong>{{ $agency->AgencyID ?? '-' }}</strong></td>
                                        <td>{{ $agency->AgencyName ?? '-' }}</td>
                                        <td>{{ $agency->AgencyUserName ?? '-' }}</td>
                                        <td>{{ $agency->AgencyEmail ?? '-' }}</td>
                                        <td>{{ $agency->AgencyPhoneNum ?? '-' }}</td>
                                        <td>{{ $agency->created_at ? $agency->created_at->format('M d, Y') : '-' }}
                                        </td>
                                        <td>
                                            @if (isset($agency->AgencyPhoneNum) && $agency->AgencyPhoneNum)
                                                <span style="color: #059669; font-weight: 600;">Active</span>
                                            @else
                                                <span style="color: #dc2626; font-weight: 600;">Inactive</span>
                                            @endif
                                        </td>
                                        <td class="actions-cell">
                                            @if (isset($agency->AgencyID))
                                                <a href="{{ route('admin.agency.edit', $agency->AgencyID) }}"
                                                    class="action-btn">
                                                    Edit Profile
                                                </a>
                                                <a href="{{ route('admin.agency.view', $agency->AgencyID) }}"
                                                    class="action-btn">
                                                    View Profile
                                                </a>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="8" class="empty-state">
                                        <i class="fas fa-building"></i>
                                        <h3>No Agencies Found</h3>
                                        <p>There are currently no agencies registered in the system.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endif {{-- End of main users/agencies listing view --}}

        {{-- Enhanced Success message --}}
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

        <!-- Enhanced JavaScript for Mobile Menu and Interactions -->
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

            // Enhanced table row interactions
            document.addEventListener('DOMContentLoaded', function() {
                const tableRows = document.querySelectorAll('tbody tr');

                tableRows.forEach(row => {
                    row.addEventListener('mouseenter', function() {
                        this.style.transform = 'scale(1.002)';
                    });

                    row.addEventListener('mouseleave', function() {
                        this.style.transform = 'scale(1)';
                    });
                });

                // Add smooth scrolling for large tables
                const tableContainers = document.querySelectorAll('.table-container');
                tableContainers.forEach(container => {
                    container.style.scrollBehavior = 'smooth';
                });
            });
        </script>
    </div>
</body>

</html>
