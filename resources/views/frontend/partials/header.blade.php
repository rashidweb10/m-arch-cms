<!-- Header Section Start -->
<div class="top_position">

    <!-- Top Header -->
    <div class="header_section_top">
        <div class="container position-relative">
            <div class="row align-items-center">

                <div class="col-md-2"></div>

                <div class="col-md-4">
                    <p class="mrg_35 robot_slab">
                        All Admission on Counselling Call: {{get_setting('phone')}}
                    </p>
                </div>

                <div class="col-md-6">
                    <div class="d-flex browser_link">
                        <ul class="d-flex ms-auto mb-0">
                            <li class="nav-item">
                                @if( get_setting('brochure') )
                                <a target="_blank" class="nav-link robot_slab" href="{{ uploaded_asset(get_setting('brochure')) }}">
                                    <i class="fas fa-file-download me-1"></i> Brochure
                                </a>
                                @endif
                            </li>
                            @auth
                                <li class="nav-item dropdown">
                                    <a class="nav-link robot_slab dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->name }}
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('auth.dashboard') }}">
                                                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('auth.profile') }}">
                                                <i class="fas fa-user me-2"></i> Edit Profile
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('auth.change-password') }}">
                                                <i class="fas fa-lock me-2"></i> Change Password
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('auth.enrolled-courses') }}">
                                                <i class="fas fa-graduation-cap me-2"></i> Enrolled Courses
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('auth.logout') }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="dropdown-item text-danger" style="cursor: pointer; border: none; background: none; width: 100%; text-align: left;">
                                                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a class="nav-link robot_slab" href="{{ route('auth.login') }}">
                                        <i class="fas fa-sign-in-alt me-1"></i> Login
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link robot_slab" href="{{ route('auth.register') }}">
                                        <i class="fas fa-user-plus me-1"></i> Register
                                    </a>
                                </li>
                            @endauth
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Main Header -->
    <header>
        <div class="container">
            <div class="row align-items-center">

                <!-- Logo -->
                <div class="col-md-1 col-3 order-md-1 order-2">
                    <div class="logo_width">
                        <a class="navbar-brand" href="/">
                            <img
                                class="w-150"
                                src="{{ uploaded_asset(get_setting('logo')) }}"
                                title="MarinArch Logo"
                                alt="MarinArch Logo"
                            />
                        </a>
                    </div>
                </div>

                <!-- Mobile Toggle -->
                <div class="col-md-4 col-1 order-md-2 order-3 d-lg-none d-block">
                    <button
                        class="navbar-toggler"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent"
                        aria-expanded="false"
                        aria-label="Toggle navigation"
                    >
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>

                <!-- Navigation -->
                <div class="col-md-11 col-3 order-md-3 d-lg-block d-none">
                    <nav class="navbar navbar-expand-lg navbar-light p-0">

                        <div
                            class="collapse navbar-collapse justify-content-end"
                            id="navbarSupportedContent"
                        >
                            <div class="d-md-flex">
                                <ul class="navbar-nav ms-md-auto mb-0 position_tops">

                                    <li class="nav-item">
                                        <a class="nav-link robot_slab" href="{{ route('home') }}">
                                            Home
                                        </a>
                                    </li>

                                    <!-- MarineArch Menu -->
                                    <li class="nav-item menu">
                                        <a href="#" class="nav-link robot_slab">
                                            MarineArch
                                        </a>
                                        <ul class="submenu">
                                            <li>
                                                <a href="{{ route('about') }}">
                                                    <i class="fa-regular fa-address-card"></i>
                                                    About Us
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('courses') }}">
                                                    <i class="fa-brands fa-discourse"></i>
                                                    Courses
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('faculties') }}">
                                                    <i class="fa-regular fa-address-card"></i>
                                                    Faculties
                                                </a>
                                            </li>
                                        </ul>
                                    </li>

                                    <!-- Courses Menu -->
                                    <li class="nav-item menu">
                                        <a href="#" class="nav-link robot_slab">
                                            Courses
                                        </a>
                                        <ul class="submenu">
                                            <li>
                                                <a href="{{ route('about') }}">
                                                    <i class="fa-regular fa-address-card"></i>
                                                    About Us
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('courses') }}">
                                                    <i class="fa-brands fa-discourse"></i>
                                                    Courses
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('faculties') }}">
                                                    <i class="fa-regular fa-address-card"></i>
                                                    Faculties
                                                </a>
                                            </li>
                                        </ul>
                                    </li>

                                    <!-- Faculties Menu -->
                                    <li class="nav-item menu">
                                        <a href="#" class="nav-link robot_slab">
                                            Faculties
                                        </a>
                                        <ul class="submenu">
                                            <li>
                                                <a href="{{ route('about') }}">
                                                    <i class="fa-regular fa-address-card"></i>
                                                    About Us
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('courses') }}">
                                                    <i class="fa-brands fa-discourse"></i>
                                                    Courses
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('faculties') }}">
                                                    <i class="fa-regular fa-address-card"></i>
                                                    Faculties
                                                </a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link robot_slab" href="{{ route('testimonials') }}">
                                            Student Speak
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link robot_slab" href="{{ route('blog.index') }}">
                                            Blogs
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link robot_slab" href="{{ route('contact') }}">
                                            Contact Us
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </div>

                    </nav>
                </div>

            </div>
        </div>
    </header>

</div>
<!-- Header Section End -->