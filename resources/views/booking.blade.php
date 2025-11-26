<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <title>Pieteikt vizīti</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body { font-family: sans-serif; max-width: 900px; margin: 0 auto; padding: 20px; }
        header nav a { margin-right: 10px; }
        label { display:block; margin-top: 10px; }
        fieldset { margin-top: 15px; }
        .total-box {
            margin-top: 20px;
            padding: 15px;
            border: 2px solid #333;
            background: #f9f9f9;
        }
        .total-box h2 {
            margin-top: 0;
        }
        .total-value {
            font-size: 24px;
            font-weight: bold;
        }
        .error { color: red; }
        .success { color: green; font-weight: bold; }
    </style>
</head>
<body>

<header>
    
        <strong>Pieteikt vizīti</strong>
    </nav>
</header>

<main>
    <h1>Pieteikt auto detailing vizīti</h1>

    {{-- Success ziņa no BookingController --}}
    @if(session('success'))
        <p class="success">{{ session('success') }}</p>
    @endif

    {{-- Kļūdu saraksts --}}
    @if($errors->any())
        <ul class="error">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form id="booking-form" method="POST" action="{{ route('booking.store') }}">
            {{-- KLIENTA DATI --}}
        <label for="customer_name">Vārds, Uzvārds:</label>
        <input type="text" id="customer_name" name="customer_name" required>

        <label for="customer_phone">Telefons:</label>
        <input type="text" id="customer_phone" name="customer_phone" required>

        <label for="customer_email">E-pasts (nav obligāts):</label>
        <input type="email" id="customer_email" name="customer_email">

        @csrf

        {{-- AUTO IZVĒLE --}}
        <label for="car">Izvēlies auto modeli:</label>
        <select id="car" name="car" required>
            <option value="">-- Izvēlies auto --</option>
            {{-- TE VARĒSI IEMEST SAVU MILZĪGO SARAKSTU --}}
            <option value="Mazs auto" data-multiplier="1.0">Mazs auto (Fiesta, Polo, Yaris...)</option>
            <option value="Vidējs auto" data-multiplier="1.2">Vidējs auto (A4, 3 Series, Golf...)</option>
            <option value="SUV" data-multiplier="1.5">SUV (Q7, X5, GLE...)</option>
            <option value="Busiņš" data-multiplier="2.0">Busiņš (Transporter, Sprinter...)</option>
        </select>

        {{-- STĀVOKLIS --}}
        <label for="condition">Auto stāvoklis:</label>
        <select id="condition" name="condition" required>
            <option value="">-- Izvēlies --</option>
            <option value="normal">Normāls</option>
            <option value="dirty">Netīrs</option>
            <option value="very_dirty">Ļoti netīrs</option>
        </select>

        {{-- DATUMS + LAIKS --}}
        <label for="date">Datums:</label>
        <input type="date" id="date" name="date" required>

        <label for="time">Laiks:</label>
        <input type="time" id="time" name="time" required>

        {{-- PAKALPOJUMI --}}
        <fieldset>
            <legend>Pakalpojumi:</legend>

            <label>
                <input type="checkbox" name="services[]" value="exterior" class="service" data-price="30">
                Ārējā mazgāšana (30 €)
            </label>

            <label>
                <input type="checkbox" name="services[]" value="interior" class="service" data-price="40">
                Salona tīrīšana (40 €)
            </label>

            <label>
                <input type="checkbox" name="services[]" value="polishing" class="service" data-price="80">
                Pulēšana (80 €)
            </label>
        </fieldset>

        {{-- SLEPENAIS LAUKS AR KOPĒJO CENU (tiks nosūtīts uz controllera) --}}
        <input type="hidden" name="total" id="totalInput" value="0">

        {{-- CENU KALKULATORA BLOKS --}}
        <div class="total-box">
            <h2>Cenu kalkulators</h2>
            <p>Auto izmērs + pakalpojumu cena + stāvoklis:</p>
            <p>Kopējā cena: <span class="total-value" id="totalDisplay">€0.00</span></p>
        </div>

        <button type="submit" style="margin-top: 15px;">Pieteikt vizīti</button>
    </form>
</main>

<script>
    const carSelect = document.getElementById('car');
    const conditionSelect = document.getElementById('condition');
    const serviceCheckboxes = document.querySelectorAll('.service');
    const totalDisplay = document.getElementById('totalDisplay');
    const totalInput = document.getElementById('totalInput');

    function calculateTotal() {
        let base = 0;

        // Saskaita izvēlēto pakalpojumu cenu
        serviceCheckboxes.forEach(cb => {
            if (cb.checked) {
                base += parseFloat(cb.dataset.price);
            }
        });

        // Auto multiplikators
        let carMultiplier = 1;
        const selectedCarOption = carSelect.options[carSelect.selectedIndex];
        if (selectedCarOption && selectedCarOption.dataset.multiplier) {
            carMultiplier = parseFloat(selectedCarOption.dataset.multiplier) || 1;
        }

        // Stāvokļa multiplikators
        let conditionMultiplier = 1;
        const condition = conditionSelect.value;
        if (condition === 'dirty') {
            conditionMultiplier = 1.1;      // +10%
        } else if (condition === 'very_dirty') {
            conditionMultiplier = 1.25;     // +25%
        }

        const total = base * carMultiplier * conditionMultiplier;

        totalDisplay.textContent = '€' + total.toFixed(2);
        totalInput.value = total.toFixed(2);
    }

    carSelect.addEventListener('change', calculateTotal);
    conditionSelect.addEventListener('change', calculateTotal);
    serviceCheckboxes.forEach(cb => {
        cb.addEventListener('change', calculateTotal);
    });
</script>

</body>
</html>
