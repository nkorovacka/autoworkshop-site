<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <title>Admin panelis</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<!-- Admina galvene ar lietotāja vārdu un navigāciju pa sadaļām -->
<header>
    <div class="admin-top">
        <div>
            <strong>Admin panelis</strong>
            <div style="color:#9ca3af; font-size:0.9rem;">Sveiki, {{ auth()->user()->name }}</div>
        </div>
        <div>
            <a href="{{ route('home') }}" style="color:#9ca3af;">← Publiskā lapa</a>
        </div>
    </div>
    <nav class="admin-nav">
        <a href="{{ route('admin.bookings') }}" class="{{ request()->routeIs('admin.bookings') ? 'active' : '' }}">Pakalpojumi</a>
        <a href="{{ route('admin.products') }}" class="{{ request()->routeIs('admin.products*') ? 'active' : '' }}">Produkti & pasūtījumi</a>
        <a href="{{ route('admin.offers') }}" class="{{ request()->routeIs('admin.offers*') ? 'active' : '' }}">Piedāvājumi</a>
        <a href="{{ route('admin.work-items') }}" class="{{ request()->routeIs('admin.work-items*') ? 'active' : '' }}">Darbi</a>
        <a href="{{ route('admin.overview') }}" class="{{ request()->routeIs('admin.overview') ? 'active' : '' }}">Kopsavilkums</a>
    </nav>
</header>

<main>
    <!-- Informatīvs panelis ar ātrajiem norādījumiem -->
    <div class="panel">
        <!-- Virsraksts par pieteikumu sadaļu -->
        <h2>Pakalpojumu pieteikumi</h2>
        <!-- Īss skaidrojums, kur atrast pieteikumu pārvaldību -->
        <p style="color:#6b7280;">Lai pārvaldītu booking pieteikumus, dodies uz administrācijas sadaļu.</p>
        <p>
            <!-- Ātrā saite uz pieteikumu sarakstu -->
            <a href="{{ route('admin.bookings') }}" style="color:#2563eb; font-weight:600;">→ Atvērt pakalpojumu pieteikumu sarakstu</a>
        </p>
        <!-- Atgādinājums par publisko lapu -->
        <p>Lai apskatītu publisko lapu, izmanto saiti augšējā joslā.</p>
    </div>
</main>

<!-- Iekšējie stili: novietoti pēc HTML, lai skaidri atdalītu struktūru no noformējuma -->
<style>
    /* Pamatfonu, tipogrāfiju un krāsu definīcija visai lapai */
    body { font-family: 'Inter', sans-serif; background:#f3f4f6; color:#111827; margin:0; }

    /* Galvenes josla ar tumšu fonu un baltu tekstu */
    header { background:#111827; color:white; padding:1.2rem 2rem; }

    /* Galvenes izkārtojums: lietotāja info un saite uz publisko lapu */
    .admin-top { display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:0.8rem; }

    /* Navigācijas saites uz admin sadaļām */
    .admin-nav { display:flex; gap:0.8rem; flex-wrap:wrap; margin-top:0.9rem; }
    .admin-nav a { color:#9ca3af; text-decoration:none; padding:0.35rem 0.9rem; border:1px solid transparent; border-radius:999px; }
    .admin-nav a.active { border-color:#f59e0b; color:#fde68a; }
    .admin-nav a:hover { color:white; border-color:#4b5563; }

    /* Galvenais satura bloks ar maksimālo platumu un atstarpēm */
    main { max-width:1200px; margin:2rem auto; padding:0 2rem; display:flex; flex-direction:column; gap:2rem; }

    /* Kartīšu režģis (ja nākotnē pievienos statistikas blokus) */
    .cards { display:grid; grid-template-columns:repeat(auto-fit,minmax(220px,1fr)); gap:1rem; }
    .card { background:white; border-radius:16px; padding:1.3rem; border:1px solid #e5e7eb; }
    .card h3 { margin:0 0 0.4rem; font-size:1rem; color:#6b7280; }
    .card strong { font-size:1.8rem; }

    /* Informatīvais panelis ar rāmīti un noapaļojumiem */
    .panel { background:white; border-radius:20px; border:1px solid #e5e7eb; padding:1.5rem; }

    /* Tabulu stili (ja šajā skatā nākotnē pievieno tabulu) */
    table { width:100%; border-collapse:collapse; }
    th, td { text-align:left; padding:0.75rem 0; border-bottom:1px solid #f3f4f6; font-size:0.95rem; }
    th { color:#6b7280; font-weight:600; }
</style>
</body>
</html>
