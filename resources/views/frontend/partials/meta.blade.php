<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge" />
<title>@yield('meta.title', get_setting('meta_title'))</title>
<meta name="description" content="@yield('meta.description', get_setting('meta_description'))">

<!-- Favicon -->
<link rel="icon" type="image/png" href="{{ asset('assets/frontend/img/favicon.png') }}"> 