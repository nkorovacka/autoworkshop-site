<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produkti - Auto Detailing Workshop</title>
    
</head>
<body>
<!-- Galvene ar navigāciju un lietotāja stāvokli -->
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
    <!-- Lapas virsraksts un ievads -->
    <h1>Produkti auto kopšanai</h1>
    <p class="lead">Atlasīti līdzekļi, lai Tavs auto izskatītos perfekti arī starp vizītēm servisā.</p>

    <!-- Flash paziņojumi par groza darbībām -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-error">{{ $errors->first() }}</div>
    @endif

    <!-- Filtri meklēšanai un kārtošanai -->
    <div class="product-filters">
        <div class="search-control">
            <label for="productSearch">Meklēt nosaukumu</label>
            <input type="text" id="productSearch" placeholder="Sāc rakstīt produktu nosaukumu...">
        </div>
        <div class="sort-control">
            <label for="productSort">Kārtot pēc</label>
            <select id="productSort">
                <option value="name-asc">Alfabēta secībā (A-Z)</option>
                <option value="name-desc">Alfabēta secībā (Z-A)</option>
                <option value="price-asc">Cena: no zemākās</option>
                <option value="price-desc">Cena: no augstākās</option>
            </select>
        </div>
    </div>

    <!-- Produktu režģis -->
    @if($products->count())
        <div class="products-grid" id="productsGrid">
            @foreach($products as $product)
                @php $inStock = $product->stock > 0; @endphp
                <!-- Viena produkta kartīte -->
                <article class="product-card"
                         data-name="{{ Str::lower($product->name) }}"
                         data-price="{{ $product->price }}"
                         data-product-id="{{ $product->id }}">
                    <!-- Produkta attēls ar klikšķi uz detaļu lapu -->
                    <div class="product-image" onclick="window.location='{{ route('products.show', $product) }}'">
                        @if($product->image)
                            <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}">
                        @else
                            <span>Attēls tiks pievienots</span>
                        @endif
                    </div>
                    <!-- Produkta nosaukums -->
                    <h2 onclick="window.location='{{ route('products.show', $product) }}'">{{ $product->name }}</h2>
                    <p class="price">{{ number_format($product->price, 2) }} €</p>
                    @if($product->description)
                        <p>{{ $product->description }}</p>
                    @endif
                    <!-- Noliktavas statuss -->
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
                    <!-- Kartītes apakšējā daļa ar darbībām -->
                    <div class="product-bottom">
                        <!-- Pievienošana grozam vai pieteikšanās -->
                        <div class="card-actions">
                            @auth
                                <form method="POST" action="{{ route('cart.add', $product) }}">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn-add-cart">🛒 Pievienot grozam</button>
                                </form>
                            @else
                                <a class="btn-add-cart disabled" href="{{ route('login') }}">Ieiet, lai pievienotu grozā</a>
                            @endauth
                        </div>
                        <!-- Papildu informācija un saite uz detaļām -->
                        <div class="product-footer">
                            <span>{{ $inStock ? 'Pieejams tūlītējai izsniegšanai' : 'Drīzumā pieejams' }}</span>
                            <a href="{{ route('products.show', $product) }}">Detaļas →</a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    @else
        <!-- Tukšs stāvoklis, ja nav produktu -->
        <p>Šobrīd nav pieejamu produktu.</p>
    @endif
</main>

