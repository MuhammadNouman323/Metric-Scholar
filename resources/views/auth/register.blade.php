<x-layout>
    <style>
        html, body { overflow-x: clip; }

        @keyframes gradient-shift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        .gradient-text {
            background: linear-gradient(135deg, #0e48c1, #4f83f5, #0e48c1);
            background-size: 200% 200%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gradient-shift 4s ease infinite;
        }

        @keyframes float-slower {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(10px) rotate(-1deg); }
        }
        .animate-float-slower { animation: float-slower 7s ease-in-out infinite; }

        @keyframes glow-pulse {
            0%, 100% { opacity: 0.4; transform: scale(1); }
            50% { opacity: 0.7; transform: scale(1.05); }
        }
        .animate-glow { animation: glow-pulse 3s ease-in-out infinite; }

        @keyframes spin-slow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .animate-spin-slow { animation: spin-slow 20s linear infinite; }

        @keyframes drift-1 {
            0%, 100% { transform: translate(0, 0) scale(1); opacity: 0.5; }
            25% { transform: translate(20px, -30px) scale(1.1); opacity: 0.7; }
            50% { transform: translate(-15px, -60px) scale(0.9); opacity: 0.4; }
            75% { transform: translate(30px, -20px) scale(1.05); opacity: 0.6; }
        }
        @keyframes drift-2 {
            0%, 100% { transform: translate(0, 0) scale(1); opacity: 0.4; }
            33% { transform: translate(-30px, -40px) scale(1.15); opacity: 0.6; }
            66% { transform: translate(15px, -70px) scale(0.85); opacity: 0.3; }
        }
        @keyframes drift-3 {
            0%, 100% { transform: translate(0, 0); opacity: 0.3; }
            50% { transform: translate(40px, -50px); opacity: 0.6; }
        }
        .particle-1 { animation: drift-1 8s ease-in-out infinite; }
        .particle-2 { animation: drift-2 10s ease-in-out infinite; }
        .particle-3 { animation: drift-3 12s ease-in-out infinite; }
        .particle { position: absolute; border-radius: 50%; pointer-events: none; }

        @keyframes geo-float-1 {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            25% { transform: translate(10px, -18px) rotate(90deg); }
            50% { transform: translate(-8px, -35px) rotate(180deg); }
            75% { transform: translate(15px, -15px) rotate(270deg); }
        }
        @keyframes geo-float-2 {
            0%, 100% { transform: translate(0, 0) rotate(0deg) scale(1); }
            50% { transform: translate(-20px, -30px) rotate(180deg) scale(1.1); }
        }
        .geo-shape-1 { animation: geo-float-1 12s ease-in-out infinite; }
        .geo-shape-2 { animation: geo-float-2 15s ease-in-out infinite; }

        .glass-card {
            background: rgba(255, 255, 255, 0.65);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        .premium-border { position: relative; }
        .premium-border::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: inherit;
            padding: 1px;
            background: linear-gradient(135deg, rgba(14,72,193,0.3), rgba(79,131,245,0.1), rgba(14,72,193,0.3));
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            pointer-events: none;
        }

        .btn-shine { position: relative; overflow: hidden; }
        .btn-shine::after {
            content: '';
            position: absolute;
            top: -50%; left: -50%;
            width: 200%; height: 200%;
            background: linear-gradient(to right, transparent 0%, rgba(255,255,255,0.1) 45%, rgba(255,255,255,0.3) 50%, rgba(255,255,255,0.1) 55%, transparent 100%);
            transform: rotate(25deg) translateX(-150%);
            transition: transform 0.6s ease;
        }
        .btn-shine:hover::after { transform: rotate(25deg) translateX(150%); }

        .magnetic-btn { transition: transform 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94); }

        .input-glow { transition: all 0.3s ease; }
        .input-glow:focus { box-shadow: 0 0 0 3px rgba(14,72,193,0.1), 0 0 20px rgba(14,72,193,0.05); }

        .premium-checkbox {
            appearance: none;
            -webkit-appearance: none;
            width: 18px; height: 18px;
            border: 2px solid #d1d5db;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
            flex-shrink: 0;
        }
        .premium-checkbox:checked {
            background: linear-gradient(135deg, #0e48c1, #4f83f5);
            border-color: #0e48c1;
            box-shadow: 0 2px 8px rgba(14,72,193,0.3);
        }
        .premium-checkbox:checked::after {
            content: '';
            position: absolute;
            left: 4px; top: 1px;
            width: 5px; height: 10px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }
        .premium-checkbox:hover { border-color: #0e48c1; }

        @keyframes card-enter {
            from { opacity: 0; transform: translateY(20px) scale(0.98); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
        .card-enter { animation: card-enter 0.8s cubic-bezier(0.22, 1, 0.36, 1) forwards; }
        .card-enter-delay { animation-delay: 0.15s; opacity: 0; }

        @keyframes mesh-move {
            0%, 100% { transform: translate(0, 0) scale(1); }
            25% { transform: translate(20px, -15px) scale(1.05); }
            50% { transform: translate(-15px, 10px) scale(0.95); }
            75% { transform: translate(10px, 18px) scale(1.02); }
        }
        .mesh-blob { position: absolute; border-radius: 50%; filter: blur(60px); pointer-events: none; }
        .mesh-blob-1 { animation: mesh-move 20s ease-in-out infinite; }
        .mesh-blob-2 { animation: mesh-move 25s ease-in-out infinite reverse; }

        @keyframes float-card {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-6px); }
        }
    </style>

    <div class="min-h-screen bg-gradient-to-br from-[#f0f4ff] via-[#f8fafc] to-white flex flex-col justify-center items-center p-4 sm:p-6 lg:p-8 relative overflow-hidden">
        <!-- Background Decorations -->
        <div class="absolute -top-40 -right-40 w-[600px] h-[600px] rounded-full bg-[radial-gradient(circle_at_center,_rgba(14,72,193,0.08),_transparent_60%)] animate-glow"></div>
        <div class="absolute -bottom-40 -left-40 w-[500px] h-[500px] rounded-full bg-[radial-gradient(circle_at_center,_rgba(79,131,245,0.06),_transparent_60%)]"></div>
        <div class="mesh-blob mesh-blob-1 w-80 h-80 bg-[#0e48c1]/[0.04] top-10 left-10"></div>
        <div class="mesh-blob mesh-blob-2 w-64 h-64 bg-[#4f83f5]/[0.03] bottom-20 right-20"></div>

        <!-- Floating Particles -->
        <div class="particle particle-1 w-2 h-2 bg-[#0e48c1]/15 top-20 left-[10%]"></div>
        <div class="particle particle-2 w-3 h-3 bg-[#4f83f5]/10 top-32 right-[15%]"></div>
        <div class="particle particle-3 w-1.5 h-1.5 bg-[#0e48c1]/20 bottom-32 left-[20%]"></div>
        <div class="particle particle-1 w-2 h-2 bg-[#4f83f5]/10 bottom-20 right-[25%]" style="animation-delay: 2s"></div>
        <div class="particle particle-2 w-2.5 h-2.5 bg-[#0e48c1]/10 top-[40%] left-[5%]" style="animation-delay: 3s"></div>

        <!-- Floating Geometric Shapes -->
        <svg class="geo-shape-1 absolute top-16 left-[8%] w-12 h-12 text-[#0e48c1]/[0.06]" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5">
            <rect x="6" y="6" width="36" height="36" rx="6"/>
        </svg>
        <svg class="geo-shape-2 absolute top-24 right-[12%] w-10 h-10 text-[#4f83f5]/[0.05]" viewBox="0 0 40 40" fill="none" stroke="currentColor" stroke-width="1.5">
            <polygon points="20,2 38,32 2,32"/>
        </svg>
        <svg class="geo-shape-1 absolute bottom-24 left-[12%] w-8 h-8 text-[#0e48c1]/[0.05]" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="1.5" style="animation-delay: -4s">
            <circle cx="16" cy="16" r="12"/>
        </svg>
        <svg class="geo-shape-2 absolute bottom-16 right-[10%] w-10 h-10 text-[#4f83f5]/[0.05]" viewBox="0 0 40 40" fill="none" stroke="currentColor" stroke-width="1.5" style="animation-delay: -7s">
            <path d="M20 2L38 20L20 38L2 20Z"/>
        </svg>

        <!-- Main Card Container -->
        <div class="w-full max-w-6xl bg-white/80 backdrop-blur-xl rounded-[2.5rem] shadow-[0_25px_60px_rgba(0,0,0,0.06)] overflow-hidden flex flex-col lg:flex-row min-h-[700px] border border-white/60 card-enter relative">

            <!-- Left Side -->
            <div class="relative w-full lg:w-[45%] bg-gradient-to-br from-[#0e48c1] via-[#1257d8] to-[#0c3ca1] p-10 lg:p-14 flex flex-col justify-between overflow-hidden text-white">
                <!-- Decorative blobs -->
                <div class="absolute -top-32 -right-32 w-96 h-96 rounded-full bg-white/10 blur-3xl animate-glow"></div>
                <div class="absolute -bottom-48 left-1/2 -translate-x-1/2 w-[500px] h-[500px] rounded-full bg-white/5 blur-3xl"></div>

                <!-- Grid pattern -->
                <div class="absolute inset-0 opacity-[0.04] pointer-events-none" style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cpath d=&quot;M0 0h60v60H0z&quot; fill=&quot;none&quot;/%3E%3Cpath d=&quot;M60 0v60M0 0h60&quot; stroke=&quot;white&quot; stroke-width=&quot;0.5&quot;/%3E%3C/svg%3E')"></div>

                <!-- Floating particles -->
                <div class="particle particle-1 w-3 h-3 bg-white/10 top-20 left-[20%]"></div>
                <div class="particle particle-2 w-2 h-2 bg-white/10 top-40 right-[25%]"></div>
                <div class="particle particle-3 w-2.5 h-2.5 bg-white/5 bottom-32 left-[30%]"></div>

                <!-- Rotating rings -->
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[350px] h-[350px] border border-white/[0.08] rounded-full animate-spin-slow"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[280px] h-[280px] border border-white/[0.05] rounded-full animate-spin-slow" style="animation-direction: reverse; animation-duration: 25s"></div>

                <div class="relative z-10 flex flex-col h-full items-start">
                    <!-- Logo -->
                    <a href="{{ route('landing') }}" class="flex items-center gap-3 mb-12 lg:mb-20 group">
                        <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-[#0e48c1] flex-shrink-0 shadow-[0_4px_15px_rgba(0,0,0,0.2)] group-hover:shadow-[0_6px_20px_rgba(0,0,0,0.3)] group-hover:scale-105 transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 3L1 9L5 11.18V17.18L12 21L19 17.18V11.18L21 10.09V17H23V9L12 3ZM18.82 9L12 12.72L5.18 9L12 5.28L18.82 9ZM17 15.99L12 18.72L7 15.99V12.27L12 15L17 12.27V15.99Z"/>
                            </svg>
                        </div>
                        <span class="font-bold text-xl tracking-tight">Scholar Metric</span>
                    </a>

                    <!-- Heading -->
                    <div class="max-w-[420px]">
                        <h1 class="text-3xl sm:text-4xl lg:text-[44px] font-bold leading-[1.2] mb-6 tracking-tight">
                            Institutional<br />
                            Excellence<br />
                            through<br />
                            <span class="text-blue-200">Administrative</span><br />
                            <span class="text-blue-200">Precision.</span>
                        </h1>
                        <p class="text-blue-100/80 text-base sm:text-[17px] leading-relaxed max-w-sm font-medium">
                            A robust academic evaluation ecosystem designed for modern universities and dedicated administrators.
                        </p>
                    </div>

                    <div class="flex-grow"></div>

                    <!-- Testimonial -->
                    <div class="glass-card !bg-white/10 !border-white/20 rounded-2xl p-4 lg:p-5 max-w-[360px] w-full premium-border animate-float-slower">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="flex -space-x-2">
                                <img class="w-8 h-8 lg:w-9 lg:h-9 rounded-full border-2 border-[#0e48c1] object-cover shadow-md bg-gray-200" src="https://i.pravatar.cc/150?img=11" alt="Avatar">
                                <img class="w-8 h-8 lg:w-9 lg:h-9 rounded-full border-2 border-[#0e48c1] object-cover shadow-md bg-gray-200" src="https://i.pravatar.cc/150?img=12" alt="Avatar">
                                <div class="w-8 h-8 lg:w-9 lg:h-9 rounded-full border-2 border-[#0e48c1] bg-white/20 backdrop-blur-sm text-white flex items-center justify-center text-[10px] lg:text-xs font-bold z-10">+4k</div>
                            </div>
                            <div class="text-blue-100 font-semibold text-sm">Trusted by 450+ Institutions</div>
                        </div>
                        <p class="text-xs lg:text-sm text-blue-200/80 leading-relaxed font-medium">
                            "The transition to Scholar Metric redefined how our department handles faculty growth and evaluation cycles."
                        </p>
                    </div>
                </div>
            </div>

            <!-- Right Side - Form -->
            <div class="w-full lg:w-[55%] flex flex-col justify-center p-8 sm:p-12 lg:p-16 xl:py-20 xl:px-24 bg-white/60 backdrop-blur-sm card-enter card-enter-delay">
                <div class="w-full max-w-[440px] mx-auto">
                    <!-- Header -->
                    <div class="mb-8 lg:mb-10">
                        <div class="inline-flex items-center gap-2 bg-[#0e48c1]/5 rounded-full px-3 py-1 mb-4">
                            <svg class="w-3 h-3 text-[#0e48c1]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                            <span class="text-[11px] font-bold text-[#0e48c1] uppercase tracking-wider">Create Account</span>
                        </div>
                        <h2 class="text-[28px] lg:text-[32px] font-bold text-gray-900 mb-2 tracking-tight">Admin Registration</h2>
                        <p class="text-gray-500 font-medium text-[15px]">Create an institutional administrator account.</p>
                    </div>

                    <form method="POST" action="{{ url('/register') }}">
                        @csrf
                        <!-- Full Name -->
                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Full Name</label>
                            <div class="relative flex items-center bg-[#f8fafc] rounded-xl overflow-hidden input-glow border border-gray-100 focus-within:border-blue-200 focus-within:bg-white transition-all duration-300">
                                <div class="pl-4 text-gray-400">
                                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                </div>
                                <input type="text" name="name" value="{{ old('name') }}" class="w-full bg-transparent px-3 py-3.5 text-gray-900 font-medium placeholder:text-gray-400 placeholder:font-normal focus:outline-none text-[15px]" placeholder="Dr. Julian Vane">
                            </div>
                            @error('name')
                                <p class="mt-2 flex items-center gap-1.5 text-sm font-semibold text-red-500"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Institutional Email</label>
                            <div class="relative flex items-center bg-[#f8fafc] rounded-xl overflow-hidden input-glow border border-gray-100 focus-within:border-blue-200 focus-within:bg-white transition-all duration-300">
                                <div class="pl-4 text-gray-400">
                                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                </div>
                                <input type="email" name="email" value="{{ old('email') }}" class="w-full bg-transparent px-3 py-3.5 text-gray-900 font-medium placeholder:text-gray-400 placeholder:font-normal focus:outline-none text-[15px]" placeholder="name@scholarmetric.edu">
                            </div>
                            @error('email')
                                <p class="mt-2 flex items-center gap-1.5 text-sm font-semibold text-red-500"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Department -->
                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Department/Unit</label>
                            <div class="relative flex items-center bg-[#f8fafc] rounded-xl overflow-hidden input-glow border border-gray-100 focus-within:border-blue-200 focus-within:bg-white transition-all duration-300">
                                <div class="pl-4 text-gray-400">
                                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                </div>
                                <input type="text" name="department" value="{{ old('department') }}" class="w-full bg-transparent px-3 py-3.5 text-gray-900 font-medium placeholder:text-gray-400 placeholder:font-normal focus:outline-none text-[15px]" placeholder="Optional">
                            </div>
                            @error('department')
                                <p class="mt-2 flex items-center gap-1.5 text-sm font-semibold text-red-500"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Password</label>
                            <div class="relative flex items-center bg-[#f8fafc] rounded-xl overflow-hidden input-glow border border-gray-100 focus-within:border-blue-200 focus-within:bg-white transition-all duration-300">
                                <div class="pl-4 text-gray-400">
                                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                </div>
                                <input type="password" name="password" class="w-full bg-transparent px-3 py-3.5 pr-12 text-gray-900 font-medium placeholder:text-gray-400 placeholder:font-normal focus:outline-none text-[15px] tracking-widest" placeholder="••••••••••••">
                                <button type="button" class="toggle-pw absolute inset-y-0 right-4 flex items-center text-gray-400 hover:text-[#0e48c1] focus:outline-none transition-colors duration-300">
                                    <svg class="w-[18px] h-[18px] eye-open" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <svg class="w-[18px] h-[18px] eye-closed hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                                </button>
                            </div>
                            @error('password')
                                <p class="mt-2 flex items-center gap-1.5 text-sm font-semibold text-red-500"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-5">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Confirm Password</label>
                            <div class="relative flex items-center bg-[#f8fafc] rounded-xl overflow-hidden input-glow border border-gray-100 focus-within:border-blue-200 focus-within:bg-white transition-all duration-300">
                                <div class="pl-4 text-gray-400">
                                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                </div>
                                <input type="password" name="password_confirmation" class="w-full bg-transparent px-3 py-3.5 pr-12 text-gray-900 font-medium placeholder:text-gray-400 placeholder:font-normal focus:outline-none text-[15px] tracking-widest" placeholder="••••••••••••">
                                <button type="button" class="toggle-pw absolute inset-y-0 right-4 flex items-center text-gray-400 hover:text-[#0e48c1] focus:outline-none transition-colors duration-300">
                                    <svg class="w-[18px] h-[18px] eye-open" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <svg class="w-[18px] h-[18px] eye-closed hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                                </button>
                            </div>
                        </div>

                        <!-- Terms -->
                        <div class="mb-8 flex items-start">
                            <input id="terms" name="terms" type="checkbox" value="1" @checked(old('terms')) class="premium-checkbox mt-0.5">
                            <label for="terms" class="ml-2.5 text-sm text-gray-500 font-semibold cursor-pointer select-none hover:text-gray-700 transition-colors duration-300">I agree to the institutional data privacy terms.</label>
                        </div>
                        @error('terms')
                            <p class="-mt-6 mb-6 flex items-center gap-1.5 text-sm font-semibold text-red-500"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>{{ $message }}</p>
                        @enderror

                        <!-- Submit -->
                        <button type="submit" class="magnetic-btn btn-shine w-full bg-gradient-to-r from-[#0e48c1] to-[#1a5cd6] hover:from-[#0c3ca1] hover:to-[#0e48c1] text-white font-bold rounded-xl py-4 transition-all duration-300 focus:ring-4 focus:ring-blue-300 focus:outline-none shadow-[0_8px_25px_rgba(14,72,193,0.25)] hover:shadow-[0_12px_35px_rgba(14,72,193,0.4)] flex items-center justify-center gap-2 transform active:scale-[0.98]">
                            <span>Create Admin Account</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </button>
                    </form>

                    <div class="mt-8 text-center">
                        <p class="text-sm text-gray-500 font-medium">
                            Already have an account?
                            <a href="{{ route('login') }}" class="text-[#0e48c1] hover:text-[#0c3ca1] font-bold transition-colors duration-300 relative group">
                                Sign In
                                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-[#0e48c1] group-hover:w-full transition-all duration-300 rounded-full"></span>
                            </a>
                        </p>
                    </div>

                    <script>
                        (function () {
                            // Password toggles
                            document.querySelectorAll('.toggle-pw').forEach(btn => {
                                btn.addEventListener('click', () => {
                                    const input = btn.closest('.relative').querySelector('input[type="password"], input[type="text"]');
                                    const isPw = input.type === 'password';
                                    input.type = isPw ? 'text' : 'password';
                                    btn.querySelector('.eye-open').classList.toggle('hidden', !isPw);
                                    btn.querySelector('.eye-closed').classList.toggle('hidden', isPw);
                                });
                            });

                            // Magnetic button
                            const submitBtn = document.querySelector('.magnetic-btn');
                            submitBtn.addEventListener('mousemove', (e) => {
                                const rect = submitBtn.getBoundingClientRect();
                                const x = e.clientX - rect.left - rect.width / 2;
                                const y = e.clientY - rect.top - rect.height / 2;
                                submitBtn.style.transform = 'translate(' + x * 0.15 + 'px, ' + y * 0.15 + 'px)';
                            });
                            submitBtn.addEventListener('mouseleave', () => {
                                submitBtn.style.transform = 'translate(0, 0)';
                            });

                            // Custom cursor
                            if (window.matchMedia('(pointer: fine)').matches) {
                                const dot = document.createElement('div');
                                const ring = document.createElement('div');
                                dot.className = 'fixed w-2 h-2 bg-[#0e48c1]/40 rounded-full pointer-events-none z-[9998] mix-blend-difference transition-transform duration-100 ease-out';
                                ring.className = 'fixed w-7 h-7 border-2 border-[#0e48c1]/15 rounded-full pointer-events-none z-[9998] transition-all duration-300 ease-out';
                                dot.style.cssText = 'transform: translate(-50%, -50%); display: none;';
                                ring.style.cssText = 'transform: translate(-50%, -50%); display: none;';
                                document.body.appendChild(dot);
                                document.body.appendChild(ring);
                                let mouseX = 0, mouseY = 0, ringX = 0, ringY = 0;
                                document.addEventListener('mousemove', (e) => {
                                    mouseX = e.clientX; mouseY = e.clientY;
                                    dot.style.display = 'block'; ring.style.display = 'block';
                                    dot.style.left = mouseX + 'px'; dot.style.top = mouseY + 'px';
                                });
                                const animateRing = () => {
                                    ringX += (mouseX - ringX) * 0.15; ringY += (mouseY - ringY) * 0.15;
                                    ring.style.left = ringX + 'px'; ring.style.top = ringY + 'px';
                                    requestAnimationFrame(animateRing);
                                };
                                animateRing();
                                document.querySelectorAll('a, button, label').forEach(el => {
                                    el.addEventListener('mouseenter', () => {
                                        ring.style.width = '44px'; ring.style.height = '44px';
                                        ring.style.borderColor = 'rgba(14,72,193,0.35)';
                                        dot.style.transform = 'translate(-50%, -50%) scale(1.5)';
                                    });
                                    el.addEventListener('mouseleave', () => {
                                        ring.style.width = '28px'; ring.style.height = '28px';
                                        ring.style.borderColor = 'rgba(14,72,193,0.15)';
                                        dot.style.transform = 'translate(-50%, -50%) scale(1)';
                                    });
                                });
                            }
                        })();
                    </script>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4 text-[13px] font-semibold text-gray-400 max-w-4xl text-center">
            <span>&copy; {{ date('Y') }} Scholar Metric Academic Systems. All rights reserved.</span>
            <span class="hidden sm:inline text-gray-300">|</span>
            <div class="flex gap-4">
                <a href="#" class="hover:text-[#0e48c1] transition-colors duration-300">Privacy Policy</a>
                <a href="#" class="hover:text-[#0e48c1] transition-colors duration-300">Terms of Service</a>
            </div>
        </div>
    </div>
</x-layout>
