<x-layout>
    <style>
        /* Sidebar scroll */
        .sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: linear-gradient(180deg, rgba(14,72,193,0.25), rgba(79,131,245,0.25)); border-radius: 999px; }
        .sidebar-scroll::-webkit-scrollbar-thumb:hover { background: linear-gradient(180deg, rgba(14,72,193,0.45), rgba(79,131,245,0.45)); }
        .sidebar-scroll { scrollbar-width: thin; scrollbar-color: rgba(14,72,193,0.25) transparent; }

        /* Drawer */
        .sidebar-drawer { transform: translateX(-100%); transition: transform 0.35s cubic-bezier(0.22, 1, 0.36, 1); }
        .sidebar-drawer.is-open { transform: translateX(0); }
        @media (min-width: 1024px) { .sidebar-drawer, .sidebar-drawer.is-open { transform: none; } }

        /* Backdrop */
        .sidebar-backdrop { opacity: 0; pointer-events: none; transition: opacity 0.3s ease; }
        .sidebar-backdrop.is-visible { opacity: 1; pointer-events: auto; }

        /* Nav link glow on active */
        .nav-link-active {
            position: relative;
        }
        .nav-link-active::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: inherit;
            background: linear-gradient(135deg, #0e48c1, #3d6ae8);
            opacity: 0;
            filter: blur(12px);
            z-index: -1;
            transition: opacity 0.3s;
        }
        .nav-link-active:hover::before { opacity: 0.25; }

        /* Profile card hover */
        .profile-card {
            position: relative;
            overflow: hidden;
        }
        .profile-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: conic-gradient(from 0deg, transparent, rgba(14,72,193,0.1), transparent 30%);
            animation: profileSpin 4s linear infinite;
            opacity: 0;
            transition: opacity 0.3s;
        }
        .profile-card:hover::before { opacity: 1; }
        @keyframes profileSpin { to { transform: rotate(360deg); } }

        /* Auto-hiding scrollbar: hidden at rest, visible while scrolling */
        .scroll-auto-hide { scrollbar-width: thin; scrollbar-color: transparent transparent; scrollbar-gutter: stable; transition: scrollbar-color 0.3s ease; }
        .scroll-auto-hide::-webkit-scrollbar { width: 8px; height: 8px; }
        .scroll-auto-hide::-webkit-scrollbar-track { background: transparent; }
        .scroll-auto-hide::-webkit-scrollbar-thumb { background: transparent; border-radius: 999px; transition: background 0.3s ease; }
        .scroll-auto-hide.scrolling { scrollbar-color: rgba(100,116,139,0.45) transparent; }
        .scroll-auto-hide.scrolling::-webkit-scrollbar-thumb { background: rgba(100,116,139,0.45); }

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

            <!-- Decorative glow blob -->
            <div class="absolute -top-20 -right-20 w-48 h-48 bg-gradient-to-br from-[#0e48c1]/10 to-[#4f83f5]/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-16 -left-16 w-40 h-40 bg-gradient-to-tr from-[#4f83f5]/8 to-[#0e48c1]/8 rounded-full blur-3xl pointer-events-none"></div>

            <!-- Logo -->
            <div class="relative h-24 flex items-center justify-between px-7 shrink-0">
                <a href="/admin/dashboard" class="flex items-center group focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#0e48c1]/40 rounded-xl">
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
                        <div class="text-[9px] font-bold text-[#0e48c1]/60 tracking-[0.2em] uppercase">Academic Curator</div>
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
                <a href="/admin/dashboard"
                    class="{{ request()->is('admin/dashboard')
                        ? 'text-white bg-gradient-to-r from-[#0e48c1] to-[#3d6ae8] shadow-[0_6px_16px_rgba(14,72,193,0.3)] nav-link-active'
                        : 'text-slate-500 hover:bg-white/80 hover:text-slate-900 hover:shadow-sm hover:shadow-[0_2px_8px_rgba(14,72,193,0.06)]' }}
                        group flex items-center px-4 py-3 rounded-2xl transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#0e48c1]/40">
                    <svg class="w-5 h-5 mr-3 transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                    Dashboard
                </a>
                <a href="/admin/user"
                    class="{{ request()->is('admin/user')
                        ? 'text-white bg-gradient-to-r from-[#0e48c1] to-[#3d6ae8] shadow-[0_6px_16px_rgba(14,72,193,0.3)] nav-link-active'
                        : 'text-slate-500 hover:bg-white/80 hover:text-slate-900 hover:shadow-sm hover:shadow-[0_2px_8px_rgba(14,72,193,0.06)]' }}
                        group flex items-center px-4 py-3 rounded-2xl transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#0e48c1]/40">
                    <svg class="w-5 h-5 mr-3 transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Users
                </a>
                <a href="/admin/departments"
                    class="{{ request()->is('admin/departments')
                        ? 'text-white bg-gradient-to-r from-[#0e48c1] to-[#3d6ae8] shadow-[0_6px_16px_rgba(14,72,193,0.3)] nav-link-active'
                        : 'text-slate-500 hover:bg-white/80 hover:text-slate-900 hover:shadow-sm hover:shadow-[0_2px_8px_rgba(14,72,193,0.06)]' }}
                        group flex items-center px-4 py-3 rounded-2xl transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#0e48c1]/40">
                    <svg class="w-5 h-5 mr-3 transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 21V9l9-6 9 6v12h-6v-7H9v7H3z" />
                    </svg>
                    Departments
                </a>
                <a href="/admin/students"
                    class="{{ request()->is('admin/students')
                        ? 'text-white bg-gradient-to-r from-[#0e48c1] to-[#3d6ae8] shadow-[0_6px_16px_rgba(14,72,193,0.3)] nav-link-active'
                        : 'text-slate-500 hover:bg-white/80 hover:text-slate-900 hover:shadow-sm hover:shadow-[0_2px_8px_rgba(14,72,193,0.06)]' }}
                        group flex items-center px-4 py-3 rounded-2xl transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#0e48c1]/40">
                    <svg class="w-5 h-5 mr-3 transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                    </svg>
                    Students
                </a>
                <a href="/admin/faculty"
                    class="{{ request()->is('admin/faculity') || request()->is('admin/faculty')
                        ? 'text-white bg-gradient-to-r from-[#0e48c1] to-[#3d6ae8] shadow-[0_6px_16px_rgba(14,72,193,0.3)] nav-link-active'
                        : 'text-slate-500 hover:bg-white/80 hover:text-slate-900 hover:shadow-sm hover:shadow-[0_2px_8px_rgba(14,72,193,0.06)]' }}
                        group flex items-center px-4 py-3 rounded-2xl transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#0e48c1]/40">
                    <svg class="w-5 h-5 mr-3 transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                    Faculty
                </a>
                <a href="/admin/courses"
                    class="{{ request()->is('admin/courses') || request()->is('admin/courses/*')
                        ? 'text-white bg-gradient-to-r from-[#0e48c1] to-[#3d6ae8] shadow-[0_6px_16px_rgba(14,72,193,0.3)] nav-link-active'
                        : 'text-slate-500 hover:bg-white/80 hover:text-slate-900 hover:shadow-sm hover:shadow-[0_2px_8px_rgba(14,72,193,0.06)]' }}
                        group flex items-center px-4 py-3 rounded-2xl transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#0e48c1]/40">
                    <svg class="w-5 h-5 mr-3 transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    Courses
                </a>
                <a href="/admin/reports"
                    class="{{ request()->is('admin/reports')
                        ? 'text-white bg-gradient-to-r from-[#0e48c1] to-[#3d6ae8] shadow-[0_6px_16px_rgba(14,72,193,0.3)] nav-link-active'
                        : 'text-slate-500 hover:bg-white/80 hover:text-slate-900 hover:shadow-sm hover:shadow-[0_2px_8px_rgba(14,72,193,0.06)]' }}
                        group flex items-center px-4 py-3 rounded-2xl transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#0e48c1]/40">
                    <svg class="w-5 h-5 mr-3 transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Reports
                </a>
                <a href="/admin/moderation"
                    class="{{ request()->is('admin/moderation')
                        ? 'text-white bg-gradient-to-r from-[#0e48c1] to-[#3d6ae8] shadow-[0_6px_16px_rgba(14,72,193,0.3)] nav-link-active'
                        : 'text-slate-500 hover:bg-white/80 hover:text-slate-900 hover:shadow-sm hover:shadow-[0_2px_8px_rgba(14,72,193,0.06)]' }}
                        group flex items-center px-4 py-3 rounded-2xl transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#0e48c1]/40">
                    <svg class="w-5 h-5 mr-3 transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    Moderation
                </a>
                <a href="/admin/evaluations"
                    class="{{ request()->is('admin/evaluations*')
                        ? 'text-white bg-gradient-to-r from-[#0e48c1] to-[#3d6ae8] shadow-[0_6px_16px_rgba(14,72,193,0.3)] nav-link-active'
                        : 'text-slate-500 hover:bg-white/80 hover:text-slate-900 hover:shadow-sm hover:shadow-[0_2px_8px_rgba(14,72,193,0.06)]' }}
                        group flex items-center px-4 py-3 rounded-2xl transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#0e48c1]/40">
                    <svg class="w-5 h-5 mr-3 transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                    Evaluations
                </a>
            </nav>

            <!-- Bottom Section -->
            <div class="relative px-5 pb-6 pt-5 border-t border-slate-100/70 shrink-0">

                <a href="/admin/evaluations/new"
                    class="w-full flex items-center justify-center gap-2 mb-5 py-3.5 rounded-2xl text-sm font-bold text-white
                           bg-gradient-to-r from-[#0e48c1] to-[#3d6ae8]
                           shadow-[0_6px_18px_rgba(14,72,193,0.3)]
                           transition-all duration-300 hover:shadow-[0_10px_28px_rgba(14,72,193,0.45)] hover:-translate-y-0.5 hover:scale-[1.02]
                           active:translate-y-0 active:scale-[0.98]
                           focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#0e48c1]/40 focus-visible:ring-offset-2
                           relative overflow-hidden group">
                    <span class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/20 to-white/0 translate-x-[-200%] group-hover:translate-x-[200%] transition-transform duration-700 ease-out"></span>
                    <svg class="w-4 h-4 relative" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    <span class="relative">New Evaluation</span>
                </a>

                <!-- Profile -->
                <a href="{{ route('admin.profile') }}"
                    class="profile-card flex items-center gap-3 bg-white/80 border border-slate-100/80 rounded-2xl p-3 mb-4 shadow-sm
                           transition-all duration-300 hover:shadow-md hover:-translate-y-0.5 hover:border-[#0e48c1]/20
                           focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#0e48c1]/40">
                    <div class="relative">
                        <img src="{{ Auth::user()->avatar_url }}" alt="{{ Auth::user()->name }}"
                            class="w-10 h-10 rounded-full object-cover ring-2 ring-white shadow-sm bg-slate-200 shrink-0">
                        <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-emerald-400 border-2 border-white rounded-full"></span>
                    </div>
                    <div class="flex flex-col min-w-0">
                        <span class="text-[13.5px] font-bold text-slate-900 leading-tight truncate">{{ Auth::user()->name }}</span>
                        <span class="text-[11.5px] font-medium text-[#0e48c1] leading-tight capitalize">{{ Auth::user()->role->value }}</span>
                        <span class="text-[11px] font-medium text-slate-400 leading-tight truncate">{{ Auth::user()->email }}</span>
                    </div>
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
        <main class="flex-1 overflow-y-auto scroll-auto-hide relative z-10 w-full">
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
                    <a href="/admin/dashboard" class="flex items-center gap-2 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#0e48c1]/40 rounded-lg">
                        <div class="w-8 h-8 bg-gradient-to-br from-[#0e48c1] to-[#3d6ae8] rounded-xl flex items-center justify-center text-white shadow-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 3L1 9L5 11.18V17.18L12 21L19 17.18V11.18L21 10.09V17H23V9L12 3ZM18.82 9L12 12.72L5.18 9L12 5.28L18.82 9ZM17 15.99L12 18.72L7 15.99V12.27L12 15L17 12.27V15.99Z" />
                            </svg>
                        </div>
                        <span class="font-bold text-[15px] text-slate-900 tracking-tight">Scholar Metric</span>
                    </a>
                </div>
                <div class="flex items-center gap-1">
                    <a href="{{ route('admin.profile') }}" class="flex items-center focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#0e48c1]/40 rounded-full">
                        <img src="{{ Auth::user()->avatar_url }}" alt="{{ Auth::user()->name }}"
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

            document.querySelectorAll('.scroll-auto-hide').forEach(function (el) {
                var hideTimer = null;
                el.addEventListener('scroll', function () {
                    el.classList.add('scrolling');
                    if (hideTimer) clearTimeout(hideTimer);
                    hideTimer = setTimeout(function () {
                        el.classList.remove('scrolling');
                    }, 500);
                }, { passive: true });
            });
        })();
    </script>
</x-layout>
