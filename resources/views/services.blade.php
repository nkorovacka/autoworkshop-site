<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <title>Pakalpojumi</title>
</head>
<body>
<header>
    <nav>
        <a href="{{ url('/') }}">Galvenā lapa</a> |
        <a href="{{ url('/services') }}">Pakalpojumi</a> |
        <a href="{{ url('/products') }}">Produkti</a> |
        <a href="{{ url('/offers') }}">Piedāvājumi </a> |
        <a href="{{ url('/our-work') }}">Mūsu darbi</a>
    </nav>
</header>

<main>
    <h1>Pakalpojumi</h1>

    <p>Šeit vēlāk būs arī kalkulators pēc auto izmēra.</p>

        <ul>
        @foreach($services as $service)
            <li>
                <strong>{{ $service['name'] }}</strong> –
                {{ $service['description'] }} –
                no {{ number_format($service['price'], 2) }} €
            </li>
        @endforeach
    </ul>

    <p style="margin-top: 20px;">
        <a href="{{ route('booking.create') }}" style="padding: 10px 15px; border: 1px solid #333; text-decoration:none;">
            Pieteikties uz detailing
        </a>
    </p>

</main>
</body>
</html>
