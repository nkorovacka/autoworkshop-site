<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <title>Rezervēt vizīti - Auto Detailing Workshop</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --accent: #ff5c35;
            --accent-dark: #d9461f;
            --accent-light: #fff1ec;
            --ink: #1a1a1a;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            color: var(--ink);
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

        /* Main Container */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 3rem 2rem;
        }

        .page-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .page-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            letter-spacing: -1px;
        }

        .page-header p {
            color: #666;
            font-size: 1.1rem;
        }

        /* Offer Banner */
        .offer-banner {
            background: linear-gradient(135deg, var(--accent) 0%, var(--accent-dark) 100%);
            color: white;
            padding: 2rem;
            border-radius: 16px;
            margin-bottom: 3rem;
            text-align: center;
        }

        .offer-banner h2 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .offer-banner p {
            opacity: 0.95;
        }

        /* Form Layout */
        .booking-layout {
            display: grid;
            grid-template-columns: 1fr 400px;
            gap: 2rem;
        }

        .booking-form {
            background: white;
            border-radius: 20px;
            padding: 2.5rem;
            border: 1px solid #e8e8e8;
        }

        .form-section {
            margin-bottom: 2.5rem;
        }

        .form-section:last-child {
            margin-bottom: 0;
        }

        .section-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .section-icon {
            width: 24px;
            height: 24px;
            background: var(--accent-light);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .form-field {
            margin-bottom: 1rem;
        }

        .form-field label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .form-field input,
        .form-field select,
        .form-field textarea {
            width: 100%;
            padding: 0.9rem;
            border: 1px solid #e8e8e8;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.2s;
        }

        .form-field input:focus,
        .form-field select:focus,
        .form-field textarea:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-light);
        }

        /* Service Selection */
        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 1rem;
        }

        .service-option {
            position: relative;
        }

        .service-option input {
            display: none;
        }

        .service-label {
            display: block;
            padding: 1.2rem;
            border: 2px solid #e8e8e8;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s;
            text-align: center;
        }

        .service-option input:checked + .service-label {
            border-color: var(--accent);
            background: var(--accent-light);
        }

        .service-label .icon {
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
        }

        .service-label .name {
            font-weight: 600;
            font-size: 0.95rem;
            margin-bottom: 0.3rem;
        }

        .service-label .price {
            color: var(--accent);
            font-weight: 600;
            font-size: 0.9rem;
        }

        /* Summary Sidebar */
        .booking-summary {
            position: sticky;
            top: 100px;
            height: fit-content;
        }

        .summary-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            border: 1px solid #e8e8e8;
        }

        .summary-card h3 {
            font-size: 1.3rem;
            margin-bottom: 1.5rem;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            padding: 0.8rem 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .summary-item:last-child {
            border-bottom: none;
        }

        .summary-total {
            display: flex;
            justify-content: space-between;
            padding-top: 1rem;
            margin-top: 1rem;
            border-top: 2px solid #e8e8e8;
            font-size: 1.3rem;
            font-weight: 700;
        }

        .summary-total .amount {
            color: var(--accent);
        }

        /* Submit Button */
        .submit-btn {
            width: 100%;
            padding: 1.2rem;
            background: var(--accent);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            margin-top: 1.5rem;
        }

        .submit-btn:hover {
            background: var(--accent-dark);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(255, 92, 53, 0.3);
        }

        /* Messages */
        .message {
            padding: 1rem 1.5rem;
            border-radius: 10px;
            margin-bottom: 2rem;
        }

        .message.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .message.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Responsive */
        @media (max-width: 968px) {
            .booking-layout {
                grid-template-columns: 1fr;
            }

            .booking-summary {
                position: static;
            }

            .nav-links {
                display: none;
            }
        }

        @media (max-width: 640px) {
            .page-header h1 {
                font-size: 2rem;
            }

            .services-grid {
                grid-template-columns: 1fr;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Loading State */
        .loading {
            opacity: 0.6;
            pointer-events: none;
        }

        /* Info Box */
        .info-box {
            background: #f8f9fa;
            border-left: 4px solid var(--accent);
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
        }

        footer {
            max-width: 1400px;
            margin: 0 auto;
            padding: 3rem 2rem;
            text-align: center;
            color: #666;
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
                <li><a href="{{ route('products.index') }}">Produkti</a></li>
                <li><a href="{{ route('offers.index') }}">Piedāvājumi</a></li>
                <li><a href="{{ route('our-work') }}">Darbi</a></li>
                <li><a href="{{ route('booking.create') }}" class="active">Rezervēt</a></li>
            </ul>
            <div class="nav-right">
                @auth
                    <div class="user-greeting">Sveiki, {{ auth()->user()->name }}</div>
                    <div class="auth-buttons signed-in">
                        <a class="btn-cart" href="#">🛒 Grozs</a>
                        <a class="btn-profile" href="{{ route('profile') }}">👤 Profils</a>
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

    <div class="container">
        <div class="page-header">
            <h1>Rezervē savu vizīti</h1>
            <p>Aizpildi formu un saņem apstiprinājumu dažu minūšu laikā</p>
        </div>

        <!-- Offer Banner (if coming from offer) -->
        <div class="offer-banner" id="offerBanner" style="display: none;">
            <h2 id="offerTitle">Īpašais piedāvājums</h2>
            <p id="offerDescription"></p>
        </div>

        <!-- Messages -->
        <div id="messages"></div>

        <div class="booking-layout">
            <!-- Main Form -->
            <div class="booking-form">
                <form id="bookingForm">
                    <!-- Personal Information -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <span class="section-icon">👤</span>
                            Tava informācija
                        </h3>
                        @auth
                            <div class="info-box" style="margin-bottom:1rem;">
                                Tu esi pieslēdzies sistēmai kā <strong>{{ auth()->user()->name }}</strong>. Pieteikuma lauki ir aizpildīti ar Taviem datiem.
                            </div>
                        @endauth
                        <div class="form-grid">
                            <div class="form-field">
                                <label for="name">Vārds, Uzvārds *</label>
                                <input type="text" id="name" name="customer_name" value="{{ old('customer_name', auth()->user()->name ?? '') }}" required>
                            </div>
                            <div class="form-field">
                                <label for="phone">Telefona numurs *</label>
                                <input type="tel" id="phone" name="customer_phone" value="{{ old('customer_phone') }}" required>
                            </div>
                        </div>
                        <div class="form-field">
                            <label for="email">E-pasts</label>
                            <input type="email" id="email" name="customer_email" value="{{ old('customer_email', auth()->user()->email ?? '') }}">
                        </div>
                    </div>

                    <!-- Vehicle Information -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <span class="section-icon">🚗</span>
                            Auto informācija
                        </h3>
                        <div class="form-grid">
                            <div class="form-field">
                                <label for="car">Auto modelis *</label>
                                <input type="text" id="car" name="car" placeholder="piem., VW Golf" required>
                            </div>
                            <div class="form-field">
                                <label for="carSize">Auto izmērs *</label>
                                <select id="carSize" required>
                                    <option value="">-- Izvēlies --</option>
                                    <option value="1">Mazs (Polo, Fiesta)</option>
                                    <option value="1.2">Vidējs (Golf, A4)</option>
                                    <option value="1.5">Liels / SUV</option>
                                    <option value="2">Busiņš</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-field">
                            <label for="condition">Auto stāvoklis *</label>
                            <select id="condition" name="condition" required>
                                <option value="">-- Izvēlies --</option>
                                <option value="normal">Normāls</option>
                                <option value="dirty">Ļoti netīrs (+10%)</option>
                                <option value="very_dirty">Ekstremāli netīrs (+25%)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Date & Time -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <span class="section-icon">📅</span>
                            Datums un laiks
                        </h3>
                        <div class="form-grid">
                            <div class="form-field">
                                <label for="date">Datums *</label>
                                <input type="date" id="date" name="date" required>
                            </div>
                            <div class="form-field">
                                <label for="time">Laiks *</label>
                                <input type="time" id="time" name="time" required>
                            </div>
                        </div>
                        <div class="info-box">
                            💡 Ieteicams rezervēt vismaz 2 dienas iepriekš. Darba laiks: P-Pk 9:00-18:00, S 10:00-16:00
                        </div>
                    </div>

                    <!-- Services -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <span class="section-icon">✨</span>
                            Izvēlies pakalpojumus
                        </h3>
                        <div class="services-grid">
                            <div class="service-option">
                                <input type="checkbox" id="service-exterior" name="services[]" value="exterior" data-price="30">
                                <label for="service-exterior" class="service-label">
                                    <div class="icon">🧽</div>
                                    <div class="name">Ārējā mazgāšana</div>
                                    <div class="price">no €30</div>
                                </label>
                            </div>
                            <div class="service-option">
                                <input type="checkbox" id="service-interior" name="services[]" value="interior" data-price="45">
                                <label for="service-interior" class="service-label">
                                    <div class="icon">🪑</div>
                                    <div class="name">Salona tīrīšana</div>
                                    <div class="price">no €45</div>
                                </label>
                            </div>
                            <div class="service-option">
                                <input type="checkbox" id="service-polish" name="services[]" value="polishing" data-price="80">
                                <label for="service-polish" class="service-label">
                                    <div class="icon">💎</div>
                                    <div class="name">Pulēšana</div>
                                    <div class="price">no €80</div>
                                </label>
                            </div>
                            <div class="service-option">
                                <input type="checkbox" id="service-ceramic" name="services[]" value="ceramic" data-price="150">
                                <label for="service-ceramic" class="service-label">
                                    <div class="icon">🛡️</div>
                                    <div class="name">Keramiskā aizsardzība</div>
                                    <div class="price">no €150</div>
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Summary Sidebar -->
            <div class="booking-summary">
                <div class="summary-card">
                    <h3>Rezervācijas kopsavilkums</h3>
                    
                    <div id="summaryContent">
                        <div class="summary-item">
                            <span>Auto izmērs</span>
                            <span id="summaryCar">Nav izvēlēts</span>
                        </div>
                        <div class="summary-item">
                            <span>Stāvoklis</span>
                            <span id="summaryCondition">Nav izvēlēts</span>
                        </div>
                        <div class="summary-item">
                            <span>Pakalpojumi</span>
                            <span id="summaryServices">0 izvēlēti</span>
                        </div>
                        <div class="summary-item">
                            <span>Datums</span>
                            <span id="summaryDate">Nav izvēlēts</span>
                        </div>
                        <div class="summary-total">
                            <span>Kopā:</span>
                            <span class="amount" id="totalPrice">€0.00</span>
                        </div>
                    </div>

                    <button type="submit" form="bookingForm" class="submit-btn">
                        Rezervēt vizīti
                    </button>

                    <div class="info-box" style="margin-top: 1rem;">
                        ℹ️ Precīza cena tiks apstiprināta pēc auto apskates
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Auto Detailing Workshop. Visas tiesības aizsargātas.</p>
    </footer>

    <script>
        // Price Calculator
        const carSizeSelect = document.getElementById('carSize');
        const conditionSelect = document.getElementById('condition');
        const serviceCheckboxes = document.querySelectorAll('input[name="services[]"]');
        const totalPriceEl = document.getElementById('totalPrice');
        
        // Summary elements
        const summaryCarEl = document.getElementById('summaryCar');
        const summaryConditionEl = document.getElementById('summaryCondition');
        const summaryServicesEl = document.getElementById('summaryServices');
        const summaryDateEl = document.getElementById('summaryDate');

        function calculateTotal() {
            let basePrice = 0;
            let selectedCount = 0;

            // Get selected services
            serviceCheckboxes.forEach(cb => {
                if (cb.checked) {
                    basePrice += parseFloat(cb.dataset.price);
                    selectedCount++;
                }
            });

            // Apply multipliers
            const carMultiplier = parseFloat(carSizeSelect.value) || 1;
            const conditionValue = conditionSelect.value;
            let conditionMultiplier = 1;
            
            if (conditionValue === 'dirty') conditionMultiplier = 1.1;
            if (conditionValue === 'very_dirty') conditionMultiplier = 1.25;

            const total = basePrice * carMultiplier * conditionMultiplier;
            totalPriceEl.textContent = '€' + total.toFixed(2);

            // Update summary
            summaryServicesEl.textContent = selectedCount + ' izvēlēti';
        }

        function updateSummary() {
            // Car size
            const carText = carSizeSelect.options[carSizeSelect.selectedIndex]?.text || 'Nav izvēlēts';
            summaryCarEl.textContent = carText;

            // Condition
            const conditionText = conditionSelect.options[conditionSelect.selectedIndex]?.text || 'Nav izvēlēts';
            summaryConditionEl.textContent = conditionText;

            // Date
            const dateValue = document.getElementById('date').value;
            const timeValue = document.getElementById('time').value;
            if (dateValue && timeValue) {
                summaryDateEl.textContent = `${dateValue} ${timeValue}`;
            } else if (dateValue) {
                summaryDateEl.textContent = dateValue;
            } else {
                summaryDateEl.textContent = 'Nav izvēlēts';
            }

            calculateTotal();
        }

        // Event listeners
        carSizeSelect.addEventListener('change', updateSummary);
        conditionSelect.addEventListener('change', updateSummary);
        serviceCheckboxes.forEach(cb => cb.addEventListener('change', updateSummary));
        document.getElementById('date').addEventListener('change', updateSummary);
        document.getElementById('time').addEventListener('change', updateSummary);

        // Form submission
        document.getElementById('bookingForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validate at least one service selected
            const hasService = Array.from(serviceCheckboxes).some(cb => cb.checked);
            if (!hasService) {
                showMessage('Lūdzu izvēlies vismaz vienu pakalpojumu', 'error');
                return;
            }

            // Get form data
            const formData = new FormData(this);
            formData.append('total', totalPriceEl.textContent.replace('€', ''));

            // Show loading
            document.body.classList.add('loading');

            // Simulate submission (replace with actual endpoint)
            setTimeout(() => {
                document.body.classList.remove('loading');
                showMessage('✅ Rezervācija veiksmīgi nosūtīta! Sazināsimies ar Tevi tuvākajā laikā.', 'success');
                this.reset();
                updateSummary();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }, 1500);
        });

        function showMessage(text, type) {
            const messagesDiv = document.getElementById('messages');
            messagesDiv.innerHTML = `<div class="message ${type}">${text}</div>`;
            setTimeout(() => {
                messagesDiv.innerHTML = '';
            }, 5000);
        }

        // Preselect service when coming from services page
        const urlParams = new URLSearchParams(window.location.search);
        const serviceParam = urlParams.get('service');
        if (serviceParam) {
            const checkbox = document.getElementById(`service-${serviceParam}`);
            if (checkbox) {
                checkbox.checked = true;
                checkbox.dispatchEvent(new Event('change'));
            }
        }

        // Set minimum date to today
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('date').setAttribute('min', today);

        // Check for offer in URL
        const offerId = urlParams.get('offer');
        if (offerId) {
            document.getElementById('offerBanner').style.display = 'block';
            // In real implementation, fetch offer details
        }

        // Initialize summary totals on load
        updateSummary();
    </script>
</body>
</html>
