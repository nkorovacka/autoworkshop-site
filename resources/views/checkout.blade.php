<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Auto Detailing Workshop</title>
</head>
<body>
<!-- Galvene ar navigāciju un lietotāja darbībām -->
<header>
    <nav>
        <!-- Zīmola nosaukums -->
        <div class="logo">Auto Detailing</div>
        <!-- Galvenā navigācija -->
        <ul class="nav-links">
            <li><a href="{{ route('home') }}">Galvenā</a></li>
            <li><a href="{{ route('services.index') }}">Pakalpojumi</a></li>
            <li><a href="{{ route('products.index') }}">Produkti</a></li>
            <li><a href="{{ route('offers.index') }}">Piedāvājumi</a></li>
            <li><a href="{{ route('our-work') }}">Darbi</a></li>
        </ul>
        <!-- Lietotāja konta darbības -->
        <div class="nav-right">
            <div class="user-greeting">Sveiki, {{ auth()->user()->name }}</div>
            <div class="auth-buttons">
                <a class="btn-cart" href="{{ route('cart.index') }}">🛒 Grozs</a>
                <a class="btn-profile" href="{{ route('profile') }}">👤 Profils</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-logout">Iziet</button>
                </form>
            </div>
        </div>
    </nav>
</header>

<main>
    <!-- Lapas virsraksts un īss apraksts -->
    <h1>Pasūtījuma apmaksa</h1>
    <p class="lead">Ievadi kartes datus un izvēlies piegādes veidu.</p>

    <!-- Kļūdas paziņojums, ja validācija neizdevās -->
    @if($errors->any())
        <div class="flash flash-error">{{ $errors->first() }}</div>
    @endif

    <div class="checkout-grid">
        <!-- Maksājuma forma -->
        <section class="card">
            <h2>Maksājuma informācija</h2>
            <form method="POST" action="{{ route('checkout.store') }}">
                @csrf
                <div class="form-group">
                    <label for="customer_name">Vārds un Uzvārds</label>
                    <input type="text" id="customer_name" name="customer_name" value="{{ old('customer_name', auth()->user()->name) }}" required>
                </div>
                <div class="form-group">
                    <label for="customer_phone">Telefons</label>
                    <input type="text" id="customer_phone" name="customer_phone" value="{{ old('customer_phone') }}" placeholder="+371 20000000" required>
                </div>
                <!-- Kartes dati -->
                <div class="form-group">
                    <label for="card_holder">Kartes īpašnieks</label>
                    <input type="text" id="card_holder" name="card_holder" value="{{ old('card_holder') }}" required>
                </div>
                <div class="form-group">
                    <label for="card_number">Kartes numurs</label>
                    <input type="text" id="card_number" name="card_number" inputmode="numeric" value="{{ old('card_number') }}" required>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="card_expiry">Derīgs līdz (MM/YY)</label>
                        <input type="text" id="card_expiry" name="card_expiry" placeholder="MM/YY" value="{{ old('card_expiry') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="card_cvc">CVC</label>
                        <input type="text" id="card_cvc" name="card_cvc" inputmode="numeric" value="{{ old('card_cvc') }}" required>
                    </div>
                </div>

                <!-- Piegādes veids un adrese -->
                <h2 style="margin-top:1.5rem;">Piegāde</h2>
                <div class="radio-row">
                    <label>
                        <input type="radio" name="shipping_method" value="pickup" {{ old('shipping_method', 'pickup') === 'pickup' ? 'checked' : '' }}>
                        Saņemšu uz vietas salonā
                    </label>
                    <label>
                        <input type="radio" name="shipping_method" value="delivery" {{ old('shipping_method') === 'delivery' ? 'checked' : '' }}>
                        Sūtīt uz adresi
                    </label>
                </div>
                <div class="form-group shipping-address {{ old('shipping_method') === 'delivery' ? 'visible' : '' }}" id="shippingAddressGroup">
                    <label for="shipping_address">Piegādes adrese</label>
                    <input type="text" id="shipping_address" name="shipping_address" value="{{ old('shipping_address') }}" placeholder="Iela, mājas nr., pilsēta">
                </div>

                <!-- Papildu piezīmes -->
                <div class="form-group">
                    <label for="notes">Papildu piezīmes (neobligāti)</label>
                    <textarea id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                </div>

                <!-- Pasūtījuma apstiprināšana -->
                <button type="submit" class="btn-primary">Apstiprināt pasūtījumu</button>
            </form>
        </section>
        <!-- Kopsavilkums ar precēm un summu -->
        <aside class="card">
            <h2>Kopsavilkums</h2>
            <div class="summary-section">
                <div class="summary-item">
                    <span>Produkti</span>
                    <span>{{ number_format($subtotal, 2) }} €</span>
                </div>
                <div class="summary-item">
                    <span>Piegāde</span>
                    <span>Tiks precizēta</span>
                </div>
                <div class="summary-item summary-total">
                    <span>Kopējā summa</span>
                    <span>{{ number_format($subtotal, 2) }} €</span>
                </div>
            </div>
            <div class="item-list">
                @foreach($items as $item)
                    <!-- Viena prece kopsavilkumā -->
                    <div class="item-row">
                        <span>{{ $item->product->name }} × {{ $item->quantity }}</span>
                        <span>{{ number_format($item->unit_price * $item->quantity, 2) }} €</span>
                    </div>
                @endforeach
            </div>
        </aside>
    </div>
