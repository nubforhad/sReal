<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @yield('title', 'Dashboard') - Real Estate ERP
    </title>

    {{-- Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Bootstrap Icons --}}
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    @stack('styles')
</head>

<body class="bg-slate-50 text-slate-800">

    <div
        x-data="{ sidebarOpen: false }"
        class="min-h-screen"
    >

        {{-- Mobile Overlay --}}
        <div
            x-show="sidebarOpen"
            x-cloak
            @click="sidebarOpen = false"
            class="fixed inset-0 z-40 bg-black/50 lg:hidden"
        ></div>

        {{-- Sidebar --}}
        @include('admin.layouts.sidebar')

        {{-- Main Area --}}
        <div class="lg:ml-64 min-h-screen">

            {{-- Navbar --}}
            @include('admin.layouts.navbar')

            {{-- Page Content --}}
            <main class="p-4 sm:p-6">

                {{-- Success Message --}}
                @if(session('success'))
                    <div
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        class="mb-5 flex items-center justify-between rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700"
                    >
                        <div class="flex items-center gap-2">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>{{ session('success') }}</span>
                        </div>

                        <button
                            type="button"
                            @click="show = false"
                            class="text-green-600 hover:text-green-800"
                        >
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                @endif

                {{-- Error Message --}}
                @if(session('error'))
                    <div
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        class="mb-5 flex items-center justify-between rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700"
                    >
                        <div class="flex items-center gap-2">
                            <i class="bi bi-exclamation-circle-fill"></i>
                            <span>{{ session('error') }}</span>
                        </div>

                        <button
                            type="button"
                            @click="show = false"
                            class="text-red-600 hover:text-red-800"
                        >
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                @endif

                {{-- Validation Errors --}}
                @if($errors->any())
                    <div
                        class="mb-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700"
                    >
                        <div class="mb-2 flex items-center gap-2 font-semibold">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                            Please fix the following errors:
                        </div>

                        <ul class="list-inside list-disc space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Content --}}
                @yield('content')

            </main>

        </div>

    </div>

    @stack('scripts')

</body>

</html> 
