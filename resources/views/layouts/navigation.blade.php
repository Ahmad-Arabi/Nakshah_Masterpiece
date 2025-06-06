<header class="">
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
                <img src="{{ asset('images/Arlogo.png') }}" alt="Naqsha Logo" class="img-fluid nav-logo">
                <h2>{{env('APP_NAME_AR')}} <em>{{env('APP_NAME')}}</em></h2></a>
            <div class="d-flex align-items-center d-lg-none">
                @auth
                <a href="{{ route('cart.index') }}" class="cart-icon-mobile">
                    <i class="fa fa-shopping-cart"></i>
                    @if($userCartCount > 0)
                        <span class="cart-count">{{ $userCartCount }}</span>
                    @endif
                </a>
                @endauth
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <!-- Main Navigation Items -->
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('home') }}">Home
                            @if(request()->routeIs('home'))
                                <span class="sr-only">(current)</span>
                            @endif
                        </a>
                    </li> 
                    <li class="nav-item {{ request()->routeIs('shop') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('shop') }}">Shop</a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('about') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('about') }}">About Us</a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('user.contactUs') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('user.contactUs') }}">Contact Us</a>
                    </li>

                    <!-- Mobile-only navigation items for authenticated users -->
                    @if (Auth::check())
                        @if (Auth::user()->isAdmin || Auth::user()->role === 'admin')
                            <li class="nav-item mobile-only">
                                <a class="nav-link text-center" href="{{ route('admin.homepage.index') }}">
                                    {{ __('Admin Dashboard') }}
                                </a>
                            </li>
                        @endif
                        <li class="nav-item mobile-only">
                            <a class="nav-link user-profile-link" href="{{ route('profile.edit') }}">
                                <div class="mobile-user-info">
                                    @if (Auth::user()->profile_picture)
                                        <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="{{ Auth::user()->name }}" class="mobile-user-avatar">
                                    @else
                                        <div class="mobile-user-initial">
                                            <span>{{ substr(Auth::user()->name, 0, 1) }}</span>
                                        </div>
                                    @endif
                                    <span class="mobile-user-name">{{ Auth::user()->name }}</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item mobile-only">
                            <a class="nav-link text-center logout-link" href="#" 
                               onclick="event.preventDefault(); document.getElementById('mobile-logout-form').submit();">
                                {{ __('Log Out') }}
                            </a>
                            <form id="mobile-logout-form" method="POST" action="{{ route('logout') }}" class="d-none">
                                @csrf
                            </form>
                        </li>
                    @endif
                </ul>
                
                <!-- Authentication Links - Separate Section -->
                <div class="auth-section ms-4">
                    @if (Auth::check())
                        @auth
                        <a href="{{ route('cart.index') }}" class="cart-icon-nav me-3 mr-4">
                            <i class="fa fa-shopping-cart"></i>
                            @if($userCartCount > 0)
                                <span class="cart-count">{{ $userCartCount }}</span>
                            @endif
                        </a>
                        @endauth
                        <div class="dropdown" x-data="{ open: false }">
                            <button @click="open = !open" class="dropdown-btn">
                                <div class="user-info">
                                    @if (Auth::user()->profile_picture)
                                        <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="{{ Auth::user()->name }}" class="user-avatar">
                                    @else
                                        <div class="user-initial">
                                            <span>{{ substr(Auth::user()->name, 0, 1) }}</span>
                                        </div>
                                    @endif
                                    <span class="user-name">{{ Auth::user()->name }}</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" class="dropdown-arrow" :class="{'rotate-180': open}">
                                        <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                                    </svg>
                                </div>
                            </button>
                            
                            <div x-cloak x-show="open" @click.away="open = false" class="user-dropdown">
                                <a href="{{ route('profile.edit') }}" class="dropdown-item">
                                    {{ __('Profile') }}
                                </a>
                                
                                @if (Auth::user()->isAdmin || Auth::user()->role === 'admin')
                                    <a href="{{ route('admin.homepage.index') }}" class="dropdown-item">
                                        {{ __('Admin Dashboard') }}
                                    </a>
                                @endif
                                
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item logout-btn">
                                        {{ __('Log Out') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="auth-buttons">
                            <a href="{{ route('login') }}" class="filled-button">{{ __('Log In') }}</a>
                            <a href="{{ route('register') }}" class="btn btn-outline-light ml-2">{{ __('Register') }}</a>
                        </div>
                    @endif
                </div>

                <!-- Mobile-only login/register buttons with desktop styling -->
                @if (!Auth::check())
                    <div class="mobile-auth-buttons py-3">
                        <a href="{{ route('login') }}" class="filled-button ml-2">{{ __('Log In') }}</a>
                        <a href="{{ route('register') }}" class="btn btn-outline-light ml-2">{{ __('Register') }}</a>
                    </div>
                @endif
            </div>
        </div>
    </nav>
    <!-- Banner Ends Here -->
        <div class="container-fluid mx-0 px-0">
            <div class="owl-carousel coupons-carousel">
              @foreach ($featuredCoupons as $coupon)
                <div class="coupon-item"> Use Code <span class="coupon">{{ $coupon->code }}</span> for <span class="discount">{{ $coupon->discount }}</span> off for your next order! </div>

              @endforeach
              <div class="coupon-item"> Get free shipping on orders over 50 JOD !</div>
            </div>
        </div>
</header>