<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} – produkta apraksts</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        :root {
            --accent:#ff5c35;
            --accent-dark:#d94516;
            --ink:#181818;
            --muted:#6f6f6f;
            --border:#ededed;
            --card:#ffffff;
        }
        body { font-family:"Inter", Arial, sans-serif; background:#f7f7f7; color:var(--ink); line-height:1.6; }
        header { background:white; border-bottom:1px solid var(--border); position:sticky; top:0; z-index:10; }
        nav { max-width:1400px; margin:0 auto; padding:1.2rem 2rem; display:flex; justify-content:space-between; align-items:center; }
        .logo { font-weight:600; letter-spacing:-0.5px; font-size:1.15rem; }
        .nav-links { list-style:none; display:flex; gap:1.8rem; }
        .nav-links a { text-decoration:none; color:var(--muted); font-weight:500; transition:color 0.2s; }
        .nav-links a.active, .nav-links a:hover { color:var(--ink); }
        .nav-right { display:flex; align-items:center; gap:1.2rem; }
        .icon-button { background:none; border:none; font-size:1.2rem; color:var(--muted); cursor:pointer; }
        .auth-buttons { display:flex; gap:0.8rem; }
        .auth-buttons.signed-in { gap:0.6rem; }
        .btn-login, .btn-signup { padding:0.45rem 1.1rem; border-radius:8px; font-size:0.85rem; font-weight:500; cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; justify-content:center; }
        .btn-login { border:1px solid var(--border); background:none; }
        .btn-login:hover { background:#f5f5f5; }
        .btn-signup { border:none; background:var(--ink); color:white; }
        .btn-profile { border:none; background:var(--ink); color:white; padding:0.45rem 1.1rem; border-radius:8px; font-size:0.85rem; font-weight:500; text-decoration:none; display:inline-flex; align-items:center; gap:0.4rem; }
        .btn-profile:hover { background:#333; }
        .btn-cart { border:1px solid var(--border); background:white; color:var(--ink); padding:0.45rem 1.1rem; border-radius:8px; font-size:0.85rem; font-weight:500; text-decoration:none; display:inline-flex; align-items:center; gap:0.4rem; }
        .btn-cart:hover { background:#f5f5f5; }
        .user-greeting { font-size:0.85rem; font-weight:600; color:var(--ink); white-space:nowrap; }
        .logout-form { margin:0; }
        .btn-logout { border:none; background:#f1f1f1; color:#1a1a1a; padding:0.45rem 1rem; border-radius:8px; font-size:0.85rem; font-weight:500; cursor:pointer; transition:background 0.2s; }
        .btn-logout:hover { background:#dfdfdf; }
        .btn-add-cart { margin-top:0.5rem; padding:0.9rem 1.5rem; border-radius:12px; border:none; font-weight:600; cursor:pointer; display:inline-flex; align-items:center; gap:0.5rem; background:var(--ink); color:white; text-decoration:none; }
        .btn-add-cart.disabled { background:#e0e0e0; color:#777; cursor:not-allowed; }

        main { max-width:1400px; margin:0 auto; padding:2.5rem 2rem 3rem; }
        .hero-title { font-size:2.4rem; margin-bottom:0.4rem; }
        .intro { color:var(--muted); margin-bottom:2rem; }

        .product-card { background:var(--card); border:1px solid var(--border); border-radius:24px; padding:2rem; display:flex; flex-wrap:wrap; gap:1.5rem; box-shadow:0 20px 40px rgba(0,0,0,0.04); }
        .product-media { flex:1 1 320px; }
        .image-frame { width:100%; height:320px; border-radius:18px; background:#f0f0f0; display:flex; align-items:center; justify-content:center; color:#999; overflow:hidden; }
        .image-frame img { width:100%; height:100%; object-fit:cover; }
        .product-details { flex:1 1 360px; display:flex; flex-direction:column; gap:1rem; }
        .price { font-size:1.6rem; font-weight:700; }
        .tag-row { display:flex; gap:0.6rem; flex-wrap:wrap; font-size:0.9rem; color:var(--muted); }
        .tag { padding:0.2rem 0.7rem; border-radius:999px; background:#fff2ec; color:var(--accent-dark); font-weight:600; }
        .stock-ok { color:#0f9d58; }
        .stock-low { color:#c7771a; }
        .stock-out { color:#c0392b; }

        .section { margin-top:2rem; }
        .section h3 { font-size:1.2rem; margin-bottom:0.4rem; }
        .section p, .section pre { color:var(--ink); }
        .section pre { font-family:"Inter", Arial, sans-serif; background:#fefefe; padding:0.8rem; border-radius:12px; border:1px solid var(--border); white-space:pre-wrap; }

        .back-link { display:inline-flex; align-items:center; gap:0.4rem; margin-top:2.5rem; text-decoration:none; color:var(--accent); font-weight:600; }

        @media(max-width:680px){
            nav { flex-direction:column; gap:0.8rem; }
            .nav-links { flex-wrap:wrap; justify-content:center; }
            .product-card { padding:1.5rem; }
            .image-frame { height:240px; }
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
            <li><a href="{{ route('products.index') }}" class="active">Produkti</a></li>
            <li><a href="{{ route('offers.index') }}">Piedāvājumi</a></li>
            <li><a href="{{ route('our-work') }}">Darbi</a></li>
        </ul>
        <div class="nav-right">
            @auth
                <div class="user-greeting">Sveiki, {{ auth()->user()->name }}</div>
                <div class="auth-buttons signed-in">
                    <a class="btn-cart" href="#">🛒 Grozs</a>
                    <a class="btn-profile" href="{{ route('profile') }}">👤 Profils</a>
                    <form method="POST" action="{{ route('logout') }}" class="logout-form">
                        @csrf
                        <button type="submit" class="btn-logout">Iziet</button>
                    </form>
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

<main>
    <h1 class="hero-title">{{ $product->name }}</h1>
    <p class="intro">Detalizēta informācija par produktu un tā pielietojumu.</p>

    <article class="product-card">
        <div class="product-media">
            <div class="image-frame" onclick="window.location='{{ route('products.show', $product) }}'">
                @if($product->image)
                    <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}">
                @else
                    <span>Produkta attēls tiks pievienots</span>
                @endif
            </div>
        </div>
        <div class="product-details">
            <div>
                <p class="price">{{ number_format($product->price, 2) }} €</p>
                <p class="{{ $product->stock > 0 ? ($product->stock <= 5 ? 'stock-low' : 'stock-ok') : 'stock-out' }}">
                    @if($product->stock > 0)
                        @if($product->stock <= 5)
                            Atliek {{ $product->stock }} gb
                        @else
                            Noliktavā: {{ $product->stock }} gb
                        @endif
                    @else
                        Šobrīd nav pieejams noliktavā
                    @endif
                </p>
            </div>
            @if($product->supplier || $product->origin_country)
                <div class="tag-row">
                    @if($product->supplier)
                        <span class="tag">{{ $product->supplier }}</span>
                    @endif
                    @if($product->origin_country)
                        <span class="tag">Ražots: {{ $product->origin_country }}</span>
                    @endif
                </div>
            @endif
            @if($product->description || $product->long_description)
                <div class="section">
                    <h3>Produkta apraksts</h3>
                    <p>{{ $product->long_description ?? $product->description }}</p>
                </div>
            @endif
            @if($product->usage_instructions)
                <div class="section">
                    <h3>Kā lietot</h3>
                    <pre>{{ $product->usage_instructions }}</pre>
                </div>
            @endif
            <div class="section">
                <h3>Pievienot grozam</h3>
                @auth
                    <form method="POST" action="#">
                        @csrf
                        <button type="button" class="btn-add-cart">🛒 Pievienot grozam</button>
                        <p style="color:#777; margin-top:0.4rem;">(Groza funkcionalitāte tiks piesaistīta vēlāk.)</p>
                    </form>
                @else
                    <a class="btn-add-cart disabled" href="{{ route('login') }}">Ieiet, lai pievienotu grozā</a>
                @endauth
            </div>
        </div>
    </article>

    <a class="back-link" href="{{ route('products.index') }}">&larr; Atpakaļ uz produktu sarakstu</a>
</main>

<footer>
    <p>&copy; 2024 Auto Detailing Workshop. Visas tiesības aizsargātas.</p>
</footer>
</body>
</html>
