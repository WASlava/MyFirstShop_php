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
