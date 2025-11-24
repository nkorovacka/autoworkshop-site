<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <title>Pieteikt vizīti</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<header>
    <nav>
        <a href="{{ url('/') }}">Galvenā lapa</a> |
        <a href="{{ url('/services') }}">Pakalpojumi</a> |
        <a href="{{ url('/products') }}">Produkti</a> |
        <a href="{{ url('/our-work') }}">Mūsu darbi</a> |
        <a href="{{ url('/booking') }}">Pieteikt vizīti</a>
    </nav>
</header>

<main>
    <h1>Pieteikt vizīti</h1>

    {{-- Paziņojums pēc saglabāšanas --}}
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <form method="POST" action="{{ route('booking.store') }}" id="bookingForm">
        @csrf

        {{-- Auto izvēle --}}
        <div>
            <label for="car">Auto modelis:</label>
            <select name="car" id="car" required>
                <option value="">-- Izvēlies auto --</option>
                <option value="">-- Izvēlies auto --</option>
        <option value="Audi A1" data-multiplier="1.0">Audi A1</option>
        <option value="Audi A4" data-multiplier="1.1">Audi A4</option>
        <option value="Audi Q7" data-multiplier="1.5">Audi Q7</option>
        <option value="Audi e-tron" data-multiplier="1.5">Audi e-tron (Elektro SUV)</option>
        <option value="Audi RS3" data-multiplier="1.3">Audi RS3 (Sporta)</option>
        <option value="Audi RS4" data-multiplier="1.4">Audi RS4 (Sporta)</option>
        <option value="Audi RS6" data-multiplier="1.6">Audi RS6 (Sporta)</option>
        <option value="Audi S3" data-multiplier="1.2">Audi S3 (Sporta)</option>
        <option value="Audi S5" data-multiplier="1.3">Audi S5 (Sporta)</option>
        <option value="BMW 1 Series" data-multiplier="1.0">BMW 1 Series (Kompakts)</option>
        <option value="BMW 2 Series" data-multiplier="1.1">BMW 2 Series (Kupeja)</option>
        <option value="BMW 3 Series" data-multiplier="1.1">BMW 3 Series (Sedans)</option>
        <option value="BMW 4 Series" data-multiplier="1.2">BMW 4 Series (Kupeja)</option>
        <option value="BMW 5 Series" data-multiplier="1.3">BMW 5 Series (Lielā)</option>
        <option value="BMW 6 Series" data-multiplier="1.4">BMW 6 Series (Gran Turismo)</option>
        <option value="BMW 7 Series" data-multiplier="1.5">BMW 7 Series (Premium sedans)</option>
        <option value="BMW 8 Series" data-multiplier="1.6">BMW 8 Series (Luksusa kupeja)</option>
        <option value="BMW X1" data-multiplier="1.1">BMW X1 (Mazais SUV)</option>
        <option value="BMW X2" data-multiplier="1.2">BMW X2 (Krosovers)</option>
        <option value="BMW X3" data-multiplier="1.3">BMW X3 (SUV)</option>
        <option value="BMW X4" data-multiplier="1.4">BMW X4 (Sporta SUV)</option>
        <option value="BMW X5" data-multiplier="1.5">BMW X5 (Lielais SUV)</option>
        <option value="BMW X6" data-multiplier="1.6">BMW X6 (Kupeja SUV)</option>
        <option value="BMW X7" data-multiplier="1.7">BMW X7 (Premium SUV)</option>
        <option value="BMW Z4" data-multiplier="1.4">BMW Z4 (Roadsters)</option>
        <option value="BMW i3" data-multiplier="1.1">BMW i3 (Elektro kompakts)</option>
        <option value="BMW i4" data-multiplier="1.3">BMW i4 (Elektro sedans)</option>
        <option value="BMW iX" data-multiplier="1.6">BMW iX (Elektro SUV)</option>
        <option value="BMW iX3" data-multiplier="1.4">BMW iX3 (Elektro SUV)</option>
        <option value="BMW M2" data-multiplier="1.4">BMW M2 (Sporta)</option>
        <option value="BMW M3" data-multiplier="1.5">BMW M3 (Sporta)</option>
        <option value="BMW M4" data-multiplier="1.5">BMW M4 (Sporta kupeja)</option>
        <option value="BMW M5" data-multiplier="1.6">BMW M5 (Sporta sedans)</option>
        <option value="BMW M8" data-multiplier="1.8">BMW M8 (Luksusa sporta)</option>
        <option value="Mercedes A-Class" data-multiplier="1.0">Mercedes A-Class (Kompakts)</option>
        <option value="Mercedes B-Class" data-multiplier="1.1">Mercedes B-Class (Kompakts minivens)</option>
        <option value="Mercedes C-Class" data-multiplier="1.2">Mercedes C-Class (Sedans)</option>
        <option value="Mercedes CLA" data-multiplier="1.2">Mercedes CLA (Sporta sedans)</option>
        <option value="Mercedes E-Class" data-multiplier="1.3">Mercedes E-Class (Lielais sedans)</option>
        <option value="Mercedes CLS" data-multiplier="1.4">Mercedes CLS (Luksusa kupeja)</option>
        <option value="Mercedes S-Class" data-multiplier="1.5">Mercedes S-Class (Premium sedans)</option>
        <option value="Mercedes GLA" data-multiplier="1.2">Mercedes GLA (Mazais SUV)</option>
        <option value="Mercedes GLB" data-multiplier="1.3">Mercedes GLB (Kompakts SUV)</option>
        <option value="Mercedes GLC" data-multiplier="1.4">Mercedes GLC (SUV)</option>
        <option value="Mercedes GLE" data-multiplier="1.5">Mercedes GLE (Lielais SUV)</option>
        <option value="Mercedes GLS" data-multiplier="1.6">Mercedes GLS (Premium SUV)</option>
        <option value="Mercedes G-Class" data-multiplier="1.7">Mercedes G-Class (Apvidus auto)</option>
        <option value="Mercedes EQA" data-multiplier="1.3">Mercedes EQA (Elektro SUV)</option>
        <option value="Mercedes EQB" data-multiplier="1.4">Mercedes EQB (Elektro SUV)</option>
        <option value="Mercedes EQC" data-multiplier="1.5">Mercedes EQC (Elektro SUV)</option>
        <option value="Mercedes EQE" data-multiplier="1.5">Mercedes EQE (Elektro sedans)</option>
        <option value="Mercedes EQS" data-multiplier="1.6">Mercedes EQS (Elektro luksuss sedans)</option>
        <option value="Mercedes Vito" data-multiplier="1.7">Mercedes Vito (Mikroautobuss)</option>
        <option value="Mercedes V-Class" data-multiplier="1.8">Mercedes V-Class (Premium busiņš)</option>
        <option value="Mercedes Sprinter" data-multiplier="2.0">Mercedes Sprinter (Kravas/vienības busiņš)</option>
        <option value="Mercedes AMG A45" data-multiplier="1.4">Mercedes AMG A45 (Sporta kompakts)</option>
        <option value="Mercedes AMG C63" data-multiplier="1.6">Mercedes AMG C63 (Sporta sedans)</option>
        <option value="Mercedes AMG E63" data-multiplier="1.7">Mercedes AMG E63 (Sporta luksus sedans)</option>
        <option value="Mercedes AMG GTR" data-multiplier="2.0">Mercedes AMG GTR (Superauto)</option>
        <option value="Volkswagen Up!" data-multiplier="1.0">Volkswagen Up! (Mazais pilsētas auto)</option>
        <option value="Volkswagen Polo" data-multiplier="1.0">Volkswagen Polo (Kompakts)</option>
        <option value="Volkswagen Golf" data-multiplier="1.1">Volkswagen Golf (Vidēja klase)</option>
        <option value="Volkswagen Golf Variant" data-multiplier="1.2">Volkswagen Golf Variant (Universālis)</option>
        <option value="Volkswagen Jetta" data-multiplier="1.2">Volkswagen Jetta (Sedans)</option>
        <option value="Volkswagen Passat" data-multiplier="1.3">Volkswagen Passat (Lielā klase)</option>
        <option value="Volkswagen Passat Variant" data-multiplier="1.4">Volkswagen Passat Variant (Universālis)</option>
        <option value="Volkswagen Arteon" data-multiplier="1.4">Volkswagen Arteon (Premium kupejsedans)</option>
        <option value="Volkswagen Tiguan" data-multiplier="1.3">Volkswagen Tiguan (SUV)</option>
        <option value="Volkswagen Tiguan Allspace" data-multiplier="1.4">Volkswagen Tiguan Allspace (SUV ar 7 vietām)</option>
        <option value="Volkswagen T-Roc" data-multiplier="1.2">Volkswagen T-Roc (Mazais SUV)</option>
        <option value="Volkswagen T-Cross" data-multiplier="1.1">Volkswagen T-Cross (Kompakts SUV)</option>
        <option value="Volkswagen Taigo" data-multiplier="1.1">Volkswagen Taigo (Kompakts kupeja SUV)</option>
        <option value="Volkswagen Touareg" data-multiplier="1.5">Volkswagen Touareg (Lielais SUV)</option>
        <option value="Volkswagen Touran" data-multiplier="1.4">Volkswagen Touran (Ģimenes minivens)</option>
        <option value="Volkswagen Sharan" data-multiplier="1.5">Volkswagen Sharan (Lielais minivens)</option>
        <option value="Volkswagen Caddy" data-multiplier="1.6">Volkswagen Caddy (Mazais kravas/vienības auto)</option>
        <option value="Volkswagen Transporter T5" data-multiplier="1.7">Volkswagen Transporter T5 (Busiņš)</option>
        <option value="Volkswagen Transporter T6" data-multiplier="1.7">Volkswagen Transporter T6 (Busiņš)</option>
        <option value="Volkswagen Multivan" data-multiplier="1.8">Volkswagen Multivan (Premium busiņš)</option>
        <option value="Volkswagen ID.3" data-multiplier="1.2">Volkswagen ID.3 (Elektro kompakts)</option>
        <option value="Volkswagen ID.4" data-multiplier="1.3">Volkswagen ID.4 (Elektro SUV)</option>
        <option value="Volkswagen ID.5" data-multiplier="1.4">Volkswagen ID.5 (Elektro kupeja SUV)</option>
        <option value="Volkswagen ID.Buzz" data-multiplier="1.6">Volkswagen ID.Buzz (Elektro retro busiņš)</option>
        <option value="Toyota Aygo" data-multiplier="1.0">Toyota Aygo (Mazais pilsētas auto)</option>
        <option value="Toyota Yaris" data-multiplier="1.0">Toyota Yaris (Kompakts)</option>
        <option value="Toyota Yaris Cross" data-multiplier="1.1">Toyota Yaris Cross (Mazais SUV)</option>
        <option value="Toyota Corolla" data-multiplier="1.1">Toyota Corolla (Sedans/Hatchback)</option>
        <option value="Toyota Corolla Touring Sports" data-multiplier="1.2">Toyota Corolla Touring Sports (Universālis)</option>
        <option value="Toyota Prius" data-multiplier="1.2">Toyota Prius (Hibrīda sedans)</option>
        <option value="Toyota Camry" data-multiplier="1.3">Toyota Camry (Lielais sedans)</option>
        <option value="Toyota Avensis" data-multiplier="1.3">Toyota Avensis (Sedans/Universālis)</option>
        <option value="Toyota C-HR" data-multiplier="1.2">Toyota C-HR (Kompakts SUV)</option>
        <option value="Toyota RAV4" data-multiplier="1.3">Toyota RAV4 (SUV)</option>
        <option value="Toyota Highlander" data-multiplier="1.5">Toyota Highlander (Lielais SUV)</option>
        <option value="Toyota Land Cruiser" data-multiplier="1.6">Toyota Land Cruiser (Apvidus auto)</option>
        <option value="Toyota Hilux" data-multiplier="1.6">Toyota Hilux (Pikaps)</option>
        <option value="Toyota Proace City" data-multiplier="1.5">Toyota Proace City (Mazais komercauto)</option>
        <option value="Toyota Proace Verso" data-multiplier="1.7">Toyota Proace Verso (Mikroautobuss)</option>
        <option value="Toyota GR Yaris" data-multiplier="1.3">Toyota GR Yaris (Sporta kompakts)</option>
        <option value="Toyota Supra" data-multiplier="1.6">Toyota Supra (Sporta kupeja)</option>
        <option value="Toyota bZ4X" data-multiplier="1.4">Toyota bZ4X (Elektro SUV)</option>
        <option value="Nissan Micra" data-multiplier="1.0">Nissan Micra (Kompakts)</option>
        <option value="Nissan Note" data-multiplier="1.1">Nissan Note (Mazais ģimenes auto)</option>
        <option value="Nissan Leaf" data-multiplier="1.2">Nissan Leaf (Elektro sedans)</option>
        <option value="Nissan Juke" data-multiplier="1.2">Nissan Juke (Mazais SUV)</option>
        <option value="Nissan Qashqai" data-multiplier="1.3">Nissan Qashqai (SUV)</option>
        <option value="Nissan X-Trail" data-multiplier="1.4">Nissan X-Trail (Lielāks SUV)</option>
        <option value="Nissan Ariya" data-multiplier="1.5">Nissan Ariya (Elektro SUV)</option>
        <option value="Nissan Navara" data-multiplier="1.6">Nissan Navara (Pikaps)</option>
        <option value="Nissan Pathfinder" data-multiplier="1.6">Nissan Pathfinder (Apvidus auto)</option>
        <option value="Nissan Townstar" data-multiplier="1.5">Nissan Townstar (Mazais busiņš)</option>
        <option value="Nissan Primastar" data-multiplier="1.7">Nissan Primastar (Mikroautobuss)</option>
        <option value="Škoda Citigo" data-multiplier="1.0">Škoda Citigo (Mazais pilsētas auto)</option>
        <option value="Škoda Fabia" data-multiplier="1.0">Škoda Fabia (Kompakts)</option>
        <option value="Škoda Scala" data-multiplier="1.1">Škoda Scala (Hečbeks)</option>
        <option value="Škoda Rapid" data-multiplier="1.1">Škoda Rapid (Sedans)</option>
        <option value="Škoda Octavia" data-multiplier="1.2">Škoda Octavia (Sedans/Universālis)</option>
        <option value="Škoda Superb" data-multiplier="1.3">Škoda Superb (Lielais sedans)</option>
        <option value="Škoda Kamiq" data-multiplier="1.2">Škoda Kamiq (Mazais SUV)</option>
        <option value="Škoda Karoq" data-multiplier="1.3">Škoda Karoq (SUV)</option>
        <option value="Škoda Kodiaq" data-multiplier="1.5">Škoda Kodiaq (Lielais SUV)</option>
        <option value="Škoda Enyaq iV" data-multiplier="1.5">Škoda Enyaq iV (Elektro SUV)</option>
        <option value="Volvo C30" data-multiplier="1.1">Volvo C30 (Kompakts kupejs)</option>
        <option value="Volvo S40" data-multiplier="1.2">Volvo S40 (Mazais sedans)</option>
        <option value="Volvo S60" data-multiplier="1.3">Volvo S60 (Vidējs sedans)</option>
        <option value="Volvo S80" data-multiplier="1.4">Volvo S80 (Lielais sedans)</option>
        <option value="Volvo S90" data-multiplier="1.5">Volvo S90 (Premium sedans)</option>
        <option value="Volvo V40" data-multiplier="1.2">Volvo V40 (Universālis)</option>
        <option value="Volvo V60" data-multiplier="1.3">Volvo V60 (Universālis)</option>
        <option value="Volvo V70" data-multiplier="1.4">Volvo V70 (Lielais universālis)</option>
        <option value="Volvo V90" data-multiplier="1.5">Volvo V90 (Premium universālis)</option>
        <option value="Volvo XC40" data-multiplier="1.3">Volvo XC40 (Mazais SUV)</option>
        <option value="Volvo XC60" data-multiplier="1.4">Volvo XC60 (SUV)</option>
        <option value="Volvo XC70" data-multiplier="1.5">Volvo XC70 (Apvidus universālis)</option>
        <option value="Volvo XC90" data-multiplier="1.6">Volvo XC90 (Lielais SUV)</option>
        <option value="Volvo EX30" data-multiplier="1.3">Volvo EX30 (Elektro SUV)</option>
        <option value="Volvo EX90" data-multiplier="1.6">Volvo EX90 (Elektro premium SUV)</option>
        <option value="Honda Jazz" data-multiplier="1.0">Honda Jazz (Mazais pilsētas auto)</option>
        <option value="Honda Civic" data-multiplier="1.1">Honda Civic (Sedans/Hečbeks)</option>
        <option value="Honda Accord" data-multiplier="1.3">Honda Accord (Vidējs sedans)</option>
        <option value="Honda Insight" data-multiplier="1.2">Honda Insight (Hibrīds sedans)</option>
        <option value="Honda HR-V" data-multiplier="1.2">Honda HR-V (Mazais SUV)</option>
        <option value="Honda CR-V" data-multiplier="1.4">Honda CR-V (SUV)</option>
        <option value="Honda e" data-multiplier="1.1">Honda e (Elektro kompakts)</option>
        <option value="Honda Prelude" data-multiplier="1.3">Honda Prelude (Kupeja)</option>
        <option value="Honda S2000" data-multiplier="1.4">Honda S2000 (Roadsters)</option>
        <option value="Honda Odyssey" data-multiplier="1.5">Honda Odyssey (Minivens)</option>
        <option value="Ford Fiesta" data-multiplier="1.0">Ford Fiesta (Kompakts)</option>
        <option value="Ford Focus" data-multiplier="1.1">Ford Focus (Hečbeks/Sedans)</option>
        <option value="Ford Mondeo" data-multiplier="1.3">Ford Mondeo (Lielais sedans)</option>
        <option value="Ford Fusion" data-multiplier="1.2">Ford Fusion (Sedans)</option>
        <option value="Ford Mustang" data-multiplier="1.5">Ford Mustang (Sporta kupeja)</option>
        <option value="Ford Puma" data-multiplier="1.2">Ford Puma (Mazais SUV)</option>
        <option value="Ford Kuga" data-multiplier="1.3">Ford Kuga (SUV)</option>
        <option value="Ford Edge" data-multiplier="1.4">Ford Edge (Lielais SUV)</option>
        <option value="Ford Explorer" data-multiplier="1.5">Ford Explorer (Premium SUV)</option>
        <option value="Ford EcoSport" data-multiplier="1.1">Ford EcoSport (Mazais SUV)</option>
        <option value="Ford Ranger" data-multiplier="1.6">Ford Ranger (Pikaps)</option>
        <option value="Ford Tourneo Connect" data-multiplier="1.5">Ford Tourneo Connect (Mazais busiņš)</option>
        <option value="Ford Transit Custom" data-multiplier="1.7">Ford Transit Custom (Vidējs busiņš)</option>
        <option value="Ford Transit" data-multiplier="1.8">Ford Transit (Lielais komercauto)</option>
        <option value="Mazda 2" data-multiplier="1.0">Mazda 2 (Mazais kompakts)</option>
        <option value="Mazda 3" data-multiplier="1.1">Mazda 3 (Hečbeks/Sedans)</option>
        <option value="Mazda 6" data-multiplier="1.3">Mazda 6 (Vidējs sedans/universālis)</option>
        <option value="Mazda CX-3" data-multiplier="1.2">Mazda CX-3 (Mazais SUV)</option>
        <option value="Mazda CX-30" data-multiplier="1.3">Mazda CX-30 (Kompakts SUV)</option>
        <option value="Mazda CX-5" data-multiplier="1.4">Mazda CX-5 (SUV)</option>
        <option value="Mazda CX-60" data-multiplier="1.5">Mazda CX-60 (Plug-in hibrīds SUV)</option>
        <option value="Mazda CX-9" data-multiplier="1.6">Mazda CX-9 (Lielais SUV)</option>
        <option value="Mazda MX-5" data-multiplier="1.3">Mazda MX-5 (Sporta roadsters)</option>
        <option value="Mazda MX-30" data-multiplier="1.3">Mazda MX-30 (Elektro SUV)</option>
        <option value="Kia Picanto" data-multiplier="1.0">Kia Picanto (Mazais pilsētas auto)</option>
        <option value="Kia Rio" data-multiplier="1.0">Kia Rio (Kompakts)</option>
        <option value="Kia Ceed" data-multiplier="1.1">Kia Ceed (Hečbeks/Universālis)</option>
        <option value="Kia Proceed" data-multiplier="1.2">Kia Proceed (Sporta universālis)</option>
        <option value="Kia Stonic" data-multiplier="1.2">Kia Stonic (Mazais SUV)</option>
        <option value="Kia Sportage" data-multiplier="1.4">Kia Sportage (SUV)</option>
        <option value="Kia Sorento" data-multiplier="1.6">Kia Sorento (Lielais SUV)</option>
        <option value="Kia Niro" data-multiplier="1.3">Kia Niro (Hibrīds/elektro SUV)</option>
        <option value="Kia EV6" data-multiplier="1.5">Kia EV6 (Elektro kupeja SUV)</option>
        <option value="Kia Carens" data-multiplier="1.4">Kia Carens (Ģimenes minivens)</option>
        <option value="Kia Carnival" data-multiplier="1.7">Kia Carnival (Lielais minivens)</option>
        <option value="Hyundai i10" data-multiplier="1.0">Hyundai i10 (Mazais pilsētas auto)</option>
        <option value="Hyundai i20" data-multiplier="1.0">Hyundai i20 (Kompakts)</option>
        <option value="Hyundai i30" data-multiplier="1.1">Hyundai i30 (Hečbeks/Universālis)</option>
        <option value="Hyundai Elantra" data-multiplier="1.2">Hyundai Elantra (Sedans)</option>
        <option value="Hyundai Sonata" data-multiplier="1.3">Hyundai Sonata (Vidējs sedans)</option>
        <option value="Hyundai Bayon" data-multiplier="1.2">Hyundai Bayon (Mazais SUV)</option>
        <option value="Hyundai Kona" data-multiplier="1.3">Hyundai Kona (SUV / arī elektro)</option>
        <option value="Hyundai Tucson" data-multiplier="1.4">Hyundai Tucson (SUV)</option>
        <option value="Hyundai Santa Fe" data-multiplier="1.5">Hyundai Santa Fe (Lielais SUV)</option>
        <option value="Hyundai Palisade" data-multiplier="1.6">Hyundai Palisade (Premium SUV)</option>
        <option value="Hyundai Ioniq" data-multiplier="1.3">Hyundai Ioniq (Hibrīds/elektro)</option>
        <option value="Hyundai Ioniq 5" data-multiplier="1.5">Hyundai Ioniq 5 (Elektro kupeja SUV)</option>
        <option value="Hyundai Ioniq 6" data-multiplier="1.6">Hyundai Ioniq 6 (Elektro sedans)</option>
        <option value="Peugeot 108" data-multiplier="1.0">Peugeot 108 (Mazais pilsētas auto)</option>
        <option value="Peugeot 208" data-multiplier="1.1">Peugeot 208 (Kompakts)</option>
        <option value="Peugeot 308" data-multiplier="1.2">Peugeot 308 (Hečbeks/Universālis)</option>
        <option value="Peugeot 508" data-multiplier="1.3">Peugeot 508 (Lielais sedans)</option>
        <option value="Peugeot 2008" data-multiplier="1.2">Peugeot 2008 (Mazais SUV)</option>
        <option value="Peugeot 3008" data-multiplier="1.4">Peugeot 3008 (SUV)</option>
        <option value="Peugeot 5008" data-multiplier="1.5">Peugeot 5008 (SUV ar 7 vietām)</option>
        <option value="Peugeot Rifter" data-multiplier="1.5">Peugeot Rifter (Minivens/busiņš)</option>
        <option value="Peugeot Traveller" data-multiplier="1.7">Peugeot Traveller (Lielais busiņš)</option>
        <option value="Peugeot e-208" data-multiplier="1.2">Peugeot e-208 (Elektro kompakts)</option>
        <option value="Peugeot e-2008" data-multiplier="1.3">Peugeot e-2008 (Elektro SUV)</option>
        <option value="Opel Karl" data-multiplier="1.0">Opel Karl (Mazais pilsētas auto)</option>
        <option value="Opel Corsa" data-multiplier="1.1">Opel Corsa (Kompakts)</option>
        <option value="Opel Astra" data-multiplier="1.2">Opel Astra (Hečbeks/Universālis)</option>
        <option value="Opel Insignia" data-multiplier="1.3">Opel Insignia (Sedans/Universālis)</option>
        <option value="Opel Crossland" data-multiplier="1.2">Opel Crossland (Mazais SUV)</option>
        <option value="Opel Mokka" data-multiplier="1.3">Opel Mokka (SUV)</option>
        <option value="Opel Grandland" data-multiplier="1.4">Opel Grandland (Vidējs SUV)</option>
        <option value="Opel Combo Life" data-multiplier="1.5">Opel Combo Life (Minivens)</option>
        <option value="Opel Zafira Life" data-multiplier="1.6">Opel Zafira Life (Mikroautobuss)</option>
        <option value="Renault Twingo" data-multiplier="1.0">Renault Twingo (Mazais pilsētas auto)</option>
        <option value="Renault Clio" data-multiplier="1.1">Renault Clio (Kompakts)</option>
        <option value="Renault Captur" data-multiplier="1.2">Renault Captur (Mazais SUV)</option>
        <option value="Renault Megane" data-multiplier="1.2">Renault Megane (Hečbeks/Universālis)</option>
        <option value="Renault Arkana" data-multiplier="1.3">Renault Arkana (Kupeja SUV)</option>
        <option value="Renault Austral" data-multiplier="1.3">Renault Austral (SUV)</option>
        <option value="Renault Koleos" data-multiplier="1.5">Renault Koleos (Lielais SUV)</option>
        <option value="Renault Scenic" data-multiplier="1.4">Renault Scenic (Ģimenes minivens)</option>
        <option value="Renault Espace" data-multiplier="1.5">Renault Espace (Lielais minivens)</option>
        <option value="Renault Kangoo" data-multiplier="1.5">Renault Kangoo (Mazais busiņš)</option>
        <option value="Renault Trafic" data-multiplier="1.7">Renault Trafic (Mikroautobuss)</option>
        <option value="Renault Master" data-multiplier="1.9">Renault Master (Kravas auto)</option>
        <option value="Renault Zoe" data-multiplier="1.2">Renault Zoe (Elektro kompakts)</option>
        <option value="Tesla Model 3" data-multiplier="1.4">Tesla Model 3 (Elektro sedans)</option>
        <option value="Tesla Model Y" data-multiplier="1.5">Tesla Model Y (Elektro SUV)</option>
        <option value="Tesla Model S" data-multiplier="1.6">Tesla Model S (Luksusa elektro sedans)</option>
        <option value="Tesla Model X" data-multiplier="1.7">Tesla Model X (Luksusa elektro SUV)</option>
        <option value="Tesla Cybertruck" data-multiplier="2.0">Tesla Cybertruck (Pikaps)</option>
        <option value="Citroën C1" data-multiplier="1.0">Citroën C1 (Mazais pilsētas auto)</option>
        <option value="Citroën C3" data-multiplier="1.1">Citroën C3 (Kompakts)</option>
        <option value="Citroën C3 Aircross" data-multiplier="1.2">Citroën C3 Aircross (Mazais SUV)</option>
        <option value="Citroën C4" data-multiplier="1.2">Citroën C4 (Hečbeks)</option>
        <option value="Citroën ë-C4" data-multiplier="1.3">Citroën ë-C4 (Elektro hečbeks)</option>
        <option value="Citroën C5 X" data-multiplier="1.4">Citroën C5 X (Universālis/SUV)</option>
        <option value="Citroën C5 Aircross" data-multiplier="1.4">Citroën C5 Aircross (SUV)</option>
        <option value="Citroën Berlingo" data-multiplier="1.5">Citroën Berlingo (Mazais busiņš)</option>
        <option value="Citroën Spacetourer" data-multiplier="1.7">Citroën Spacetourer (Mikroautobuss)</option>
        <option value="Lexus CT 200h" data-multiplier="1.2">Lexus CT 200h (Hibrīds kompakts)</option>
        <option value="Lexus IS" data-multiplier="1.3">Lexus IS (Vidējs sedans)</option>
        <option value="Lexus ES" data-multiplier="1.4">Lexus ES (Lielais sedans)</option>
        <option value="Lexus GS" data-multiplier="1.4">Lexus GS (Premium sedans)</option>
        <option value="Lexus LS" data-multiplier="1.6">Lexus LS (Luksusa sedans)</option>
        <option value="Lexus NX" data-multiplier="1.4">Lexus NX (SUV)</option>
        <option value="Lexus RX" data-multiplier="1.5">Lexus RX (Premium SUV)</option>
        <option value="Lexus UX" data-multiplier="1.3">Lexus UX (Kompakts SUV)</option>
        <option value="Lexus GX" data-multiplier="1.6">Lexus GX (Lielais SUV)</option>
        <option value="Lexus LX" data-multiplier="1.7">Lexus LX (Flagmanis SUV)</option>
        <option value="Mitsubishi Space Star" data-multiplier="1.0">Mitsubishi Space Star (Mazais auto)</option>
        <option value="Mitsubishi Colt" data-multiplier="1.0">Mitsubishi Colt (Kompakts)</option>
        <option value="Mitsubishi Lancer" data-multiplier="1.2">Mitsubishi Lancer (Sedans)</option>
        <option value="Mitsubishi ASX" data-multiplier="1.2">Mitsubishi ASX (Mazais SUV)</option>
        <option value="Mitsubishi Eclipse Cross" data-multiplier="1.3">Mitsubishi Eclipse Cross (SUV)</option>
        <option value="Mitsubishi Outlander" data-multiplier="1.4">Mitsubishi Outlander (SUV / Plug-in)</option>
        <option value="Mitsubishi Pajero" data-multiplier="1.6">Mitsubishi Pajero (Apvidus auto)</option>
        <option value="Mitsubishi L200" data-multiplier="1.6">Mitsubishi L200 (Pikaps)</option>
        <option value="Jeep Renegade" data-multiplier="1.3">Jeep Renegade (Mazais SUV)</option>
        <option value="Jeep Compass" data-multiplier="1.4">Jeep Compass (SUV)</option>
        <option value="Jeep Cherokee" data-multiplier="1.5">Jeep Cherokee (SUV)</option>
        <option value="Jeep Grand Cherokee" data-multiplier="1.6">Jeep Grand Cherokee (Premium SUV)</option>
        <option value="Jeep Wrangler" data-multiplier="1.6">Jeep Wrangler (Apvidus auto)</option>
        <option value="Jeep Gladiator" data-multiplier="1.7">Jeep Gladiator (Pikaps)</option>
        <option value="Jeep Avenger" data-multiplier="1.3">Jeep Avenger (Mazs elektro SUV)</option>
        <option value="Subaru Justy" data-multiplier="1.0">Subaru Justy (Kompakts)</option>
        <option value="Subaru Impreza" data-multiplier="1.1">Subaru Impreza (Hečbeks/Sedans)</option>
        <option value="Subaru Legacy" data-multiplier="1.3">Subaru Legacy (Sedans/Universālis)</option>
        <option value="Subaru Outback" data-multiplier="1.4">Subaru Outback (Universālis/SUV)</option>
        <option value="Subaru XV (Crosstrek)" data-multiplier="1.3">Subaru XV (Mazais SUV)</option>
        <option value="Subaru Forester" data-multiplier="1.4">Subaru Forester (SUV)</option>
        <option value="Subaru Ascent" data-multiplier="1.5">Subaru Ascent (Lielais SUV)</option>
        <option value="Subaru BRZ" data-multiplier="1.4">Subaru BRZ (Sporta kupeja)</option>
        <option value="Fiat Panda" data-multiplier="1.0">Fiat Panda (Mazais pilsētas auto)</option>
        <option value="Fiat 500" data-multiplier="1.0">Fiat 500 (Retro kompakts)</option>
        <option value="Fiat 500X" data-multiplier="1.2">Fiat 500X (Mazais SUV)</option>
        <option value="Fiat Punto" data-multiplier="1.1">Fiat Punto (Kompakts)</option>
        <option value="Fiat Tipo" data-multiplier="1.2">Fiat Tipo (Sedans/Universālis)</option>
        <option value="Fiat Doblo" data-multiplier="1.5">Fiat Doblo (Mazais busiņš)</option>
        <option value="Fiat Scudo" data-multiplier="1.6">Fiat Scudo (Komercauto)</option>
        <option value="Fiat Ducato" data-multiplier="1.8">Fiat Ducato (Lielais kravas busiņš)</option>
        <option value="SEAT Mii" data-multiplier="1.0">SEAT Mii (Mazais pilsētas auto)</option>
        <option value="SEAT Ibiza" data-multiplier="1.0">SEAT Ibiza (Kompakts)</option>
        <option value="SEAT Leon" data-multiplier="1.2">SEAT Leon (Hečbeks/Universālis)</option>
        <option value="SEAT Toledo" data-multiplier="1.2">SEAT Toledo (Sedans)</option>
        <option value="SEAT Arona" data-multiplier="1.2">SEAT Arona (Mazais SUV)</option>
        <option value="SEAT Ateca" data-multiplier="1.3">SEAT Ateca (SUV)</option>
        <option value="SEAT Tarraco" data-multiplier="1.5">SEAT Tarraco (Lielais SUV)</option>
        <option value="Suzuki Alto" data-multiplier="1.0">Suzuki Alto (Mazais pilsētas auto)</option>
        <option value="Suzuki Swift" data-multiplier="1.1">Suzuki Swift (Kompakts)</option>
        <option value="Suzuki Baleno" data-multiplier="1.1">Suzuki Baleno (Hečbeks)</option>
        <option value="Suzuki Ignis" data-multiplier="1.2">Suzuki Ignis (Mazais SUV)</option>
        <option value="Suzuki Vitara" data-multiplier="1.3">Suzuki Vitara (SUV)</option>
        <option value="Suzuki SX4" data-multiplier="1.3">Suzuki SX4 (Kompakts SUV)</option>
        <option value="Suzuki S-Cross" data-multiplier="1.4">Suzuki S-Cross (SUV)</option>
        <option value="Suzuki Jimny" data-multiplier="1.3">Suzuki Jimny (Apvidus auto)</option>
        <option value="Suzuki Grand Vitara" data-multiplier="1.5">Suzuki Grand Vitara (Lielāks SUV)</option>
        <option value="Chevrolet Spark" data-multiplier="1.0">Chevrolet Spark (Mazais auto)</option>
        <option value="Chevrolet Aveo" data-multiplier="1.1">Chevrolet Aveo (Kompakts)</option>
        <option value="Chevrolet Cruze" data-multiplier="1.2">Chevrolet Cruze (Sedans)</option>
        <option value="Chevrolet Malibu" data-multiplier="1.3">Chevrolet Malibu (Vidējs sedans)</option>
        <option value="Chevrolet Trax" data-multiplier="1.3">Chevrolet Trax (Mazais SUV)</option>
        <option value="Chevrolet Captiva" data-multiplier="1.4">Chevrolet Captiva (SUV)</option>
        <option value="Chevrolet Equinox" data-multiplier="1.4">Chevrolet Equinox (Vidējs SUV)</option>
        <option value="Chevrolet Tahoe" data-multiplier="1.6">Chevrolet Tahoe (Lielais SUV)</option>
        <option value="Chevrolet Suburban" data-multiplier="1.7">Chevrolet Suburban (XL SUV)</option>
        <option value="Chevrolet Camaro" data-multiplier="1.5">Chevrolet Camaro (Muscle car)</option>
        <option value="Chevrolet Corvette" data-multiplier="1.6">Chevrolet Corvette (Sporta kupeja)</option>
        <option value="Chrysler 200" data-multiplier="1.3">Chrysler 200 (Vidējs sedans)</option>
        <option value="Chrysler 300" data-multiplier="1.4">Chrysler 300 (Lielais sedans)</option>
        <option value="Chrysler PT Cruiser" data-multiplier="1.2">Chrysler PT Cruiser (Retro auto)</option>
        <option value="Chrysler Pacifica" data-multiplier="1.6">Chrysler Pacifica (Minivens)</option>
        <option value="Chrysler Grand Voyager" data-multiplier="1.7">Chrysler Grand Voyager (Lielais minivens)</option>
        <option value="Alfa Romeo MiTo" data-multiplier="1.1">Alfa Romeo MiTo (Mazais auto)</option>
        <option value="Alfa Romeo Giulietta" data-multiplier="1.2">Alfa Romeo Giulietta (Hečbeks)</option>
        <option value="Alfa Romeo Giulia" data-multiplier="1.3">Alfa Romeo Giulia (Sporta sedans)</option>
        <option value="Alfa Romeo Stelvio" data-multiplier="1.4">Alfa Romeo Stelvio (SUV)</option>
        <option value="Alfa Romeo 159" data-multiplier="1.3">Alfa Romeo 159 (Vidējs sedans)</option>
        <option value="Alfa Romeo 147" data-multiplier="1.2">Alfa Romeo 147 (Kompakts)</option>
        <option value="Alfa Romeo 156" data-multiplier="1.2">Alfa Romeo 156 (Sedans)</option>
        <option value="Dacia Spring" data-multiplier="1.1">Dacia Spring (Elektro kompakts)</option>
        <option value="Dacia Sandero" data-multiplier="1.1">Dacia Sandero (Kompakts)</option>
        <option value="Dacia Logan" data-multiplier="1.2">Dacia Logan (Sedans/Universālis)</option>
        <option value="Dacia Jogger" data-multiplier="1.4">Dacia Jogger (7-vietīgs ģimenes auto)</option>
        <option value="Dacia Duster" data-multiplier="1.4">Dacia Duster (SUV)</option>
        <option value="Dacia Lodgy" data-multiplier="1.5">Dacia Lodgy (Ģimenes minivens)</option>
        <option value="Dacia Dokker" data-multiplier="1.5">Dacia Dokker (Mazais busiņš)</option>
        <option value="Land Rover Defender" data-multiplier="1.6">Land Rover Defender (Apvidus auto)</option>
        <option value="Land Rover Discovery" data-multiplier="1.6">Land Rover Discovery (Premium SUV)</option>
        <option value="Land Rover Discovery Sport" data-multiplier="1.5">Discovery Sport (Mazāks SUV)</option>
        <option value="Range Rover Evoque" data-multiplier="1.4">Range Rover Evoque (Mazais luksusa SUV)</option>
        <option value="Range Rover Velar" data-multiplier="1.5">Range Rover Velar (Luksusa SUV)</option>
        <option value="Range Rover Sport" data-multiplier="1.6">Range Rover Sport (Sporta SUV)</option>
        <option value="Range Rover" data-multiplier="1.7">Range Rover (Flagmanis SUV)</option>
        <option value="Jaguar XE" data-multiplier="1.3">Jaguar XE (Sedans)</option>
        <option value="Jaguar XF" data-multiplier="1.4">Jaguar XF (Lielais sedans)</option>
        <option value="Jaguar XJ" data-multiplier="1.5">Jaguar XJ (Luksusa sedans)</option>
        <option value="Jaguar F-Pace" data-multiplier="1.5">Jaguar F-Pace (SUV)</option>
        <option value="Jaguar E-Pace" data-multiplier="1.4">Jaguar E-Pace (Mazais SUV)</option>
        <option value="Jaguar I-Pace" data-multiplier="1.5">Jaguar I-Pace (Elektro SUV)</option>
        <option value="Jaguar F-Type" data-multiplier="1.5">Jaguar F-Type (Sporta kupeja/kabriolets)</option>
        <option value="Porsche 911" data-multiplier="1.6">Porsche 911 (Sporta kupeja)</option>
        <option value="Porsche 718 Cayman" data-multiplier="1.5">Porsche 718 Cayman (Kupeja)</option>
        <option value="Porsche 718 Boxster" data-multiplier="1.5">Porsche 718 Boxster (Kabriolets)</option>
        <option value="Porsche Panamera" data-multiplier="1.6">Porsche Panamera (Luksusa sedans)</option>
        <option value="Porsche Taycan" data-multiplier="1.5">Porsche Taycan (Elektro sedans)</option>
        <option value="Porsche Macan" data-multiplier="1.5">Porsche Macan (Mazais SUV)</option>
        <option value="Porsche Cayenne" data-multiplier="1.6">Porsche Cayenne (SUV)</option>
        <option value="Mini One" data-multiplier="1.0">Mini One (Mazais auto)</option>
        <option value="Mini Cooper" data-multiplier="1.1">Mini Cooper (Kompakts)</option>
        <option value="Mini Cooper S" data-multiplier="1.2">Mini Cooper S (Sporta kompakts)</option>
        <option value="Mini Clubman" data-multiplier="1.2">Mini Clubman (Hečbeks/Universālis)</option>
        <option value="Mini Countryman" data-multiplier="1.3">Mini Countryman (Mazais SUV)</option>
        <option value="Mini Electric" data-multiplier="1.2">Mini Electric (Elektro kompakts)</option>
        <option value="Smart Fortwo" data-multiplier="0.9">Smart Fortwo (2-vietīgs pilsētas auto)</option>
        <option value="Smart Forfour" data-multiplier="1.0">Smart Forfour (4-vietīgs kompakts)</option>
        <option value="Smart EQ Fortwo" data-multiplier="1.0">Smart EQ Fortwo (Elektro 2-vietīgs)</option>
        <option value="Smart EQ Forfour" data-multiplier="1.1">Smart EQ Forfour (Elektro kompakts)</option>
        <option value="Saab 9-3" data-multiplier="1.2">Saab 9-3 (Sedans/Kabriolets)</option>
        <option value="Saab 9-5" data-multiplier="1.3">Saab 9-5 (Lielais sedans)</option>
        <option value="Saab 9-7X" data-multiplier="1.5">Saab 9-7X (SUV)</option>
        <option value="Saab 900" data-multiplier="1.1">Saab 900 (Hečbeks/Klasika)</option>
        <option value="Daewoo Matiz" data-multiplier="1.0">Daewoo Matiz (Mazais pilsētas auto)</option>
        <option value="Daewoo Kalos" data-multiplier="1.1">Daewoo Kalos (Kompakts)</option>
        <option value="Daewoo Lanos" data-multiplier="1.1">Daewoo Lanos (Sedans)</option>
        <option value="Daewoo Nubira" data-multiplier="1.2">Daewoo Nubira (Sedans/Universālis)</option>
        <option value="Daewoo Leganza" data-multiplier="1.3">Daewoo Leganza (Lielāks sedans)</option>
                {!! $carOptions ?? '' !!}
            </select>
        </div>

        {{-- Auto stāvoklis --}}
        <div>
            <label for="condition">Stāvoklis:</label>
            <select name="condition" id="condition" required>
                <option value="">-- Izvēlies --</option>
                <option value="normal">Normāls</option>
                <option value="dirty">Netīrs</option>
                <option value="very_dirty">Ļoti netīrs</option>
            </select>
        </div>

        {{-- Materiāls, ja izvēlēsies salona pakalpojumu --}}
        <div>
            <label for="material">Salona materiāls (ādas, audums...):</label>
            <input type="text" name="material" id="material" placeholder="piem., ādas salons">
        </div>

        {{-- Datums + laiks --}}
        <div>
            <label for="date">Datums:</label>
            <input type="date" name="date" id="date" required>
        </div>

        <div>
            <label for="time">Laiks:</label>
            <input type="time" name="time" id="time" required>
        </div>

        {{-- Pakalpojumi (šeit vienkārši piemēri – vēlāk var ņemt no DB) --}}
        <fieldset>
            <legend>Pakalpojumi:</legend>
            <label>
                <input type="checkbox" name="services[]" value="exterior" data-price="30">
                Ārējā mazgāšana (30 €)
            </label><br>
            <label>
                <input type="checkbox" name="services[]" value="interior" data-price="40">
                Salona tīrīšana (40 €)
            </label><br>
            <label>
                <input type="checkbox" name="services[]" value="polishing" data-price="80">
                Pulēšana (80 €)
            </label>
        </fieldset>

        {{-- Gala cena --}}
        <div>
            <p>Kopējā cena: <strong><span id="totalDisplay">0.00</span> €</strong></p>
            <input type="hidden" name="total" id="total">
        </div>

        <button type="submit">Apstiprināt pieteikumu</button>
    </form>
</main>

<script>
// JS kalkulators

function calculateTotal() {
    const carSelect = document.getElementById('car');
    const selectedOption = carSelect.options[carSelect.selectedIndex];
    const multiplier = parseFloat(selectedOption.getAttribute('data-multiplier')) || 1.0;

    let baseTotal = 0;

    document.querySelectorAll('input[name="services[]"]:checked').forEach(cb => {
        baseTotal += parseFloat(cb.getAttribute('data-price')) || 0;
    });

    // Stāvokļa koeficients (piemērs)
    const condition = document.getElementById('condition').value;
    let conditionMultiplier = 1.0;
    if (condition === 'dirty') conditionMultiplier = 1.1;
    if (condition === 'very_dirty') conditionMultiplier = 1.25;

    const total = baseTotal * multiplier * conditionMultiplier;

    document.getElementById('totalDisplay').textContent = total.toFixed(2);
    document.getElementById('total').value = total.toFixed(2);
}

document.getElementById('car').addEventListener('change', calculateTotal);
document.getElementById('condition').addEventListener('change', calculateTotal);
document.querySelectorAll('input[name="services[]"]').forEach(cb => {
    cb.addEventListener('change', calculateTotal);
});
</script>

</body>
</html>
