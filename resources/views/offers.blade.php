<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <title>Piedāvājumi un pasākumi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body { font-family: sans-serif; max-width: 1000px; margin: 0 auto; padding: 20px; }
        header nav a { margin-right: 10px; }
        h1 { margin-bottom: 10px; }
        .offers-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .offer-card {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 6px;
            background: #fafafa;
        }
        .offer-card h2 { margin-top: 0; }
        .tag { font-size: 12px; color: #555; }
        .cta-btn { margin-top: 10px; padding: 6px 10px; cursor: pointer; }
        .cta-btn[disabled] { opacity: 0.6; cursor: not-allowed; }
        .msg-success { color: green; }
        .msg-error { color: red; }
        input[type="text"], input[type="email"] {
            width: 100%;
            padding: 6px 8px;
            margin-top: 4px;
            margin-bottom: 6px;
            box-sizing: border-box;
        }
    </style>
</head>
<body>

<header>
    <nav>
        <a href="{{ route('home') }}">Galvenā lapa</a> |
        <a href="{{ route('services.index') }}">Pakalpojumi</a> |
        <a href="{{ route('products.index') }}">Produkti</a> |
        <a href="{{ route('our-work') }}">Mūsu darbi</a> |
        <strong><a href="{{ route('offers.index') }}">Piedāvājumi / pasākumi</a></strong>
    </nav>
</header>

<main>
    <h1>Piedāvājumi un pasākumi</h1>

    @if(session('success'))
        <p class="msg-success">{{ session('success') }}</p>
    @endif

    @if(session('error'))
        <p class="msg-error">{{ session('error') }}</p>
    @endif

    @if($offers->count())
        <div class="offers-grid">
            @foreach($offers as $offer)
                <div class="offer-card">
                    <h2>{{ $offer->title }}</h2>

                    @if($offer->type === 'webinar')
                        <span class="tag">Vebinārs / online pasākums</span>
                    @else
                        <span class="tag">Detailing piedāvājums (ar auto)</span>
                    @endif

                    @if($offer->event_date)
                        <p><strong>Datums:</strong> {{ $offer->event_date }}</p>
                    @endif

                    @if($offer->description)
                        <p>{{ $offer->description }}</p>
                    @endif

                    {{-- WEBINĀRS (vietu limits + pieteikšanās skaits) --}}
                    @if($offer->type === 'webinar')
                        @if($offer->is_limited && $offer->capacity)
                            <p>Vietas: {{ $offer->registrations_count }} / {{ $offer->capacity }}</p>
                        @endif

                        @if($offer->is_limited && $offer->capacity && $offer->registrations_count >= $offer->capacity)
                            <button class="cta-btn" disabled>Pilns</button>
                        @else
                            <form method="POST" action="{{ route('offers.signup', $offer) }}">
                                @csrf
                                <div>
                                    <label>Vārds</label>
                                    <input type="text" name="name" required>
                                </div>
                                <div>
                                    <label>E-pasts</label>
                                    <input type="email" name="email" required>
                                </div>
                                <button type="submit" class="cta-btn">Pieteikties vebināram</button>
                            </form>
                        @endif

                    {{-- DETAILING PIEDĀVĀJUMS – uz booking ar time slotiem --}}
                    @else
                        <p><em>Šim piedāvājumam pieteikšanās notiek ar auto rezervācijas formu, kur varēsi izvēlēties laiku.</em></p>
                        <a href="{{ route('booking.create', ['offer' => $offer->id]) }}" class="cta-btn">
                            Pieteikties uz detailing ar atlaidi
                        </a>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <p>Šobrīd nav aktīvu piedāvājumu.</p>
    @endif
</main>

</body>
</html>
