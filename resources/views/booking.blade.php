@extends('layouts.public')

@section('title', 'Rezervēt vizīti - Auto Detailing Workshop')

@section('content')

    <div class="container">
        <!-- Lapas virsraksts un īss apraksts -->
        <div class="page-header">
            <h1>Rezervē savu vizīti</h1>
            <p>Aizpildi formu un saņem apstiprinājumu dažu minūšu laikā</p>
        </div>

        <!-- Sistēmas paziņojumi par veiksmēm/kļūdām -->
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
            <!-- Galvenā rezervācijas forma -->
            <div class="booking-form">
                <form id="bookingForm" method="POST" action="{{ route('booking.store') }}">
                    @csrf
                    <!-- Slēptais lauks kopējai summai, ko aizpilda JS -->
                    <input type="hidden" id="totalField" name="total" value="{{ old('total', '0') }}">
                    <!-- Personas dati -->
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
                                <input type="tel" id="phone" name="customer_phone" value="{{ old('customer_phone') }}" required inputmode="tel" maxlength="14" pattern="^\+?\d{1,13}$" placeholder="+37120000000">
                                <small id="phoneError" class="field-error" style="display:none;"></small>
                            </div>
                        </div>
                        <div class="form-field">
                            <label for="email">E-pasts</label>
                            <input type="email" id="email" name="customer_email" value="{{ old('customer_email', auth()->user()->email ?? '') }}">
                        </div>
                    </div>

                    <!-- Auto informācija -->
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

                    <!-- Datums un laiks -->
                    @php
                        $minDate = $minBookingDate ?? \Carbon\Carbon::tomorrow()->format('Y-m-d');
                        $defaultDateValue = old('date', $minDate);
                    @endphp
                    <div class="form-section">
                        <h3 class="section-title">
                            <span class="section-icon">📅</span>
                            Datums un laiks
                        </h3>
                        <div class="form-grid">
                            <div class="form-field">
                                <label for="date">Datums *</label>
                                <input type="date"
                                       id="date"
                                       name="date"
                                       value="{{ $defaultDateValue }}"
                                       min="{{ $minDate }}"
                                       required>
                                <small style="color:#777;">Rezervācijas pieejamas tikai darba dienās un sākot ar rītdienu.</small>
                            </div>
                            <div class="form-field">
                                <label for="time">Laiks *</label>
                                <select id="time" name="time" required>
                                    <option value="">-- Izvēlies laiku --</option>
                                    @foreach($generalTimeSlots as $slot)
                                        <option value="{{ $slot }}" @selected(old('time') === $slot)>{{ $slot }}</option>
                                    @endforeach
                                </select>
                                <small style="color:#777;">Pieejami laiki darba dienās: 9:00, 11:00, 13:00, 15:00, 17:00 un 19:00.</small>
                            </div>
                        </div>
                        <div class="info-box">
                            💡 Ieteicams rezervēt vismaz 2 dienas iepriekš. Darba laiks: Pirmdiena-Piektdiena 9:00-19:00 (brīvdienās slēgts).
                        </div>
                    </div>

                    <!-- Pakalpojumu izvēle -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <span class="section-icon">✨</span>
                            Izvēlies pakalpojumus
                        </h3>
                        @php
                            $oldServices = collect(old('services', []))->map(fn ($value) => (string) $value)->all();
                        @endphp
                        <div class="services-grid" id="servicesGrid">
                            @foreach($services as $service)
                                @php
                                    $inputId = 'service-' . $service->slug;
                                @endphp
                                <div class="service-option">
                                    <input type="checkbox"
                                           id="{{ $inputId }}"
                                           name="services[]"
                                           value="{{ $service->id }}"
                                           data-price="{{ $service->base_price }}"
                                           data-slug="{{ $service->slug }}"
                                           data-name="{{ $service->name }}"
                                           @checked(in_array((string) $service->id, $oldServices, true))>
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

            <!-- Kopsavilkuma sānu panelis -->
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

    <!-- Iekšējie stili: CSS novietots pēc HTML, lai atdalītu struktūru no noformējuma -->
