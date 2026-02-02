<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <title>Lietotāju pārvaldība</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<!-- Admin paneļa galvene ar lietotāja info un navigāciju -->
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
    <!-- Veiksmes paziņojums pēc atjaunināšanas vai dzēšanas -->
    @if(session('success'))
        <div class="flash flash-success">{{ session('success') }}</div>
    @endif

    <!-- Kļūdu saraksts, ja validācija neizdevās -->
    @if($errors->any())
        <div class="flash flash-error">
            <strong>Kļūda:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Palīgteikums par paroles lauku -->
    <div class="hint">
        Atstāj paroles laukus tukšus, ja nevēlies mainīt paroli.
    </div>

    <!-- Lietotāju saraksts ar iespēju rediģēt katru ierakstu -->
    <table>
        <thead>
        <tr>
            <th>Vārds</th>
            <th>E-pasts</th>
            <th>Loma</th>
            <th>Jauna parole</th>
            <th>Darbības</th>
        </tr>
        </thead>
        <tbody>
        @forelse($users as $user)
            <tr class="{{ auth()->id() === $user->id ? 'row-self' : '' }}">
                <!-- Slēptā forma, kas piesaistīta ievades laukiem ar form atribūtu -->
                <form id="update-user-{{ $user->id }}" method="POST" action="{{ route('admin.users.update', $user) }}">
                    @csrf
                    @method('PATCH')
                </form>

                <!-- Vārda rediģēšana -->
                <td>
                    <input
                        type="text"
                        name="name"
                        value="{{ old('name', $user->name) }}"
                        form="update-user-{{ $user->id }}"
                        required
                    >
                </td>

                <!-- E-pasta rediģēšana -->
                <td>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email', $user->email) }}"
                        form="update-user-{{ $user->id }}"
                        required
                    >
                </td>

                <!-- Lomas izvēle (admins / parasts lietotājs) -->
                <td>
                    <select name="is_admin" form="update-user-{{ $user->id }}">
                        <option value="1" {{ (int) old('is_admin', $user->is_admin) === 1 ? 'selected' : '' }}>Admins</option>
                        <option value="0" {{ (int) old('is_admin', $user->is_admin) === 0 ? 'selected' : '' }}>Lietotājs</option>
                    </select>
                </td>

                <!-- Jaunas paroles ievade (nav obligāta) -->
                <td>
                    <div class="password-grid">
                        <input
                            type="password"
                            name="password"
                            placeholder="Jauna parole"
                            form="update-user-{{ $user->id }}"
                        >
                        <input
                            type="password"
                            name="password_confirmation"
                            placeholder="Apstiprinājums"
                            form="update-user-{{ $user->id }}"
                        >
                    </div>
                </td>

                <!-- Darbības: saglabāt un dzēst -->
                <td>
                    <div class="actions">
                        <button class="btn-save" type="submit" form="update-user-{{ $user->id }}">Saglabāt</button>
                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn-delete" type="submit" {{ auth()->id() === $user->id ? 'disabled' : '' }}>
                                Dzēst
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr><td colspan="5">Nav lietotāju.</td></tr>
        @endforelse
        </tbody>
    </table>

    <!-- Lapošanas saites, ja lietotāju ir daudz -->
    {{ $users->links() }}
</main>

<!-- Iekšējais CSS: novietots pēc HTML, lai strukturāli atdalītu izkārtojumu no stiliem -->
<style>
    /* Pamata admin izkārtojums un krāsu palete */
    body { font-family:'Inter',sans-serif; margin:0; background:#f4f5f7; color:#111; }
    header { background:#111827; color:white; padding:1.2rem 2rem; }
    .admin-top { display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:0.8rem; }
    .admin-nav { display:flex; gap:0.8rem; flex-wrap:wrap; margin-top:0.9rem; }
    .admin-nav a { color:#9ca3af; text-decoration:none; padding:0.35rem 0.9rem; border:1px solid transparent; border-radius:999px; }
    .admin-nav a.active { border-color:#f59e0b; color:#fde68a; }
    .admin-nav a:hover { color:white; border-color:#4b5563; }

    /* Galvenais saturs ar tabulu */
    main { max-width:1200px; margin:2rem auto; padding:0 2rem 3rem; display:flex; flex-direction:column; gap:1.2rem; }
    table { width:100%; border-collapse:collapse; background:white; border-radius:16px; overflow:hidden; box-shadow:0 10px 30px rgba(0,0,0,0.05); }
    th, td { padding:0.9rem 1rem; border-bottom:1px solid #f3f4f6; vertical-align:top; }
    th { background:#f9fafb; text-align:left; font-weight:600; color:#6b7280; }
    tr:last-child td { border-bottom:none; }
    .row-self { background:#fff7ed; }

    /* Ievades lauki un select */
    input, select { width:100%; padding:0.55rem 0.7rem; border:1px solid #e5e7eb; border-radius:10px; font-size:0.95rem; }
    input:focus, select:focus { outline:none; border-color:#f59e0b; box-shadow:0 0 0 3px rgba(245,158,11,0.15); }
    .password-grid { display:grid; grid-template-columns:1fr 1fr; gap:0.6rem; }

    /* Flash ziņojumi un palīdzības teksts */
    .flash { padding:0.9rem 1rem; border-radius:12px; font-weight:600; }
    .flash-success { background:#ecfdf3; color:#166534; border:1px solid #bbf7d0; }
    .flash-error { background:#fef2f2; color:#991b1b; border:1px solid #fecaca; }
    .flash-error ul { margin:0.6rem 0 0 1.2rem; font-weight:500; }
    .hint { background:#fff7ed; border:1px solid #fed7aa; color:#9a3412; padding:0.7rem 1rem; border-radius:12px; font-weight:600; }

    /* Darbību pogas */
    .actions { display:flex; gap:0.6rem; flex-wrap:wrap; align-items:center; }
    .btn-save { background:#111827; color:white; border:none; padding:0.5rem 1rem; border-radius:10px; cursor:pointer; }
    .btn-delete { background:#dc2626; color:white; border:none; padding:0.5rem 1rem; border-radius:10px; cursor:pointer; }
    .btn-delete[disabled] { background:#fca5a5; cursor:not-allowed; }

    /* Responsivitāte mazākiem ekrāniem */
    @media (max-width: 900px) {
        .password-grid { grid-template-columns:1fr; }
    }
</style>
</body>
</html>
