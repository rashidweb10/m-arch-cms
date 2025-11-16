<header>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-3">
                <div class="logo_width">
                    <a class="navbar-brand" href="/">
                        <img class="w-150" src="{{ uploaded_asset(get_setting('logo')) }}" />
                    </a>
                </div>
            </div>
            <div class="col-md-9 mt-md-2">
                <div class="call_box">
                    <a href="tel:{{get_setting('phone')}}"><i class="fa-solid fa-phone"></i> {{get_setting('phone')}}</a>
                </div>
                <nav class="navbar navbar-expand-lg p-0 mt-1">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                        <ul class="navbar-nav mb-2 mb-lg-0"></ul>
                        <div class="d-flex">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0 position_tops">
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">HOME</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">ABOUT US</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('products') ? 'active' : '' }}" href="{{ route('products') }}">PRODUCTS</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">CONTACT US</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</header>