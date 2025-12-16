<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <title>Piedāvājumi un pasākumi - Auto Detailing Workshop</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
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

        /* Header */
        header {
            background: white;
            border-bottom: 1px solid #e8e8e8;
            padding: 1.2rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        nav {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--ink);
            letter-spacing: -0.5px;
        }

        .nav-links {
            display: flex;
            list-style: none;
            gap: 2.5rem;
        }

        .nav-links a {
            text-decoration: none;
            color: #666;
            font-size: 0.95rem;
            font-weight: 500;
            transition: color 0.2s;
        }

        .nav-links a:hover,
        .nav-links a.active {
            color: var(--ink);
        }

        .nav-right {
            display: flex;
            gap: 1.5rem;
            align-items: center;
        }

        .icon-button {
            background: none;
            border: none;
            font-size: 1.3rem;
            cursor: pointer;
            color: #666;
            transition: color 0.2s;
        }

        .icon-button:hover {
            color: var(--ink);
        }

        .auth-buttons {
            display: flex;
            gap: 1rem;
        }

        .btn-login {
            padding: 0.5rem 1.2rem;
            background: none;
            border: 1px solid #e8e8e8;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--ink);
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-login:hover {
            background: #f5f5f5;
        }

        .btn-signup {
            padding: 0.5rem 1.2rem;
            background: var(--ink);
            border: none;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 500;
            color: white;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-signup:hover {
            background: #333;
        }

        .auth-buttons.signed-in {
            gap: 0.6rem;
            align-items: center;
        }

        .logout-form {
            margin: 0;
        }

        .btn-logout {
            padding: 0.45rem 1rem;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 500;
            border: none;
            background: #f1f1f1;
            color: var(--ink);
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-logout:hover {
            background: #dfdfdf;
        }

        .auth-buttons.signed-in {
            gap: 0.6rem;
        }

        .user-greeting {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--ink);
            white-space: nowrap;
        }

        .btn-cart,
        .btn-profile {
            padding: 0.45rem 1.1rem;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .btn-cart {
            border: 1px solid #e8e8e8;
            background: white;
            color: var(--ink);
        }

        .btn-cart:hover {
            background: #f5f5f5;
        }

        .btn-profile {
            border: none;
            background: var(--ink);
            color: white;
        }

        .btn-profile:hover {
            background: #333;
        }

        /* Hero Section */
        .hero {
            max-width: 1400px;
            margin: 0 auto;
            padding: 3rem 2rem;
            text-align: center;
        }

        .hero h1 {
            font-size: 2.8rem;
            font-weight: 700;
            margin-bottom: 1rem;
            letter-spacing: -1px;
        }

        .hero p {
            font-size: 1.2rem;
            color: #666;
            max-width: 600px;
            margin: 0 auto;
        }

        /* Filter Tabs */
        .filter-tabs {
            max-width: 1400px;
            margin: 0 auto 3rem;
            padding: 0 2rem;
            display: flex;
            gap: 1rem;
            justify-content: center;
        }

        .filter-tab {
            padding: 0.8rem 2rem;
            background: white;
            border: 2px solid #e8e8e8;
            border-radius: 999px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.2s;
        }

        .filter-tab:hover {
            border-color: var(--accent);
        }

        .filter-tab.active {
            background: var(--accent);
            color: white;
            border-color: var(--accent);
        }

        /* Offers Grid */
        .offers-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem 4rem;
        }

        .offers-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
            gap: 2rem;
        }

        /* Offer Card */
        .offer-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid #e8e8e8;
            transition: all 0.3s;
            display: flex;
            flex-direction: column;
        }

        .offer-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .offer-header {
            padding: 2rem;
            background: linear-gradient(135deg, var(--accent-light) 0%, #fff 100%);
        }

        .offer-type {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.4rem 1rem;
            background: white;
            border-radius: 999px;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--accent);
            margin-bottom: 1rem;
        }

        .offer-type.webinar {
            background: var(--accent);
            color: white;
        }

        .offer-type.detailing {
            background: var(--ink);
            color: white;
        }

        .offer-card h3 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .offer-date {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #666;
            font-size: 0.95rem;
        }

        .offer-body {
            padding: 2rem;
            flex: 1;
        }

        .offer-description {
            color: #555;
            margin-bottom: 1.5rem;
            line-height: 1.7;
        }

        .offer-spots {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 12px;
            margin-bottom: 1.5rem;
        }

        .spots-progress {
            flex: 1;
            height: 8px;
            background: #e8e8e8;
            border-radius: 999px;
            overflow: hidden;
        }

        .spots-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--accent), var(--accent-dark));
            border-radius: 999px;
            transition: width 0.3s;
        }

        .spots-text {
            font-size: 0.9rem;
            font-weight: 600;
            color: #666;
        }

        .offer-footer {
            padding: 0 2rem 2rem;
        }

        .offer-btn {
            width: 100%;
            padding: 1rem;
            background: var(--ink);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .offer-btn:hover {
            background: #333;
            transform: scale(1.02);
        }

        .offer-btn:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: scale(1);
        }

        .offer-btn.webinar {
            background: var(--accent);
        }

        .offer-btn.webinar:hover {
            background: var(--accent-dark);
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 10000;
            padding: 2rem;
            overflow-y: auto;
        }

        .modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: white;
            border-radius: 20px;
            max-width: 500px;
            width: 100%;
            padding: 2.5rem;
            position: relative;
        }

        .modal-close {
            position: absolute;
            top: 1.5rem;
            right: 1.5rem;
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #666;
        }

        .modal h2 {
            font-size: 1.8rem;
            margin-bottom: 1rem;
        }

        .modal-form .form-field {
            margin-bottom: 1.5rem;
        }

        .modal-form label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .modal-form input {
            width: 100%;
            padding: 0.9rem;
            border: 1px solid #e8e8e8;
            border-radius: 10px;
            font-size: 1rem;
        }

        .modal-form input:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-light);
        }

        .modal-submit {
            width: 100%;
            padding: 1rem;
            background: var(--accent);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .modal-submit:hover {
            background: var(--accent-dark);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
        }

        .empty-state-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }

        .empty-state h3 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .empty-state p {
            color: #666;
        }

        /* Messages */
        .message {
            max-width: 1400px;
            margin: 0 auto 2rem;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            margin-left: 2rem;
            margin-right: 2rem;
        }

        .message.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .message.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Responsive */
        @media (max-width: 968px) {
            .nav-links {
                display: none;
            }

            .offers-grid {
                grid-template-columns: 1fr;
            }

            .hero h1 {
                font-size: 2rem;
            }
        }

        @media (max-width: 640px) {
            .filter-tabs {
                flex-direction: column;
            }

            .filter-tab {
                width: 100%;
            }
        }

        footer {
            max-width: 1400px;
            margin: 0 auto;
            padding: 3rem 2rem;
            text-align: center;
            color: #666;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <div class="logo">Auto Detailing</div>
            <ul class="nav-links">
                <li><a href="{{ route('home') }}">Galvenā</a></li>
                <li><a href="{{ route('services.index') }}">Pakalpojumi</a></li>
                <li><a href="{{ route('products.index') }}">Produkti</a></li>
                <li><a href="{{ route('offers.index') }}" class="active">Piedāvājumi</a></li>
                <li><a href="{{ route('our-work') }}">Darbi</a></li>
            </ul>
            <div class="nav-right">
                @auth
                    <div class="user-greeting">Sveiki, {{ auth()->user()->name }}</div>
                    <div class="auth-buttons signed-in">
                        <a class="btn-cart" href="#">🛒 Grozs</a>
                        <a class="btn-profile" href="{{ route('profile') }}">👤 Profils</a>
                        <form method="POST" action="{{ route('logout') }}" class="logout-form">
                            @csrf
                            <button type="submit" class="btn-logout">Iziet</button>
                        </form>
                    </div>
                @else
                    <button class="icon-button" title="Profils">👤</button>
                    <div class="auth-buttons">
                        <a class="btn-login" href="{{ route('login') }}">Ieiet</a>
                        <a class="btn-signup" href="{{ route('register') }}">Reģistrēties</a>
                    </div>
                @endauth
            </div>
        </nav>
    </header>

    <div class="hero">
        <h1>Piedāvājumi un pasākumi</h1>
        <p>Izmanto īpašos piedāvājumus un piedalies mūsu vebināros, lai uzzinātu vairāk par auto kopšanu</p>
    </div>

    <!-- Filter Tabs -->
    <div class="filter-tabs">
        <button class="filter-tab active" data-filter="all">Visi piedāvājumi</button>
        <button class="filter-tab" data-filter="webinar">Vebināri</button>
        <button class="filter-tab" data-filter="detailing">Detailing akcijas</button>
    </div>

    <!-- Messages -->
    <div id="messages">
        @if (session('success'))
            <div class="message success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="message error">{{ session('error') }}</div>
        @endif
        @if ($errors->any())
            <div class="message error">{{ $errors->first() }}</div>
        @endif
    </div>

    <!-- Offers Grid -->
    <div class="offers-container">
        @if($offers->isEmpty())
            <div class="empty-state" id="emptyState">
                <div class="empty-state-icon">📭</div>
                <h3>Nav aktīvu piedāvājumu</h3>
                <p>Šobrīd nav pieejamu piedāvājumu šajā kategorijā</p>
            </div>
        @else
            <div class="offers-grid" id="offersGrid">
                @foreach($offers as $offer)
                    @php
                        $isFull = $offer->is_limited && $offer->capacity && $offer->registrations_count >= $offer->capacity;
                        $spotsPercent = $offer->is_limited && $offer->capacity
                            ? min(100, round($offer->registrations_count / $offer->capacity * 100))
                            : 0;
                        $eventDate = $offer->event_date
                            ? \Carbon\Carbon::parse($offer->event_date)->locale('lv')->translatedFormat('d. F H:i')
                            : null;
                    @endphp
                    <div class="offer-card" data-type="{{ $offer->type }}">
                        <div class="offer-header">
                            <span class="offer-type {{ $offer->type }}">
                                {{ $offer->type === 'webinar' ? '🎥 Vebinārs' : '✨ Detailing' }}
                            </span>
                            <h3>{{ $offer->title }}</h3>
                            @if($eventDate)
                                <div class="offer-date">
                                    📅 {{ $eventDate }}
                                </div>
                            @endif
                        </div>
                        <div class="offer-body">
                            <p class="offer-description">{{ $offer->description }}</p>
                            @if($offer->is_limited && $offer->capacity)
                                <div class="offer-spots">
                                    <div class="spots-progress">
                                        <div class="spots-fill" style="width: {{ $spotsPercent }}%"></div>
                                    </div>
                                    <div class="spots-text">
                                        {{ $offer->registrations_count }}/{{ $offer->capacity }} vietas
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="offer-footer">
                            @if($offer->type === 'webinar')
                                @auth
                                    <button type="button"
                                            class="offer-btn webinar webinar-trigger"
                                            data-offer-id="{{ $offer->id }}"
                                            data-offer-title="{{ $offer->title }}"
                                            data-offer-action="{{ route('offers.signup', $offer) }}"
                                            {{ $isFull ? 'disabled' : '' }}>
                                        {{ $isFull ? 'Pilns' : 'Pieteikties vebināram' }}
                                    </button>
                                @else
                                    <a class="offer-btn webinar" href="{{ route('login') }}">
                                        Ieiet, lai pieteiktos
                                    </a>
                                @endauth
                            @else
                                <a class="offer-btn"
                                   href="{{ route('booking.create', ['offer' => $offer->id]) }}">
                                    Rezervēt ar atlaidi
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Registration Modal -->
    <div class="modal" id="registrationModal">
        <div class="modal-content">
            <button class="modal-close" onclick="closeModal()">×</button>
            <h2 id="modalTitle">Pieteikties pasākumam</h2>
            <form class="modal-form" id="registrationForm" method="POST" action="">
                @csrf
                <input type="hidden" id="modalOfferId" name="offer_id">
                <div class="form-field">
                    <label for="modalName">Vārds, Uzvārds *</label>
                    <input type="text" id="modalName" name="name" required>
                </div>
                <div class="form-field">
                    <label for="modalEmail">E-pasts *</label>
                    <input type="email" id="modalEmail" name="email" required>
                </div>
                <button type="submit" class="modal-submit">Pieteikties</button>
            </form>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Auto Detailing Workshop. Visas tiesības aizsargātas.</p>
    </footer>

    <script>
        const filterTabs = document.querySelectorAll('.filter-tab');
        const offerCards = document.querySelectorAll('.offer-card');
        const emptyState = document.getElementById('emptyState');

        filterTabs.forEach(tab => {
            tab.addEventListener('click', () => {
                filterTabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');
                const filter = tab.dataset.filter;
                let visibleCount = 0;

                offerCards.forEach(card => {
                    if (!card) return;
                    if (filter === 'all' || card.dataset.type === filter) {
                        card.style.display = 'flex';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                if (emptyState) {
                    emptyState.style.display = visibleCount === 0 ? 'block' : 'none';
                }
            });
        });

        const registrationModal = document.getElementById('registrationModal');
        const registrationForm = document.getElementById('registrationForm');
        const modalTitle = document.getElementById('modalTitle');
        const modalOfferId = document.getElementById('modalOfferId');

        document.querySelectorAll('.webinar-trigger').forEach(btn => {
            btn.addEventListener('click', () => {
                modalTitle.textContent = `Pieteikties: ${btn.dataset.offerTitle}`;
                modalOfferId.value = btn.dataset.offerId;
                registrationForm.action = btn.dataset.offerAction;
                registrationModal.classList.add('active');
            });
        });

        function closeModal() {
            registrationModal.classList.remove('active');
            registrationForm.reset();
        }

        window.closeModal = closeModal;

        registrationModal?.addEventListener('click', (e) => {
            if (e.target === registrationModal) {
                closeModal();
            }
        });
    </script>
</body>
</html>
