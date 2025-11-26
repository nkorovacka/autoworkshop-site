<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pakalpojumi - Auto Detailing Workshop</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #1a1a1a;
            background: #fafafa;
        }

        /* Header */
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
            color: #1a1a1a;
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

        .nav-links a:hover {
            color: #1a1a1a;
        }

        .nav-links a.active {
            color: #1a1a1a;
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
            color: #1a1a1a;
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
            color: #1a1a1a;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-login:hover {
            background: #f5f5f5;
        }

        .btn-signup {
            padding: 0.5rem 1.2rem;
            background: #1a1a1a;
            border: none;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 500;
            color: white;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-signup:hover {
            background: #333;
        }

        /* Hero Section */
        .hero-section {
            max-width: 1400px;
            margin: 0 auto;
            padding: 5rem 2rem 3rem;
        }

        .hero-content {
            max-width: 800px;
        }

        .hero-section h1 {
            font-size: 3.5rem;
            font-weight: 700;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            letter-spacing: -2px;
            color: #1a1a1a;
        }

        .hero-section p {
            font-size: 1.2rem;
            color: #666;
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
        }

        .btn-primary {
            padding: 1rem 2rem;
            background: #1a1a1a;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            color: white;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary:hover {
            background: #333;
            transform: translateY(-2px);
        }

        .btn-secondary {
            padding: 1rem 2rem;
            background: white;
            border: 1px solid #e8e8e8;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            color: #1a1a1a;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-secondary:hover {
            background: #f5f5f5;
        }

        /* Services Grid */
        .services-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 4rem 2rem;
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
            margin-bottom: 4rem;
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
            background: #f5f5f5;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
        }

        .service-card h3 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.8rem;
            color: #1a1a1a;
        }

        .service-price {
            font-size: 1.1rem;
            font-weight: 600;
            color: #666;
            margin-bottom: 1rem;
        }

        .service-description {
            color: #666;
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }

        .service-features {
            list-style: none;
            margin-bottom: 1.5rem;
        }

        .service-features li {
            padding: 0.4rem 0;
            color: #666;
            font-size: 0.95rem;
        }

        .service-features li:before {
            content: "✓";
            margin-right: 0.8rem;
            color: #1a1a1a;
            font-weight: bold;
        }

        .service-duration {
            font-size: 0.9rem;
            color: #999;
            margin-bottom: 1.5rem;
        }

        .btn-service {
            width: 100%;
            padding: 0.9rem;
            background: #1a1a1a;
            border: none;
            border-radius: 10px;
            font-size: 0.95rem;
            font-weight: 600;
            color: white;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-service:hover {
            background: #333;
        }

        /* Process Section */
        .process-section {
            max-width: 1400px;
            margin: 0 auto;
            padding: 4rem 2rem;
            background: white;
            border-radius: 24px;
            margin-bottom: 4rem;
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
            margin-bottom: 4rem;
        }

        .process-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 3rem;
        }

        .process-step {
            text-align: center;
        }

        .step-number {
            width: 60px;
            height: 60px;
            background: #1a1a1a;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: bold;
            margin: 0 auto 1.5rem;
        }

        .process-step h4 {
            font-size: 1.2rem;
            margin-bottom: 0.8rem;
            color: #1a1a1a;
        }

        .process-step p {
            color: #666;
            line-height: 1.6;
        }

        /* FAQ Section */
        .faq-section {
            max-width: 900px;
            margin: 4rem auto;
            padding: 0 2rem;
        }

        .faq-item {
            background: white;
            border-radius: 12px;
            margin-bottom: 1rem;
            border: 1px solid #e8e8e8;
            overflow: hidden;
        }

        .faq-question {
            padding: 1.5rem;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: background 0.2s;
        }

        .faq-question:hover {
            background: #f5f5f5;
        }

        .faq-answer {
            padding: 0 1.5rem 1.5rem;
            color: #666;
            line-height: 1.6;
            display: none;
        }

        .faq-item.active .faq-answer {
            display: block;
        }

        .faq-icon {
            transition: transform 0.3s;
        }

        .faq-item.active .faq-icon {
            transform: rotate(180deg);
        }

        /* CTA Section */
        .cta-section {
            max-width: 1400px;
            margin: 4rem auto;
            padding: 5rem 2rem;
            background: linear-gradient(135deg, #1a1a1a 0%, #333 100%);
            border-radius: 24px;
            text-align: center;
            color: white;
        }

        .cta-section h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            letter-spacing: -1px;
        }

        .cta-section p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .btn-cta {
            padding: 1.2rem 2.5rem;
            background: white;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            color: #1a1a1a;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-cta:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(255,255,255,0.3);
        }

        /* Footer */
        footer {
            max-width: 1400px;
            margin: 0 auto;
            padding: 3rem 2rem;
            text-align: center;
            color: #666;
        }

        @media (max-width: 768px) {
            .hero-section h1 {
                font-size: 2.5rem;
            }

            .nav-links {
                display: none;
            }

            .services-grid {
                grid-template-columns: 1fr;
            }

            .hero-buttons {
                flex-direction: column;
            }

            .btn-primary, .btn-secondary {
                width: 100%;
                text-align: center;
            }
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
                <li><a href="/our-work">Darbi</a></li>
            </ul>
            <div class="nav-right">
                <button class="icon-button" title="Profils">👤</button>
                <div class="auth-buttons">
                    <button class="btn-login">Ieiet</button>
                    <button class="btn-signup">Reģistrēties</button>
                </div>
            </div>
        </nav>
    </header>

    <div class="hero-section">
        <div class="hero-content">
            <h1>Premium auto kopšanas pakalpojumi</h1>
            <p>Mēs piedāvājam pilnu spektru profesionālu detailing pakalpojumu, kas padarīs Tavu auto nevainojamu. Izmantojam tikai labākos produktus un jaunākās tehnoloģijas.</p>
            <div class="hero-buttons">
                <a href="/booking" class="btn-primary">Aprēķināt cenu</a>
                <a href="#services" class="btn-secondary">Uzzināt vairāk</a>
            </div>
        </div>
    </div>

    <div class="services-container" id="services">
        <div class="services-grid">
            <div class="service-card">
                <div class="service-icon">🚿</div>
                <h3>Ārējā mazgāšana</h3>
                <div class="service-price">No €30</div>
                <p class="service-description">Rūpīga virsbūves mazgāšana ar premium šampūnu, diskus, stiklus un riepas. Pilnīga atjaunošana un spīdums.</p>
                <ul class="service-features">
                    <li>Priekšmazgāšana ar aktīvajām putām</li>
                    <li>Rokas mazgāšana ar mikrošķiedras cimdu</li>
                    <li>Visu riepu un disku tīrīšana</li>
                    <li>Stiklu un spoguļu attīrīšana</li>
                    <li>Žāvēšana ar mikrošķiedras dvieļiem</li>
                </ul>
                <div class="service-duration">⏱ Ilgums: ~1 stunda</div>
                <button class="btn-service" onclick="window.location.href='/booking'">Pieteikties</button>
            </div>

            <div class="service-card">
                <div class="service-icon">🪑</div>
                <h3>Salona ķīmiskā tīrīšana</h3>
                <div class="service-price">No €45</div>
                <p class="service-description">Dziļa salona tīrīšana ar profesionālām ķīmiskajām vielām. Traipu izvadīšana, sēdekļu, grīdas un bagāžnieka tīrīšana.</p>
                <ul class="service-features">
                    <li>Visas virsmas putekļu sūkšana</li>
                    <li>Ķīmiskā tīrīšana visiem sēdekļiem</li>
                    <li>Grīdas un paklājiņu dziļā tīrīšana</li>
                    <li>Traipu izvadīšana</li>
                    <li>Salona aromāts pēc izvēles</li>
                </ul>
                <div class="service-duration">⏱ Ilgums: ~2 stundas</div>
                <button class="btn-service" onclick="window.location.href='/booking'">Pieteikties</button>
            </div>

            <div class="service-card">
                <div class="service-icon">✨</div>
                <h3>Virsbūves pulēšana</h3>
                <div class="service-price">No €80</div>
                <p class="service-description">Profesionāla virsbūves pulēšana ar mašīnu. Skrāpējumu, svītru un oksidrēto krāsas nogāze, atjaunojot sākotnējo spīdumu.</p>
                <ul class="service-features">
                    <li>Virsbūves novērtēšana un sagatavošana</li>
                    <li>Vairāku posmu pulēšana</li>
                    <li>Skrāpējumu un svītru novākšana</li>
                    <li>Krāsas dziļuma atjaunošana</li>
                    <li>Aizsargvaska uzklāšana</li>
                </ul>
                <div class="service-duration">⏱ Ilgums: ~3-4 stundas</div>
                <button class="btn-service" onclick="window.location.href='/booking'">Pieteikties</button>
            </div>

            <div class="service-card">
                <div class="service-icon">🛡️</div>
                <h3>Keramiskā aizsardzība</h3>
                <div class="service-price">No €150</div>
                <p class="service-description">Premium keramiskais pārklājums ar 2+ gadu aizsardzību. Hidrofobi efekts, aizsardzība pret UV stariem un ķīmiskiem savienojumiem.</p>
                <ul class="service-features">
                    <li>Virsbūves sagatavošana un pulēšana</li>
                    <li>Nano keramiskā pārklājuma uzklāšana</li>
                    <li>UV un ķīmiskā aizsardzība</li>
                    <li>Ūdens atgrūdošs efekts</li>
                    <li>2 gadu garantija</li>
                </ul>
                <div class="service-duration">⏱ Ilgums: ~6-8 stundas</div>
                <button class="btn-service" onclick="window.location.href='/booking'">Pieteikties</button>
            </div>

            <div class="service-card">
                <div class="service-icon">🎯</div>
                <h3>Pilns Detailing</h3>
                <div class="service-price">No €120</div>
                <p class="service-description">Komplekss pakalpojums - gan salons, gan virsbūve. Pilnīga auto transformācija vienā apmeklējumā ar maksimālu rezultātu.</p>
                <ul class="service-features">
                    <li>Visa ārējā mazgāšana un pulēšana</li>
                    <li>Pilna salona ķīmiskā tīrīšana</li>
                    <li>Disku un riepu detailing</li>
                    <li>Motora nodalījuma mazgāšana</li>
                    <li>Aizsargpārklājuma uzklāšana</li>
                </ul>
                <div class="service-duration">⏱ Ilgums: ~5-6 stundas</div>
                <button class="btn-service" onclick="window.location.href='/booking'">Pieteikties</button>
            </div>

            <div class="service-card">
                <div class="service-icon">💎</div>
                <h3>VIP Pakalpojums</h3>
                <div class="service-price">No €250</div>
                <p class="service-description">Absolūti viss - premium detailing ar keramisko aizsardzību, salona ādas kopšana, motora mazgāšana un vairāk.</p>
                <ul class="service-features">
                    <li>Viss no Pilna Detailing pakalpojuma</li>
                    <li>Keramiskā pārklājuma uzklāšana</li>
                    <li>Ādas sēdekļu kondicionēšana</li>
                    <li>Luktuļu pulēšana</li>
                    <li>Premium aromāts uz 30 dienām</li>
                </ul>
                <div class="service-duration">⏱ Ilgums: ~8-10 stundas</div>
                <button class="btn-service" onclick="window.location.href='/booking'">Pieteikties</button>
            </div>
        </div>
    </div>

    <div class="process-section">
        <h2 class="section-title">Kā mēs strādājam</h2>
        <p class="section-subtitle">Vienkāršs process jūsu ērtībai</p>
        <div class="process-grid">
            <div class="process-step">
                <div class="step-number">1</div>
                <h4>Izvēlies pakalpojumu</h4>
                <p>Apskati mūsu pakalpojumus un izvēlies piemērotāko. Izmanto kalkulatoru, lai aprēķinātu cenu.</p>
            </div>
            <div class="process-step">
                <div class="step-number">2</div>
                <h4>Piesakies online</h4>
                <p>Aizpildi vienkāršu pieteikšanās formu un izvēlies sev ērtu laiku. Saņemsi apstiprinājumu e-pastā.</p>
            </div>
            <div class="process-step">
                <div class="step-number">3</div>
                <h4>Atved auto</h4>
                <p>Atved savu auto uz mūsu servisu izvēlētajā laikā. Mūsu meistari pārbaudīs auto un sāks darbu.</p>
            </div>
            <div class="process-step">
                <div class="step-number">4</div>
                <h4>Saņem rezultātu</h4>
                <p>Pēc darba pabeigšanas saņemsi paziņojumu. Tavs auto būs gatavs, gluži kā jauns!</p>
            </div>
        </div>
    </div>

    <div class="faq-section">
        <h2 class="section-title">Biežāk uzdotie jautājumi</h2>
        <p class="section-subtitle">Atbildes uz populārākajiem jautājumiem</p>

        <div class="faq-item">
            <div class="faq-question" onclick="this.parentElement.classList.toggle('active')">
                <span>Cik ilgi ilgst katrs pakalpojums?</span>
                <span class="faq-icon">▼</span>
            </div>
            <div class="faq-answer">
                Ārējā mazgāšana aizņem apmēram 1 stundu, salona tīrīšana 2 stundas, pulēšana 3-4 stundas, bet pilns detailing var aizņemt 5-6 stundas. Precīzs laiks atkarīgs no auto stāvokļa un izmēra.
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question" onclick="this.parentElement.classList.toggle('active')">
                <span>Vai cena mainās atkarībā no auto izmēra?</span>
                <span class="faq-icon">▼</span>
            </div>
            <div class="faq-answer">
                Jā, cena mainās atkarībā no auto izmēra. Maziem auto koeficients ir 1.0, vidējiem - 1.2, SUV - 1.5, bet busiņiem - 2.0. Izmanto mūsu kalkulatoru, lai aprēķinātu precīzu cenu.
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question" onclick="this.parentElement.classList.toggle('active')">
                <span>Kādus produktus jūs izmantojat?</span>
                <span class="faq-icon">▼</span>
            </div>
            <div class="faq-answer">
                Mēs izmantojam tikai premium produktus no pazīstamiem ražotājiem - Meguiar's, Chemical Guys, Gtechniq un citiem. Visi produkti ir droši krāsai un virsmām.
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question" onclick="this.parentElement.classList.toggle('active')">
                <span>Vai ir garantija uz pakalpojumiem?</span>
                <span class="faq-icon">▼</span>
            </div>
            <div class="faq-answer">
                Jā, mēs garantējam 100% apmierinātību ar mūsu darbu. Keramiskajam pārklājumam ir 2 gadu garantija. Ja kaut kas neapmierina, mēs to labosim bez maksas.
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question" onclick="this.parentElement.classList.toggle('active')">
                <span>Vai man jāgaida līdz darbs ir pabeigts?</span>
                <span class="faq-icon">▼</span>
            </div>
            <div class="faq-answer">
                Nē, tu vari atstāt auto pie mums un doties prom. Kad darbs būs pabeigts, mēs Tev pazvanīsim vai atsūtīsim ziņu. Mums ir arī gaidīšanas zona ar WiFi un kafiju, ja vēlies pagaidīt.
            </div>
        </div>
    </div>

    <div class="cta-section">
        <h2>Gatavs atjaunot savu auto?</h2>
        <p>Izmanto mūsu kalkulatoru, lai aprēķinātu cenu un piesakies jau šodien!</p>
        <a href="/booking" class="btn-cta">Aprēķināt cenu un pieteikties →</a>
    </div>

    <footer>
        <p>&copy; 2024 Auto Detailing Workshop. Visas tiesības aizsargātas.</p>
    </footer>
</body>
</html>