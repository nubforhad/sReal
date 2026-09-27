<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @yield('title', 'Dashboard') - Real Estate ERP
    </title>


    {{-- Laravel Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])


    {{-- Bootstrap Icons --}}
    <link  rel="stylesheet"   href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


    @stack('styles')
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>


    <style>

  


/*
|--------------------------------------------------------------------------
| Base
|--------------------------------------------------------------------------
*/

html {
    scroll-behavior: smooth;
}

body {
    margin: 0;
    min-height: 100vh;
    overflow-x: hidden;

    background: #f8fafc;
    color: #1e293b;

    font-family:
        Inter,
        ui-sans-serif,
        system-ui,
        -apple-system,
        BlinkMacSystemFont,
        "Segoe UI",
        sans-serif;
}


/*
|--------------------------------------------------------------------------
| Alpine
|--------------------------------------------------------------------------
*/

[x-cloak] {
    display: none !important;
}


/*
|--------------------------------------------------------------------------
| Selection
|--------------------------------------------------------------------------
*/

::selection {
    background: #dbeafe;
    color: #1d4ed8;
}


/*
|--------------------------------------------------------------------------
| Global Scrollbar
|--------------------------------------------------------------------------
*/

* {
    scrollbar-width: thin;
    scrollbar-color: #cbd5e1 transparent;
}

::-webkit-scrollbar {
    width: 6px;
    height: 6px;
}

::-webkit-scrollbar-track {
    background: transparent;
}

::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 9999px;
}

::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}


/*
|--------------------------------------------------------------------------
| Sidebar
|--------------------------------------------------------------------------
*/

.sidebar-scroll {
    scrollbar-width: thin;
    scrollbar-color: #cbd5e1 transparent;
}

.sidebar-scroll::-webkit-scrollbar {
    width: 5px;
}

.sidebar-scroll::-webkit-scrollbar-track {
    background: transparent;
}

.sidebar-scroll::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 9999px;
}

.sidebar-scroll::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}


/*
|--------------------------------------------------------------------------
| Page Animation
|--------------------------------------------------------------------------
*/

.page-content {
    animation: pageFadeIn 0.2s ease-in-out;
}