</main>

<!-- Kājenes informācija ar kontaktiem un ātrajām saitēm -->
<footer>
    <div class="footer-wrapper">
        <div class="footer-column">
            <h4>Salons</h4>
            <p>Auto Detailing Workshop<br>Brīvības iela 123, Rīga</p>
            <p>Darba laiks:<br>Pirmdiena-Piektdiena 9:00-19:00<br>Brīvdienās nestrādājam</p>
        </div>
        <div class="footer-column">
            <h4>Kontakti</h4>
            <ul>
                <li>📞 +371 2000 0000</li>
                <li>✉️ info@detailing.lv</li>
                <li>WhatsApp & Telegram</li>
            </ul>
        </div>
        <div class="footer-column">
            <h4>Ātrās saites</h4>
            <ul>
                <li><a href="{{ route('services.index') }}">Pakalpojumi</a></li>
                <li><a href="{{ route('products.index') }}">Produkti</a></li>
                <li><a href="{{ route('offers.index') }}">Piedāvājumi</a></li>
                <li><a href="{{ route('booking.create') }}">Rezervēt vizīti</a></li>
            </ul>
        </div>
        <div class="footer-column">
            <h4>Sekojiet mums</h4>
            <ul>
                <li><a href="#">Instagram</a></li>
                <li><a href="#">Facebook</a></li>
                <li><a href="#">YouTube</a></li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        &copy; {{ date('Y') }} Auto Detailing Workshop. Visas tiesības aizsargātas.
    </div>
</footer>

