<nav class="navbar navbar-expand-sm navbar-toggleable-sm navbar-light bg-white border-bottom box-shadow mb-1">
    <div class="container-fluid">
{{--        <a class="navbar-brand" href="#">My Online Store</a>--}}
                    <a class="navbar-brand" href="{{ route('home') }}">My Online Store</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse d-sm-inline-flex justify-content-between" id="navbarSupportedContent">
            <ul class="navbar-nav flex-grow-1">
                <li class="nav-item">
{{--                    <a class="nav-link text-dark" href="#">Home</a>--}}
                                            <a class="nav-link text-dark" href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
{{--                    <a class="nav-link text-dark" href="#">Products</a>--}}
                                            <a class="nav-link text-dark" href="{{ route('products.index') }}">Products</a>
                </li>
                    @if(Auth::check())
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="{{ route('account.index') }}">Profile</a>
                        </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('orders.index') }}">My orders</a>
                    </li>

                    @endif
                    @if (Auth::check() && (Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Manager')))
                        <li class="nav-item">
                              <a class="nav-link text-dark" href="{{ route('roles.index') }}">Roles</a>
                        </li>
                        <li class="nav-item">
                              <a class="nav-link text-dark" href="{{ route('users.index') }}">Users</a>
                        </li>
                        <li class="nav-item">
                              <a class="nav-link text-dark" href="{{ route('brands.index') }}">Brands</a>
                        </li>
                        <li class="nav-item">
                              <a class="nav-link text-dark" href="{{ route('categories.index') }}">Categories</a>
                        </li>
                        <li class="nav-item">
                              <a class="nav-link text-dark" href="{{ route('image.index') }}">Image</a>
                        </li>
                    @endif
            </ul>
                <ul class="navbar-nav" style="padding-right:20px">
                    <div class="d-flex">
                        @auth
                            <span class="mx-4" style="align-content:center">Hello, {{ auth()->user()->name }}</span>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <input type="hidden" name="returnUrl" value="/products">
                                <input type="submit" value="Logout" class="btn btn-outline-secondary">
                            </form>
                        @else
                            <a href="{{ route('register') }}" class="btn btn-outline-dark" style="margin:0 0 0 5px">Register</a>
                            <a href="{{ route('login') }}" class="btn btn-outline-dark" style="margin:0 0 0 5px">Login</a>
                        @endauth
                    </div>
                </ul>

            <div id="cart-summary">
                                    @include('layouts.cartSummary')
            </div>
        </div>
    </div>
</nav>
