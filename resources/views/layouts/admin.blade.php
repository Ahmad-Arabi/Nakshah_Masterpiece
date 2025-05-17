<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Home')</title>
    <link rel="shortcut icon" href=" {{ asset('images/admin_favicon.png') }} " type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @yield('style')
</head>

<body>
    <div id="sidebar" class="d-flex flex-column flex-shrink-0 p-3 text-white">
        <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <span class="fs-4"><i class="bi bi-toggles"></i> Admin Dashboard</span>
        </a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="{{ route('admin.homepage.index') }}"
                    class="nav-link {{ request()->routeIs('admin.homepage.index') ? 'active' : 'text-white' }}">
                    <i class="bi bi-house-door"></i>
                    Home
                </a>
            </li>
            <li>
                <a href="{{ route('admin.users.index') }}"
                    class="nav-link {{ request()->routeIs('admin.users.index') ? 'active' : 'text-white' }}">
                    <i class="bi bi-people"></i>
                    Users
                </a>
            </li>
            <li>
                <a href="{{ route('admin.orders.index') }}"
                    class="nav-link {{ request()->routeIs('admin.orders.index') ? 'active' : 'text-white' }}">
                    <i class="bi bi-cart-check"></i>
                    Orders
                </a>
            </li>
            <li>
                <a href="{{ route('admin.products.index') }}"
                    class="nav-link {{ request()->routeIs('admin.products.index') ? 'active' : 'text-white' }}">
                    <i class="bi bi-box-seam"></i>
                    Products
                </a>
            </li>
            <li>
                <a href="{{ route('admin.categories.index') }}"
                    class="nav-link {{ request()->routeIs('admin.categories.index') ? 'active' : 'text-white' }}">
                    <i class="bi bi-tags"></i>
                    Categories
                </a>
            </li>
            <li>
                <a href="{{ route('admin.coupons.index') }}"
                    class="nav-link {{ request()->routeIs('admin.coupons.index') ? 'active' : 'text-white' }}">
                    <i class="bi bi-percent"></i>
                    Coupons
                </a>
            </li>
            <li>
                <a href="{{ route('admin.reviews.index') }}"    
                    class="nav-link {{ request()->routeIs('admin.reviews.index') ? 'active' : 'text-white' }}">
                    <i class="bi bi-chat-right-heart"></i>
                    Product Reviews
                </a>
            </li>
            <li>
                <a href="{{ route('admin.contact-us.index') }}"
                    class="nav-link {{ request()->routeIs('admin.contact-us.index') ? 'active' : 'text-white' }}">
                    <i class="bi bi-chat-left-dots-fill"></i>
                    Messages
                </a>
            </li>
            <div class="accordion" id="chartsAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                type="button" data-bs-toggle="collapse" 
                                data-bs-target="#chartsSection" aria-expanded="false" 
                                aria-controls="chartsSection">
                            <i class="bi bi-graph-up-arrow"></i> Charts & Statistics
                        </button>
                    </h2>
                    <div id="chartsSection" class="accordion-collapse collapse" data-bs-parent="#chartsAccordion">
                        <div class="accordion-body">
                            <ul class="list-unstyled">
                                <li>
                                    <a class="nav-link {{ request()->routeIs('admin.charts.products') ? 'active' : 'text-white' }}" 
                                       href="{{ route('admin.charts.products') }}">
                                        <i class="bi bi-box-seam"></i> Products & Stock
                                    </a>
                                </li>
                                <li>
                                    <a class="nav-link {{ request()->routeIs('admin.charts.index') ? 'active' : 'text-white' }}" 
                                       href="{{ route('admin.charts.index') }}">
                                        <i class="bi bi-bar-chart"></i> Charts
                                    </a>
                                </li>
                                {{-- <li>
                                    <a class="nav-link {{ request()->routeIs('admin.orders.statistics') ? 'active' : 'text-white' }}" 
                                       href="">
                                        <i class="bi bi-cart"></i> Orders Statistics
                                    </a>
                                </li> --}}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </ul>
        <hr>
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('images/default.png') }}"
                    alt="" width="32" height="32" class="rounded-circle me-2">
                <strong>{{ Auth::user()->name }}</strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                <li>
                    <x-dropdown-link :href="route('profile.edit')" class="dropdown-item">
                        <i class="bi bi-person-circle"></i>
                        {{ __('Profile') }}
                    </x-dropdown-link>
                </li>
                <li>
                    <x-dropdown-link :href="route('home')" class="dropdown-item">
                        <i class="bi bi-house"></i>
                        {{ __('Exit') }}
                    </x-dropdown-link>
                </li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')" class="dropdown-item text-danger"
                            onclick="event.preventDefault();
                            this.closest('form').submit();">
                            <i class="bi bi-box-arrow-left"></i>
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                </li>
            </ul>
        </div>
    </div>

    <!-- Content Area -->
    <div id="content">
        @yield('content')
    </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
