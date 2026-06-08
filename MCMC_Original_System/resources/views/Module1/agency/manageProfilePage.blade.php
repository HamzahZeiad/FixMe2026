<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Agency Profile Management</title>
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

        .profile-pic-container:hover::after {
            content: "\f030";
            font-family: "Font Awesome 5 Free";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 16px;
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
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 32px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 8px;
        }

        .form-group label {
            font-size: 0.95rem;
            font-weight: 600;
            color: #4a4237;
            margin-bottom: 4px;
        }

        .form-group input {
            border: 2px solid rgba(0, 0, 0, 0.08);
            border-radius: 12px;
            padding: 12px 16px;
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

        /* Style for any readonly fields that might be added later */
        .form-group input[readonly] {
            background: rgba(0, 0, 0, 0.03);
            color: #666;
            cursor: not-allowed;
            border-color: rgba(0, 0, 0, 0.05);
        }

        .form-group input[readonly]:hover {
            border-color: rgba(0, 0, 0, 0.05);
        }

        /* Enhanced Button Styles */
        .update-btn {
            background: linear-gradient(135deg, #FF595A 0%, #ff7b7c 100%);
            color: #ffffff;
            font-weight: 600;
            font-size: 1rem;
            padding: 14px 32px;
            border-radius: 12px;
            border: none;
            margin-top: 32px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow:
                0 8px 24px rgba(255, 89, 90, 0.3),
                0 4px 12px rgba(255, 89, 90, 0.2);
            position: relative;
            overflow: hidden;
        }

        .update-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s ease;
        }

        .update-btn:hover {
            background: linear-gradient(135deg, #ff4748 0%, #ff6b6c 100%);
            transform: translateY(-2px);
            box-shadow:
                0 12px 32px rgba(255, 89, 90, 0.4),
                0 8px 16px rgba(255, 89, 90, 0.3);
        }

        .update-btn:hover::before {
            left: 100%;
        }

        .update-btn:active {
            transform: translateY(0px);
        }

        /* For the logout icon at the bottom */
        .logout-icon {
            margin-top: auto;
            margin-bottom: 20px;
        }

        /* Enhanced profile picture styling */
        .profile-card-picture {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            border: 3px solid rgba(255, 89, 90, 0.2);
            margin: 0 auto 2rem;
            background: linear-gradient(135deg, #f9f9f9, #ffffff);
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            position: relative;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow:
                0 8px 24px rgba(0, 0, 0, 0.1),
                0 4px 12px rgba(0, 0, 0, 0.06);
        }

        .profile-card-picture:hover {
            border-color: rgba(255, 89, 90, 0.5);
            transform: translateY(-4px) scale(1.02);
            box-shadow:
                0 16px 40px rgba(0, 0, 0, 0.15),
                0 8px 20px rgba(255, 89, 90, 0.2);
        }

        .profile-card-picture img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .profile-card-picture:hover img {
            transform: scale(1.05);
        }

        .profile-card-picture:hover::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 89, 90, 0.2);
            backdrop-filter: blur(2px);
        }

        .profile-card-picture:hover::after {
            content: "\f030";
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 28px;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.5);
        }

        .profile-pic-label {
            color: #FF595A;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            display: block;
            margin-bottom: 24px;
            text-align: center;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .profile-pic-label:hover {
            color: #ff4748;
            transform: translateY(-1px);
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

        .form-group {
            animation: fadeInUp 0.4s ease-out;
            animation-delay: calc(var(--delay, 0) * 0.1s);
        }

        /* Success alert styling */
        .alert {
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
            color: #155724;
            padding: 12px 20px;
            border-radius: 12px;
            border: 1px solid rgba(21, 87, 36, 0.2);
            margin-bottom: 24px;
            box-shadow: 0 4px 12px rgba(21, 87, 36, 0.1);
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

            .form-grid {
                grid-template-columns: 1fr;
                gap: 20px;
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
        }

        @media (max-width: 480px) {
            .sidebar {
                display: none;
            }

            .content-area {
                margin-left: 0;
                padding: 16px;
            }

            .tabs {
                gap: 20px;
            }

            .tab {
                font-size: 1rem;
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
            <!-- Profile picture in top bar that opens file upload when clicked -->
            <label for="AgencyProfilePicture" class="profile-pic-container">
                @if ($agency->AgencyProfilePicture)
                    <img id="profilePicPreview" src="{{ asset('storage/' . $agency->AgencyProfilePicture) }}"
                        alt="Profile Picture">
                @else
                    <img id="profilePicPreview"
                        src="https://ui-avatars.com/api/?name={{ urlencode($agency->AgencyName) }}&background=eeeeee&color=666666"
                        alt="Profile Picture">
                @endif
            </label>
        </div>
    </header>

    <!-- Sidebar -->
    <aside class="sidebar">
        <nav class="sidebar-nav">
            <a href="{{ route('agency.home') }}" class="sidebar-link"><i class="fas fa-home"></i> <span>Home</span></a>
            <a href="#" class="sidebar-link active"><i class="fas fa-cog"></i> <span>Profile</span></a>
            <a href="{{ route('agency.security') }}" class="sidebar-link"><i class="fas fa-shield-alt"></i>
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
                <div class="tab active">Account Setting</div>

            </div>

            <!-- Success Message -->
            @if (session('status'))
                <div class="alert alert-success"
                    style="color: green; margin-bottom: 1rem; padding: 8px 12px; background-color: #f0fff0; border-radius: 4px;">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="alert alert-error"
                    style="color: #e53e3e; margin-bottom: 1rem; padding: 8px 12px; background-color: #fed7d7; border-radius: 4px;">
                    <strong>Please fix the following errors:</strong>
                    <ul style="margin: 0.5rem 0 0 1.5rem;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Profile Picture Section -->
            <div style="display: flex; justify-content: center;">
                <div>
                    <label for="AgencyProfilePicture" class="profile-card-picture">
                        @if ($agency->AgencyProfilePicture)
                            <img id="cardProfilePicPreview"
                                src="{{ asset('storage/' . $agency->AgencyProfilePicture) }}" alt="Profile Picture">
                        @else
                            <img id="cardProfilePicPreview"
                                src="https://ui-avatars.com/api/?name={{ urlencode($agency->AgencyName) }}&background=eeeeee&color=666666"
                                alt="Profile Picture">
                        @endif
                    </label>
                    <label for="AgencyProfilePicture" class="profile-pic-label">
                        Change Profile Picture
                    </label>
                </div>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('agency.profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- File input for profile picture (hidden but accessible via the labels) -->
                <input type="file" name="AgencyProfilePicture" id="AgencyProfilePicture" accept="image/*"
                    style="display: none;" />

                <div class="form-grid">
                    <!-- Left Column -->
                    <div>
                        <div class="form-group" style="--delay: 1">
                            <label for="AgencyName">Name:</label>
                            <input type="text" name="AgencyName" id="AgencyName"
                                value="{{ old('AgencyName', $agency->AgencyName) }}" required />
                            @error('AgencyName')
                                <div style="color: #e53e3e; font-size: 0.875rem; margin-top: 0.5rem;">{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group" style="--delay: 3">
                            <label for="AgencyUserName">Username:</label>
                            <input type="text" name="AgencyUserName" id="AgencyUserName"
                                value="{{ old('AgencyUserName', $agency->AgencyUserName) }}" required />
                            @error('AgencyUserName')
                                <div style="color: #e53e3e; font-size: 0.875rem; margin-top: 0.5rem;">{{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div>
                        <div class="form-group" style="--delay: 2">
                            <label for="AgencyEmail">Email:</label>
                            <input type="email" name="AgencyEmail" id="AgencyEmail"
                                value="{{ old('AgencyEmail', $agency->AgencyEmail) }}" />
                            @error('AgencyEmail')
                                <div style="color: #e53e3e; font-size: 0.875rem; margin-top: 0.5rem;">{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group" style="--delay: 4">
                            <label for="AgencyPhoneNum">Phone number:</label>
                            <input type="text" name="AgencyPhoneNum" id="AgencyPhoneNum"
                                value="{{ old('AgencyPhoneNum', $agency->AgencyPhoneNum) }}" />
                            @error('AgencyPhoneNum')
                                <div style="color: #e53e3e; font-size: 0.875rem; margin-top: 0.5rem;">{{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div style="text-align: right;">
                    <button type="submit" class="update-btn">Update Profile</button>
                </div>
            </form>
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

            // Enhanced profile picture preview functionality
            const input = document.getElementById('AgencyProfilePicture');
            const headerPreview = document.getElementById('profilePicPreview');
            const cardPreview = document.getElementById('cardProfilePicPreview');

            input.addEventListener('change', function(e) {
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        // Add smooth transition effect
                        headerPreview.style.opacity = '0';
                        cardPreview.style.opacity = '0';

                        setTimeout(() => {
                            headerPreview.src = e.target.result;
                            cardPreview.src = e.target.result;
                            headerPreview.style.opacity = '1';
                            cardPreview.style.opacity = '1';
                        }, 150);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            });

            // Add form submission enhancement
            const form = document.querySelector('form');
            const submitBtn = document.querySelector('.update-btn');

            form.addEventListener('submit', function(e) {
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Updating...';
                submitBtn.disabled = true;
            });

            // Add floating animation to cards on scroll
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
            document.querySelectorAll('.form-group').forEach(group => {
                group.style.transform = 'translateY(20px)';
                group.style.opacity = '0';
                group.style.transition = 'all 0.6s ease';
                observer.observe(group);
            });

            // Add smooth hover effects and validation
            document.querySelectorAll('.form-group input').forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'translateY(-2px)';
                });

                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'translateY(0)';
                });
            });

            // Add real-time validation for name field
            const nameInput = document.getElementById('AgencyName');

            // Name validation
            nameInput.addEventListener('input', function() {
                const value = this.value.trim();
                if (value.length < 2) {
                    this.style.borderColor = '#e74c3c';
                    this.style.boxShadow = '0 0 0 3px rgba(231, 76, 60, 0.1)';
                } else {
                    this.style.borderColor = '#FF595A';
                    this.style.boxShadow = '0 0 0 3px rgba(255, 89, 90, 0.1)';
                }
            });



            // Enhanced form validation
            form.addEventListener('submit', function(e) {
                const name = nameInput.value.trim();

                if (name.length < 2) {
                    e.preventDefault();
                    nameInput.focus();
                    nameInput.style.borderColor = '#e74c3c';
                    alert('Agency name must be at least 2 characters long.');
                    return false;
                }

                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Updating...';
                submitBtn.disabled = true;
            });
        });
    </script>
</body>

</html>
