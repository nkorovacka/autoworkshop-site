<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <title>Piedāvājumu pārvaldība</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<!-- Admin panelis: galvene ar lietotāja vārdu un navigāciju -->
<header>
    <div class="admin-top">
        <div>
            <strong>Admin panelis</strong>
            <div style="color:#9ca3af; font-size:0.9rem;">Sveiki, {{ auth()->user()->name }}</div>
        </div>
        <div>
            <a href="{{ route('home') }}" style="color:#9ca3af;">← Publiskā lapa</a>
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
    <!-- Flash paziņojumi par veiksmēm/kļūdām pēc darbībām -->
    @if(session('success'))
        <div class="flash flash-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="flash flash-error">{{ session('error') }}</div>
    @endif

    <!-- Forma jauna vebināra/piedāvājuma izveidei -->
    <section class="panel">
        <h2>Pievienot vebināru</h2>
        <form method="POST" action="{{ route('admin.offers.store') }}">
            @csrf
            <!-- Nosaukums un apraksts ir obligāti -->
            <input type="text" name="title" placeholder="Nosaukums" required value="{{ old('title') }}">
            <textarea name="description" rows="3" placeholder="Apraksts" required>{{ old('description') }}</textarea>
            <!-- Pasākuma datums/laiks -->
            <input type="datetime-local" name="event_date" value="{{ old('event_date') }}" required>
            <!-- Dalībnieku skaits un checkboxu sinhronizācija ar JS -->
            <input type="number" name="capacity" placeholder="Dalībnieku skaits" value="{{ old('capacity') }}" class="capacity-input" data-confirm-target="createUnlimitedConfirm" data-limit-target="createLimited">
            <!-- Pasākuma formāts -->
            <select name="format" required>
                <option value="online" {{ old('format') === 'online' ? 'selected' : '' }}>Tiešsaistē</option>
                <option value="in_person" {{ old('format') === 'in_person' ? 'selected' : '' }}>Klātienē</option>
            </select>
            <!-- Limits ieslēdz ierobežotu dalībnieku skaitu -->
            <label style="display:flex; gap:0.5rem; align-items:center;">
                <input type="checkbox" id="createLimited" name="is_limited" value="1" {{ old('is_limited') ? 'checked' : '' }}> Ierobežots dalībnieku skaits
            </label>
            <!-- Apstiprinājums neierobežotam pasākumam -->
            <label style="display:flex; gap:0.5rem; align-items:center; font-size:0.9rem;">
                <input type="checkbox" id="createUnlimitedConfirm" name="confirm_unlimited" value="1" {{ old('confirm_unlimited') ? 'checked' : '' }}>
                Apstiprinu, ka šim pasākumam nav vietu limita (neierobežots)
            </label>
            <!-- Iesniegšanas poga -->
            <button class="btn-primary" type="submit">Saglabāt piedāvājumu</button>
        </form>
    </section>

    <!-- Esošo vebināru rediģēšanas saraksts -->
    <section class="panel">
        <h2>Esošie vebināri</h2>
        @forelse($offers as $offer)
            @php
                $eventValue = $offer->event_date ? \Carbon\Carbon::parse($offer->event_date)->format('Y-m-d\TH:i') : '';
            @endphp
            <details style="margin-bottom:1rem;">
                <!-- Summary rāda vebināra nosaukumu un formātu -->
                <summary>{{ $offer->title }} ({{ $offer->format === 'in_person' ? 'Klātienē' : 'Tiešsaistē' }})</summary>
                <form method="POST" action="{{ route('admin.offers.update', $offer) }}" style="margin-top:0.8rem;">
                    @csrf
                    @method('PATCH')
                    <!-- Pamata lauki rediģēšanai -->
                    <input type="text" name="title" value="{{ $offer->title }}" required>
                    <textarea name="description" rows="3" required>{{ $offer->description }}</textarea>
                    <input type="datetime-local" name="event_date" value="{{ $eventValue }}">
                    <!-- Kapacitāte un checkboxu sinhronizācija -->
                    <input type="number" name="capacity" value="{{ $offer->capacity }}" class="capacity-input" data-confirm-target="confirmUnlimited{{ $offer->id }}" data-limit-target="limited{{ $offer->id }}">
                    <select name="format" required>
                        <option value="online" {{ $offer->format === 'online' ? 'selected' : '' }}>Tiešsaistē</option>
                        <option value="in_person" {{ $offer->format === 'in_person' ? 'selected' : '' }}>Klātienē</option>
                    </select>
                    <!-- Ierobežots/aktīvs status -->
                    <label style="display:flex; gap:0.5rem; align-items:center;">
                        <input type="checkbox" id="limited{{ $offer->id }}" name="is_limited" value="1" {{ $offer->is_limited ? 'checked' : '' }}> Ierobežots
                    </label>
                    <label style="display:flex; gap:0.5rem; align-items:center;">
                        <input type="checkbox" name="is_active" value="1" {{ $offer->is_active ? 'checked' : '' }}> Aktīvs
                    </label>
                    <!-- Apstiprinājums neierobežotam pasākumam -->
                    <label style="display:flex; gap:0.5rem; align-items:center; font-size:0.9rem;">
                        <input type="checkbox" id="confirmUnlimited{{ $offer->id }}" name="confirm_unlimited" value="1">
                        Apstiprinu neierobežotu vietu skaitu
                    </label>
                    <button class="btn-primary" type="submit">Atjaunināt</button>
                    <!-- Pieteikušos skaits un kapacitāte -->
                    <p style="color:#6b7280; font-size:0.9rem;">Pieteikušies: {{ $offer->registrations_count }} / {{ $offer->capacity ?? '∞' }}</p>
                </form>
                <!-- Piedāvājuma dzēšana ar apstiprinājumu -->
                <form method="POST" action="{{ route('admin.offers.destroy', $offer) }}" onsubmit="return confirm('Dzēst piedāvājumu?');" style="margin-top:0.6rem;">
                    @csrf
                    @method('DELETE')
                    <button class="btn-danger" type="submit">Dzēst piedāvājumu</button>
                </form>
            </details>
        @empty
            <!-- Tukšs stāvoklis, ja nav izveidotu piedāvājumu -->
            <p>Nav izveidotu piedāvājumu.</p>
        @endforelse
    </section>

    <!-- Pieteikumu tabula vebināriem -->
    <section class="panel">
        <h2>Vebināru pieteikumi</h2>
        <table>
            <thead>
            <tr>
                <th>Dalībnieks</th>
                <th>E-pasts</th>
                <th>Piedāvājums</th>
                <th>Pieteikuma datums</th>
                <th>Darbība</th>
            </tr>
            </thead>
            <tbody>
            @forelse($registrations as $registration)
                <tr>
                    <!-- Dalībnieka vārds un e-pasts -->
                    <td>{{ $registration->name ?? optional($registration->user)->name }}</td>
                    <td>{{ $registration->email ?? optional($registration->user)->email }}</td>
                    <!-- Piedāvājuma nosaukums vai norāde, ja tas dzēsts -->
                    <td>{{ $registration->offer->title ?? 'Dzēsts piedāvājums' }}</td>
                    <!-- Pieteikuma izveides datums -->
                    <td>{{ $registration->created_at }}</td>
                    <td>
                        <!-- Pieteikuma dzēšana ar apstiprinājumu -->
                        <form method="POST"
                              action="{{ route('admin.offers.registrations.destroy', $registration) }}"
                              onsubmit="return confirm('Dzēst pieteikumu?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn-danger" type="submit">Dzēst</button>
                        </form>
                    </td>
                </tr>
            @empty
                <!-- Tukšs stāvoklis, ja nav pieteikumu -->
                <tr><td colspan="5">Nav pieteikumu.</td></tr>
            @endforelse
            </tbody>
        </table>

        <!-- Lapošanas saites pieteikumu sarakstam -->
{{ $registrations->links() }}
</section>
</main>
<!-- JS: sinhronizē kapacitātes lauku ar "neierobežots" checkboxiem -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.capacity-input').forEach(input => {
            const confirmId = input.dataset.confirmTarget;
            const confirmBox = document.getElementById(confirmId);
            const limitBox = document.getElementById(input.dataset.limitTarget);
            if (!confirmBox) {
                return;
            }
            const sync = () => {
                const hasValue = input.value.trim() !== '';
                confirmBox.disabled = hasValue;
                confirmBox.required = !hasValue;
                if (hasValue) {
                    confirmBox.checked = false;
                }

                if (limitBox) {
                    limitBox.disabled = !hasValue;
                    if (!hasValue) {
                        limitBox.checked = false;
                    }
                }
            };
            sync();
            input.addEventListener('input', sync);
        });
    });
