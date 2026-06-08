<!-- filepath: c:\xampp\htdocs\Laravel\SDW_Laravel_Project\mcmc\myApp\resources\views\home.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f0f4f8;
            margin: 0;
            padding: 0;
        }

        .top-bar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 56px;
            background: #d2dbf6;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            padding: 0 2rem;
            z-index: 100;
            box-shadow: 0 2px 8px rgba(59, 130, 246, 0.07);
        }

        .top-bar .logo {
            font-weight: 700;
            font-size: 1.3rem;
            color: #283d63;
            letter-spacing: 0.02em;
        }

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

        .sidebar-link.active,
        .sidebar-link:hover {
            background: #b9c8f6;
            color: #0057ff;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 87, 255, 0.2);
        }

        .sidebar-link.submit-inquiry {
            color: #2c2c2c;
            font-weight: 600;
        }

        .sidebar-link.submit-inquiry.active,
        .sidebar-link.submit-inquiry:hover {
            background: #fbe9ef;
            color: #000000;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .main-content {
            margin-left: 14rem;
            margin-top: 56px;
            padding: 2rem;
        }

        .hero-section {
            background: linear-gradient(135deg, #6a7fd0, #6bc5f3);
            color: white;
            padding: 80px 0;
            text-align: center;
            border-radius: 18px;
        }

        .hero-text {
            font-size: 2.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .cta-button {
            background: linear-gradient(145deg, #283d63, #1a2a4c);
            color: white;
            padding: 0.75rem 1.5rem;
            font-size: 1.2rem;
            border-radius: 0.75rem;
            border: none;
            transition: all 0.3s ease;
            width: 300px;
            margin: 0.5rem 0;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(40, 61, 99, 0.3);
        }

        .cta-button:hover {
            background: linear-gradient(145deg, #5a709a, #283d63);
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 6px 20px rgba(40, 61, 99, 0.4);
        }

        .section-title {
            font-size: 2rem;
            font-weight: 600;
            color: #283d63;
            margin-top: 40px;
            text-align: center;
        }

        .feature-cards {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-top: 40px;
        }

        .feature-card {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 300px;
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        }

        .feature-card h3 {
            margin-top: 20px;
            font-size: 1.5rem;
            font-weight: 600;
            color: #283d63;
        }

        .feature-card p {
            color: #6b6b6b;
        }

        footer {
            background-color: #283d63;
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: 40px;
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
                transform: translateY(50px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
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

        /* Page Load Animation */
        body {
            opacity: 0;
            animation: fadeIn 0.8s ease-in-out forwards;
        }

        /* Hero Section Animation */
        .hero-section {
            opacity: 0;
            animation: slideInUp 1s ease-out forwards 0.3s;
        }

        .hero-text {
            opacity: 0;
            animation: slideInUp 0.8s ease-out forwards 0.6s;
        }

        .hero-section p {
            opacity: 0;
            animation: slideInUp 0.8s ease-out forwards 0.8s;
        }

        /* Button Animations */
        .cta-button {
            opacity: 0;
            animation: fadeIn 0.8s ease-out forwards 1s;
        }

        .cta-button:first-of-type {
            animation-delay: 1s;
        }

        .cta-button:last-of-type {
            animation-delay: 1.2s;
        }

        /* Section Title Animation */
        .section-title {
            opacity: 0;
            animation: slideInUp 0.8s ease-out forwards 1.4s;
        }

        /* Feature Card Animations */
        .feature-card {
            opacity: 0;
            animation: fadeIn 0.8s ease-out forwards;
        }

        .feature-card:nth-child(1) {
            animation-delay: 1.6s;
            animation-name: slideInLeft;
        }

        .feature-card:nth-child(2) {
            animation-delay: 1.8s;
            animation-name: slideInUp;
        }

        .feature-card:nth-child(3) {
            animation-delay: 2s;
            animation-name: slideInRight;
        }

        .feature-card:hover {
            opacity: 1 !important;
            transform: translateY(-5px) !important;
            transition: transform 0.3s ease, box-shadow 0.3s ease !important;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15) !important;
            animation: none !important;
        }

        /* Footer Animation */
        footer {
            opacity: 0;
            animation: fadeIn 0.8s ease-out forwards 2.2s;
        }

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
            .feature-cards {
                flex-direction: column;
                align-items: center;
            }

            .top-bar {
                flex-direction: column;
                align-items: center;
                height: auto;
                padding: 10px 10px;
            }

            .main-content {
                padding: 1rem;
            }
        }
    </style>
</head>

<body>
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="logo">AuthenticityHub</div>
    </div>
    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="sidebar-nav">
            <a href="{{ route('home') }}" class="sidebar-link active">
                <i class="fa fa-home"></i>
                <span>Home</span>
            </a>


        </div>
    </nav>
    <!-- Main Content -->
    <div class="main-content">
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="container">
                <h1 class="hero-text">Welcome to AuthenticityHub</h1>
                <p>Here you can have the right of saying what you want and feel about any news</p>
                <div style="display: flex; flex-direction: column; gap: 1rem; align-items: center;">
                    <a href="{{ route('register') }}">
                        <button class="cta-button mt-6">Make your account with us</button>
                    </a>
                    <a href="{{ route('login') }}">
                        <button class="cta-button mt-4">Sign in</button>
                    </a>
                </div>
            </div>
        </section>
        <!-- Features Section -->
        <section>
            <h2 class="section-title">Features that make your life easier</h2>
            <div class="feature-cards">
                <!-- Feature 1 -->
                <div class="feature-card">
                    <img src="https://via.placeholder.com/80" alt="Feature 1" class="mx-auto">
                    <h3>Easy to Use</h3>
                    <p>Get started quickly with a user-friendly interface designed for everyone.</p>
                </div>
                <!-- Feature 2 -->
                <div class="feature-card">
                    <img src="https://via.placeholder.com/80" alt="Feature 2" class="mx-auto">
                    <h3>Fast & Reliable</h3>
                    <p>Our platform is optimized for speed and offers exceptional performance.</p>
                </div>
                <!-- Feature 3 -->
                <div class="feature-card">
                    <img src="https://via.placeholder.com/80" alt="Feature 3" class="mx-auto">
                    <h3>24/7 Support</h3>
                    <p>Our team is here to help, anytime you need assistance or guidance.</p>
                </div>
            </div>
        </section>
        <!-- Footer Section -->
        <footer>
            <p>&copy; 2025 AuthenticityHub. All Rights Reserved.</p>
        </footer>
    </div>

    <!-- Success Message -->
    @if (session('success'))
        <div
            class="fixed top-20 right-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-lg z-50">
            <div class="flex items-center">
                <div class="py-1">
                    <svg class="h-6 w-6 text-green-500 mr-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div>
                    {{ session('success') }}
                </div>
            </div>
        </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add smooth scrolling to navigation links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();

                    document.querySelector(this.getAttribute('href')).scrollIntoView({
                        behavior: 'smooth'
                    });
                });
            });

            // Animate elements when they come into view
            const observerOptions = {
                root: null,
                rootMargin: '0px',
                threshold: 0.1
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.feature-card').forEach(card => {
                observer.observe(card);
            });
        });

        // Auto hide success message after 3 seconds
        setTimeout(function() {
            const successAlert = document.querySelector('.bg-green-100');
            if (successAlert) {
                successAlert.style.transition = 'opacity 1s ease-out';
                successAlert.style.opacity = '0';
                setTimeout(() => successAlert.remove(), 1000);
            }
        }, 3000);
    </script>
</body>

</html>