@keyframes pageFadeIn {

    from {
        opacity: 0;
        transform: translateY(4px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }

}


/*
|--------------------------------------------------------------------------
| Tables
|--------------------------------------------------------------------------
*/

.table-responsive {
    width: 100%;
    overflow-x: auto;

    -webkit-overflow-scrolling: touch;
}

.table-responsive table {
    min-width: 700px;
}


/*
|--------------------------------------------------------------------------
| ERP Card
|--------------------------------------------------------------------------
*/

.erp-card {
    width: 100%;

    border: 1px solid #e2e8f0;
    border-radius: 12px;

    background: #ffffff;
}


/*
|--------------------------------------------------------------------------
| Form Elements
|--------------------------------------------------------------------------
*/

input,
select,
textarea {
    max-width: 100%;
}

input:focus,
select:focus,
textarea:focus {
    outline: none;
}


/*
|--------------------------------------------------------------------------
| Mobile
|--------------------------------------------------------------------------
*/

@media (max-width: 1023px) {

    body.sidebar-open {
        overflow: hidden;
    }

}


/*
|--------------------------------------------------------------------------
| Small Mobile
|--------------------------------------------------------------------------
*/

@media (max-width: 639px) {

    .page-content {
        padding-left: 0;
        padding-right: 0;
    }

} 



        /* =========================================
           Alpine
        ========================================= */

        [x-cloak] {
            display: none !important;
        }


        /* =========================================
           Global
        ========================================= */

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            overflow-x: hidden;
        }


        /* =========================================
           Scrollbar
        ========================================= */

        * {
            scrollbar-width: thin;
            scrollbar-color: #cbd5e1 transparent;
        }

        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 9999px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }


        /* =========================================
           Sidebar Scrollbar
        ========================================= */

        .sidebar-scroll::-webkit-scrollbar {
            width: 5px;
        }

        .sidebar-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 9999px;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }


        /* =========================================
           Page Animation
        ========================================= */

        .page-content {
            animation: pageFade .2s ease-in-out;
        }

        @keyframes pageFade {

            from {
                opacity: 0;
                transform: translateY(3px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }

        }


        /* =========================================
           Mobile
        ========================================= */

        @media (max-width: 1023px) {

            body.sidebar-open {
                overflow: hidden;
            }

        }


        /* =========================================
           Table Responsive
        ========================================= */

        .table-responsive {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

    </style>

</head>


<body class="min-h-screen bg-slate-50 text-slate-800 antialiased">


    {{-- =========================================
         MAIN ALPINE APP
    ========================================= --}}

    <div
        x-data="{
            sidebarOpen: false
        }"
        x-init="
            $watch('sidebarOpen', value => {
                document.body.classList.toggle('sidebar-open', value)
            })
        "
        @keydown.escape.window="sidebarOpen = false"
        class="min-h-screen"
    >


        {{-- =========================================
             MOBILE OVERLAY
        ========================================= --}}

        <div
            x-show="sidebarOpen"
            x-cloak
            x-transition:enter="transition-opacity ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="sidebarOpen = false"
            class="fixed inset-0 z-40 bg-slate-900/50 backdrop-blur-[2px] lg:hidden"
        ></div>


        {{-- =========================================
             SIDEBAR
        ========================================= --}}

        @include('admin.layouts.sidebar')


        {{-- =========================================
             MAIN AREA
        ========================================= --}}

        <div class="min-h-screen lg:ml-[260px]">


            {{-- Navbar --}}
            @include('admin.layouts.navbar')


            {{-- =====================================
                 CONTENT
            ====================================== --}}

            <main class="page-content min-h-[calc(100vh-64px)] p-3 sm:p-4 lg:p-6">

                <div class="mx-auto w-full max-w-[1600px]">


                    {{-- =================================
                         SUCCESS MESSAGE
                    ================================== --}}

                    @if(session('success'))

                        <div
                            x-data="{ show: true }"
                            x-show="show"
                            x-transition
                            class="mb-5 flex items-start justify-between gap-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 shadow-sm"
                        >

                            <div class="flex items-start gap-2">

                                <i class="bi bi-check-circle-fill mt-0.5"></i>

                                <span>
                                    {{ session('success') }}
                                </span>

                            </div>


                            <button
                                type="button"
                                @click="show = false"
                                class="shrink-0 text-emerald-600 transition hover:text-emerald-800"
                            >
                                <i class="bi bi-x-lg"></i>
                            </button>

                        </div>

                    @endif


                    {{-- =================================
                         ERROR MESSAGE
                    ================================== --}}

                    @if(session('error'))

                        <div
                            x-data="{ show: true }"
                            x-show="show"
                            x-transition
                            class="mb-5 flex items-start justify-between gap-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700 shadow-sm"
                        >

                            <div class="flex items-start gap-2">

                                <i class="bi bi-exclamation-circle-fill mt-0.5"></i>

                                <span>
                                    {{ session('error') }}
                                </span>

                            </div>


                            <button
                                type="button"
                                @click="show = false"
                                class="shrink-0 text-red-600 transition hover:text-red-800"
                            >
                                <i class="bi bi-x-lg"></i>
                            </button>

                        </div>

                    @endif


                    {{-- =================================
                         VALIDATION ERRORS
                    ================================== --}}

                    @if($errors->any())

                        <div
                            x-data="{ show: true }"
                            x-show="show"
                            class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700 shadow-sm"
                        >

                            <div class="flex items-start justify-between gap-3">

                                <div>

                                    <div class="mb-2 flex items-center gap-2 font-semibold">

                                        <i class="bi bi-exclamation-triangle-fill"></i>

                                        <span>
                                            Please fix the following errors.
                                        </span>

                                    </div>


                                    <ul class="list-inside list-disc space-y-1">

                                        @foreach($errors->all() as $error)

                                            <li>
                                                {{ $error }}
                                            </li>

                                        @endforeach

                                    </ul>

                                </div>


                                <button
                                    type="button"
                                    @click="show = false"
                                    class="shrink-0 text-red-600 hover:text-red-800"
                                >
                                    <i class="bi bi-x-lg"></i>
                                </button>

                            </div>

                        </div>

                    @endif


                    {{-- =================================
                         PAGE CONTENT
                    ================================== --}}

                    @yield('content')

                </div>

            </main>

        </div>

    </div>


    @stack('scripts')

</body>

</html> 
