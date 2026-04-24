<x-layout>
    <div class="flex h-screen bg-[#f8fafc] font-sans antialiased text-gray-900 overflow-hidden">

        <!-- Sidebar -->
        <aside
            class="w-[260px] bg-[#f8fafc] border-r border-gray-100 flex flex-col hidden md:flex flex-shrink-0 z-20 h-screen">
            <!-- Logo -->
            <div class="h-24 flex items-center px-8 text-[#0e48c1] mb-2 shrink-0">
                <a href="/admin/dashboard" class="flex items-center">
                    <div
                        class="w-8 h-8 bg-[#0e48c1] rounded-lg flex items-center justify-center text-white mr-3 shadow-sm shadow-blue-500/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M12 3L1 9L5 11.18V17.18L12 21L19 17.18V11.18L21 10.09V17H23V9L12 3ZM18.82 9L12 12.72L5.18 9L12 5.28L18.82 9ZM17 15.99L12 18.72L7 15.99V12.27L12 15L17 12.27V15.99Z" />
                        </svg>
                    </div>
                    <div>
                        <div class="font-bold text-lg tracking-tight leading-none mb-1">Scholar Metric</div>
                        <div class="text-[9px] font-bold text-gray-400 tracking-[0.2em] uppercase">Academic Curator
                        </div>
                    </div>
                </a>
            </div>

            <!-- Nav -->
            <nav class="flex-1 overflow-y-auto space-y-1 text-[14px] font-semibold text-gray-500 pb-4">
                <a href="/admin/dashboard"
                    class="{{ request()->is('admin/dashboard') ? 'text-[#0e48c1] bg-blue-50/70 border-l-4 border-[#0e48c1]' : 'hover:bg-gray-100 hover:text-gray-900 border-l-4 border-transparent' }} flex items-center px-8 py-3.5 transition-colors relative">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                        </path>
                    </svg>
                    Dashboard
                </a>
                <a href="/admin/user"
                    class="{{ request()->is('admin/user') ? 'text-[#0e48c1] bg-blue-50/70 border-l-4 border-[#0e48c1]' : 'hover:bg-gray-100 hover:text-gray-900 border-l-4 border-transparent' }} flex items-center px-8 py-3.5 transition-colors relative">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                    Users
                </a>
                <a href="/admin/students"
                    class="{{ request()->is('admin/students') ? 'text-[#0e48c1] bg-blue-50/70 border-l-4 border-[#0e48c1]' : 'hover:bg-gray-100 hover:text-gray-900 border-l-4 border-transparent' }} flex items-center px-8 py-3.5 transition-colors relative">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z">
                        </path>
                    </svg>
                    Students
                </a>
                <a href="/admin/faculty"
                    class="{{ request()->is('admin/faculity') || request()->is('admin/faculty') ? 'text-[#0e48c1] bg-blue-50/70 border-l-4 border-[#0e48c1]' : 'hover:bg-gray-100 hover:text-gray-900 border-l-4 border-transparent' }} flex items-center px-8 py-3.5 transition-colors relative">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
                        </path>
                    </svg>
                    Faculty
                </a>
                <a href="/admin/courses"
                    class="{{ request()->is('admin/courses') || request()->is('admin/courses/*') ? 'text-[#0e48c1] bg-blue-50/70 border-l-4 border-[#0e48c1]' : 'hover:bg-gray-100 hover:text-gray-900 border-l-4 border-transparent' }} flex items-center px-8 py-3.5 transition-colors relative">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                        </path>
                    </svg>
                    Courses
                </a>
                <a href="/admin/reports"
                    class="{{ request()->is('admin/reports') ? 'text-[#0e48c1] bg-blue-50/70 border-l-4 border-[#0e48c1]' : 'hover:bg-gray-100 hover:text-gray-900 border-l-4 border-transparent' }} flex items-center px-8 py-3.5 transition-colors relative">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                        </path>
                    </svg>
                    Reports
                </a>

            </nav>

            <!-- Bottom Section -->
            <div class="px-6 pb-8 border-t border-gray-100 pt-6 shrink-0">
                <button
                    class="w-full bg-[#0e48c1] hover:bg-blue-800 text-white rounded-xl py-3.5 text-sm font-bold mb-5 transition-all hover:shadow-[0_4px_12px_rgba(14,72,193,0.3)] shadow-[0_4px_10px_rgba(14,72,193,0.15)] flex items-center justify-center gap-2 transform active:scale-[0.98]">
                    <span class="text-lg leading-none"></span> Genrate Report
                </button>

                <!-- Profile -->
                <div class="flex items-center gap-3 bg-[#f1f5f9] rounded-2xl p-3 mb-6">
                    <img src="https://i.pravatar.cc/150?img=60" alt="Dr. Academic"
                        class="w-10 h-10 rounded-full object-cover shadow-sm bg-gray-200">
                    <div class="flex flex-col">
                        <span class="text-[14px] font-bold text-gray-900 leading-tight">admin</span>
                        <span class="text-[13px] font-medium text-gray-500">Senior Professor</span>
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center px-3 py-2 text-gray-500 hover:text-gray-900 text-[14px] font-medium transition-colors cursor-pointer bg-transparent border-0 text-left">
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
