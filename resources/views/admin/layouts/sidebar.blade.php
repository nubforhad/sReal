
<aside
    class="fixed inset-y-0 left-0 z-50 flex w-[260px] flex-col
           border-r border-slate-200 bg-white
           shadow-[4px_0_24px_rgba(15,23,42,0.06)]
           transform transition-transform duration-300 ease-in-out
           -translate-x-full lg:translate-x-0"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
>


    {{-- =========================================
         SIDEBAR HEADER
    ========================================= --}}

    <div
        class="flex h-16 shrink-0 items-center
               border-b border-slate-200 bg-white px-4"
    >

        <a
            href="{{ route('dashboard') }}"
            @click="sidebarOpen = false"
            class="flex min-w-0 items-center gap-3"
        >

            {{-- Logo --}}
            <div
                class="flex h-10 w-10 shrink-0 items-center justify-center
                       rounded-xl bg-blue-600 text-white
                       shadow-sm shadow-blue-200"
            >
                <i class="bi bi-buildings-fill text-lg"></i>
            </div>


            {{-- Logo Text --}}
            <div class="min-w-0">

                <h1
                    class="truncate text-sm font-bold tracking-tight text-slate-800"
                >
                    Real Estate ERP
                </h1>

                <p
                    class="truncate text-[11px] font-medium text-slate-400"
                >
                    Management System
                </p>

            </div>

        </a>


        {{-- Mobile Close Button --}}
        <button
            type="button"
            @click="sidebarOpen = false"
            class="ml-auto flex h-9 w-9 shrink-0 items-center justify-center
                   rounded-lg text-slate-500
                   transition duration-200
                   hover:bg-red-50 hover:text-red-600
                   lg:hidden"
            aria-label="Close sidebar"
        >
            <i class="bi bi-x-lg text-lg"></i>
        </button>

    </div>



    {{-- =========================================
         SIDEBAR MENU SCROLL AREA
    ========================================= --}}

    <div
        class="sidebar-scroll min-h-0 flex-1 overflow-y-auto overflow-x-hidden px-3 py-4"
    >

        {{-- Main Menu Label --}}
        <div class="mb-2 px-3">

            <p
                class="text-[10px] font-bold uppercase tracking-[0.08em] text-slate-400"
            >
                Main Menu
            </p>

        </div>


        <nav class="space-y-1">


            {{-- =====================================
                 DASHBOARD
            ====================================== --}}

            <a
                href="{{ route('dashboard') }}"
                @click="sidebarOpen = false"
                class="group flex items-center gap-3 rounded-xl px-3 py-2.5
                       text-sm font-medium transition-all duration-200
                       {{ request()->routeIs('dashboard')
                            ? 'bg-blue-50 text-blue-700'
                            : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}"
            >

                <span
                    class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg
                    {{ request()->routeIs('dashboard')
                        ? 'bg-blue-100 text-blue-600'
                        : 'bg-slate-100 text-slate-500 group-hover:bg-white group-hover:text-slate-700' }}"
                >
                    <i class="bi bi-grid-1x2-fill"></i>
                </span>

                <span>
                    Dashboard
                </span>

            </a>



            {{-- ==========  COMPANY MANAGEMENT ===== --}}

            <div
                x-data="{
                    open: {{ request()->routeIs('admin.companies.*', 'admin.branches.*', 'admin.projects.*') ? 'true' : 'false' }}
                }"
            >

                <button
                    type="button"
                    @click="open = !open"
                    class="group flex w-full items-center justify-between
                           rounded-xl px-3 py-2.5
                           text-sm font-medium text-slate-600
                           transition hover:bg-slate-50 hover:text-slate-900"
                >

                    <span class="flex min-w-0 items-center gap-3">

                        <span
                            class="flex h-8 w-8 shrink-0 items-center justify-center
                                   rounded-lg bg-slate-100 text-slate-500
                                   transition group-hover:bg-white"
                        >
                            <i class="bi bi-buildings"></i>
                        </span>

                        <span class="truncate">
                            Company Management
                        </span>

                    </span>


                    <i
                        class="bi bi-chevron-down ml-2 shrink-0 text-[10px]
                               text-slate-400 transition-transform duration-200"
                        :class="{ 'rotate-180': open }"
                    ></i>

                </button>


                <div
                    x-show="open"
                    x-cloak
                    class="mt-1 space-y-1 pl-11"
                >

                    <a
                        href="{{ route('admin.companies.index') }}"
                        @click="sidebarOpen = false"
                        class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm
                            transition
                            {{ request()->routeIs('admin.companies.*')
                                ? 'bg-blue-50 font-medium text-blue-700'
                                : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' }}"
                    >
                        <i class="bi bi-building"></i>
                        <span>Companies</span>
                    </a>


                    <a
                        href="{{ route('admin.branches.index') }}"
                        @click="sidebarOpen = false"
                        class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm
                            transition
                            {{ request()->routeIs('admin.branches.*')
                                ? 'bg-blue-50 font-medium text-blue-700'
                                : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' }}"
                    >
                        <i class="bi bi-diagram-3"></i>
                        <span>Branches</span>
                    </a>


                    <a
                        href="{{ route('admin.projects.index') }}"
                        @click="sidebarOpen = false"
                        class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm
                            transition
                            {{ request()->routeIs('admin.projects.*')
                                ? 'bg-blue-50 font-medium text-blue-700'
                                : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' }}"
                    >
                        <i class="bi bi-houses"></i>
                        <span>Projects</span>
                    </a>

                </div>

            </div>



            {{-- =====================================
                 USER MANAGEMENT
            ====================================== --}}

            <div
                x-data="{
                    open: {{ request()->routeIs('admin.users.*') ? 'true' : 'false' }}
                }"
            >

                <button
                    type="button"
                    @click="open = !open"
                    class="group flex w-full items-center justify-between
                           rounded-xl px-3 py-2.5
                           text-sm font-medium text-slate-600
                           transition hover:bg-slate-50 hover:text-slate-900"
                >

                    <span class="flex min-w-0 items-center gap-3">

                        <span
                            class="flex h-8 w-8 shrink-0 items-center justify-center
                                   rounded-lg bg-slate-100 text-slate-500"
                        >
                            <i class="bi bi-people"></i>
                        </span>

                        <span>
                            User Management
                        </span>

                    </span>


                    <i
                        class="bi bi-chevron-down ml-2 text-[10px] text-slate-400
                               transition-transform duration-200"
                        :class="{ 'rotate-180': open }"
                    ></i>

                </button>


                <div x-show="open"  x-cloak  class="mt-1 space-y-1 pl-11" >
                    <a href="{{ route('admin.users.index') }}"  @click="sidebarOpen = false"  class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm
                            transition {{ request()->routeIs('admin.users.*')   ? 'bg-blue-50 font-medium text-blue-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' }}">
                        <i class="bi bi-person-lines-fill"></i>
                        <span>Users</span>
                    </a>
                </div>
            </div>
            {{-- ===============  BUSINESS SECTION ======= --}}
            <div class="px-3 pb-1 pt-5">
                <p class="text-[10px] font-bold uppercase tracking-[0.08em] text-slate-400" >
                    Business
                </p>
            </div>
            {{-- ======= CLIENT MANAGEMENT====== --}}
            <div x-data="{ open: false }">
                <button type="button"
                    @click="open = !open"
                    class="group flex w-full items-center justify-between
                           rounded-xl px-3 py-2.5
                           text-sm font-medium text-slate-600
                           transition hover:bg-slate-50 hover:text-slate-900"
                >

                    <!-- <span class="flex items-center gap-3">

                        <span
                            class="flex h-8 w-8 shrink-0 items-center justify-center
                                   rounded-lg bg-slate-100 text-slate-500"
                        >
                            <i class="bi bi-person-vcard"></i>
                        </span>

                        <span>
                            Client Management
                        </span>
                    </span> -->
                    <a
                        href="{{ route('admin.clients.index') }}"
                        @click="sidebarOpen = false"
                        class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm
                            transition
                            {{ request()->routeIs('admin.clients.*')
                                ? 'bg-blue-50 font-medium text-blue-700'
                                : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' }}"
                    >
                        <i class="bi bi-person-vcard"></i>
                        <span>clients</span>
                    </a>


                    <i
                        class="bi bi-chevron-down text-[10px] text-slate-400
                               transition-transform"
                        :class="{ 'rotate-180': open }"
                    ></i>

                </button>


                <div
                    x-show="open"
                    x-cloak
                    class="mt-1 space-y-1 pl-11"
                >

                    <span
                        class="block rounded-lg px-3 py-2 text-sm text-slate-400"
                    >
                        Clients
                    </span>

                </div>

            </div>



            {{-- =====================================
                 LAND MANAGEMENT
            ====================================== --}}

            <div x-data="{ open: false }">

                <button
                    type="button"
                    @click="open = !open"
                    class="group flex w-full items-center justify-between
                           rounded-xl px-3 py-2.5
                           text-sm font-medium text-slate-600
                           transition hover:bg-slate-50 hover:text-slate-900"
                >

                    <span class="flex items-center gap-3">

                        <span
                            class="flex h-8 w-8 shrink-0 items-center justify-center
                                   rounded-lg bg-slate-100 text-slate-500"
                        >
                            <i class="bi bi-map"></i>
                        </span>

                        <span>
                            Land Management
                        </span>

                    </span>


                    <i
                        class="bi bi-chevron-down text-[10px] text-slate-400
                               transition-transform"
                        :class="{ 'rotate-180': open }"
                    ></i>

                </button>


                <div
                    x-show="open"
                    x-cloak
                    class="mt-1 space-y-1 pl-11"
                >

                    <span class="block rounded-lg px-3 py-2 text-sm text-slate-400">
                        Land
                    </span>

                    <span class="block rounded-lg px-3 py-2 text-sm text-slate-400">
                        Land Share Sale
                    </span>

                    <span class="block rounded-lg px-3 py-2 text-sm text-slate-400">
                        Land Share Payment
                    </span>

                    <span class="block rounded-lg px-3 py-2 text-sm text-slate-400">
                        Land Registration
                    </span>

                </div>

            </div>



            {{-- =====================================
                 CONSTRUCTION
            ====================================== --}}

            <div x-data="{ open: false }">

                <button
                    type="button"
                    @click="open = !open"
                    class="group flex w-full items-center justify-between
                           rounded-xl px-3 py-2.5
                           text-sm font-medium text-slate-600
                           transition hover:bg-slate-50 hover:text-slate-900"
                >

                    <span class="flex items-center gap-3">

                        <span
                            class="flex h-8 w-8 shrink-0 items-center justify-center
                                   rounded-lg bg-slate-100 text-slate-500"
                        >
                            <i class="bi bi-cone-striped"></i>
                        </span>

                        <span>
                            Construction
                        </span>

                    </span>


                    <i
                        class="bi bi-chevron-down text-[10px] text-slate-400
                               transition-transform"
                        :class="{ 'rotate-180': open }"
                    ></i>

                </button>


                <div
                    x-show="open"
                    x-cloak
                    class="mt-1 space-y-1 pl-11"
                >

                    <span class="block rounded-lg px-3 py-2 text-sm text-slate-400">
                        Buildings
                    </span>

                    <span class="block rounded-lg px-3 py-2 text-sm text-slate-400">
                        Floors
                    </span>

                    <span class="block rounded-lg px-3 py-2 text-sm text-slate-400">
                        Flats
                    </span>

                    <span class="block rounded-lg px-3 py-2 text-sm text-slate-400">
                        Construction Cost
                    </span>

                </div>

            </div>



            {{-- =====================================
                 SALES
            ====================================== --}}

            <div x-data="{ open: false }">

                <button
                    type="button"
                    @click="open = !open"
                    class="group flex w-full items-center justify-between
                           rounded-xl px-3 py-2.5
                           text-sm font-medium text-slate-600
                           transition hover:bg-slate-50 hover:text-slate-900"
                >

                    <span class="flex items-center gap-3">

                        <span
                            class="flex h-8 w-8 shrink-0 items-center justify-center
                                   rounded-lg bg-slate-100 text-slate-500"
                        >
                            <i class="bi bi-cart-check"></i>
                        </span>

                        <span>
                            Sales & Allocation
                        </span>

                    </span>


                    <i
                        class="bi bi-chevron-down text-[10px] text-slate-400
                               transition-transform"
                        :class="{ 'rotate-180': open }"
                    ></i>

                </button>


                <div
                    x-show="open"
                    x-cloak
                    class="mt-1 space-y-1 pl-11"
                >

                    <span class="block rounded-lg px-3 py-2 text-sm text-slate-400">
                        Installments
                    </span>

                    <span class="block rounded-lg px-3 py-2 text-sm text-slate-400">
                        Payment Points
                    </span>

                    <span class="block rounded-lg px-3 py-2 text-sm text-slate-400">
                        Flat Choice
                    </span>

                    <span class="block rounded-lg px-3 py-2 text-sm text-slate-400">
                        Flat Allocation
                    </span>

                    <span class="block rounded-lg px-3 py-2 text-sm text-slate-400">
                        Agreements
                    </span>

                    <span class="block rounded-lg px-3 py-2 text-sm text-slate-400">
                        Handover
                    </span>

                </div>

            </div>



            {{-- =====================================
                 FINANCE
            ====================================== --}}

            <div x-data="{ open: false }">

                <button
                    type="button"
                    @click="open = !open"
                    class="group flex w-full items-center justify-between
                           rounded-xl px-3 py-2.5
                           text-sm font-medium text-slate-600
                           transition hover:bg-slate-50 hover:text-slate-900"
                >

                    <span class="flex items-center gap-3">

                        <span
                            class="flex h-8 w-8 shrink-0 items-center justify-center
                                   rounded-lg bg-slate-100 text-slate-500"
                        >
                            <i class="bi bi-cash-stack"></i>
                        </span>

                        <span>
                            Finance
                        </span>

                    </span>


                    <i
                        class="bi bi-chevron-down text-[10px] text-slate-400
                               transition-transform"
                        :class="{ 'rotate-180': open }"
                    ></i>

                </button>


                <div
                    x-show="open"
                    x-cloak
                    class="mt-1 space-y-1 pl-11"
                >

                    <span class="block rounded-lg px-3 py-2 text-sm text-slate-400">
                        Payments
                    </span>

                    <span class="block rounded-lg px-3 py-2 text-sm text-slate-400">
                        Income
                    </span>

                    <span class="block rounded-lg px-3 py-2 text-sm text-slate-400">
                        Expenses
                    </span>

                    <span class="block rounded-lg px-3 py-2 text-sm text-slate-400">
                        Finance Reports
                    </span>

                </div>

            </div>



            {{-- =====================================
                 HR
            ====================================== --}}

            <div x-data="{ open: false }">

                <button
                    type="button"
                    @click="open = !open"
                    class="group flex w-full items-center justify-between
                           rounded-xl px-3 py-2.5
                           text-sm font-medium text-slate-600
                           transition hover:bg-slate-50 hover:text-slate-900"
                >

                    <span class="flex items-center gap-3">

                        <span
                            class="flex h-8 w-8 shrink-0 items-center justify-center
                                   rounded-lg bg-slate-100 text-slate-500"
                        >
                            <i class="bi bi-person-badge"></i>
                        </span>

                        <span>
                            HR & Payroll
                        </span>

                    </span>


                    <i
                        class="bi bi-chevron-down text-[10px] text-slate-400
                               transition-transform"
                        :class="{ 'rotate-180': open }"
                    ></i>

                </button>


                <div
                    x-show="open"
                    x-cloak
                    class="mt-1 space-y-1 pl-11"
                >

                    <span class="block rounded-lg px-3 py-2 text-sm text-slate-400">
                        Employees
                    </span>

                    <span class="block rounded-lg px-3 py-2 text-sm text-slate-400">
                        Payroll
                    </span>

                </div>

            </div>



            {{-- =====================================
                 REPORTS
            ====================================== --}}

            <a
                href="#"
                @click="sidebarOpen = false"
                class="group flex items-center gap-3 rounded-xl px-3 py-2.5
                       text-sm font-medium text-slate-600
                       transition hover:bg-slate-50 hover:text-slate-900"
            >

                <span
                    class="flex h-8 w-8 shrink-0 items-center justify-center
                           rounded-lg bg-slate-100 text-slate-500"
                >
                    <i class="bi bi-bar-chart-line"></i>
                </span>

                <span>
                    Reports
                </span>

            </a>



            {{-- Divider --}}
            <div class="my-4 border-t border-slate-100"></div>



            {{-- =====================================
                 SETTINGS
            ====================================== --}}

            <a
                href="#"
                @click="sidebarOpen = false"
                class="group flex items-center gap-3 rounded-xl px-3 py-2.5
                       text-sm font-medium text-slate-600
                       transition hover:bg-slate-50 hover:text-slate-900"
            >

                <span
                    class="flex h-8 w-8 shrink-0 items-center justify-center
                           rounded-lg bg-slate-100 text-slate-500"
                >
                    <i class="bi bi-gear"></i>
                </span>

                <span>
                    Settings
                </span>

            </a>


            {{-- Extra Bottom Space --}}
            <div class="h-4"></div>

        </nav>

    </div>



    {{-- =========================================
         SIDEBAR FOOTER
    ========================================= --}}

    <div class="shrink-0 border-t border-slate-200 bg-white p-3">

        <div class="rounded-xl bg-slate-50 px-3 py-2.5">

            <div class="flex items-center gap-2.5">

                <div
                    class="flex h-9 w-9 shrink-0 items-center justify-center
                           rounded-lg bg-blue-100 text-blue-600"
                >
                    <i class="bi bi-shield-check"></i>
                </div>


                <div class="min-w-0">

                    <p class="truncate text-xs font-semibold text-slate-700">
                        {{ auth()->user()->getRoleNames()->first() ?? 'User' }}
                    </p>

                    <p class="text-[10px] text-slate-400">
                        Access Level
                    </p>

                </div>

            </div>

        </div>

    </div>

</aside>