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
        .quantity-row { display:flex; align-items:center; gap:0.8rem; margin-top:0.5rem; }
        .quantity-row label { font-weight:600; }
        .quantity-row input { width:90px; padding:0.5rem; border-radius:10px; border:1px solid var(--border); }
        .quantity-row input:focus { outline:none; border-color:var(--accent); box-shadow:0 0 0 3px rgba(255,92,53,0.15); }
        .flash { padding:0.9rem 1.1rem; border-radius:12px; margin:1rem 0; font-weight:500; }
        .flash-success { background:#e6f5ef; color:#136b3a; border:1px solid #b7e2c9; }
        .flash-error { background:#fdecea; color:#b5302c; border:1px solid #f3c0b7; }

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

        footer { background:white; border-top:1px solid #e8e8e8; margin-top:4rem; }
        .footer-wrapper { max-width:1400px; margin:0 auto; padding:3rem 2rem; display:grid; grid-template-columns:repeat(auto-fit,minmax(220px,1fr)); gap:2rem; color:#555; }
        .footer-column h4 { font-size:1rem; text-transform:uppercase; letter-spacing:0.15rem; color:var(--ink); margin-bottom:1rem; }
        .footer-column ul { list-style:none; display:flex; flex-direction:column; gap:0.6rem; }
        .footer-column a { text-decoration:none; color:#666; }
        .footer-column a:hover { color:var(--ink); }
        .footer-bottom { text-align:center; padding:1.5rem; color:#777; font-size:0.9rem; border-top:1px solid #f0f0f0; }

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
                    <a class="btn-cart" href="{{ route('cart.index') }}">🛒 Grozs</a>
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

    @if(session('success'))
        <div class="flash flash-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="flash flash-error">{{ $errors->first() }}</div>
    @endif

    @php
        $inStock = $product->stock > 0;
        $maxQty = $inStock ? min($product->stock, 100) : 100;
    @endphp
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
                <p class="{{ $inStock ? ($product->stock <= 5 ? 'stock-low' : 'stock-ok') : 'stock-out' }}">
                    @if($inStock)
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
                    @if($inStock)
                        <form method="POST" action="{{ route('cart.add', $product) }}">
                            @csrf
                            <div class="quantity-row">
                                <label for="quantity">Daudzums</label>
                                <input type="number"
                                       id="quantity"
                                       name="quantity"
                                       min="1"
                                       max="{{ $maxQty }}"
                                       value="1">
                            </div>
                            <button type="submit" class="btn-add-cart">🛒 Pievienot grozam</button>
                        </form>
                    @else
                        <p style="color:#b5302c;">Šobrīd nav iespējams pievienot grozam (produkts nav noliktavā).</p>
                    @endif
                @else
                    <a class="btn-add-cart disabled" href="{{ route('login') }}">Ieiet, lai pievienotu grozā</a>
                @endauth
            </div>
        </div>
    </article>

    <a class="back-link" href="{{ route('products.index') }}">&larr; Atpakaļ uz produktu sarakstu</a>
</main>

<footer>
    <div class="footer-wrapper">
        <div class="footer-column">
            <h4>Salons</h4>
            <p>Auto Detailing Workshop<br>Brīvības iela 123, Rīga</p>
            <p>Darba laiks:<br>Pirmdiena-Piektdiena 9:00-19:00<br>Brīvdienās nestrādājam</p>
        </div>
        <div class="footer-column">
            <h4>Kontakti</h4>
            <ul>
                <li>📞 +371 2000 0000</li>
                <li>✉️ info@detailing.lv</li>
                <li>WhatsApp & Telegram</li>
            </ul>
        </div>
        <div class="footer-column">
            <h4>Ātrās saites</h4>
            <ul>
                <li><a href="{{ route('services.index') }}">Pakalpojumi</a></li>
                <li><a href="{{ route('products.index') }}">Produkti</a></li>
                <li><a href="{{ route('offers.index') }}">Piedāvājumi</a></li>
                <li><a href="{{ route('booking.create') }}">Rezervēt vizīti</a></li>
            </ul>
        </div>
        <div class="footer-column">
            <h4>Sekojiet mums</h4>
            <ul>
                <li><a href="#">Instagram</a></li>
                <li><a href="#">Facebook</a></li>
                <li><a href="#">YouTube</a></li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        &copy; {{ date('Y') }} Auto Detailing Workshop. Visas tiesības aizsargātas.
    </div>
</footer>
</body>
</html>
