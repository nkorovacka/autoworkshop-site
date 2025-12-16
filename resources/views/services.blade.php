<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pakalpojumi - Auto Detailing Workshop</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --accent: #ff5c35;
            --accent-dark: #d94516;
            --accent-light: #fff3ec;
            --ink: #1a1a1a;
            --muted: #6c6c6c;
        }
        body { font-family: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; background:#fafafa; color:var(--ink); line-height:1.6; }

        header { background:white; border-bottom:1px solid #e8e8e8; position:sticky; top:0; z-index:100; }
        nav { max-width:1400px; margin:0 auto; padding:1.2rem 2rem; display:flex; justify-content:space-between; align-items:center; }
        .logo { font-size:1.3rem; font-weight:600; letter-spacing:-0.5px; }
        .nav-links { display:flex; list-style:none; gap:2.5rem; }
        .nav-links a { text-decoration:none; color:#666; font-size:0.95rem; font-weight:500; transition:color 0.2s; }
        .nav-links a.active, .nav-links a:hover { color:var(--ink); }
        .nav-right { display:flex; align-items:center; gap:1.5rem; }
        .icon-button { background:none; border:none; font-size:1.2rem; color:#666; cursor:pointer; }
        .auth-buttons { display:flex; gap:0.9rem; }
        .auth-buttons.signed-in { gap:0.6rem; align-items:center; }
        .btn-login, .btn-signup { padding:0.45rem 1.1rem; border-radius:8px; font-size:0.85rem; font-weight:500; cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; justify-content:center; }
        .btn-login { border:1px solid #e8e8e8; background:none; }
        .btn-login:hover { background:#f5f5f5; }
        .btn-signup { background:var(--ink); color:white; border:none; }
        .btn-profile { border:none; background:var(--ink); color:white; padding:0.45rem 1.1rem; border-radius:8px; font-size:0.85rem; font-weight:500; text-decoration:none; display:inline-flex; align-items:center; gap:0.4rem; }
        .btn-profile:hover { background:#333; }
        .btn-cart { border:1px solid #e8e8e8; background:white; color:var(--ink); text-decoration:none; padding:0.45rem 1.1rem; border-radius:8px; font-size:0.9rem; font-weight:500; display:inline-flex; align-items:center; gap:0.4rem; }
        .btn-cart:hover { background:#f5f5f5; }
        .user-greeting { font-size:0.9rem; font-weight:600; color:var(--ink); white-space:nowrap; }
        .logout-form { margin:0; }
        .btn-logout { padding:0.45rem 1rem; border-radius:8px; font-size:0.9rem; font-weight:500; border:none; background:#f1f1f1; color:var(--ink); cursor:pointer; transition:background 0.2s; }
        .btn-logout:hover { background:#dfdfdf; }

        .intro { max-width:1400px; margin:0 auto; padding:4rem 2rem 2.5rem; }
        .intro h1 { font-size:2.8rem; margin-bottom:0.8rem; }
        .intro p { color:var(--muted); max-width:760px; }

        .services-grid { max-width:1400px; margin:0 auto; padding:0 2rem 3rem; display:grid; grid-template-columns:repeat(auto-fit,minmax(320px,1fr)); gap:1.5rem; }
        .service-card { background:white; border:1px solid #f0f0f0; border-radius:18px; padding:2rem; display:flex; flex-direction:column; gap:0.8rem; box-shadow:0 10px 25px rgba(0,0,0,0.04); }
        .service-card h2 { font-size:1.4rem; }
        .service-card small { color:var(--muted); font-weight:500; }
        .service-card ul { list-style:none; color:var(--muted); padding-left:0; }
        .service-card li { padding-left:1rem; position:relative; }
        .service-card li::before { content:"•"; color:var(--accent); position:absolute; left:0; }
        .service-card button { margin-top:auto; padding:0.9rem; border-radius:10px; border:none; background:var(--accent); color:white; font-weight:600; cursor:pointer; transition:background 0.2s; }
        .service-card button:hover { background:var(--accent-dark); }

        .packages { max-width:1400px; margin:0 auto; padding:0 2rem 3rem; }
        .packages h2 { font-size:2.2rem; margin-bottom:0.4rem; }
        .packages p { color:var(--muted); margin-bottom:1.5rem; }
        .package-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(260px,1fr)); gap:1.2rem; }
        .package { border-radius:20px; padding:2rem; color:white; background:linear-gradient(135deg,var(--ink),#373737); box-shadow:0 20px 35px rgba(0,0,0,0.18); }
        .package span { text-transform:uppercase; letter-spacing:0.2rem; font-size:0.8rem; opacity:0.7; }
        .package h3 { font-size:2rem; margin:0.6rem 0; }
        .package:nth-child(2) { background:linear-gradient(135deg,var(--accent),var(--accent-dark)); }

        .cta { max-width:1400px; margin:0 auto 4rem; padding:3.5rem 2rem; border-radius:24px; background:linear-gradient(135deg,var(--accent),var(--accent-dark)); color:white; text-align:center; }
        .cta p { opacity:0.9; margin-top:0.5rem; }
        .cta a { display:inline-block; margin-top:1.2rem; padding:0.9rem 1.8rem; border-radius:12px; background:white; color:var(--ink); text-decoration:none; font-weight:600; }

        footer { max-width:1400px; margin:0 auto; padding:2.5rem 2rem; text-align:center; color:var(--muted); }

        @media (max-width:768px) {
            .nav-links, .nav-right { display:none; }
            .intro { padding:3rem 1.5rem 2rem; }
            .services-grid, .packages { padding:0 1.5rem 2.5rem; }
            .cta { padding:3rem 1.5rem; }
        }
    </style>
</head>
<body>
<header>
    <nav>
        <div class="logo">Auto Detailing</div>
        <ul class="nav-links">
            <li><a href="{{ route('home') }}">Galvenā</a></li>
            <li><a href="{{ route('services.index') }}" class="active">Pakalpojumi</a></li>
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

<section class="intro">
    <h1>Pakalpojumu katalogs un cenas</h1>
    <p>Vienkārši apskati pakalpojumu aprakstus, iekļautos darbus un cenu sākot no. Katram pakalpojumam norādām paredzamo izpildes laiku un to, kas iekļauts komplektā.</p>
</section>

<section class="services-grid">
    <article class="service-card">
        <h2>Ārējā mazgāšana</h2>
        <small>No €30 · 1 stunda</small>
        <p>Rūpīga virsbūves mazgāšana, disku un riepu kopšana, hidrofobs vasks.</p>
        <ul>
            <li>Divpakāpju mazgāšana</li>
            <li>Stiklu un spoguļu pulēšana</li>
            <li>Foto atskaite pēc darba</li>
        </ul>
        @auth
            <button onclick="location.href='{{ route('booking.create', ['service' => 'exterior']) }}'">Pieteikties</button>
        @else
            <button onclick="location.href='{{ route('login') }}'">Ieiet, lai pieteiktos</button>
        @endauth
    </article>
    <article class="service-card">
        <h2>Salona ķīmiskā tīrīšana</h2>
        <small>No €45 · 2 stundas</small>
        <p>Dziļa salona tīrīšana, antibakteriāla apstrāde, aromāta izvēle.</p>
        <ul>
            <li>Sēdekļu un grīdas tīrīšana</li>
            <li>Ādas kopšana pēc izvēles</li>
            <li>UV aizsardzība paneļiem</li>
        </ul>
        @auth
            <button onclick="location.href='{{ route('booking.create', ['service' => 'interior']) }}'">Pieteikties</button>
        @else
            <button onclick="location.href='{{ route('login') }}'">Ieiet, lai pieteiktos</button>
        @endauth
    </article>
    <article class="service-card">
        <h2>Virsbūves pulēšana</h2>
        <small>No €80 · 3-4 stundas</small>
        <p>Profesionāla vairāku posmu pulēšana krāsas atjaunošanai.</p>
        <ul>
            <li>Krāsas biezuma mērījumi</li>
            <li>2-3 pakāpju pulēšana</li>
            <li>Keramiskā primēšana</li>
        </ul>
        @auth
            <button onclick="location.href='{{ route('booking.create', ['service' => 'polish']) }}'">Pieteikties</button>
        @else
            <button onclick="location.href='{{ route('login') }}'">Ieiet, lai pieteiktos</button>
        @endauth
    </article>
    <article class="service-card">
        <h2>Keramiskā aizsardzība</h2>
        <small>No €150 · 6-8 stundas</small>
        <p>Premium nano keramika ar 24 mēnešu garantiju un kontrolēm.</p>
        <ul>
            <li>Sagatavošana un pulēšana</li>
            <li>2 slāņu pārklājums</li>
            <li>Pēcapkalpošanas instrukcijas</li>
        </ul>
        @auth
            <button onclick="location.href='{{ route('booking.create', ['service' => 'ceramic']) }}'">Pieteikties</button>
        @else
            <button onclick="location.href='{{ route('login') }}'">Ieiet, lai pieteiktos</button>
        @endauth
    </article>
    <article class="service-card">
        <h2>Pilns detailing</h2>
        <small>No €120 · 5-6 stundas</small>
        <p>Ārējā kopšana, salona tīrīšana, disku un motora detaļu kopšana vienā vizītē.</p>
        <ul>
            <li>Visa ārējā kopšana</li>
            <li>Pilna salona tīrīšana</li>
            <li>Motora nodalījuma mazgāšana</li>
        </ul>
        @auth
            <button onclick="location.href='{{ route('booking.create', ['service' => 'full']) }}'">Pieteikties</button>
        @else
            <button onclick="location.href='{{ route('login') }}'">Ieiet, lai pieteiktos</button>
        @endauth
    </article>
    <article class="service-card">
        <h2>VIP programma</h2>
        <small>No €250 · 8-10 stundas</small>
        <p>Premium komplekts ar keramiku, lukturu pulēšanu un pēc-kopšanas box.</p>
        <ul>
            <li>Visa Pilnā programma + keramika</li>
            <li>Ādas kopšana un kondicionēšana</li>
            <li>Privāts konsultants</li>
        </ul>
        @auth
            <button onclick="location.href='{{ route('booking.create', ['service' => 'vip']) }}'">Pieteikties</button>
        @else
            <button onclick="location.href='{{ route('login') }}'">Ieiet, lai pieteiktos</button>
        @endauth
    </article>
</section>

<section class="packages">
    <h2>Komplekti ar fiksētu cenu</h2>
    <p>Izvēlies gatavu komplektu un saņem prioritāru grafiku.</p>
    <div class="package-grid">
        <div class="package">
            <span>Neon Copper</span>
            <h3>€420</h3>
            <p>Polēšana + keramika ar vara akcentu. 24 mēn. garantija.</p>
        </div>
        <div class="package">
            <span>Midnight Interior</span>
            <h3>€210</h3>
            <p>Salona dziļā tīrīšana, ādas kopšana, UV aizsardzība.</p>
        </div>
        <div class="package">
            <span>Full Spectrum</span>
            <h3>€590</h3>
            <p>Pilns detailing ar keramiku, lukturu pulēšanu un pēc-kopšanas komplektu.</p>
        </div>
    </div>
</section>

<section class="cta">
    <h2>Kuru pakalpojumu izvēlies?</h2>
    <p>Aizpildi pieteikumu un saņem apstiprinājumu dažu minūšu laikā.</p>
    <a href="{{ route('booking.create') }}">Rezervēt tiešsaistē</a>
</section>

<footer>
    <p>&copy; 2024 Auto Detailing Workshop. Visas tiesības aizsargātas.</p>
</footer>
</body>
</html>