<!-- Iekšējais CSS: novietots pēc HTML, lai atdalītu struktūru no noformējuma -->
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
    /* Galvene un navigācija */
    header { background:white; border-bottom:1px solid var(--border); }
    nav { max-width:1400px; margin:0 auto; padding:1.2rem 2rem; display:flex; justify-content:space-between; align-items:center; }
    .logo { font-weight:600; letter-spacing:-0.5px; font-size:1.15rem; }
    .nav-links { list-style:none; display:flex; gap:1.8rem; }
    .nav-links a { text-decoration:none; color:var(--muted); font-weight:500; transition:color 0.2s; }
    .nav-links a.active, .nav-links a:hover { color:var(--ink); }
    .nav-right { display:flex; align-items:center; gap:1.2rem; }
    .auth-buttons { display:flex; gap:0.6rem; }
    .btn-cart, .btn-profile, .btn-logout { padding:0.45rem 1.1rem; border-radius:8px; text-decoration:none; display:inline-flex; align-items:center; gap:0.4rem; font-weight:500; }
    .btn-cart { border:1px solid var(--border); background:white; color:var(--ink); }
    .btn-profile { border:none; background:var(--ink); color:white; }
    .btn-logout { border:none; background:#f1f1f1; color:var(--ink); cursor:pointer; }
    /* Galvenais saturs */
    main { max-width:1200px; margin:0 auto; padding:2.5rem 2rem 3rem; }
    h1 { font-size:2.2rem; margin-bottom:0.3rem; }
    .lead { color:var(--muted); margin-bottom:1.5rem; }
    .flash { padding:0.9rem 1.1rem; border-radius:12px; margin-bottom:1.5rem; font-weight:500; }
    .flash-error { background:#fdecea; border:1px solid #f3c0b7; color:#b5302c; }
    /* Checkout izkārtojums */
    .checkout-grid { display:grid; grid-template-columns:2fr 1fr; gap:1.5rem; align-items:start; }
    .card { background:white; border:1px solid var(--border); border-radius:18px; padding:1.5rem; }
    .card h2 { font-size:1.3rem; margin-bottom:1rem; }
    .form-group { margin-bottom:1rem; }
    label { display:block; font-weight:600; margin-bottom:0.4rem; }
    input, select, textarea { width:100%; padding:0.65rem 0.9rem; border-radius:10px; border:1px solid var(--border); font-size:1rem; }
    input:focus, select:focus, textarea:focus { outline:none; border-color:var(--accent); box-shadow:0 0 0 3px rgba(255,92,53,0.15); }
    .form-row { display:flex; gap:1rem; }
    .form-row .form-group { flex:1; }
    .radio-row { display:flex; gap:1.5rem; margin-bottom:1rem; }
    .radio-row label { display:flex; align-items:center; gap:0.4rem; font-weight:500; }
    .btn-primary { width:100%; padding:0.9rem; border:none; border-radius:12px; background:var(--ink); color:white; font-weight:600; font-size:1.05rem; cursor:pointer; margin-top:1rem; }
    .summary-section { display:flex; flex-direction:column; gap:0.9rem; }
    .summary-item { display:flex; justify-content:space-between; }
    .summary-total { font-size:1.3rem; font-weight:700; }
    .item-list { border-top:1px solid #f0f0f0; padding-top:1rem; margin-top:1rem; }
    .item-row { display:flex; justify-content:space-between; margin-bottom:0.6rem; font-size:0.95rem; }
    .shipping-address { display:none; }
    .shipping-address.visible { display:block; }
    /* Kājenes noformējums */
    footer { background:white; border-top:1px solid #e8e8e8; margin-top:4rem; }
    .footer-wrapper { max-width:1400px; margin:0 auto; padding:3rem 2rem; display:grid; grid-template-columns:repeat(auto-fit,minmax(220px,1fr)); gap:2rem; color:#555; }
    .footer-column h4 { font-size:1rem; text-transform:uppercase; letter-spacing:0.15rem; color:var(--ink); margin-bottom:1rem; }
    .footer-column ul { list-style:none; display:flex; flex-direction:column; gap:0.6rem; }
    .footer-column a { text-decoration:none; color:#666; }
    .footer-column a:hover { color:var(--ink); }
    .footer-bottom { text-align:center; padding:1.5rem; color:#777; font-size:0.9rem; border-top:1px solid #f0f0f0; }
    /* Responsivitāte mazākiem ekrāniem */
    @media(max-width:900px){
        .checkout-grid { grid-template-columns:1fr; }
        .form-row { flex-direction:column; }
    }
</style>

<script>
    // Piegādes veida radio pogas un adreses lauks.
    const shippingRadios = document.querySelectorAll('input[name=\"shipping_method\"]');
    const shippingGroup = document.getElementById('shippingAddressGroup');

    // Parāda vai paslēpj adreses lauku pēc izvēlētā piegādes veida.
    function toggleAddress() {
        const needsAddress = document.querySelector('input[name=\"shipping_method\"]:checked').value === 'delivery';
        if (needsAddress) {
            shippingGroup.classList.add('visible');
        } else {
            shippingGroup.classList.remove('visible');
        }
    }

    // Reaģē uz piegādes veida izmaiņām.
    shippingRadios.forEach(radio => radio.addEventListener('change', toggleAddress));
    // Inicializācija pēc lapas ielādes.
    document.addEventListener('DOMContentLoaded', toggleAddress);
</script>
</body>
</html>
