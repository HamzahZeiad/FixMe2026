<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Agency Security Settings</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
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

        /* Enhanced Content Container */
        .content-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            box-shadow:
                0 20px 60px rgba(0, 0, 0, 0.1),
                0 8px 20px rgba(0, 0, 0, 0.06),
                inset 0 1px 0 rgba(255, 255, 255, 0.8);
            padding: 40px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            position: relative;
            overflow: hidden;
        }

        .content-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.8), transparent);
        }

        /* Enhanced Tabs */
        .tabs {
            display: flex;
            gap: 40px;
            border-bottom: 2px solid rgba(255, 89, 90, 0.1);
            margin-bottom: 40px;
            padding-bottom: 16px;
            position: relative;
        }

        .tab {
            padding: 8px 0;
            font-weight: 500;
            font-size: 1.1rem;
            color: #666;
            cursor: pointer;
            position: relative;
            transition: all 0.3s ease;
        }

        .tab:hover {
            color: #FF595A;
        }

        .tab.active {
            color: #FF595A;
            font-weight: 700;
        }

        .tab.active::after {
            content: '';
            position: absolute;
            bottom: -17px;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(135deg, #FF595A, #ff7b7c);
            border-radius: 2px;
            box-shadow: 0 2px 8px rgba(255, 89, 90, 0.4);
        }

        /* Enhanced Form Styling */
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 24px;
            animation: fadeInUp 0.4s ease-out;
            animation-fill-mode: both;
        }

        .form-group:nth-child(1) {
            animation-delay: 0.1s;
        }

        .form-group:nth-child(2) {
            animation-delay: 0.2s;
        }

        .form-group:nth-child(3) {
            animation-delay: 0.3s;
        }

        .form-group label {
            font-size: 0.95rem;
            font-weight: 600;
            color: #4a4237;
            margin-bottom: 4px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-group input {
            border: 2px solid rgba(0, 0, 0, 0.08);
            border-radius: 12px;
            padding: 14px 16px;
            font-size: 1rem;
            outline: none;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .form-group input:focus {
            border-color: #FF595A;
            box-shadow: 0 0 0 3px rgba(255, 89, 90, 0.1);
            background: rgba(255, 255, 255, 0.95);
            transform: translateY(-1px);
        }

        .form-group input:hover {
            border-color: rgba(255, 89, 90, 0.3);
        }

        /* Enhanced Button Styles */
        .btn-submit {
            background: linear-gradient(135deg, #FF595A 0%, #ff7b7c 100%);
            color: #ffffff;
            font-weight: 600;
            font-size: 1rem;
            padding: 14px 32px;
            border-radius: 12px;
            border: none;
            margin-top: 20px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow:
                0 8px 24px rgba(255, 89, 90, 0.3),
                0 4px 12px rgba(255, 89, 90, 0.2);
            position: relative;
            overflow: hidden;
            min-width: 160px;
        }

        .btn-submit::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s ease;
        }

        .btn-submit:hover {
            background: linear-gradient(135deg, #ff4748 0%, #ff6b6c 100%);
            transform: translateY(-2px);
            box-shadow:
                0 12px 32px rgba(255, 89, 90, 0.4),
                0 8px 16px rgba(255, 89, 90, 0.3);
        }

        .btn-submit:hover::before {
            left: 100%;
        }

        .btn-submit:active {
            transform: translateY(0px);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #e2e8f0, #cbd5e0);
            color: #4a5568;
            font-weight: 600;
            font-size: 0.95rem;
            padding: 12px 24px;
            border-radius: 12px;
            border: none;
            margin-top: 12px;
            margin-left: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 120px;
        }

        .btn-secondary:hover {
            background: linear-gradient(135deg, #cbd5e0, #a0aec0);
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
            color: #2d3748;
        }

        /* Enhanced Alert Styling */
        .alert {
            padding: 16px 20px;
            border-radius: 12px;
            margin-bottom: 24px;
            backdrop-filter: blur(10px);
            border: 1px solid;
            animation: slideInDown 0.5s ease-out;
            position: relative;
            overflow: hidden;
            font-weight: 500;
        }

        .alert::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: currentColor;
        }

        .alert-success {
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
            color: #155724;
            border-color: rgba(21, 87, 36, 0.2);
            box-shadow: 0 4px 12px rgba(21, 87, 36, 0.1);
        }

        .alert-error {
            background: linear-gradient(135deg, #f8d7da, #f1b0b7);
            color: #721c24;
            border-color: rgba(114, 28, 36, 0.2);
            box-shadow: 0 4px 12px rgba(114, 28, 36, 0.1);
        }

        /* Password Guidelines Styling */
        .password-guidelines {
            margin-top: 40px;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            padding-top: 24px;
            background: rgba(249, 250, 251, 0.8);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .password-guidelines h3 {
            font-size: 1.1rem;
            font-weight: 600;
            color: #4a4237;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .password-guidelines ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .password-guidelines li {
            padding: 8px 0;
            color: #6b7280;
            font-size: 0.95rem;
            position: relative;
            padding-left: 24px;
        }

        .password-guidelines li::before {
            content: '✓';
            position: absolute;
            left: 0;
            color: #10b981;
            font-weight: bold;
        }

        /* Form Container Styling */
        .form-container {
            max-width: 500px;
            margin: 0 auto;
            animation: fadeInUp 0.6s ease-out;
        }

        /* Modern animations */
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

        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
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

        /* Apply animations */
        .content-container {
            animation: fadeInUp 0.6s ease-out;
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

            .content-container {
                padding: 24px;
                border-radius: 16px;
            }

            .form-container {
                max-width: 100%;
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
    </style>
</head>

<body>
    <!-- Top Bar -->
    <header class="top-bar">
        <div class="logo">AuthenticityHub</div>
        <div class="user-area">
            <div class="welcome">
                <div>{{ $agency->AgencyName }}</div>
                <div style="font-size: 0.75rem; opacity: 0.8;">Welcome</div>
            </div>
            <div class="profile-pic-container">
                @if ($agency->AgencyProfilePicture)
                    <img src="{{ asset('storage/' . $agency->AgencyProfilePicture) }}" alt="Profile Picture">
                @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($agency->AgencyName) }}&background=eeeeee&color=666666"
                        alt="Profile Picture">
                @endif
            </div>
        </div>
    </header>

    <!-- Sidebar -->
    <aside class="sidebar">
        <nav class="sidebar-nav">
            <a href="{{ route('agency.home') }}" class="sidebar-link"><i class="fas fa-home"></i> <span>Home</span></a>
            <a href="{{ route('agency.profile') }}" class="sidebar-link"><i class="fas fa-cog"></i>
                <span>Profile</span></a>
            <a href="{{ route('agency.security') }}" class="sidebar-link active"><i class="fas fa-shield-alt"></i>
                <span>Security</span></a>
            <a href="{{ route('agency.view.display.inquiry') }}" class="sidebar-link"><i class="far fa-clipboard"></i>
                <span>Display and Approved</span></a>
            <a href="{{ route('login') }}" class="sidebar-link logout-link"><i class="fas fa-sign-out-alt"></i>
                <span>Logout</span></a>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="content-area">
        <div class="content-container">
            <!-- Tabs -->
            <div class="tabs">
                <div class="tab active">Password Management</div>
            </div>

            <!-- Success/Error Messages -->
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
            @endif

            <div class="form-container">
                @if (!session('agency_password_verified'))
                    <!-- Step 1: Verify current password -->
                    <form method="POST" action="{{ route('agency.password.verify') }}">
                        @csrf
                        <div class="form-group">
                            <label for="current_password">
                                <i class="fas fa-lock" style="color: #FF595A;"></i>
                                Current Password:
                            </label>
                            <input type="password" name="current_password" id="current_password"
                                placeholder="Enter your current password" required />
                            @error('current_password')
                                <span
                                    style="color: #e53e3e; font-size: 0.875rem; margin-top: 0.5rem; display: flex; align-items: center; gap: 0.25rem;">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn-submit">
                            <i class="fas fa-shield-alt" style="margin-right: 8px;"></i>
                            Verify Password
                        </button>
                    </form>
                @else
                    <!-- Step 2: Set new password -->
                    <form method="POST" action="{{ route('agency.password.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="new_password">
                                <i class="fas fa-key" style="color: #FF595A;"></i>
                                New Password:
                            </label>
                            <input type="password" name="new_password" id="new_password"
                                placeholder="Enter your new password" required />
                            @error('new_password')
                                <span
                                    style="color: #e53e3e; font-size: 0.875rem; margin-top: 0.5rem; display: flex; align-items: center; gap: 0.25rem;">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="new_password_confirmation">
                                <i class="fas fa-check-circle" style="color: #FF595A;"></i>
                                Confirm New Password:
                            </label>
                            <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                                placeholder="Confirm your new password" required />
                        </div>

                        <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                            <button type="submit" class="btn-submit">
                                <i class="fas fa-save" style="margin-right: 8px;"></i>
                                Update Password
                            </button>
                            <a href="{{ route('agency.password.edit.reset') }}" class="btn-secondary">
                                <i class="fas fa-times" style="margin-right: 6px;"></i>
                                Cancel
                            </a>
                        </div>
                    </form>
                @endif

                <div class="password-guidelines">
                    <h3>
                        <i class="fas fa-info-circle" style="color: #FF595A;"></i>
                        Password Guidelines
                    </h3>
                    <ul>
                        <li>Use at least 8 characters</li>
                        <li>Include a mix of letters, numbers, and symbols</li>
                        <li>Avoid using easily guessable information (birthdays, names, etc.)</li>
                        <li>Don't reuse passwords from other websites</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tab switching functionality
            const tabs = document.querySelectorAll('.tab');
            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    tabs.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');
                });
            });

            // Enhanced form submission animation
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    if (!form.checkValidity()) return;

                    const submitBtn = this.querySelector('[type="submit"]');
                    const originalText = submitBtn.innerHTML;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
                    submitBtn.style.pointerEvents = 'none';
                    submitBtn.disabled = true;
                });
            });

            // Enhanced input field interactions
            const inputs = document.querySelectorAll('input[type="password"]');
            inputs.forEach(input => {
                // Enhanced focus effects
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'translateY(-2px)';
                    this.parentElement.style.transition = 'transform 0.3s ease';
                });

                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'translateY(0)';
                });

                // Real-time password strength indicator
                if (input.name === 'new_password') {
                    input.addEventListener('input', function() {
                        showPasswordStrength(this.value);
                    });
                }

                // Password confirmation matching
                if (input.name === 'new_password_confirmation') {
                    input.addEventListener('input', function() {
                        const newPassword = document.getElementById('new_password').value;
                        if (this.value && this.value !== newPassword) {
                            this.style.borderColor = '#e74c3c';
                            this.style.boxShadow = '0 0 0 3px rgba(231, 76, 60, 0.1)';
                        } else if (this.value === newPassword && newPassword) {
                            this.style.borderColor = '#10b981';
                            this.style.boxShadow = '0 0 0 3px rgba(16, 185, 129, 0.1)';
                        } else {
                            this.style.borderColor = '';
                            this.style.boxShadow = '';
                        }
                    });
                }
            });

            // Add floating animation to form groups on scroll
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

            // Observe form groups for scroll animations
            document.querySelectorAll('.form-group').forEach((group, index) => {
                group.style.transform = 'translateY(20px)';
                group.style.opacity = '0';
                group.style.transition = `all 0.6s ease ${index * 0.1}s`;
                observer.observe(group);
            });

            // Password strength indicator
            function showPasswordStrength(password) {
                const strengthIndicator = document.getElementById('password-strength') || createStrengthIndicator();
                const strength = calculatePasswordStrength(password);

                strengthIndicator.className = `password-strength ${strength.class}`;
                strengthIndicator.textContent = strength.text;
            }

            function createStrengthIndicator() {
                const indicator = document.createElement('div');
                indicator.id = 'password-strength';
                indicator.style.cssText = `
                    margin-top: 8px;
                    padding: 6px 12px;
                    border-radius: 6px;
                    font-size: 0.875rem;
                    font-weight: 500;
                    transition: all 0.3s ease;
                `;

                const passwordField = document.getElementById('new_password');
                if (passwordField) {
                    passwordField.parentElement.appendChild(indicator);
                }

                return indicator;
            }

            function calculatePasswordStrength(password) {
                if (password.length === 0) return {
                    class: '',
                    text: ''
                };

                let score = 0;

                // Length check
                if (password.length >= 8) score += 1;
                if (password.length >= 12) score += 1;

                // Character type checks
                if (/[a-z]/.test(password)) score += 1;
                if (/[A-Z]/.test(password)) score += 1;
                if (/[0-9]/.test(password)) score += 1;
                if (/[^A-Za-z0-9]/.test(password)) score += 1;

                if (score <= 2) {
                    return {
                        class: 'weak',
                        text: '⚠️ Weak password',
                        style: 'background: #fef2f2; color: #dc2626; border: 1px solid #fecaca;'
                    };
                } else if (score <= 4) {
                    return {
                        class: 'medium',
                        text: '⚡ Medium strength',
                        style: 'background: #fffbeb; color: #d97706; border: 1px solid #fed7aa;'
                    };
                } else {
                    return {
                        class: 'strong',
                        text: '✅ Strong password',
                        style: 'background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0;'
                    };
                }
            }

            // Apply dynamic styles to strength indicator
            const style = document.createElement('style');
            style.textContent = `
                .password-strength.weak { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
                .password-strength.medium { background: #fffbeb; color: #d97706; border: 1px solid #fed7aa; }
                .password-strength.strong { background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; }
            `;
            document.head.appendChild(style);
        });
    </script>
</body>

</html>
