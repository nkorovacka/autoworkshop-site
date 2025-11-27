<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pakalpojumi - Auto Detailing Workshop</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; background:#f9f9f9; color:#161616; line-height:1.6; }
        header { background:white; border-bottom:1px solid #eaeaea; }
        nav { max-width:1200px; margin:0 auto; padding:1.2rem 1.5rem; display:flex; justify-content:space-between; align-items:center; }
        .logo { font-weight:600; letter-spacing:0.08rem; }
        .nav-links { list-style:none; display:flex; gap:1.5rem; }
        .nav-links a { text-decoration:none; color:#6b6b6b; font-weight:500; }
        .nav-links a.active, .nav-links a:hover { color:#161616; }

        .intro { max-width:1200px; margin:0 auto; padding:3rem 1.5rem; }
        .intro h1 { font-size:2.6rem; margin-bottom:0.6rem; }
        .intro p { color:#6b6b6b; max-width:720px; }

        .services { max-width:1200px; margin:0 auto; padding:0 1.5rem 3rem; display:grid; grid-template-columns:repeat(auto-fit,minmax(320px,1fr)); gap:1.5rem; }
        .service { background:white; border:1px solid #eaeaea; border-radius:18px; padding:2rem; display:flex; flex-direction:column; gap:0.8rem; }
        .service small { color:#6b6b6b; }
        .service ul { list-style:none; padding-left:0; color:#6b6b6b; }
        .service li::before { content:"•"; color:#ff5c35; margin-right:0.5rem; }
        .service button { margin-top:auto; padding:0.9rem; border-radius:10px; border:none; background:#161616; color:white; font-weight:600; cursor:pointer; }

        .packages { max-width:1200px; margin:0 auto; padding:0 1.5rem 3rem; }
        .package-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(260px,1fr)); gap:1.2rem; }
        .package { background:#161616; color:white; border-radius:20px; padding:2rem; }
        .package span { opacity:0.7; text-transform:uppercase; font-size:0.8rem; letter-spacing:0.18rem; }
        .package h3 { margin:0.6rem 0; }

        .cta { max-width:1200px; margin:0 auto 3rem; padding:2.5rem 1.5rem; border-radius:22px; background:#ff5c35; color:white; text-align:center; }
        .cta a { display:inline-block; margin-top:1rem; padding:0.9rem 1.6rem; border-radius:10px; background:white; color:#161616; text-decoration:none; font-weight:600; }

        footer { max-width:1200px; margin:0 auto; padding:2rem 1.5rem; text-align:center; color:#6b6b6b; }

        @media (max-width:768px) {
            .nav-links { display:none; }
            .intro h1 { font-size:2.1rem; }
        }
    </style>
</head>
<body>
<header>
    <nav>
        <div class="logo">Auto Detailing</div>
        <ul class="nav-links">
            <li><a href="/">Galvenā</a></li>
            <li><a href="/services" class="active">Pakalpojumi</a></li>
            <li><a href="/products">Produkti</a></li>
            <li><a href="/offers">Piedāvājumi</a></li>
        </ul>
    </nav>
</header>

<section class="intro">
    <h1>Pakalpojumu katalogs un cenas</h1>
    <p>Vienkārši apskati pakalpojumu aprakstus, iekļautos darbus un cenu sākot no. Katram pakalpojumam norādām paredzamo izpildes laiku un to, kas iekļauts komplektā.</p>
</section>

<section class="services">
    <article class="service">
        <h2>Ārējā mazgāšana</h2>
        <small>No €30 · 1 stunda</small>
        <p>Rūpīga virsbūves mazgāšana, disku un riepu kopšana, hidrofobs vasks.</p>
        <ul>
            <li>Divpakāpju mazgāšana</li>
            <li>Stiklu un spoguļu pulēšana</li>
            <li>Foto atskaite pēc darba</li>
        </ul>
        <button onclick="location.href='/booking'">Pieteikties</button>
    </article>
    <article class="service">
        <h2>Salona ķīmiskā tīrīšana</h2>
        <small>No €45 · 2 stundas</small>
        <p>Dziļa salona tīrīšana, antibakteriāla apstrāde, aromāta izvēle.</p>
        <ul>
            <li>Sēdekļu un grīdas tīrīšana</li>
            <li>Ādas kopšana pēc izvēles</li>
            <li>UV aizsardzība paneļiem</li>
        </ul>
        <button onclick="location.href='/booking'">Pieteikties</button>
    </article>
    <article class="service">
        <h2>Virsbūves pulēšana</h2>
        <small>No €80 · 3-4 stundas</small>
        <p>Profesionāla vairāku posmu pulēšana krāsas atjaunošanai.</p>
        <ul>
            <li>Krāsas biezuma mērījumi</li>
            <li>2-3 pakāpju pulēšana</li>
            <li>Keramiskā primēšana</li>
        </ul>
        <button onclick="location.href='/booking'">Pieteikties</button>
    </article>
    <article class="service">
        <h2>Keramiskā aizsardzība</h2>
        <small>No €150 · 6-8 stundas</small>
        <p>Premium nano keramika ar 24 mēnešu garantiju un kontrolēm.</p>
        <ul>
            <li>Sagatavošana un pulēšana</li>
            <li>2 slāņu pārklājums</li>
            <li>Pēcapkalpošanas instrukcijas</li>
        </ul>
        <button onclick="location.href='/booking'">Pieteikties</button>
    </article>
    <article class="service">
        <h2>Pilns detailing</h2>
        <small>No €120 · 5-6 stundas</small>
        <p>Ārējā kopšana, salona tīrīšana, disku un motora detaļu kopšana vienā vizītē.</p>
        <ul>
            <li>Visa ārējā kopšana</li>
            <li>Pilna salona tīrīšana</li>
            <li>Motora nodalījuma mazgāšana</li>
        </ul>
        <button onclick="location.href='/booking'">Pieteikties</button>
    </article>
    <article class="service">
        <h2>VIP programma</h2>
        <small>No €250 · 8-10 stundas</small>
        <p>Premium komplekts ar keramiku, lukturu pulēšanu un pēc-kopšanas box.</p>
        <ul>
            <li>Visa Pilnā programma + keramika</li>
            <li>Ādas kopšana un kondicionēšana</li>
            <li>Privāts konsultants</li>
        </ul>
        <button onclick="location.href='/booking'">Pieteikties</button>
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
    <a href="/booking">Rezervēt tiešsaistē</a>
</section>

<footer>
    <p>&copy; 2024 Auto Detailing Workshop. Visas tiesības aizsargātas.</p>
</footer>
</body>
</html>
