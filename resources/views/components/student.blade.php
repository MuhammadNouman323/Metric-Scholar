<x-layout>
    <style>
        .sidebar-scroll::-webkit-scrollbar { width: 5px; }
        .sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: rgba(100, 116, 139, 0.25); border-radius: 999px; }
        .sidebar-scroll::-webkit-scrollbar-thumb:hover { background: rgba(100, 116, 139, 0.4); }
        .sidebar-scroll { scrollbar-width: thin; scrollbar-color: rgba(100, 116, 139, 0.25) transparent; }
        @media (prefers-reduced-motion: reduce) {
            * { transition-duration: 0.001ms !important; animation-duration: 0.001ms !important; }
        }
    </style>

    <div class="flex h-screen bg-gradient-to-br from-slate-50 via-slate-50 to-blue-50/40 font-sans antialiased text-slate-900 overflow-hidden">

        <!-- Sidebar -->
        <aside
            class="hidden md:flex flex-col flex-shrink-0 w-[232px] h-[calc(100vh-24px)] my-3 ml-3 rounded-[28px]
                   bg-white/70 backdrop-blur-2xl border border-white/60
                   shadow-[0_8px_32px_rgba(15,23,42,0.07),0_2px_8px_rgba(15,23,42,0.04)]
                   z-20 overflow-hidden">

            <!-- Logo -->
            <div class="h-20 flex items-center px-6 shrink-0">
                <a href="/student/dashboard" class="flex items-center group focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#0e48c1]/40 rounded-xl">
                    <div class="relative mr-3">
                        <div
                            class="w-9 h-9 bg-gradient-to-br from-[#0e48c1] to-[#3d6ae8] rounded-xl flex items-center justify-center text-white
                                   shadow-[0_4px_14px_rgba(14,72,193,0.35)] transition-transform duration-300 group-hover:scale-105 group-hover:-rotate-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M12 3L1 9L5 11.18V17.18L12 21L19 17.18V11.18L21 10.09V17H23V9L12 3ZM18.82 9L12 12.72L5.18 9L12 5.28L18.82 9ZM17 15.99L12 18.72L7 15.99V12.27L12 15L17 12.27V15.99Z" />
                            </svg>
                        </div>
                        <span class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 bg-emerald-400 border-2 border-white rounded-full"></span>
                    </div>
                    <div>
                        <div class="font-bold text-[14.5px] tracking-tight leading-none text-slate-900 mb-1">Scholar Metric</div>
                        <div class="text-[8.5px] font-bold text-slate-400 tracking-[0.2em] uppercase">Academic Curator</div>
                    </div>
                </a>
            </div>

            <!-- Nav -->
            <nav class="sidebar-scroll flex-1 overflow-y-auto px-3.5 space-y-1 text-[14px] font-semibold text-slate-500 pb-4">
                <a href="/student/dashboard"
                    class="{{ request()->is('student/dashboard')
                        ? 'text-white bg-gradient-to-r from-[#0e48c1] to-[#3d6ae8] shadow-[0_6px_16px_rgba(14,72,193,0.3)]'
                        : 'text-slate-500 hover:bg-white/80 hover:text-slate-900 hover:shadow-sm' }}
                        group flex items-center px-4 py-3 rounded-2xl transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#0e48c1]/40">
                    <svg class="w-5 h-5 mr-3 transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                        </path>
                    </svg>
                    Dashboard
                </a>
                <a href="/student/courses"
                    class="{{ request()->is('student/courses')
                        ? 'text-white bg-gradient-to-r from-[#0e48c1] to-[#3d6ae8] shadow-[0_6px_16px_rgba(14,72,193,0.3)]'
                        : 'text-slate-500 hover:bg-white/80 hover:text-slate-900 hover:shadow-sm' }}
                        group flex items-center px-4 py-3 rounded-2xl transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#0e48c1]/40">
                    <svg class="w-5 h-5 mr-3 transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z">
                        </path>
                    </svg>
                    Courses
                </a>
                <a href="/student/teachers"
                    class="{{ request()->is('student/teachers')
                        ? 'text-white bg-gradient-to-r from-[#0e48c1] to-[#3d6ae8] shadow-[0_6px_16px_rgba(14,72,193,0.3)]'
                        : 'text-slate-500 hover:bg-white/80 hover:text-slate-900 hover:shadow-sm' }}
                        group flex items-center px-4 py-3 rounded-2xl transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#0e48c1]/40">
                    <svg class="w-5 h-5 mr-3 transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                    Teachers
                </a>
                <a href="/student/feedback"
                    class="{{ request()->is('student/feedback') || request()->is('student/feedback/*')
                        ? 'text-white bg-gradient-to-r from-[#0e48c1] to-[#3d6ae8] shadow-[0_6px_16px_rgba(14,72,193,0.3)]'
                        : 'text-slate-500 hover:bg-white/80 hover:text-slate-900 hover:shadow-sm' }}
                        group flex items-center px-4 py-3 rounded-2xl transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#0e48c1]/40">
                    <svg class="w-5 h-5 mr-3 transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                        </path>
                    </svg>
                    Feedback
                </a>
                <a href="/student/feedback-history"
                    class="{{ request()->is('student/feedback-history') || request()->is('student/feedback-history/*')
                        ? 'text-white bg-gradient-to-r from-[#0e48c1] to-[#3d6ae8] shadow-[0_6px_16px_rgba(14,72,193,0.3)]'
                        : 'text-slate-500 hover:bg-white/80 hover:text-slate-900 hover:shadow-sm' }}
                        group flex items-center px-4 py-3 rounded-2xl transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#0e48c1]/40">
                    <svg class="w-5 h-5 mr-3 transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                    History
                </a>
            </nav>

            <!-- Bottom Section -->
            <div class="px-4 pb-5 pt-4 border-t border-slate-100/70 shrink-0">
                <!-- Profile card -->
                <a href="/student/profile"
                    class="flex items-center gap-3 bg-white/80 border border-slate-100 rounded-2xl p-2.5 mb-3 shadow-sm
                           transition-all duration-200 hover:shadow-md hover:-translate-y-0.5 hover:border-[#0e48c1]/20
                           focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#0e48c1]/40">
                    <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}"
                        class="w-9 h-9 rounded-full object-cover ring-2 ring-white shadow-sm bg-slate-200 shrink-0">
                    <div class="flex flex-col min-w-0">
                        <span class="text-[12.5px] font-bold text-slate-900 leading-tight truncate">{{ auth()->user()->name }}</span>
                        <span class="text-[10.5px] font-medium text-[#0e48c1] capitalize leading-tight">{{ auth()->user()->role->value }}</span>
                    </div>
                </a>

                <a href="#"
                    class="group flex items-center px-2.5 py-2 rounded-xl text-slate-500 hover:text-slate-900 hover:bg-white/80 text-[12.5px] font-semibold transition-colors mb-0.5 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#0e48c1]/40">
                    <svg class="w-4 h-4 mr-2.5 transition-transform duration-200 group-hover:rotate-45" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Settings
                </a>
                <form method="POST" action="{{ route('logout') }}" class="mb-2">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center px-2.5 py-2 rounded-xl text-slate-500 hover:text-slate-900 hover:bg-white/80 text-[12.5px] font-semibold transition-colors cursor-pointer bg-transparent border-0 text-left focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#0e48c1]/40">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                            </path>
                        </svg>
                        Logout
                    </button>
                </form>

                <!-- Status -->
                <div class="px-2.5 pt-1">
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Status</p>
                    <div class="flex items-center gap-1.5">
                        <span class="relative flex h-2 w-2">
                            <span class="absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75 animate-ping"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                        </span>
                        <span class="text-[12px] font-semibold text-slate-600">Verified Academic</span>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto relative z-10 w-full">
            <!-- Mobile Header -->
            <div class="flex md:hidden items-center justify-between px-6 py-4 bg-white/80 backdrop-blur-md border-b border-slate-100/80 sticky top-0 z-30">
                <a href="/student/dashboard" class="flex items-center gap-2 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#0e48c1]/40 rounded-lg">
                    <div class="w-8 h-8 bg-gradient-to-br from-[#0e48c1] to-[#3d6ae8] rounded-lg flex items-center justify-center text-white shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 3L1 9L5 11.18V17.18L12 21L19 17.18V11.18L21 10.09V17H23V9L12 3ZM18.82 9L12 12.72L5.18 9L12 5.28L18.82 9ZM17 15.99L12 18.72L7 15.99V12.27L12 15L17 12.27V15.99Z" />
                        </svg>
                    </div>
                    <span class="font-bold text-[15px] text-slate-900 tracking-tight">Scholar Metric</span>
                </a>
                <a href="/student/profile" class="flex items-center focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#0e48c1]/40 rounded-full">
                    <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}"
                        class="w-8 h-8 rounded-full object-cover ring-2 ring-white shadow-sm bg-slate-200">
                </a>
            </div>

            <div class="min-h-full">
                {{ $slot }}
            </div>
        </main>

    </div>
</x-layout>