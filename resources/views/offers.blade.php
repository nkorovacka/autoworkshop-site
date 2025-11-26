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
        .cta-btn { margin-top: 10px; padding: 6px 10px; }
        .msg-success { color: green; }
        .msg-error { color: red; }
    </style>
</head>
<body>

<header>
    <nav>
        <a href="{{ url('/') }}">Galvenā lapa</a> |
        <a href="{{ url('/services') }}">Pakalpojumi</a> |
        <a href="{{ url('/products') }}">Produkti</a> |
        <a href="{{ url('/our-work') }}">Mūsu darbi</a> |
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
                        <span class="tag">Vebinārs / pasākums</span>
                    @else
                        <span class="tag">Detailing piedāvājums</span>
                    @endif

                    @if($offer->event_date)
                        <p><strong>Datums:</strong> {{ $offer->event_date }}</p>
                    @endif

                    @if($offer->description)
                        <p>{{ $offer->description }}</p>
                    @endif

                    {{-- WEBINĀRA PIETEIKŠANĀS --}}
                    @if($offer->type === 'webinar')
                        @if($offer->is_limited)
                            <p>Vietas: {{ $offer->registrations_count }} / {{ $offer->capacity }}</p>
                        @endif

                        @if($offer->is_limited && $offer->registrations_count >= $offer->capacity)
                            <button class="cta-btn" disabled>Pilns</button>
                        @else
                            <form method="POST" action="{{ route('offers.signup', $offer) }}">
                                @csrf
                                <div>
                                    <input type="text" name="name" placeholder="Vārds" required>
                                </div>
                                <div>
                                    <input type="email" name="email" placeholder="E-pasts" required>
                                </div>
                                <button type="submit" class="cta-btn">Pieteikties vebināram</button>
                            </form>
                        @endif

                    @else
                        {{-- DETAILING PIEDĀVĀJUMS – vedam uz booking --}}
                        <p><em>Šim piedāvājumam pieteikšanās notiek ar auto booking formu.</em></p>
                        <a href="{{ route('booking.create', ['offer' => $offer->id]) }}" class="cta-btn">
                            Pieteikties ar atlaidi
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
