<aside
    class="fixed inset-y-0 left-0 z-50 w-64
           transform border-r border-slate-200 bg-white
           transition-transform duration-300
           lg:translate-x-0"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
>

    {{-- Logo --}}
    <div class="flex h-16 items-center border-b border-slate-200 px-5">

        <a
            href="{{ route('dashboard') }}"
            class="flex items-center gap-3"
        >

            <div
                class="flex h-9 w-9 items-center justify-center
                       rounded-lg bg-blue-600 text-white"
            >
                <i class="bi bi-buildings-fill"></i>
            </div>

            <div>
                <h1 class="text-sm font-bold text-slate-800">
                    Real Estate ERP
                </h1>

                <p class="text-xs text-slate-500">
                    Management System
                </p>
            </div>

        </a>

        {{-- Mobile Close --}}
        <button
            type="button"
            @click="sidebarOpen = false"
            class="ml-auto text-slate-500 hover:text-slate-700 lg:hidden"
        >
            <i class="bi bi-x-lg text-lg"></i>
        </button>

    </div>


    {{-- Navigation --}}
    <div class="h-[calc(100vh-4rem)] overflow-y-auto p-3">

        <nav class="space-y-1">

            {{-- Dashboard --}}
            <a
                href="{{ route('dashboard') }}"
                class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium
                    {{ request()->routeIs('dashboard')
                        ? 'bg-blue-50 text-blue-700'
                        : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}"
            >
                <i class="bi bi-speedometer2 text-lg"></i>

                <span>Dashboard</span>
            </a>


            {{-- ================= COMPANY MANAGEMENT ================= --}}

            <div
                x-data="{
                    open: {{ request()->routeIs('admin.companies.*', 'admin.branches.*', 'admin.projects.*') ? 'true' : 'false' }}
                }"
            >

                <button
                    type="button"
                    @click="open = !open"
                    class="flex w-full items-center justify-between rounded-lg
                           px-3 py-2.5 text-sm font-medium text-slate-600
                           hover:bg-slate-50 hover:text-slate-900"
                >

                    <span class="flex items-center gap-3">
                        <i class="bi bi-buildings text-lg"></i>
                        <span>Company Management</span>
                    </span>

                    <i
                        class="bi bi-chevron-down text-xs transition-transform"
                        :class="{ 'rotate-180': open }"
                    ></i>

                </button>


                <div
                    x-show="open"
                    x-collapse
                    x-cloak
                    class="mt-1 space-y-1 pl-9"
                >

                    {{-- Companies --}}
                    <a
                        href="{{ route('admin.companies.index') }}"
                        class="block rounded-lg px-3 py-2 text-sm
                            {{ request()->routeIs('admin.companies.*')
                                ? 'bg-blue-50 text-blue-700'
                                : 'text-slate-600 hover:bg-slate-50' }}"
                    >
                        <i class="bi bi-building mr-2"></i>
                        Companies
                    </a>


                    {{-- Branches --}}
                    <a
                        href="{{ route('admin.branches.index') }}"
                        class="block rounded-lg px-3 py-2 text-sm
                            {{ request()->routeIs('admin.branches.*')
                                ? 'bg-blue-50 text-blue-700'
                                : 'text-slate-600 hover:bg-slate-50' }}"
                    >
                        <i class="bi bi-diagram-3 mr-2"></i>
                        Branches
                    </a>


                    {{-- Projects --}}
                    <a
                        href="{{ route('admin.projects.index') }}"
                        class="block rounded-lg px-3 py-2 text-sm
                            {{ request()->routeIs('admin.projects.*')
                                ? 'bg-blue-50 text-blue-700'
                                : 'text-slate-600 hover:bg-slate-50' }}"
                    >
                        <i class="bi bi-houses mr-2"></i>
                        Projects
                    </a>

                </div>

            </div>


            {{-- ================= USER MANAGEMENT ================= --}}

            <div
                x-data="{
                    open: {{ request()->routeIs('admin.users.*') ? 'true' : 'false' }}
                }"
            >

                <button
                    type="button"
                    @click="open = !open"
                    class="flex w-full items-center justify-between rounded-lg
                           px-3 py-2.5 text-sm font-medium text-slate-600
                           hover:bg-slate-50 hover:text-slate-900"
                >

                    <span class="flex items-center gap-3">
                        <i class="bi bi-people text-lg"></i>
                        <span>User Management</span>
                    </span>

                    <i
                        class="bi bi-chevron-down text-xs transition-transform"
                        :class="{ 'rotate-180': open }"
                    ></i>

                </button>


                <div
                    x-show="open"
                    x-collapse
                    x-cloak
                    class="mt-1 space-y-1 pl-9"
                >

                    <a
                        href="{{ route('admin.users.index') }}"
                        class="block rounded-lg px-3 py-2 text-sm
                            {{ request()->routeIs('admin.users.*')
                                ? 'bg-blue-50 text-blue-700'
                                : 'text-slate-600 hover:bg-slate-50' }}"
                    >
                        <i class="bi bi-person-lines-fill mr-2"></i>
                        Users
                    </a>

                </div>

            </div>


            {{-- ================= CLIENT ================= --}}

            <div
                x-data="{ open: false }"
            >

                <button
                    type="button"
                    @click="open = !open"
                    class="flex w-full items-center justify-between rounded-lg
                           px-3 py-2.5 text-sm font-medium text-slate-600
                           hover:bg-slate-50 hover:text-slate-900"
                >

                    <span class="flex items-center gap-3">
                        <i class="bi bi-person-vcard text-lg"></i>
                        <span>Client Management</span>
                    </span>

                    <i
                        class="bi bi-chevron-down text-xs transition-transform"
                        :class="{ 'rotate-180': open }"
                    ></i>

                </button>

                <div
                    x-show="open"
                    x-collapse
                    x-cloak
                    class="mt-1 space-y-1 pl-9"
                >

                    <span class="block rounded-lg px-3 py-2 text-sm text-slate-400">
                        Clients
                    </span>

                </div>

            </div>


            {{-- ================= LAND ================= --}}

            <div
                x-data="{ open: false }"
            >

                <button
                    type="button"
                    @click="open = !open"
                    class="flex w-full items-center justify-between rounded-lg
                           px-3 py-2.5 text-sm font-medium text-slate-600
                           hover:bg-slate-50 hover:text-slate-900"
                >

                    <span class="flex items-center gap-3">
                        <i class="bi bi-map text-lg"></i>
                        <span>Land Management</span>
                    </span>

                    <i
                        class="bi bi-chevron-down text-xs transition-transform"
                        :class="{ 'rotate-180': open }"
                    ></i>

                </button>

                <div
                    x-show="open"
                    x-collapse
                    x-cloak
                    class="mt-1 space-y-1 pl-9"
                >

                    <span class="block rounded-lg px-3 py-2 text-sm text-slate-400">
                        Land
                    </span>

                    <span class="block rounded-lg px-3 py-2 text-sm text-slate-400">
                        Land Share Sale
                    </span>

                    <span class="block rounded-lg px-3 py-2 text-sm text-slate-400">
                        Land Registration
                    </span>

                </div>

            </div>


            {{-- ================= CONSTRUCTION ================= --}}

            <div
                x-data="{ open: false }"
            >

                <button
                    type="button"
                    @click="open = !open"
                    class="flex w-full items-center justify-between rounded-lg
                           px-3 py-2.5 text-sm font-medium text-slate-600
                           hover:bg-slate-50 hover:text-slate-900"
                >

                    <span class="flex items-center gap-3">
                        <i class="bi bi-cone-striped text-lg"></i>
                        <span>Construction</span>
                    </span>

                    <i
                        class="bi bi-chevron-down text-xs transition-transform"
                        :class="{ 'rotate-180': open }"
                    ></i>

                </button>

                <div
                    x-show="open"
                    x-collapse
                    x-cloak
                    class="mt-1 space-y-1 pl-9"
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


            {{-- ================= SALES ================= --}}

            <div
                x-data="{ open: false }"
            >

                <button
                    type="button"
                    @click="open = !open"
                    class="flex w-full items-center justify-between rounded-lg
                           px-3 py-2.5 text-sm font-medium text-slate-600
                           hover:bg-slate-50 hover:text-slate-900"
                >

                    <span class="flex items-center gap-3">
                        <i class="bi bi-cart-check text-lg"></i>
                        <span>Sales & Allocation</span>
                    </span>

                    <i
                        class="bi bi-chevron-down text-xs transition-transform"
                        :class="{ 'rotate-180': open }"
                    ></i>

                </button>

                <div
                    x-show="open"
                    x-collapse
                    x-cloak
                    class="mt-1 space-y-1 pl-9"
                >

                    <span class="block rounded-lg px-3 py-2 text-sm text-slate-400">
                        Installments
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


            {{-- ================= FINANCE ================= --}}

            <div
                x-data="{ open: false }"
            >

                <button
                    type="button"
                    @click="open = !open"
                    class="flex w-full items-center justify-between rounded-lg
                           px-3 py-2.5 text-sm font-medium text-slate-600
                           hover:bg-slate-50 hover:text-slate-900"
                >

                    <span class="flex items-center gap-3">
                        <i class="bi bi-cash-stack text-lg"></i>
                        <span>Finance</span>
                    </span>

                    <i
                        class="bi bi-chevron-down text-xs transition-transform"
                        :class="{ 'rotate-180': open }"
                    ></i>

                </button>

                <div
                    x-show="open"
                    x-collapse
                    x-cloak
                    class="mt-1 space-y-1 pl-9"
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


            {{-- ================= HR ================= --}}

            <div
                x-data="{ open: false }"
            >

                <button
                    type="button"
                    @click="open = !open"
                    class="flex w-full items-center justify-between rounded-lg
                           px-3 py-2.5 text-sm font-medium text-slate-600
                           hover:bg-slate-50 hover:text-slate-900"
                >

                    <span class="flex items-center gap-3">
                        <i class="bi bi-person-badge text-lg"></i>
                        <span>HR & Payroll</span>
                    </span>

                    <i
                        class="bi bi-chevron-down text-xs transition-transform"
                        :class="{ 'rotate-180': open }"
                    ></i>

                </button>

                <div
                    x-show="open"
                    x-collapse
                    x-cloak
                    class="mt-1 space-y-1 pl-9"
                >

                    <span class="block rounded-lg px-3 py-2 text-sm text-slate-400">
                        Employees
                    </span>

                    <span class="block rounded-lg px-3 py-2 text-sm text-slate-400">
                        Payroll
                    </span>

                </div>

            </div>


            {{-- ================= REPORTS ================= --}}

            <a
                href="#"
                class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium
                       text-slate-600 hover:bg-slate-50 hover:text-slate-900"
            >
                <i class="bi bi-bar-chart-line text-lg"></i>
                <span>Reports</span>
            </a>


            {{-- ================= SETTINGS ================= --}}

            <div class="my-3 border-t border-slate-200"></div>

            <a
                href="#"
                class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium
                       text-slate-600 hover:bg-slate-50 hover:text-slate-900"
            >
                <i class="bi bi-gear text-lg"></i>
                <span>Settings</span>
            </a>

        </nav>

    </div>

</aside> 
