<header class="">
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}"><h2>نقشة <em>Nakshah</em></h2></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('home') }}">Home
                            @if(request()->routeIs('home'))
                                <span class="sr-only">(current)</span>
                            @endif
                        </a>
                    </li> 
                    <li class="nav-item {{ request()->routeIs('products') ? 'active' : '' }}">
                        <a class="nav-link" href="">Shop</a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('about') ? 'active' : '' }}">
                        <a class="nav-link" href="">About Us</a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('contact') ? 'active' : '' }}">
                        <a class="nav-link" href="">Contact Us</a>
                    </li>
                    @if (Auth::check())
                        @if (Auth::user()->isAdmin || Auth::user()->role === 'admin')
                            <li class="nav-item admin-link">
                                <a class="nav-link" href="{{ route('admin.homepage.index') }}">Admin Dashboard</a>
                            </li>
                        @endif
                    @endif
                </ul>
                
                <div class="user-menu ms-4">
                    @if (Auth::check())
                        <div class="dropdown" x-data="{ open: false }">
                            <button @click="open = !open" class="dropdown-btn">
                                <div class="user-info">
                                    @if (Auth::user()->profile_photo_path)
                                        <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" alt="{{ Auth::user()->name }}" class="user-avatar">
                                    @else
                                        <div class="user-initial">
                                            <span>{{ substr(Auth::user()->name, 0, 1) }}</span>
                                        </div>
                                    @endif
                                    <span class="user-name">{{ Auth::user()->name }}</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" class="dropdown-arrow">
                                        <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                                    </svg>
                                </div>
                            </button>
                            
                            <div x-show="open" @click.away="open = false" class="user-dropdown">
                                <a href="{{ route('profile.edit') }}" class="dropdown-item">
                                    {{ __('Profile') }}
                                </a>
                                
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
                            <a href="{{ route('login') }}" class="btn btn-primary">{{ __('Log In') }}</a>
                            <a href="{{ route('register') }}" class="btn btn-outline-primary">{{ __('Register') }}</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </nav>
</header>