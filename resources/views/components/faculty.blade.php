<x-layout>
    <style>
        .sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: linear-gradient(180deg, rgba(14,72,193,0.25), rgba(79,131,245,0.25)); border-radius: 999px; }
        .sidebar-scroll::-webkit-scrollbar-thumb:hover { background: linear-gradient(180deg, rgba(14,72,193,0.45), rgba(79,131,245,0.45)); }
        .sidebar-scroll { scrollbar-width: thin; scrollbar-color: rgba(14,72,193,0.25) transparent; }

        .sidebar-drawer { transform: translateX(-100%); transition: transform 0.35s cubic-bezier(0.22, 1, 0.36, 1); }
        .sidebar-drawer.is-open { transform: translateX(0); }
        @media (min-width: 1024px) { .sidebar-drawer, .sidebar-drawer.is-open { transform: none; } }

        .sidebar-backdrop { opacity: 0; pointer-events: none; transition: opacity 0.3s ease; }
        .sidebar-backdrop.is-visible { opacity: 1; pointer-events: auto; }

        .nav-link-active { position: relative; }
        .nav-link-active::before {
            content: '';
            position: absolute; inset: 0; border-radius: inherit;
            background: linear-gradient(135deg, #0e48c1, #3d6ae8);
            opacity: 0; filter: blur(12px); z-index: -1;
            transition: opacity 0.3s;
        }
        .nav-link-active:hover::before { opacity: 0.25; }

        .profile-card { position: relative; overflow: hidden; }
        .profile-card::before {
            content: '';
            position: absolute; top: -50%; left: -50%; width: 200%; height: 200%;
            background: conic-gradient(from 0deg, transparent, rgba(14,72,193,0.1), transparent 30%);
            animation: profileSpin 4s linear infinite;
            opacity: 0; transition: opacity 0.3s;
        }
        .profile-card:hover::before { opacity: 1; }
        @keyframes profileSpin { to { transform: rotate(360deg); } }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { transition-duration: 0.001ms !important; animation-duration: 0.001ms !important; }
        }
    </style>

    <div class="flex h-screen bg-gradient-to-br from-slate-50 via-slate-50 to-blue-50/30 font-sans antialiased text-slate-900 overflow-hidden">

        <!-- Mobile Backdrop -->
        <div id="sidebar-backdrop" class="sidebar-backdrop fixed inset-0 z-[55] bg-slate-900/40 backdrop-blur-sm lg:hidden" aria-hidden="true"></div>

        <!-- Sidebar -->
        <aside id="sidebar-drawer"
            class="sidebar-drawer flex flex-col flex-shrink-0 fixed lg:relative inset-y-0 left-0
                   w-[280px] max-w-[85vw] lg:w-[272px]
                   h-full lg:h-[calc(100vh-24px)] my-0 lg:my-3 ml-0 lg:ml-3
                   rounded-none lg:rounded-[28px]
                   bg-white/60 backdrop-blur-2xl border border-white/60
                   shadow-[0_8px_32px_rgba(15,23,42,0.07),0_2px_8px_rgba(15,23,42,0.04)]
                   z-[60] lg:z-20 overflow-hidden">

            <!-- Decorative blobs -->
            <div class="absolute -top-20 -right-20 w-48 h-48 bg-gradient-to-br from-[#0e48c1]/10 to-[#4f83f5]/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-16 -left-16 w-40 h-40 bg-gradient-to-tr from-[#4f83f5]/8 to-[#0e48c1]/8 rounded-full blur-3xl pointer-events-none"></div>

            <!-- Logo -->
            <div class="relative h-24 flex items-center justify-between px-7 shrink-0">
                <a href="/faculty/dashboard" class="flex items-center group focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#0e48c1]/40 rounded-xl">
                    <div class="relative mr-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-[#0e48c1] to-[#3d6ae8] rounded-2xl flex items-center justify-center text-white
                                   shadow-[0_4px_14px_rgba(14,72,193,0.35)] transition-all duration-300 group-hover:scale-110 group-hover:-rotate-3 group-hover:shadow-[0_6px_20px_rgba(14,72,193,0.45)]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 3L1 9L5 11.18V17.18L12 21L19 17.18V11.18L21 10.09V17H23V9L12 3ZM18.82 9L12 12.72L5.18 9L12 5.28L18.82 9ZM17 15.99L12 18.72L7 15.99V12.27L12 15L17 12.27V15.99Z" />
                            </svg>
                        </div>
                        <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-emerald-400 border-2 border-white rounded-full shadow-[0_0_8px_rgba(52,211,153,0.5)] animate-pulse"></span>
                    </div>
                    <div>
                        <div class="font-bold text-[17px] tracking-tight leading-none text-slate-900 mb-1">Scholar Metric</div>
                        <div class="text-[9px] font-bold text-[#0e48c1]/60 tracking-[0.2em] uppercase">Faculty Portal</div>
                    </div>
                </a>
                <button type="button" data-sidebar-close aria-label="Close navigation menu"
                    class="lg:hidden w-10 h-10 flex items-center justify-center rounded-xl text-slate-400 hover:text-slate-900 hover:bg-slate-100/80 transition-all duration-200 cursor-pointer focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#0e48c1]/40 active:scale-90">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Nav -->
            <nav class="sidebar-scroll flex-1 overflow-y-auto px-4 space-y-1 text-[14px] font-semibold text-slate-500 pb-4">
                <a href="/faculty/dashboard"
                    class="{{ request()->is('faculty/dashboard')
                        ? 'text-white bg-gradient-to-r from-[#0e48c1] to-[#3d6ae8] shadow-[0_6px_16px_rgba(14,72,193,0.3)] nav-link-active'
                        : 'text-slate-500 hover:bg-white/80 hover:text-slate-900 hover:shadow-sm hover:shadow-[0_2px_8px_rgba(14,72,193,0.06)]' }}
                        group flex items-center px-4 py-3 rounded-2xl transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#0e48c1]/40">
                    <svg class="w-5 h-5 mr-3 transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                    Dashboard
                </a>
                <a href="/faculty/feedback"
                    class="{{ request()->is('faculty/feedback')
                        ? 'text-white bg-gradient-to-r from-[#0e48c1] to-[#3d6ae8] shadow-[0_6px_16px_rgba(14,72,193,0.3)] nav-link-active'
                        : 'text-slate-500 hover:bg-white/80 hover:text-slate-900 hover:shadow-sm hover:shadow-[0_2px_8px_rgba(14,72,193,0.06)]' }}
                        group flex items-center px-4 py-3 rounded-2xl transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#0e48c1]/40">
                    <svg class="w-5 h-5 mr-3 transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                    Feedback
                </a>
                <a href="/faculty/analytics"
                    class="{{ request()->is('faculty/analytics')
                        ? 'text-white bg-gradient-to-r from-[#0e48c1] to-[#3d6ae8] shadow-[0_6px_16px_rgba(14,72,193,0.3)] nav-link-active'
                        : 'text-slate-500 hover:bg-white/80 hover:text-slate-900 hover:shadow-sm hover:shadow-[0_2px_8px_rgba(14,72,193,0.06)]' }}
                        group flex items-center px-4 py-3 rounded-2xl transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#0e48c1]/40">
                    <svg class="w-5 h-5 mr-3 transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Analytics
                </a>
            </nav>

            <!-- Bottom Section -->
            <div class="relative px-5 pb-6 pt-5 border-t border-slate-100/70 shrink-0">
                <!-- Profile card -->
                <a href="/faculty/profile"
                    class="profile-card flex items-center gap-3 bg-white/80 border border-slate-100/80 rounded-2xl p-3 mb-3 shadow-sm
                           transition-all duration-300 hover:shadow-md hover:-translate-y-0.5 hover:border-[#0e48c1]/20
                           focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#0e48c1]/40">
                    <div class="relative">
                        <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}"
                            class="w-10 h-10 rounded-full object-cover ring-2 ring-white shadow-sm bg-slate-200 shrink-0">
                        <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-emerald-400 border-2 border-white rounded-full"></span>
                    </div>
                    <div class="flex flex-col min-w-0">
                        <span class="text-[13.5px] font-bold text-slate-900 leading-tight truncate">{{ auth()->user()->name }}</span>
                        <span class="text-[11.5px] font-medium text-[#0e48c1] capitalize leading-tight">{{ auth()->user()->role->value }}</span>
                    </div>
                </a>

                <a href="#"
                    class="group flex items-center px-3 py-2.5 rounded-xl text-slate-500 hover:text-slate-900 hover:bg-white/80 text-[13.5px] font-semibold transition-all duration-200 mb-1 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#0e48c1]/40 active:scale-[0.98]">
                    <svg class="w-4.5 h-4.5 mr-3 transition-transform duration-200 group-hover:rotate-45" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Settings
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center px-3 py-2.5 rounded-xl text-slate-500 hover:text-red-600 hover:bg-red-50/60 text-[13.5px] font-semibold transition-all duration-200 cursor-pointer bg-transparent border-0 text-left group focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-red-400/40 active:scale-[0.98]">
                        <svg class="w-4.5 h-4.5 mr-3 transition-transform duration-200 group-hover:-translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto relative z-10 w-full">
            <x-notification-bell position="global" />

            <!-- Mobile Header -->
            <div class="flex lg:hidden items-center justify-between px-4 py-3 bg-white/80 backdrop-blur-md border-b border-slate-100/80 sticky top-0 z-30">
                <div class="flex items-center gap-2">
                    <button type="button" data-sidebar-toggle aria-controls="sidebar-drawer" aria-expanded="false" aria-label="Open navigation menu"
                        class="w-11 h-11 flex items-center justify-center rounded-xl border border-slate-200 bg-white/80 text-slate-700 hover:bg-slate-50 active:scale-95 transition-all duration-200 cursor-pointer focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#0e48c1]/40">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <a href="/faculty/dashboard" class="flex items-center gap-2 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#0e48c1]/40 rounded-lg">
                        <div class="w-8 h-8 bg-gradient-to-br from-[#0e48c1] to-[#3d6ae8] rounded-xl flex items-center justify-center text-white shadow-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 3L1 9L5 11.18V17.18L12 21L19 17.18V11.18L21 10.09V17H23V9L12 3ZM18.82 9L12 12.72L5.18 9L12 5.28L18.82 9ZM17 15.99L12 18.72L7 15.99V12.27L12 15L17 12.27V15.99Z" />
                            </svg>
                        </div>
                        <span class="font-bold text-[15px] text-slate-900 tracking-tight">Scholar Metric</span>
                    </a>
                </div>
                <div class="flex items-center gap-1">
                    <a href="/faculty/profile" class="flex items-center focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#0e48c1]/40 rounded-full">
                        <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}"
                            class="w-8 h-8 rounded-full object-cover ring-2 ring-white shadow-sm bg-slate-200">
                    </a>
                </div>
            </div>

            <div class="min-h-full">
                {{ $slot }}
            </div>
        </main>

    </div>

    <script>
        (function () {
            var drawer = document.getElementById('sidebar-drawer');
            var backdrop = document.getElementById('sidebar-backdrop');
            var main = document.querySelector('main');
            if (!drawer) return;

            function setOpen(open) {
                drawer.classList.toggle('is-open', open);
                if (backdrop) backdrop.classList.toggle('is-visible', open);
                document.querySelectorAll('[data-sidebar-toggle]').forEach(function (btn) {
                    btn.setAttribute('aria-expanded', String(open));
                });
                if (main && window.innerWidth < 1024) main.style.overflow = open ? 'hidden' : '';
            }

            document.querySelectorAll('[data-sidebar-toggle]').forEach(function (el) {
                el.addEventListener('click', function () {
                    setOpen(!drawer.classList.contains('is-open'));
                });
            });
            document.querySelectorAll('[data-sidebar-close]').forEach(function (el) {
                el.addEventListener('click', function () { setOpen(false); });
            });
            if (backdrop) backdrop.addEventListener('click', function () { setOpen(false); });
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') setOpen(false);
            });
            drawer.querySelectorAll('a').forEach(function (link) {
                link.addEventListener('click', function () { setOpen(false); });
            });
            window.matchMedia('(min-width: 1024px)').addEventListener('change', function (e) {
                if (e.matches) setOpen(false);
            });
        })();
    </script>
</x-layout>
