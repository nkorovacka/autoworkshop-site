<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <title>Mūsu darbu pārvaldība</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { font-family:'Inter',sans-serif; background:#f3f4f6; margin:0; color:#111; }
        header { background:#111827; color:white; padding:1.2rem 2rem; }
        .admin-top { display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:0.8rem; }
        .admin-nav { display:flex; gap:0.8rem; flex-wrap:wrap; margin-top:0.9rem; }
        .admin-nav a { color:#9ca3af; text-decoration:none; padding:0.35rem 0.9rem; border:1px solid transparent; border-radius:999px; }
        .admin-nav a.active { border-color:#f59e0b; color:#fde68a; }
        .admin-nav a:hover { color:white; border-color:#4b5563; }
        main { max-width:1200px; margin:2rem auto 4rem; padding:0 2rem; display:flex; flex-direction:column; gap:2rem; }
        .panel { background:white; border-radius:18px; border:1px solid #e5e7eb; padding:1.5rem; box-shadow:0 15px 30px rgba(15,23,42,0.05); }
        h2 { margin-top:0; }
        form { display:flex; flex-direction:column; gap:0.8rem; }
        input, textarea { padding:0.7rem 0.9rem; border-radius:10px; border:1px solid #d1d5db; font-size:0.95rem; }
        button { border:none; border-radius:10px; padding:0.75rem 1.1rem; font-weight:600; cursor:pointer; }
        .btn-primary { background:#111827; color:white; }
        .btn-danger { background:#ef4444; color:white; }
        .flash { padding:0.9rem 1rem; border-radius:12px; font-weight:600; }
        .flash-success { background:#e6f5ef; color:#136b3a; border:1px solid #b7e2c9; }
        .item-card { border:1px solid #e5e7eb; border-radius:16px; padding:1rem 1.2rem; background:#fafafa; margin-bottom:1rem; }
        details { background:white; border-radius:14px; padding:1rem; }
        summary { cursor:pointer; font-weight:600; }
    </style>
</head>
<body>
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
        <a href="{{ route('admin.overview') }}" class="{{ request()->routeIs('admin.overview') ? 'active' : '' }}">Kopsavilkums</a>
    </nav>
</header>

<main>
    @if(session('success'))
        <div class="flash flash-success">{{ session('success') }}</div>
    @endif

    <section class="panel">
        <h2>Pievienot jaunu darbu</h2>
        <form method="POST" action="{{ route('admin.work-items.store') }}" enctype="multipart/form-data">
            @csrf
            <input type="text" name="title" placeholder="Nosaukums" required>
            @php
                $tags = ['Exterior','Interior','Full detailing','Engine bay','Leather care','Wheels'];
            @endphp
            <select name="tag">
                <option value="">-- Izvēlies tipu --</option>
                @foreach($tags as $tag)
                    <option value="{{ $tag }}">{{ $tag }}</option>
                @endforeach
            </select>
            <textarea name="description" rows="3" placeholder="Apraksts (neobligāts)"></textarea>
            <input type="number" name="position" placeholder="Pozīcija (secības skaitlis)">
            <label>Foto „pirms”
                <input type="file" name="before_image" accept="image/*">
            </label>
            <label>Foto „pēc”
                <input type="file" name="after_image" accept="image/*">
            </label>
            <button class="btn-primary" type="submit">Saglabāt</button>
        </form>
    </section>

    <section class="panel">
        <h2>Esišo darbu saraksts</h2>
        @forelse($items as $item)
            <div class="item-card">
                <details>
                    <summary>{{ $item->title }} @if(!$item->is_visible)(Paslēpts)@endif</summary>
                    <form method="POST" action="{{ route('admin.work-items.update', $item) }}" enctype="multipart/form-data" style="margin-top:0.8rem;">
                        @csrf
                        @method('PATCH')
                        <input type="text" name="title" value="{{ $item->title }}" required>
                        <select name="tag">
                            <option value="">-- Izvēlies tipu --</option>
                            @foreach($tags as $tag)
                                <option value="{{ $tag }}" {{ $item->tag === $tag ? 'selected' : '' }}>{{ $tag }}</option>
                            @endforeach
                        </select>
                        <textarea name="description" rows="3" placeholder="Apraksts">{{ $item->description }}</textarea>
                        <input type="number" name="position" value="{{ $item->position }}">
                        <label style="display:flex; gap:0.5rem; align-items:center;">
                            <input type="checkbox" name="is_visible" value="1" {{ $item->is_visible ? 'checked' : '' }}> Rādīt publiski
                        </label>
                        <div style="display:flex; gap:1rem;">
                            <div>
                                <p style="margin:0 0 0.3rem;">Foto pirms</p>
                                @if($item->before_image)
                                    <img src="{{ asset('storage/'.$item->before_image) }}" alt="Pirms" style="width:100px; height:100px; object-fit:cover; border-radius:8px;">
                                @endif
                                <input type="file" name="before_image" accept="image/*">
                            </div>
                            <div>
                                <p style="margin:0 0 0.3rem;">Foto pēc</p>
                                @if($item->after_image)
                                    <img src="{{ asset('storage/'.$item->after_image) }}" alt="Pēc" style="width:100px; height:100px; object-fit:cover; border-radius:8px;">
                                @endif
                                <input type="file" name="after_image" accept="image/*">
                            </div>
                        </div>
                        <button class="btn-primary" type="submit" style="margin-top:0.6rem;">Saglabāt izmaiņas</button>
                    </form>
                    <form method="POST" action="{{ route('admin.work-items.destroy', $item) }}" onsubmit="return confirm('Dzēst darbu?');" style="margin-top:0.6rem;">
                        @csrf
                        @method('DELETE')
                        <button class="btn-danger" type="submit">Dzēst darbu</button>
                    </form>
                </details>
            </div>
        @empty
            <p>Nav pievienotu darbu.</p>
        @endforelse
    </section>
</main>
</body>
</html>
