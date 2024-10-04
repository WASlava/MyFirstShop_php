@php
    use Illuminate\Support\Facades\Auth;
    $currentController = request()->route()->getName();
    $categories = app(\App\Http\Services\CategoryService::class)->getCategoriesMenu();
@endphp

    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/site.css" />
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    @yield('head_scripts')
</head>
<body>

@include('components.navigation')

<div class="container-fluid">
    {{--    @if ($currentController == 'home' || $currentController == 'products.index')--}}
    {{--        @include('components.categories_menu')--}}
    {{--    @endif--}}
    <x-categories-menu :categories="$categories" />
</div>

{{--<div class="container">--}}
{{--    @yield('content')--}}
{{--</div>--}}



<div class="container">
    <main role="main" class="pb-3">
        @yield('content')
    </main>
</div>

<footer class="border-top footer text-muted  sticky-footer">
    <div class="container">
        &copy; 2024 - "My Online Store" - <a href="{{ route('privacy') }}">Privacy</a>
    </div>
</footer>

@yield('end_scripts')
<script src="https://kit.fontawesome.com/ffcaad880f.js" crossorigin="anonymous"></script>
<script src="/lib/jquery/dist/jquery.min.js"></script>
<script src="/lib/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
