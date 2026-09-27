<header
    class="sticky top-0 z-30 h-16 border-b border-slate-200
           bg-white/95 backdrop-blur"
>

    <div
        class="flex h-full items-center justify-between
               px-3 sm:px-5 lg:px-6"
    >


        {{-- =========================================
             LEFT SIDE
        ========================================= --}}

        <div class="flex min-w-0 items-center gap-2 sm:gap-3">


            {{-- Mobile Menu Button --}}
            <button
                type="button"
                @click="sidebarOpen = true"
                class="flex h-10 w-10 shrink-0 items-center justify-center
                       rounded-xl text-slate-600
                       transition duration-200
                       hover:bg-blue-50 hover:text-blue-600
                       lg:hidden"
                aria-label="Open sidebar"
            >
                <i class="bi bi-list text-2xl"></i>
            </button>


            {{-- Page Title --}}
            <div class="min-w-0">

                <h2
                    class="truncate text-base font-semibold text-slate-800 sm:text-lg"
                >
                    @yield('page-title', 'Dashboard')
                </h2>

                <p
                    class="hidden truncate text-xs text-slate-400 sm:block"
                >
                    Real Estate Management System
                </p>

            </div>

        </div>



        {{-- =========================================
             RIGHT SIDE
        ========================================= --}}

        <div class="flex shrink-0 items-center gap-1 sm:gap-2">


            {{-- Search --}}
            <button
                type="button"
                class="hidden h-10 w-10 items-center justify-center
                       rounded-xl text-slate-500
                       transition hover:bg-slate-100 hover:text-slate-700
                       md:flex"
                aria-label="Search"
            >
                <i class="bi bi-search text-lg"></i>
            </button>


            {{-- Notification --}}
            <button
                type="button"
                class="relative flex h-10 w-10 items-center justify-center
                       rounded-xl text-slate-500
                       transition hover:bg-slate-100 hover:text-slate-700"
                aria-label="Notifications"
            >

                <i class="bi bi-bell text-lg"></i>

                <span
                    class="absolute right-2 top-2 h-2 w-2 rounded-full
                           bg-red-500 ring-2 ring-white"
                ></span>

            </button>


            {{-- Divider --}}
            <div
                class="mx-1 hidden h-7 w-px bg-slate-200 sm:block"
            ></div>



            {{-- =====================================
                 USER DROPDOWN
            ====================================== --}}

            <div
                x-data="{ open: false }"
                class="relative"
            >

                {{-- User Button --}}
                <button
                    type="button"
                    @click="open = !open"
                    class="flex items-center gap-2 rounded-xl
                           px-1.5 py-1.5 sm:px-2
                           transition hover:bg-slate-100"
                >


                    {{-- Avatar --}}
                    <div
                        class="flex h-9 w-9 shrink-0 items-center justify-center
                               rounded-xl bg-blue-600
                               text-sm font-bold text-white
                               shadow-sm shadow-blue-200"
                    >
                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                    </div>


                    {{-- User Details --}}
                    <div class="hidden min-w-0 text-left md:block">

                        <p
                            class="max-w-[130px] truncate
                                   text-sm font-semibold text-slate-700"
                        >
                            {{ auth()->user()->name ?? 'User' }}
                        </p>

                        <p
                            class="max-w-[130px] truncate
                                   text-[11px] text-slate-400"
                        >
                            {{ auth()->user()->getRoleNames()->first() ?? 'User' }}
                        </p>

                    </div>


                    {{-- Arrow --}}
                    <i
                        class="bi bi-chevron-down hidden text-[10px]
                               text-slate-400 sm:block"
                    ></i>

                </button>



                {{-- =====================================
                     DROPDOWN
                ====================================== --}}

                <div
                    x-show="open"
                    x-cloak
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    @click.outside="open = false"
                    class="absolute right-0 top-full mt-2 w-[260px]
                           overflow-hidden rounded-xl
                           border border-slate-200 bg-white
                           shadow-xl shadow-slate-200/60"
                >


                    {{-- User Info --}}
                    <div
                        class="border-b border-slate-100 bg-slate-50 px-4 py-4"
                    >

                        <div class="flex items-center gap-3">

                            <div
                                class="flex h-11 w-11 shrink-0 items-center
                                       justify-center rounded-xl
                                       bg-blue-600 font-bold text-white"
                            >
                                {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                            </div>


                            <div class="min-w-0">

                                <p
                                    class="truncate text-sm font-semibold text-slate-800"
                                >
                                    {{ auth()->user()->name ?? 'User' }}
                                </p>

                                <p
                                    class="truncate text-xs text-slate-500"
                                >
                                    {{ auth()->user()->email ?? '' }}
                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- Profile --}}
                    <a
                        href="#"
                        @click="open = false"
                        class="flex items-center gap-3 px-4 py-3
                               text-sm text-slate-600
                               transition hover:bg-slate-50 hover:text-slate-900"
                    >

                        <i class="bi bi-person text-base"></i>

                        <span>
                            My Profile
                        </span>

                    </a>


                    {{-- Settings --}}
                    <a
                        href="#"
                        @click="open = false"
                        class="flex items-center gap-3 px-4 py-3
                               text-sm text-slate-600
                               transition hover:bg-slate-50 hover:text-slate-900"
                    >

                        <i class="bi bi-gear text-base"></i>

                        <span>
                            Settings
                        </span>

                    </a>


                    {{-- Divider --}}
                    <div class="border-t border-slate-100"></div>


                    {{-- Logout --}}
                    <form
                        method="POST"
                        action="{{ route('logout') }}"
                    >

                        @csrf

                        <button
                            type="submit"
                            class="flex w-full items-center gap-3
                                   px-4 py-3 text-left text-sm
                                   text-red-600
                                   transition hover:bg-red-50"
                        >

                            <i class="bi bi-box-arrow-right text-base"></i>

                            <span>
                                Logout
                            </span>

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</header>
