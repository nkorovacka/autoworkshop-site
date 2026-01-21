<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grozs - Auto Detailing Workshop</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        :root {
            --accent:#ff5c35;
            --accent-dark:#d94516;
            --ink:#181818;
            --muted:#6f6f6f;
            --border:#ededed;
            --card:#ffffff;
        }
        body { font-family:"Inter", Arial, sans-serif; background:#f7f7f7; color:var(--ink); line-height:1.6; }
        header { background:white; border-bottom:1px solid var(--border); }
        footer { background:white; border-top:1px solid #e8e8e8; margin-top:4rem; }
        .footer-wrapper { max-width:1400px; margin:0 auto; padding:3rem 2rem; display:grid; grid-template-columns:repeat(auto-fit,minmax(220px,1fr)); gap:2rem; color:#555; }
        .footer-column h4 { font-size:1rem; text-transform:uppercase; letter-spacing:0.15rem; color:var(--ink); margin-bottom:1rem; }
        .footer-column ul { list-style:none; display:flex; flex-direction:column; gap:0.6rem; }
        .footer-column a { text-decoration:none; color:#666; }
        .footer-column a:hover { color:var(--ink); }
        .footer-bottom { text-align:center; padding:1.5rem; color:#777; font-size:0.9rem; border-top:1px solid #f0f0f0; }
        nav { max-width:1400px; margin:0 auto; padding:1.2rem 2rem; display:flex; justify-content:space-between; align-items:center; }
        .logo { font-weight:600; letter-spacing:-0.5px; font-size:1.15rem; }
        .nav-links { list-style:none; display:flex; gap:1.8rem; }
        .nav-links a { text-decoration:none; color:var(--muted); font-weight:500; transition:color 0.2s; }
        .nav-links a.active, .nav-links a:hover { color:var(--ink); }
        .nav-right { display:flex; align-items:center; gap:1.2rem; }
        .icon-button { background:none; border:none; font-size:1.2rem; color:var(--muted); cursor:pointer; }
        .auth-buttons { display:flex; gap:0.8rem; }
        .auth-buttons.signed-in { gap:0.6rem; }
        .btn-login, .btn-signup { padding:0.45rem 1.1rem; border-radius:8px; font-size:0.85rem; font-weight:500; cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; justify-content:center; }
        .btn-login { border:1px solid var(--border); background:none; }
        .btn-login:hover { background:#f5f5f5; }
        .btn-signup { border:none; background:var(--ink); color:white; }
        .btn-profile { border:none; background:var(--ink); color:white; padding:0.45rem 1.1rem; border-radius:8px; font-size:0.85rem; font-weight:500; text-decoration:none; display:inline-flex; align-items:center; gap:0.4rem; }
        .btn-profile:hover { background:#333; }
        .btn-cart { border:1px solid var(--border); background:white; color:var(--ink); padding:0.45rem 1.1rem; border-radius:8px; font-size:0.85rem; font-weight:500; text-decoration:none; display:inline-flex; align-items:center; gap:0.4rem; }
        .btn-cart:hover { background:#f5f5f5; }
        .user-greeting { font-size:0.85rem; font-weight:600; color:var(--ink); white-space:nowrap; }
        .logout-form { margin:0; }
        .btn-logout { border:none; background:#f1f1f1; color:var(--ink); padding:0.45rem 1rem; border-radius:8px; font-size:0.85rem; font-weight:500; cursor:pointer; transition:background 0.2s; }
        .btn-logout:hover { background:#dfdfdf; }

        main { max-width:1200px; margin:0 auto; padding:2.5rem 2rem 3rem; }
        h1 { font-size:2.2rem; margin-bottom:0.3rem; }
        .lead { color:var(--muted); margin-bottom:1.5rem; }

        .alert { padding:0.9rem 1.1rem; border-radius:12px; margin-bottom:1.5rem; font-weight:500; }
        .alert-success { background:#e6f5ef; color:#136b3a; border:1px solid #b7e2c9; }
        .alert-error { background:#fdecea; color:#b5302c; border:1px solid #f3c0b7; }

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

        .cart-summary { background:white; border:1px solid var(--border); border-radius:16px; padding:1.3rem; }
        .summary-row { display:flex; justify-content:space-between; margin-bottom:0.8rem; color:#6b6b6b; }
        .summary-total { font-size:1.3rem; font-weight:700; color:var(--ink); }
        .btn-primary { width:100%; margin-top:1rem; padding:0.9rem; border-radius:12px; border:none; background:var(--ink); color:white; font-weight:600; cursor:pointer; }
        .empty-state { background:white; border:1px dashed #c9c9c9; border-radius:16px; padding:2rem; text-align:center; }
        .empty-state a { color:var(--accent-dark); font-weight:600; text-decoration:none; }

        @media(max-width:900px){
            .cart-layout { grid-template-columns:1fr; }
            .cart-item { grid-template-columns:1fr; gap:0.5rem; align-items:flex-start; }
        }
    </style>
</head>
<body>
<header>
    <nav>
        <div class="logo">Auto Detailing</div>
        <ul class="nav-links">
            <li><a href="{{ route('home') }}">Galvenā</a></li>
            <li><a href="{{ route('services.index') }}">Pakalpojumi</a></li>
            <li><a href="{{ route('products.index') }}">Produkti</a></li>
            <li><a href="{{ route('offers.index') }}">Piedāvājumi</a></li>
            <li><a href="{{ route('our-work') }}">Darbi</a></li>
        </ul>
        <div class="nav-right">
            <div class="user-greeting">Sveiki, {{ auth()->user()->name }}</div>
            <div class="auth-buttons signed-in">
                <a class="btn-cart" href="{{ route('cart.index') }}">🛒 Grozs</a>
                <a class="btn-profile" href="{{ route('profile') }}">👤 Profils</a>
                <form method="POST" action="{{ route('logout') }}" class="logout-form">
                    @csrf
                    <button type="submit" class="btn-logout">Iziet</button>
                </form>
            </div>
        </div>
    </nav>
</header>

<main>
    <h1>Tavs grozs</h1>
    <p class="lead">Pārskati produktus un turpini ar pasūtījumu.</p>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-error">{{ $errors->first() }}</div>
    @endif

    @if($items->count())
        <div class="cart-layout">
            <section class="cart-items">
                @foreach($items as $item)
                    <article class="cart-item">
                        <div>
                            <h3>{{ $item->product->name ?? 'Produkts nav pieejams' }}</h3>
                            <p>{{ number_format($item->unit_price, 2) }} € / gab.</p>
                        </div>
                        <div>
                            <strong>{{ number_format($item->unit_price * $item->quantity, 2) }} €</strong>
                        </div>
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
                        <form method="POST" action="{{ route('cart.destroy', $item) }}" class="remove-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" title="Izņemt">×</button>
                        </form>
                    </article>
                @endforeach
            </section>
            <aside class="cart-summary">
                <h2>Kopsavilkums</h2>
                <div class="summary-row">
                    <span>Starpsumma</span>
                    <span>{{ number_format($subtotal, 2) }} €</span>
                </div>
                <div class="summary-row">
                    <span>Piegāde</span>
                    <span>Aprēķināsim individuāli</span>
                </div>
                <div class="summary-row summary-total">
                    <span>Kopā</span>
                    <span>{{ number_format($subtotal, 2) }} €</span>
                </div>
                <a class="btn-primary" href="{{ route('checkout.index') }}">Turpināt pasūtījumu</a>
            </aside>
        </div>
    @else
        <div class="empty-state">
            <p>Grozs ir tukšs. Dodies uz <a href="{{ route('products.index') }}">produktu kataloga lapu</a> un izvēlies sev nepieciešamos līdzekļus.</p>
        </div>
    @endif
</main>

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
<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.quantity-input').forEach(input => {
            let debounceTimer;
            input.addEventListener('input', () => {
                const form = input.closest('form');
                if (!form) {
                    return;
                }
                const newValue = parseInt(input.value, 10);
                const lastValue = parseInt(input.dataset.lastValue || input.defaultValue, 10);
                if (!newValue || newValue === lastValue) {
                    return;
                }
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    input.dataset.lastValue = newValue;
                    form.submit();
                }, 500);
            });
        });
    });
</script>
</body>
</html>
