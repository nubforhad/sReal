<header class="sticky top-0 z-30 border-b border-slate-200 bg-white">

    <div class="flex h-16 items-center justify-between px-4 sm:px-6">

        {{-- Left --}}
        <div class="flex items-center gap-3">

            {{-- Mobile Menu --}}
            <button
                type="button"
                @click="sidebarOpen = !sidebarOpen"
                class="rounded-lg p-2 text-slate-600 hover:bg-slate-100 lg:hidden"
            >
                <i class="bi bi-list text-2xl"></i>
            </button>

            {{-- Page Title --}}
            <div class="hidden sm:block">
                <h2 class="text-lg font-semibold text-slate-800">
                    @yield('page-title', 'Dashboard')
                </h2>
            </div>

        </div>


        {{-- Right --}}
        <div class="flex items-center gap-2">

            {{-- Notification --}}
            <button
                type="button"
                class="relative rounded-lg p-2 text-slate-500 hover:bg-slate-100 hover:text-slate-700"
            >
                <i class="bi bi-bell text-xl"></i>

                <span
                    class="absolute right-1 top-1 h-2 w-2 rounded-full bg-red-500"
                ></span>
            </button>


            {{-- User Dropdown --}}
            <div
                x-data="{ open: false }"
                class="relative"
            >

                <button
                    type="button"
                    @click="open = !open"
                    class="flex items-center gap-2 rounded-lg px-2 py-1.5
                           hover:bg-slate-100"
                >

                    <div
                        class="flex h-9 w-9 items-center justify-center
                               rounded-full bg-blue-600 font-semibold text-white"
                    >
                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                    </div>

                    <div class="hidden text-left md:block">

                        <p class="text-sm font-medium text-slate-700">
                            {{ auth()->user()->name ?? 'User' }}
                        </p>

                        <p class="text-xs text-slate-500">
                            {{ auth()->user()->getRoleNames()->first() ?? 'User' }}
                        </p>

                    </div>

                    <i class="bi bi-chevron-down text-xs text-slate-500"></i>

                </button>


                {{-- Dropdown --}}
                <div
                    x-show="open"
                    x-cloak
                    @click.outside="open = false"
                    x-transition
                    class="absolute right-0 mt-2 w-56 overflow-hidden
                           rounded-xl border border-slate-200 bg-white
                           shadow-lg"
                >

                    <div class="border-b border-slate-100 px-4 py-3">

                        <p class="text-sm font-semibold text-slate-800">
                            {{ auth()->user()->name ?? 'User' }}
                        </p>

                        <p class="truncate text-xs text-slate-500">
                            {{ auth()->user()->email ?? '' }}
                        </p>

                    </div>


                    {{-- Profile --}}
                    <a
                        href="#"
                        class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-600
                               hover:bg-slate-50"
                    >
                        <i class="bi bi-person"></i>
                        Profile
                    </a>


                    {{-- Logout --}}
                    <form
                        method="POST"
                        action="{{ route('logout') }}"
                    >
                        @csrf

                        <button
                            type="submit"
                            class="flex w-full items-center gap-3 px-4 py-2.5
                                   text-left text-sm text-red-600 hover:bg-red-50"
                        >
                            <i class="bi bi-box-arrow-right"></i>
                            Logout
                        </button>
                    </form>

                </div>

            </div>

        </div>

    </div>

</header> 
