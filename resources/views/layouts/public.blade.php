<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Auto Detailing Workshop')</title>
    <style>
        :root {
            color-scheme: light;
            color: var(--ink, #1a1a1a);
            background: var(--bg, #f7f2eb);
            --bg: #f7f2eb;
            --surface: #ffffff;
            --surface-strong: #ffffff;
            --ink: #1a1a1a;
            --muted: #666666;
            --border: #f4ddd2;
            --footer: #fff7f2;
            --button-surface: #ffffff;
            --button-border: #e8e8e8;
        }

        html {
            scrollbar-gutter: stable;
            overflow-y: scroll;
        }

        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: var(--bg);
            color: var(--ink);
            min-width: 0;
        }

        img,
        picture,
        video,
        canvas,
        svg,
        iframe {
            max-width: 100%;
            height: auto;
        }

        * {
            min-width: 0;
        }

        .site-header {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: var(--surface);
            border-bottom: 1px solid var(--border);
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
            border: 1px solid var(--border);
            border-radius: 999px;
            color: var(--muted, #666);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: var(--surface);
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
            background: var(--button-surface);
            border-color: var(--button-border);
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
            background: var(--button-surface);
            border-color: var(--button-border);
        }

        .site-btn-logout:hover {
            background: var(--surface-strong);
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
            color: var(--muted);
        }

        .footer-column a:hover {
            color: var(--ink, #1a1a1a);
        }

        .footer-bottom {
            text-align: center;
            padding: 1.5rem;
            color: var(--muted);
            font-size: 0.9rem;
            border-top: 1px solid var(--border);
        }

        @media (max-width: 900px) {
            .site-nav {
                flex-direction: column;
                align-items: stretch;
                gap: 1rem;
                padding: 1rem 1rem;
            }

            .site-logo {
                font-size: 1.05rem;
                text-align: center;
                width: 100%;
            }

            .site-nav-links {
                flex-wrap: wrap;
                justify-content: center;
                gap: 0.85rem;
                padding: 0.25rem 0;
            }

            .site-nav-links a {
                padding: 0.45rem 0.5rem;
                border-radius: 8px;
            }

            .site-nav-right {
                width: 100%;
                justify-content: center;
                flex-wrap: wrap;
                gap: 0.75rem;
            }

            .site-auth-buttons,
            .site-auth-buttons.site-auth-buttons-signed-in {
                justify-content: center;
            }

            .site-btn {
                white-space: normal;
                padding: 0.55rem 0.9rem;
            }

            .site-icon-button {
                margin: 0 auto;
            }

            .footer-wrapper {
                grid-template-columns: 1fr;
                gap: 1.5rem;
                padding: 2rem 1rem;
            }

            .site-footer {
                padding-bottom: 1rem;
            }

            .footer-bottom {
                padding: 1rem 0;
            }
        }

        @media (max-width: 640px) {
            .site-nav {
                padding: 1rem 0.75rem;
            }

            .footer-wrapper {
                padding: 1.5rem 0.75rem;
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

    @include('partials.public-footer')

    @stack('scripts')
</body>
</html>
