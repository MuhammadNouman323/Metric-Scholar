<x-layout>
    <style>
        html {
            scroll-behavior: smooth;
        }

        .reveal {
            opacity: 0;
            transform: translateY(28px);
            transition: opacity 0.8s cubic-bezier(0.22, 1, 0.36, 1), transform 0.8s cubic-bezier(0.22, 1, 0.36, 1);
        }

        .reveal.revealed {
            opacity: 1;
            transform: none;
        }

        @keyframes float-slow {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-14px);
            }
        }

        @keyframes float-slower {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(10px);
            }
        }

        .animate-float-slow {
            animation: float-slow 6s ease-in-out infinite;
        }

        .animate-float-slower {
            animation: float-slower 7s ease-in-out infinite;
        }

        @keyframes pulse-ring {
            0% {
                box-shadow: 0 0 0 0 rgba(14, 72, 193, 0.25);
            }

            70% {
                box-shadow: 0 0 0 12px rgba(14, 72, 193, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(14, 72, 193, 0);
            }
        }

        .animate-pulse-ring {
            animation: pulse-ring 2.5s ease-out infinite;
        }
    </style>

    <!-- ==================== NAVBAR ==================== -->
    <header id="navbar"
        class="fixed top-0 inset-x-0 z-50 transition-all duration-300 border-b border-transparent">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-[72px]">
                <!-- Logo -->
                <a href="{{ route('landing') }}" class="flex items-center gap-3 group">
                    <div
                        class="w-10 h-10 bg-[#0e48c1] rounded-xl flex items-center justify-center text-white shadow-[0_8px_20px_rgba(14,72,193,0.25)] group-hover:shadow-[0_8px_25px_rgba(14,72,193,0.35)] transition-shadow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M12 3L1 9L5 11.18V17.18L12 21L19 17.18V11.18L21 10.09V17H23V9L12 3ZM18.82 9L12 12.72L5.18 9L12 5.28L18.82 9ZM17 15.99L12 18.72L7 15.99V12.27L12 15L17 12.27V15.99Z" />
                        </svg>
                    </div>
                    <span class="font-bold text-xl tracking-tight text-gray-900">Scholar <span
                            class="text-[#0e48c1]">Metric</span></span>
                </a>

                <!-- Desktop Nav -->
                <nav class="hidden md:flex items-center gap-1 bg-white/70 backdrop-blur-md border border-gray-100 rounded-full px-2 py-1.5 shadow-sm">
                    <a href="#features"
                        class="px-4 py-2 text-sm font-semibold text-gray-600 hover:text-[#0e48c1] hover:bg-white rounded-full transition-colors">Features</a>
                    <a href="#how-it-works"
                        class="px-4 py-2 text-sm font-semibold text-gray-600 hover:text-[#0e48c1] hover:bg-white rounded-full transition-colors">How
                        it works</a>
                    <a href="#testimonials"
                        class="px-4 py-2 text-sm font-semibold text-gray-600 hover:text-[#0e48c1] hover:bg-white rounded-full transition-colors">Testimonials</a>
                </nav>

                <!-- Desktop Actions -->
                <div class="hidden md:flex items-center gap-3">
                    <a href="{{ route('login') }}"
                        class="px-5 py-2.5 text-sm font-bold text-gray-700 hover:text-[#0e48c1] transition-colors">Login</a>
                    <a href="{{ route('register') }}"
                        class="px-5 py-2.5 bg-[#0e48c1] hover:bg-[#0c3ca1] text-white text-sm font-bold rounded-xl shadow-[0_8px_20px_rgba(14,72,193,0.2)] hover:shadow-[0_8px_25px_rgba(14,72,193,0.3)] transition-all active:scale-[0.97]">Get
                        Started</a>
                </div>

                <!-- Mobile Toggle -->
                <button id="mobile-menu-btn" type="button"
                    class="md:hidden w-11 h-11 flex items-center justify-center rounded-xl border border-gray-200 bg-white/80 backdrop-blur text-gray-700 hover:bg-gray-50 transition-colors"
                    aria-label="Toggle menu" aria-expanded="false">
                    <svg id="icon-open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg id="icon-close" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu"
            class="md:hidden hidden mx-4 mb-4 rounded-2xl bg-white/95 backdrop-blur-md border border-gray-100 shadow-[0_20px_50px_rgba(0,0,0,0.08)] p-3">
            <nav class="flex flex-col gap-1">
                <a href="#features"
                    class="mobile-link px-4 py-3 text-sm font-bold text-gray-700 hover:bg-[#f4f6f8] hover:text-[#0e48c1] rounded-xl transition-colors">Features</a>
                <a href="#how-it-works"
                    class="mobile-link px-4 py-3 text-sm font-bold text-gray-700 hover:bg-[#f4f6f8] hover:text-[#0e48c1] rounded-xl transition-colors">How
                    it works</a>
                <a href="#testimonials"
                    class="mobile-link px-4 py-3 text-sm font-bold text-gray-700 hover:bg-[#f4f6f8] hover:text-[#0e48c1] rounded-xl transition-colors">Testimonials</a>
                <div class="flex gap-2 pt-2 mt-2 border-t border-gray-100">
                    <a href="{{ route('login') }}"
                        class="mobile-link flex-1 text-center px-4 py-3 text-sm font-bold text-gray-700 border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors">Login</a>
                    <a href="{{ route('register') }}"
                        class="mobile-link flex-1 text-center px-4 py-3 text-sm font-bold bg-[#0e48c1] text-white rounded-xl hover:bg-[#0c3ca1] transition-colors">Get
                        Started</a>
                </div>
            </nav>
        </div>
    </header>

    <!-- ==================== HERO ==================== -->
    <section class="relative pt-36 pb-16 lg:pt-44 lg:pb-24 overflow-hidden">
        <!-- Background decorations -->
        <div class="absolute inset-0 -z-10 bg-gradient-to-b from-[#f4f6f8] via-white to-white"></div>
        <div class="absolute -top-40 -right-40 -z-10 w-[600px] h-[600px] rounded-full bg-[radial-gradient(circle_at_center,_rgba(14,72,193,0.10),_transparent_65%)]"></div>
        <div class="absolute top-40 -left-52 -z-10 w-[550px] h-[550px] rounded-full bg-[radial-gradient(circle_at_center,_rgba(14,72,193,0.08),_transparent_65%)]"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto reveal">
                <!-- Badge -->
                <div
                    class="inline-flex items-center gap-2 bg-white border border-gray-200 rounded-full pl-2 pr-4 py-1.5 shadow-sm mb-8">
                    <span
                        class="bg-[#0e48c1]/10 text-[#0e48c1] text-[11px] font-extrabold uppercase tracking-wider px-2.5 py-1 rounded-full">New</span>
                    <span class="text-[13px] font-semibold text-gray-600">Smarter faculty evaluations are here</span>
                </div>

                <h1
                    class="text-4xl sm:text-5xl lg:text-[64px] font-extrabold tracking-tight leading-[1.08] text-gray-900 mb-6">
                    Elevating Academic Excellence through
                    <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-[#0e48c1] to-[#4f83f5]">Informed
                        Feedback.</span>
                </h1>

                <p class="text-lg sm:text-xl text-gray-500 font-medium leading-relaxed max-w-2xl mx-auto mb-10">
                    Scholar Metric is a sophisticated evaluation ecosystem that turns anonymous course feedback into
                    actionable insights for students, faculty, and administrators.
                </p>

                <!-- CTAs -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-14">
                    <a href="{{ route('register') }}"
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-4 bg-[#0e48c1] hover:bg-[#0c3ca1] text-white font-bold rounded-xl shadow-[0_8px_20px_rgba(14,72,193,0.25)] hover:shadow-[0_12px_30px_rgba(14,72,193,0.35)] transition-all focus:ring-4 focus:ring-blue-300 focus:outline-none transform active:scale-[0.98]">
                        Get Started Free
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                    <a href="#features"
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-4 bg-white hover:bg-gray-50 text-gray-800 font-bold rounded-xl border border-gray-200 shadow-sm transition-all active:scale-[0.98]">
                        Explore Features
                    </a>
                </div>

                <!-- Trust row -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <div class="flex -space-x-3">
                        <img class="w-9 h-9 rounded-full border-2 border-white object-cover shadow-sm bg-gray-200"
                            src="https://i.pravatar.cc/150?img=32" alt="Educator avatar">
                        <img class="w-9 h-9 rounded-full border-2 border-white object-cover shadow-sm bg-gray-200"
                            src="https://i.pravatar.cc/150?img=12" alt="Educator avatar">
                        <img class="w-9 h-9 rounded-full border-2 border-white object-cover shadow-sm bg-gray-200"
                            src="https://i.pravatar.cc/150?img=53" alt="Educator avatar">
                        <img class="w-9 h-9 rounded-full border-2 border-white object-cover shadow-sm bg-gray-200"
                            src="https://i.pravatar.cc/150?img=26" alt="Educator avatar">
                        <span
                            class="w-9 h-9 rounded-full border-2 border-white bg-[#0e48c1] text-white text-[10px] font-extrabold flex items-center justify-center shadow-sm">2k+</span>
                    </div>
                    <p class="text-sm font-semibold text-gray-500">
                        Trusted by <span class="text-gray-900 font-bold">2,000+ educators</span> & institutions
                    </p>
                </div>
            </div>

            <!-- Dashboard Mockup -->
            <div class="relative max-w-5xl mx-auto mt-16 lg:mt-20 reveal" style="transition-delay: 150ms">
                <!-- Glow -->
                <div
                    class="absolute inset-x-8 top-10 bottom-0 -z-10 bg-gradient-to-b from-[#0e48c1]/15 to-transparent blur-3xl rounded-full">
                </div>

                <!-- Floating card: notification (left) -->
                <div
                    class="hidden lg:flex animate-float-slow absolute -left-16 top-24 z-20 items-center gap-3 bg-white rounded-2xl border border-gray-100 shadow-[0_20px_50px_rgba(0,0,0,0.08)] p-4 pr-6">
                    <div
                        class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-[13px] font-bold text-gray-900 leading-tight">New feedback received</p>
                        <p class="text-xs text-gray-400 font-medium mt-0.5">Data Structures · just now</p>
                    </div>
                </div>

                <!-- Floating card: score chip (right) -->
                <div
                    class="hidden lg:flex animate-float-slower absolute -right-14 bottom-24 z-20 items-center gap-3 bg-white rounded-2xl border border-gray-100 shadow-[0_20px_50px_rgba(0,0,0,0.08)] p-4 pr-6">
                    <div class="relative w-11 h-11 flex-shrink-0">
                        <svg class="w-11 h-11 -rotate-90" viewBox="0 0 36 36">
                            <circle cx="18" cy="18" r="15.5" fill="none" stroke="#eef2f7" stroke-width="4" />
                            <circle cx="18" cy="18" r="15.5" fill="none" stroke="#0e48c1" stroke-width="4"
                                stroke-linecap="round" stroke-dasharray="87 97.4" />
                        </svg>
                        <span
                            class="absolute inset-0 flex items-center justify-center text-[10px] font-extrabold text-[#0e48c1]">92%</span>
                    </div>
                    <div>
                        <p class="text-[13px] font-bold text-gray-900 leading-tight">Satisfaction up</p>
                        <p class="text-xs text-emerald-500 font-bold mt-0.5 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7" />
                            </svg>
                            +12% this semester
                        </p>
                    </div>
                </div>

                <!-- App window -->
                <div
                    class="bg-white rounded-[2rem] border border-gray-200/80 shadow-[0_40px_90px_-20px_rgba(13,38,89,0.18)] overflow-hidden">
                    <!-- Window bar -->
                    <div class="flex items-center gap-3 px-5 py-3.5 border-b border-gray-100 bg-[#fafbfc]">
                        <div class="flex gap-1.5">
                            <span class="w-3 h-3 rounded-full bg-red-400"></span>
                            <span class="w-3 h-3 rounded-full bg-amber-400"></span>
                            <span class="w-3 h-3 rounded-full bg-emerald-400"></span>
                        </div>
                        <div
                            class="mx-auto flex items-center gap-2 bg-white border border-gray-100 rounded-lg px-4 py-1.5 text-xs font-semibold text-gray-400">
                            <svg class="w-3 h-3 text-emerald-500" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 1a5 5 0 00-5 5v3H6a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V11a2 2 0 00-2-2h-1V6a5 5 0 00-5-5zm-3 8V6a3 3 0 116 0v3H9z" />
                            </svg>
                            app.scholarmetric.edu/dashboard
                        </div>
                    </div>

                    <div class="grid grid-cols-12">
                        <!-- Mini sidebar -->
                        <div class="hidden md:flex col-span-1 flex-col items-center gap-2 py-6 border-r border-gray-100 bg-[#fafbfc]">
                            <div
                                class="w-9 h-9 rounded-xl bg-[#0e48c1] text-white flex items-center justify-center shadow-[0_6px_15px_rgba(14,72,193,0.3)]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h4v-6h4v6h4a1 1 0 001-1V10" />
                                </svg>
                            </div>
                            <div class="w-9 h-9 rounded-xl text-gray-300 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <div class="w-9 h-9 rounded-xl text-gray-300 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                            <div class="w-9 h-9 rounded-xl text-gray-300 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        </div>

                        <!-- Main panel -->
                        <div class="col-span-12 md:col-span-8 p-5 sm:p-7">
                            <div class="flex items-end justify-between mb-5">
                                <div>
                                    <p class="text-[11px] font-bold uppercase tracking-wider text-gray-400">Faculty
                                        Performance Overview</p>
                                    <h3 class="text-lg font-extrabold text-gray-900 mt-1">Spring Semester · 2026</h3>
                                </div>
                                <span
                                    class="hidden sm:inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-600 text-[11px] font-extrabold px-3 py-1.5 rounded-full">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Live
                                </span>
                            </div>

                            <!-- Stat cards -->
                            <div class="grid grid-cols-3 gap-3 mb-6">
                                <div class="rounded-2xl border border-gray-100 bg-[#f8fafc] p-4">
                                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wide">Avg. Rating</p>
                                    <p class="text-2xl font-extrabold text-gray-900 mt-1">4.7<span
                                            class="text-sm text-gray-400 font-bold">/5</span></p>
                                    <p class="text-[11px] font-bold text-emerald-500 mt-1">+0.4 vs last term</p>
                                </div>
                                <div class="rounded-2xl border border-gray-100 bg-[#f8fafc] p-4">
                                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wide">Responses</p>
                                    <p class="text-2xl font-extrabold text-gray-900 mt-1">1,284</p>
                                    <p class="text-[11px] font-bold text-[#0e48c1] mt-1">86% participation</p>
                                </div>
                                <div class="rounded-2xl border border-gray-100 bg-[#f8fafc] p-4">
                                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wide">Courses</p>
                                    <p class="text-2xl font-extrabold text-gray-900 mt-1">24</p>
                                    <p class="text-[11px] font-bold text-gray-400 mt-1">across 6 departments</p>
                                </div>
                            </div>

                            <!-- Rating bars -->
                            <div class="space-y-3.5">
                                <div>
                                    <div class="flex justify-between text-xs font-bold mb-1.5">
                                        <span class="text-gray-700">Teaching Clarity</span>
                                        <span class="text-[#0e48c1]">94%</span>
                                    </div>
                                    <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                                        <div class="h-full w-[94%] bg-gradient-to-r from-[#0e48c1] to-[#4f83f5] rounded-full">
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between text-xs font-bold mb-1.5">
                                        <span class="text-gray-700">Course Materials</span>
                                        <span class="text-[#0e48c1]">88%</span>
                                    </div>
                                    <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                                        <div class="h-full w-[88%] bg-gradient-to-r from-[#0e48c1] to-[#4f83f5] rounded-full">
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between text-xs font-bold mb-1.5">
                                        <span class="text-gray-700">Fair Assessment</span>
                                        <span class="text-[#0e48c1]">91%</span>
                                    </div>
                                    <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                                        <div class="h-full w-[91%] bg-gradient-to-r from-[#0e48c1] to-[#4f83f5] rounded-full">
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between text-xs font-bold mb-1.5">
                                        <span class="text-gray-700">Approachability</span>
                                        <span class="text-[#0e48c1]">96%</span>
                                    </div>
                                    <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                                        <div class="h-full w-[96%] bg-gradient-to-r from-[#0e48c1] to-[#4f83f5] rounded-full">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right panel -->
                        <div class="col-span-12 md:col-span-4 border-t md:border-t-0 md:border-l border-gray-100 p-5 sm:p-7 bg-[#fafbfc]">
                            <!-- Score ring -->
                            <div class="flex flex-col items-center py-2 mb-6">
                                <div class="relative w-32 h-32">
                                    <svg class="w-32 h-32 -rotate-90" viewBox="0 0 120 120">
                                        <circle cx="60" cy="60" r="52" fill="none" stroke="#eef2f7" stroke-width="10" />
                                        <circle cx="60" cy="60" r="52" fill="none" stroke="#0e48c1" stroke-width="10"
                                            stroke-linecap="round" stroke-dasharray="307 327" />
                                    </svg>
                                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                                        <span class="text-3xl font-extrabold text-gray-900 leading-none">4.7</span>
                                        <span class="text-[11px] font-bold text-gray-400 mt-1">out of 5.0</span>
                                    </div>
                                </div>
                                <p class="mt-3 text-xs font-bold text-gray-500">Overall Faculty Score</p>
                            </div>

                            <!-- Recent feedback -->
                            <p class="text-[11px] font-bold uppercase tracking-wider text-gray-400 mb-3">Recent
                                Feedback</p>
                            <div class="space-y-2.5">
                                <div
                                    class="flex items-start gap-2.5 bg-white border border-gray-100 rounded-xl p-3 shadow-sm">
                                    <div
                                        class="w-7 h-7 rounded-lg bg-blue-50 text-[#0e48c1] flex items-center justify-center text-[11px] font-extrabold flex-shrink-0">
                                        ★</div>
                                    <p class="text-xs text-gray-600 font-medium leading-snug">"Explains complex topics
                                        with real-world examples."</p>
                                </div>
                                <div
                                    class="flex items-start gap-2.5 bg-white border border-gray-100 rounded-xl p-3 shadow-sm">
                                    <div
                                        class="w-7 h-7 rounded-lg bg-blue-50 text-[#0e48c1] flex items-center justify-center text-[11px] font-extrabold flex-shrink-0">
                                        ★</div>
                                    <p class="text-xs text-gray-600 font-medium leading-snug">"Assignments are fair and
                                        genuinely helpful."</p>
                                </div>
                                <div
                                    class="flex items-start gap-2.5 bg-white border border-gray-100 rounded-xl p-3 shadow-sm opacity-70">
                                    <div
                                        class="w-7 h-7 rounded-lg bg-gray-100 text-gray-400 flex items-center justify-center text-[11px] font-extrabold flex-shrink-0">
                                        ★</div>
                                    <p class="text-xs text-gray-500 font-medium leading-snug">"More practice sessions
                                        would be great."</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== STATS STRIP ==================== -->
    <section class="border-y border-gray-100 bg-white/70 backdrop-blur">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
            <dl class="grid grid-cols-2 lg:grid-cols-4 gap-x-6 gap-y-10 text-center">
                <div class="reveal">
                    <dt class="order-2 mt-2 text-sm font-bold uppercase tracking-wider text-gray-400">Active Educators
                    </dt>
                    <dd class="order-1 text-4xl lg:text-5xl font-extrabold text-gray-900 tracking-tight">2,000+</dd>
                </div>
                <div class="reveal" style="transition-delay: 100ms">
                    <dt class="order-2 mt-2 text-sm font-bold uppercase tracking-wider text-gray-400">Evaluations
                        Processed</dt>
                    <dd class="order-1 text-4xl lg:text-5xl font-extrabold text-gray-900 tracking-tight">58k+</dd>
                </div>
                <div class="reveal" style="transition-delay: 200ms">
                    <dt class="order-2 mt-2 text-sm font-bold uppercase tracking-wider text-gray-400">Departments</dt>
                    <dd class="order-1 text-4xl lg:text-5xl font-extrabold text-gray-900 tracking-tight">120+</dd>
                </div>
                <div class="reveal" style="transition-delay: 300ms">
                    <dt class="order-2 mt-2 text-sm font-bold uppercase tracking-wider text-gray-400">Satisfaction Rate
                    </dt>
                    <dd class="order-1 text-4xl lg:text-5xl font-extrabold text-[#0e48c1] tracking-tight">96%</dd>
                </div>
            </dl>
        </div>
    </section>

    <!-- ==================== FEATURES ==================== -->
    <section id="features" class="py-20 lg:py-28 relative overflow-hidden">
        <div class="absolute top-1/3 -right-52 -z-10 w-[500px] h-[500px] rounded-full bg-[radial-gradient(circle_at_center,_rgba(14,72,193,0.06),_transparent_65%)]">
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-2xl mx-auto text-center mb-14 lg:mb-20 reveal">
                <p class="text-sm font-extrabold uppercase tracking-[0.2em] text-[#0e48c1] mb-3">Features</p>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-gray-900 mb-5">
                    Everything your institution needs to listen & improve
                </h2>
                <p class="text-lg text-gray-500 font-medium leading-relaxed">
                    One connected platform for evaluations — built for administrators, embraced by faculty, and trusted
                    by students.
                </p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5 lg:gap-7">
                <!-- Feature 1 -->
                <div
                    class="reveal group bg-white rounded-[2rem] border border-gray-100 p-8 shadow-[0_10px_35px_rgba(0,0,0,0.04)] hover:shadow-[0_25px_50px_rgba(14,72,193,0.10)] hover:-translate-y-1.5 hover:border-blue-100 transition-all duration-300">
                    <div
                        class="w-[52px] h-[52px] rounded-2xl bg-[#0e48c1]/10 text-[#0e48c1] flex items-center justify-center mb-6 group-hover:bg-[#0e48c1] group-hover:text-white group-hover:shadow-[0_8px_20px_rgba(14,72,193,0.3)] transition-all duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-extrabold text-gray-900 mb-2.5">Anonymous Feedback</h3>
                    <p class="text-[15px] text-gray-500 font-medium leading-relaxed">
                        Students share honest, identity-protected course reviews — so the signal is real, not filtered
                        by fear.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div
                    class="reveal group bg-white rounded-[2rem] border border-gray-100 p-8 shadow-[0_10px_35px_rgba(0,0,0,0.04)] hover:shadow-[0_25px_50px_rgba(14,72,193,0.10)] hover:-translate-y-1.5 hover:border-blue-100 transition-all duration-300"
                    style="transition-delay: 100ms">
                    <div
                        class="w-[52px] h-[52px] rounded-2xl bg-[#0e48c1]/10 text-[#0e48c1] flex items-center justify-center mb-6 group-hover:bg-[#0e48c1] group-hover:text-white group-hover:shadow-[0_8px_20px_rgba(14,72,193,0.3)] transition-all duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-extrabold text-gray-900 mb-2.5">Real-time Analytics</h3>
                    <p class="text-[15px] text-gray-500 font-medium leading-relaxed">
                        Live dashboards turn every submission into trends, ratings, and comparisons the moment they
                        arrive.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div
                    class="reveal group bg-white rounded-[2rem] border border-gray-100 p-8 shadow-[0_10px_35px_rgba(0,0,0,0.04)] hover:shadow-[0_25px_50px_rgba(14,72,193,0.10)] hover:-translate-y-1.5 hover:border-blue-100 transition-all duration-300"
                    style="transition-delay: 200ms">
                    <div
                        class="w-[52px] h-[52px] rounded-2xl bg-[#0e48c1]/10 text-[#0e48c1] flex items-center justify-center mb-6 group-hover:bg-[#0e48c1] group-hover:text-white group-hover:shadow-[0_8px_20px_rgba(14,72,193,0.3)] transition-all duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-extrabold text-gray-900 mb-2.5">Course Management</h3>
                    <p class="text-[15px] text-gray-500 font-medium leading-relaxed">
                        Organize departments, courses, enrollments, and assignments in a clean, structured catalog.
                    </p>
                </div>

                <!-- Feature 4 -->
                <div
                    class="reveal group bg-white rounded-[2rem] border border-gray-100 p-8 shadow-[0_10px_35px_rgba(0,0,0,0.04)] hover:shadow-[0_25px_50px_rgba(14,72,193,0.10)] hover:-translate-y-1.5 hover:border-blue-100 transition-all duration-300">
                    <div
                        class="w-[52px] h-[52px] rounded-2xl bg-[#0e48c1]/10 text-[#0e48c1] flex items-center justify-center mb-6 group-hover:bg-[#0e48c1] group-hover:text-white group-hover:shadow-[0_8px_20px_rgba(14,72,193,0.3)] transition-all duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-extrabold text-gray-900 mb-2.5">Guided Evaluation Workflows</h3>
                    <p class="text-[15px] text-gray-500 font-medium leading-relaxed">
                        Step-by-step evaluation builders let admins launch structured review cycles in minutes.
                    </p>
                </div>

                <!-- Feature 5 -->
                <div
                    class="reveal group bg-white rounded-[2rem] border border-gray-100 p-8 shadow-[0_10px_35px_rgba(0,0,0,0.04)] hover:shadow-[0_25px_50px_rgba(14,72,193,0.10)] hover:-translate-y-1.5 hover:border-blue-100 transition-all duration-300"
                    style="transition-delay: 100ms">
                    <div
                        class="w-[52px] h-[52px] rounded-2xl bg-[#0e48c1]/10 text-[#0e48c1] flex items-center justify-center mb-6 group-hover:bg-[#0e48c1] group-hover:text-white group-hover:shadow-[0_8px_20px_rgba(14,72,193,0.3)] transition-all duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-extrabold text-gray-900 mb-2.5">Reports & Exports</h3>
                    <p class="text-[15px] text-gray-500 font-medium leading-relaxed">
                        Generate polished summaries and export to PDF or print-ready formats for committees and
                        accreditation.
                    </p>
                </div>

                <!-- Feature 6 -->
                <div
                    class="reveal group bg-white rounded-[2rem] border border-gray-100 p-8 shadow-[0_10px_35px_rgba(0,0,0,0.04)] hover:shadow-[0_25px_50px_rgba(14,72,193,0.10)] hover:-translate-y-1.5 hover:border-blue-100 transition-all duration-300"
                    style="transition-delay: 200ms">
                    <div
                        class="w-[52px] h-[52px] rounded-2xl bg-[#0e48c1]/10 text-[#0e48c1] flex items-center justify-center mb-6 group-hover:bg-[#0e48c1] group-hover:text-white group-hover:shadow-[0_8px_20px_rgba(14,72,193,0.3)] transition-all duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-extrabold text-gray-900 mb-2.5">Role-based Access</h3>
                    <p class="text-[15px] text-gray-500 font-medium leading-relaxed">
                        Tailored dashboards for admins, faculty, and students — everyone sees exactly what matters to
                        them.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== HOW IT WORKS ==================== -->
    <section id="how-it-works" class="py-20 lg:py-28 bg-[#f4f6f8]/70 relative overflow-hidden">
        <div
            class="absolute -bottom-40 left-1/2 -translate-x-1/2 -z-0 w-[700px] h-[500px] rounded-full bg-[radial-gradient(ellipse_at_center,_rgba(255,255,255,0.9),_transparent_70%)]">
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="max-w-2xl mx-auto text-center mb-14 lg:mb-20 reveal">
                <p class="text-sm font-extrabold uppercase tracking-[0.2em] text-[#0e48c1] mb-3">How it works</p>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-gray-900 mb-5">
                    From questions to insights in three steps
                </h2>
                <p class="text-lg text-gray-500 font-medium leading-relaxed">
                    A simple loop that keeps quality rising semester after semester.
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-6 lg:gap-10 relative">
                <!-- Connector line -->
                <div class="hidden md:block absolute top-[52px] left-[16%] right-[16%] border-t-2 border-dashed border-blue-200">
                </div>

                <!-- Step 1 -->
                <div class="reveal relative text-center px-4">
                    <div
                        class="relative z-10 w-[104px] h-[104px] mx-auto mb-7 rounded-[2rem] bg-white border border-blue-100 shadow-[0_15px_35px_rgba(14,72,193,0.12)] flex items-center justify-center rotate-3">
                        <div
                            class="w-[76px] h-[76px] rounded-3xl bg-gradient-to-br from-[#0e48c1] to-[#4f83f5] flex items-center justify-center text-white shadow-inner -rotate-3">
                            <svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>
                        <span
                            class="absolute -top-2.5 -right-2.5 w-8 h-8 rounded-full bg-white border border-blue-100 shadow-sm flex items-center justify-center text-[13px] font-extrabold text-[#0e48c1] rotate-6">1</span>
                    </div>
                    <span
                        class="inline-block bg-[#0e48c1]/10 text-[#0e48c1] text-[11px] font-extrabold uppercase tracking-wider px-3 py-1 rounded-full mb-3">Admin</span>
                    <h3 class="text-xl font-extrabold text-gray-900 mb-3">Create an Evaluation</h3>
                    <p class="text-[15px] text-gray-500 font-medium leading-relaxed max-w-xs mx-auto">
                        Admins build a guided evaluation in three quick steps — pick courses, set criteria, publish.
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="reveal relative text-center px-4" style="transition-delay: 150ms">
                    <div
                        class="relative z-10 w-[104px] h-[104px] mx-auto mb-7 rounded-[2rem] bg-white border border-blue-100 shadow-[0_15px_35px_rgba(14,72,193,0.12)] flex items-center justify-center -rotate-2">
                        <div
                            class="w-[76px] h-[76px] rounded-3xl bg-gradient-to-br from-[#0e48c1] to-[#4f83f5] flex items-center justify-center text-white shadow-inner rotate-2">
                            <svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                            </svg>
                        </div>
                        <span
                            class="absolute -top-2.5 -right-2.5 w-8 h-8 rounded-full bg-white border border-blue-100 shadow-sm flex items-center justify-center text-[13px] font-extrabold text-[#0e48c1] rotate-6">2</span>
                    </div>
                    <span
                        class="inline-block bg-[#0e48c1]/10 text-[#0e48c1] text-[11px] font-extrabold uppercase tracking-wider px-3 py-1 rounded-full mb-3">Student</span>
                    <h3 class="text-xl font-extrabold text-gray-900 mb-3">Submit Honest Feedback</h3>
                    <p class="text-[15px] text-gray-500 font-medium leading-relaxed max-w-xs mx-auto">
                        Students rate courses and write anonymous reviews through a fast, friendly interface.
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="reveal relative text-center px-4" style="transition-delay: 300ms">
                    <div
                        class="relative z-10 w-[104px] h-[104px] mx-auto mb-7 rounded-[2rem] bg-white border border-blue-100 shadow-[0_15px_35px_rgba(14,72,193,0.12)] flex items-center justify-center rotate-2">
                        <div
                            class="w-[76px] h-[76px] rounded-3xl bg-gradient-to-br from-[#0e48c1] to-[#4f83f5] flex items-center justify-center text-white shadow-inner -rotate-2">
                            <svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </div>
                        <span
                            class="absolute -top-2.5 -right-2.5 w-8 h-8 rounded-full bg-white border border-blue-100 shadow-sm flex items-center justify-center text-[13px] font-extrabold text-[#0e48c1] rotate-6">3</span>
                    </div>
                    <span
                        class="inline-block bg-[#0e48c1]/10 text-[#0e48c1] text-[11px] font-extrabold uppercase tracking-wider px-3 py-1 rounded-full mb-3">Faculty</span>
                    <h3 class="text-xl font-extrabold text-gray-900 mb-3">Act on Insights</h3>
                    <p class="text-[15px] text-gray-500 font-medium leading-relaxed max-w-xs mx-auto">
                        Faculty unlock analytics and trend reports that highlight strengths and where to grow next.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== TESTIMONIALS ==================== -->
    <section id="testimonials" class="py-20 lg:py-28">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-2xl mx-auto text-center mb-14 lg:mb-20 reveal">
                <p class="text-sm font-extrabold uppercase tracking-[0.2em] text-[#0e48c1] mb-3">Testimonials</p>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-gray-900 mb-5">
                    Loved by campuses everywhere
                </h2>
                <p class="text-lg text-gray-500 font-medium leading-relaxed">
                    Hear from the educators and administrators who made feedback their superpower.
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-5 lg:gap-7">
                <!-- T1 -->
                <figure
                    class="reveal bg-white rounded-[2rem] border border-gray-100 p-8 shadow-[0_10px_35px_rgba(0,0,0,0.04)] flex flex-col">
                    <div class="flex gap-1 text-amber-400 mb-5" aria-label="5 out of 5 stars">
                        @foreach ([1, 2, 3, 4, 5] as $star)
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2l2.94 6.26 6.86.63-5.18 4.55 1.53 6.72L12 16.67l-6.15 3.49 1.53-6.72L2.2 8.89l6.86-.63L12 2z" />
                            </svg>
                        @endforeach
                    </div>
                    <blockquote class="text-[15px] text-gray-600 font-medium leading-relaxed flex-1">
                        "Scholar Metric replaced our messy paper forms entirely. The analytics showed us exactly which
                        departments needed support — within one semester."
                    </blockquote>
                    <figcaption class="flex items-center gap-3 mt-7 pt-6 border-t border-gray-100">
                        <img class="w-11 h-11 rounded-full object-cover border-2 border-white shadow-md bg-gray-200"
                            src="https://i.pravatar.cc/150?img=32" alt="Portrait of Dr. Sarah Mitchell">
                        <div>
                            <p class="text-sm font-extrabold text-gray-900">Dr. Sarah Mitchell</p>
                            <p class="text-xs font-semibold text-gray-400">Dean of Engineering · Northfield University
                            </p>
                        </div>
                    </figcaption>
                </figure>

                <!-- T2 -->
                <figure
                    class="reveal bg-white rounded-[2rem] border border-gray-100 p-8 shadow-[0_10px_35px_rgba(0,0,0,0.04)] flex flex-col"
                    style="transition-delay: 100ms">
                    <div class="flex gap-1 text-amber-400 mb-5" aria-label="5 out of 5 stars">
                        @foreach ([1, 2, 3, 4, 5] as $star)
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2l2.94 6.26 6.86.63-5.18 4.55 1.53 6.72L12 16.67l-6.15 3.49 1.53-6.72L2.2 8.89l6.86-.63L12 2z" />
                            </svg>
                        @endforeach
                    </div>
                    <blockquote class="text-[15px] text-gray-600 font-medium leading-relaxed flex-1">
                        "The anonymous feedback gave my students a genuine voice. Seeing my ratings trend upward each
                        month has been incredibly motivating."
                    </blockquote>
                    <figcaption class="flex items-center gap-3 mt-7 pt-6 border-t border-gray-100">
                        <img class="w-11 h-11 rounded-full object-cover border-2 border-white shadow-md bg-gray-200"
                            src="https://i.pravatar.cc/150?img=12" alt="Portrait of Prof. James Okafor">
                        <div>
                            <p class="text-sm font-extrabold text-gray-900">Prof. James Okafor</p>
                            <p class="text-xs font-semibold text-gray-400">Senior Lecturer · Computer Science</p>
                        </div>
                    </figcaption>
                </figure>

                <!-- T3 -->
                <figure
                    class="reveal bg-white rounded-[2rem] border border-gray-100 p-8 shadow-[0_10px_35px_rgba(0,0,0,0.04)] flex flex-col"
                    style="transition-delay: 200ms">
                    <div class="flex gap-1 text-amber-400 mb-5" aria-label="5 out of 5 stars">
                        @foreach ([1, 2, 3, 4, 5] as $star)
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2l2.94 6.26 6.86.63-5.18 4.55 1.53 6.72L12 16.67l-6.15 3.49 1.53-6.72L2.2 8.89l6.86-.63L12 2z" />
                            </svg>
                        @endforeach
                    </div>
                    <blockquote class="text-[15px] text-gray-600 font-medium leading-relaxed flex-1">
                        "Setup took an afternoon. Exporting accreditation-ready reports used to take weeks — now it's
                        literally one click before a board meeting."
                    </blockquote>
                    <figcaption class="flex items-center gap-3 mt-7 pt-6 border-t border-gray-100">
                        <img class="w-11 h-11 rounded-full object-cover border-2 border-white shadow-md bg-gray-200"
                            src="https://i.pravatar.cc/150?img=47" alt="Portrait of Dr. Elena Vasquez">
                        <div>
                            <p class="text-sm font-extrabold text-gray-900">Dr. Elena Vasquez</p>
                            <p class="text-xs font-semibold text-gray-400">Academic Director · Crestwood College</p>
                        </div>
                    </figcaption>
                </figure>
            </div>
        </div>
    </section>

    <!-- ==================== CTA ==================== -->
    <section class="pb-24 lg:pb-32 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto reveal">
            <div
                class="relative overflow-hidden rounded-[2.5rem] bg-gradient-to-br from-[#0e48c1] via-[#1257d8] to-[#0c3ca1] px-6 py-16 sm:px-12 lg:px-20 lg:py-20 text-center shadow-[0_35px_80px_-15px_rgba(14,72,193,0.45)]">
                <!-- Decorative blobs -->
                <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full bg-white/10 blur-3xl pointer-events-none">
                </div>
                <div
                    class="absolute -bottom-32 -left-20 w-[420px] h-[420px] rounded-full bg-white/10 blur-3xl pointer-events-none">
                </div>
                <div
                    class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[400px] bg-[radial-gradient(ellipse_at_center,_rgba(255,255,255,0.08),_transparent_70%)] pointer-events-none">
                </div>

                <div class="relative z-10">
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-white mb-5">
                        Ready to elevate your institution?
                    </h2>
                    <p class="text-lg text-blue-100 font-medium leading-relaxed max-w-2xl mx-auto mb-10">
                        Join thousands of educators turning honest feedback into measurable academic excellence. Set up
                        takes less than five minutes.
                    </p>
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                        <a href="{{ route('register') }}"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-4 bg-white text-[#0e48c1] font-extrabold rounded-xl shadow-[0_10px_30px_rgba(0,0,0,0.15)] hover:bg-blue-50 transition-all active:scale-[0.98]">
                            Create Free Account
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                        <a href="{{ route('login') }}"
                            class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-4 border-2 border-white/40 hover:border-white/70 hover:bg-white/10 text-white font-bold rounded-xl transition-all active:scale-[0.98]">
                            Sign In
                        </a>
                    </div>
                    <p class="mt-7 text-sm font-semibold text-blue-200/80">
                        No credit card required · Cancel anytime
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== FOOTER ==================== -->
    <footer class="border-t border-gray-100 bg-[#f4f6f8]/60">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 lg:py-16">
            <div class="grid gap-10 lg:grid-cols-12">
                <!-- Brand -->
                <div class="lg:col-span-5">
                    <a href="{{ route('landing') }}" class="flex items-center gap-3 mb-5">
                        <div class="w-10 h-10 bg-[#0e48c1] rounded-xl flex items-center justify-center text-white shadow-[0_8px_20px_rgba(14,72,193,0.25)]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M12 3L1 9L5 11.18V17.18L12 21L19 17.18V11.18L21 10.09V17H23V9L12 3ZM18.82 9L12 12.72L5.18 9L12 5.28L18.82 9ZM17 15.99L12 18.72L7 15.99V12.27L12 15L17 12.27V15.99Z" />
                            </svg>
                        </div>
                        <span class="font-bold text-xl tracking-tight text-gray-900">Scholar <span
                                class="text-[#0e48c1]">Metric</span></span>
                    </a>
                    <p class="text-[15px] text-gray-500 font-medium leading-relaxed max-w-sm mb-6">
                        A sophisticated evaluation ecosystem designed for modern institutions and dedicated faculty.
                    </p>
                    <div class="flex -space-x-3">
                        <img class="w-9 h-9 rounded-full border-2 border-white object-cover shadow-sm bg-gray-200"
                            src="https://i.pravatar.cc/150?img=11" alt="Community member">
                        <img class="w-9 h-9 rounded-full border-2 border-white object-cover shadow-sm bg-gray-200"
                            src="https://i.pravatar.cc/150?img=12" alt="Community member">
                        <img class="w-9 h-9 rounded-full border-2 border-white object-cover shadow-sm bg-gray-200"
                            src="https://i.pravatar.cc/150?img=13" alt="Community member">
                    </div>
                </div>

                <!-- Links -->
                <div class="lg:col-span-7 grid grid-cols-2 sm:grid-cols-3 gap-8">
                    <div>
                        <h4 class="text-sm font-extrabold uppercase tracking-wider text-gray-900 mb-4">Product</h4>
                        <ul class="space-y-3 text-[15px] font-medium text-gray-500">
                            <li><a href="#features" class="hover:text-[#0e48c1] transition-colors">Features</a></li>
                            <li><a href="#how-it-works" class="hover:text-[#0e48c1] transition-colors">How it works</a>
                            </li>
                            <li><a href="#testimonials" class="hover:text-[#0e48c1] transition-colors">Testimonials</a>
                            </li>
                            <li><a href="{{ route('register') }}" class="hover:text-[#0e48c1] transition-colors">Get
                                    started</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-sm font-extrabold uppercase tracking-wider text-gray-900 mb-4">Roles</h4>
                        <ul class="space-y-3 text-[15px] font-medium text-gray-500">
                            <li><a href="{{ route('login') }}" class="hover:text-[#0e48c1] transition-colors">Admin
                                    portal</a></li>
                            <li><a href="{{ route('login') }}" class="hover:text-[#0e48c1] transition-colors">Faculty
                                    portal</a></li>
                            <li><a href="{{ route('login') }}" class="hover:text-[#0e48c1] transition-colors">Student
                                    portal</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-sm font-extrabold uppercase tracking-wider text-gray-900 mb-4">Support</h4>
                        <ul class="space-y-3 text-[15px] font-medium text-gray-500">
                            <li><a href="#" class="hover:text-[#0e48c1] transition-colors">Privacy Policy</a></li>
                            <li><a href="#" class="hover:text-[#0e48c1] transition-colors">System Status</a></li>
                            <li><a href="#" class="hover:text-[#0e48c1] transition-colors">Contact</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div
                class="mt-12 pt-8 border-t border-gray-200/70 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-[13px] font-semibold text-gray-400 text-center sm:text-left">
                    © {{ date('Y') }} Scholar Metric Academic Systems. All rights reserved.
                </p>
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span class="text-[13px] font-semibold text-gray-400">All systems operational</span>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Navbar background on scroll
        (function () {
            const navbar = document.getElementById('navbar');
            const onScroll = () => {
                if (window.scrollY > 24) {
                    navbar.classList.add('bg-white/85', 'backdrop-blur-md', 'shadow-[0_10px_35px_rgba(0,0,0,0.06)]', 'border-gray-100');
                } else {
                    navbar.classList.remove('bg-white/85', 'backdrop-blur-md', 'shadow-[0_10px_35px_rgba(0,0,0,0.06)]', 'border-gray-100');
                }
            };
            window.addEventListener('scroll', onScroll, { passive: true });
            onScroll();
        })();

        // Mobile menu
        (function () {
            const btn = document.getElementById('mobile-menu-btn');
            const menu = document.getElementById('mobile-menu');
            const iconOpen = document.getElementById('icon-open');
            const iconClose = document.getElementById('icon-close');

            const setOpen = (open) => {
                menu.classList.toggle('hidden', !open);
                iconOpen.classList.toggle('hidden', open);
                iconClose.classList.toggle('hidden', !open);
                btn.setAttribute('aria-expanded', String(open));
            };

            btn.addEventListener('click', () => setOpen(menu.classList.contains('hidden')));
            menu.querySelectorAll('.mobile-link').forEach(link =>
                link.addEventListener('click', () => setOpen(false))
            );
        })();

        // Scroll reveal
        (function () {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('revealed');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

            document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
        })();
    </script>
</x-layout>
