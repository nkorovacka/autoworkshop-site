@extends('layouts.public')

@section('title', 'Mūsu darbi – Auto Detailing Workshop')

@section('content')

<main>
    <!-- Lapas virsraksts un īss ievads -->
    <div class="hero">
        <h1>Pirms un Pēc projekti</h1>
    </div>

    <!-- Darbu galerija ar kartītēm -->
    <!-- Darbu kartīšu režģis ar pirms/pēc slaideriem -->
    <section class="grid">
        @forelse($workItems as $index => $item)
            <article class="work-card" data-slider-index="{{ $index }}">
                @if($item->tag)
                    <!-- Darba tips/etiķete -->
                    <span class="tag">{{ $item->tag }}</span>
                @endif
                <!-- Darba nosaukums -->
                <h3 class="card-title">{{ $item->title }}</h3>
                @if($item->description)
                    <!-- Īss darba apraksts -->
                    <p>{{ $item->description }}</p>
                @endif
                <!-- Slaideris ar "pirms" un "pēc" attēliem -->
                <div class="slider"
                     data-images='@json([
                        $item->before_image ? asset("images/uploads/".$item->before_image) : asset("images/our-work/placeholder-before.jpg"),
                        $item->after_image ? asset("images/uploads/".$item->after_image) : asset("images/our-work/placeholder-after.jpg")
                     ])'>
                    <img src="{{ $item->before_image ? asset("images/uploads/".$item->before_image) : asset("images/our-work/placeholder-before.jpg") }}" alt="{{ $item->title }} foto">
                    <button class="prev" type="button" aria-label="Iepriekšējais">&lt;</button>
                    <button class="next" type="button" aria-label="Nākamais">&gt;</button>
                </div>
            </article>
        @empty
            <!-- Tukšs stāvoklis, ja nav neviena darba -->
            <p>Šobrīd nav pieejamu projektu. Drīzumā pievienosim!</p>
        @endforelse
    </section>

    <!-- Biežāk uzdotie jautājumi -->
    <!-- FAQ sadaļa ar atveramiem jautājumiem -->
    <section class="faq">
        <h2>Biežāk uzdotie jautājumi</h2>
        <details open>
            <summary>Vai varu atstāt auto uz visu dienu?</summary>
            <p>Jā, garākos detailing darbus veicam 6–8h laikā, un auto var atstāt pie mums visu dienu.</p>
        </details>
        <details>
            <summary>Cik ilgi saglabājas keramiskā aizsardzība?</summary>
            <p>Vidēji 24 mēnešus, ja auto tiek regulāri kopts un mazgāts ar atbilstošiem līdzekļiem.</p>
        </details>
        <details>
            <summary>Vai piedāvājat izbraukuma servisu?</summary>
            <p>Jā, noteiktos pakalpojumos nodrošinām izbraukumu pie klienta Rīgas robežās.</p>
        </details>
        <details>
            <summary>Kā sagatavoties salona tīrīšanai?</summary>
            <p>Izņem personīgās mantas un trauslus priekšmetus. Mēs visu pārējo paveiksim.</p>
        </details>
    </section>
</main>

<!-- Iekšējais CSS: novietots pēc HTML, lai atdalītu struktūru no noformējuma -->
@push('styles')
<style>
        /* Globālā nullēšana un kastes modelis */
        * { margin:0; padding:0; box-sizing:border-box; }
        /* Krāsu mainīgie un palete */
        :root {
            --accent:#ff5c35;
            --accent-dark:#d9461f;
            --accent-light:#fff1ec;
            --ink:#1a1a1a;
            --muted:#6c6c6c;
        }
        /* Pamatteksts un fons */
        body { font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif; background:#fafafa; color:var(--ink); line-height:1.6; }
        /* Galvenais saturs */
        main { max-width:1400px; margin:0 auto; padding:4rem 2rem 3rem; }
        /* Hero virsraksts */
        .hero { text-align:center; margin-bottom:3rem; }
        .hero h1 { font-size:2.8rem; margin-bottom:0.5rem; }
        .hero p { color:var(--muted); max-width:700px; margin:0 auto; }
        /* Darbu režģis */
        .grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(280px,1fr)); gap:1.5rem; }
        /* Darbu kartītes izskats un ēnojums */
        .work-card { max-width:380px; background:white; border:1px solid #f0f0f0; border-radius:20px; padding:1.5rem; box-shadow:0 15px 35px rgba(0,0,0,0.06); display:flex; flex-direction:column; gap:1rem; }
        .card-title { font-size:1.2rem; }
        /* Slider elements */
        /* Slaidera rāmis ar fiksētu augstumu */
        .slider { position:relative; border-radius:16px; overflow:hidden; border:1px solid #ededed; background:#f7f7f7; height:220px; display:flex; align-items:center; justify-content:center; }
        .slider img { width:100%; height:100%; object-fit:cover; display:block; }
        /* Slaidera navigācijas pogas */
        .slider button { position:absolute; top:50%; transform:translateY(-50%); background:rgba(0,0,0,0.55); color:white; border:none; width:36px; height:36px; border-radius:50%; cursor:pointer; }
        .slider button:hover { background:rgba(0,0,0,0.75); }
        .slider button.prev { left:10px; }
        .slider button.next { right:10px; }
        .tag { font-size:0.8rem; text-transform:uppercase; letter-spacing:0.15rem; color:#ff814f; }
        .placeholder-note { font-size:0.85rem; color:#888; }
        /* FAQ sadaļa */
        .faq { margin-top:4rem; background:white; border-radius:24px; border:1px solid #e8e8e8; padding:3rem; }
        .faq h2 { text-align:center; margin-bottom:1.5rem; font-size:2rem; }
        details { border:1px solid #f0f0f0; border-radius:14px; padding:1rem 1.2rem; margin-bottom:1rem; background:#fff; }
        summary { cursor:pointer; font-weight:600; }
        summary::marker { color:var(--accent); }
        details p { margin-top:0.6rem; color:#555; }
        /* Responsivitāte mazākiem ekrāniem */
        @media(max-width:640px){ .grid { grid-template-columns:1fr; } .faq { padding:2rem 1.5rem; } }
    </style>
@endpush

@push('scripts')
<script>
    // Attēlu slaidera loģika katram darbu blokam.
    // Apstrādā katru slaideri atsevišķi, lai būtu neatkarīga navigācija.
    document.querySelectorAll('.slider').forEach(slider => {
        const images = JSON.parse(slider.dataset.images);
        let current = 0;
        const img = slider.querySelector('img');

        // Atjauno attēlu pēc indeksa.
        function render() {
            img.src = images[current];
        }

        // Pāriet uz iepriekšējo attēlu.
        slider.querySelector('.prev').addEventListener('click', () => {
            current = (current - 1 + images.length) % images.length;
            render();
        });

        // Pāriet uz nākamo attēlu.
        slider.querySelector('.next').addEventListener('click', () => {
            current = (current + 1) % images.length;
            render();
        });
    });
</script>
@endpush
@endsection
