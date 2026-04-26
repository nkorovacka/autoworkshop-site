<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Auto Detailing Workshop')</title>
    <style>
        html {
            scrollbar-gutter: stable;
            overflow-y: scroll;
        }

        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .site-header {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: #fff7f2;
            border-bottom: 1px solid #f4ddd2;
            font-family: "Inter", Arial, sans-serif;
        }

        .site-content {
            width: 100%;
            flex: 1 0 auto;
            min-width: 0;
        }

        .site-content > * {
            width: 100%;
        }

        .site-nav {
            max-width: 1400px;
            margin: 0 auto;
            padding: 1.2rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1.5rem;
        }

        .site-logo {
            color: var(--ink, #1a1a1a);
            font-size: 1.2rem;
            font-weight: 600;
            letter-spacing: -0.5px;
            text-decoration: none;
            white-space: nowrap;
        }

        .site-nav-links {
            display: flex;
            align-items: center;
            gap: 2rem;
            list-style: none;
        }

        .site-nav-links a {
            color: var(--muted, #666);
            font-size: 0.95rem;
            font-weight: 500;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .site-nav-links a:hover,
        .site-nav-links a.active {
            color: var(--ink, #1a1a1a);
        }

        .site-nav-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .site-user-greeting {
            color: var(--ink, #1a1a1a);
            font-size: 0.88rem;
            font-weight: 600;
            white-space: nowrap;
        }

        .site-icon-button {
            width: 34px;
            height: 34px;
            border: 1px solid #ead8cf;
            border-radius: 999px;
            color: var(--muted, #666);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #fff;
            line-height: 1;
        }

        .site-icon-button svg,
        .site-btn-icon {
            width: 16px;
            height: 16px;
            fill: none;
            stroke: currentColor;
            stroke-width: 1.8;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .site-auth-buttons {
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .site-auth-buttons.site-auth-buttons-signed-in {
            gap: 0.6rem;
        }

        .site-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.35rem;
            padding: 0.45rem 1.1rem;
            border-radius: 8px;
            border: 1px solid transparent;
            color: var(--ink, #1a1a1a);
            font-size: 0.85rem;
            font-weight: 500;
            text-decoration: none;
            white-space: nowrap;
            transition: background 0.2s ease, border-color 0.2s ease, color 0.2s ease;
        }

        .site-btn-login,
        .site-btn-cart {
            background: #fff;
            border-color: #e8e8e8;
        }

        .site-btn-login:hover,
        .site-btn-cart:hover,
        .site-btn-login.active,
        .site-btn-cart.active {
            background: #f5f5f5;
        }

        .site-btn-signup,
        .site-btn-profile {
            background: var(--ink, #1a1a1a);
            color: #fff;
        }

        .site-btn-signup:hover,
        .site-btn-profile:hover,
        .site-btn-signup.active,
        .site-btn-profile.active {
            background: #333;
        }

        .site-btn-logout {
            background: #f1f1f1;
        }

        .site-btn-logout:hover {
            background: #dfdfdf;
        }

        .site-logout-form {
            margin: 0;
        }

        .site-logout-form button {
            cursor: pointer;
        }

        .site-footer {
            background: #fff7f2;
            border-top: 1px solid #f4ddd2;
            margin-top: auto;
        }

        .footer-wrapper {
            max-width: 1400px;
            margin: 0 auto;
            padding: 3rem 2rem;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 2rem;
            color: #555;
        }

        .footer-column h4 {
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 0.15rem;
            color: var(--ink, #1a1a1a);
            margin-bottom: 1rem;
        }

        .footer-column ul {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 0.6rem;
        }

        .footer-column a {
            text-decoration: none;
            color: #666;
        }

        .footer-column a:hover {
            color: var(--ink, #1a1a1a);
        }

        .footer-bottom {
            text-align: center;
            padding: 1.5rem;
            color: #777;
            font-size: 0.9rem;
            border-top: 1px solid #f0f0f0;
        }

        @media (max-width: 900px) {
            .site-nav {
                flex-direction: column;
            }

            .site-nav-links {
                flex-wrap: wrap;
                justify-content: center;
                gap: 1rem;
            }

            .site-nav-right {
                width: 100%;
                justify-content: center;
                flex-wrap: wrap;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    @include('partials.public-header')

    <div class="site-content">
        @yield('content')
    </div>

    @unless (request()->routeIs('login') || request()->routeIs('register'))
        @include('partials.public-footer')
    @endunless

    @stack('scripts')
</body>
</html>
