<!DOCTYPE html>
<html lang="en">
<head> 
    @include('frontend.partials.meta')
    @include('frontend.partials.styles')
</head>
<body>

    @include('frontend.partials.header')

    <main>
        @yield('content')
    </main>

    @include('frontend.partials.footer')

    @include('frontend.partials.scripts')
    @yield('scripts')

</body>
</html>
