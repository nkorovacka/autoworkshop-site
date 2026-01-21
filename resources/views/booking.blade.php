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
            gap: 0.75rem;
            padding: 0.8rem 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .summary-item span:first-child {
            flex: 0 0 auto;
        }

        .summary-item span:last-child {
            text-align: right;
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
            background: white;
            border-top: 1px solid #e8e8e8;
            margin-top: 4rem;
        }

        .footer-wrapper {
            max-width: 1400px;
            margin: 0 auto;
            padding: 3rem 2rem;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 2rem;
            color: #555;
        }

        .footer-column h4 {
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 0.15rem;
            color: var(--ink);
            margin-bottom: 1rem;
        }

        .footer-column ul {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 0.6rem;
        }

        .footer-column a {
            text-decoration: none;
            color: #666;
        }

        .footer-column a:hover {
            color: var(--ink);
        }

        .footer-bottom {
            text-align: center;
            padding: 1.5rem;
            color: #777;
            font-size: 0.9rem;
            border-top: 1px solid #f0f0f0;
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
                        <a class="btn-cart" href="{{ route('cart.index') }}">🛒 Grozs</a>
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
        <div id="messages">
            @if(session('success'))
                <div class="message success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="message error">{{ session('error') }}</div>
            @endif
            @if($errors->any())
                <div class="message error">
                    <ul style="margin:0; padding-left:1.2rem;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <div class="booking-layout">
            <!-- Main Form -->
            <div class="booking-form">
                <form id="bookingForm" method="POST" action="{{ route('booking.store') }}">
                    @csrf
                    <input type="hidden" id="totalField" name="total" value="{{ old('total', '0') }}">
                    @if($offer)
                        <input type="hidden" name="offer_id" value="{{ $offer->id }}">
                    @endif
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
                            <div class="form-field" style="grid-column: span 2;">
                                @php
                                    $oldCarValue = old('car');
                                    $oldCarLabel = '';
                                    if ($oldCarValue) {
                                        $matchedVehicle = collect($vehicles)->firstWhere('name', $oldCarValue);
                                        $oldCarLabel = $matchedVehicle['label'] ?? $oldCarValue;
                                    }
                                @endphp
                                <label for="carDisplay">Auto modelis *</label>
                                <input type="text"
                                       id="carDisplay"
                                       list="carSuggestions"
                                       placeholder="Sāc rakstīt modeli..."
                                       autocomplete="off"
                                       style="margin-bottom: 0.5rem;"
                                       value="{{ $oldCarLabel }}"
                                       required>
                                <datalist id="carSuggestions">
                                    @foreach($vehicles as $vehicle)
                                        <option value="{{ $vehicle['label'] ?? $vehicle['name'] }}"
                                                data-name="{{ $vehicle['name'] }}"
                                                data-multiplier="{{ $vehicle['multiplier'] }}"></option>
                                    @endforeach
                                </datalist>
                                <input type="hidden" id="car" name="car" value="{{ $oldCarValue }}">
                                <small style="color:#777;">Sāc rakstīt, lai atrastu savu modeli.</small>
                            </div>
                        </div>
                        <div class="form-grid">
                            <div class="form-field">
                                <label for="bodyCondition">Auto virsbūves stāvoklis *</label>
                                <select id="bodyCondition" name="condition" required>
                                    <option value="">-- Izvēlies --</option>
                                    <option value="normal" @selected(old('condition') === 'normal')>Normāls</option>
                                    <option value="dirty" @selected(old('condition') === 'dirty')>Ļoti netīrs (+10%)</option>
                                    <option value="very_dirty" @selected(old('condition') === 'very_dirty')>Ekstremāli netīrs (+25%)</option>
                                </select>
                            </div>
                            <div class="form-field">
                                <label for="interiorMaterial">Salona materiāls</label>
                                <select id="interiorMaterial" name="interior_material">
                                    <option value="">-- Izvēlies --</option>
                                    <option value="fabric" @selected(old('interior_material') === 'fabric')>Audums / kombinēts</option>
                                    <option value="leather" @selected(old('interior_material') === 'leather')>Āda (+10%)</option>
                                    <option value="alcantara" @selected(old('interior_material') === 'alcantara')>Premium āda / Alcantara (+15%)</option>
                                </select>
                            </div>
                            <div class="form-field">
                                <label for="interiorCondition">Salona stāvoklis</label>
                                <select id="interiorCondition" name="interior_condition" disabled>
                                    <option value="">-- Izvēlies --</option>
                                    <option value="fresh" @selected(old('interior_condition') === 'fresh')>Labi kopts</option>
                                    <option value="used" @selected(old('interior_condition') === 'used')>Vidēji nolietots (+10%)</option>
                                    <option value="dirty" @selected(old('interior_condition') === 'dirty')>Ļoti netīrs (+20%)</option>
                                </select>
                                <small style="color:#777;">Salona stāvokli var izvēlēties pēc materiāla izvēles. Šī informācija kļūst obligāta, ja izvēlies salona dziļo tīrīšanu, pilnu detailing komplektu vai VIP programmu.</small>
                            </div>
                        </div>
                    </div>

                    <!-- Date & Time -->
                    @php
                        $isOfferSchedule = $offer && $offer->type === 'detailing' && $offer->has_timeslots;
                        $minDate = $minBookingDate ?? \Carbon\Carbon::tomorrow()->format('Y-m-d');
                        $defaultDateValue = $isOfferSchedule
                            ? ($offer->event_date ?? '')
                            : old('date', $minDate);
                    @endphp
                    <div class="form-section">
                        <h3 class="section-title">
                            <span class="section-icon">📅</span>
                            Datums un laiks
                        </h3>
                        <div class="form-grid">
                            <div class="form-field">
                                <label for="date">Datums *</label>
                                @if($isOfferSchedule && !empty($offer->event_date))
                                    <input type="date"
                                           id="date"
                                           name="date"
                                           value="{{ $defaultDateValue }}"
                                           readonly
                                           required>
                                    <small style="color:#777;">Datums fiksēts: {{ \Carbon\Carbon::parse($offer->event_date)->format('d.m.Y') }}</small>
                                @else
                                    <input type="date"
                                           id="date"
                                           name="date"
                                           value="{{ $defaultDateValue }}"
                                           min="{{ $minDate }}"
                                           required>
                                    <small style="color:#777;">Rezervācijas pieejamas tikai darba dienās un sākot ar rītdienu.</small>
                                @endif
                            </div>
                            <div class="form-field">
                                <label for="time">Laiks *</label>
                                @if($isOfferSchedule && !empty($timeSlots))
                                    <select id="time" name="time" required>
                                        <option value="">-- Izvēlies laiku --</option>
                                        @foreach($timeSlots as $slot)
                                            @php
                                                $taken = in_array($slot, $takenSlots ?? []);
                                                $selected = old('time') === $slot;
                                            @endphp
                                            <option value="{{ $slot }}"
                                                    {{ $selected ? 'selected' : '' }}
                                                    {{ $taken ? 'disabled' : '' }}>
                                                {{ $slot }}{{ $taken ? ' (aizņemts)' : '' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if(!empty($takenSlots))
                                        <small style="color:#777;">Pelēkie laiki jau ir aizņemti.</small>
                                    @endif
                                @else
                                    <select id="time" name="time" required>
                                        <option value="">-- Izvēlies laiku --</option>
                                        @foreach($generalTimeSlots as $slot)
                                            <option value="{{ $slot }}" @selected(old('time') === $slot)>{{ $slot }}</option>
                                        @endforeach
                                    </select>
                                    <small style="color:#777;">Pieejami laiki darba dienās: 9:00, 11:00, 13:00, 15:00, 17:00 un 19:00.</small>
                                @endif
                            </div>
                        </div>
                        <div class="info-box">
                            💡 Ieteicams rezervēt vismaz 2 dienas iepriekš. Darba laiks: Pirmdiena-Piektdiena 9:00-19:00 (brīvdienās slēgts).
                        </div>
                    </div>

                    <!-- Services -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <span class="section-icon">✨</span>
                            Izvēlies pakalpojumus
                        </h3>
                        <div class="services-grid" id="servicesGrid">
                            @foreach($services as $service)
                                @php
                                    $inputId = 'service-' . $service->slug;
                                @endphp
                                <div class="service-option">
                                    <input type="checkbox"
                                           id="{{ $inputId }}"
                                           name="services[]"
                                           value="{{ $service->slug }}"
                                           data-price="{{ $service->base_price }}"
                                           data-name="{{ $service->name }}">
                                    <label for="{{ $inputId }}" class="service-label">
                                        <div class="icon">{{ $service->icon ?? '✨' }}</div>
                                        <div class="name">{{ $service->name }}</div>
                                        <div class="price">no €{{ number_format($service->base_price, 0) }}</div>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <div class="info-box" style="margin-top: 1rem;">
                            💡 Pilns detailing komplekts un VIP programma ir pilni pakalpojumu komplekti, tāpēc tos nevar apvienot ar citiem pakalpojumiem.
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
                            <span>Virsbūves stāvoklis</span>
                            <span id="summaryBodyCondition">Nav izvēlēts</span>
                        </div>
                        <div class="summary-item">
                            <span>Salona materiāls</span>
                            <span id="summaryInteriorMaterial">Nav izvēlēts</span>
                        </div>
                        <div class="summary-item">
                            <span>Salona stāvoklis</span>
                            <span id="summaryInteriorCondition">Nav izvēlēts</span>
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

    <script>
        // Price Calculator
        const bookingForm = document.getElementById('bookingForm');
        const totalField = document.getElementById('totalField');
        const carHiddenInput = document.getElementById('car');
        const carDisplayInput = document.getElementById('carDisplay');
        const carSuggestionData = Array.from(document.querySelectorAll('#carSuggestions option')).map(option => {
            const label = (option.value || '').trim();
            const name = (option.dataset.name || label).trim();
            const multiplier = parseFloat(option.dataset.multiplier) || 1;
            return {
                label,
                name,
                multiplier,
                labelLower: label.toLowerCase(),
                nameLower: name.toLowerCase(),
            };
        });
        let selectedCar = null;
        const bodyConditionSelect = document.getElementById('bodyCondition');
        const interiorMaterialSelect = document.getElementById('interiorMaterial');
        const interiorConditionSelect = document.getElementById('interiorCondition');
        const serviceCheckboxes = document.querySelectorAll('input[name="services[]"]');
        const exclusiveServiceSlugs = ['pilns-detailing-komplekts', 'vip-programma'];
        const interiorServiceSlugs = ['salona-dzila-tirisana', 'pilns-detailing-komplekts', 'vip-programma'];
        const bodyConditionMultipliers = {
            normal: 1,
            dirty: 1.1,
            very_dirty: 1.25,
        };
        const interiorMaterialMultipliers = {
            fabric: 1,
            leather: 1.1,
            alcantara: 1.15,
        };
        const interiorConditionMultipliers = {
            fresh: 1,
            used: 1.1,
            dirty: 1.2,
        };
        const totalPriceEl = document.getElementById('totalPrice');
        
        // Summary elements
        const summaryCarEl = document.getElementById('summaryCar');
        const summaryBodyConditionEl = document.getElementById('summaryBodyCondition');
        const summaryInteriorMaterialEl = document.getElementById('summaryInteriorMaterial');
        const summaryInteriorConditionEl = document.getElementById('summaryInteriorCondition');
        const summaryServicesEl = document.getElementById('summaryServices');
        const summaryDateEl = document.getElementById('summaryDate');
        const dateField = document.getElementById('date');
        const timeField = document.getElementById('time');
        const usesOfferSchedule = @json($isOfferSchedule);
        const minBookingDate = @json($isOfferSchedule ? null : $minDate);
        const generalBookedSlots = @json($generalBookedSlots);

        function getSelectedServiceSlugs() {
            return Array.from(serviceCheckboxes)
                .filter(cb => cb.checked)
                .map(cb => cb.value);
        }

        function requiresInteriorDetails() {
            return getSelectedServiceSlugs().some(slug => interiorServiceSlugs.includes(slug));
        }

        function hasBaseVehicleDetails() {
            return Boolean(carHiddenInput.value && bodyConditionSelect?.value);
        }

        function hasInteriorDetails() {
            return Boolean(interiorMaterialSelect?.value && interiorConditionSelect?.value);
        }

        function hasAllRequiredVehicleDetails() {
            if (!hasBaseVehicleDetails()) return false;
            if (requiresInteriorDetails() && !hasInteriorDetails()) return false;
            return true;
        }

        function updateInteriorRequirementState() {
            const required = requiresInteriorDetails();
            if (interiorMaterialSelect) {
                interiorMaterialSelect.required = required;
            }
            if (interiorConditionSelect) {
                interiorConditionSelect.required = required;
                if (!required) {
                    interiorConditionSelect.disabled = !interiorMaterialSelect?.value;
                }
            }
        }

        function updateGeneralTimeAvailability() {
            if (usesOfferSchedule || !timeField) {
                return;
            }

            const selectedDate = dateField?.value;
            const takenList = selectedDate && generalBookedSlots[selectedDate]
                ? generalBookedSlots[selectedDate]
                : [];

            let selectionCleared = false;

            Array.from(timeField.options).forEach(option => {
                if (!option.value) {
                    return;
                }
                const isTaken = takenList.includes(option.value);
                option.disabled = isTaken;
                option.textContent = option.value + (isTaken ? ' (aizņemts)' : '');

                if (isTaken && option.selected) {
                    option.selected = false;
                    selectionCleared = true;
                }
            });

            if (!selectedDate) {
                Array.from(timeField.options).forEach(option => {
                    if (!option.value) return;
                    option.disabled = false;
                    option.textContent = option.value;
                });
            }

            if (selectionCleared) {
                timeField.value = '';
                showMessage('Šis laiks tika rezervēts. Lūdzu izvēlies citu pieejamo laiku.', 'error');
            }
        }

        function calculateTotal() {
            let basePrice = 0;
            let selectedCount = 0;
            let selectedNames = [];

            // Get selected services
            serviceCheckboxes.forEach(cb => {
                if (cb.checked) {
                    basePrice += parseFloat(cb.dataset.price);
                    selectedCount++;
                    selectedNames.push(cb.dataset.name);
                }
            });

            // Apply multipliers
            const carMultiplier = selectedCar?.multiplier || 1;
            const bodyConditionMultiplier = bodyConditionMultipliers[bodyConditionSelect?.value] ?? 1;
            const interiorRequired = requiresInteriorDetails();
            const interiorMaterialMultiplier = interiorRequired && interiorMaterialSelect?.value
                ? interiorMaterialMultipliers[interiorMaterialSelect.value] ?? 1
                : 1;
            const interiorConditionMultiplier = interiorRequired && interiorConditionSelect?.value
                ? interiorConditionMultipliers[interiorConditionSelect.value] ?? 1
                : 1;

            const total = basePrice * carMultiplier * bodyConditionMultiplier * interiorMaterialMultiplier * interiorConditionMultiplier;
            totalPriceEl.textContent = '€' + total.toFixed(2);
            if (totalField) {
                totalField.value = total.toFixed(2);
            }

            summaryServicesEl.textContent = selectedCount
                ? selectedNames.join(', ')
                : 'Nav izvēlēts';
        }

        function updateSummary() {
            // Car size
            const carText = selectedCar?.label || (carDisplayInput.value?.trim() || '');
            summaryCarEl.textContent = carText || 'Nav izvēlēts';

            // Body condition
            const bodyConditionText = bodyConditionSelect?.options[bodyConditionSelect.selectedIndex]?.text || 'Nav izvēlēts';
            summaryBodyConditionEl.textContent = bodyConditionText;

            // Interior material
            const interiorMaterialText = interiorMaterialSelect?.options[interiorMaterialSelect.selectedIndex]?.text || 'Nav izvēlēts';
            summaryInteriorMaterialEl.textContent = interiorMaterialText;

            // Interior condition
            const interiorConditionText = interiorConditionSelect?.options[interiorConditionSelect.selectedIndex]?.text || 'Nav izvēlēts';
            summaryInteriorConditionEl.textContent = interiorConditionText;

            // Date
            const dateValue = dateField ? dateField.value : '';
            const timeValue = timeField ? timeField.value : '';
            let dateLabel = '';

            if (dateField) {
                if (dateField.tagName === 'SELECT') {
                    dateLabel = dateField.options[dateField.selectedIndex]?.text || '';
                } else {
                    dateLabel = formatDateForDisplay(dateField.value);
                }
            }

            if (dateLabel && timeValue) {
                summaryDateEl.textContent = `${dateLabel} ${timeValue}`;
            } else if (dateLabel) {
                summaryDateEl.textContent = dateLabel;
            } else {
                summaryDateEl.textContent = 'Nav izvēlēts';
            }

            calculateTotal();
        }

        // Event listeners
        function findCarMatch(value) {
            const normalized = (value || '').toLowerCase().trim();
            if (!normalized) {
                return null;
            }

            return carSuggestionData.find(option =>
                option.labelLower === normalized || option.nameLower === normalized
            ) || null;
        }

        function handleCarInput() {
            const match = findCarMatch(carDisplayInput.value);

            if (match) {
                selectedCar = match;
                carHiddenInput.value = match.name;
            } else {
                selectedCar = null;
                carHiddenInput.value = '';
            }

            updateSummary();
        }

        function parseDate(value) {
            return value ? new Date(`${value}T00:00:00`) : null;
        }

        function formatDateForDisplay(value) {
            if (!value) return '';
            const date = parseDate(value);
            if (!date) return value;
            return date.toLocaleDateString('lv-LV', {
                weekday: 'long',
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
            });
        }

        function isWeekendDate(date) {
            if (!date) return false;
            const day = date.getDay();
            return day === 0 || day === 6;
        }

        function ensureValidDate(showFeedback = true) {
            if (!dateField || usesOfferSchedule) {
                updateSummary();
                return;
            }

            if (!dateField.value) {
                updateSummary();
                updateGeneralTimeAvailability();
                return;
            }

            const selectedDate = parseDate(dateField.value);
            const minDate = minBookingDate ? parseDate(minBookingDate) : null;

            if (minDate && selectedDate < minDate) {
                if (showFeedback) {
                    showMessage('Rezervācijas iespējamas sākot ar rītdienu.', 'error');
                }
                dateField.value = '';
                updateSummary();
                updateGeneralTimeAvailability();
                return;
            }

            if (isWeekendDate(selectedDate)) {
                if (showFeedback) {
                    showMessage('Brīvdienās nestrādājam. Lūdzu izvēlies darba dienu.', 'error');
                }
                dateField.value = '';
                updateSummary();
                updateGeneralTimeAvailability();
                return;
            }

            updateSummary();
            updateGeneralTimeAvailability();
        }

        function updateInteriorConditionState() {
            if (!interiorMaterialSelect || !interiorConditionSelect) {
                return;
            }

            const hasMaterial = !!interiorMaterialSelect.value;
            if (!hasMaterial) {
                interiorConditionSelect.value = '';
                interiorConditionSelect.disabled = true;
            } else {
                interiorConditionSelect.disabled = false;
            }
        }

        function enforceServiceRules(triggerSummary = true) {
            if (!serviceCheckboxes.length) {
                if (triggerSummary) updateSummary();
                return;
            }

            if (!hasBaseVehicleDetails()) {
                serviceCheckboxes.forEach(cb => {
                    cb.checked = false;
                    cb.disabled = true;
                });
                if (triggerSummary) {
                    updateSummary();
                }
                return;
            }

            serviceCheckboxes.forEach(cb => {
                cb.disabled = false;
            });

            const selectedExclusive = [];
            let hasStandard = false;

            serviceCheckboxes.forEach(cb => {
                const isExclusive = exclusiveServiceSlugs.includes(cb.value);
                if (isExclusive && cb.checked) {
                    selectedExclusive.push(cb);
                }
                if (!isExclusive && cb.checked) {
                    hasStandard = true;
                }
            });

            if (selectedExclusive.length > 0) {
                const keep = selectedExclusive[0];
                serviceCheckboxes.forEach(cb => {
                    const isExclusive = exclusiveServiceSlugs.includes(cb.value);
                    if (isExclusive) {
                        cb.disabled = cb !== keep;
                        if (cb !== keep && cb.checked) {
                            cb.checked = false;
                        }
                    } else {
                        if (cb.checked) {
                            cb.checked = false;
                        }
                        cb.disabled = true;
                    }
                });
            } else if (hasStandard) {
                serviceCheckboxes.forEach(cb => {
                    const isExclusive = exclusiveServiceSlugs.includes(cb.value);
                    if (isExclusive) {
                        if (cb.checked) {
                            cb.checked = false;
                        }
                        cb.disabled = true;
                    } else {
                        cb.disabled = false;
                    }
                });
            } else {
                serviceCheckboxes.forEach(cb => {
                    cb.disabled = false;
                });
            }

            updateInteriorRequirementState();

            if (triggerSummary) {
                updateSummary();
            }
        }

        carDisplayInput.addEventListener('input', () => {
            handleCarInput();
            enforceServiceRules(false);
        });
        carDisplayInput.addEventListener('change', () => {
            handleCarInput();
            enforceServiceRules(false);
        });
        if (bodyConditionSelect) {
            bodyConditionSelect.addEventListener('change', () => {
                updateSummary();
                enforceServiceRules(false);
            });
        }
        if (interiorMaterialSelect) {
            interiorMaterialSelect.addEventListener('change', () => {
                updateInteriorConditionState();
                updateSummary();
                enforceServiceRules(false);
            });
        }
        if (interiorConditionSelect) {
            interiorConditionSelect.addEventListener('change', () => {
                updateSummary();
                enforceServiceRules(false);
            });
        }
        serviceCheckboxes.forEach(cb => cb.addEventListener('change', () => {
            enforceServiceRules(true);
        }));
        if (dateField) {
            dateField.addEventListener('change', () => ensureValidDate(true));
            dateField.addEventListener('input', () => ensureValidDate(false));
        }
        if (timeField) {
            timeField.addEventListener('change', updateSummary);
        }

        // Form submission
        if (bookingForm) {
            bookingForm.addEventListener('submit', function(e) {
                let isValid = true;

                const hasService = Array.from(serviceCheckboxes).some(cb => cb.checked);
                if (!hasService) {
                    showMessage('Lūdzu izvēlies vismaz vienu pakalpojumu', 'error');
                    isValid = false;
                }

                if (isValid && !carHiddenInput.value) {
                    showMessage('Lūdzu izvēlies auto modeli no saraksta', 'error');
                    carDisplayInput.focus();
                    isValid = false;
                }

                if (isValid && !usesOfferSchedule) {
                    ensureValidDate(false);
                    if (!dateField || !dateField.value) {
                        showMessage('Lūdzu izvēlies pieejamo darba dienu no kalendāra', 'error');
                        if (dateField) {
                            dateField.focus();
                        }
                        isValid = false;
                    }
                }

                if (isValid && (!timeField || !timeField.value)) {
                    showMessage('Lūdzu izvēlies pieejamo laiku', 'error');
                    if (timeField) {
                        timeField.focus();
                    }
                    isValid = false;
                }

                if (isValid && !hasAllRequiredVehicleDetails()) {
                    showMessage('Lūdzu aizpildi auto informāciju (un salona sadaļu, ja izvēlies atbilstošus pakalpojumus)', 'error');
                    isValid = false;
                }

                if (!isValid) {
                    e.preventDefault();
                    return;
                }

                if (totalField) {
                    totalField.value = totalPriceEl.textContent.replace('€', '').trim();
                }
            });
        }

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

        // Check for offer in URL
        const offerId = urlParams.get('offer');
        if (offerId) {
            document.getElementById('offerBanner').style.display = 'block';
            // In real implementation, fetch offer details
        }

        // Initialize summary totals on load
        handleCarInput();
        if (usesOfferSchedule) {
            updateSummary();
        } else {
            ensureValidDate(false);
        }
        updateInteriorConditionState();
        enforceServiceRules(false);
    </script>
</body>
</html>
