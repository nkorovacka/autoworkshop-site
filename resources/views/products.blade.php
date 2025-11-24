<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <title>Produkti</title>
</head>
<body>
<header>
    <nav>
        <a href="{{ url('/') }}">Galvenā lapa</a> |
        <a href="{{ url('/services') }}">Pakalpojumi</a> |
        <a href="{{ url('/products') }}">Produkti</a> |
        <a href="{{ url('/our-work') }}">Mūsu darbi</a>
    </nav>
</header>

<main>
    <h1>Produkti</h1>

    @if($products->count())
        <ul>
            @foreach($products as $product)
                <li>
                    <strong>{{ $product->name }}</strong> –
                    {{ $product->description }} –
                    {{ number_format($product->price, 2) }} €
                </li>
            @endforeach
        </ul>
    @else
        <p>Pagaidām nav neviena produkta.</p>
    @endif
</main>
</body>
</html>
