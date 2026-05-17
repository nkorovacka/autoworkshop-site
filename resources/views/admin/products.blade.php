<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <title>Produktu pārvaldība</title>
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
    <!-- Flash paziņojumi par veiksmēm vai kļūdām pēc darbībām -->
    @if(session('success'))
        <div class="flash flash-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="flash" style="background:#fdecea; color:#b5302c; border:1px solid #f3c0b7;">{{ session('error') }}</div>
    @endif

    <!-- Forma jauna produkta izveidei -->
    <section class="panel">
        <h2>Pievienot jaunu produktu</h2>
        <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
            @csrf
            <!-- Produkta pamata dati -->
            <input type="text" name="name" placeholder="Nosaukums" required value="{{ old('name') }}">
            <textarea name="description" rows="3" placeholder="Apraksts (neobligāts)">{{ old('description') }}</textarea>
            <input type="text" name="supplier" placeholder="Piegādātājs (neobligāts)" value="{{ old('supplier') }}">
            <input type="number" step="0.01" name="price" placeholder="Cena €" required value="{{ old('price') }}">
            <input type="number" name="stock" placeholder="Daudzums noliktavā" required value="{{ old('stock', 0) }}">
            <input type="file" name="image" accept="image/*">
            <button type="submit" class="btn-primary">Saglabāt produktu</button>
        </form>
    </section>

    <!-- Produktu saraksts ar redzamību un rediģēšanu -->
    <section class="panel">
        <h2>Produktu saraksts</h2>
        <table>
            <thead>
            <tr>
                <th>Nosaukums</th>
                <th>Cena</th>
                <th>Daudzums</th>
                <th>Redzams</th>
                <th>Darbības</th>
            </tr>
            </thead>
            <tbody>
            @forelse($products as $product)
                <tr>
                    <!-- Nosaukums, cena, daudzums un redzamība -->
                    <td>{{ $product->name }}</td>
                    <td>{{ number_format($product->price, 2) }} €</td>
                    <td>{{ $product->stock }}</td>
                    <td>{{ $product->is_visible ? 'Jā' : 'Nē' }}</td>
                    <td>
                        <div class="product-actions">
                            <!-- Redzamības pārslēgšana -->
                            <form method="POST" action="{{ route('admin.products.visibility', $product) }}">
                                @csrf
                                @method('PATCH')
                                <button class="btn-secondary" type="submit">
                                    {{ $product->is_visible ? 'Paslēpt' : 'Parādīt' }}
                                </button>
                            </form>
                            <!-- Produkta dzēšana -->
                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Dzēst produktu?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn-danger" type="submit">Dzēst</button>
                            </form>
                        </div>
                        <!-- Produkta rediģēšana salokāmā blokā -->
                        <details style="margin-top:0.7rem;">
                            <summary style="cursor:pointer; color:#2563eb; font-weight:600;">Rediģēt</summary>
                            <form method="POST"
                                  action="{{ route('admin.products.update', $product) }}"
                                  enctype="multipart/form-data"
                                  style="display:flex; flex-direction:column; gap:0.5rem; margin-top:0.6rem;">
                                @csrf
                                @method('PATCH')
                                <!-- Rediģējamie lauki -->
                                <input type="text" name="name" value="{{ $product->name }}" required>
                                <textarea name="description" rows="2" placeholder="Apraksts">{{ $product->description }}</textarea>
                                <input type="text" name="supplier" value="{{ $product->supplier }}" placeholder="Piegādātājs">
                                <input type="number" step="0.01" name="price" value="{{ $product->price }}" required>
                                <input type="number" name="stock" value="{{ $product->stock }}" required>
                                <div>
                                    <!-- Esošā attēla priekšskatījums -->
                                    @if($product->image)
                                        <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" style="width:80px; height:80px; object-fit:cover; border-radius:8px;">
                                    @endif
                                </div>
                                <input type="file" name="image" accept="image/*">
                                <button type="submit" class="btn-primary">Saglabāt izmaiņas</button>
                            </form>
                        </details>
                    </td>
                </tr>
            @empty
                <!-- Tukšs stāvoklis, ja produktu nav -->
                <tr><td colspan="5">Nav produktu.</td></tr>
            @endforelse
            </tbody>
        </table>
    </section>

    <!-- Pasūtījumu saraksts ar statusu pārvaldību -->
    <section class="panel">
        <h2>Produktu pasūtījumi</h2>
        <table>
            <thead>
            <tr>
                <th>#</th>
                <th>Klients</th>
                <th>Summa</th>
                <th>Izveidots</th>
                <th>Statuss</th>
                <th>Darbības</th>
            </tr>
            </thead>
            <tbody>
            @forelse($orders as $order)
                <tr>
                    <!-- Pasūtījuma pamata dati -->
                    <td>#{{ $order->id }}</td>
                    <td>{{ $order->customer_name ?? optional($order->user)->name ?? 'Klients' }}</td>
                    <td>{{ number_format($order->total_price, 2) }} € ({{ $order->total_items }} gab.)</td>
                    <td>{{ $order->created_at }}</td>
                    @php
                        $orderStatus = $order->status ?? 'pending';
                        $orderStatusLabels = [
                            'pending' => 'Jauns',
                            'processing' => 'Procesā',
                            'completed' => 'Pabeigts',
                            'cancelled' => 'Atcelts',
                        ];
                    @endphp
                    <!-- Statusa nozīmīte ar krāsojumu -->
                    <td><span class="status-pill {{ $orderStatus }}">{{ $orderStatusLabels[$orderStatus] ?? $orderStatus }}</span></td>
                    <td>
                        <div class="order-actions">
                            <form method="POST" action="{{ route('admin.orders.update', $order) }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="completed">
                                <button class="btn-primary" type="submit">Pabeigt</button>
                            </form>
                            <form method="POST" action="{{ route('admin.orders.update', $order) }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="cancelled">
                                <button class="btn-danger" type="submit">Atcelt</button>
                            </form>
                            @if($orderStatus !== 'pending')
                                <form method="POST" action="{{ route('admin.orders.update', $order) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="pending">
                                    <button class="btn-reset" type="submit">Atjaunot</button>
                                </form>
                            @endif
                        </div>
                        <!-- Pasūtījuma preču saraksts -->
                        @if($order->items->count())
                            <ul style="margin:0.5rem 0 0; color:#6b7280; font-size:0.9rem; padding-left:1rem;">
                                @foreach($order->items as $item)
                                    <li>{{ $item->product->name ?? 'Produkts' }} × {{ $item->quantity }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </td>
                </tr>
            @empty
                <!-- Tukšs stāvoklis, ja pasūtījumu nav -->
                <tr><td colspan="6">Nav pasūtījumu.</td></tr>
            @endforelse
            </tbody>
        </table>

        <!-- Lapošana pasūtījumu sarakstam -->
        {{ $orders->links() }}
    </section>
</main>

<!-- Iekšējie stili: novietoti pēc HTML, lai atdalītu struktūru no noformējuma -->
<style>
    /* Lapas pamata tipogrāfija un fona krāsas */
    body { font-family:'Inter',sans-serif; background:#f3f4f6; margin:0; color:#111; }

    /* Galvene ar tumšu fonu un baltu tekstu */
    header { background:#111827; color:white; padding:1.2rem 2rem; }
    .admin-top { display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:0.8rem; }

    /* Navigācijas josla */
    .admin-nav { display:flex; gap:0.8rem; flex-wrap:wrap; margin-top:0.9rem; }
    .admin-nav a { color:#9ca3af; text-decoration:none; padding:0.35rem 0.9rem; border:1px solid transparent; border-radius:999px; }
    .admin-nav a.active { border-color:#f59e0b; color:#fde68a; }
    .admin-nav a:hover { color:white; border-color:#4b5563; }

    /* Galvenais satura izvietojums */
    main { max-width:1200px; margin:2rem auto 4rem; padding:0 2rem; display:grid; grid-template-columns:1fr; gap:2rem; }

    /* Paneļi un virsraksti */
    .panel { background:white; border-radius:20px; border:1px solid #e5e7eb; padding:1.5rem; box-shadow:0 15px 30px rgba(15,23,42,0.05); }
    h2 { margin-top:0; }

    /* Formu lauki un pogas */
    form { display:flex; flex-direction:column; gap:0.8rem; }
    input, textarea { padding:0.7rem 0.9rem; border-radius:10px; border:1px solid #d1d5db; font-size:0.95rem; }
    button { border:none; border-radius:10px; padding:0.75rem 1.1rem; font-weight:600; cursor:pointer; }
    .btn-primary { background:#111827; color:white; }
    .btn-secondary { background:#e5e7eb; color:#111827; }
    .btn-danger { background:#ef4444; color:white; }
    .btn-reset { background:#fff7ed; color:#c2410c; }

    /* Flash paziņojumi */
    .flash { padding:0.9rem 1rem; border-radius:12px; font-weight:600; }
    .flash-success { background:#e6f5ef; color:#136b3a; border:1px solid #b7e2c9; }

    /* Tabulu noformējums */
    table { width:100%; border-collapse:collapse; margin-top:1rem; }
    th, td { text-align:left; padding:0.85rem 0.5rem; border-bottom:1px solid #f3f4f6; font-size:0.95rem; }
    th { color:#6b7280; font-weight:600; }

    /* Darbību pogu izvietojums */
    .product-actions, .order-actions { display:flex; gap:0.4rem; flex-wrap:wrap; }

    /* Statusa nozīmītes krāsojums pēc statusa */
    .status-pill { padding:0.25rem 0.8rem; border-radius:999px; font-weight:600; font-size:0.85rem; text-transform:capitalize; }
    .status-pill.pending { background:#fff4e6; color:#b34700; }
    .status-pill.processing { background:#e0ecff; color:#1d4ed8; }
    .status-pill.completed { background:#e6f5ef; color:#136b3a; }
    .status-pill.cancelled { background:#fdecea; color:#b5302c; }

    /* Hide pagination summary text and arrow icons in admin product/orders page */
    nav[role="navigation"] > div:first-child,
    nav[role="navigation"] p.text-sm,
    nav[role="navigation"] svg {
        display: none !important;
    }
</style>
</body>
</html>