@push('styles')
    <style>
        /* Globāla nullēšana un kastes modelis vienkāršākai izkārtošanai */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Krāsu mainīgie un pamattoni visai lapai */
        :root {
            --accent: #ff5c35;
            --accent-dark: #d9461f;
            --accent-light: #fff1ec;
            --ink: #1a1a1a;
        }

        /* Pamatteksta stils un fons */
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            color: var(--ink);
            background: #fafafa;
        }

        /* Konteiners, kas nosaka satura platumu un iekšējo atstarpi */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 3rem 2rem;
        }

        /* Lapas virsraksta bloks */
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

        /* Rezervācijas formas izkārtojums ar sānu kopsavilkumu */
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

        /* Pakalpojumu izvēles kartītes */
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

        /* Kopsavilkuma sānjosla */
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

        /* Rezervācijas apstiprināšanas poga */
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

        /* Paziņojumu (veiksmes/kļūdas) bloki */
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

        .field-error {
            color: #b5302c;
            font-size: 0.85rem;
            margin-top: 0.4rem;
            display: block;
        }

        /* Responsivitāte planšetēm un telefoniem */
        @media (max-width: 968px) {
            .booking-layout {
                grid-template-columns: 1fr;
            }

            .booking-summary {
                position: static;
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

        /* Ielādes stāvokļa indikators (deaktivē klikšķus) */
        .loading {
            opacity: 0.6;
            pointer-events: none;
        }

        /* Informatīvās piezīmes lietotājam */
        .info-box {
            background: #f8f9fa;
            border-left: 4px solid var(--accent);
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
        }

    </style>
@endpush

@push('scripts')
    <!-- Aprēķinu un kopsavilkuma loģika rezervācijas formai -->
    <script>
        // Price Calculator
        // Galvenie formas un UI elementi, kurus atjaunojam ar JS.
        const bookingForm = document.getElementById('bookingForm');
        const totalField = document.getElementById('totalField');
        const carHiddenInput = document.getElementById('car');
        const carDisplayInput = document.getElementById('carDisplay');
        const phoneInput = document.getElementById('phone');
        const phoneError = document.getElementById('phoneError');
        // Datu saraksts ar auto modeļiem un cenu koeficientiem no <datalist>.
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
        // Pašlaik izvēlētais auto (objekts no carSuggestionData).
        let selectedCar = null;
        // Nolasa izvēlēto virsbūves/salona stāvokli un pakalpojumus.
        const bodyConditionSelect = document.getElementById('bodyCondition');
        const interiorMaterialSelect = document.getElementById('interiorMaterial');
        const interiorConditionSelect = document.getElementById('interiorCondition');
        const serviceCheckboxes = document.querySelectorAll('input[name="services[]"]');
        // Pakalpojumu grupas, kam ir īpaši noteikumi.
        // Ekskluzīvie pakalpojumi ir pilnie komplekti, kurus nedrīkst kombinēt ar citiem.
        const exclusiveServiceSlugs = ['pilns-detailing-komplekts', 'vip-programma'];
        // Šie pakalpojumi prasa papildu informāciju par salonu.
        const interiorServiceSlugs = ['salona-dzila-tirisana', 'pilns-detailing-komplekts', 'vip-programma'];
        // Koeficienti cenu korekcijai pēc auto stāvokļa.
        const bodyConditionMultipliers = {
            normal: 1,
            dirty: 1.1,
            very_dirty: 1.25,
        };
        // Koeficienti salona materiālam.
        const interiorMaterialMultipliers = {
            fabric: 1,
            leather: 1.1,
            alcantara: 1.15,
        };
        // Koeficienti salona stāvoklim.
        const interiorConditionMultipliers = {
            fresh: 1,
            used: 1.1,
            dirty: 1.2,
        };
        // Kopsummas vizuālais elements.
        const totalPriceEl = document.getElementById('totalPrice');
        
        // Kopsavilkuma sadaļas elementi (parādām izvēles).
        const summaryCarEl = document.getElementById('summaryCar');
        const summaryBodyConditionEl = document.getElementById('summaryBodyCondition');
        const summaryInteriorMaterialEl = document.getElementById('summaryInteriorMaterial');
        const summaryInteriorConditionEl = document.getElementById('summaryInteriorCondition');
        const summaryServicesEl = document.getElementById('summaryServices');
        const summaryDateEl = document.getElementById('summaryDate');
        const dateField = document.getElementById('date');
        const timeField = document.getElementById('time');
        // Minimālais datums parastām rezervācijām.
        const minBookingDate = @json($minDate);
        // Jau aizņemtie laiki pa datumiem (tikai parastajiem booking).
        const generalBookedSlots = @json($generalBookedSlots);

        // Telefona numura pamata validācija (max 13 cipari, optional + sākumā).
        function validatePhoneField(shouldNotify) {
            if (!phoneInput) {
                return true;
            }

            const rawValue = phoneInput.value.trim();
            const digitsOnly = rawValue.replace(/\D/g, '');
            let message = '';

            if (rawValue.length > 0 && !/^\+?\d*$/.test(rawValue)) {
                message = 'Atļauti tikai cipari un + sākumā.';
            } else if (digitsOnly.length > 13) {
                message = 'Telefona numurs ir par garu (maks. 13 cipari).';
            }

            if (digitsOnly.length > 13 && rawValue.length > 0) {
                const trimmedDigits = digitsOnly.slice(0, 13);
                phoneInput.value = (rawValue.startsWith('+') ? '+' : '') + trimmedDigits;
            }

            phoneInput.setCustomValidity(message);
            if (phoneError) {
                phoneError.textContent = message;
                phoneError.style.display = message ? 'block' : 'none';
            }

            if (shouldNotify && message) {
                showMessage(message, 'error');
            }

            return message === '';
        }

        // Izvelk atzīmēto pakalpojumu slugus.
        function getSelectedServiceSlugs() {
            return Array.from(serviceCheckboxes)
                .filter(cb => cb.checked)
                .map(cb => cb.dataset.slug);
        }

        // Nosaka, vai izvēlēto pakalpojumu dēļ ir jāprasa salona materiāls un stāvoklis.
        function requiresInteriorDetails() {
            return getSelectedServiceSlugs().some(slug => interiorServiceSlugs.includes(slug));
        }

        // Pārbauda, vai aizpildīti pamatdati (auto + virsbūves stāvoklis).
        function hasBaseVehicleDetails() {
            return Boolean(carHiddenInput.value && bodyConditionSelect?.value);
        }

        // Pārbauda, vai aizpildīti salona dati (materiāls + stāvoklis).
        function hasInteriorDetails() {
            return Boolean(interiorMaterialSelect?.value && interiorConditionSelect?.value);
        }

        // Apvienotā pārbaude visiem obligātajiem auto datiem.
        function hasAllRequiredVehicleDetails() {
            if (!hasBaseVehicleDetails()) return false;
            if (requiresInteriorDetails() && !hasInteriorDetails()) return false;
            return true;
        }

        // Dinamiski ieslēdz/izslēdz salona lauku obligātumu.
        // Ja izvēlēts salona pakalpojums, materiāls un stāvoklis kļūst obligāti.
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

        // Pārbauda pieejamos laikus konkrētajam datumam (parastajiem booking).
        function updateGeneralTimeAvailability() {
            if (!timeField) {
                return;
            }

            const selectedDate = dateField?.value;
            const takenList = selectedDate && generalBookedSlots[selectedDate]
                ? generalBookedSlots[selectedDate]
                : [];

            // Atspējo aizņemtos laikus un pieliek norādi tekstā.
            Array.from(timeField.options).forEach(option => {
                if (!option.value) {
                    return;
                }
                const isTaken = takenList.includes(option.value);
                option.disabled = isTaken;
                option.textContent = option.value + (isTaken ? ' (aizņemts)' : '');
            });

            // Ja datums nav izvēlēts, atjauno visus laikus.
            if (!selectedDate) {
                Array.from(timeField.options).forEach(option => {
                    if (!option.value) return;
                    option.disabled = false;
                    option.textContent = option.value;
                });
            }
        }

        // Aprēķina kopsummu pēc izvēlētajiem pakalpojumiem un koeficientiem.
        function calculateTotal() {
            let basePrice = 0;
            let selectedCount = 0;
            let selectedNames = [];

            // Apkopo izvēlētos pakalpojumus un to cenas.
            // Atļauj izvēli, ja pamatdati ir aizpildīti.
            serviceCheckboxes.forEach(cb => {
                if (cb.checked) {
                    basePrice += parseFloat(cb.dataset.price);
                    selectedCount++;
                    selectedNames.push(cb.dataset.name);
                }
            });

            // Pielieto koeficientus (auto izmērs + stāvokļi).
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

        // Atjauno kopsavilkuma laukus un pārrēķina cenu.
        function updateSummary() {
            // Auto modelis / izmērs kopsavilkumā.
            const carText = selectedCar?.label || (carDisplayInput.value?.trim() || '');
            summaryCarEl.textContent = carText || 'Nav izvēlēts';

            // Virsbūves stāvoklis kopsavilkumā.
            const bodyConditionText = bodyConditionSelect?.options[bodyConditionSelect.selectedIndex]?.text || 'Nav izvēlēts';
            summaryBodyConditionEl.textContent = bodyConditionText;

            // Salona materiāls kopsavilkumā.
            const interiorMaterialText = interiorMaterialSelect?.options[interiorMaterialSelect.selectedIndex]?.text || 'Nav izvēlēts';
            summaryInteriorMaterialEl.textContent = interiorMaterialText;

            // Salona stāvoklis kopsavilkumā.
            const interiorConditionText = interiorConditionSelect?.options[interiorConditionSelect.selectedIndex]?.text || 'Nav izvēlēts';
            summaryInteriorConditionEl.textContent = interiorConditionText;

            // Datums un laiks kopsavilkumā.
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

            // Pēc teksta atjaunošanas pārrēķina cenu.
            calculateTotal();
        }

        // Meklē atbilstošu auto ierakstu datalist sarakstā.
        function findCarMatch(value) {
            const normalized = (value || '').toLowerCase().trim();
            if (!normalized) {
                return null;
            }

            return carSuggestionData.find(option =>
                option.labelLower === normalized || option.nameLower === normalized
            ) || null;
        }

        // Sinhronizē auto lauka vērtību ar slēpto "car" lauku.
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

        // Pārvērš datuma virkni par Date objektu.
        function parseDate(value) {
            return value ? new Date(`${value}T00:00:00`) : null;
        }

        // Formatē datumu latviskā, cilvēkam lasāmā formā.
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

        // Nosaka, vai izvēlētais datums iekrīt brīvdienā.
        function isWeekendDate(date) {
            if (!date) return false;
            const day = date.getDay();
            return day === 0 || day === 6;
        }

        // Validē datumu un atjauno laiku pieejamību.
        function ensureValidDate(showFeedback = true) {
            if (!dateField) {
                updateSummary();
                return;
            }

            if (!dateField.value) {
                // Nav izvēlēts datums — atjauno kopsavilkumu un laiku sarakstu.
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
                // Notīra nepareizu datumu.
                dateField.value = '';
                updateSummary();
                updateGeneralTimeAvailability();
                return;
            }

            if (isWeekendDate(selectedDate)) {
                if (showFeedback) {
                    showMessage('Brīvdienās nestrādājam. Lūdzu izvēlies darba dienu.', 'error');
                }
                // Notīra brīvdienu izvēli.
                dateField.value = '';
                updateSummary();
                updateGeneralTimeAvailability();
                return;
            }

            updateSummary();
            updateGeneralTimeAvailability();
        }

        // Ieslēdz/izslēdz salona stāvokļa izvēli pēc materiāla izvēles.
        function updateInteriorConditionState() {
            if (!interiorMaterialSelect || !interiorConditionSelect) {
                return;
            }

            const hasMaterial = !!interiorMaterialSelect.value;
            if (!hasMaterial) {
                // Ja nav materiāla, salona stāvoklis nav pieejams.
                interiorConditionSelect.value = '';
                interiorConditionSelect.disabled = true;
            } else {
                // Ja materiāls ir izvēlēts, ļauj izvēlēties stāvokli.
                interiorConditionSelect.disabled = false;
            }
        }

        // Uzliek pakalpojumu kombināciju noteikumus rezervācijas formā.
        // Funkcija neļauj lietotājam frontendā izvēlēties neatļautas pakalpojumu kombinācijas.
        function enforceServiceRules(triggerSummary = true) {
            if (!serviceCheckboxes.length) {
                if (triggerSummary) updateSummary();
                return;
            }

            if (!hasBaseVehicleDetails()) {
                // Kamēr nav izvēlēts auto modelis un virsbūves stāvoklis,
                // pakalpojumu izvēle tiek pilnībā bloķēta.
                serviceCheckboxes.forEach(cb => {
                    cb.checked = false;
                    cb.disabled = true;
                });
                if (triggerSummary) {
                    updateSummary();
                }
                return;
            }

            // Ja pamatdati ir aizpildīti, sākumā atbloķējam visas izvēles,
            // un pēc tam piemērojam kombināciju ierobežojumus.
            serviceCheckboxes.forEach(cb => {
                cb.disabled = false;
            });

            const selectedExclusive = [];
            let hasStandard = false;

            serviceCheckboxes.forEach(cb => {
                // Katram pakalpojumam nosaka, vai tas ir ekskluzīvs komplekts.
                const isExclusive = exclusiveServiceSlugs.includes(cb.dataset.slug);

                // Saglabā izvēlētos ekskluzīvos pakalpojumus atsevišķi,
                // lai pēc tam varētu bloķēt pārējās izvēles.
                if (isExclusive && cb.checked) {
                    selectedExclusive.push(cb);
                }

                // Ja izvēlēts kaut viens standarta pakalpojums,
                // ekskluzīvie komplekti vairs nedrīkst būt pieejami.
                if (!isExclusive && cb.checked) {
                    hasStandard = true;
                }
            });

            // Ja izvēlēts ekskluzīvs pakalpojums, drīkst palikt aktīvs tikai tas viens.
            // Visi pārējie pakalpojumi tiek atspējoti, jo pilnais komplekts nav kombinējams.
            if (selectedExclusive.length > 0) {
                const keep = selectedExclusive[0];
                serviceCheckboxes.forEach(cb => {
                    const isExclusive = exclusiveServiceSlugs.includes(cb.dataset.slug);
                    if (isExclusive) {
                        // Atstāj pieejamu tikai jau izvēlēto ekskluzīvo pakalpojumu.
                        cb.disabled = cb !== keep;
                        if (cb !== keep && cb.checked) {
                            cb.checked = false;
                        }
                    } else {
                        // Standarta pakalpojumi kopā ar ekskluzīvo komplektu nav atļauti.
                        if (cb.checked) {
                            cb.checked = false;
                        }
                        cb.disabled = true;
                    }
                });
            } else if (hasStandard) {
                // Ja izvēlēti standarta pakalpojumi, tie savā starpā drīkst kombinēties,
                // taču ekskluzīvie komplekti tiek bloķēti.
                serviceCheckboxes.forEach(cb => {
                    const isExclusive = exclusiveServiceSlugs.includes(cb.dataset.slug);
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
                // Ja nekas nav izvēlēts, lietotājs var sākt izvēli no jauna.
                serviceCheckboxes.forEach(cb => {
                    cb.disabled = false;
                });
            }

            // Pēc pakalpojumu maiņas pārbauda,
            // vai tagad jāpadara salona lauki obligāti.
            updateInteriorRequirementState();

            if (triggerSummary) {
                // Ja nepieciešams, uzreiz atjauno rezervācijas kopsavilkumu un cenu.
                updateSummary();
            }
        }

        // Klausītāji auto lauka ievadei (sinhronizē izvēli ar slēpto lauku).
        carDisplayInput.addEventListener('input', () => {
            handleCarInput();
            enforceServiceRules(false);
        });
        carDisplayInput.addEventListener('change', () => {
            handleCarInput();
            enforceServiceRules(false);
        });
        // Virsbūves stāvokļa maiņa ietekmē cenu un noteikumus.
        if (bodyConditionSelect) {
            bodyConditionSelect.addEventListener('change', () => {
                updateSummary();
                enforceServiceRules(false);
            });
        }
        // Salona materiāls ietekmē stāvokļa pieejamību un cenu.
        if (interiorMaterialSelect) {
            interiorMaterialSelect.addEventListener('change', () => {
                updateInteriorConditionState();
                updateSummary();
                enforceServiceRules(false);
            });
        }
        // Salona stāvokļa maiņa ietekmē cenu.
        if (interiorConditionSelect) {
            interiorConditionSelect.addEventListener('change', () => {
                updateSummary();
                enforceServiceRules(false);
            });
        }
        // Pakalpojumu izvēle ietekmē cenu un kombināciju noteikumus.
        serviceCheckboxes.forEach(cb => cb.addEventListener('change', () => {
            enforceServiceRules(true);
        }));
        // Datuma izvēlei validācija un laiku filtrēšana.
        if (dateField) {
            dateField.addEventListener('change', () => ensureValidDate(true));
        }
        // Laika izvēle atjauno kopsavilkumu.
        if (timeField) {
            timeField.addEventListener('change', updateSummary);
        }
        // Formas iesniegšanas validācija pirms nosūtīšanas.
        if (bookingForm) {
            bookingForm.addEventListener('submit', function(e) {
                let isValid = true;

                // Pārbauda, vai ir izvēlēts vismaz viens pakalpojums.
                const hasService = Array.from(serviceCheckboxes).some(cb => cb.checked);
                if (!hasService) {
                    showMessage('Lūdzu izvēlies vismaz vienu pakalpojumu.', 'error');
                    isValid = false;
                }

                // Pārbauda, vai auto modelis ir izvēlēts no saraksta.
                if (isValid && !carHiddenInput.value) {
                    showMessage('Lūdzu izvēlies auto modeli no saraksta.', 'error');
                    carDisplayInput.focus();
                    isValid = false;
                }

                // Parastām rezervācijām nepieciešams derīgs datums.
                if (isValid) {
                    ensureValidDate(false);
                    if (!dateField || !dateField.value) {
                        showMessage('Lūdzu izvēlies pieejamo darba dienu no kalendāra.', 'error');
                        if (dateField) {
                            dateField.focus();
                        }
                        isValid = false;
                    }
                }

                // Laiks ir obligāts vienmēr.
                if (isValid && (!timeField || !timeField.value)) {
                    showMessage('Lūdzu izvēlies pieejamo laiku.', 'error');
                    if (timeField) {
                        timeField.focus();
                    }
                    isValid = false;
                }

                // Auto/salona dati jābūt aizpildītiem pēc izvēlēm.
                if (isValid && !hasAllRequiredVehicleDetails()) {
                    showMessage('Lūdzu aizpildi auto informāciju (un salona sadaļu, ja izvēlies atbilstošus pakalpojumus).', 'error');
                    isValid = false;
                }

                // Telefona numuram jābūt līdz 13 cipariem (+ ir izvēles).
                if (isValid && !validatePhoneField(true)) {
                    phoneInput.focus();
                    isValid = false;
                }

                // Ja ir kļūdas, neļauj nosūtīt formu.
                if (!isValid) {
                    e.preventDefault();
                    return;
                }

                // Ieliek kopsummu slēptajā laukā pirms nosūtīšanas.
                if (totalField) {
                    totalField.value = totalPriceEl.textContent.replace('€', '').trim();
                }
            });
        }

        // Parāda paziņojumu un automātiski paslēpj pēc 5 sekundēm.
        function showMessage(text, type) {
            const messagesDiv = document.getElementById('messages');
            messagesDiv.innerHTML = `<div class="message ${type}">${text}</div>`;
            setTimeout(() => {
                messagesDiv.innerHTML = '';
            }, 5000);
        }

        // Ja URL satur ?service=, automātiski atzīmē atbilstošo pakalpojumu.
        const urlParams = new URLSearchParams(window.location.search);
        const serviceParam = urlParams.get('service');
        if (serviceParam) {
            const checkbox = document.getElementById(`service-${serviceParam}`);
            if (checkbox) {
                checkbox.checked = true;
                checkbox.dispatchEvent(new Event('change'));
            }
        }

        // Inicializācija pēc lapas ielādes: kopsavilkums, datums un noteikumi.
        handleCarInput();
        ensureValidDate(false);
        updateInteriorConditionState();
        enforceServiceRules(false);
    </script>
@endpush
@endsection
