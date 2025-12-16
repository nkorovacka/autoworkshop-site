<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mūsu darbi – Auto Detailing Workshop</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        :root {
            --accent:#ff5c35;
            --accent-dark:#d9461f;
            --accent-light:#fff1ec;
            --ink:#1a1a1a;
            --muted:#6c6c6c;
        }
        body { font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif; background:#fafafa; color:var(--ink); line-height:1.6; }
        header { background:white; border-bottom:1px solid #e8e8e8; position:sticky; top:0; z-index:100; }
        nav { max-width:1400px; margin:0 auto; padding:1.2rem 2rem; display:flex; justify-content:space-between; align-items:center; }
        .logo { font-size:1.3rem; font-weight:600; letter-spacing:-0.5px; }
        .nav-links { display:flex; list-style:none; gap:2.5rem; }
        .nav-links a { text-decoration:none; color:#666; font-weight:500; }
        .nav-links a.active, .nav-links a:hover { color:var(--ink); }
        .nav-right { display:flex; align-items:center; gap:1.2rem; }
        .icon-button { background:none; border:none; font-size:1.2rem; color:#666; cursor:pointer; }
        .auth-buttons { display:flex; gap:0.9rem; }
        .auth-buttons.signed-in { gap:0.6rem; align-items:center; }
        .btn-login, .btn-signup, .btn-profile, .btn-cart, .btn-logout {
            border-radius:8px; font-size:0.85rem; font-weight:500; text-decoration:none;
            display:inline-flex; align-items:center; justify-content:center; padding:0.45rem 1.1rem;
        }
        .btn-login { border:1px solid #e8e8e8; background:white; color:var(--ink); }
        .btn-login:hover { background:#f5f5f5; }
        .btn-signup { border:none; background:var(--ink); color:white; }
        .btn-signup:hover { background:#333; }
        .btn-profile { border:none; background:var(--ink); color:white; gap:0.3rem; }
        .btn-profile:hover { background:#333; }
        .btn-cart { border:1px solid #e8e8e8; background:white; color:var(--ink); gap:0.3rem; }
        .btn-cart:hover { background:#f5f5f5; }
        .btn-logout { border:none; background:#f1f1f1; color:var(--ink); gap:0.3rem; }
        .btn-logout:hover { background:#dedede; }
        .user-greeting { font-size:0.85rem; font-weight:600; color:var(--ink); white-space:nowrap; }
        main { max-width:1400px; margin:0 auto; padding:4rem 2rem 3rem; }
        .hero { text-align:center; margin-bottom:3rem; }
        .hero h1 { font-size:2.8rem; margin-bottom:0.5rem; }
        .hero p { color:var(--muted); max-width:700px; margin:0 auto; }
        .grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(280px,1fr)); gap:1.5rem; }
        .work-card { background:white; border:1px solid #f0f0f0; border-radius:20px; padding:1.5rem; box-shadow:0 15px 35px rgba(0,0,0,0.06); display:flex; flex-direction:column; gap:1rem; }
        .card-title { font-size:1.2rem; }
        .slider { position:relative; border-radius:16px; overflow:hidden; border:1px solid #ededed; background:#f7f7f7; height:220px; display:flex; align-items:center; justify-content:center; }
        .slider img { width:100%; height:100%; object-fit:cover; display:block; }
        .slider button { position:absolute; top:50%; transform:translateY(-50%); background:rgba(0,0,0,0.55); color:white; border:none; width:36px; height:36px; border-radius:50%; cursor:pointer; }
        .slider button:hover { background:rgba(0,0,0,0.75); }
        .slider button.prev { left:10px; }
        .slider button.next { right:10px; }
        .tag { font-size:0.8rem; text-transform:uppercase; letter-spacing:0.15rem; color:#ff814f; }
        .placeholder-note { font-size:0.85rem; color:#888; }
        .faq { margin-top:4rem; background:white; border-radius:24px; border:1px solid #e8e8e8; padding:3rem; }
        .faq h2 { text-align:center; margin-bottom:1.5rem; font-size:2rem; }
        details { border:1px solid #f0f0f0; border-radius:14px; padding:1rem 1.2rem; margin-bottom:1rem; background:#fff; }
        summary { cursor:pointer; font-weight:600; }
        summary::marker { color:var(--accent); }
        details p { margin-top:0.6rem; color:#555; }
        footer { text-align:center; padding:3rem 2rem; color:#666; }
        @media(max-width:640px){ nav { flex-direction:column; gap:0.8rem; } .nav-links { flex-wrap:wrap; justify-content:center; } }
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
            <li><a href="{{ route('our-work') }}" class="active">Darbi</a></li>
        </ul>
        <div class="nav-right">
            @auth
                <div class="user-greeting">Sveiki, {{ auth()->user()->name }}</div>
                <div class="auth-buttons signed-in">
                    <a class="btn-cart" href="#">🛒 Grozs</a>
                    <a class="btn-profile" href="{{ route('profile') }}">👤 Profils</a>
                    <form method="POST" action="{{ route('logout') }}">
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
    <div class="hero">
        <h1>Pirms un Pēc projekti</h1>
        <p>Ievieto savas „pirms / pēc” fotogrāfijas mapē <strong>public/images/our-work</strong> ar nosaukumiem, kas atbilst zemāk redzamajiem failiem.</p>
        <p class="placeholder-note">Piemēram: <code>before1.jpg</code>, <code>after1.jpg</code>, ... , <code>before6.jpg</code>.</p>
    </div>

    @php
        $projects = [
            ['title' => 'Pilns detailing – BMW 5. sērija', 'tag' => 'Exterior', 'before' => 'before1.jpg', 'after' => 'after1.jpg', 'text' => 'Spīduma atjaunošana un keramiskais pārklājums.'],
            ['title' => 'Salona dziļā tīrīšana – VW Golf', 'tag' => 'Interior', 'before' => 'before2.jpg', 'after' => 'after2.jpg', 'text' => 'Traipu noņemšana un antibakteriālā apstrāde.'],
            ['title' => 'Keramiskā aizsardzība – Audi A6', 'tag' => 'Coating', 'before' => 'before3.jpg', 'after' => 'after3.jpg', 'text' => 'Matēta virsbūve kļūst spīdīga un hidrofoba.'],
            ['title' => 'Motora nodalījuma kopšana – Mini Cooper', 'tag' => 'Engine bay', 'before' => 'before4.jpg', 'after' => 'after4.jpg', 'text' => 'Motora telpa notīrīta un konservēta.'],
            ['title' => 'Salona ādas atjaunošana – Volvo XC60', 'tag' => 'Leather care', 'before' => 'before5.jpg', 'after' => 'after5.jpg', 'text' => 'Ādas sēdekļi atjauno krāsu un elastību.'],
            ['title' => 'Disku atjaunošana – Porsche Cayenne', 'tag' => 'Wheels', 'before' => 'before6.jpg', 'after' => 'after6.jpg', 'text' => 'Disku tīrīšana, pulēšana un aizsargvasks.'],
        ];
    @endphp

    <section class="grid">
        @foreach($projects as $index => $project)
            <article class="work-card" data-slider-index="{{ $index }}">
                <span class="tag">{{ $project['tag'] }}</span>
                <h3 class="card-title">{{ $project['title'] }}</h3>
                <p>{{ $project['text'] }}</p>
                <div class="slider"
                     data-images='@json([
                        asset("images/our-work/{$project['before']}"),
                        asset("images/our-work/{$project['after']}")
                     ])'>
                    <img src="{{ asset("images/our-work/{$project['before']}") }}" alt="{{ $project['title'] }} foto">
                    <button class="prev" type="button" aria-label="Iepriekšējais">&lt;</button>
                    <button class="next" type="button" aria-label="Nākamais">&gt;</button>
                </div>
                <p class="placeholder-note">* Aizvieto attēlus mapē <code>public/images/our-work/{{ $project['before'] }} / {{ $project['after'] }}</code></p>
            </article>
        @endforeach
    </section>

    <section class="faq">
        <h2>Biežāk uzdotie jautājumi</h2>
        <details open>
            <summary>Vai varu atstāt auto uz visu dienu?</summary>
            <p>Jā, garākos detailing darbus veicam 6–8h laikā, un auto var atstāt pie mums visu dienu.</p>
        </details>
        <details>
            <summary>Cik ilgi saglabājas keramiskā aizsardzība?</summary>
            <p>Vidēji 24 mēnešus, ja auto tiek regulāri kopts un mazgāts ar atbilstošiem līdzekļiem.</p>
        </details>
        <details>
            <summary>Vai piedāvājat izbraukuma servisu?</summary>
            <p>Jā, noteiktos pakalpojumos nodrošinām izbraukumu pie klienta Rīgas robežās.</p>
        </details>
        <details>
            <summary>Kā sagatavoties salona tīrīšanai?</summary>
            <p>Izņem personīgās mantas un trauslus priekšmetus. Mēs visu pārējo paveiksim.</p>
        </details>
    </section>
</main>

<footer>
    <p>&copy; {{ date('Y') }} Auto Detailing Workshop</p>
</footer>

<script>
    document.querySelectorAll('.slider').forEach(slider => {
        const images = JSON.parse(slider.dataset.images);
        let current = 0;
        const img = slider.querySelector('img');

        function render() {
            img.src = images[current];
        }

        slider.querySelector('.prev').addEventListener('click', () => {
            current = (current - 1 + images.length) % images.length;
            render();
        });

        slider.querySelector('.next').addEventListener('click', () => {
            current = (current + 1) % images.length;
            render();
        });
    });
</script>
</body>
</html>
