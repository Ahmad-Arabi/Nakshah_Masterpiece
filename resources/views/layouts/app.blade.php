<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap"
        rel="stylesheet">

    <title>Nakshah</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('/user/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="{{ asset('/user/css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('/user/css/templatemo-sixteen.css') }}">
    <link rel="stylesheet" href="{{ asset('/user/css/owl.css') }}">
    <link rel="stylesheet" href="{{ asset('/user/css/flex-slider.css') }}">
    <link rel="stylesheet" href="{{ asset('/user/css/custom.css') }}">
    
    <!-- Shop specific CSS -->
    @if(request()->routeIs('shop'))
    <link rel="stylesheet" href="{{ asset('user/css/shop.css') }}">
    @endif

    @if(request()->routeIs('product.show'))
    <link rel="stylesheet" href="{{ asset('user/css/product.css') }}">
    @endif

</head>

<body>

    <!-- ***** Preloader Start ***** -->
    <div id="preloader">
        <div class="jumper">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <!-- ***** Preloader End ***** -->

    <!-- Header -->
    @include('layouts.navigation')
    <!-- Header Ends -->

    <!-- Page Content -->
    <main class="flex-grow-1">
        {{ $slot }}
    </main>
    <!-- Page Content Ends -->


    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="footer-about">
                        <h4>نقشة <span>Nakshah</span></h4>
                        <p>Nakshah is your premier destination for authentic Arabic art and calligraphy. Discover
                            handcrafted treasures that blend traditional artistry with modern design.</p>
                        <ul class="social-icons">
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="footer-links">
                        <h4>Useful Links</h4>
                        <ul>
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li><a href="#">Our Products</a></li>
                            <li><a href="#">About Us</a></li>
                            <li><a href="#">Contact Us</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Terms & Conditions</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="footer-contact">
                        <h4>Contact Us</h4>
                        <p><i class="fa fa-map-marker"></i> Amman, Jordan</p>
                        <p><i class="fa fa-phone"></i> +962 79 000 0000</p>
                        <p><i class="fa fa-envelope"></i> info@nakshah.com</p>
                        <div class="newsletter">
                            <h5>Subscribe to our newsletter</h5>
                            <form>
                                <input type="email" placeholder="Your email address">
                                <button type="submit" class="filled-button">Subscribe</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="inner-content">
                        <p>Copyright &copy; {{ date('Y') }} Nakshah. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>


    <!-- Bootstrap core JavaScript -->
    <script src="{{ asset('/user/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('/user/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>


    <!-- Additional Scripts -->
    <script src="{{ asset('/user/js/custom.js') }}"></script>
    <script src="{{ asset('/user/js/owl.js') }}"></script>
    <script src="{{ asset('/user/js/slick.js') }}"></script>
    <script src="{{ asset('/user/js/isotope.js') }}"></script>
    <script src="{{ asset('/user/js/accordions.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
    
    <!-- Stack for page-specific scripts -->
    @stack('scripts')

</body>

</html>
