<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Manage Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <style>
        /* Enhanced Root Styles */
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #6a7fd0, #6bc5f3);
            margin: 0;
            padding: 0;
            opacity: 0;
            animation: pageLoad 1s ease-in-out forwards;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Enhanced Main Content */
        .main-content {
            margin-left: 14rem;
            margin-top: 56px;
            padding: 2rem;
            min-height: calc(100vh - 56px);
            background: transparent;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        /* Floating Background Elements */
        .main-content::before {
            content: '';
            position: absolute;
            top: 10%;
            left: 10%;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
            z-index: 0;
        }

        .main-content::after {
            content: '';
            position: absolute;
            bottom: 15%;
            right: 15%;
            width: 150px;
            height: 150px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.08) 0%, transparent 70%);
            border-radius: 50%;
            animation: float 8s ease-in-out infinite reverse;
            z-index: 0;
        }

        /* Enhanced Profile Card */
        .profile-card {
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.95), rgba(248, 250, 252, 0.9));
            padding: 3rem;
            border-radius: 24px;
            box-shadow:
                0 25px 60px rgba(0, 0, 0, 0.15),
                0 10px 20px rgba(0, 0, 0, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.6);
            max-width: 650px;
            width: 100%;
            backdrop-filter: blur(20px);
            text-align: center;
            opacity: 0;
            animation: slideInUp 1s ease-out forwards 0.3s;
            transition: all 0.4s ease;
            position: relative;
            z-index: 1;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .profile-card:hover {
            box-shadow:
                0 35px 80px rgba(0, 0, 0, 0.2),
                0 15px 30px rgba(0, 0, 0, 0.15),
                inset 0 1px 0 rgba(255, 255, 255, 0.8);
            transform: translateY(-5px);
        }

        /* Enhanced Profile Header */
        .profile-header {
            background: linear-gradient(135deg, #283d63, #4f8cff, #6bc5f3);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-align: center;
            position: relative;
            opacity: 0;
            animation: fadeInScale 0.8s ease-out forwards 0.6s;
        }

        .profile-header::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 4px;
            background: linear-gradient(135deg, #4f8cff, #6bc5f3);
            border-radius: 2px;
            opacity: 0;
            animation: fadeIn 0.6s ease-out forwards 1s;
        }

        /* Enhanced Profile Picture */
        .profile-picture {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            border: 4px solid transparent;
            background: linear-gradient(white, white) padding-box,
                linear-gradient(135deg, #4f8cff, #6bc5f3, #6a7fd0) border-box;
            margin: 0 auto 2rem;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            transition: all 0.5s ease;
            animation: profilePulse 3s ease-in-out infinite;
            position: relative;
            cursor: pointer;
        }

        .profile-picture::before {
            content: '';
            position: absolute;
            inset: -4px;
            border-radius: 50%;
            padding: 4px;
            background: linear-gradient(135deg, #4f8cff, #6bc5f3, #6a7fd0);
            mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            mask-composite: xor;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .profile-picture:hover::before {
            opacity: 1;
        }

        .profile-picture:hover {
            transform: scale(1.08) rotate(2deg);
            box-shadow: 0 15px 40px rgba(79, 140, 255, 0.3);
        }

        .profile-picture img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .profile-picture:hover img {
            transform: scale(1.05);
        }

        /* Enhanced Form Groups */
        .form-group {
            margin-bottom: 2rem;
            text-align: left;
            opacity: 0;
            animation: slideInUp 0.6s ease-out forwards;
            animation-delay: calc(var(--animation-order) * 0.15s + 0.8s);
            position: relative;
        }

        .form-group label {
            font-weight: 600;
            color: #283d63;
            margin-bottom: 0.75rem;
            display: block;
            font-size: 1.1rem;
            position: relative;
            padding-left: 1.5rem;
        }

        .form-group label::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 20px;
            background: linear-gradient(135deg, #4f8cff, #6bc5f3);
            border-radius: 2px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .form-group:focus-within label::before {
            opacity: 1;
        }

        .form-group input {
            width: 100%;
            padding: 1rem 1.25rem;
            border-radius: 12px;
            border: 2px solid #e2e8f0;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            position: relative;
        }

        .form-group input:focus {
            transform: translateY(-2px);
            border-color: #4f8cff;
            box-shadow:
                0 10px 25px rgba(79, 140, 255, 0.15),
                0 0 0 4px rgba(79, 140, 255, 0.1);
            background: rgba(255, 255, 255, 1);
            outline: none;
        }

        .form-group input::placeholder {
            color: #a0aec0;
            font-style: italic;
        }

        /* File Input Enhancement */
        .form-group input[type="file"] {
            padding: 0;
            border: 2px dashed #e2e8f0;
            background: rgba(249, 250, 251, 0.8);
            cursor: pointer;
            text-align: center;
            position: relative;
            height: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .form-group input[type="file"]:hover {
            border-color: #4f8cff;
            background: rgba(239, 246, 255, 0.8);
        }

        .form-group input[type="file"]::before {
            content: '\f093 \a Choose Profile Picture';
            font-family: 'Font Awesome 6 Free', 'Poppins';
            font-weight: 900;
            white-space: pre;
            color: #6b7280;
            font-size: 1rem;
            text-align: center;
        }

        .form-group input[type="file"]:hover::before {
            color: #4f8cff;
        }

        /* Enhanced Save Button */
        .btn-save {
            background: linear-gradient(135deg, #4f8cff, #6bc5f3);
            border-radius: 12px;
            box-shadow:
                0 8px 25px rgba(79, 140, 255, 0.3),
                0 4px 10px rgba(0, 0, 0, 0.1);
            color: white;
            font-weight: 600;
            padding: 1.25rem 3rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1.1rem;
            opacity: 0;
            animation: fadeInScale 0.6s ease-out forwards 1.5s;
            position: relative;
            overflow: hidden;
            margin-top: 1rem;
        }

        .btn-save::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .btn-save:hover::before {
            left: 100%;
        }

        .btn-save:hover {
            transform: translateY(-3px);
            box-shadow:
                0 15px 40px rgba(79, 140, 255, 0.4),
                0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .btn-save:active {
            transform: translateY(-1px);
        }

        /* Enhanced Success/Error Messages */
        .alert {
            padding: 1.25rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            backdrop-filter: blur(10px);
            border: 1px solid;
            animation: slideInDown 0.5s ease-out;
            position: relative;
            overflow: hidden;
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
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(34, 197, 94, 0.05));
            color: #059669;
            border-color: rgba(16, 185, 129, 0.2);
        }

        .alert-error {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.1), rgba(220, 38, 38, 0.05));
            color: #dc2626;
            border-color: rgba(239, 68, 68, 0.2);
        }

        /* Top Bar Styling */
        .top-bar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 56px;
            background: linear-gradient(135deg, #d2dbf6, #e8eef7);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 2rem;
            z-index: 100;
            box-shadow: 0 4px 20px rgba(59, 130, 246, 0.1);
            backdrop-filter: blur(20px);
        }

        .top-bar .logo {
            font-weight: 700;
            font-size: 1.4rem;
            background: linear-gradient(135deg, #283d63, #4f8cff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: 0.02em;
            position: absolute;
            left: 2rem;
        }

        /* Enhanced User Info */
        .user-info-topbar {
            display: flex;
            flex-direction: row-reverse;
            align-items: center;
            position: absolute;
            right: 2rem;
            top: 50%;
            transform: translateY(-50%);
            gap: 0.75rem;
        }

        .user-info-topbar .user-pic {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            overflow: hidden;
            border: 2px solid transparent;
            background: linear-gradient(white, white) padding-box,
                linear-gradient(135deg, #4f8cff, #6bc5f3) border-box;
            transition: all 0.3s ease;
        }

        .user-info-topbar .user-pic:hover {
            transform: scale(1.1);
            box-shadow: 0 5px 15px rgba(79, 140, 255, 0.3);
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
            max-width: 120px;
            word-break: break-all;
        }

        /* Enhanced Sidebar */
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

        /* Enhanced Animation Keyframes */
        @keyframes pageLoad {
            from {
                opacity: 0;
            }

            to {
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

        @keyframes slideInDown {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes profilePulse {

            0%,
            100% {
                box-shadow: 0 0 0 0 rgba(79, 140, 255, 0.4);
            }

            50% {
                box-shadow: 0 0 0 20px rgba(79, 140, 255, 0);
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            33% {
                transform: translateY(-15px) rotate(1deg);
            }

            66% {
                transform: translateY(-10px) rotate(-1deg);
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

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 1rem;
            }

            .profile-card {
                padding: 2rem;
                margin: 1rem;
            }

            .sidebar {
                display: none;
            }

            .profile-header {
                font-size: 2rem;
            }
        }

        /* Loading Animation for Form Submission */
        .loading {
            position: relative;
        }

        .loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin: -10px 0 0 -10px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top: 2px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
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
            <a href="{{ route('public.user.home') }}" class="sidebar-link btn-back"><i class="fas fa-arrow-left"></i>
                <span>Back</span></a>
            <a href="#" class="sidebar-link active"><i class="fas fa-user"></i> <span>Profile</span></a>

            <a href="{{ route('password.edit') }}" class="sidebar-link"><i class="fas fa-shield-alt"></i>
                <span>Security</span></a>

            <div style="flex:1"></div>
            <a href="{{ route('login') }}" class="sidebar-link exit-link"><i class="fas fa-sign-out-alt"></i>
                <span>Exit</span></a>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <div class="profile-card">
            <!-- Success Message -->
            @if (session('status'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle" style="margin-right: 0.5rem;"></i>
                    {{ session('status') }}
                </div>
            @endif

            <!-- Circular Profile Picture -->
            <div class="profile-picture">
                @if (Auth::user()->UserProfilePicture)
                    <img id="profilePicPreview" src="{{ asset('storage/' . Auth::user()->UserProfilePicture) }}"
                        alt="Profile Picture">
                @else
                    <img id="profilePicPreview"
                        src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->UserName) }}&background=6bc5f3&color=283d63&size=200"
                        alt="Profile Picture">
                @endif
            </div>

            <h2 class="profile-header">Manage Your Profile</h2>
            <p style="color: #6b7280; margin-bottom: 2rem; opacity: 0; animation: fadeIn 0.6s ease-out forwards 0.9s;">
                Keep your information up to date for better service
            </p>

            @if ($errors->any())
                <div class="alert alert-error">
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Please fix the following errors:</strong>
                    </div>
                    <ul style="margin: 0; padding-left: 1.5rem;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data"
                id="profile-form">
                @csrf
                @method('PUT')

                <div class="form-group" style="--animation-order: 1">
                    <label for="UserName">
                        <i class="fas fa-user" style="margin-right: 0.5rem; color: #4f8cff;"></i>
                        Full Name
                    </label>
                    <input type="text" name="UserName" id="UserName"
                        value="{{ old('UserName', Auth::user()->UserName) }}" placeholder="Enter your full name"
                        required />
                    @error('UserName')
                        <div
                            style="color: #ef4444; font-size: 0.875rem; margin-top: 0.5rem; display: flex; align-items: center; gap: 0.25rem;">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group" style="--animation-order: 2">
                    <label for="UserEmail">
                        <i class="fas fa-envelope" style="margin-right: 0.5rem; color: #4f8cff;"></i>
                        Email Address
                    </label>
                    <input type="email" name="UserEmail" id="UserEmail"
                        value="{{ old('UserEmail', Auth::user()->UserEmail) }}" placeholder="Enter your email address"
                        required />
                    @error('UserEmail')
                        <div
                            style="color: #ef4444; font-size: 0.875rem; margin-top: 0.5rem; display: flex; align-items: center; gap: 0.25rem;">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group" style="--animation-order: 3">
                    <label for="UserPhoneNum">
                        <i class="fas fa-phone" style="margin-right: 0.5rem; color: #4f8cff;"></i>
                        Phone Number
                    </label>
                    <input type="tel" name="UserPhoneNum" id="UserPhoneNum"
                        value="{{ old('UserPhoneNum', Auth::user()->UserPhoneNum) }}"
                        placeholder="Enter your phone number (optional)" />
                    @error('UserPhoneNum')
                        <div
                            style="color: #ef4444; font-size: 0.875rem; margin-top: 0.5rem; display: flex; align-items: center; gap: 0.25rem;">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group" style="--animation-order: 4">
                    <label for="UserProfilePicture">
                        <i class="fas fa-camera" style="margin-right: 0.5rem; color: #4f8cff;"></i>
                        Profile Picture
                    </label>
                    <input type="file" name="UserProfilePicture" id="UserProfilePicture" accept="image/*" />
                    <div style="font-size: 0.875rem; color: #6b7280; margin-top: 0.5rem; text-align: center;">
                        <i class="fas fa-info-circle" style="margin-right: 0.25rem;"></i>
                        Accepted formats: JPG, PNG, GIF (Max 2MB)
                    </div>
                    @error('UserProfilePicture')
                        <div
                            style="color: #ef4444; font-size: 0.875rem; margin-top: 0.5rem; display: flex; align-items: center; gap: 0.25rem;">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Additional Info Section -->
                <div
                    style="background: linear-gradient(135deg, #eff6ff, #dbeafe); padding: 1.5rem; border-radius: 12px; margin: 2rem 0; border-left: 4px solid #4f8cff; opacity: 0; animation: slideInUp 0.6s ease-out forwards 1.3s;">
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                        <i class="fas fa-shield-alt" style="color: #4f8cff;"></i>
                        <strong style="color: #283d63;">Security & Privacy</strong>
                    </div>
                    <p style="color: #6b7280; font-size: 0.9rem; margin: 0; line-height: 1.5;">
                        Your personal information is encrypted and secure. You can update your password in the
                        <a href="{{ route('password.edit') }}"
                            style="color: #4f8cff; text-decoration: none; font-weight: 600;">Security Settings</a>.
                    </p>
                </div>

                <button type="submit" class="btn-save" id="save-btn">
                    <i class="fas fa-save" style="margin-right: 0.5rem;"></i>
                    Save Changes
                </button>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('UserProfilePicture');
            const preview = document.getElementById('profilePicPreview');
            const form = document.getElementById('profile-form');
            const saveBtn = document.getElementById('save-btn');

            // Enhanced profile picture preview with animation
            input.addEventListener('change', function(e) {
                if (input.files && input.files[0]) {
                    const file = input.files[0];

                    // File size validation (2MB)
                    if (file.size > 2 * 1024 * 1024) {
                        showNotification('File size must be less than 2MB', 'error');
                        input.value = '';
                        return;
                    }

                    // File type validation
                    if (!file.type.startsWith('image/')) {
                        showNotification('Please select a valid image file', 'error');
                        input.value = '';
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        // Add loading animation
                        preview.style.opacity = '0';
                        preview.style.transform = 'scale(0.8)';

                        setTimeout(() => {
                            preview.src = e.target.result;
                            preview.style.opacity = '1';
                            preview.style.transform = 'scale(1)';
                            preview.style.transition = 'all 0.5s ease';

                            // Add success feedback
                            showNotification(
                                'Profile picture updated! Remember to save changes.',
                                'success');
                        }, 300);
                    }
                    reader.readAsDataURL(file);
                }
            });

            // Enhanced form submission with loading state
            form.addEventListener('submit', function(e) {
                if (!form.checkValidity()) {
                    e.preventDefault();
                    return;
                }

                // Add loading state to button
                const originalContent = saveBtn.innerHTML;
                saveBtn.innerHTML = `
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <div class="loading-spinner"></div>
                        <span>Saving...</span>
                    </div>
                `;
                saveBtn.disabled = true;
                saveBtn.classList.add('loading');

                // Add loading spinner styles if not exists
                if (!document.querySelector('#loading-styles')) {
                    const style = document.createElement('style');
                    style.id = 'loading-styles';
                    style.textContent = `
                        .loading-spinner {
                            width: 16px;
                            height: 16px;
                            border: 2px solid rgba(255, 255, 255, 0.3);
                            border-top: 2px solid white;
                            border-radius: 50%;
                            animation: spin 1s linear infinite;
                        }
                    `;
                    document.head.appendChild(style);
                }

                // Show progress notification
                showNotification('Updating your profile...', 'info');
            });

            // Enhanced input field interactions
            const inputs = form.querySelectorAll('input[type="text"], input[type="email"], input[type="tel"]');
            inputs.forEach(input => {
                // Real-time validation feedback
                input.addEventListener('input', function() {
                    validateField(this);
                });

                input.addEventListener('blur', function() {
                    validateField(this);
                });

                // Enhanced focus effects
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'translateY(-2px)';
                    this.parentElement.style.transition = 'transform 0.3s ease';
                });

                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'translateY(0)';
                });
            });

            // Field validation function
            function validateField(field) {
                const isValid = field.checkValidity() && field.value.trim() !== '';

                if (field.hasAttribute('required') && !field.value.trim()) {
                    field.style.borderColor = '#ef4444';
                    field.style.boxShadow = '0 0 0 3px rgba(239, 68, 68, 0.1)';
                } else if (isValid) {
                    field.style.borderColor = '#10b981';
                    field.style.boxShadow = '0 0 0 3px rgba(16, 185, 129, 0.1)';

                    // Reset to normal after 2 seconds
                    setTimeout(() => {
                        field.style.borderColor = '#e2e8f0';
                        field.style.boxShadow = 'none';
                    }, 2000);
                } else {
                    field.style.borderColor = '#e2e8f0';
                    field.style.boxShadow = 'none';
                }
            }

            // Enhanced notification system
            function showNotification(message, type = 'info') {
                // Remove existing notifications
                const existingNotifications = document.querySelectorAll('.notification');
                existingNotifications.forEach(notification => notification.remove());

                const notification = document.createElement('div');
                notification.className = 'notification';

                const icons = {
                    success: 'fas fa-check-circle',
                    error: 'fas fa-exclamation-triangle',
                    info: 'fas fa-info-circle'
                };

                const colors = {
                    success: 'linear-gradient(135deg, rgba(16, 185, 129, 0.9), rgba(34, 197, 94, 0.8))',
                    error: 'linear-gradient(135deg, rgba(239, 68, 68, 0.9), rgba(220, 38, 38, 0.8))',
                    info: 'linear-gradient(135deg, rgba(79, 140, 255, 0.9), rgba(107, 197, 243, 0.8))'
                };

                notification.style.cssText = `
                    position: fixed;
                    top: 80px;
                    right: 2rem;
                    background: ${colors[type]};
                    color: white;
                    padding: 1rem 1.5rem;
                    border-radius: 12px;
                    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
                    backdrop-filter: blur(10px);
                    z-index: 1000;
                    display: flex;
                    align-items: center;
                    gap: 0.75rem;
                    font-weight: 500;
                    max-width: 400px;
                    animation: slideInRight 0.3s ease-out;
                    border: 1px solid rgba(255, 255, 255, 0.2);
                `;

                notification.innerHTML = `
                    <i class="${icons[type]}"></i>
                    <span>${message}</span>
                    <button onclick="this.parentElement.remove()" style="
                        background: none;
                        border: none;
                        color: rgba(255, 255, 255, 0.7);
                        cursor: pointer;
                        font-size: 1.2rem;
                        margin-left: 0.5rem;
                        padding: 0;
                        width: 20px;
                        height: 20px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        border-radius: 50%;
                        transition: all 0.2s ease;
                    " onmouseover="this.style.background='rgba(255,255,255,0.1)'" onmouseout="this.style.background='none'">
                        ×
                    </button>
                `;

                document.body.appendChild(notification);

                // Auto remove after 5 seconds
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.style.animation = 'slideOutRight 0.3s ease-in';
                        setTimeout(() => {
                            notification.remove();
                        }, 300);
                    }
                }, 5000);

                // Add notification animations if not exists
                if (!document.querySelector('#notification-styles')) {
                    const style = document.createElement('style');
                    style.id = 'notification-styles';
                    style.textContent = `
                        @keyframes slideInRight {
                            from {
                                transform: translateX(100%);
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
                                transform: translateX(100%);
                                opacity: 0;
                            }
                        }
                    `;
                    document.head.appendChild(style);
                }
            }

            // Auto-hide success messages after 4 seconds
            const alertSuccess = document.querySelector('.alert-success');
            if (alertSuccess) {
                setTimeout(() => {
                    alertSuccess.style.animation = 'slideInDown 0.3s ease-in reverse';
                    setTimeout(() => {
                        alertSuccess.remove();
                    }, 300);
                }, 4000);
            }

            // Enhanced profile picture hover effect
            const profilePic = document.querySelector('.profile-picture');
            profilePic.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.05) rotate(2deg)';
            });

            profilePic.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1) rotate(0deg)';
            });

            // Add parallax effect to background elements
            window.addEventListener('scroll', function() {
                const scrolled = window.pageYOffset;
                const parallax1 = document.querySelector('.main-content::before');
                const parallax2 = document.querySelector('.main-content::after');

                // This would need to be applied differently since pseudo-elements can't be directly accessed
                // Consider adding actual background elements if parallax is needed
            });

            // Keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                // Ctrl+S to save (prevent default and trigger form submit)
                if (e.ctrlKey && e.key === 's') {
                    e.preventDefault();
                    if (form.checkValidity()) {
                        form.submit();
                    } else {
                        showNotification('Please fill in all required fields correctly', 'error');
                    }
                }
            });
        });
    </script>
</body>

</html>
