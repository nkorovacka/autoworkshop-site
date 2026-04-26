@extends('layouts.public')

@section('title', 'Grozs - Auto Detailing Workshop')

@section('content')

<main>
    <!-- Lapas virsraksts -->
    <h1>Tavs grozs</h1>
    <p class="lead">Pārskati produktus un turpini ar pasūtījumu.</p>

    <!-- Paziņojumi par veiksmēm vai kļūdām -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-error">{{ $errors->first() }}</div>
    @endif

    @if($items->count())
        <!-- Groza izkārtojums: preces pa kreisi, kopsavilkums pa labi -->
        <div class="cart-layout">
            <section class="cart-items">
                @foreach($items as $item)
                    <!-- Viena prece grozā ar cenu, daudzumu un dzēšanu -->
                    <article class="cart-item">
                        <div>
                            <h3>{{ $item->product->name ?? 'Produkts nav pieejams' }}</h3>
                            <p>{{ number_format($item->unit_price, 2) }} € / gab.</p>
                        </div>
                        <div>
                            <strong>{{ number_format($item->unit_price * $item->quantity, 2) }} €</strong>
                        </div>
                        <!-- Daudzuma maiņas forma -->
                        <form method="POST" action="{{ route('cart.update', $item) }}" class="quantity-form">
                            @csrf
                            @method('PATCH')
                            <label class="sr-only" for="quantity-{{ $item->id }}">Daudzums</label>
                            <input type="number"
                                   id="quantity-{{ $item->id }}"
                                   class="quantity-input"
                                   name="quantity"
                                   min="1"
                                   max="{{ $item->product->stock ?? 100 }}"
                                   value="{{ $item->quantity }}"
                                   data-last-value="{{ $item->quantity }}">
                        </form>
                        <!-- Produkta izņemšanas forma -->
                        <form method="POST" action="{{ route('cart.destroy', $item) }}" class="remove-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" title="Izņemt">×</button>
                        </form>
                    </article>
                @endforeach
            </section>
            <aside class="cart-summary">
                <div class="cart-total-box">
                    <span class="cart-total-label">Summa</span>
                    <span class="cart-total-amount">{{ number_format($subtotal, 2) }} €</span>
                </div>
                <!-- Poga uz pasūtījuma noformēšanu -->
                <a class="btn-primary" href="{{ route('checkout.index') }}">Turpināt pasūtījumu</a>
            </aside>
        </div>
    @else
        <!-- Tukšs grozs -->
        <div class="empty-state">
            <p>Grozs ir tukšs. Dodies uz <a href="{{ route('products.index') }}">produktu kataloga lapu</a> un izvēlies sev nepieciešamos līdzekļus.</p>
        </div>
    @endif
</main>

