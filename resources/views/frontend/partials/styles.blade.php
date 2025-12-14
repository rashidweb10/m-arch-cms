<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100..900&amp;family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&amp;display=swap" rel="stylesheet">

<!-- Local Stylesheets -->
<link rel="stylesheet" href="{{ asset('assets/frontend/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('assets/frontend/css/responsive.css') }}">
<link rel="stylesheet" href="{{ asset('assets/frontend/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/frontend/css/owl.carousel.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/frontend/css/owl.theme.default.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/frontend/css/aos.css') }}">
<link rel="stylesheet" href="{{ asset('assets/frontend/css/hover.css') }}">

<!-- FontAwesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<!-- Fancybox CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.css" />

<style>

/* Submenu */
.submenu {
	display: none;
	position: absolute;
	top: 100%;
	background-color: #bde3fa;
	border-top: 0px solid transparent;
	width: 220px;
	z-index: 1000;
	padding-left: 0px !important;
	padding-right: 0px !important;
}

.menu>li:hover>.submenu {
	display: block;
}

.submenu li {
	position: relative;
	margin-left: 0px !important;
	border-bottom: 1px dashed #888;
	padding-top: 7px;
	padding-bottom: 7px;
}

.submenu li:last-child {
	border-bottom: none !important;
}

.submenu li:hover {
	background-color: #92c2e7;
}

.submenu li a {
	padding: 10px 15px;
	color: #000 !important;
	text-decoration: none;
}

.submenu li:hover a {
	color: #000 !important;
	background: transparent;
}

/* Submenu Images */
.submenu img {
	width: 17px;
	position: relative;
	top: -2px;
	left: -4px;
	filter: grayscale(0%) contrast(0%) brightness(0) !important;
	margin-right: 4px;
}

.submenu img:hover {
	filter: grayscale(0%) !important;
}

.submenu a:hover img {
	filter: grayscale(100%) !important;
}

/* Nested Submenu */
.submenu .submenu {
	left: 100%;
	top: 0;
	display: none;
	overflow: hidden;
}

.submenu li:hover>.submenu {
	display: block;
}

/* Reset List Styles */
ul {
	list-style: none;
	margin: 0;
	padding: 0;
}

.submenu li a i {
	margin-right: 4px;
	position: relative;
	top: 1px;
}

</style>
