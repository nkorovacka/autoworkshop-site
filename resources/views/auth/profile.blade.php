<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mans profils - Auto Detailing</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif; background:#fafafa; color:#1a1a1a; }
        header { background:white; border-bottom:1px solid #e8e8e8; position:sticky; top:0; z-index:100; }
        nav { max-width:1400px; margin:0 auto; padding:1.2rem 2rem; display:flex; justify-content:space-between; align-items:center; }
        .logo { font-size:1.3rem; font-weight:600; letter-spacing:-0.5px; }
        .nav-links { display:flex; list-style:none; gap:2.5rem; }
        .nav-links a { text-decoration:none; color:#666; font-weight:500; }
        .nav-links a:hover, .nav-links a.active { color:#1a1a1a; }
        .nav-right { display:flex; align-items:center; gap:1rem; }
        .auth-buttons { display:flex; gap:0.6rem; align-items:center; }
        .user-greeting { font-weight:600; }
        .btn-cart, .btn-profile, .btn-logout { padding:0.45rem 1rem; border-radius:8px; border:none; text-decoration:none; font-weight:500; cursor:pointer; display:inline-flex; align-items:center; gap:0.3rem; }
        .btn-cart { background:white; border:1px solid #e8e8e8; color:#1a1a1a; }
        .btn-profile { background:#1a1a1a; color:white; }
        .btn-logout { background:#f1f1f1; color:#1a1a1a; }
        .btn-cart:hover { background:#f5f5f5; }
        .btn-profile:hover { background:#333; }
        .btn-logout:hover { background:#dfdfdf; }
        main { max-width:1100px; margin:2rem auto 4rem; background:white; border-radius:24px; padding:3rem; border:1px solid #e8e8e8; display:flex; flex-direction:column; gap:2.5rem; }
        .profile-header { display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid #f0f0f0; padding-bottom:1.5rem; }
        .profile-section { border:1px solid #f4f4f4; border-radius:18px; padding:1.5rem; background:#fafafa; display:flex; flex-direction:column; gap:1rem; }
        .profile-section-header h2 { margin-bottom:0.2rem; font-size:1.3rem; }
        .profile-section-header p { color:#777; font-size:0.95rem; }
        .items-list { display:flex; flex-direction:column; gap:1rem; }
        .item-card { background:white; border-radius:16px; border:1px solid #e8e8e8; padding:1rem 1.5rem; display:flex; justify-content:space-between; gap:1rem; align-items:center; }
        .item-title { font-weight:600; font-size:1.1rem; }
        .item-meta { color:#666; font-size:0.95rem; display:flex; gap:1rem; flex-wrap:wrap; }
        .item-actions { display:flex; gap:0.6rem; align-items:center; }
        .status-pill { padding:0.4rem 1rem; border-radius:999px; background:#e6f5ef; color:#136b3a; font-weight:600; font-size:0.9rem; }
        .status-pill.cancelled { background:#fdecea; color:#b5302c; }
        .cancel-button { border:none; background:none; color:#c0392b; font-weight:600; cursor:pointer; font-size:0.9rem; }
        .cancel-button:hover { text-decoration:underline; }
        .cancel-note { color:#9a3412; font-weight:600; font-size:0.9rem; }
        .flash { padding:0.9rem 1rem; border-radius:12px; font-weight:600; }
        .flash-success { background:#e6f5ef; color:#136b3a; border:1px solid #b7e2c9; }
        .flash-error { background:#fdecea; color:#b5302c; border:1px solid #f3c0b7; }
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
    @if(session('success'))
        <div class="flash flash-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="flash flash-error">{{ session('error') }}</div>
    @endif
    <section class="profile-header">
        <div>
            <h1>Sveiki, {{ $user->name }}</h1>
            <p>{{ $user->email }}</p>
        </div>
    </section>

    <section class="profile-section">
        <div class="profile-section-header">
            <h2>Mani vebināri</h2>
            <p>Aktīvie un gaidāmie pieteikumi</p>
        </div>
        @if($webinarRegistrations->isEmpty())
            <p>Nav pieteikumu vebināriem.</p>
        @else
            <div class="items-list">
                @foreach($webinarRegistrations as $registration)
                    @php
                        $eventDate = $registration->offer && $registration->offer->event_date
                            ? \Carbon\Carbon::parse($registration->offer->event_date)->startOfDay()
                            : null;
                        $isTooLateToCancel = $eventDate && now()->startOfDay()->greaterThanOrEqualTo($eventDate);
                    @endphp
                    <div class="item-card">
                        <div>
                            <div class="item-title">
                                @if($registration->offer && $registration->offer->title)
                                    Vebinārs: {{ $registration->offer->title }}
                                @elseif($registration->offer)
                                    Vebinārs (bez nosaukuma)
                                @else
                                    Vebinārs (piedāvājums nav atrasts)
                                @endif
                            </div>
                            <div class="item-meta">
                                @if($registration->offer && $registration->offer->event_date)
                                    <span>📅 {{ \Carbon\Carbon::parse($registration->offer->event_date)->locale('lv')->translatedFormat('d. F H:i') }}</span>
                                @endif
                                <span>Formatā: {{ ($registration->offer->format ?? 'online') === 'in_person' ? 'klātienē' : 'tiešsaistē' }}</span>
                            </div>
                        </div>
                        <div class="item-actions">
                            <span class="status-pill">Pieteikts</span>
                            @if($isTooLateToCancel)
                                <span class="cancel-note">Atcelšana nav pieejama vebināra dienā.</span>
                            @else
                                <form method="POST"
                                      action="{{ route('profile.webinars.cancel', $registration) }}"
                                      onsubmit="return confirm('Vai tiešām atcelt šo vebināru?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="cancel-button">Atcelt</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>

    <section class="profile-section">
        <div class="profile-section-header">
            <h2>Servisa vēsture</h2>
            <p>Booking pieteikumi un statuss</p>
        </div>
        @if($serviceBookings->isEmpty())
            <p>Servisa pieteikumu vēl nav.</p>
        @else
            <div class="items-list">
                @foreach($serviceBookings as $booking)
                    <div class="item-card">
                        <div>
                            <div class="item-title">{{ $booking->car_model ?? 'Auto' }}</div>
                            <div class="item-meta">
                                @if($booking->date)
                                    <span>📅 {{ \Carbon\Carbon::parse($booking->date)->translatedFormat('d.m.Y') }}</span>
                                @endif
                                @if($booking->time_slot)
                                    <span>⏰ {{ $booking->time_slot }}</span>
                                @endif
                            </div>
                        </div>
                        @php
                            $status = $booking->status ?? 'pending';
                            $statusLabels = [
                                'pending' => 'Apstrādē',
                                'approved' => 'Apstiprināts',
                                'rejected' => 'Atteikts',
                            ];
                        @endphp
                        <div class="item-actions">
                            <span class="status-pill {{ $status === 'rejected' ? 'cancelled' : '' }}">
                                {{ $statusLabels[$status] ?? ucfirst($status) }}
                            </span>
                            <form method="POST"
                                  action="{{ route('profile.bookings.cancel', $booking) }}"
                                  onsubmit="return confirm('Vai tiešām atcelt šo rezervāciju?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="cancel-button">Atcelt</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>

    <section class="profile-section">
        <div class="profile-section-header">
            <h2>Produktu pasūtījumi</h2>
            <p>Grozā iegādātie produkti</p>
        </div>
        @if($orders->isEmpty())
            <p>Vēl nav pasūtījumu.</p>
        @else
            <div class="items-list">
                @foreach($orders as $order)
                    <div class="item-card">
                        <div>
                            <div class="item-title">Pasūtījums #{{ $order->id }}</div>
                            <div class="item-meta">
                                <span>{{ $order->total_items }} produkti</span>
                                <span>{{ number_format($order->total_price, 2) }} €</span>
                                <span>{{ \Carbon\Carbon::parse($order->created_at)->translatedFormat('d.m.Y') }}</span>
                            </div>
                            @if($order->items->count())
                                <ul style="margin-top:0.5rem; color:#555; font-size:0.95rem;">
                                    @foreach($order->items as $item)
                                        <li>{{ $item->product->name ?? 'Produkts' }} × {{ $item->quantity }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                        <div class="item-actions">
                            <span class="status-pill {{ $order->status === 'cancelled' ? 'cancelled' : '' }}">{{ ucfirst($order->status) }}</span>
                            @if($order->status !== 'cancelled')
                                <form method="POST"
                                      action="{{ route('profile.orders.cancel', $order) }}"
                                      onsubmit="return confirm('Vai tiešām atcelt šo pasūtījumu?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="cancel-button">Atcelt</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>
</main>
</body>
</html>
