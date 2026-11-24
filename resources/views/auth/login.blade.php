<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> Log in</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/fav1.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,500;12..96,700&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --ink: #0E3B43;
            --ink-deep: #082A30;
            --coral: #FF6B4A;
            --mist: #F5F7F6;
            --line: #D9E0DE;
        }
        body { font-family: 'DM Sans', ui-sans-serif, system-ui, sans-serif; background: var(--mist); }
        .font-display { font-family: 'Bricolage Grotesque', 'DM Sans', sans-serif; }

        /* The one memorable moment: rings draw themselves in on load */
        .ring { fill: none; stroke: rgba(255,255,255,.16); stroke-width: 1.5; stroke-dasharray: 1600; stroke-dashoffset: 1600; animation: draw 2.4s ease-out forwards; }
        .ring:nth-child(2) { animation-delay: .15s; }
        .ring:nth-child(3) { animation-delay: .3s; }
        .ring:nth-child(4) { animation-delay: .45s; }
        .ring:nth-child(5) { animation-delay: .6s; stroke: var(--coral); stroke-width: 2.5; }
        @keyframes draw { to { stroke-dashoffset: 0; } }
        @media (prefers-reduced-motion: reduce) {
            .ring { animation: none; stroke-dashoffset: 0; }
        }

        .field {
            width: 100%;
            border: 1.5px solid var(--line);
            background: #fff;
            border-radius: .875rem;
            padding: .85rem 1rem;
            color: #10201f;
            transition: border-color .15s, box-shadow .15s;
        }
        .field::placeholder { color: #9aa8a5; }
        .field:hover { border-color: #b7c4c1; }
        .field:focus { outline: none; border-color: var(--ink); box-shadow: 0 0 0 4px rgba(14,59,67,.12); }
        .field.has-error { border-color: #d64545; }

        .btn-main {
            width: 100%;
            background: var(--ink);
            color: #fff;
            font-weight: 600;
            border-radius: .875rem;
            padding: .9rem 1rem;
            transition: background .15s, transform .1s;
        }
        .btn-main:hover { background: var(--ink-deep); }
        .btn-main:active { transform: scale(.985); }
        .btn-main:focus-visible { outline: 3px solid var(--coral); outline-offset: 3px; }

        .check {
            appearance: none;
            width: 1.15rem; height: 1.15rem;
            border: 1.5px solid #9fb0ad;
            border-radius: .35rem;
            background: #fff;
            display: grid; place-content: center;
            transition: background .15s, border-color .15s;
        }
        .check:checked { background: var(--ink); border-color: var(--ink); }
        .check:checked::after { content: ''; width: .3rem; height: .6rem; border: solid #fff; border-width: 0 2px 2px 0; transform: rotate(45deg) translate(-1px, -1px); }
        .check:focus-visible { outline: 3px solid var(--coral); outline-offset: 2px; }
    </style>
</head>
<body class="antialiased text-slate-800">
<div class="min-h-screen grid lg:grid-cols-[1.05fr_1fr]">

    {{-- Left: brand panel --}}
    <aside class="relative hidden lg:flex flex-col justify-between overflow-hidden p-14 text-white" style="background: var(--ink);">
        <svg class="absolute -right-40 -bottom-40 w-[46rem] h-[46rem]" viewBox="0 0 600 600" aria-hidden="true">
            <circle class="ring" cx="300" cy="300" r="280"/>
            <circle class="ring" cx="300" cy="300" r="220"/>
            <circle class="ring" cx="300" cy="300" r="160"/>
            <circle class="ring" cx="300" cy="300" r="100"/>
            <circle class="ring" cx="300" cy="300" r="40"/>
        </svg>

        <a href="/" class="relative flex items-center gap-3">
            <span class="grid h-10 w-10 place-content-center rounded-xl font-display text-lg font-bold" style="background: var(--coral); color: var(--ink-deep);">
                {{ strtoupper(substr(config('app.name', 'L'), 0, 1)) }}
            </span>
            <span class="font-display text-xl font-medium">{{ config('app.name', 'Laravel') }}</span>
        </a>

        <div class="relative max-w-md">
            <h1 class="font-display text-5xl font-bold leading-[1.05] tracking-tight">
                Good to see you again.
            </h1>
            <p class="mt-5 text-lg leading-relaxed text-white/70">
                Log in to pick up right where you left off.
            </p>
        </div>

        <p class="relative text-sm text-white/50">&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}</p>
    </aside>

    {{-- Right: form --}}
    <main class="flex items-center justify-center px-6 py-12 sm:px-10">
        <div class="w-full max-w-md">

            {{-- Mobile brand --}}
            <a href="/" class="mb-10 flex items-center gap-3 lg:hidden">
                <span class="grid h-10 w-10 place-content-center rounded-xl font-display text-lg font-bold text-white" style="background: var(--ink);">
                    {{ strtoupper(substr(config('app.name', 'L'), 0, 1)) }}
                </span>
                <span class="font-display text-xl font-medium">{{ config('app.name', 'Laravel') }}</span>
            </a>
            <img src="{{ asset('assets/images/fav1.png') }}" alt="Safe ERP Logo" class="mx-auto mb-6 w-16 h-16">

            <h2 class="font-display text-3xl font-bold tracking-tight" style="color: var(--ink-deep);">Log in to your account</h2>
            <p class="mt-2 text-slate-500">Enter your email and password to continue.</p>

            <x-auth-session-status class="mt-6" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-5" x-data="{ show: false }">
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email" class="mb-1.5 block text-sm font-medium text-slate-700">{{ __('Email') }}</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                           class="field @error('email') has-error @enderror"
                           placeholder="you@example.com"
                           required autofocus autocomplete="username">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                {{-- Password --}}
                <div>
                    <div class="mb-1.5 flex items-center justify-between">
                        <label for="password" class="block text-sm font-medium text-slate-700">{{ __('Password') }}</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                               class="rounded text-sm font-medium hover:underline focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
                               style="color: var(--ink);">
                                {{ __('Forgot password?') }}
                            </a>
                        @endif
                    </div>

                    <div class="relative">
                        <input id="password" name="password" :type="show ? 'text' : 'password'"
                               class="field pr-20 @error('password') has-error @enderror"
                               placeholder="Your password"
                               required autocomplete="current-password">
                        <button type="button" @click="show = !show"
                                class="absolute inset-y-0 right-3 my-auto h-8 rounded-lg px-2 text-sm font-medium text-slate-500 hover:text-slate-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-1"
                                :aria-pressed="show.toString()" aria-controls="password">
                            <span x-text="show ? 'Hide' : 'Show'">Show</span>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                {{-- Remember me --}}
                <label for="remember_me" class="flex cursor-pointer items-center gap-2.5">
                    <input id="remember_me" type="checkbox" name="remember" class="check">
                    <span class="text-sm text-slate-600">{{ __('Keep me logged in on this device') }}</span>
                </label>

                <button type="submit" class="btn-main">{{ __('Log in') }}</button>
            </form>

            @if (Route::has('register'))
                <p class="mt-8 text-center text-sm text-slate-500">
                    {{ __("Don't have an account?") }}
                    <a href="{{ route('register') }}" class="font-semibold hover:underline" style="color: var(--ink);">{{ __('Create one') }}</a>
                </p>
            @endif
        </div>
    </main>
</div>
</body>
</html>