<!-- Kājenes informācija ar kontaktiem un ātrajām saitēm -->
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
<!-- Iekšējais CSS: novietots pēc HTML, lai atdalītu struktūru no noformējuma -->
<style>
        /* Globālā nullēšana un kastes modelis */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        /* Krāsu mainīgie un palete */
        :root {
            --accent: #ff5c35;
            --accent-dark: #d94516;
            --ink: #181818;
            --muted: #6f6f6f;
            --card: #ffffff;
            --border: #ededed;
        }
        /* Pamatteksts un fons */
        body { font-family: "Inter", Arial, sans-serif; background:#f7f7f7; color:var(--ink); line-height:1.6; }
        /* Galvene un kājene */
        header { background:white; border-bottom:1px solid var(--border); }
        footer { background:white; border-top:1px solid #e8e8e8; margin-top:4rem; }
        .footer-wrapper { max-width:1400px; margin:0 auto; padding:3rem 2rem; display:grid; grid-template-columns:repeat(auto-fit,minmax(220px,1fr)); gap:2rem; color:#555; }
        .footer-column h4 { font-size:1rem; text-transform:uppercase; letter-spacing:0.15rem; color:var(--ink); margin-bottom:1rem; }
        .footer-column ul { list-style:none; display:flex; flex-direction:column; gap:0.6rem; }
        .footer-column a { text-decoration:none; color:#666; }
        .footer-column a:hover { color:var(--ink); }
        .footer-bottom { text-align:center; padding:1.5rem; color:#777; font-size:0.9rem; border-top:1px solid #f0f0f0; }
        /* Navigācija */
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

        /* Galvenais saturs */
        main { max-width:1400px; margin:0 auto; padding:2.5rem 2rem 3rem; }
        h1 { font-size:2.4rem; margin-bottom:0.6rem; }
        .lead { color:var(--muted); margin-bottom:1rem; }
        .alert {
            padding:0.9rem 1.1rem;
            border-radius:12px;
            margin-bottom:1.5rem;
            font-weight:500;
        }
        .alert-success { background:#e6f5ef; color:#136b3a; border:1px solid #b7e2c9; }
        .alert-error { background:#fdecea; color:#b5302c; border:1px solid #f3c0b7; }
        /* Filtru josla meklēšanai un kārtošanai */
        .product-filters {
            display:flex;
            flex-wrap:wrap;
            gap:1rem;
            margin-bottom:2rem;
            background:white;
            padding:1rem 1.5rem;
            border:1px solid var(--border);
            border-radius:12px;
        }
        .product-filters label {
            display:block;
            font-weight:600;
            font-size:0.9rem;
            margin-bottom:0.3rem;
        }
        .product-filters input,
        .product-filters select {
            width:220px;
            padding:0.6rem 0.8rem;
            border:1px solid var(--border);
            border-radius:10px;
            font-size:0.95rem;
        }
        .product-filters input:focus,
        .product-filters select:focus {
            outline:none;
            border-color:var(--accent);
            box-shadow:0 0 0 3px rgba(255,92,53,0.15);
        }
        /* Produktu režģis */
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
        .product-bottom { margin-top:auto; display:flex; flex-direction:column; gap:0.8rem; }
        .card-actions { display:flex; flex-direction:column; gap:0.4rem; }
        .card-actions form { width:100%; }
        .btn-add-cart { width:100%; border:none; border-radius:10px; background:var(--ink); color:white; font-weight:600; padding:0.65rem 1rem; cursor:pointer; display:inline-flex; align-items:center; justify-content:center; gap:0.4rem; font-size:0.95rem; transition:background 0.2s; text-decoration:none; }
        .btn-add-cart:hover { background:#333; }
        .btn-add-cart.disabled { background:#f0f0f0; color:#888; cursor:not-allowed; }
        .product-footer { display:flex; justify-content:space-between; font-size:0.9rem; color:var(--muted); }
        .product-footer a { text-decoration:none; color:var(--accent); font-weight:600; }

        /* Responsivitāte mazākiem ekrāniem */
        @media (max-width:600px) {
            nav { flex-direction:column; gap:0.8rem; }
            .nav-links { flex-wrap:wrap; justify-content:center; }
            .product-filters { flex-direction:column; }
            .product-filters input,
            .product-filters select { width:100%; }
        }
    </style>
<script>
    // Meklēšanas un kārtošanas loģika produktu režģim.
    document.addEventListener('DOMContentLoaded', () => {
        // Formas elementi: meklēšanas lauks, kārtošanas izvēlne un režģis.
        const searchInput = document.getElementById('productSearch');
        const sortSelect = document.getElementById('productSort');
        const grid = document.getElementById('productsGrid');

        // Drošības pārbaude: ja nav būtisku elementu, JS loģika neturpinās.
        if (!grid || !searchInput || !sortSelect) {
            return;
        }

        // Saglabā visas kartītes un sākotnēji tās uzskata par redzamām.
        const allCards = Array.from(grid.querySelectorAll('.product-card'));
        let visibleCards = [...allCards];

        // Kārto redzamos produktus pēc nosaukuma vai cenas.
        const sortCards = () => {
            // Izvelk kritēriju un virzienu no izvēlētās vērtības (piem., name-asc).
            const [criterion, direction] = sortSelect.value.split('-');
            const sorted = [...visibleCards].sort((cardA, cardB) => {
                if (criterion === 'name') {
                    // Nosaukumu salīdzināšana alfabēta secībā.
                    const nameA = cardA.dataset.name || '';
                    const nameB = cardB.dataset.name || '';
                    return direction === 'asc'
                        ? nameA.localeCompare(nameB)
                        : nameB.localeCompare(nameA);
                }

                // Cenu salīdzināšana skaitliski.
                const priceA = parseFloat(cardA.dataset.price) || 0;
                const priceB = parseFloat(cardB.dataset.price) || 0;
                return direction === 'asc' ? priceA - priceB : priceB - priceA;
            });

            // Pārkārto DOM elementus pēc jaunās secības.
            sorted.forEach(card => grid.appendChild(card));
        };

        // Filtrē kartītes pēc meklēšanas teksta.
        const filterCards = () => {
            // Normalizē meklēšanas tekstu uz maziem burtiem.
            const query = searchInput.value.trim().toLowerCase();

            // Atlasām kartītes, kuru nosaukums satur meklējamo tekstu.
            visibleCards = allCards.filter(card => {
                const productName = card.dataset.name || '';
                return productName.includes(query);
            });

            // Paslēpj visas kartītes.
            allCards.forEach(card => {
                card.style.display = 'none';
            });

            // Parāda tikai atbilstošās kartītes.
            visibleCards.forEach(card => {
                card.style.display = 'flex';
            });

            // Pēc filtrēšanas pārsortē redzamās kartītes.
            sortCards();
        };

        // Meklēšana reaģē uz ievadi, kārtošana uz izvēles maiņu.
        searchInput.addEventListener('input', filterCards);
        sortSelect.addEventListener('change', sortCards);

        // Inicializē sākotnējo kartīšu stāvokli.
        allCards.forEach(card => card.style.display = 'flex');
        filterCards();
    });
</script>
</body>
</html>
