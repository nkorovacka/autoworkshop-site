<header class="site-header">
    <nav class="site-nav">
        <a class="site-logo" href="{{ route('home') }}">Auto Detailing</a>

        <ul class="site-nav-links">
            <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Galvenā</a></li>
            <li><a href="{{ route('services.index') }}" class="{{ request()->routeIs('services.*') ? 'active' : '' }}">Pakalpojumi</a></li>
            <li><a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'active' : '' }}">Produkti</a></li>
            <li><a href="{{ route('offers.index') }}" class="{{ request()->routeIs('offers.*') ? 'active' : '' }}">Piedāvājumi</a></li>
            <li><a href="{{ route('our-work') }}" class="{{ request()->routeIs('our-work') ? 'active' : '' }}">Darbi</a></li>
        </ul>

        <div class="site-nav-right">
            @auth
                <div class="site-auth-buttons site-auth-buttons-signed-in">
                    <a class="site-btn site-btn-cart {{ request()->routeIs('cart.*') ? 'active' : '' }}" href="{{ route('cart.index') }}">Grozs</a>
                    <a class="site-btn site-btn-profile {{ request()->routeIs('profile') ? 'active' : '' }}" href="{{ route('profile') }}">
                        <svg class="site-btn-icon" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm-7 8a7 7 0 0 1 14 0"/>
                        </svg>
                        Profils
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="site-logout-form">
                        @csrf
                        <button type="submit" class="site-btn site-btn-logout">Iziet</button>
                    </form>
                </div>
            @else
                <span class="site-icon-button" aria-hidden="true">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm-7 8a7 7 0 0 1 14 0"/>
                    </svg>
                </span>
                <div class="site-auth-buttons">
                    <a class="site-btn site-btn-login {{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">Ieiet</a>
                    <a class="site-btn site-btn-signup {{ request()->routeIs('register') ? 'active' : '' }}" href="{{ route('register') }}">Reģistrēties</a>
                </div>
            @endauth
        </div>
    </nav>
</header>
