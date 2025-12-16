<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produkti - Auto Detailing Workshop</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --accent: #ff5c35;
            --accent-dark: #d94516;
            --ink: #181818;
            --muted: #6f6f6f;
            --card: #ffffff;
            --border: #ededed;
        }
        body { font-family: "Inter", Arial, sans-serif; background:#f7f7f7; color:var(--ink); line-height:1.6; }
        header, footer { background:white; border-bottom:1px solid var(--border); }
        footer { border-top:1px solid var(--border); border-bottom:none; }
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
        .btn-logout { border:none; background:#f1f1f1; color:var(--ink); padding:0.45rem 1rem; border-radius:8px; font-size:0.85rem; font-weight:500; cursor:pointer; transition:background 0.2s; }
        .btn-logout:hover { background:#e0e0e0; }

        main { max-width:1400px; margin:0 auto; padding:2.5rem 2rem 3rem; }
        h1 { font-size:2.4rem; margin-bottom:0.6rem; }
        .lead { color:var(--muted); margin-bottom:2rem; }

        .products-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(260px,1fr)); gap:1.2rem; }
        .product-card { background:var(--card); border:1px solid var(--border); border-radius:16px; padding:1.3rem; display:flex; flex-direction:column; gap:0.6rem; }
        .product-image { width:100%; height:180px; border-radius:12px; background:#f0f0f0; display:flex; align-items:center; justify-content:center; font-size:0.85rem; color:#999; overflow:hidden; cursor:pointer; }
        .product-image img { width:100%; height:100%; object-fit:cover; }
        .product-card h2 { font-size:1.2rem; color:var(--ink); cursor:pointer; }
        .price { font-weight:700; }
        .stock { font-size:0.9rem; color:var(--muted); }
        .stock-ok { color:#0f9d58; }
        .stock-low { color:#c7771a; }
        .stock-out { color:#c0392b; }
        .product-footer { margin-top:auto; display:flex; justify-content:space-between; font-size:0.9rem; color:var(--muted); }
        .product-footer a { text-decoration:none; color:var(--accent); font-weight:600; }

        @media (max-width:600px) {
            nav { flex-direction:column; gap:0.8rem; }
            .nav-links { flex-wrap:wrap; justify-content:center; }
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
    <h1>Produkti auto kopšanai</h1>
    <p class="lead">Atlasīti līdzekļi, lai Tavs auto izskatītos perfekti arī starp vizītēm servisā.</p>

    @if($products->count())
        <div class="products-grid">
            @foreach($products as $product)
                @php $inStock = $product->stock > 0; @endphp
                <article class="product-card" data-product-id="{{ $product->id }}">
                    <div class="product-image" onclick="window.location='{{ route('products.show', $product) }}'">
                        @if($product->image)
                            <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}">
                        @else
                            <span>Attēls tiks pievienots</span>
                        @endif
                    </div>
                    <h2 onclick="window.location='{{ route('products.show', $product) }}'">{{ $product->name }}</h2>
                    <p class="price">{{ number_format($product->price, 2) }} €</p>
                    @if($product->description)
                        <p>{{ $product->description }}</p>
                    @endif
                    <p class="stock {{ $inStock ? ($product->stock <= 5 ? 'stock-low' : 'stock-ok') : 'stock-out' }}">
                        @if($inStock)
                            @if($product->stock <= 5)
                                Atliek {{ $product->stock }} gb
                            @else
                                Noliktavā: {{ $product->stock }} gb
                            @endif
                        @else
                            Nav pieejams
                        @endif
                    </p>
                    <div class="product-footer">
                        <span>{{ $inStock ? 'Pieejams tūlītējai izsniegšanai' : 'Drīzumā pieejams' }}</span>
                        <a href="{{ route('products.show', $product) }}">Detaļas →</a>
                    </div>
                </article>
            @endforeach
        </div>
    @else
        <p>Šobrīd nav pieejamu produktu.</p>
    @endif
</main>

<footer>
    <p>&copy; 2024 Auto Detailing Workshop. Visas tiesības aizsargātas.</p>
</footer>
</body>
</html>
