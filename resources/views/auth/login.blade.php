@extends('layouts.public')

@section('title', 'Pieteikties - Auto Detailing Workshop')

@push('styles')
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --accent: #ff5c35;
            --accent-dark: #d9461f;
            --accent-light: #fff1ec;
            --ink: #1a1a1a;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            color: var(--ink);
            background: #fafafa;
        }

        .auth-section {
            max-width: 1100px;
            margin: 0 auto;
            padding: 4rem 2rem 5rem;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 3rem;
        }

        .auth-copy {
            padding: 3rem;
            border-radius: 24px;
            background: white;
            border: 1px solid #f0e0d9;
            position: relative;
        }

        .auth-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.85rem;
            letter-spacing: 0.2rem;
            text-transform: uppercase;
            color: var(--accent-dark);
            background: rgba(255, 92, 53, 0.12);
            padding: 0.45rem 1.2rem;
            border-radius: 999px;
            margin-bottom: 1rem;
        }

        .auth-copy h1 {
            font-size: 2.6rem;
            line-height: 1.2;
            margin-bottom: 1rem;
        }

        .auth-copy p {
            color: #555;
            margin-bottom: 1.5rem;
        }

        .auth-card {
            background: white;
            border-radius: 24px;
            padding: 3rem;
            border: 1px solid #e8e8e8;
            box-shadow: 0 15px 35px rgba(0,0,0,0.05);
        }

        .auth-card h2 {
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
        }

        .auth-card p {
            color: #666;
            margin-bottom: 2rem;
        }

        .form-field {
            margin-bottom: 1.3rem;
        }

        .form-field label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.4rem;
        }

        .form-field input {
            width: 100%;
            padding: 0.95rem;
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            font-size: 1rem;
            transition: border 0.2s;
        }

        .form-field input:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-light);
        }

        .primary-btn {
            width: 100%;
            padding: 1rem;
            border: none;
            border-radius: 12px;
            background: var(--accent);
            color: white;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }

        .primary-btn:hover {
            background: var(--accent-dark);
        }

        .secondary-link {
            margin-top: 1rem;
            text-align: center;
            font-size: 0.95rem;
        }

        .secondary-link a {
            color: var(--accent);
            font-weight: 600;
            text-decoration: none;
        }

        .message {
            margin-top: 1.5rem;
            padding: 1rem;
            border-radius: 12px;
            text-align: center;
            font-weight: 600;
            display: none;
        }

        .message.success {
            display: block;
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .message.error {
            display: block;
            background: #f8d7da;
            color: #842029;
            border: 1px solid #f5c2c7;
        }

        footer {
            max-width: 1400px;
            margin: 0 auto;
            padding: 3rem 2rem;
            text-align: center;
            color: #666;
        }

        @media (max-width: 768px) {
            .auth-card,
            .auth-copy {
                padding: 2rem;
            }
        }
    </style>
@endpush

@section('content')
    <section class="auth-section">
        <div class="auth-copy">
            <div class="auth-pill">Drošs konts</div>
            <h1>Pieslēdzies, lai pārvaldītu rezervācijas un pasūtījumus</h1>
            <p>Saglabā savu pakalpojumu vēsturi, piekļūsti rēķiniem un seko līdzi piedāvājumiem vienuviet.</p>
        </div>

        <div class="auth-card">
            <h2>Pieteikties</h2>
            <p>Ievadi savu e-pastu un paroli</p>
            <form method="POST" action="{{ route('login.store') }}">
                @csrf
                <div class="form-field">
                    <label for="email">E-pasts</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="piem., vards@example.com">
                    @error('email')
                        <small style="color:#c53030; display:block; margin-top:0.3rem;">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-field">
                    <label for="password">Parole</label>
                    <input type="password" id="password" name="password" required placeholder="********">
                    @error('password')
                        <small style="color:#c53030; display:block; margin-top:0.3rem;">{{ $message }}</small>
                    @enderror
                </div>
                <div style="margin-bottom: 1.5rem;">
                    <a href="{{ route('password.request') }}" style="color:var(--accent); font-weight:600; text-decoration:none;">Aizmirsi paroli?</a>
                </div>
                <button type="submit" class="primary-btn">Ieiet</button>
                @if ($errors->any())
                    <div class="message error" style="margin-top:1rem;">{{ $errors->first() }}</div>
                @endif
                @if (session('status'))
                    <div class="message success" style="margin-top:1rem;">{{ session('status') }}</div>
                @endif
            </form>
            <div class="secondary-link">
                Nav konta? <a href="{{ route('register') }}">Reģistrējies</a>
            </div>
        </div>
    </section>

@endsection
