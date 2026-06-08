<!-- filepath: resources/views/Module1/publicUser/editPasswordPage.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>AuthenticityHub - Change Password</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #6a7fd0, #6bc5f3);
            min-height: 100vh;
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



        /* Standardized Sidebar Styling */
        .sidebar {
            position: fixed;
            top: 56px;
            left: 0;
            width: 14rem;
            height: calc(100vh - 56px);
            background: linear-gradient(135deg, #d2dbf6, #e8eef7);
            box-shadow: 0 8px 30px rgba(40, 61, 99, 0.15);
            border-top-right-radius: 1.5rem;
            border-bottom-right-radius: 1.5rem;
            padding: 2rem 0;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            z-index: 99;
            backdrop-filter: blur(20px);
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
            padding: 1rem;
            color: #283d63;
            text-decoration: none;
            font-weight: 500;
            border-radius: 12px;
            transition: all 0.3s ease;
            background: transparent;
            position: relative;
        }

        .sidebar-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 0;
            height: 80%;
            background: linear-gradient(135deg, #4f8cff, #6bc5f3);
            border-radius: 0 4px 4px 0;
            transition: width 0.3s ease;
        }

        .sidebar-link:hover::before,
        .sidebar-link.active::before {
            width: 4px;
        }

        .sidebar-link:hover {
            background: rgba(185, 200, 246, 0.5);
            color: #0057ff;
            transform: translateX(6px);
        }

        .sidebar-link.active {
            background: rgba(185, 200, 246, 0.7);
            color: #0057ff;
            font-weight: 600;
        }

        .sidebar-link i {
            width: 1.25rem;
            height: 1.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.3s ease;
        }

        .sidebar-link:hover i {
            transform: scale(1.1);
        }

        /* Exit link specific styling */
        .exit-link {
            margin-top: auto;
            margin-bottom: 1rem;
            color: #e74c3c !important;
        }

        .exit-link:hover {
            background: rgba(239, 68, 68, 0.1) !important;
            color: #dc2626 !important;
        }

        .exit-link::before {
            background: linear-gradient(135deg, #ef4444, #dc2626) !important;
        }

        .main-content {
            margin-left: 14rem;
            margin-top: 56px;
            min-height: calc(100vh - 56px);
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem;
        }

        .card {
            background: rgba(238, 242, 255, 0.9);
            border-radius: 18px;
            box-shadow: 0 4px 24px rgba(80, 143, 244, 0.08);
            padding: 2.5rem 2.5rem 2rem 2.5rem;
            width: 100%;
            max-width: 420px;
            margin: 0 auto;
            /* Center horizontally if needed */
        }

        .card h2 {
            text-align: center;
            margin-bottom: 2rem;
            color: #2d3a4b;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 1.3rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            color: #4f8cff;
            font-weight: 500;
        }

        input[type="password"] {
            width: 92%;
            display: block;
            margin: 0 auto;
            padding: 0.7rem 1rem;
            border: 1.5px solid #d0e2ff;
            border-radius: 8px;
            font-size: 1rem;
            background: #f4f7fb;
            transition: all 0.3s ease;
        }

        input[type="password"]:focus {
            transform: scale(1.03);
            border-color: #4f8cff;
            box-shadow: 0 0 10px rgba(79, 140, 255, 0.3);
            outline: none;
        }

        /* Standardized Button Styling */
        .btn {
            width: 100%;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 0.75rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            opacity: 0;
            animation: fadeIn 0.5s ease-out forwards 0.9s;
        }

        .btn-primary {
            background: linear-gradient(145deg, #4f8cff, #357ae8);
            color: #fff;
            box-shadow: 0 4px 15px rgba(79, 140, 255, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(79, 140, 255, 0.4);
        }

        .btn-success {
            background: linear-gradient(145deg, #2ecc71, #27ae60);
            color: #fff;
            box-shadow: 0 4px 15px rgba(46, 204, 113, 0.3);
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(46, 204, 113, 0.4);
        }

        .alert {
            padding: 0.7rem 1rem;
            border-radius: 6px;
            margin-bottom: 1rem;
            font-size: 1rem;
            animation: slideInUp 0.5s ease-out forwards;
        }

        .alert-success {
            background: #eafaf1;
            color: #2ecc71;
        }

        .alert-error {
            background: #fdeaea;
            color: #e74c3c;
            animation: shake 0.5s ease-in-out;
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

        @media (max-width: 900px) {
            .main-content {
                margin-left: 0;
                margin-top: 0;
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
                top: 0;
            }

            .sidebar-nav {
                flex-direction: row;
                padding: 0 1rem;
                gap: 0.5rem;
            }

            .sidebar-link {
                flex: 1;
                justify-content: center;
                border-bottom: 4px solid transparent;
                padding: 0.75rem 0.5rem;
                text-align: center;
            }

            .sidebar-link:hover,
            .sidebar-link.active {
                border-bottom: 4px solid #0057ff;
                transform: none;
                background: transparent;
            }

            .exit-link {
                border-top: none;
                border-left: 1px solid rgba(0, 0, 0, 0.1);
                margin-top: 0;
            }

            .exit-link:hover {
                border-bottom: 4px solid #e74c3c !important;
                border-left: none !important;
                background: transparent !important;
            }

            .top-bar {
                position: static;
            }
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

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
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
            transition: all 0.4s ease;
        }

        .card:hover {
            box-shadow: 0 10px 50px rgba(80, 143, 244, 0.15);
        }

        /* Form Field Animations */
        .form-group {
            opacity: 0;
            animation: slideInUp 0.5s ease-out forwards;
            animation-delay: calc(var(--animation-order) * 0.15s + 0.5s);
        }

        /* Button Animation */
        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .btn:active {
            transform: translateY(1px) scale(0.98);
        }

        /* Form transitions between steps */
        form {
            transition: all 0.5s ease;
            opacity: 1;
        }

        form.fade-out {
            opacity: 0;
            transform: translateY(-20px);
        }

        form.fade-in {
            opacity: 0;
            transform: translateY(20px);
            animation: slideInUp 0.5s ease-out forwards;
        }
    </style>
</head>

<body>
    <!-- Top Bar -->
    <header class="top-bar">
        <div class="logo">AuthenticityHub</div>

        <div class="user-info-topbar">
            <div class="user-pic">
                @if (Auth::user()->UserProfilePicture)
                    <img src="{{ asset('storage/' . Auth::user()->UserProfilePicture) }}" alt="Profile Picture">
                @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->UserName) }}&background=cccccc&color=555555"
                        alt="Profile Picture">
                @endif
            </div>
            <div class="user-name">{{ Auth::user()->UserName }}</div>
        </div>
    </header>

    <!-- Sidebar -->
    <aside class="sidebar">
        <nav class="sidebar-nav">
            <a href="{{ url()->previous() !== request()->url() && url()->previous() !== '' ? url()->previous() : route('home') }}"
                class="sidebar-link btn-back"><i class="fas fa-arrow-left"></i> <span>Back</span></a>
            <a href="{{ route('profile.manage') }}" class="sidebar-link">
                <i class="fas fa-user"></i>
                <span>Profile</span>
            </a>

            <a href="{{ route('password.edit') }}" class="sidebar-link active">
                <i class="fas fa-shield-alt"></i>
                <span>Security</span>
            </a>

            <div style="flex:1"></div>
            <a href="{{ route('login') }}" class="sidebar-link exit-link"><i class="fas fa-sign-out-alt"></i>
                <span>Exit</span></a>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <div class="card">
            <h2>Change Password</h2>

            {{-- Success/Error messages --}}
            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-error">{{ session('error') }}</div>
            @endif

            {{-- Step 1: Ask for current password --}}
            @if (!session('password_verified'))
                <form method="POST" action="{{ route('password.verify') }}" id="verify-form">
                    @csrf
                    <div class="form-group" style="--animation-order: 1">
                        <label for="current_password">Enter Current Password:</label>
                        <input type="password" name="current_password" id="current_password" required>
                        @error('current_password')
                            <div style="color:#e74c3c;">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Verify</button>
                </form>

                <!-- Password Guidelines Section -->
                <div style="margin-top: 30px; border-top: 1px solid #e5e7eb; padding-top: 20px;">
                    <h3 style="font-size: 1.1rem; font-weight: 600; color: #2d3a4b; margin-bottom: 15px;">Password
                        Guidelines</h3>
                    <ul style="list-style-type: disc; padding-left: 20px; margin: 0; color: #4a5568;">
                        <li style="margin-bottom: 8px;">Use at least 8 characters</li>
                        <li style="margin-bottom: 8px;">Include a mix of letters, numbers, and symbols</li>
                        <li style="margin-bottom: 8px;">Avoid using easily guessable information (birthdays, names,
                            etc.)</li>
                        <li>Don't reuse passwords from other websites</li>
                    </ul>
                </div>
            @else
                {{-- Step 2: Show new password fields --}}
                <form method="POST" action="{{ route('password.update') }}" id="update-form" class="fade-in">
                    @csrf
                    @method('PUT')
                    <div class="form-group" style="--animation-order: 1">
                        <label for="new_password">New Password:</label>
                        <input type="password" name="new_password" id="new_password" required>
                        @error('new_password')
                            <div style="color:#e74c3c;">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group" style="--animation-order: 2">
                        <label for="new_password_confirmation">Confirm New Password:</label>
                        <input type="password" name="new_password_confirmation" id="new_password_confirmation" required>
                    </div>
                    <button type="submit" class="btn btn-success">Update Password</button>
                    <button type="button" class="btn btn-primary" style="margin-top: 10px;"
                        onclick="resetForm('{{ route('password.edit.reset') }}')">
                        Back
                    </button>
                </form>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Form submission animations
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    if (!form.checkValidity()) return;

                    const submitBtn = this.querySelector('[type="submit"]');
                    const originalText = submitBtn.innerText;

                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> ' +
                        (form.id === 'verify-form' ? 'Verifying...' : 'Updating...');
                    submitBtn.style.pointerEvents = 'none';

                    form.classList.add('fade-out');
                });
            });

            // Animation for alerts if present
            const alerts = document.querySelectorAll('.alert');
            if (alerts.length > 0) {
                alerts.forEach(alert => {
                    setTimeout(() => {
                        alert.style.opacity = '0';
                        alert.style.transition = 'opacity 0.5s ease';
                    }, 5000);
                });
            }
        });

        // Function to handle form reset with animation
        function resetForm(url) {
            const form = document.getElementById('update-form');
            form.classList.add('fade-out');

            setTimeout(() => {
                window.location.href = url;
            }, 300);
        }
    </script>
</body>

</html>
