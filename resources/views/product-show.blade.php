<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <title>{{ $product->name }} – produkta apraksts</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body { font-family: sans-serif; max-width: 900px; margin: 0 auto; padding: 20px;}
        header nav a { margin-right: 10px; }
        .product-wrapper {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .product-image {
            flex: 1 1 280px;
        }
        .product-image img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }
        .placeholder-img {
            width:100%;
            height:260px;
            background:#ddd;
            display:flex;
            align-items:center;
            justify-content:center;
            border-radius:8px;
        }
        .product-info {
            flex: 2 1 320px;
        }
        .price { font-weight: bold; margin-bottom: 10px; }
        .tag { font-size: 13px; color: #555; margin-bottom: 6px; }
        .section-title { margin-top: 15px; margin-bottom: 5px; font-weight: bold; }
        pre {
            white-space: pre-wrap;
            font-family: inherit;
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
        <a href="{{ route('offers.index') }}">Piedāvājumi / pasākumi</a>
    </nav>
</header>

<main>
    <h1>{{ $product->name }}</h1>

    <div class="product-wrapper">
        <div class="product-image">
            @if($product->image)
                <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}">
            @else
                <div class="placeholder-img">
                    <span>Nav pievienots produkta attēls</span>
                </div>
            @endif
        </div>

        <div class="product-info">
            <p class="price">{{ number_format($product->price, 2) }} €</p>

            @if($product->stock > 0)
                <p>Pieejams noliktavā: {{ $product->stock }} gb</p>
            @else
                <p style="color:red;">Šobrīd nav pieejams noliktavā</p>
            @endif

            @if($product->supplier || $product->origin_country)
                <p class="tag">
                    @if($product->supplier)
                        Piegādātājs: {{ $product->supplier }}
                    @endif
                    @if($product->origin_country)
                        @if($product->supplier) |
                        @endif
                        Ražots: {{ $product->origin_country }}
                    @endif
                </p>
            @endif

            @if($product->long_description)
                <div>
                    <div class="section-title">Produkta apraksts</div>
                    <p>{{ $product->long_description }}</p>
                </div>
            @elseif($product->description)
                <div>
                    <div class="section-title">Produkta apraksts</div>
                    <p>{{ $product->description }}</p>
                </div>
            @endif

            @if($product->usage_instructions)
                <div>
                    <div class="section-title">Kā lietot</div>
                    <pre>{{ $product->usage_instructions }}</pre>
                </div>
            @endif
        </div>
    </div>

    <p style="margin-top:20px;">
        <a href="{{ route('products.index') }}">&larr; Atpakaļ uz produktu sarakstu</a>
    </p>
</main>

</body>
</html>
