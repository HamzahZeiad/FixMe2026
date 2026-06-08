<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Register</title>
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

        /* Smooth transitions for all elements */
        * {
            transition: all 0.4s ease-in-out;
        }

        .signin-link {
            display: inline-block;
            background: linear-gradient(145deg, #4f8cff, #0057ff);
            color: #ffffff;
            font-weight: 600;
            border-radius: 0.75rem;
            padding: 0.75rem 1.5rem;
            width: 100%;
            max-width: 350px;
            margin: 0 auto;
            font-size: 1.2rem;
            text-decoration: none;
            box-shadow: 0 4px 12px rgba(79, 140, 255, 0.3);
            transition: all 0.3s ease;
        }

        .signin-link:hover {
            background: linear-gradient(145deg, #0057ff, #003bbd);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(79, 140, 255, 0.4);
        }

        .input-smooth,
        .btn-smooth {
            border-radius: 20px;
            background: linear-gradient(145deg, #e6ebfc, #c5cee9);
            box-shadow: inset 6px 6px 8px rgba(59, 130, 246, 0.2), inset -6px -6px 8px rgba(255, 255, 255, 0.7);
            border: none;
            padding: 1rem 1.25rem;
            font-size: 1.125rem;
            color: #283d63;
            font-weight: 500;
            width: 100%;
            cursor: text;
            transition: background 0.4s ease-in-out, box-shadow 0.4s ease-in-out;
        }

        /* Light Effect on Hover */
        .input-smooth:hover {
            background: linear-gradient(145deg, #c5cee9, #e6ebfc);
            box-shadow: inset 6px 6px 8px rgba(59, 130, 246, 0.3), inset -6px -6px 8px rgba(255, 255, 255, 0.6),
                0 0 8px rgba(59, 130, 246, 0.5);
        }

        .input-smooth:focus {
            outline: none;
            box-shadow: inset 6px 6px 8px rgba(59, 130, 246, 0.6), inset -6px -6px 8px rgba(255, 255, 255, 0.9),
                0 0 12px rgba(59, 130, 246, 0.7);
            background: linear-gradient(145deg, #c5cee9, #e6ebfc);
            color: #1a2a4c;
            font-weight: 600;
            transform: scale(1.02);
        }

        .btn-smooth {
            background: linear-gradient(145deg, #4f8cff, #0057ff);
            color: #ffffff;
            font-weight: 600;
            border-radius: 0.75rem;
            border: none;
            padding: 0.75rem 1.5rem;
            font-size: 1.125rem;
            width: 100%;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(79, 140, 255, 0.3);
        }

        .btn-smooth:hover {
            background: linear-gradient(145deg, #0057ff, #003bbd);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(79, 140, 255, 0.4);
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



        /* Sidebar Styling */
        .sidebar {
            position: fixed;
            top: 56px;
            left: 0;
            width: 14rem;
            height: calc(100vh - 56px);
            background: #d2dbf6;
            border-top-right-radius: 1.5rem;
            border-bottom-right-radius: 1.5rem;
            box-shadow: 0 4px 15px rgba(40, 61, 99, 0.1);
            padding: 1.5rem 0;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
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
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: #283d63;
            text-decoration: none;
            font-weight: 500;
            border-radius: 0.75rem;
            transition: all 0.3s ease;
        }

        .sidebar-link i {
            font-size: 1.1rem;
            width: 1.25rem;
            text-align: center;
        }

        .sidebar-link:hover {
            background: #b9c8f6;
            color: #0057ff;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 87, 255, 0.2);
        }

        /* Main Content Area */
        .main-content {
            margin-left: 14rem;
            margin-top: 56px;
            padding: 2rem;
            min-height: calc(100vh - 56px);
            background: transparent;
        }

        .card {
            background: #eef2ff;
            padding: 2rem 2.5rem;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            max-width: 450px;
            width: 100%;
            box-sizing: border-box;
            margin: 2rem auto;
            backdrop-filter: blur(10px);
            /* Add blur effect for better visibility */
            opacity: 0;
            animation: slideInUp 0.8s ease-out forwards 0.3s;
        }

        /* Help Center Styling */
        .help-center {
            position: fixed;
            top: 0;
            right: -400px;
            width: 380px;
            height: 100vh;
            background: #ffffff;
            box-shadow: -5px 0 15px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            transition: right 0.4s ease-in-out;
            padding: 2rem;
            overflow-y: auto;
        }

        .help-center.active {
            right: 0;
        }

        /* Modal Overlay */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease-in-out;
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .help-center h2 {
            font-size: 1.75rem;
            font-weight: 600;
            color: #283d63;
            margin-bottom: 2rem;
        }

        .help-center .close-btn {
            position: absolute;
            top: 1.25rem;
            right: 1.25rem;
            font-size: 1.5rem;
            color: #283d63;
            cursor: pointer;
        }

        .help-topic {
            border-bottom: 1px solid #e5e7eb;
            padding: 1rem 0;
        }

        .help-topic-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            color: #4b5563;
            font-size: 1.1rem;
            padding: 0.5rem 0;
        }

        .help-topic-header i {
            transition: transform 0.3s ease;
        }

        .help-topic-header.active i {
            transform: rotate(180deg);
        }

        .help-topic-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
            padding: 0 0.5rem;
            color: #6b7280;
        }

        .help-topic-content.active {
            max-height: 300px;
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
        }

        /* Validation error styling */
        .error-message {
            color: #dc3545;
            font-size: 0.875rem;
            font-weight: 500;
            margin-top: 0.5rem;
            margin-bottom: 1rem;
            display: block;
        }

        .input-smooth.is-invalid {
            border: 2px solid #dc3545;
            box-shadow: inset 6px 6px 8px rgba(220, 53, 69, 0.2), inset -6px -6px 8px rgba(255, 255, 255, 0.7);
        }

        /* Animation Keyframes */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
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

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        /* Page Load Animation */
        body {
            opacity: 0;
            animation: fadeIn 0.8s ease-in-out forwards;
        }

        /* Form Field Animations */
        .input-smooth {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .input-smooth:focus {
            transform: scale(1.02);
            box-shadow: 0 0 15px rgba(59, 130, 246, 0.5);
        }

        /* Button Animation Enhancements */
        .btn-smooth {
            transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .btn-smooth:hover {
            transform: translateY(-5px) scale(1.03);
            box-shadow: 0 10px 20px rgba(59, 130, 246, 0.4);
        }

        .signin-link {
            animation: float 6s ease-in-out infinite;
        }

        /* Form submission animation */
        form.submitting .btn-smooth {
            pointer-events: none;
            animation: pulse 1.5s infinite;
        }

        /* Responsive Design */
        @media (max-width: 900px) {
            .sidebar {
                width: 60px;
            }

            .sidebar a span {
                display: none;
            }

            .main-content {
                margin-left: 60px;
            }
        }

        @media (max-width: 768px) {
            .top-bar {
                padding: 1rem;
            }



            .top-bar .user-area {
                position: static;
                margin-left: auto;
            }

            .main-content {
                padding: 1rem;
            }
        }

        /* ...existing styles for alerts, forms, etc... */
    </style>
</head>

<body>
    <!-- Top Bar -->
    <header class="top-bar">
        <div class="logo">AuthenticityHub</div>

    </header>

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-nav">
            <a href="{{ route('home') }}" class="sidebar-link">
                <i class="fas fa-home"></i>
                <span>Home</span>
            </a>


            <a href="#" class="sidebar-link" id="help-link">
                <i class="fas fa-question-circle"></i>
                <span>Help</span>
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <div class="flex justify-center items-center">
            <div class="card">
                <h2 style="font-size: 2rem;"><b>Create Account</b></h2>

                @if (session('message'))
                    <div class="alert alert-success">{{ session('message') }}</div>
                @endif

                <form method="POST" action="{{ route('register') }}" novalidate>
                    @csrf

                    <label for="UserName">Username</label>
                    <input type="text" name="UserName" value="{{ old('UserName') }}"
                        class="input-smooth @error('UserName') is-invalid @enderror" required />
                    @error('UserName')
                        <span class="error-message">{{ $message }}</span>
                    @enderror

                    <label for="UserEmail">Email address</label>
                    <input type="email" name="UserEmail" value="{{ old('UserEmail') }}"
                        class="input-smooth @error('UserEmail') is-invalid @enderror" required />
                    @error('UserEmail')
                        <span class="error-message">{{ $message }}</span>
                    @enderror

                    <label for="UserPassword">Password</label>
                    <input type="password" name="UserPassword"
                        class="input-smooth @error('UserPassword') is-invalid @enderror" required />
                    @error('UserPassword')
                        <span class="error-message">{{ $message }}</span>
                    @enderror

                    <label for="UserPassword_confirmation">Confirm Password</label>
                    <input type="password" name="UserPassword_confirmation" class="input-smooth" required />

                    <button type="submit" class="btn-smooth mt-4 w-full">Register</button>
                </form>
                <div class="mt-6 text-center">
                    <div style="font-weight:600; color:#283d63; margin-bottom: 1rem;">
                        Already have an account?
                    </div>
                    <a href="{{ route('login') }}" class="signin-link">
                        Sign in
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Overlay -->
    <div class="modal-overlay" id="modal-overlay"></div>

    <!-- Help Center -->
    <div class="help-center" id="help-center">
        <h2>Account Creation Help</h2>
        <div class="close-btn" id="close-help">&times;</div>

        <div class="help-topic">
            <div class="help-topic-header" data-topic="create">
                How to create your account
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="help-topic-content" id="create">
                <p>Creating your account is simple:</p>
                <ol>
                    <li>Fill in your username in the Username field</li>
                    <li>Enter a valid email address you have access to</li>
                    <li>Choose a strong password following our guidelines</li>
                    <li>Confirm your password by typing it again</li>
                    <li>Click the "Register" button to complete registration</li>
                </ol>
                <p>After registration, you'll receive a confirmation email to verify your account.</p>
            </div>
        </div>

        <div class="help-topic">
            <div class="help-topic-header" data-topic="password">
                Password requirements
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="help-topic-content" id="password">
                <p>Your password must meet these requirements:</p>
                <ul>
                    <li>At least 8 characters long</li>
                    <li>Include at least one uppercase letter (A-Z)</li>
                    <li>Include at least one lowercase letter (a-z)</li>
                    <li>Include at least one number (0-9)</li>
                    <li>Include at least one special character (!@#$%^&*)</li>
                </ul>
                <p>A strong password is essential for keeping your account secure.</p>
            </div>
        </div>

        <div class="help-topic">
            <div class="help-topic-header" data-topic="email">
                Email verification
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="help-topic-content" id="email">
                <p>After registering, you'll need to verify your email:</p>
                <ol>
                    <li>Check your inbox for a verification email from AuthenticityHub</li>
                    <li>If you don't see it, check your spam/junk folder</li>
                    <li>Click the verification link in the email</li>
                    <li>Once verified, you can log in to your account</li>
                </ol>
                <p>Email verification links expire after 24 hours. If yours expires, you can request a new one from the
                    login page.</p>
            </div>
        </div>

        <div class="help-topic">
            <div class="help-topic-header" data-topic="username">
                Choosing a username
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="help-topic-content" id="username">
                <p>Tips for selecting a good username:</p>
                <ul>
                    <li>Must be between 4-20 characters</li>
                    <li>Can contain letters, numbers, and underscores</li>
                    <li>Cannot contain spaces or special characters</li>
                    <li>Must be unique (not already taken by another user)</li>
                    <li>Cannot contain offensive or inappropriate language</li>
                </ul>
                <p>Your username will be visible to other users on the platform.</p>
            </div>
        </div>

        <div class="help-topic">
            <div class="help-topic-header" data-topic="support">
                Need more help?
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="help-topic-content" id="support">
                <p>If you're having trouble creating your account:</p>
                <ul>
                    <li>Email: support@authenticityhub.com</li>
                    <li>Phone: 1-800-AUTH-HUB</li>
                    <li>Live chat: Available Monday-Friday, 9am-5pm EST</li>
                </ul>
                <p>Our support team is ready to assist you with any registration issues.</p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add animation for form fields
            const formInputs = document.querySelectorAll('.input-smooth');
            formInputs.forEach((input, index) => {
                input.style.opacity = '0';
                setTimeout(() => {
                    input.style.opacity = '1';
                    input.style.animation = 'slideInUp 0.5s ease-out forwards';
                }, 100 * (index + 1));
            });

            // Form submission animation
            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                if (!form.checkValidity()) return;

                form.classList.add('submitting');
                const submitBtn = this.querySelector('[type="submit"]');
                const originalText = submitBtn.innerText;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';

                // Allow the form to submit normally
            });

            // Help Center Functionality
            const helpLink = document.getElementById('help-link');
            const helpCenter = document.getElementById('help-center');
            const closeHelp = document.getElementById('close-help');
            const modalOverlay = document.getElementById('modal-overlay');

            helpLink.addEventListener('click', function(e) {
                e.preventDefault();
                helpCenter.classList.add('active');
                modalOverlay.classList.add('active');
                document.body.style.overflow = 'hidden'; // Prevent scrolling
            });

            closeHelp.addEventListener('click', function() {
                helpCenter.classList.remove('active');
                modalOverlay.classList.remove('active');
                document.body.style.overflow = ''; // Re-enable scrolling
            });

            modalOverlay.addEventListener('click', function() {
                helpCenter.classList.remove('active');
                modalOverlay.classList.remove('active');
                document.body.style.overflow = ''; // Re-enable scrolling
            });

            // Topic expansion
            const helpTopicHeaders = document.querySelectorAll('.help-topic-header');

            helpTopicHeaders.forEach(header => {
                header.addEventListener('click', function() {
                    const topicId = this.getAttribute('data-topic');
                    const content = document.getElementById(topicId);

                    // Toggle active class for the header
                    this.classList.toggle('active');

                    // Toggle active class for the content
                    content.classList.toggle('active');
                });
            });
        });
    </script>
</body>

</html>
