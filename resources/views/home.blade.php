<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auto Detailing Workshop - Premium Auto Kopšana</title>
    
</head>
<body>
    <!-- Galvenā navigācija ar logo, saišu izvēlni un lietotāja stāvokli -->
    <header>
        <nav>
            <div class="logo">Auto Detailing</div>
            <ul class="nav-links">
                <li><a href="{{ route('home') }}" class="active">Galvenā</a></li>
                <li><a href="{{ route('services.index') }}">Pakalpojumi</a></li>
                <li><a href="{{ route('products.index') }}">Produkti</a></li>
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

    <!-- Hero sadaļa ar galveno vēstījumu un CTA pogām -->
    <div class="hero-section">
        <div class="hero-layout">
            <div class="hero-content">
                <div class="hero-pill">Signature Detailing Line</div>
                <h1>Atdzīvini sava auto izskatu ar profesionālu kopšanu</h1>
                <p>Mēs piedāvājam pilnu auto detaļu kopšanas spektru — no rūpīgas mazgāšanas līdz keramiskajai aizsardzībai. Viss, lai Tavs auto izskatītos un justos nevainojami katru dienu.</p>
                <div class="hero-buttons">
                    <a href="/booking" class="btn-primary">Rezervēt vizīti</a>
                    <a href="/services" class="btn-secondary">Apskatīt pakalpojumus</a>
                </div>
                <div class="hero-stats">
                    <div class="stat-card">
                        <span class="stat-value">1 200+</span>
                        <span class="stat-label">Apkalpoti auto</span>
                    </div>
                    <div class="stat-card">
                        <span class="stat-value">4.9/5</span>
                        <span class="stat-label">Klientu vērtējums</span>
                    </div>
                    <div class="stat-card">
                        <span class="stat-value">10+</span>
                        <span class="stat-label">Gadu pieredze</span>
                    </div>
                </div>
            </div>
            <div class="hero-visual">
                <span class="accent-label">Chromatic finish</span>
            </div>
        </div>
    </div>
    <!-- Zīmola "signature" sadaļa ar materiālu un ieguvumu uzskaitījumu -->
    <div class="signature-section">
        <div class="signature-grid">
            <div class="signature-copy">
                <div class="signature-label">Signature gradient</div>
                <h2>Mūsu raksturīgā vara-oranžā palete</h2>
                <p>Auto kopšanas procesā apvienojam kontrastus: dziļu melnu spīdumu, drosmīgas vara otrās kārtas akcentus un krēmīgu pārklājumu, kas saudzē krāsu.</p>
                <div class="signature-benefits">
                    <div class="signature-benefit">
                        <span class="benefit-dot"></span>
                        <div>3 posmu keramiskais pārklājums</div>
                    </div>
                    <div class="signature-benefit">
                        <span class="benefit-dot"></span>
                        <div>Tonēta slāņa pašdziedēšanās</div>
                    </div>
                    <div class="signature-benefit">
                        <span class="benefit-dot"></span>
                        <div>Roku darbs ar personalizētu finish</div>
                    </div>
                </div>
            </div>
            <div class="signature-panel">
                <h3>Color Lab</h3>
                <p>Katrai vizītei izveidojam unikālu akcentu komplektu, kas pieskaņots virsbūves tonim un klienta vēlmēm.</p>
                <div class="palette">
                    <span class="tone-dark"></span>
                    <span class="tone-accent"></span>
                    <span class="tone-soft"></span>
                </div>
                <div class="signature-stats">
                    <div class="sig-stat">
                        <div class="sig-value">92%</div>
                        <div class="sig-label">Hidrofobija</div>
                    </div>
                    <div class="sig-stat">
                        <div class="sig-value">+30%</div>
                        <div class="sig-label">Spīduma dziļums</div>
                    </div>
                    <div class="sig-stat">
                        <div class="sig-value">24m</div>
                        <div class="sig-label">Aizsardzība</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Galveno priekšrocību izcēluma bloks -->
    <div class="highlight-section">
        <h2 class="section-title">Kāpēc izvēlēties mūs</h2>
        <p class="section-subtitle">Modernas tehnoloģijas, premium produkti un meistari ar pieredzi</p>
        <div class="highlight-grid">
            <div class="highlight-card">
                <div class="highlight-icon">🧼</div>
                <h3>Premium produkti</h3>
                <p>Strādājam ar Gtechniq, Koch Chemie un citiem vadošajiem zīmoliem, lai garantētu izcilu rezultātu.</p>
            </div>
            <div class="highlight-card">
                <div class="highlight-icon">🛡️</div>
                <h3>Garantēta kvalitāte</h3>
                <p>Katram pakalpojumam nodrošinām kvalitātes kontroli un 100% apmierinātības garantiju.</p>
            </div>
            <div class="highlight-card">
                <div class="highlight-icon">⚡</div>
                <h3>Ātrs serviss</h3>
                <p>Piesakies online un saņem apstiprinājumu dažu minūšu laikā. Elastīgi grafiki darba dienās un brīvdienās.</p>
            </div>
            <div class="highlight-card">
                <div class="highlight-icon">📍</div>
                <h3>Ērta atrašanās vieta</h3>
                <p>Serviss Rīgas centrā ar bezmaksas stāvvietu un gaidīšanas zonu ar WiFi un kafiju.</p>
            </div>
        </div>
    </div>

    <!-- Populārāko pakalpojumu priekšskatījums -->
    <div class="services-preview">
        <h2 class="section-title">Populārākie pakalpojumi</h2>
        <p class="section-subtitle">Izvēlies sev piemērotāko pakalpojumu komplektu</p>
        <div class="services-grid">
            <div class="service-card">
                <div class="service-icon">🚿</div>
                <h3>Ārējā mazgāšana</h3>
                <p class="service-description">Divpakāpju mazgāšanas process, kas saudzīgi attīra virsbūvi, diskus un detaļas.</p>
                <a class="service-link" href="/services">Skatīt detaļas →</a>
            </div>
            <div class="service-card">
                <div class="service-icon">🪑</div>
                <h3>Salona dziļā tīrīšana</h3>
                <p class="service-description">Ķīmiskā tīrīšana, sēdekļu kopšana un antibakteriāla apstrāde svaigam salonam.</p>
                <a class="service-link" href="/services">Skatīt detaļas →</a>
            </div>
            <div class="service-card">
                <div class="service-icon">💎</div>
                <h3>Keramiskā aizsardzība</h3>
                <p class="service-description">Ilgstošs pārklājums ar hidrofobo efektu un aizsardzību pret UV un ķīmiju.</p>
                <a class="service-link" href="/services">Skatīt detaļas →</a>
            </div>
        </div>
    </div>


    <!-- Aktuālo piedāvājumu sadaļa -->
    <div class="offers-section">
        <h2 class="section-title">Aktuālie piedāvājumi</h2>
        <p class="section-subtitle">Izmanto sezonālās akcijas un komplektu cenas</p>
        <div class="offers-grid">
            <div class="offer-card">
                <span class="offer-tag">-20% / pavasaris</span>
                <h3>Pilns detailing komplekts</h3>
                <p>Piesakies pilnajam pakalpojumu komplektam un saņem 20% atlaidi darba laikam.</p>
                <a class="offer-button" href="/offers">Uzzināt vairāk</a>
            </div>
            <div class="offer-card">
                <span class="offer-tag">Brīvdienu bonuss</span>
                <h3>Bezmaksas salona aromāts</h3>
                <p>Vizītēm sestdienās un svētdienās pievienojam premium aromātu komplektu bez maksas.</p>
                <a class="offer-button" href="/offers">Apskatīt akcijas</a>
            </div>
            <div class="offer-card">
                <span class="offer-tag">Jauns klientiem</span>
                <h3>50% atlaide pulēšanai</h3>
                <p>Pirmreizējiem klientiem piedāvājam pusi cenas virsbūves pulēšanas pakalpojumiem.</p>
                <a class="offer-button" href="/booking">Pieteikties</a>
            </div>
        </div>
    </div>

    <!-- Processa skaidrojums soli pa solim -->
    <div class="process-section">
        <h2 class="section-title">Kā viss notiek</h2>
        <p class="section-subtitle">Vienkāršs process ērtai pieredzei</p>
        <div class="process-grid">
            <div class="process-step">
                <div class="step-number">1</div>
                <h4>Izvēlies pakalpojumu</h4>
                <p>Izpēti pakalpojumus un rezervē sev ērtāko komplektu.</p>
            </div>
            <div class="process-step">
                <div class="step-number">2</div>
                <h4>Piesakies tiešsaistē</h4>
                <p>Aizpildi pieteikumu, izvēlies laiku un saņem apstiprinājumu e-pastā.</p>
            </div>
            <div class="process-step">
                <div class="step-number">3</div>
                <h4>Atved auto</h4>
                <p>Atved auto izvēlētajā laikā vai izmanto mūsu izbraukuma pakalpojumu.</p>
            </div>
            <div class="process-step">
                <div class="step-number">4</div>
                <h4>Saņem rezultātu</h4>
                <p>Mēs informēsim, kad darbs pabeigts. Pārbaudi auto un izbaudi jauno izskatu.</p>
            </div>
        </div>
    </div>

    <!-- Noslēdzošais aicinājums rezervēt vizīti -->
    <div class="cta-section">
        <h2>Vai Tavs auto gatavs atjaunot izskatu?</h2>
        <p>Rezervē vizīti tiešsaistē un saņem personalizētu piedāvājumu ar precīzu cenu.</p>
        <a href="/booking" class="btn-cta">Rezervēt vizīti →</a>
    </div>

    <!-- Darbu galerija, ja ir pieejami darbi -->
    @if($workItems->count())
    <section class="work-section">
        <div class="work-header">
            <span class="work-pill">Mūsu darbi</span>
            <h2>Pirms un pēc projekti</h2>
            <p>Daži no jaunākajiem projektiem, kurus mūsu komanda paveica klientiem.</p>
        </div>
        <div class="work-grid">
            @foreach($workItems as $index => $item)
                <article class="work-card" data-slider-index="{{ $index }}">
                    @if($item->tag)
                        <span class="tag">{{ $item->tag }}</span>
                    @endif
                    <h3 class="card-title">{{ $item->title }}</h3>
                    @if($item->description)
                        <p>{{ $item->description }}</p>
                    @endif
                    <div class="work-slider"
                         data-images='@json([
                            $item->before_image ? asset("storage/".$item->before_image) : asset("images/our-work/placeholder-before.jpg"),
                            $item->after_image ? asset("storage/".$item->after_image) : asset("images/our-work/placeholder-after.jpg")
                         ])'>
                        <img src="{{ $item->before_image ? asset("storage/".$item->before_image) : asset("images/our-work/placeholder-before.jpg") }}" alt="{{ $item->title }} foto">
                        <button class="prev" type="button" aria-label="Iepriekšējais">&lt;</button>
                        <button class="next" type="button" aria-label="Nākamais">&gt;</button>
                    </div>
                </article>
            @endforeach
        </div>
    </section>
    @endif

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
                    <li><a href="#" target="_blank">Instagram</a></li>
                    <li><a href="#" target="_blank">Facebook</a></li>
                    <li><a href="#" target="_blank">YouTube</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            &copy; {{ date('Y') }} Auto Detailing Workshop. Visas tiesības aizsargātas.
        </div>
    </footer>

    <script>
        document.querySelectorAll('.work-slider').forEach(slider => {
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
<style>
        /* Globālā nullēšana un kastes modelis vienmērīgai izkārtošanai */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Krāsu mainīgie un toņu palete visai lapai */
        :root {
            --accent: #ff5c35;
            --accent-dark: #d9461f;
            --accent-light: #fff1ec;
            --ink: #1a1a1a;
        }

        /* Pamatteksts, fons un kopējā tipogrāfija */
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: var(--ink);
            background: #fafafa;
        }

        /* Galvenes fiksācija un navigācijas izkārtojums */
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

        .btn-login {
            padding: 0.5rem 1.2rem;
            background: none;
            border: 1px solid #e8e8e8;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--ink);
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-login:hover {
            background: #f5f5f5;
        }

        .btn-signup {
            padding: 0.5rem 1.2rem;
            background: var(--ink);
            border: none;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 500;
            color: white;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
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

        .auth-buttons.signed-in {
            align-items: center;
        }

        .logout-form {
            margin: 0;
        }

        .btn-logout {
            padding: 0.45rem 1rem;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 500;
            border: none;
            background: #f1f1f1;
            color: var(--ink);
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-logout:hover {
            background: #dfdfdf;
        }

        /* Hero sadaļas izkārtojums un galvenie CTA stili */
        .hero-section {
            max-width: 1400px;
            margin: 0 auto;
            padding: 5rem 2rem 3rem;
        }

        .hero-layout {
            background: linear-gradient(120deg, white 35%, var(--accent-light));
            border-radius: 28px;
            padding: 3.5rem;
            border: 1px solid #f7d7c7;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 3rem;
            position: relative;
            overflow: hidden;
        }

        .hero-layout:after {
            content: "";
            position: absolute;
            width: 220px;
            height: 220px;
            background: radial-gradient(circle, rgba(255,92,53,0.25), transparent 70%);
            top: -40px;
            right: -40px;
            filter: blur(2px);
        }

        .hero-content {
            max-width: 650px;
            position: relative;
        }

        .hero-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.85rem;
            letter-spacing: 0.2rem;
            text-transform: uppercase;
            color: var(--accent-dark);
            background: rgba(255, 92, 53, 0.12);
            padding: 0.5rem 1.3rem;
            border-radius: 999px;
            margin-bottom: 1rem;
        }

        .hero-pill::before {
            content: "";
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--accent);
        }

        .hero-content h1 {
            font-size: 3.5rem;
            font-weight: 700;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            letter-spacing: -2px;
        }

        .hero-content p {
            font-size: 1.2rem;
            color: #555;
            margin-bottom: 2rem;
            line-height: 1.7;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .btn-primary,
        .btn-secondary,
        .btn-cta {
            padding: 1rem 2rem;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background: var(--accent);
            color: white;
            border: none;
            box-shadow: 0 15px 30px rgba(255,92,53,0.25);
        }

        .btn-primary:hover {
            background: var(--accent-dark);
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: white;
            border: 1px solid #e8e8e8;
            color: var(--ink);
        }

        .btn-secondary:hover {
            background: #f5f5f5;
        }

        .hero-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1.5rem;
            margin-top: 3rem;
        }

        .stat-card {
            background: white;
            border-radius: 18px;
            padding: 1.5rem;
            border: 1px solid #f0f0f0;
            position: relative;
        }

        .stat-card::before {
            content: "";
            position: absolute;
            top: 1rem;
            left: 1.5rem;
            width: 20px;
            height: 4px;
            border-radius: 999px;
            background: var(--accent);
        }

        .stat-value {
            display: block;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.3rem;
        }

        .stat-label {
            color: #666;
        }

        .hero-visual {
            position: relative;
        }

        .hero-accent-card {
            background: var(--ink);
            color: white;
            border-radius: 24px;
            padding: 2.5rem;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            position: relative;
            overflow: hidden;
        }

        .hero-accent-card::after {
            content: "";
            position: absolute;
            width: 220px;
            height: 220px;
            background: rgba(255,255,255,0.08);
            border-radius: 50%;
            bottom: -120px;
            right: -60px;
        }

        .accent-label {
            text-transform: uppercase;
            letter-spacing: 0.3rem;
            font-size: 0.75rem;
            color: rgba(255,255,255,0.7);
        }

        .accent-title {
            font-size: 1.9rem;
            margin: 1rem 0;
        }

        .accent-meter {
            margin-top: 2rem;
            height: 8px;
            border-radius: 999px;
            background: rgba(255,255,255,0.15);
            overflow: hidden;
        }

        .accent-meter-fill {
            width: 85%;
            height: 100%;
            background: linear-gradient(90deg, #ffe0d4, var(--accent));
            border-radius: inherit;
        }

        .color-stripes {
            display: flex;
            gap: 0.8rem;
            margin-top: 1.5rem;
        }

        .color-stripe {
            flex: 1;
            height: 6px;
            border-radius: 999px;
            opacity: 0.9;
        }

        .stripe-one {
            background: linear-gradient(90deg, var(--ink), #343434);
        }

        .stripe-two {
            background: linear-gradient(90deg, var(--accent-dark), var(--accent));
        }

        .stripe-three {
            background: linear-gradient(90deg, #ffd4c4, #fff5ef);
        }

        /* "Signature" sadaļas vizuālie akcenti un palete */
        .signature-section {
            max-width: 1400px;
            margin: 0 auto;
            padding: 3rem 2rem 4rem;
        }

        .signature-grid {
            background: white;
            border: 1px solid #f0e0d9;
            border-radius: 28px;
            padding: 3rem;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 3rem;
            position: relative;
            overflow: hidden;
        }

        .signature-grid::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(120deg, rgba(255,92,53,0.08), transparent 60%);
            pointer-events: none;
        }

        .signature-copy {
            position: relative;
            z-index: 2;
        }

        .signature-label {
            font-size: 0.85rem;
            letter-spacing: 0.2rem;
            text-transform: uppercase;
            color: #b34b2f;
        }

        .signature-copy h2 {
            font-size: 2.4rem;
            margin: 0.8rem 0 1rem;
            letter-spacing: -1px;
        }

        .signature-copy p {
            color: #555;
            margin-bottom: 1rem;
        }

        .signature-benefits {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .signature-benefit {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            background: #fff9f6;
            border: 1px solid #ffe1d6;
            border-radius: 14px;
            padding: 0.8rem 1rem;
        }

        .benefit-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--accent);
        }

        .signature-panel {
            background: var(--ink);
            border-radius: 24px;
            padding: 2.5rem;
            color: white;
            position: relative;
            overflow: hidden;
            z񎎠
            z-index: 1;
        }

        .signature-panel::before {
            content: "";
            position: absolute;
            width: 260px;
            height: 260px;
            background: radial-gradient(circle, rgba(255,255,255,0.1), transparent 70%);
            top: -80px;
            right: -30px;
        }

        .signature-panel h3 {
            font-size: 1.6rem;
            margin-bottom: 1rem;
        }

        .signature-stats {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .sig-stat {
            flex: 1;
            min-width: 120px;
        }

        .sig-value {
            font-size: 2rem;
            font-weight: 700;
        }

        .sig-label {
            color: rgba(255,255,255,0.7);
        }

        .palette {
            display: flex;
            gap: 0.7rem;
            margin-top: 1.5rem;
        }

        .palette span {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            border: 1px solid rgba(255,255,255,0.2);
        }

        .palette .tone-dark {
            background: #1a1a1a;
        }

        .palette .tone-accent {
            background: var(--accent);
        }

        .palette .tone-soft {
            background: var(--accent-light);
        }

        /* Priekšrocību kartīšu izkārtojums un krāsu kontrasti */
        .highlight-section {
            max-width: 1400px;
            margin: 0 auto;
            padding: 4rem 2rem;
        }

        .section-title {
            text-align: center;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            letter-spacing: -1px;
        }

        .section-subtitle {
            text-align: center;
            color: #666;
            font-size: 1.1rem;
            margin-bottom: 3rem;
        }

        .highlight-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 1.5rem;
        }

        .highlight-card {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            border: 1px solid #e8e8e8;
        }

        .highlight-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            background: var(--accent-light);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .highlight-card h3 {
            font-size: 1.3rem;
            margin-bottom: 0.5rem;
        }

        .highlight-card p {
            color: #666;
        }

        /* Populārāko pakalpojumu priekšskatījuma režģis */
        .services-preview {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem 4rem;
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 2rem;
        }

        .service-card {
            background: white;
            border-radius: 16px;
            padding: 2.5rem;
            border: 1px solid #e8e8e8;
            transition: all 0.3s;
        }

        .service-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
        }

        .service-icon {
            width: 60px;
            height: 60px;
            background: var(--accent-light);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
        }

        .service-card h3 {
            font-size: 1.4rem;
            margin-bottom: 0.8rem;
        }

        .service-description {
            color: #666;
            margin-bottom: 1.2rem;
        }

        .service-link {
            color: var(--accent);
            font-weight: 600;
            text-decoration: none;
        }

        .service-link:hover {
            color: var(--accent-dark);
        }


        /* Piedāvājumu kartītes un to tipogrāfija */
        .offers-section {
            max-width: 1400px;
            margin: 0 auto 4rem;
            padding: 0 2rem;
        }

        .offers-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 1.5rem;
        }

        .offer-card {
            background: white;
            border-radius: 18px;
            padding: 2rem;
            border: 1px solid #e8e8e8;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .offer-tag {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.15rem;
            color: #666;
        }

        .offer-card h3 {
            font-size: 1.4rem;
        }

        .offer-card p {
            color: #666;
            flex: 1;
        }

        .offer-button {
            align-self: flex-start;
            padding: 0.8rem 1.6rem;
            border-radius: 999px;
            border: 1px solid var(--ink);
            color: var(--ink);
            text-decoration: none;
            font-weight: 600;
        }

        .offer-button:hover {
            background: var(--ink);
            color: white;
        }

        /* Procesa un CTA sadaļu izkārtojums */
        .process-section {
            max-width: 1400px;
            margin: 0 auto;
            padding: 4rem 2rem;
            background: white;
            border-radius: 24px;
            border: 1px solid #e8e8e8;
            margin-bottom: 4rem;
        }

        .process-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2.5rem;
        }

        .process-step {
            text-align: center;
        }

        .step-number {
            width: 60px;
            height: 60px;
            background: var(--accent);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: bold;
            margin: 0 auto 1.5rem;
        }

        .process-step p {
            color: #666;
        }

        .cta-section {
            max-width: 1400px;
            margin: 0 auto 4rem;
            padding: 5rem 2rem;
            background: linear-gradient(135deg, var(--ink) 0%, #333 100%);
            border-radius: 24px;
            text-align: center;
            color: white;
        }

        .cta-section h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .cta-section p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .btn-cta {
            background: white;
            color: var(--ink);
            border: none;
        }

        /* Mūsu darbu galerijas izkārtojums */
        .work-section {
            max-width:1400px;
            margin:0 auto 4rem;
            padding:0 2rem;
        }

        .work-header {
            text-align:center;
            margin-bottom:2.5rem;
        }

        .work-pill {
            display:inline-block;
            padding:0.35rem 0.9rem;
            border-radius:999px;
            background:#fff1ec;
            color:#d9461f;
            font-weight:600;
            text-transform:uppercase;
            letter-spacing:0.1rem;
            font-size:0.85rem;
            margin-bottom:0.8rem;
        }

        .work-header h2 {
            font-size:2.2rem;
        }

        .work-grid {
            display:grid;
            grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
            gap:1.4rem;
        }

        .work-card {
            background:white;
            border-radius:20px;
            border:1px solid #f0f0f0;
            padding:1.4rem;
            box-shadow:0 18px 35px rgba(0,0,0,0.06);
            display:flex;
            flex-direction:column;
            gap:0.8rem;
        }

        .work-card .tag {
            font-size:0.8rem;
            text-transform:uppercase;
            color:#ff814f;
            letter-spacing:0.15rem;
        }

        .work-slider {
            position:relative;
            border-radius:16px;
            overflow:hidden;
            border:1px solid #ededed;
            background:#f7f7f7;
            height:200px;
            display:flex;
            align-items:center;
            justify-content:center;
        }

        .work-slider img {
            width:100%;
            height:100%;
            object-fit:cover;
            display:block;
        }

        .work-slider button {
            position:absolute;
            top:50%;
            transform:translateY(-50%);
            background:rgba(0,0,0,0.55);
            color:white;
            border:none;
            width:34px;
            height:34px;
            border-radius:50%;
            cursor:pointer;
        }

        .work-slider button.prev { left:10px; }
        .work-slider button.next { right:10px; }

        /* Kājenes struktūra ar kolonnām un apakšējo joslu */
        footer {
            background:white;
            border-top:1px solid #e8e8e8;
            margin-top:4rem;
        }

        .footer-wrapper {
            max-width:1400px;
            margin:0 auto;
            padding:3rem 2rem;
            display:grid;
            grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
            gap:2rem;
            color:#555;
        }

        .footer-column h4 {
            font-size:1rem;
            text-transform:uppercase;
            letter-spacing:0.15rem;
            color:var(--ink);
            margin-bottom:1rem;
        }

        .footer-column ul {
            list-style:none;
            display:flex;
            flex-direction:column;
            gap:0.6rem;
        }

        .footer-column a {
            text-decoration:none;
            color:#666;
        }

        .footer-column a:hover {
            color:var(--ink);
        }

        .footer-bottom {
            text-align:center;
            padding:1.5rem;
            color:#777;
            font-size:0.9rem;
            border-top:1px solid #f0f0f0;
        }

        /* Mobilā adaptācija mazākiem ekrāniem */
        @media (max-width: 768px) {
            .hero-section h1 {
                font-size: 2.5rem;
            }

            .nav-links {
                display: none;
            }

            .hero-buttons {
                flex-direction: column;
            }

            .btn-primary,
            .btn-secondary,
            .btn-cta {
                width: 100%;
                text-align: center;
            }

            .calculator-section,
            .process-section,
            .cta-section {
                padding: 3rem 1.5rem;
            }
        }
    </style>
</body>
</html>
