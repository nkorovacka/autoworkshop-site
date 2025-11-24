<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <title>Mūsu darbi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<header>
    <nav>
        <a href="{{ url('/') }}">Galvenā lapa</a> |
        <a href="{{ url('/services') }}">Pakalpojumi</a> |
        <a href="{{ url('/products') }}">Produkti</a> |
        <a href="{{ url('/our-work') }}">Mūsu darbi</a>
    </nav>
</header>

<main>
    <h1>Mūsu darbi</h1>
    <p>Šeit var parādīt “pirms/pēc” bildes un īsus aprakstus par projektiem.</p>

    <section>
        <h2>Pirms / Pēc galerija</h2>

        <div>
            <h3>BMW 5. sērija – pilns detailing</h3>
            <p>Pirms: izbalējusi krāsa, redzami skrāpējumi. Pēc: spīdīga virsbūve, aizsargpārklājums, iztīrīts salons.</p>
        </div>

        <div>
            <h3>VW Golf – salona ķīmiskā tīrīšana</h3>
            <p>Pirms: traipi uz sēdekļiem un grīdas. Pēc: atjaunots salons, patīkams aromāts.</p>
        </div>

        <div>
            <h3>Audi A6 – keramiskā aizsardzība</h3>
            <p>Pirms: matēta virsbūve. Pēc: dziļš spīdums un ūdeni atgrūdošs pārklājums.</p>
        </div>
    </section>
</main>

<footer>
    <p>&copy; {{ date('Y') }} Auto Detailing Workshop</p>
</footer>
</body>
</html>
