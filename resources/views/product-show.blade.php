@extends('layouts.public')

@section('title', $product->name . ' – produkta apraksts')

@section('content')

<main>
    <!-- Produkta virsraksts un īss ievads -->
    <h1 class="hero-title">{{ $product->name }}</h1>
    <p class="intro">Detalizēta informācija par produktu un tā pielietojumu.</p>

    <!-- Flash paziņojumi par groza darbībām -->
    @if(session('success'))
        <div class="flash flash-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="flash flash-error">{{ $errors->first() }}</div>
    @endif

    <!-- Noliktavas un daudzuma aprēķini -->
    @php
        $inStock = $product->stock > 0;
        $maxQty = $inStock ? min($product->stock, 100) : 100;
    @endphp
    <!-- Produkta karte ar attēlu un detaļām -->
    <article class="product-card">
        <!-- Attēla zona -->
        <div class="product-media">
            <div class="image-frame" onclick="window.location='{{ route('products.show', $product) }}'">
                @if($product->image)
                    <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}">
                @else
                    <span>Produkta attēls tiks pievienots</span>
                @endif
            </div>
        </div>
        <!-- Produkta detaļas un rīcības -->
        <div class="product-details">
            <div>
                <p class="price">{{ number_format($product->price, 2) }} €</p>
                <p class="{{ $inStock ? ($product->stock <= 5 ? 'stock-low' : 'stock-ok') : 'stock-out' }}">
                    @if($inStock)
                        @if($product->stock <= 5)
                            Atliek {{ $product->stock }} gb
                        @else
                            Noliktavā: {{ $product->stock }} gb
                        @endif
                    @else
                        Šobrīd nav pieejams noliktavā
                    @endif
                </p>
            </div>
            <!-- Ražotājs un izcelsme -->
            @if($product->supplier || $product->origin_country)
                <div class="tag-row">
                    @if($product->supplier)
                        <span class="tag">{{ $product->supplier }}</span>
                    @endif
                    @if($product->origin_country)
                        <span class="tag">Ražots: {{ $product->origin_country }}</span>
                    @endif
                </div>
            @endif
            <!-- Apraksta sadaļa -->
            @if($product->description || $product->long_description)
                <div class="section">
                    <h3>Produkta apraksts</h3>
                    <p>{{ $product->long_description ?? $product->description }}</p>
                </div>
            @endif
            <!-- Lietošanas instrukcijas -->
            @if($product->usage_instructions)
                <div class="section">
                    <h3>Kā lietot</h3>
                    <pre>{{ $product->usage_instructions }}</pre>
                </div>
            @endif
            <!-- Groza pievienošanas forma -->
            <div class="section">
                <h3>Pievienot grozam</h3>
                @auth
                    @if($inStock)
                        <form method="POST" action="{{ route('cart.add', $product) }}">
                            @csrf
                            <div class="quantity-row">
                                <label for="quantity">Daudzums</label>
                                <input type="number"
                                       id="quantity"
                                       name="quantity"
                                       min="1"
                                       max="{{ $maxQty }}"
                                       value="1">
                            </div>
                            <button type="submit" class="btn-add-cart">🛒 Pievienot grozam</button>
                        </form>
                    @else
                        <p style="color:#b5302c;">Šobrīd nav iespējams pievienot grozam (produkts nav noliktavā).</p>
                    @endif
                @else
                    <a class="btn-add-cart disabled" href="{{ route('login') }}">Ieiet, lai pievienotu grozā</a>
                @endauth
            </div>
        </div>
    </article>

    <!-- Atpakaļ saite uz katalogu -->
    <a class="back-link" href="{{ route('products.index') }}">&larr; Atpakaļ uz produktu sarakstu</a>
</main>

<!-- Iekšējais CSS: novietots pēc HTML, lai atdalītu struktūru no noformējuma -->
@push('styles')
<style>
        /* Globālā nullēšana un kastes modelis */
        * { margin:0; padding:0; box-sizing:border-box; }
        /* Krāsu mainīgie un palete */
        :root {
            --accent:#ff5c35;
            --accent-dark:#d94516;
            --ink:#181818;
            --muted:#6f6f6f;
            --border:#ededed;
            --card:#ffffff;
        }
        /* Pamatteksts un fons */
        body { font-family:"Inter", Arial, sans-serif; background:#f7f7f7; color:var(--ink); line-height:1.6; }
        /* Pogas grozam un daudzuma ievade */
        .btn-add-cart { margin-top:0.5rem; padding:0.9rem 1.5rem; border-radius:12px; border:none; font-weight:600; cursor:pointer; display:inline-flex; align-items:center; gap:0.5rem; background:var(--ink); color:white; text-decoration:none; }
        .btn-add-cart.disabled { background:#e0e0e0; color:#777; cursor:not-allowed; }
        .quantity-row { display:flex; align-items:center; gap:0.8rem; margin-top:0.5rem; }
        .quantity-row label { font-weight:600; }
        .quantity-row input { width:90px; padding:0.5rem; border-radius:10px; border:1px solid var(--border); }
        .quantity-row input:focus { outline:none; border-color:var(--accent); box-shadow:0 0 0 3px rgba(255,92,53,0.15); }
        /* Paziņojumu bloki */
        .flash { padding:0.9rem 1.1rem; border-radius:12px; margin:1rem 0; font-weight:500; }
        .flash-success { background:#e6f5ef; color:#136b3a; border:1px solid #b7e2c9; }
        .flash-error { background:#fdecea; color:#b5302c; border:1px solid #f3c0b7; }

        /* Galvenais saturs un produktu karte */
        main { max-width:1400px; margin:0 auto; padding:2.5rem 2rem 3rem; }
        .hero-title { font-size:2.4rem; margin-bottom:0.4rem; }
        .intro { color:var(--muted); margin-bottom:2rem; }

        .product-card { background:var(--card); border:1px solid var(--border); border-radius:24px; padding:2rem; display:flex; flex-wrap:wrap; gap:1.5rem; box-shadow:0 20px 40px rgba(0,0,0,0.04); }
        .product-media { flex:1 1 320px; }
        .image-frame { width:100%; height:320px; border-radius:18px; background:#f0f0f0; display:flex; align-items:center; justify-content:center; color:#999; overflow:hidden; }
        .image-frame img { width:100%; height:100%; object-fit:cover; }
        .product-details { flex:1 1 360px; display:flex; flex-direction:column; gap:1rem; }
        .price { font-size:1.6rem; font-weight:700; }
        .tag-row { display:flex; gap:0.6rem; flex-wrap:wrap; font-size:0.9rem; color:var(--muted); }
        .tag { padding:0.2rem 0.7rem; border-radius:999px; background:#fff2ec; color:var(--accent-dark); font-weight:600; }
        .stock-ok { color:#0f9d58; }
        .stock-low { color:#c7771a; }
        .stock-out { color:#c0392b; }

        .section { margin-top:2rem; }
        .section h3 { font-size:1.2rem; margin-bottom:0.4rem; }
        .section p, .section pre { color:var(--ink); }
        .section pre { font-family:"Inter", Arial, sans-serif; background:#fefefe; padding:0.8rem; border-radius:12px; border:1px solid var(--border); white-space:pre-wrap; }

        .back-link { display:inline-flex; align-items:center; gap:0.4rem; margin-top:2.5rem; text-decoration:none; color:var(--accent); font-weight:600; }

        /* Responsivitāte mazākiem ekrāniem */
        @media(max-width:680px){
            .product-card { padding:1.5rem; }
            .image-frame { height:240px; }
        }
    </style>
@endpush
@endsection
