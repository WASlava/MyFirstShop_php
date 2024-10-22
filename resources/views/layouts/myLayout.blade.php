@php
    use Illuminate\Support\Facades\Auth;
    $currentController = request()->route()->getName();
    $categories = app(\App\Http\Services\CategoryService::class)->getCategoriesMenu();
@endphp

    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="/css/site.css" />
    @yield('styles')
    @yield('head_scripts')
</head>
<body>

@include('components.navigation')

<div class="container-fluid fixed-top1">
    @if ($currentController == 'home' || $currentController == 'products.index')
        @include('components.categories-menu', ['categories' => $categories])
    @endif
</div>
{{--<script>--}}
{{--    function adjustPaddingTop() {--}}
{{--        var mainNavbarHeight = document.getElementById('main-navbar').offsetHeight;--}}
{{--        var secondNavbar = document.getElementById('second-navbar');--}}
{{--        var secondNavbarHeight = secondNavbar ? secondNavbar.offsetHeight : 0;--}}

{{--        var totalNavbarHeight = mainNavbarHeight + secondNavbarHeight;--}}
{{--        document.querySelector('.main-content').style.paddingTop = totalNavbarHeight + 'px';--}}
{{--    }--}}

{{--    // Викликаємо функцію при завантаженні сторінки--}}
{{--    window.onload = adjustPaddingTop;--}}

{{--    // Викликаємо функцію при зміні розміру вікна--}}
{{--    window.onresize = adjustPaddingTop;--}}
{{--</script>--}}
<div class="container main-content">
    <main role="main" class="pb-3">
        @yield('content')
    </main>
</div>

@if(session('success'))
    <div class="alert alert-success fixed-alert">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger fixed-alert">
        {{ session('error') }}
    </div>
@endif

{{--<footer class="footer-container">--}}
<footer class="border-top footer text-muted sticky-footer">
    <div class="container">
        &copy; 2024 - "My Online Store" - <a href="{{ route('privacy') }}">Privacy</a>
    </div>
</footer>


<!-- Font Awesome -->
<script src="https://kit.fontawesome.com/ffcaad880f.js" crossorigin="anonymous"></script>

<!-- Bootstrap JS Bundle (Popper included) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- Optional jQuery -->
<script src="/lib/jquery/dist/jquery.min.js"></script>

@yield('end_scripts')
</body>
</html>
