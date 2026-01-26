<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aizmirsu paroli - Auto Detailing Workshop</title>
</head>
<body>
<!-- Galvene ar navigāciju -->
<header>
    <nav>
        <div class="logo">Auto Detailing</div>
        <ul class="nav-links">
            <li><a href="{{ route('home') }}">Galvenā</a></li>
            <li><a href="{{ route('services.index') }}">Pakalpojumi</a></li>
            <li><a href="{{ route('products.index') }}">Produkti</a></li>
            <li><a href="{{ route('offers.index') }}">Piedāvājumi</a></li>
            <li><a href="{{ route('our-work') }}">Darbi</a></li>
        </ul>
        <div class="nav-right">
            <a class="btn-login" href="{{ route('login') }}">Ieiet</a>
            <a class="btn-signup" href="{{ route('register') }}">Reģistrēties</a>
        </div>
    </nav>
</header>

<main>
    <!-- Lapas virsraksts -->
    <section class="auth-header">
        <h1>Aizmirsu paroli</h1>
        <p>Ievadi savu e-pastu, un mēs nosūtīsim paroles atiestatīšanas saiti.</p>
    </section>

    <!-- Statusa vai kļūdas paziņojumi -->
    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-error">{{ $errors->first() }}</div>
    @endif

    <!-- Paroles atiestatīšanas pieprasījuma forma -->
    <section class="auth-card">
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <label for="email">E-pasts</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required>
            <button type="submit">Nosūtīt saiti</button>
        </form>
        <div class="helper-links">
            <a href="{{ route('login') }}">Atpakaļ uz pieteikšanos</a>
        </div>
    </section>
</main>

<!-- Iekšējais CSS: novietots pēc HTML, lai atdalītu struktūru no noformējuma -->
<style>
    /* Globālā nullēšana un kastes modelis */
    * { margin: 0; padding: 0; box-sizing: border-box; }
    /* Krāsu mainīgie un palete */
    :root {
        --accent: #ff5c35;
        --accent-dark: #d9461f;
        --ink: #1a1a1a;
        --muted: #6f6f6f;
        --border: #e8e8e8;
    }
    /* Pamatteksts un fons */
    body { font-family: "Inter", Arial, sans-serif; background: #fafafa; color: var(--ink); line-height: 1.6; }

    /* Galvene un navigācija */
    header { background: white; border-bottom: 1px solid var(--border); }
    nav { max-width: 1400px; margin: 0 auto; padding: 1.2rem 2rem; display: flex; justify-content: space-between; align-items: center; }
    .logo { font-weight: 600; letter-spacing: -0.5px; font-size: 1.15rem; }
    .nav-links { list-style: none; display: flex; gap: 1.8rem; }
    .nav-links a { text-decoration: none; color: var(--muted); font-weight: 500; }
    .nav-links a:hover { color: var(--ink); }
    .nav-right { display: flex; gap: 0.8rem; }
    .btn-login, .btn-signup { padding: 0.45rem 1.1rem; border-radius: 8px; font-size: 0.85rem; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; }
    .btn-login { border: 1px solid var(--border); color: var(--ink); }
    .btn-signup { background: var(--ink); color: white; }

    /* Lapas saturs */
    main { max-width: 600px; margin: 0 auto; padding: 3rem 2rem 4rem; }
    .auth-header { text-align: center; margin-bottom: 2rem; }
    .auth-header h1 { font-size: 2.2rem; margin-bottom: 0.6rem; }
    .auth-header p { color: var(--muted); }

    /* Paziņojumi */
    .alert { padding: 0.9rem 1.1rem; border-radius: 12px; margin-bottom: 1.2rem; font-weight: 500; }
    .alert-success { background: #e6f5ef; color: #136b3a; border: 1px solid #b7e2c9; }
    .alert-error { background: #fdecea; color: #b5302c; border: 1px solid #f3c0b7; }

    /* Forma */
    .auth-card { background: white; border: 1px solid var(--border); border-radius: 16px; padding: 2rem; display: flex; flex-direction: column; gap: 1rem; }
    label { font-weight: 600; margin-bottom: 0.4rem; display: block; }
    input { width: 100%; padding: 0.7rem 0.9rem; border-radius: 10px; border: 1px solid var(--border); font-size: 1rem; }
    input:focus { outline: none; border-color: var(--accent); box-shadow: 0 0 0 3px rgba(255,92,53,0.15); }
    button { width: 100%; padding: 0.85rem; border: none; border-radius: 12px; background: var(--ink); color: white; font-weight: 600; cursor: pointer; }
    .helper-links { text-align: center; margin-top: 0.5rem; }
    .helper-links a { color: var(--accent); text-decoration: none; font-weight: 600; }

    /* Responsivitāte */
    @media (max-width: 700px) {
        nav { flex-direction: column; gap: 0.8rem; }
        .nav-links { flex-wrap: wrap; justify-content: center; }
        .nav-right { width: 100%; justify-content: center; }
    }
</style>
</body>
</html>
