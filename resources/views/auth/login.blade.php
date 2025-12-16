<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pieteikties - Auto Detailing Workshop</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --accent: #ff5c35;
            --accent-dark: #d9461f;
            --accent-light: #fff1ec;
            --ink: #1a1a1a;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            color: var(--ink);
            background: #fafafa;
        }

        header {
            background: white;
            border-bottom: 1px solid #e8e8e8;
            padding: 1.2rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        nav {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--ink);
            letter-spacing: -0.5px;
        }

        .nav-links {
            display: flex;
            list-style: none;
            gap: 2.5rem;
        }

        .nav-links a {
            text-decoration: none;
            color: #666;
            font-size: 0.95rem;
            font-weight: 500;
            transition: color 0.2s;
        }

        .nav-links a:hover,
        .nav-links a.active {
            color: var(--ink);
        }

        .nav-right {
            display: flex;
            gap: 1.5rem;
            align-items: center;
        }

        .icon-button {
            background: none;
            border: none;
            font-size: 1.3rem;
            cursor: pointer;
            color: #666;
            transition: color 0.2s;
        }

        .icon-button:hover {
            color: var(--ink);
        }

        .auth-buttons {
            display: flex;
            gap: 1rem;
        }

        .btn-login,
        .btn-signup {
            padding: 0.5rem 1.2rem;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-login {
            background: none;
            border: 1px solid #e8e8e8;
            color: var(--ink);
            transition: all 0.2s;
        }

        .btn-login:hover {
            background: #f5f5f5;
        }

        .btn-signup {
            background: var(--ink);
            border: none;
            color: white;
            transition: all 0.2s;
        }

        .btn-signup:hover {
            background: #333;
        }

        .auth-buttons.signed-in {
            gap: 0.6rem;
        }

        .user-greeting {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--ink);
            white-space: nowrap;
        }

        .btn-cart,
        .btn-profile {
            padding: 0.45rem 1.1rem;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .btn-cart {
            border: 1px solid #e8e8e8;
            background: white;
            color: var(--ink);
        }

        .btn-cart:hover {
            background: #f5f5f5;
        }

        .btn-profile {
            border: none;
            background: var(--ink);
            color: white;
        }

        .btn-profile:hover {
            background: #333;
        }

        .auth-section {
            max-width: 1100px;
            margin: 0 auto;
            padding: 4rem 2rem 5rem;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 3rem;
        }

        .auth-copy {
            padding: 3rem;
            border-radius: 24px;
            background: white;
            border: 1px solid #f0e0d9;
            position: relative;
        }

        .auth-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.85rem;
            letter-spacing: 0.2rem;
            text-transform: uppercase;
            color: var(--accent-dark);
            background: rgba(255, 92, 53, 0.12);
            padding: 0.45rem 1.2rem;
            border-radius: 999px;
            margin-bottom: 1rem;
        }

        .auth-copy h1 {
            font-size: 2.6rem;
            line-height: 1.2;
            margin-bottom: 1rem;
        }

        .auth-copy p {
            color: #555;
            margin-bottom: 1.5rem;
        }

        .auth-card {
            background: white;
            border-radius: 24px;
            padding: 3rem;
            border: 1px solid #e8e8e8;
            box-shadow: 0 15px 35px rgba(0,0,0,0.05);
        }

        .auth-card h2 {
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
        }

        .auth-card p {
            color: #666;
            margin-bottom: 2rem;
        }

        .form-field {
            margin-bottom: 1.3rem;
        }

        .form-field label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.4rem;
        }

        .form-field input {
            width: 100%;
            padding: 0.95rem;
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            font-size: 1rem;
            transition: border 0.2s;
        }

        .form-field input:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-light);
        }

        .remember-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .primary-btn {
            width: 100%;
            padding: 1rem;
            border: none;
            border-radius: 12px;
            background: var(--accent);
            color: white;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }

        .primary-btn:hover {
            background: var(--accent-dark);
        }

        .secondary-link {
            margin-top: 1rem;
            text-align: center;
            font-size: 0.95rem;
        }

        .secondary-link a {
            color: var(--accent);
            font-weight: 600;
            text-decoration: none;
        }

        .message {
            margin-top: 1.5rem;
            padding: 1rem;
            border-radius: 12px;
            text-align: center;
            font-weight: 600;
            display: none;
        }

        .message.success {
            display: block;
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .message.error {
            display: block;
            background: #f8d7da;
            color: #842029;
            border: 1px solid #f5c2c7;
        }

        footer {
            max-width: 1400px;
            margin: 0 auto;
            padding: 3rem 2rem;
            text-align: center;
            color: #666;
        }

        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }

            .auth-card,
            .auth-copy {
                padding: 2rem;
            }
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <div class="logo">Auto Detailing</div>
            <ul class="nav-links">
                <li><a href="{{ route('home') }}">Galvenā</a></li>
                <li><a href="{{ route('services.index') }}">Pakalpojumi</a></li>
                <li><a href="{{ route('products.index') }}">Produkti</a></li>
                <li><a href="{{ route('offers.index') }}">Piedāvājumi</a></li>
                <li><a href="{{ route('our-work') }}">Darbi</a></li>
            </ul>
            <div class="nav-right">
                @auth
                    <div class="user-greeting">Sveiki, {{ auth()->user()->name }}</div>
                    <div class="auth-buttons signed-in">
                        <a class="btn-cart" href="#">🛒 Grozs</a>
                        <a class="btn-profile" href="{{ route('profile') }}">👤 Profils</a>
                    </div>
                @else
                    <button class="icon-button" title="Profils">👤</button>
                    <div class="auth-buttons">
                        <a class="btn-login" href="{{ route('login') }}">Ieiet</a>
                        <a class="btn-signup" href="{{ route('register') }}">Reģistrēties</a>
                    </div>
                @endauth
            </div>
        </nav>
    </header>

    <section class="auth-section">
        <div class="auth-copy">
            <div class="auth-pill">Drošs konts</div>
            <h1>Pieslēdzies, lai pārvaldītu rezervācijas un pasūtījumus</h1>
            <p>Saglabā savu pakalpojumu vēsturi, piekļūsti rēķiniem un seko līdzi piedāvājumiem vienuviet.</p>
            <ul style="list-style:none; color:#444; display:flex; flex-direction:column; gap:0.8rem;">
                <li>✅ Saglabā iecienītos pakalpojumus</li>
                <li>✅ Piekļūsti ekskluzīviem piedāvājumiem</li>
                <li>✅ Saņem atgādinājumus par vizītēm</li>
            </ul>
        </div>

        <div class="auth-card">
            <h2>Pieteikties</h2>
            <p>Ievadi savu e-pastu un paroli</p>
            <form method="POST" action="{{ route('login.store') }}">
                @csrf
                <div class="form-field">
                    <label for="email">E-pasts</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="piem., vards@example.com">
                    @error('email')
                        <small style="color:#c53030; display:block; margin-top:0.3rem;">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-field">
                    <label for="password">Parole</label>
                    <input type="password" id="password" name="password" required placeholder="********">
                    @error('password')
                        <small style="color:#c53030; display:block; margin-top:0.3rem;">{{ $message }}</small>
                    @enderror
                </div>
                <div class="remember-row">
                    <label style="display:flex; gap:0.5rem; align-items:center; font-size:0.9rem; color:#555;">
                        <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        Atcerēties mani
                    </label>
                    <a href="javascript:void(0)" style="color:var(--accent); font-weight:600; text-decoration:none;">Aizmirsi paroli?</a>
                </div>
                <button type="submit" class="primary-btn">Ieiet</button>
                @if ($errors->any())
                    <div class="message error" style="margin-top:1rem;">{{ $errors->first() }}</div>
                @endif
                @if (session('status'))
                    <div class="message success" style="margin-top:1rem;">{{ session('status') }}</div>
                @endif
            </form>
            <div class="secondary-link">
                Nav konta? <a href="{{ route('register') }}">Reģistrējies</a>
            </div>
        </div>
    </section>

    <footer>
        <p>&copy; 2024 Auto Detailing Workshop. Visas tiesības aizsargātas.</p>
    </footer>
</body>
</html>
