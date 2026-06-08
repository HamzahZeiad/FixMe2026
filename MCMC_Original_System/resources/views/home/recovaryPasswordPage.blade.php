<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Password Recovery</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #6a7fd0, #6bc5f3);
            margin: 0;
            padding: 0;
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



        .top-bar nav {
            margin-left: 2rem;
            display: flex;
            align-items: center;
            gap: 1.2rem;
            position: absolute;
            right: 2rem;
        }

        .top-bar nav a {
            color: #283d63;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }

        .top-bar nav a:hover {
            color: #0057ff;
        }

        /* Standardized Sidebar Styling */
        .sidebar {
            position: fixed;
            top: 56px;
            left: 0;
            width: 14rem;
            height: calc(100vh - 56px);
            background: #e6edfa;
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
            flex: 1;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.7rem;
            padding: 0.75rem 1rem;
            color: #2d3a4b;
            text-decoration: none;
            font-weight: 500;
            border-radius: 0.75rem;
            transition: all 0.3s ease;
        }

        .sidebar-link:hover {
            background: #d0e2ff;
            color: #4f8cff;
            transform: translateX(4px);
        }

        .sidebar-link.active {
            background: #d0e2ff;
            color: #4f8cff;
        }

        .sidebar-link i {
            width: 1.2rem;
            text-align: center;
        }

        /* Main Content Area */
        .main-content {
            margin-left: 14rem;
            margin-top: 56px;
            padding: 2rem;
            min-height: calc(100vh - 56px);
            background: transparent;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Animation Styling */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
            }

            to {
                opacity: 0;
            }
        }

        @keyframes slideInRight {
            from {
                transform: translateX(50px);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOutLeft {
            from {
                transform: translateX(0);
                opacity: 1;
            }

            to {
                transform: translateX(-50px);
                opacity: 0;
            }
        }

        @keyframes slideInLeft {
            from {
                transform: translateX(-50px);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }

            to {
                transform: translateX(50px);
                opacity: 0;
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.4s ease-in-out forwards;
        }

        .animate-fade-out {
            animation: fadeOut 0.4s ease-in-out forwards;
        }

        .animate-slide-in-right {
            animation: slideInRight 0.5s ease-in-out forwards;
        }

        .animate-slide-out-left {
            animation: slideOutLeft 0.5s ease-in-out forwards;
        }

        .animate-slide-in-left {
            animation: slideInLeft 0.5s ease-in-out forwards;
        }

        .animate-slide-out-right {
            animation: slideOutRight 0.5s ease-in-out forwards;
        }

        /* Form Styling */
        .input-group {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .input-icon {
            background: #5c5c5c;
            border-radius: 16px 0 0 16px;
            padding: 0.85rem 1rem;
            display: flex;
            align-items: center;
            height: 54px;
        }

        .input-icon i {
            color: #fff;
            font-size: 1.3rem;
        }

        .input-smooth {
            border-radius: 0 16px 16px 0;
            background: #fff;
            border: none;
            padding: 1rem 1.25rem;
            font-size: 1.125rem;
            color: #283d63;
            font-weight: 500;
            width: 100%;
            box-shadow: 0 2px 8px rgb(255, 255, 255);
            transition: all 0.4s ease-in-out;
            outline: none;
        }

        .input-smooth:focus,
        .input-smooth:hover {
            background: linear-gradient(145deg, #e6ebfc, #c5cee9);
            box-shadow: 0 0 16px 4px #b6d0fe;
        }

        /* validation error styling */
        .input-smooth.is-invalid {
            border: 2px solid #dc3545;
            box-shadow: 0 0 16px 4px rgba(220, 53, 69, 0.3);
        }

        .error-message {
            color: #dc3545;
            font-size: 0.875rem;
            font-weight: 500;
            margin-top: 0.5rem;
            margin-bottom: 1rem;
            display: block;
        }

        /* Card Styling */
        .card {
            background: rgba(238, 242, 255, 0.9);
            padding: 2.5rem 3rem;
            border-radius: 18px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            max-width: 450px;
            width: 100%;
            box-sizing: border-box;
            backdrop-filter: blur(10px);
        }

        .card h2 {
            color: #283d63;
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 2rem;
            text-align: center;
        }

        .card label {
            display: block;
            color: #283d63;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        /* Button Styling */
        .btn-smooth {
            background: linear-gradient(145deg, #4f8cff, #357ae8);
            color: #ffffff;
            font-weight: 600;
            cursor: pointer;
            border-radius: 0.75rem;
            padding: 0.75rem 1.5rem;
            width: 100%;
            font-size: 1rem;
            border: none;
            box-shadow: 0 4px 15px rgba(79, 140, 255, 0.3);
            transition: all 0.3s ease;
        }

        .btn-smooth:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(79, 140, 255, 0.4);
        }

        .back-button {
            margin-top: 1rem;
            background: none;
            color: #4f8cff;
            border: none;
            font-weight: 600;
            font-size: 1rem;
            width: 100%;
            cursor: pointer;
            text-decoration: underline;
            transition: color 0.3s ease;
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
        }

        .back-button:hover {
            color: #357ae8;
            background: rgba(79, 140, 255, 0.1);
            text-decoration: none;
        }

        /* Alert Styling */
        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-weight: 500;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
        }

        /* Help Section Styling */
        .help-content {
            display: none;
            /* Hidden by default */
            background: rgba(238, 242, 255, 0.9);
            padding: 2.5rem 3rem;
            border-radius: 18px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            max-width: 600px;
            width: 100%;
            box-sizing: border-box;
            backdrop-filter: blur(10px);
        }

        .help-content h2 {
            color: #283d63;
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .help-section {
            margin-bottom: 2rem;
        }

        .help-section h3 {
            color: #283d63;
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .help-section p {
            color: #505c84;
            line-height: 1.6;
            margin-bottom: 1rem;
        }

        .contact-info {
            background: #e0e7fa;
            padding: 1.5rem;
            border-radius: 12px;
            margin-top: 1.5rem;
        }

        .contact-info p {
            display: flex;
            align-items: center;
            margin-bottom: 0.7rem;
        }

        .contact-info i {
            color: #5a709a;
            font-size: 1.2rem;
            margin-right: 1rem;
            width: 24px;
            text-align: center;
        }

        .back-to-recovery {
            background: linear-gradient(145deg, #4f8cff, #357ae8);
            color: #ffffff;
            font-weight: 600;
            cursor: pointer;
            border-radius: 0.75rem;
            padding: 0.75rem 1.5rem;
            width: 100%;
            font-size: 1rem;
            border: none;
            box-shadow: 0 4px 15px rgba(79, 140, 255, 0.3);
            transition: all 0.3s ease;
            margin-top: 1.5rem;
        }

        .back-to-recovery:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(79, 140, 255, 0.4);
        }

        /* Loading and Success Styling */
        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(238, 242, 255, 0.95);
            border-radius: 18px;
            display: none;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 10;
        }

        .loading-spinner {
            width: 40px;
            height: 40px;
            border: 4px solid #e6edfa;
            border-top: 4px solid #4f8cff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-bottom: 1rem;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .loading-text {
            color: #283d63;
            font-weight: 600;
            font-size: 1.1rem;
            text-align: center;
            margin-bottom: 1rem;
        }

        .countdown {
            color: #4f8cff;
            font-weight: 700;
            font-size: 2rem;
        }

        .success-message {
            background: #dcfce7;
            color: #166534;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-weight: 500;
            display: none;
            text-align: center;
        }

        .success-message.show {
            display: block;
            animation: fadeIn 0.5s ease-in-out;
        }

        /* Responsive Design */
        @media (max-width: 900px) {
            .main-content {
                margin-left: 0;
                padding: 1rem;
            }

            .sidebar {
                position: static;
                width: 100%;
                height: auto;
                flex-direction: row;
                box-shadow: none;
                padding: 0.5rem 0;
                border-radius: 0;
                margin-top: 0;
                top: 56px;
            }

            .sidebar-nav {
                flex-direction: row;
                padding: 0 1rem;
            }

            .sidebar-link {
                flex: 1;
                justify-content: center;
                border-bottom: 4px solid transparent;
            }

            .sidebar-link:hover,
            .sidebar-link.active {
                border-bottom: 4px solid #4f8cff;
                transform: none;
            }

            .sidebar-link span {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .top-bar {
                padding: 1rem;
            }



            .top-bar nav {
                position: static;
                margin-left: auto;
            }

            .main-content {
                padding: 1rem;
            }

            .card {
                padding: 2rem;
                margin: 1rem;
            }
        }
    </style>
</head>

<body>
    <!-- Top Bar -->
    <header class="top-bar">
        <div class="logo">AuthenticityHub</div>

    </header>

    <!-- Sidebar -->
    <aside class="sidebar">
        <nav class="sidebar-nav">
            <a href="{{ route('home') }}" class="sidebar-link">
                <i class="fas fa-home"></i>
                <span>Home</span>
            </a>
            <a href="#" id="recovery-link" class="sidebar-link active">
                <i class="fas fa-key"></i>
                <span>Recovery</span>
            </a>
            <a href="#" id="help-link" class="sidebar-link">
                <i class="fas fa-question-circle"></i>
                <span>Help</span>
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Recovery Form Card -->
        <div class="card" id="recovery-card" style="position: relative;">
            <!-- Loading Overlay -->
            <div class="loading-overlay" id="loading-overlay">
                <div class="loading-spinner"></div>
                <div class="loading-text">Verifying your email...</div>
                <div class="countdown" id="countdown">5</div>
            </div>

            <h2>Password Recovery</h2>

            <!-- Success Message -->
            <div class="success-message" id="success-message">
                <i class="fas fa-check-circle" style="margin-right: 0.5rem;"></i>
                Your email has been successfully verified!
            </div>

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            @if (session('phone_required'))
                <div class="alert alert-error"
                    style="background: linear-gradient(135deg, #fef3c7, #fde68a); border: 2px solid #f59e0b; color: #92400e;">
                    <i class="fas fa-exclamation-triangle" style="margin-right: 0.5rem;"></i>
                    {{ session('phone_required') }}
                </div>
            @endif

            <!-- Phone and Password form for agencies without phone -->
            @if (session('phone_verification_agency_id'))
                <div id="agency-setup-container">
                    <h3 style="color: #283d63; margin-bottom: 1rem;">Complete Account Setup</h3>
                    <form method="POST" action="{{ route('agency.phone.update') }}" novalidate>
                        @csrf

                        <label for="phone">Phone Number</label>
                        <div class="input-group">
                            <span class="input-icon"><i class="fas fa-phone"></i></span>
                            <input type="tel" name="phone" id="phone" value="{{ old('phone') }}"
                                placeholder="Enter your phone number"
                                class="input-smooth @error('phone') is-invalid @enderror" required />
                        </div>
                        @error('phone')
                            <span class="error-message">{{ $errors->first('phone') }}</span>
                        @enderror

                        <label for="password">New Password</label>
                        <div class="input-group">
                            <span class="input-icon"><i class="fas fa-lock"></i></span>
                            <input type="password" name="password" id="password" placeholder="New Password"
                                class="input-smooth @error('password') is-invalid @enderror" required />
                        </div>
                        @error('password')
                            <span class="error-message">{{ $errors->first('password') }}</span>
                        @enderror

                        <label for="password_confirmation">Confirm Password</label>
                        <div class="input-group">
                            <span class="input-icon"><i class="fas fa-lock"></i></span>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                placeholder="Confirm New Password" class="input-smooth" required />
                        </div>

                        <button type="submit" class="btn-smooth">
                            Complete Setup
                        </button>
                        <button type="button" onclick="window.location.href='{{ route('login') }}'"
                            class="back-button">
                            Back to Login
                        </button>
                    </form>
                </div>
            @else
                <!-- Regular password recovery forms -->
                <!-- Email verification form - shown by default or when no password errors -->
                <div id="email-form-container" style="display: {{ $errors->has('password') ? 'none' : 'block' }};">
                    <form method="POST" action="{{ route('password.email') }}" novalidate id="email-form">
                        @csrf

                        <label for="email">Email address</label>
                        <div class="input-group">
                            <span class="input-icon"><i class="fas fa-envelope"></i></span>
                            <input type="email" name="email" id="email" value="{{ old('email') }}"
                                placeholder="Enter your email" class="input-smooth @error('email') is-invalid @enderror"
                                required />
                        </div>
                        @error('email')
                            <span class="error-message">{{ $errors->first('email') }}</span>
                        @enderror

                        <button type="submit" class="btn-smooth">
                            Send Recovery Link
                        </button>
                        <button type="button" onclick="window.location.href='{{ route('login') }}'"
                            class="back-button">
                            Back to Login
                        </button>
                    </form>
                </div>

                <!-- Password reset form - shown when password errors exist -->
                <div id="password-form-container"
                    style="display: {{ $errors->has('password') ? 'block' : 'none' }};">
                    <form method="POST" action="{{ route('password.reset') }}" novalidate>
                        @csrf
                        <input type="hidden" name="email" id="verified-email" value="{{ old('email') }}">

                        <label for="new-password">New Password</label>
                        <div class="input-group">
                            <span class="input-icon"><i class="fas fa-lock"></i></span>
                            <input type="password" name="password" id="new-password" placeholder="New Password"
                                class="input-smooth @error('password') is-invalid @enderror" required />
                        </div>
                        @error('password')
                            <span class="error-message">{{ $errors->first('password') }}</span>
                        @enderror

                        <label for="confirm-password">Confirm Password</label>
                        <div class="input-group">
                            <span class="input-icon"><i class="fas fa-lock"></i></span>
                            <input type="password" name="password_confirmation" id="confirm-password"
                                placeholder="Confirm New Password" class="input-smooth" required />
                        </div>

                        <button type="submit" class="btn-smooth">
                            Reset Password
                        </button>
                        <button type="button" id="back-to-email" class="back-button">
                            Back to Email Verification
                        </button>
                    </form>
                </div>
            @endif
        </div>

        <!-- Help Content -->
        <div class="help-content" id="help-content">
            <h2>Help & Support</h2>

            <div class="help-section">
                <h3>Password Recovery Process</h3>
                <p>If you've forgotten your password, don't worry! Our password recovery process is simple and secure:
                </p>
                <ol style="margin-left: 1.5rem; margin-bottom: 1rem; color: #505c84;">
                    <li>Enter your email address in the form</li>
                    <li>We'll verify your email is registered in our system</li>
                    <li>Enter your new password and confirm it</li>
                    <li>Your password will be updated immediately</li>
                </ol>
                <p>For security reasons, we never send your existing password via email.</p>
            </div>

            <div class="help-section">
                <h3>Frequently Asked Questions</h3>
                <p><strong>Q: I'm not receiving the verification email. What should I do?</strong><br>
                    A: Our system verifies your email instantly without sending an email. If your email is registered,
                    you'll be prompted to create a new password immediately.</p>

                <p><strong>Q: Is my password securely stored?</strong><br>
                    A: Yes, all passwords are encrypted using industry-standard hashing algorithms to ensure your
                    security.</p>

                <p><strong>Q: What if I still can't access my account?</strong><br>
                    A: Please contact our support team using the information below.</p>
            </div>

            <div class="contact-info">
                <h3>Contact Support</h3>
                <p><i class="fas fa-envelope"></i> support@authenticityhub.com</p>
                <p><i class="fas fa-phone"></i> +123 456 7890</p>
                <p><i class="fas fa-clock"></i> Monday-Friday, 9:00 AM - 5:00 PM</p>
            </div>

            <button class="back-to-recovery" id="back-to-recovery">Return to Password Recovery</button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const recoveryCard = document.getElementById('recovery-card');
            const helpContent = document.getElementById('help-content');
            const recoveryLink = document.getElementById('recovery-link');
            const helpLink = document.getElementById('help-link');
            const backToRecovery = document.getElementById('back-to-recovery');

            // Email verification elements
            const emailForm = document.getElementById('email-form');
            const emailFormContainer = document.getElementById('email-form-container');
            const passwordFormContainer = document.getElementById('password-form-container');
            const loadingOverlay = document.getElementById('loading-overlay');
            const successMessage = document.getElementById('success-message');
            const countdownElement = document.getElementById('countdown');
            const backToEmailBtn = document.getElementById('back-to-email');
            const verifiedEmailInput = document.getElementById('verified-email');

            // Check if we're in agency setup mode
            const agencySetupContainer = document.getElementById('agency-setup-container');
            if (agencySetupContainer) {
                // Hide the regular email/password recovery sections
                const emailContainer = document.getElementById('email-form-container');
                const passwordContainer = document.getElementById('password-form-container');
                if (emailContainer) emailContainer.style.display = 'none';
                if (passwordContainer) passwordContainer.style.display = 'none';

                // Update the title
                const cardTitle = document.querySelector('.card h2');
                if (cardTitle) cardTitle.textContent = 'Account Setup Required';

                return; // Skip the regular recovery form logic
            }

            // Check if we have password validation errors on page load
            @if ($errors->has('password') && old('email'))
                // If we have password errors, ensure the email is set in the verified field
                if (verifiedEmailInput) {
                    verifiedEmailInput.value = '{{ old('email') }}';
                }
                // Focus on the password field for better UX
                const newPasswordField = document.getElementById('new-password');
                if (newPasswordField) {
                    newPasswordField.focus();
                }
            @endif

            // Handle email form submission
            emailForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const emailInput = document.getElementById('email');
                const email = emailInput.value.trim();

                // Basic email validation
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email)) {
                    // Show validation error
                    emailInput.classList.add('is-invalid');
                    let errorMsg = emailInput.parentNode.parentNode.querySelector('.error-message');
                    if (!errorMsg) {
                        errorMsg = document.createElement('span');
                        errorMsg.className = 'error-message';
                        emailInput.parentNode.parentNode.appendChild(errorMsg);
                    }
                    errorMsg.textContent = 'The email field must be a valid email address.';
                    return;
                }

                // Remove any existing error styling
                emailInput.classList.remove('is-invalid');
                const existingError = emailInput.parentNode.parentNode.querySelector('.error-message');
                if (existingError) {
                    existingError.remove();
                }

                // Show loading overlay
                loadingOverlay.style.display = 'flex';

                // Make AJAX call to verify email
                fetch('{{ route('password.email') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content'),
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            email: email
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Store email for password reset form
                            verifiedEmailInput.value = email;

                            // Start 5-second countdown for valid email
                            let countdown = 5;
                            countdownElement.textContent = countdown;

                            const countdownInterval = setInterval(() => {
                                countdown--;
                                countdownElement.textContent = countdown;

                                if (countdown <= 0) {
                                    clearInterval(countdownInterval);

                                    // Hide loading overlay
                                    loadingOverlay.style.display = 'none';

                                    // Show success message
                                    successMessage.classList.add('show');

                                    // Hide email form and show password form after a short delay
                                    setTimeout(() => {
                                        emailFormContainer.style.display = 'none';
                                        passwordFormContainer.style.display = 'block';

                                        // Focus on new password field
                                        document.getElementById('new-password').focus();
                                    }, 1000);
                                }
                            }, 1000);
                        } else {
                            // Hide loading overlay
                            loadingOverlay.style.display = 'none';

                            // Handle email verification failure
                            emailInput.classList.add('is-invalid');
                            let errorMsg = emailInput.parentNode.parentNode.querySelector(
                                '.error-message');
                            if (!errorMsg) {
                                errorMsg = document.createElement('span');
                                errorMsg.className = 'error-message';
                                emailInput.parentNode.parentNode.appendChild(errorMsg);
                            }
                            errorMsg.textContent = data.message ||
                                'Email verification failed. Please try again.';
                        }
                    })
                    .catch(error => {
                        // Hide loading overlay
                        loadingOverlay.style.display = 'none';

                        console.error('Error:', error);

                        // Show error message
                        emailInput.classList.add('is-invalid');
                        let errorMsg = emailInput.parentNode.parentNode.querySelector('.error-message');
                        if (!errorMsg) {
                            errorMsg = document.createElement('span');
                            errorMsg.className = 'error-message';
                            emailInput.parentNode.parentNode.appendChild(errorMsg);
                        }
                        errorMsg.textContent = 'An error occurred. Please try again.';
                    });
            });

            // Handle back to email button
            backToEmailBtn.addEventListener('click', function() {
                passwordFormContainer.style.display = 'none';
                emailFormContainer.style.display = 'block';
                successMessage.classList.remove('show');

                // Clear any existing error messages and styling
                const emailInput = document.getElementById('email');
                emailInput.classList.remove('is-invalid');
                const existingError = emailInput.parentNode.parentNode.querySelector('.error-message');
                if (existingError) {
                    existingError.remove();
                }
            });

            // Show help content and hide recovery form
            helpLink.addEventListener('click', function(e) {
                e.preventDefault();

                // Apply animations
                recoveryCard.classList.add('animate-slide-out-left');

                setTimeout(() => {
                    recoveryCard.style.display = 'none';
                    recoveryCard.classList.remove('animate-slide-out-left');

                    helpContent.style.display = 'block';
                    helpContent.classList.add('animate-slide-in-right');

                    setTimeout(() => {
                        helpContent.classList.remove('animate-slide-in-right');
                    }, 500);
                }, 400);

                recoveryLink.classList.remove('active');
                helpLink.classList.add('active');
            });

            // Show recovery form and hide help content
            function showRecovery() {
                // Apply animations
                helpContent.classList.add('animate-slide-out-right');

                setTimeout(() => {
                    helpContent.style.display = 'none';
                    helpContent.classList.remove('animate-slide-out-right');

                    recoveryCard.style.display = 'block';
                    recoveryCard.classList.add('animate-slide-in-left');

                    setTimeout(() => {
                        recoveryCard.classList.remove('animate-slide-in-left');
                    }, 500);
                }, 400);

                helpLink.classList.remove('active');
                recoveryLink.classList.add('active');
            }

            recoveryLink.addEventListener('click', function(e) {
                e.preventDefault();
                showRecovery();
            });

            backToRecovery.addEventListener('click', showRecovery);

            // File input preview handling (if exists)
            const fileInput = document.getElementById('UserProfilePicture');
            if (fileInput) {
                fileInput.addEventListener('change', function(e) {
                    // Handle file preview logic here
                });
            }
        });
    </script>
</body>

</html>
