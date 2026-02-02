<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <title>Pakalpojumu pieteikumi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<!-- Admin paneļa galvene ar lietotāja informāciju un navigāciju -->
<header>
    <div class="admin-top">
        <div>
            <strong>Admin panelis</strong>
            <div style="color:#9ca3af; font-size:0.9rem;">Sveiki, {{ auth()->user()->name }}</div>
        </div>
        <div>
            <a href="{{ route('home') }}">← Publiskā lapa</a>
        </div>
    </div>
    <nav class="admin-nav">
        <a href="{{ route('admin.bookings') }}" class="{{ request()->routeIs('admin.bookings') ? 'active' : '' }}">Pakalpojumi</a>
        <a href="{{ route('admin.products') }}" class="{{ request()->routeIs('admin.products*') ? 'active' : '' }}">Produkti & pasūtījumi</a>
        <a href="{{ route('admin.offers') }}" class="{{ request()->routeIs('admin.offers*') ? 'active' : '' }}">Piedāvājumi</a>
        <a href="{{ route('admin.work-items') }}" class="{{ request()->routeIs('admin.work-items*') ? 'active' : '' }}">Darbi</a>
        <a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users*') ? 'active' : '' }}">Lietotāji</a>
    </nav>
</header>

<main>
    <!-- Veiksmes paziņojums pēc statusa maiņas -->
    @if(session('success'))
        <div class="flash flash-success">{{ session('success') }}</div>
    @endif

    <!-- Pieteikumu tabula ar detalizētu informāciju un darbībām -->
    <table>
        <thead>
        <tr>
            <th>Klients</th>
            <th>Auto</th>
            <th>Datums</th>
            <th>Laiks</th>
            <th>Statuss</th>
            <th>Darbības</th>
        </tr>
        </thead>
        <tbody>
        <!-- Saraksts ar pieteikumiem; ja nav, parāda tukšu stāvokli -->
        @forelse($bookings as $booking)
            <tr>
                <td>
                    <div>{{ $booking->customer_name }}</div>
                    <div style="color:#6b7280; font-size:0.9rem;">{{ $booking->customer_phone }}</div>
                </td>
                <!-- Auto modelis, kuru klients pieteicis -->
                <td>{{ $booking->car_model }}</td>
                <!-- Rezervācijas datums -->
                <td>{{ $booking->date }}</td>
                <!-- Rezervācijas laika slots -->
                <td>{{ $booking->time_slot }}</td>
                <!-- Statusa nozīmīte ar krāsojumu pēc statusa -->
                <td><span class="status-pill {{ $booking->status }}">{{ $booking->status }}</span></td>
                <td>
                    <div class="actions">
                        <!-- Apstiprināšanas darbība -->
                        <form method="POST" action="{{ route('admin.bookings.update', $booking) }}">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="approved">
                            <button class="btn-approve" type="submit">Apstiprināt</button>
                        </form>
                        <!-- Atteikšanas darbība -->
                        <form method="POST" action="{{ route('admin.bookings.update', $booking) }}">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="rejected">
                            <button class="btn-reject" type="submit">Atteikt</button>
                        </form>
                        <!-- Atjaunošana uz "pending", ja statuss nav gaidošs -->
                        @if($booking->status !== 'pending')
                            <form method="POST" action="{{ route('admin.bookings.update', $booking) }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="pending">
                                <button class="btn-reset" type="submit">Atjaunot</button>
                            </form>
                        @endif
                    </div>
                </td>
            </tr>
        @empty
            <!-- Tukšs stāvoklis, ja nav neviena pieteikuma -->
            <tr><td colspan="6">Nav pieteikumu.</td></tr>
        @endforelse
        </tbody>
    </table>

    <!-- Lapošanas saites, ja ir daudz pieteikumu -->
    {{ $bookings->links() }}
</main>

<!-- Iekšējais CSS: atrodas pēc HTML, lai vieglāk uzturēt struktūru un stilus atsevišķi -->
<style>
    /* Pamata izkārtojums un krāsas admin panelim */
    body { font-family:'Inter',sans-serif; margin:0; background:#f4f5f7; color:#111; }
    header { background:#111827; color:white; padding:1.2rem 2rem; }
    .admin-top { display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:0.8rem; }
    .admin-nav { display:flex; gap:0.8rem; flex-wrap:wrap; margin-top:0.9rem; }
    .admin-nav a { color:#9ca3af; text-decoration:none; padding:0.35rem 0.9rem; border:1px solid transparent; border-radius:999px; }
    .admin-nav a.active { border-color:#f59e0b; color:#fde68a; }
    .admin-nav a:hover { color:white; border-color:#4b5563; }

    /* Galvenā satura zona un tabulas vizuālais noformējums */
    main { max-width:1200px; margin:2rem auto; padding:0 2rem 3rem; display:flex; flex-direction:column; gap:1.5rem; }
    table { width:100%; border-collapse:collapse; background:white; border-radius:16px; overflow:hidden; box-shadow:0 10px 30px rgba(0,0,0,0.05); }
    th, td { padding:0.9rem 1rem; border-bottom:1px solid #f3f4f6; }
    th { background:#f9fafb; text-align:left; font-weight:600; color:#6b7280; }
    tr:last-child td { border-bottom:none; }

    /* Statusa nozīmītes krāsojums atkarībā no statusa */
    .status-pill { padding:0.25rem 0.8rem; border-radius:999px; font-weight:600; font-size:0.85rem; text-transform:capitalize; }
    .status-pill.pending { background:#fff4e6; color:#b34700; }
    .status-pill.approved { background:#e6f5ef; color:#136b3a; }
    .status-pill.rejected { background:#fdecea; color:#b5302c; }

    /* Darbību pogas un izkārtojums */
    .actions { display:flex; gap:0.5rem; }
    button { border:none; border-radius:8px; padding:0.5rem 0.9rem; cursor:pointer; font-weight:600; }
    .btn-approve { background:#0f9d58; color:white; }
    .btn-reject { background:#ef4444; color:white; }
    .btn-reset { background:#e5e7eb; color:#111; }

    /* Paziņojumu (flash) izskats */
    .flash { padding:0.9rem 1rem; border-radius:12px; font-weight:600; }
    .flash-success { background:#e6f5ef; color:#136b3a; border:1px solid #b7e2c9; }
</style>
</body>
</html>
