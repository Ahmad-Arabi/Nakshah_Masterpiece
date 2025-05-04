<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Nakshah') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --primary: #4B3F72;
            --secondary: #FF6B6B;
            --accent: #C8E6C9;
            --light: #F5F0E1;
            --dark: #333333;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            color: var(--dark);
            background-color: var(--light);
        }
        
        /* Navbar Styles */
        .navbar {
            background-color: var(--primary);
            padding: 0.8rem 1rem;
        }
        
        .navbar-brand {
            color: var(--light);
            font-weight: 700;
            font-size: 1.75rem;
        }
        
        .navbar-brand span {
            color: var(--secondary);
        }
        
        .navbar-nav .nav-link {
            color: var(--light);
            font-weight: 500;
            margin: 0 0.5rem;
            transition: all 0.3s ease;
        }
        
        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            color: var(--secondary);
        }
        
        .navbar .admin-link {
            color: var(--accent);
        }
        
        .navbar-toggler {
            border-color: var(--light);
        }
        
        .btn-primary {
            background-color: var(--secondary);
            border-color: var(--secondary);
        }
        
        .btn-primary:hover {
            background-color: #ff5252;
            border-color: #ff5252;
        }
        
        .btn-outline-primary {
            border-color: var(--accent);
            color: var(--accent);
        }
        
        .btn-outline-primary:hover {
            background-color: var(--accent);
            color: var(--primary);
        }
        
        /* Header Styles */
        .page-header {
            background-color: var(--primary);
            color: var(--light);
            padding: 5rem 0;
            margin-bottom: 3rem;
        }
        
        .page-header h1 {
            font-weight: 700;
            margin-bottom: 1rem;
        }
        
        .page-header p {
            font-size: 1.25rem;
            opacity: 0.9;
        }
        
        /* Footer Styles */
        footer {
            background-color: var(--primary);
            color: var(--light);
            padding: 3rem 0 1.5rem;
            margin-top: 4rem;
        }
        
        footer h5 {
            color: var(--secondary);
            font-weight: 600;
            margin-bottom: 1.5rem;
        }
        
        footer ul {
            padding-left: 0;
            list-style: none;
        }
        
        footer ul li {
            margin-bottom: 0.75rem;
        }
        
        footer ul li a {
            color: var(--light);
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        footer ul li a:hover {
            color: var(--secondary);
            text-decoration: none;
        }
        
        .social-icons a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            height: 40px;
            width: 40px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            color: var(--light);
            margin-right: 0.5rem;
            transition: all 0.3s ease;
        }
        
        .social-icons a:hover {
            background-color: var(--secondary);
            color: var(--light);
        }
        
        .copyright {
            padding-top: 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin-top: 2rem;
        }
        
        /* Product Card */
        .product-card {
            border-radius: 0.5rem;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            margin-bottom: 2rem;
            background-color: white;
        }
        
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        .product-img {
            height: 220px;
            overflow: hidden;
            position: relative;
        }
        
        .product-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: all 0.5s ease;
        }
        
        .product-card:hover .product-img img {
            transform: scale(1.1);
        }
        
        .product-content {
            padding: 1.5rem;
        }
        
        .product-title {
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-size: 1.1rem;
        }
        
        .product-category {
            color: #777;
            font-size: 0.85rem;
            margin-bottom: 0.75rem;
        }
        
        .product-price {
            font-weight: 700;
            color: var(--secondary);
            font-size: 1.2rem;
            margin-bottom: 1rem;
        }
        
        .rating {
            margin-bottom: 1rem;
        }
        
        .rating i {
            color: #ffc107;
            font-size: 0.9rem;
        }
        
        .rating-count {
            font-size: 0.85rem;
            color: #777;
            margin-left: 0.5rem;
        }
        
        /* Utility Classes */
        .section-title {
            position: relative;
            font-weight: 600;
            margin-bottom: 2.5rem;
            text-align: center;
        }
        
        .section-title:after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 70px;
            height: 3px;
            background-color: var(--secondary);
        }
    </style>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    @include('layouts.navigation')

        <!-- Page Header - Optional -->
        @hasSection('header')
            <header class="page-header">
                <div class="container text-center">
                    @yield('header')
                </div>
            </header>
        @endif

        <!-- Main Content -->
        <main class="flex-grow-1">
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                        <h5 class="mb-4">نقشة Nakshah</h5>
                        <p>Your destination for custom printed products that tell your unique story through personalized designs.</p>
                        <div class="social-icons mt-4">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                        <h5>Quick Links</h5>
                        <ul class="list-unstyled">
                            <li><a href="">Home</a></li>
                            <li><a href="">Shop</a></li>
                            <li><a href="">About Us</a></li>
                            <li><a href="">Contact Us</a></li>
                        </ul>
                    </div>
                    
                    <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                        <h5>Customer Service</h5>
                        <ul class="list-unstyled">
                            <li><a href="#">FAQ</a></li>
                            <li><a href="#">Shipping & Returns</a></li>
                            <li><a href="#">Terms & Conditions</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                        </ul>
                    </div>
                    
                    <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                        <h5>Contact Information</h5>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-map-marker-alt me-2"></i> Amman, Jordan</li>
                            <li><i class="fas fa-phone me-2"></i> +962 77 123 4567</li>
                            <li><i class="fas fa-envelope me-2"></i> info@nakshah.com</li>
                        </ul>
                    </div>
                </div>
                
                <div class="text-center copyright">
                    <p>© {{ date('Y') }} نقشة Nakshah. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom Scripts -->
    <script>
        // Display flash messages with Bootstrap toast
        document.addEventListener('DOMContentLoaded', function() {
            const toastElements = document.querySelectorAll('.toast');
            toastElements.forEach(toastEl => {
                const toast = new bootstrap.Toast(toastEl);
                toast.show();
            });
        });
    </script>
    
    <!-- Flash Messages -->
    @if (session('success') || session('error'))
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div id="flashMessage" class="toast align-items-center text-white {{ session('success') ? 'bg-success' : 'bg-danger' }}" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    {{ session('success') ?? session('error') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
    @endif
</body>
</html>