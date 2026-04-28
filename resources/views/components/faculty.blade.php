<x-layout>
    <div class="flex h-screen bg-[#f8fafc] font-sans antialiased text-gray-900 overflow-hidden">

        <!-- Sidebar -->
        <aside
            class="w-[260px] bg-[#f8fafc] border-r border-gray-100 flex flex-col hidden md:flex flex-shrink-0 z-20 h-screen">
            <!-- Logo -->
            <div class="h-24 flex items-center px-8 text-[#0e48c1] mb-2 shrink-0">
                <a href="/faculty/dashboard" class="flex items-center">
                    <div
                        class="w-8 h-8 bg-[#0e48c1] rounded-lg flex items-center justify-center text-white mr-3 shadow-sm shadow-blue-500/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M12 3L1 9L5 11.18V17.18L12 21L19 17.18V11.18L21 10.09V17H23V9L12 3ZM18.82 9L12 12.72L5.18 9L12 5.28L18.82 9ZM17 15.99L12 18.72L7 15.99V12.27L12 15L17 12.27V15.99Z" />
                        </svg>
                    </div>
                    <div>
                        <div class="font-bold text-lg tracking-tight leading-none mb-1">Scholar Metric</div>
                        <div class="text-[9px] font-bold text-gray-400 tracking-[0.2em] uppercase">Faculty Portal
                        </div>
                    </div>
                </a>
            </div>

            <!-- Nav -->
            <nav class="flex-1 overflow-y-auto space-y-1 text-[14px] font-semibold text-gray-500 pb-4">
                <a href="/faculty/dashboard"
                    class="{{ request()->is('faculty/dashboard') ? 'text-[#0e48c1] bg-blue-50/70 border-l-4 border-[#0e48c1]' : 'hover:bg-gray-100 hover:text-gray-900 border-l-4 border-transparent' }} flex items-center px-8 py-3.5 transition-colors relative">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                        </path>
                    </svg>
                    Dashboard
                </a>
                <a href="/faculty/feedback"
                    class="{{ request()->is('faculty/feedback') ? 'text-[#0e48c1] bg-blue-50/70 border-l-4 border-[#0e48c1]' : 'hover:bg-gray-100 hover:text-gray-900 border-l-4 border-transparent' }} flex items-center px-8 py-3.5 transition-colors relative">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                        </path>
                    </svg>
                    Feedback
                </a>
                <a href="/faculty/analytics"
                    class="{{ request()->is('faculty/analytics') ? 'text-[#0e48c1] bg-blue-50/70 border-l-4 border-[#0e48c1]' : 'hover:bg-gray-100 hover:text-gray-900 border-l-4 border-transparent' }} flex items-center px-8 py-3.5 transition-colors relative">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                        </path>
                    </svg>
                    Analytics
                </a>
            </nav>

            <!-- Bottom Section -->
            <div class="px-6 pb-8 border-t border-gray-100 pt-6 shrink-0">
                <!-- Profile card (clickable) -->
                <a href="/faculty/profile"
                    class="flex items-center gap-3 bg-[#f1f5f9] rounded-2xl p-3 mb-4 hover:bg-blue-50 transition-colors">
                    <img src="https://i.pravatar.cc/150?img=60" alt="Dr. Academic"
                        class="w-10 h-10 rounded-full object-cover shadow-sm bg-gray-200">
                    <div class="flex flex-col">
                        <span class="text-[14px] font-bold text-gray-900 leading-tight">Dr. Academic</span>
                        <span class="text-[13px] font-medium text-gray-500">Senior Professor</span>
                    </div>
                </a>
                <a href="#"
                    class="flex items-center px-3 py-2 text-gray-500 hover:text-gray-900 text-[14px] font-semibold transition-colors mb-1">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Settings
                </a>

                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center px-3 py-2 text-gray-500 hover:text-gray-900 text-[14px] font-semibold transition-colors cursor-pointer bg-transparent border-0 text-left">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                            </path>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto bg-white/50 relative z-10 w-full">
            {{ $slot }}
        </main>

    </div>
</x-layout>
