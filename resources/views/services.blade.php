@extends('layouts.public')

@section('title', 'Pakalpojumi - Auto Detailing Workshop')

@section('content')

<!-- Lapas ievads ar virsrakstu un aprakstu -->
<section class="intro">
    <h1>Pakalpojumu katalogs un cenas</h1>
    <p>Apskati pakalpojumu aprakstus, iekļautos darbus un cenu sākot no. Katram pakalpojumam norādām, kas iekļauts komplektā.</p>
</section>

<!-- Pakalpojumu kartīšu režģis -->
<section class="services-grid">
    @php
        $serviceIcons = [
            'salona-dzila-tirisana' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 6c0-2.2 1.8-4 4-4s4 1.8 4 4v3h2a3 3 0 0 1 3 3v5a5 5 0 0 1-5 5H9a5 5 0 0 1-5-5v-5a3 3 0 0 1 3-3h2V6zm2 3h4V6a2 2 0 1 0-4 0v3z"/></svg>',
            'virsbuvess-pulessana' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3a9 9 0 1 0 9 9h-2a7 7 0 1 1-7-7V3zm6.5.5-1.4 1.4 2 2 1.4-1.4-2-2zM12 7a5 5 0 1 0 5 5h-2a3 3 0 1 1-3-3V7z"/></svg>',
            'keramiska-apstrade' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2c3.3 0 6 2.7 6 6 0 4.3-4.4 9.3-6 12-1.6-2.7-6-7.7-6-12 0-3.3 2.7-6 6-6zm0 3.2a2.8 2.8 0 1 0 0 5.6 2.8 2.8 0 0 0 0-5.6z"/></svg>',
            'salona-dezinfekcija' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2c2 3 6 6.1 6 10a6 6 0 1 1-12 0c0-3.9 4-7 6-10zm-1 6.5-1.5 2.7a2.5 2.5 0 0 0 5 0L13 8.5a1.2 1.2 0 0 0-2 0z"/></svg>',
            'pilns-detailing-komplekts' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 7a3 3 0 0 1 3-3h6l2 2h2a3 3 0 0 1 3 3v5a5 5 0 0 1-5 5H9a5 5 0 0 1-5-5V7zm5.5 1a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zm6 0a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3z"/></svg>',
            'vip-programma' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2 9.6 7.2 4 8l4 4-1 5.9 5-2.7 5 2.7-1-5.9 4-4-5.6-.8L12 2z"/></svg>',
        ];
    @endphp
    @foreach($services as $service)
        <!-- Viena pakalpojuma kartīte -->
        <article class="service-card">
            <div class="icon" aria-hidden="true">
                {!! $serviceIcons[$service->slug] ?? '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3a9 9 0 1 0 9 9h-2a7 7 0 1 1-7-7V3z"/><path d="M12 8a4 4 0 1 0 4 4h-2a2 2 0 1 1-2-2V8z"/></svg>' !!}
            </div>
            <h2>{{ $service->name }}</h2>
            <small>No €{{ number_format($service->base_price, 0) }}</small>
            <p>{{ $service->description }}</p>
            @if(!empty($service->features))
                <ul>
                    @foreach($service->features as $feature)
                        <li>{{ $feature }}</li>
                    @endforeach
                </ul>
            @endif
            <!-- Pieteikšanās poga atkarībā no lietotāja stāvokļa -->
            @auth
                <button onclick="location.href='{{ route('booking.create', ['service' => $service->slug]) }}'">Pieteikties</button>
            @else
                <button onclick="location.href='{{ route('login') }}'">Ieiet, lai pieteiktos</button>
            @endauth
        </article>
    @endforeach
</section>


<!-- Aicinājums rezervēt vizīti -->
<section class="cta">
    <h2>Kuru pakalpojumu izvēlies?</h2>
    <p>Aizpildi pieteikumu un saņem apstiprinājumu dažu minūšu laikā.</p>
    <a href="{{ route('booking.create') }}">Rezervēt tiešsaistē</a>
</section>

<!-- Iekšējais CSS: novietots pēc HTML, lai atdalītu struktūru no noformējuma -->
@push('styles')
<style>
        /* Globālā nullēšana un kastes modelis */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        /* Krāsu mainīgie un palete */
        :root {
            --accent: #ff5c35;
            --accent-dark: #d94516;
            --accent-light: #fff3ec;
            --ink: #1a1a1a;
            --muted: #6c6c6c;
        }
        /* Pamatteksts un fons */
        body { font-family: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; background:#fafafa; color:var(--ink); line-height:1.6; }

        /* Ievada sadaļa */
        .intro { max-width:1400px; margin:0 auto; padding:4rem 2rem 2.5rem; }
        .intro h1 { font-size:2.8rem; margin-bottom:0.8rem; }
        .intro p { color:var(--muted); max-width:760px; }

        /* Pakalpojumu režģis un kartītes */
        .services-grid { max-width:1400px; margin:0 auto; padding:0 2rem 3rem; display:grid; grid-template-columns:repeat(auto-fit,minmax(320px,1fr)); gap:1.5rem; }
        .service-card { background:white; border:1px solid #f0f0f0; border-radius:18px; padding:2rem; display:flex; flex-direction:column; gap:0.8rem; box-shadow:0 10px 25px rgba(0,0,0,0.04); }
        .service-card .icon { width:48px; height:48px; display:grid; place-items:center; border-radius:12px; background:#f5f6f8; color:var(--accent); }
        .service-card .icon svg { width:26px; height:26px; fill:currentColor; }
        .service-card h2 { font-size:1.4rem; }
        .service-card small { color:var(--muted); font-weight:500; }
        .service-card ul { list-style:none; color:var(--muted); padding-left:0; }
        .service-card li { padding-left:1rem; position:relative; }
        .service-card li::before { content:\"•\"; color:var(--accent); position:absolute; left:0; }
        .service-card button { margin-top:auto; padding:0.9rem; border-radius:10px; border:none; background:var(--accent); color:white; font-weight:600; cursor:pointer; transition:background 0.2s; }
        .service-card button:hover { background:var(--accent-dark); }

        /* CTA sadaļa */
        .cta { max-width:1400px; margin:0 auto 4rem; padding:3.5rem 2rem; border-radius:24px; background:linear-gradient(135deg,var(--accent),var(--accent-dark)); color:white; text-align:center; }
        .cta p { opacity:0.9; margin-top:0.5rem; }
        .cta a { display:inline-block; margin-top:1.2rem; padding:0.9rem 1.8rem; border-radius:12px; background:white; color:var(--ink); text-decoration:none; font-weight:600; }

        /* Responsivitāte planšetēm un telefoniem */
        @media (max-width:768px) {
            .intro { padding:3rem 1.5rem 2rem; }
            .services-grid, .packages { padding:0 1.5rem 2.5rem; }
            .cta { padding:3rem 1.5rem; }
        }
    </style>
@endpush
@endsection
