<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auto Detailing Workshop - Profesionāla Auto Kopšana</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        /* Header */
        header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 1rem 2rem;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
        }

        nav {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: bold;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        nav ul {
            display: flex;
            list-style: none;
            gap: 2rem;
        }

        nav a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            transition: all 0.3s;
            position: relative;
        }

        nav a:hover {
            color: #667eea;
        }

        nav a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: width 0.3s;
        }

        nav a:hover::after {
            width: 100%;
        }

        /* Hero Section */
        .hero {
            max-width: 1200px;
            margin: 0 auto;
            padding: 4rem 2rem;
            text-align: center;
        }

        .hero h1 {
            font-size: 3rem;
            color: white;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
            animation: fadeInUp 0.8s ease-out;
        }

        .hero p {
            font-size: 1.2rem;
            color: rgba(255,255,255,0.9);
            margin-bottom: 2rem;
            animation: fadeInUp 0.8s ease-out 0.2s both;
        }

        .cta-button {
            display: inline-block;
            background: white;
            color: #667eea;
            padding: 1rem 2.5rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: bold;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            transition: all 0.3s;
            animation: fadeInUp 0.8s ease-out 0.4s both;
        }

        .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.3);
        }

        /* Calculator Section */
        .calculator-section {
            background: white;
            max-width: 1200px;
            margin: 2rem auto;
            padding: 3rem 2rem;
            border-radius: 30px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
        }

        .calculator-section h2 {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .calculator-section .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 2rem;
        }

        .calculator-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .calc-field {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 15px;
            transition: all 0.3s;
        }

        .calc-field:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.2);
        }

        .calc-field label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #333;
        }

        .calc-field select {
            width: 100%;
            padding: 0.8rem;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s;
        }

        .calc-field select:focus {
            outline: none;
            border-color: #667eea;
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .service-option {
            background: white;
            padding: 1rem;
            border-radius: 10px;
            border: 2px solid #e0e0e0;
            cursor: pointer;
            transition: all 0.3s;
        }

        .service-option:hover {
            border-color: #667eea;
        }

        .service-option input[type="checkbox"] {
            display: none;
        }

        .service-option label {
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .service-option input[type="checkbox"]:checked + label {
            color: #667eea;
            font-weight: bold;
        }

        .price-display {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            border-radius: 20px;
            text-align: center;
            margin-top: 2rem;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        }

        .price-display h3 {
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
            opacity: 0.9;
        }

        .price-display .price {
            font-size: 3rem;
            font-weight: bold;
        }

        /* Offers Section */
        .offers-section {
            max-width: 1200px;
            margin: 3rem auto;
            padding: 0 2rem;
        }

        .offers-section h2 {
            text-align: center;
            font-size: 2.5rem;
            color: white;
            margin-bottom: 2rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }

        .offers-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .offer-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            transition: all 0.3s;
            animation: fadeInUp 0.6s ease-out;
        }

        .offer-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.3);
        }

        .offer-badge {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0.5rem 1rem;
            font-weight: bold;
            display: inline-block;
        }

        .offer-content {
            padding: 2rem;
        }

        .offer-card h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: #333;
        }

        .offer-card p {
            color: #666;
            margin-bottom: 1rem;
        }

        .offer-button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0.8rem 1.5rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s;
        }

        .offer-button:hover {
            transform: translateX(5px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        /* Info Section */
        .info-section {
            background: white;
            max-width: 1200px;
            margin: 3rem auto;
            padding: 3rem 2rem;
            border-radius: 30px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }

        .info-card {
            text-align: center;
            padding: 2rem;
            border-radius: 15px;
            transition: all 0.3s;
        }

        .info-card:hover {
            background: #f8f9fa;
            transform: translateY(-5px);
        }

        .info-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .info-card h3 {
            font-size: 1.3rem;
            margin-bottom: 0.5rem;
            color: #333;
        }

        .info-card p {
            color: #666;
        }

        /* Footer */
        footer {
            background: rgba(255, 255, 255, 0.95);
            padding: 2rem;
            text-align: center;
            margin-top: 3rem;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2rem;
            }

            nav ul {
                flex-direction: column;
                gap: 1rem;
            }

            .calculator-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <div class="logo">🚗 Auto Detailing</div>
            <ul>
                <li><a href="/">Galvenā</a></li>
                <li><a href="/services">Pakalpojumi</a></li>
                <li><a href="/products">Produkti</a></li>
                <li><a href="/offers">Piedāvājumi</a></li>
                <li><a href="/our-work">Mūsu darbi</a></li>
            </ul>
        </nav>
    </header>

    <div class="hero">
        <h1>✨ Profesionāla Auto Kopšana ✨</h1>
        <p>Padarīsim Tavu auto kā jaunu ar mūsu premium detailing pakalpojumiem!</p>
        <a href="/booking" class="cta-button">📅 Pieteikties Tagad</a>
    </div>

    <!-- Calculator Section -->
    <div class="calculator-section">
        <h2>💰 Cenu Kalkulators</h2>
        <p class="subtitle">Aprēķini pakalpojumu izmaksas dažās sekundēs!</p>

        <div class="calculator-grid">
            <div class="calc-field">
                <label>🚙 Auto izmērs</label>
                <select id="car">
                    <option value="">Izvēlies auto</option>
                    <option value="1.0">Mazs auto (Fiesta, Polo)</option>
                    <option value="1.2">Vidējs auto (A4, Golf)</option>
                    <option value="1.5">SUV (Q7, X5)</option>
                    <option value="2.0">Busiņš (Transporter)</option>
                </select>
            </div>

            <div class="calc-field">
                <label>🧹 Stāvoklis</label>
                <select id="condition">
                    <option value="">Izvēlies stāvokli</option>
                    <option value="1">Normāls</option>
                    <option value="1.1">Netīrs (+10%)</option>
                    <option value="1.25">Ļoti netīrs (+25%)</option>
                </select>
            </div>
        </div>

        <div class="services-grid">
            <div class="service-option">
                <input type="checkbox" id="exterior" value="30" class="service">
                <label for="exterior">
                    <span>🧽</span>
                    <div>
                        <strong>Ārējā mazgāšana</strong>
                        <div>30 €</div>
                    </div>
                </label>
            </div>

            <div class="service-option">
                <input type="checkbox" id="interior" value="40" class="service">
                <label for="interior">
                    <span>🪑</span>
                    <div>
                        <strong>Salona tīrīšana</strong>
                        <div>40 €</div>
                    </div>
                </label>
            </div>

            <div class="service-option">
                <input type="checkbox" id="polishing" value="80" class="service">
                <label for="polishing">
                    <span>✨</span>
                    <div>
                        <strong>Pulēšana</strong>
                        <div>80 €</div>
                    </div>
                </label>
            </div>
        </div>

        <div class="price-display">
            <h3>Kopējā cena</h3>
            <div class="price" id="totalPrice">€0.00</div>
        </div>
    </div>

    <!-- Offers Section -->
    <div class="offers-section">
        <h2>🎁 Aktuālie Piedāvājumi</h2>
        <div class="offers-grid">
            <div class="offer-card">
                <div class="offer-badge">-20% ATLAIDE</div>
                <div class="offer-content">
                    <h3>Pavasara Akcija</h3>
                    <p>Pilns detailing pakalpojums ar 20% atlaidi. Sagatavo savu auto vasaras sezonai!</p>
                    <a href="/offers" class="offer-button">Uzzināt vairāk →</a>
                </div>
            </div>

            <div class="offer-card">
                <div class="offer-badge">BEZMAKSAS VEBINĀRS</div>
                <div class="offer-content">
                    <h3>Auto Kopšanas Pamati</h3>
                    <p>Bezmaksas vebinārs par pareizu auto kopšanu un detailing pamatlietām.</p>
                    <a href="/offers" class="offer-button">Pieteikties →</a>
                </div>
            </div>

            <div class="offer-card">
                <div class="offer-badge">JAUNS</div>
                <div class="offer-content">
                    <h3>Keramiskā Aizsardzība</h3>
                    <p>Premium keramiskais pārklājums ar 2 gadu garantiju. Ilgstoša aizsardzība!</p>
                    <a href="/booking" class="offer-button">Pieteikties →</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Section -->
    <div class="info-section">
        <div class="info-grid">
            <div class="info-card">
                <div class="info-icon">⚡</div>
                <h3>Ātra Apkalpošana</h3>
                <p>Profesionāls darbs 2-4 stundu laikā</p>
            </div>

            <div class="info-card">
                <div class="info-icon">🏆</div>
                <h3>Premium Kvalitāte</h3>
                <p>Izmantojam tikai labākos produktus</p>
            </div>

            <div class="info-card">
                <div class="info-icon">💯</div>
                <h3>Garantija</h3>
                <p>100% apmierinātības garantija</p>
            </div>

            <div class="info-card">
                <div class="info-icon">📍</div>
                <h3>Ērta Atrašanās Vieta</h3>
                <p>Viegli sasniedzams centrs</p>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Auto Detailing Workshop. Visas tiesības aizsargātas.</p>
    </footer>

    <script>
        const carSelect = document.getElementById('car');
        const conditionSelect = document.getElementById('condition');
        const serviceCheckboxes = document.querySelectorAll('.service');
        const totalPriceDisplay = document.getElementById('totalPrice');

        function calculateTotal() {
            let base = 0;

            serviceCheckboxes.forEach(cb => {
                if (cb.checked) {
                    base += parseFloat(cb.value);
                }
            });

            let carMultiplier = parseFloat(carSelect.value) || 1;
            let conditionMultiplier = parseFloat(conditionSelect.value) || 1;

            const total = base * carMultiplier * conditionMultiplier;
            totalPriceDisplay.textContent = '€' + total.toFixed(2);
        }

        carSelect.addEventListener('change', calculateTotal);
        conditionSelect.addEventListener('change', calculateTotal);
        serviceCheckboxes.forEach(cb => {
            cb.addEventListener('change', calculateTotal);
        });

        // Add click handler to service option divs
        document.querySelectorAll('.service-option').forEach(option => {
            option.addEventListener('click', function(e) {
                if (e.target.tagName !== 'INPUT') {
                    const checkbox = this.querySelector('input[type="checkbox"]');
                    checkbox.checked = !checkbox.checked;
                    calculateTotal();
                }
            });
        });
    </script>
</body>
</html>