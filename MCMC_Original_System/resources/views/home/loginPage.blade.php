<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login</title>
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
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            background: #eef2ff;
            padding: 2rem 2.5rem;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            max-width: 450px;
            width: 100%;
            box-sizing: border-box;
            backdrop-filter: blur(10px);
        }

        .card:hover {
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.2);
        }

        .input-group {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
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
            outline: none;
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

        /* Add validation error styling */
        .input-smooth.is-invalid {
            border: 2px solid #dc3545 !important;
            box-shadow: 0 0 16px 4px rgba(220, 53, 69, 0.3) !important;
        }

        /* error styling for login icon */
        .input-icon.is-invalid {
            background: #dc3545 !important;
            border: 2px solid #dc3545 !important;
        }

        .input-icon.is-invalid i {
            color: #fff !important;
        }

        .error-message {
            color: #dc3545;
            font-size: 0.875rem;
            font-weight: 500;
            margin-top: 0.5rem;
            margin-bottom: 1rem;
            display: block;
        }

        /* Alert message styling */
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
            margin-top: 1.2rem;
        }

        .btn-smooth:hover {
            background: linear-gradient(145deg, #0057ff, #003bbd);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(79, 140, 255, 0.4);
        }

        .btn-smooth:active {
            transform: translateY(0px);
        }

        .register-link {
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
            text-align: center;
        }

        .register-link:hover {
            background: linear-gradient(145deg, #0057ff, #003bbd);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(79, 140, 255, 0.4);
        }

        .forgot-link {
            color: #5f5f5f;
            font-weight: 500;
            text-decoration: none;
            margin-left: 6px;
            transition: color 0.2s;
        }

        .forgot-link:hover {
            color: #000000;
            text-decoration: underline;
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

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-5px);
            }

            75% {
                transform: translateX(5px);
            }
        }

        /* Page Load Animation */
        body {
            opacity: 0;
            animation: fadeIn 0.8s ease-in-out forwards;
        }

        /* Card Animation */
        .card {
            opacity: 0;
            animation: slideInUp 0.8s ease-out forwards 0.3s;
        }

        /* Form error animation */
        .error-message {
            animation: shake 0.5s ease-in-out;
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

            .top-bar .logo {
                font-size: 1.3rem;
                left: 1rem;
            }

            .top-bar nav {
                position: static;
                margin-left: auto;
                right: 1rem;
            }

            .main-content {
                padding: 1rem;
                margin-left: 60px;
            }

            .card {
                margin: 1rem;
                padding: 2rem 1.5rem;
                border-radius: 20px;
            }

            .input-group {
                margin-bottom: 1.2rem;
            }

            .input-icon {
                padding: 0.9rem 1rem;
                height: 55px;
            }

            .input-smooth {
                padding: 1rem 1.2rem;
                font-size: 1rem;
            }

            .btn-smooth {
                font-size: 1.1rem;
                padding: 1rem 0;
            }

            .register-link {
                font-size: 1.1rem;
                padding: 1rem 0;
            }
        }

        @media (max-width: 480px) {
            .main-content {
                margin-left: 0;
                padding: 0.5rem;
            }

            .sidebar {
                display: none;
            }

            .card {
                margin: 0.5rem;
                padding: 1.5rem 1rem;
                max-width: 100%;
            }

            .top-bar .logo {
                font-size: 1.2rem;
            }

            .input-smooth {
                font-size: 0.95rem;
            }

            .btn-smooth,
            .register-link {
                font-size: 1rem;
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
        <div class="sidebar-nav">
            <a href="{{ route('home') }}" class="sidebar-link">
                <i class="fas fa-home"></i>
                <span>Home</span>
            </a>


            <a href="#" class="sidebar-link" onclick="toggleHelpPanel(event)">
                <i class="fas fa-question-circle"></i>
                <span>Help</span>
            </a>
        </div>
    </aside>

    <!-- Help Panel -->
    <div id="helpPanel"
        class="fixed right-0 top-0 h-full w-96 bg-white shadow-2xl transform translate-x-full transition-transform duration-300 ease-in-out z-[101] overflow-y-auto">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold text-[#283d63]">Help Center</h2>
                <button onclick="toggleHelpPanel()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <div class="space-y-4">
                <!-- Help Item 1 -->
                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <div class="bg-gray-50 px-4 py-3 cursor-pointer flex justify-between items-center"
                        onclick="toggleHelpContent('help1')">
                        <h3 class="font-medium text-[#506a9f]">How to login to your account</h3>
                        <i class="fas fa-chevron-down text-[#506a9f] transition-transform" id="help1Icon"></i>
                    </div>
                    <div id="help1Content" class="px-4 py-3 bg-white hidden">
                        <p class="text-gray-600">Enter your username or email address and password in the fields
                            provided, then click the "Login" button. Make sure your caps lock is off as passwords are
                            case-sensitive.</p>
                    </div>
                </div>

                <!-- Help Item 2 -->
                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <div class="bg-gray-50 px-4 py-3 cursor-pointer flex justify-between items-center"
                        onclick="toggleHelpContent('help2')">
                        <h3 class="font-medium text-[#506a9f]">I forgot my password</h3>
                        <i class="fas fa-chevron-down text-[#506a9f] transition-transform" id="help2Icon"></i>
                    </div>
                    <div id="help2Content" class="px-4 py-3 bg-white hidden">
                        <p class="text-gray-600">Click on the "Forgot your password?" link below the login form. You'll
                            be asked to enter your email address, and we'll send you instructions to reset your
                            password.</p>
                    </div>
                </div>

                <!-- Help Item 3 -->
                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <div class="bg-gray-50 px-4 py-3 cursor-pointer flex justify-between items-center"
                        onclick="toggleHelpContent('help3')">
                        <h3 class="font-medium text-[#506a9f]">Creating a new account</h3>
                        <i class="fas fa-chevron-down text-[#506a9f] transition-transform" id="help3Icon"></i>
                    </div>
                    <div id="help3Content" class="px-4 py-3 bg-white hidden">
                        <p class="text-gray-600">Click the "Register" button at the bottom of the login page to create a
                            new account. You'll need to provide a username, email address, and password.</p>
                    </div>
                </div>

                <!-- Help Item 4 -->
                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <div class="bg-gray-50 px-4 py-3 cursor-pointer flex justify-between items-center"
                        onclick="toggleHelpContent('help4')">
                        <h3 class="font-medium text-[#506a9f]">Account security tips</h3>
                        <i class="fas fa-chevron-down text-[#506a9f] transition-transform" id="help4Icon"></i>
                    </div>
                    <div id="help4Content" class="px-4 py-3 bg-white hidden">
                        <p class="text-gray-600">
                            - Use a strong, unique password<br>
                            - Don't share your login credentials<br>
                            - Log out when using shared computers<br>
                            - Check that you're on the correct website before entering credentials
                        </p>
                    </div>
                </div>

                <!-- Help Item 5 -->
                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <div class="bg-gray-50 px-4 py-3 cursor-pointer flex justify-between items-center"
                        onclick="toggleHelpContent('help5')">
                        <h3 class="font-medium text-[#506a9f]">Contact support</h3>
                        <i class="fas fa-chevron-down text-[#506a9f] transition-transform" id="help5Icon"></i>
                    </div>
                    <div id="help5Content" class="px-4 py-3 bg-white hidden">
                        <p class="text-gray-600">If you're still having trouble, please contact our support team at <a
                                href="mailto:support@authenticityhub.com" class="text-blue-600 hover:underline">support@authenticityhub.com</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Overlay for help panel -->
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-[100] hidden" onclick="toggleHelpPanel()"></div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="card">
            <h2 style="font-size: 2rem;"><b>Login</b></h2>

            @if (session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle" style="margin-right: 0.5rem;"></i>{{ session('success') }}
                </div> @endif

            <form method="POST"
                                action="{{ route('login') }}" novalidate>
                                @csrf

                                <div class="input-group">
                                    <span class="input-icon @error('login') is-invalid @enderror">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <input type="text" id="login" name="login" value="{{ old('login') }}"
                                        required class="input-smooth @error('login') is-invalid @enderror"
                                        placeholder="Email or Username" />
                                </div>
                                @error('login')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror

                                <div class="input-group">
                                    <span class="input-icon @error('password') is-invalid @enderror">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input type="password" name="password" required
                                        class="input-smooth @error('password') is-invalid @enderror"
                                        placeholder="Password" />
                                </div>
                                @error('password')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror

                                <div style="margin-bottom:1rem;">
                                    <a href="{{ route('password.recovery') }}" class="forgot-link">
                                        Forgot your password?
                                    </a>
                                </div>

                                <button type="submit" class="btn-smooth">Login</button>
                                </form>

                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        const form = document.querySelector('form');
                                        const submitBtn = form.querySelector('[type="submit"]');

                                        // Reset button state on page load
                                        submitBtn.innerHTML = 'Login';
                                        submitBtn.style.pointerEvents = 'auto';

                                        // Check if we should clear form (after successful login/logout)
                                        const urlParams = new URLSearchParams(window.location.search);
                                        const clearForm = urlParams.get('clear') === '1' ||
                                                        sessionStorage.getItem('loginSuccess') === 'true' ||
                                                        localStorage.getItem('shouldClearLogin') === 'true' ||
                                                        @if (session('login_successful')) true @else false @endif;

                                        if (clearForm) {
                                            // Clear form and storage
                                            form.querySelectorAll('input[name]').forEach(input => {
                                                input.value = '';
                                                localStorage.removeItem('loginPage.' + input.name);
                                            });
                                            sessionStorage.removeItem('loginSuccess');
                                            localStorage.removeItem('shouldClearLogin');
                                        } else {
                                            // Only restore saved values if we're not clearing
                                            form.querySelectorAll('input[name]').forEach(input => {
                                                const key = 'loginPage.' + input.name;
                                                const val = localStorage.getItem(key);
                                                if (val !== null) input.value = val;
                                            });
                                        }

                                        // Save on change
                                        form.querySelectorAll('input[name]').forEach(input => {
                                            input.addEventListener('input', () => {
                                                const key = 'loginPage.' + input.name;
                                                localStorage.setItem(key, input.value);
                                            });
                                        });

                                        // Handle form submission
                                        form.addEventListener('submit', (e) => {
                                            if (!form.checkValidity()) return;

                                            // Add submission animation
                                            submitBtn.innerHTML = '<i class="fas
                                fa-spinner fa-spin"></i> Logging in...';
                                submitBtn.style.pointerEvents = 'none';

                                // Mark that we're attempting login
                                sessionStorage.setItem('loginAttempt', 'true');

                                // Clear form data from localStorage on successful submission
                                setTimeout(() => {
                                form.querySelectorAll('input[name]').forEach(input => {
                                localStorage.removeItem('loginPage.' + input.name);
                                });
                                }, 1000);
                                });

                                // Clear form data if the user navigates away and comes back
                                window.addEventListener('pageshow', function(event) {
                                if (event.persisted || window.performance.navigation.type === 2) {
                                // User used back button or page was cached
                                submitBtn.innerHTML = 'Login';
                                submitBtn.style.pointerEvents = 'auto';
                                }
                                });

                                // Add animation to error messages if present
                                const errorMessages = document.querySelectorAll('.error-message');
                                if (errorMessages.length > 0) {
                                errorMessages.forEach(error => {
                                error.style.display = 'none';
                                setTimeout(() => {
                                error.style.display = 'block';
                                }, 500);
                                });
                                }
                                });
                                </script>

                                <!-- Help Panel Functions - Global scope -->
                                <script>
                                    // Toggle help panel function
                                    function toggleHelpPanel(event) {
                                        if (event) {
                                            event.preventDefault();
                                        }

                                        const helpPanel = document.getElementById('helpPanel');
                                        const overlay = document.getElementById('overlay');

                                        if (helpPanel.classList.contains('translate-x-full')) {
                                            helpPanel.classList.remove('translate-x-full');
                                            overlay.classList.remove('hidden');
                                            document.body.style.overflow = 'hidden'; // Prevent scrolling
                                        } else {
                                            helpPanel.classList.add('translate-x-full');
                                            overlay.classList.add('hidden');
                                            document.body.style.overflow = ''; // Re-enable scrolling
                                        }
                                    }

                                    // Toggle help content function
                                    function toggleHelpContent(id) {
                                        const content = document.getElementById(id + 'Content');
                                        const icon = document.getElementById(id + 'Icon');

                                        if (content.classList.contains('hidden')) {
                                            content.classList.remove('hidden');
                                            icon.classList.add('rotate-180');
                                        } else {
                                            content.classList.add('hidden');
                                            icon.classList.remove('rotate-180');
                                        }
                                    }
                                </script>

                                <div style="text-align:center; margin-top:2rem;">
                                    <div
                                        style="color:#283d63; font-weight:600; margin-bottom:0.7rem; font-size:1.08rem;">
                                        Don't have an account?
                                    </div>
                                    <a href="{{ route('register') }}" class="register-link">
                                        Register
                                    </a>
                                </div>
                    </div>
                </div>
</body>

</html>
