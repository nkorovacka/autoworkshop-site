@extends('layouts.public')

@section('title', 'Mans profils - Auto Detailing')

@push('styles')
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;
            background:#f7f7f7;
            color:#1a1a1a;
        }
        main { max-width:1200px; margin:2.5rem auto 4rem; padding:0 2rem; display:flex; flex-direction:column; gap:2.5rem; }
        .profile-shell {
            background:#fffaf6;
            border-radius:32px;
            padding:3rem;
            border:1px solid #f4ddd2;
            box-shadow:0 20px 40px rgba(24, 24, 27, 0.06);
            display:flex;
            flex-direction:column;
            gap:2rem;
            position:relative;
            overflow:hidden;
        }
        .profile-header {
            display:flex;
            justify-content:space-between;
            align-items:center;
            padding:1.8rem 2rem;
            border:1px solid #e5e7eb;
            border-radius:24px;
            background:#ffffff;
            position:relative;
            z-index:1;
        }
        .profile-header h1 {
            font-size:2rem;
            letter-spacing:-0.03em;
            margin-bottom:0.35rem;
        }
        .profile-header p { color:#6b7280; font-size:1rem; }
        .profile-section {
            border:1px solid #f2ddd2;
            border-radius:24px;
            padding:1.5rem;
            background:#fff7f2;
            display:flex;
            flex-direction:column;
            gap:1rem;
            box-shadow:0 10px 24px rgba(17,24,39,0.04);
            position:relative;
            z-index:1;
        }
        .profile-section-header {
            display:flex;
            flex-direction:column;
            gap:0.35rem;
            padding-bottom:0.9rem;
            border-bottom:1px solid rgba(17,24,39,0.06);
        }
        .profile-section-header h2 {
            margin-bottom:0.2rem;
            font-size:1.3rem;
            letter-spacing:-0.02em;
        }
        .profile-section-header p { color:#777; font-size:0.95rem; }
        .items-list { display:flex; flex-direction:column; gap:1rem; }
        .item-card {
            background:#fffdfb;
            border-radius:20px;
            border:1px solid #f0e2d9;
            padding:1.15rem 1.35rem;
            display:flex;
            justify-content:space-between;
            gap:1rem;
            align-items:center;
            box-shadow:0 10px 24px rgba(17,24,39,0.04);
            transition:transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        }
        .item-card:hover {
            transform:translateY(-2px);
            box-shadow:0 16px 32px rgba(17,24,39,0.08);
            border-color:#e9c8b7;
        }
        .item-title { font-weight:700; font-size:1.08rem; color:#111827; }
        .item-meta { color:#666; font-size:0.95rem; display:flex; gap:0.75rem; flex-wrap:wrap; margin-top:0.35rem; }
        .item-meta span {
            display:inline-flex;
            align-items:center;
            min-height:32px;
            padding:0.3rem 0.75rem;
            border-radius:999px;
            background:#fff1e8;
            color:#4b5563;
            border:1px solid #f1d7ca;
        }
        .item-actions { display:flex; gap:0.6rem; align-items:center; flex-wrap:wrap; }
        .status-pill {
            padding:0.5rem 1rem;
            border-radius:999px;
            background:#e6f5ef;
            color:#136b3a;
            font-weight:700;
            font-size:0.88rem;
            border:1px solid #cce9d8;
        }
        .status-pill.cancelled { background:#fdecea; color:#b5302c; border-color:#f4c8c0; }
        .cancel-button {
            border:none;
            background:#fff3f1;
            color:#c0392b;
            font-weight:700;
            cursor:pointer;
            font-size:0.9rem;
            padding:0.55rem 0.9rem;
            border-radius:999px;
        }
        .cancel-button:hover { background:#ffe7e2; }
        .cancel-note { color:#9a3412; font-weight:600; font-size:0.9rem; }
        .flash { padding:0.9rem 1rem; border-radius:14px; font-weight:600; position:relative; z-index:1; }
        .flash-success { background:#e6f5ef; color:#136b3a; border:1px solid #b7e2c9; }
        .flash-error { background:#fdecea; color:#b5302c; border:1px solid #f3c0b7; }
        @media (max-width: 900px) {
            main { padding:0 1.5rem; }
            .profile-shell { padding:2rem; border-radius:26px; }
            .profile-header { padding:1.4rem; }
            .item-card { flex-direction:column; align-items:flex-start; }
            .item-actions { flex-wrap:wrap; }
        }
    </style>
@endpush

@section('content')
<main>
    <div class="profile-shell">
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
                                    <span>{{ \Carbon\Carbon::parse($registration->offer->event_date)->locale('lv')->translatedFormat('d. F H:i') }}</span>
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
                                    <span>{{ \Carbon\Carbon::parse($booking->date)->translatedFormat('d.m.Y') }}</span>
                                @endif
                                @if($booking->time_slot)
                                    <span>{{ $booking->time_slot }}</span>
                                @endif
                            </div>
                            @if($booking->services->isNotEmpty())
                                <div style="margin-top:0.5rem; color:#555; font-size:0.95rem;">
                                    {{ $booking->services->pluck('name')->join(', ') }}
                                </div>
                            @endif
                        </div>
                        @php
                            $status = $booking->status ?? 'pending';
                            $statusLabels = [
                                'pending' => 'Procesā',
                                'approved' => 'Apstiprināts',
                                'rejected' => 'Atcelts',
                            ];
                        @endphp
                        <div class="item-actions">
                            <span class="status-pill {{ $status === 'rejected' ? 'cancelled' : '' }}">
                                {{ $statusLabels[$status] ?? ucfirst($status) }}
                            </span>
                            @if($status === 'pending')
                                <form method="POST"
                                      action="{{ route('profile.bookings.cancel', $booking) }}"
                                      onsubmit="return confirm('Vai tiešām atcelt šo rezervāciju?');">
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
                            @php
                                $orderStatus = $order->status ?? 'pending';
                                $orderStatusLabels = [
                                    'pending' => 'Apstrādē',
                                    'processing' => 'Apstrādē',
                                    'shipped' => 'Izsūtīts',
                                    'completed' => 'Izsūtīts',
                                    'cancelled' => 'Atcelts',
                                ];
                                $orderStatusLabel = $orderStatusLabels[$orderStatus] ?? ucfirst($orderStatus);
                            @endphp
                            <span class="status-pill {{ $orderStatus === 'cancelled' ? 'cancelled' : '' }}">{{ $orderStatusLabel }}</span>
                            @if(!in_array($orderStatus, ['cancelled', 'completed', 'shipped'], true))
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
    </div>
</main>
@endsection
