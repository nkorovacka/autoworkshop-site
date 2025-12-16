<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mans profils - Auto Detailing</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif; background:#fafafa; color:#1a1a1a; }
        header { background:white; border-bottom:1px solid #e8e8e8; position:sticky; top:0; z-index:100; }
        nav { max-width:1400px; margin:0 auto; padding:1.2rem 2rem; display:flex; justify-content:space-between; align-items:center; }
        .logo { font-size:1.3rem; font-weight:600; letter-spacing:-0.5px; }
        .nav-links { display:flex; list-style:none; gap:2.5rem; }
        .nav-links a { text-decoration:none; color:#666; font-weight:500; }
        .nav-links a:hover, .nav-links a.active { color:#1a1a1a; }
        .nav-right { display:flex; align-items:center; gap:1rem; }
        .auth-buttons { display:flex; gap:0.6rem; align-items:center; }
        .user-greeting { font-weight:600; }
        .btn-cart, .btn-profile, .btn-logout { padding:0.45rem 1rem; border-radius:8px; border:none; text-decoration:none; font-weight:500; cursor:pointer; display:inline-flex; align-items:center; gap:0.3rem; }
        .btn-cart { background:white; border:1px solid #e8e8e8; color:#1a1a1a; }
        .btn-profile { background:#1a1a1a; color:white; }
        .btn-logout { background:#f1f1f1; color:#1a1a1a; }
        .btn-cart:hover { background:#f5f5f5; }
        .btn-profile:hover { background:#333; }
        .btn-logout:hover { background:#dfdfdf; }
        main { max-width:900px; margin:2rem auto; background:white; border-radius:24px; padding:3rem; border:1px solid #e8e8e8; }
        h1 { font-size:2rem; margin-bottom:1rem; }
        p { color:#555; }
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
            <div class="user-greeting">Sveiki, {{ auth()->user()->name }}</div>
            <div class="auth-buttons">
                <a class="btn-cart" href="#">🛒 Grozs</a>
                <a class="btn-profile" href="{{ route('profile') }}">👤 Profils</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-logout">Iziet</button>
                </form>
            </div>
        </div>
    </nav>
</header>

<main>
    <h1>Mans profils</h1>
    <p>Šī ir profila lapas tukšā versija. Šeit vēlāk varēs redzēt rezervācijas, pasūtījumus un konta informāciju.</p>
</main>
</body>
</html>
