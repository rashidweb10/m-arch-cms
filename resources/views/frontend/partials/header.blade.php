<!-- Header Section Start -->
<div class="top_position">

    <!-- Top Header -->
    <div class="header_section_top">
        <div class="container position-relative">
            <div class="row align-items-center">

                <div class="col-md-2"></div>

                <div class="col-md-4">
                    <p class="mrg_35 robot_slab">
                        All Admission on Counselling Call: +91 9920062295
                    </p>
                </div>

                <div class="col-md-6">
                    <div class="d-flex browser_link">
                        <ul class="d-flex ms-auto mb-0">
                            <li class="nav-item">
                                <a target="_blank" class="nav-link robot_slab" href="/">
                                    Brochure
                                </a>
                            </li>
                            <li class="nav-item">
                                <a target="_blank" class="nav-link robot_slab" href="/">
                                    Student Login
                                </a>
                            </li>
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
                                src="assets/frontend/img/marinarch-logo.png"
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
                                            <li><a href="{{ route('about') }}">About Us</a></li>
                                            <li><a href="{{ route('courses') }}">Courses</a></li>
                                            <li><a href="{{ route('faculties') }}">Faculties</a></li>
                                        </ul>
                                    </li>

                                    <!-- Faculties Menu -->
                                    <li class="nav-item menu">
                                        <a href="#" class="nav-link robot_slab">
                                            Faculties
                                        </a>
                                        <ul class="submenu">
                                            <li><a href="{{ route('about') }}">About Us</a></li>
                                            <li><a href="{{ route('courses') }}">Courses</a></li>
                                            <li><a href="{{ route('faculties') }}">Faculties</a></li>
                                        </ul>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link robot_slab" href="{{ route('testimonials') }}">
                                            Student Speak
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link robot_slab" href="{{ route('blog.index') }}">
                                            Blog
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