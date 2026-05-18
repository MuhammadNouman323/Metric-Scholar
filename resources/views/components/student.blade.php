<x-layout>
    <div class="flex h-screen bg-[#f8fafc] font-sans antialiased text-gray-900 overflow-hidden">

        <!-- Sidebar -->
        <aside
            class="w-[220px] bg-[#f8fafc] border-r border-gray-100 flex flex-col hidden md:flex flex-shrink-0 z-20 h-screen">
            <!-- Logo -->
            <div class="h-20 flex items-center px-6 text-[#0e48c1] mb-2 shrink-0">
                <a href="/student/dashboard" class="flex items-center">
                    <div
                        class="w-8 h-8 bg-[#0e48c1] rounded-lg flex items-center justify-center text-white mr-3 shadow-sm shadow-blue-500/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24"
                            fill="currentColor">
                            <path
                                d="M12 3L1 9L5 11.18V17.18L12 21L19 17.18V11.18L21 10.09V17H23V9L12 3ZM18.82 9L12 12.72L5.18 9L12 5.28L18.82 9ZM17 15.99L12 18.72L7 15.99V12.27L12 15L17 12.27V15.99Z" />
                        </svg>
                    </div>
                    <div>
                        <div class="font-bold text-[15px] tracking-tight leading-none mb-1">Scholar Metric</div>
                        <div class="text-[9px] font-bold text-gray-400 tracking-[0.2em] uppercase">Academic Curator
                        </div>
                    </div>
                </a>
            </div>

            <!-- Nav -->
            <nav class="flex-1 overflow-y-auto space-y-0.5 text-[14px] font-semibold text-gray-500 pb-4">
                <a href="/student/dashboard"
                    class="{{ request()->is('student/dashboard') ? 'text-[#0e48c1] bg-blue-50/70 border-l-4 border-[#0e48c1]' : 'hover:bg-gray-100 hover:text-gray-900 border-l-4 border-transparent' }} flex items-center px-6 py-3.5 transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                        </path>
                    </svg>
                    Dashboard
                </a>
                <a href="/student/courses"
                    class="{{ request()->is('student/courses') ? 'text-[#0e48c1] bg-blue-50/70 border-l-4 border-[#0e48c1]' : 'hover:bg-gray-100 hover:text-gray-900 border-l-4 border-transparent' }} flex items-center px-6 py-3.5 transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z">
                        </path>
                    </svg>
                    Courses
                </a>
                <a href="/student/feedback"
                    class="{{ request()->is('student/feedback') || request()->is('student/feedback/*') ? 'text-[#0e48c1] bg-blue-50/70 border-l-4 border-[#0e48c1]' : 'hover:bg-gray-100 hover:text-gray-900 border-l-4 border-transparent' }} flex items-center px-6 py-3.5 transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                        </path>
                    </svg>
                    Feedback
                </a>
            </nav>

            <!-- Bottom Section -->
            <div class="px-5 pb-6 border-t border-gray-100 pt-5 shrink-0">
                <!-- Profile card -->
                <a href="/student/profile"
                    class="flex items-center gap-3 bg-[#f1f5f9] rounded-2xl p-3 mb-3 hover:bg-blue-50 transition-colors">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=0e48c1&color=fff" alt="{{ auth()->user()->name }}"
                        class="w-9 h-9 rounded-full object-cover shadow-sm bg-gray-200">
                    <div class="flex flex-col">
                        <span class="text-[13px] font-bold text-gray-900 leading-tight">{{ auth()->user()->name }}</span>
                        <span class="text-[11px] font-medium text-gray-500 capitalize">{{ auth()->user()->role }}</span>
                    </div>
                </a>

                
                <a href="#"
                    class="flex items-center px-2 py-2 text-gray-500 hover:text-gray-900 text-[13px] font-semibold transition-colors mb-0.5">
                    <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Settings
                </a>
                <form method="POST" action="{{ route('logout') }}" class="inline mb-3">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center px-2 py-2 text-gray-500 hover:text-gray-900 text-[13px] font-semibold transition-colors cursor-pointer bg-transparent border-0 text-left">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                            </path>
                        </svg>
                        Logout
                    </button>
                </form>

                <!-- Status -->
                <div class="px-2">
                    <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mb-1">Status</p>
                    <div class="flex items-center gap-1.5">
                        <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                        <span class="text-[12px] font-semibold text-gray-600">Verified Academic</span>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto bg-white/50 relative z-10 w-full">
            {{ $slot }}
        </main>

    </div>
</x-layout>
