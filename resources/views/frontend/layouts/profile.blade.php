@extends('frontend.layouts.app')

@section('content')

@include('frontend.partials.breadcrumb', ['title' => $pageTitle ?? 'My Account'])

<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Sidebar Navigation -->
            <div class="col-md-3 mb-4">
                <div class="bg-light p-3 rounded-3 shadow-sm">
                    <div class="text-center mb-3 pb-3 border-bottom">
                        <h5 class="mb-0 robot_slab">My Account</h5>
                    </div>
                    <nav class="nav flex-column">
                        <a class="nav-link {{ request()->routeIs('auth.dashboard') ? 'active bg-primary text-white rounded' : '' }}" href="{{ route('auth.dashboard') }}">
                            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                        </a>
                        <a class="nav-link {{ request()->routeIs('auth.profile') ? 'active bg-primary text-white rounded' : '' }}" href="{{ route('auth.profile') }}">
                            <i class="fas fa-user me-2"></i> Edit Profile
                        </a>
                        <a class="nav-link {{ request()->routeIs('auth.change-password') ? 'active bg-primary text-white rounded' : '' }}" href="{{ route('auth.change-password') }}">
                            <i class="fas fa-lock me-2"></i> Change Password
                        </a>
                        <a class="nav-link {{ request()->routeIs('auth.enrolled-courses') ? 'active bg-primary text-white rounded' : '' }}" href="{{ route('auth.enrolled-courses') }}">
                            <i class="fas fa-graduation-cap me-2"></i> Enrolled Courses
                        </a>
                        <hr>
                        <form action="{{ route('auth.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start text-danger p-0">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </button>
                        </form>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9">
                @yield('profile-content')
            </div>
        </div>
    </div>
</section>

@endsection

<style>
.nav-link {
    color: #333;
    padding: 0.75rem 1rem;
    margin-bottom: 0.25rem;
    transition: all 0.3s;
}
.nav-link:hover {
    background-color: #e9ecef;
    border-radius: 0.375rem;
}
.nav-link.active {
    font-weight: 600;
}
</style>