<!-- Iekšējais CSS: novietots pēc HTML, lai atdalītu struktūru no noformējuma -->
@push('styles')
<style>
    /* Globālā nullēšana un kastes modelis */
    * { margin:0; padding:0; box-sizing:border-box; }
    /* Krāsu un tipogrāfijas mainīgie */
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
    /* Galvenais saturs */
    main { max-width:1200px; margin:0 auto; padding:2.5rem 2rem 3rem; }
    h1 { font-size:2.2rem; margin-bottom:0.3rem; }
    .lead { color:var(--muted); margin-bottom:1.5rem; }
    /* Paziņojumi */
    .alert { padding:0.9rem 1.1rem; border-radius:12px; margin-bottom:1.5rem; font-weight:500; }
    .alert-success { background:#e6f5ef; color:#136b3a; border:1px solid #b7e2c9; }
    .alert-error { background:#fdecea; color:#b5302c; border:1px solid #f3c0b7; }
    /* Groza izkārtojums */
    .cart-layout { display:grid; grid-template-columns:2fr 1fr; gap:1.5rem; align-items:start; }
    .cart-items { background:white; border:1px solid var(--border); border-radius:16px; padding:1.3rem; display:flex; flex-direction:column; gap:1.2rem; }
    .cart-item { display:grid; grid-template-columns:1fr 120px 150px 40px; gap:1rem; align-items:center; padding-bottom:1rem; border-bottom:1px solid #f0f0f0; }
    .cart-item:last-child { border-bottom:none; padding-bottom:0; }
    .cart-item h3 { font-size:1.1rem; }
    .cart-item p { color:#6b6b6b; font-size:0.92rem; }
    .quantity-form input { width:70px; padding:0.45rem; border-radius:10px; border:1px solid var(--border); text-align:center; }
    .quantity-form input:focus { outline:none; border-color:var(--accent); box-shadow:0 0 0 3px rgba(255,92,53,0.15); }
    .quantity-form button { display:none; }
    .quantity-hint { font-size:0.8rem; color:#9a9a9a; margin-top:0.3rem; }
    .remove-form button { border:none; background:none; color:#c0392b; cursor:pointer; font-size:1.2rem; }
    .sr-only { position:absolute; width:1px; height:1px; padding:0; margin:-1px; overflow:hidden; clip:rect(0,0,0,0); border:0; }
    /* Kopsavilkuma bloks */
    .cart-summary { background:white; border:1px solid var(--border); border-radius:18px; padding:1.4rem; box-shadow:0 10px 24px rgba(17,24,39,0.04); }
    .cart-total-box { display:flex; align-items:flex-end; justify-content:space-between; gap:1rem; padding:1rem; border-radius:14px; background:#fff7f2; border:1px solid #f4ddd2; }
    .cart-total-label { color:#6b6b6b; font-size:0.95rem; font-weight:600; }
    .cart-total-amount { color:var(--ink); font-size:1.7rem; font-weight:800; line-height:1; white-space:nowrap; }
    .btn-primary { width:100%; margin-top:1rem; padding:0.95rem 1rem; border-radius:12px; border:none; background:var(--ink); color:white; font-weight:700; cursor:pointer; text-align:center; text-decoration:none; display:block; transition:background 0.2s ease, transform 0.2s ease; }
    .btn-primary:hover { background:#333; transform:translateY(-1px); }
    /* Tukšā groza stāvoklis */
    .empty-state { background:white; border:1px dashed #c9c9c9; border-radius:16px; padding:2rem; text-align:center; }
    .empty-state a { color:var(--accent-dark); font-weight:600; text-decoration:none; }
    /* Responsivitāte mazākiem ekrāniem */
    @media(max-width:900px){
        .cart-layout { grid-template-columns:1fr; }
        .cart-item { grid-template-columns:1fr; gap:0.5rem; align-items:flex-start; }
    }
</style>
@endpush

@push('scripts')
<script>
    // Pēc lapas ielādes pieslēdz automātisku daudzuma saglabāšanu.
    document.addEventListener('DOMContentLoaded', () => {
        // Atrod visus daudzuma laukus groza tabulā.
        document.querySelectorAll('.quantity-input').forEach(input => {
            // Debounce taimeris, lai nesūtītu formu uzreiz pēc katras rakstzīmes.
            let debounceTimer;
            input.addEventListener('input', () => {
                // Atrodam formu, kurai pieder konkrētais input.
                const form = input.closest('form');
                if (!form) {
                    return;
                }
                // Nolasa jauno un iepriekšējo daudzumu.
                const newValue = parseInt(input.value, 10);
                const lastValue = parseInt(input.dataset.lastValue || input.defaultValue, 10);
                // Ja vērtība nav mainīta vai nav derīga, neko nedara.
                if (!newValue || newValue === lastValue) {
                    return;
                }
                // Notīra iepriekšējo taimeri un izveido jaunu aizkavi.
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    // Saglabā pēdējo vērtību, lai izvairītos no dubultiem sūtījumiem.
                    input.dataset.lastValue = newValue;
                    // Iesniedz formu, lai atjauninātu groza daudzumu serverī.
                    form.submit();
                }, 500);
            });
        });
    });
</script>
@endpush
@endsection
