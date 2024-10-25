<nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
        <a href="/" class="navbar-brand">
            <img src="{{ asset('Admin') }}/dist/img/AdminLTELogo.png" alt="AdminLTE Logo"
                class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">My Store</span>
        </a>

        <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse"
            aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse order-3" id="navbarCollapse">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="/" @class(['nav-link', 'active' => request()->routeIs('front.category')])>Home</a>
                </li>


            </ul>
        </div>

        <!-- Right navbar links -->
        <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
            <!-- Messages Dropdown Menu -->

            <!-- Notifications Dropdown Menu -->

            <li class="nav-item">
                @guest
                    <a href="{{ route('login') }}" class="btn btn-sm btn-primary">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-sm btn-secondary">Register</a>
                @endguest
                @auth
                    <span class="mr-2">Welcome Back, <b>{{ auth()->user()->name }}</b></span>
                    <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-primary">Profile</a>
                    @if (auth()->user()->is_admin)

                        <a href="{{ route('dashboard') }}" class="btn btn-sm btn-secondary">Dashboard</a>
                    @endif
                    <form action="{{ route('logout') }}" method="post" class="d-inline-block">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-primary">Logout</button>
                    </form>
                @endauth
            </li>
        </ul>
    </div>
</nav>
