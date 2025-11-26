<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <title>Auto detailing pieteikums</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body { font-family: sans-serif; max-width: 900px; margin: 0 auto; padding: 20px; }
        header nav a { margin-right: 10px; }
        h1 { margin-bottom: 10px; }
        .field { margin-bottom: 10px; }
        label { display: block; font-weight: bold; margin-bottom: 3px; }
        input[type="text"], input[type="tel"], input[type="email"], input[type="date"], input[type="time"], select {
            width: 100%;
            padding: 6px 8px;
            box-sizing: border-box;
        }
        .msg-success { color: green; }
        .msg-error { color: red; }
        .services-list label { font-weight: normal; }
    </style>
</head>
<body>

<header>
    <nav>
        <a href="{{ route('home') }}">Galvenā lapa</a> |
        <a href="{{ route('services.index') }}">Pakalpojumi</a> |
        <a href="{{ route('products.index') }}">Produkti</a> |
        <a href="{{ route('our-work') }}">Mūsu darbi</a> |
        <a href="{{ route('offers.index') }}">Piedāvājumi / pasākumi</a>
    </nav>
</header>

<main>
    <h1>Auto detailing pieteikums</h1>

    @if(session('success'))
        <p class="msg-success">{{ session('success') }}</p>
    @endif

    @if(session('error'))
        <p class="msg-error">{{ session('error') }}</p>
    @endif

    @if($errors->any())
        <div class="msg-error">
            <ul>
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Ja nākam no īpaša detailing piedāvājuma --}}
    @if(isset($offer) && $offer)
        <p><strong>Piedāvājums:</strong> {{ $offer->title }}</p>

        @if($offer->event_date)
            <p><strong>Datums:</strong> {{ $offer->event_date }}</p>
        @endif
    @endif

    <form method="POST" action="{{ route('booking.store') }}">
        @csrf

        {{-- Ja ir offer, sūtam tā ID formā --}}
        @if(isset($offer) && $offer)
            <input type="hidden" name="offer_id" value="{{ $offer->id }}">
        @endif

        <div class="field">
            <label>Vārds, Uzvārds</label>
            <input type="text" name="customer_name" value="{{ old('customer_name') }}" required>
        </div>

        <div class="field">
            <label>Telefona numurs</label>
            <input type="tel" name="customer_phone" value="{{ old('customer_phone') }}" required>
        </div>

        <div class="field">
            <label>E-pasts (nav obligāts)</label>
            <input type="email" name="customer_email" value="{{ old('customer_email') }}">
        </div>

        <div class="field">
            <label>Auto modelis</label>
            <input type="text" name="car" value="{{ old('car') }}" required>
            {{-- šeit vēlāk var ielikt tavu mega select ar visiem auto --}}
        </div>

        <div class="field">
            <label>Auto stāvoklis</label>
            <select name="condition" required>
                <option value="">-- Izvēlies --</option>
                <option value="normal" {{ old('condition') === 'normal' ? 'selected' : '' }}>Normāls</option>
                <option value="dirty"  {{ old('condition') === 'dirty' ? 'selected' : '' }}>Ļoti netīrs</option>
                <option value="new"    {{ old('condition') === 'new' ? 'selected' : '' }}>Gandrīz kā jauns</option>
            </select>
        </div>

        {{-- Datums --}}
        @if(isset($offer) && $offer && $offer->type === 'detailing' && $offer->has_timeslots && $offer->event_date)
            {{-- Datumu neliekam izvēlēties, tas ir fiksēts --}}
            <input type="hidden" name="date" value="{{ $offer->event_date }}">
        @else
            <div class="field">
                <label>Datums</label>
                <input type="date" name="date" value="{{ old('date') }}">
            </div>
        @endif

        {{-- Laiks --}}
        <div class="field">
            <label>Laiks</label>

            @if(isset($offer) && $offer && $offer->type === 'detailing' && $offer->has_timeslots && !empty($timeSlots))
                <select name="time" required>
                    <option value="">-- Izvēlies laiku --</option>
                    @foreach($timeSlots as $slot)
                        @php
                            $taken = isset($takenSlots) && in_array($slot, $takenSlots);
                        @endphp
                        <option value="{{ $slot }}" {{ $taken ? 'disabled' : '' }}>
                            {{ $slot }} {{ $taken ? '(aizņemts)' : '' }}
                        </option>
                    @endforeach
                </select>
            @else
                <input type="time" name="time" value="{{ old('time') }}" required>
            @endif
        </div>

        {{-- Pakalpojumi (vienkārši piemēri, tu vari pielikt savus) --}}
        <div class="field services-list">
            <label>Izvēlies pakalpojumus</label>
            <label>
                <input type="checkbox" name="services[]" value="exterior"
                    {{ is_array(old('services')) && in_array('exterior', old('services')) ? 'checked' : '' }}>
                Ārējā mazgāšana
            </label>
            <label>
                <input type="checkbox" name="services[]" value="interior"
                    {{ is_array(old('services')) && in_array('interior', old('services')) ? 'checked' : '' }}>
                Salona tīrīšana
            </label>
            <label>
                <input type="checkbox" name="services[]" value="polishing"
                    {{ is_array(old('services')) && in_array('polishing', old('services')) ? 'checked' : '' }}>
                Pulēšana
            </label>
        </div>

        <div class="field">
            <label>Kopējā summa (€)</label>
            <input type="text" name="total" value="{{ old('total', '0.00') }}" required>
            {{-- šeit vari likt savu JS kalkulatoru, kas aprēķina cenu automātiski --}}
        </div>

        <button type="submit">Pieteikt vizīti</button>
    </form>
</main>

</body>
</html>
