<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <title>Produkti</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body { font-family: sans-serif; max-width: 1100px; margin: 0 auto; padding: 20px;}
        header nav a { margin-right: 10px; }
        h1 { margin-bottom: 10px; }
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .product-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            background: #fafafa;
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        .product-card h2 { margin-top: 0; cursor: pointer; color: #333; }
        .product-card img {
            max-width: 100%;
            height: auto;
            margin-bottom: 10px;
            border-radius: 6px;
        }
        .price { font-weight: bold; margin-bottom: 5px; }
        .stock { font-size: 13px; margin-bottom: 8px; }
        .stock-ok { color: green; }
        .stock-low { color: #d97706; }
        .stock-out { color: red; }
        .small-link {
            font-size: 13px;
            margin-top: 6px;
            display: inline-block;
        }
        .card-footer {
            margin-top: auto;
        }
        .msg-success { color: green; }
        .msg-error { color: red; }
    </style>
</head>
<body>

<header>
    <nav>
        <a href="{{ route('home') }}">Galvenā lapa</a> |
        <a href="{{ route('services.index') }}">Pakalpojumi</a> |
        <strong><a href="{{ route('products.index') }}">Produkti</a></strong> |
        <a href="{{ route('our-work') }}">Mūsu darbi</a> |
        <a href="{{ route('offers.index') }}">Piedāvājumi / pasākumi</a>
    </nav>
</header>

<main>
    <h1>Produkti auto kopšanai</h1>

    {{-- Ja kādreiz backendā sūtīsi success message, tas te parādīsies, bet pagaidām ok --}}
    @if(session('success'))
        <p class="msg-success">{{ session('success') }}</p>
    @endif

    @if($products->count())
        <div class="products-grid">
            @foreach($products as $product)
                @php
                    $inStock = $product->stock > 0;
                @endphp
                <div class="product-card" data-product-id="{{ $product->id }}">
                    {{-- Noklikšķinot uz nosaukuma vai bildes – uz detaļu lapu --}}
                    <h2 onclick="window.location='{{ route('products.show', $product) }}'">
                        {{ $product->name }}
                    </h2>

                    @if($product->image)
                        <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}"
                             onclick="window.location='{{ route('products.show', $product) }}'">
                    @else
                        <div style="width:100%; height:160px; background:#ddd; display:flex; align-items:center; justify-content:center; border-radius:6px; margin-bottom:10px;">
                            <span>Produkts bez attēla (vēlāk var pievienot)</span>
                        </div>
                    @endif

                    <p class="price">{{ number_format($product->price, 2) }} €</p>

                    @if($product->description)
                        <p>{{ $product->description }}</p>
                    @endif

                    {{-- Atlikums --}}
                    @if($inStock)
                        @if($product->stock <= 5)
                            <p class="stock stock-low">Atlikušas tikai {{ $product->stock }} gb!</p>
                        @else
                            <p class="stock stock-ok">Noliktavā: {{ $product->stock }} gb</p>
                        @endif
                    @else
                        <p class="stock stock-out">Produkts pašlaik nav pieejams</p>
                    @endif

                    <div class="card-footer">
                        @if($inStock)
                            <p style="font-size: 13px; margin-bottom: 6px;">
                                Produkts pieejams noliktavā.
                            </p>
                        @else
                            <p style="font-size: 13px; margin-bottom: 6px;">
                                Pašlaik nav pieejams pasūtīšanai.
                            </p>
                        @endif

                        <a href="{{ route('products.show', $product) }}" class="small-link">
                            Skatīt detalizētu aprakstu
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p>Šobrīd nav pieejamu produktu.</p>
    @endif
</main>

</body>
</html>
