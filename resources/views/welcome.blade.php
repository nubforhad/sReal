<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Home | Safe ERP</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/fav1.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Unbounded:wght@500;700&family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- Pure CSS: no Tailwind/Vite needed, so this page cannot break from a missing build --}}
    <style>
        :root {
            --night: #14183A;
            --night-2: #1E2350;
            --violet: #4B3BFF;
            --amber: #FFB400;
            --paper: #EEF1F8;
            --white: #ffffff;
            --text: #2A2F55;
            --muted: #6B7094;
            --line: #D5DAEC;
        }
        *, *::before, *::after { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            margin: 0;
            font-family: 'Manrope', system-ui, -apple-system, 'Segoe UI', sans-serif;
            background: var(--paper);
            color: var(--text);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }
        a { color: inherit; text-decoration: none; }
        .display { font-family: 'Unbounded', 'Manrope', sans-serif; }
        .wrap { width: 100%; max-width: 1180px; margin: 0 auto; padding: 0 24px; }

        /* Header */
        .top { display: flex; align-items: center; justify-content: space-between; padding: 26px 0; }
        .brand { display: flex; align-items: center; gap: 12px; font-weight: 700; font-size: 1.15rem; color: var(--night); }
        .brand svg { width: 34px; height: 34px; }
        .nav { display: flex; align-items: center; gap: 8px; }
        .nav a { padding: 10px 16px; border-radius: 999px; font-weight: 600; font-size: .95rem; transition: background .15s, color .15s; }
        .nav a:hover { background: rgba(20,24,58,.07); }
        .nav a.solid { background: var(--night); color: #fff; }
        .nav a.solid:hover { background: var(--violet); }
        a:focus-visible, button:focus-visible { outline: 3px solid var(--violet); outline-offset: 3px; }

        /* Hero */
        .hero { display: grid; grid-template-columns: 1.1fr .9fr; align-items: center; gap: 48px; padding: 48px 0 88px; }
        .hero h1 {
            margin: 0;
            font-family: 'Unbounded', sans-serif;
            font-weight: 700;
            font-size: clamp(2.2rem, 4.6vw, 3.7rem);
            line-height: 1.12;
            letter-spacing: -.02em;
            color: var(--night);
        }
        .hero p.lead { margin: 22px 0 0; max-width: 480px; font-size: 1.12rem; color: var(--muted); }
        .actions { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 34px; }
        .btn {
            display: inline-flex; align-items: center; justify-content: center;
            padding: 15px 28px; border-radius: 999px; font-weight: 700; font-size: 1rem;
            border: 2px solid transparent; cursor: pointer;
            transition: background .15s, color .15s, border-color .15s, transform .1s;
        }
        .btn:active { transform: scale(.98); }
        .btn-dark { background: var(--night); color: #fff; }
        .btn-dark:hover { background: var(--violet); }
        .btn-line { border-color: var(--night); color: var(--night); }
        .btn-line:hover { background: var(--night); color: #fff; }
        .btn-amber { background: var(--amber); color: var(--night); }
        .btn-amber:hover { background: #ffc531; }

        /* Vault dial: the one memorable moment. It spins once and settles. */
        .vault { position: relative; justify-self: center; width: 100%; max-width: 440px; aspect-ratio: 1; }
        .vault svg { width: 100%; height: 100%; display: block; overflow: visible; }
        .dial { transform-origin: 200px 200px; animation: spin 3.2s cubic-bezier(.16,.84,.3,1) both; }
        @keyframes spin { from { transform: rotate(-640deg); } to { transform: rotate(0deg); } }
        .ticks line { stroke: var(--night); stroke-width: 2; stroke-linecap: round; }
        .ticks line.major { stroke-width: 3.5; }
        .pointer { animation: pop .5s 2.6s both; transform-origin: 200px 12px; }
        @keyframes pop { from { opacity: 0; transform: scale(.4); } to { opacity: 1; transform: scale(1); } }
        .unlocked { animation: fade .6s 2.9s both; }
        @keyframes fade { from { opacity: 0; } to { opacity: 1; } }
        @media (prefers-reduced-motion: reduce) {
            .dial, .pointer, .unlocked { animation: none; }
            html { scroll-behavior: auto; }
        }

        /* Modules */
        .vaultbox { background: var(--night); color: #fff; }
        .vaultbox .wrap { display: grid; grid-template-columns: .8fr 1.2fr; gap: 56px; padding-top: 88px; padding-bottom: 88px; }
        .vaultbox h2 { margin: 0; font-family: 'Unbounded', sans-serif; font-weight: 700; font-size: clamp(1.7rem, 3vw, 2.4rem); line-height: 1.2; letter-spacing: -.01em; }
        .vaultbox .sub { margin-top: 18px; color: rgba(255,255,255,.62); max-width: 340px; }
        .rows { border-top: 1px solid rgba(255,255,255,.16); }
        .row {
            display: grid; grid-template-columns: 190px 1fr; gap: 24px; align-items: baseline;
            padding: 24px 12px; margin: 0 -12px; border-bottom: 1px solid rgba(255,255,255,.16);
            border-radius: 10px; transition: background .2s;
        }
        .row:hover { background: var(--night-2); }
        .row b { font-family: 'Unbounded', sans-serif; font-weight: 500; font-size: 1.05rem; color: var(--amber); }
        .row span { color: rgba(255,255,255,.78); }

        /* Closing */
        .close { display: flex; align-items: center; justify-content: space-between; gap: 32px; flex-wrap: wrap; padding: 84px 0; }
        .close h2 { margin: 0; font-family: 'Unbounded', sans-serif; font-weight: 700; font-size: clamp(1.6rem, 3vw, 2.3rem); line-height: 1.2; color: var(--night); max-width: 560px; }
        footer { padding: 0 0 36px; color: var(--muted); font-size: .9rem; }

        /* Responsive */
        @media (max-width: 900px) {
            .hero { grid-template-columns: 1fr; padding-top: 24px; gap: 40px; }
            .vault { max-width: 340px; order: -1; }
            .vaultbox .wrap { grid-template-columns: 1fr; gap: 32px; padding-top: 64px; padding-bottom: 64px; }
        }
        @media (max-width: 560px) {
            .row { grid-template-columns: 1fr; gap: 4px; }
            .nav a:not(.solid) { padding: 10px 12px; }
        }
    </style>
</head>
<body>

    <div class="wrap">
        <header class="top">
            <a href="{{ url('/') }}" class="brand">
                <img src="{{ asset('assets/images/fav1.png') }}" alt="Safe ERP Logo" style="width: 34px; height: 34px;">
                <span class="display" style="font-size:1.05rem;">Safe ERP</span>
            </a>

            @if (Route::has('login'))
                <nav class="nav">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="solid">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="solid">Register</a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header>

        <section class="hero">
            <div>
                <h1>Run your business behind a locked door.</h1>
                <p class="lead">
                    Sales, stock, accounts and staff live in one system, and only the people you approve can open it.
                </p>
                <div class="actions">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-dark">Open dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-dark">Log in</a>
                        <a href="#modules" class="btn btn-line">See what's inside</a>
                    @endauth
                </div>
            </div>

            <div class="vault" aria-hidden="true">
                <svg viewBox="0 0 400 400">
                    <circle cx="200" cy="200" r="196" fill="#fff" stroke="#D5DAEC" stroke-width="2"/>
                    <g class="dial">
                        <g class="ticks">
                            @for ($i = 0; $i < 60; $i++)
                                <line x1="200" y1="16" x2="200" y2="{{ $i % 5 === 0 ? 40 : 30 }}"
                                      transform="rotate({{ $i * 6 }} 200 200)"
                                      class="{{ $i % 5 === 0 ? 'major' : '' }}"/>
                            @endfor
                        </g>
                        <circle cx="200" cy="200" r="138" fill="#14183A"/>
                        <circle cx="200" cy="200" r="118" fill="none" stroke="#4B3BFF" stroke-width="2" stroke-dasharray="3 9" stroke-linecap="round"/>
                    </g>
                    <img src="{{ asset('assets/images/fav1.png') }}" alt="Safe ERP Logo" style="width: 154px; height: 154px; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                    {{-- <g class="unlocked">
                        <circle cx="200" cy="200" r="58" fill="#FFB400"/>
                        <circle cx="200" cy="188" r="13" fill="#14183A"/>
                        <path d="M193 196 L207 196 L212 226 L188 226 Z" fill="#14183A"/>
                    </g> --}}
                    <path class="pointer" d="M200 4 L190 -14 L210 -14 Z" fill="#FFB400" transform="translate(0 20)"/>
                </svg>
            </div>
        </section>
    </div>

    <section id="modules" class="vaultbox">
        <div class="wrap">
            <div>
                <h2>What's inside the vault</h2>
                <p class="sub">Every module works alone and shares its data with the rest.</p>
            </div>

            <div class="rows">
                @php
                    $modules = [
                        ['Sales', 'Create quotes and invoices, and see what each customer owes.'],
                        ['Purchase', 'Order from suppliers and match every bill to a delivery.'],
                        ['Inventory', 'Watch stock move across every warehouse.'],
                        ['Accounts', 'Ledgers, payments and balances that always add up.'],
                        ['HR and payroll', 'Keep employee records, attendance and salaries together.'],
                        ['Reports', 'Export a clear summary for any date range.'],
                    ];
                @endphp
                @foreach ($modules as [$name, $text])
                    <div class="row">
                        <b>{{ $name }}</b>
                        <span>{{ $text }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <div class="wrap">
        <section class="close">
            <h2>Your team is waiting. Log in and pick up where you left off.</h2>
            @auth
                <a href="{{ url('/dashboard') }}" class="btn btn-dark">Open dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-dark">Log in</a>
            @endauth
        </section>
        <footer>&copy; {{ date('Y') }} Safe ERP. All rights reserved.</footer>
    </div>

</body>
</html>