</script>

<!-- Iekšējie stili: novietoti pēc HTML, lai atdalītu struktūru no noformējuma -->
<style>
    /* Lapas pamata tipogrāfija un fona krāsas */
    body { font-family:'Inter',sans-serif; background:#f4f5f7; margin:0; color:#111; }

    /* Galvene ar tumšu fonu un baltu tekstu */
    header { background:#111827; color:white; padding:1.2rem 2rem; }
    .admin-top { display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:0.8rem; }

    /* Navigācijas saites admin sadaļām */
    .admin-nav { display:flex; gap:0.8rem; flex-wrap:wrap; margin-top:0.9rem; }
    .admin-nav a { color:#9ca3af; text-decoration:none; padding:0.35rem 0.9rem; border:1px solid transparent; border-radius:999px; }
    .admin-nav a.active { border-color:#f59e0b; color:#fde68a; }
    .admin-nav a:hover { color:white; border-color:#4b5563; }

    /* Galvenais satura izvietojums un paneļu atstarpes */
    main { max-width:1200px; margin:2rem auto 4rem; padding:0 2rem; display:flex; flex-direction:column; gap:2rem; }

    /* Paneļu noformējums */
    .panel { background:white; border-radius:18px; border:1px solid #e5e7eb; padding:1.5rem; box-shadow:0 15px 30px rgba(15,23,42,0.05); }
    h2 { margin-top:0; }

    /* Formu lauki un pogas */
    form { display:flex; flex-direction:column; gap:0.8rem; }
    input, textarea, select { padding:0.7rem 0.9rem; border-radius:10px; border:1px solid #d1d5db; font-size:0.95rem; }
    button { border:none; border-radius:10px; padding:0.75rem 1.1rem; font-weight:600; cursor:pointer; }
    .btn-primary { background:#111827; color:white; }
    .btn-secondary { background:#e5e7eb; color:#111; }
    .btn-danger { background:#ef4444; color:white; }

    /* Salokāmie bloki esošajiem piedāvājumiem */
    details { border:1px solid #e5e7eb; border-radius:14px; padding:1rem; background:#fcfcfc; }
    summary { font-weight:600; cursor:pointer; }

    /* Flash paziņojumi par kļūdām/veiksmēm */
    .flash { padding:0.9rem 1rem; border-radius:12px; font-weight:600; }
    .flash-success { background:#e6f5ef; color:#136b3a; border:1px solid #b7e2c9; }
    .flash-error { background:#fdecea; color:#b5302c; border:1px solid #f3c0b7; }

    /* Tabulas noformējums pieteikumu sarakstam */
    table { width:100%; border-collapse:collapse; margin-top:1rem; }
    th, td { text-align:left; padding:0.8rem 0.5rem; border-bottom:1px solid #f3f4f6; font-size:0.95rem; }
    th { color:#6b7280; font-weight:600; }
</style>
</body>
</html>
