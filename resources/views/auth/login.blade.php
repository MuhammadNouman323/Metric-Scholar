<x-layout>
    <style>
        html, body { overflow: hidden; height: 100%; }

        /* ---- Gradient Shift ---- */
        @keyframes gradient-shift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        /* ---- Gradient Text ---- */
        .gradient-text {
            background: linear-gradient(135deg, #0e48c1, #4f83f5, #0e48c1);
            background-size: 200% 200%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gradient-shift 4s ease infinite;
        }

        /* ---- Floating Animations ---- */
        @keyframes float-slow {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-14px) rotate(1deg); }
        }
        @keyframes float-slower {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(10px) rotate(-1deg); }
        }
        .animate-float-slow { animation: float-slow 6s ease-in-out infinite; }
        .animate-float-slower { animation: float-slower 7s ease-in-out infinite; }

        /* ---- Glow Pulse ---- */
        @keyframes glow-pulse {
            0%, 100% { opacity: 0.4; transform: scale(1); }
            50% { opacity: 0.7; transform: scale(1.05); }
        }
        .animate-glow { animation: glow-pulse 3s ease-in-out infinite; }

        /* ---- Spin Slow ---- */
        @keyframes spin-slow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .animate-spin-slow { animation: spin-slow 20s linear infinite; }

        /* ---- Particle Drift ---- */
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

        /* ---- Geometric Shape Float ---- */
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
        @keyframes geo-float-3 {
            0%, 100% { transform: translate(0, 0) rotate(45deg); }
            50% { transform: translate(18px, -25px) rotate(225deg); }
        }
        .geo-shape-1 { animation: geo-float-1 12s ease-in-out infinite; }
        .geo-shape-2 { animation: geo-float-2 15s ease-in-out infinite; }
        .geo-shape-3 { animation: geo-float-3 18s ease-in-out infinite; }

        /* ---- Glass Card ---- */
        .glass-card {
            background: rgba(255, 255, 255, 0.65);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        /* ---- Premium Border ---- */
        .premium-border {
            position: relative;
        }
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

        /* ---- Button Shine ---- */
        .btn-shine {
            position: relative;
            overflow: hidden;
        }
        .btn-shine::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(
                to right,
                transparent 0%,
                rgba(255,255,255,0.1) 45%,
                rgba(255,255,255,0.3) 50%,
                rgba(255,255,255,0.1) 55%,
                transparent 100%
            );
            transform: rotate(25deg) translateX(-150%);
            transition: transform 0.6s ease;
        }
        .btn-shine:hover::after {
            transform: rotate(25deg) translateX(150%);
        }

        /* ---- Magnetic Button ---- */
        .magnetic-btn {
            transition: transform 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        /* ---- Input Focus Glow ---- */
        .input-glow {
            transition: all 0.3s ease;
        }
        .input-glow:focus {
            box-shadow: 0 0 0 3px rgba(14,72,193,0.1), 0 0 20px rgba(14,72,193,0.05);
        }

        /* ---- Role Card Active Glow ---- */
        .role-glow {
            transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1);
        }
        .role-glow.active {
            box-shadow: 0 8px 25px rgba(14,72,193,0.15), 0 0 0 1px rgba(14,72,193,0.2);
        }

        /* ---- Pulse Ring ---- */
        @keyframes pulse-ring {
            0% { box-shadow: 0 0 0 0 rgba(14, 72, 193, 0.25); }
            70% { box-shadow: 0 0 0 10px rgba(14, 72, 193, 0); }
            100% { box-shadow: 0 0 0 0 rgba(14, 72, 193, 0); }
        }
        .animate-pulse-ring { animation: pulse-ring 2.5s ease-out infinite; }

        /* ---- Custom Checkbox ---- */
        .premium-checkbox {
            appearance: none;
            -webkit-appearance: none;
            width: 18px;
            height: 18px;
            border: 2px solid #d1d5db;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
        }
        .premium-checkbox:checked {
            background: linear-gradient(135deg, #0e48c1, #4f83f5);
            border-color: #0e48c1;
            box-shadow: 0 2px 8px rgba(14,72,193,0.3);
        }
        .premium-checkbox:checked::after {
            content: '';
            position: absolute;
            left: 4px;
            top: 1px;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }
        .premium-checkbox:hover {
            border-color: #0e48c1;
        }

        /* ---- Card Entrance ---- */
        @keyframes card-enter {
            from { opacity: 0; transform: translateY(20px) scale(0.98); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
        .card-enter {
            animation: card-enter 0.8s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        }
        .card-enter-delay { animation-delay: 0.15s; opacity: 0; }

        /* ---- Shimmer on left panel ---- */
        @keyframes shimmer-sweep {
            0% { transform: translateX(-100%) rotate(25deg); }
            100% { transform: translateX(200%) rotate(25deg); }
        }

        /* ---- Mesh Blob Animation ---- */
        @keyframes mesh-move {
            0%, 100% { transform: translate(0, 0) scale(1); }
            25% { transform: translate(20px, -15px) scale(1.05); }
            50% { transform: translate(-15px, 10px) scale(0.95); }
            75% { transform: translate(10px, 18px) scale(1.02); }
        }
        .mesh-blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            pointer-events: none;
        }
        .mesh-blob-1 { animation: mesh-move 20s ease-in-out infinite; }
        .mesh-blob-2 { animation: mesh-move 25s ease-in-out infinite reverse; }
    </style>

    <div class="min-h-screen bg-gradient-to-br from-[#f0f4ff] via-[#f8fafc] to-white flex flex-col justify-center items-center p-4 sm:p-6 lg:p-8 relative overflow-hidden">
        <!-- Background Decorations -->
        <div class="absolute -top-40 -right-40 w-[600px] h-[600px] rounded-full bg-[radial-gradient(circle_at_center,_rgba(14,72,193,0.08),_transparent_60%)] animate-glow"></div>
        <div class="absolute -bottom-40 -left-40 w-[500px] h-[500px] rounded-full bg-[radial-gradient(circle_at_center,_rgba(79,131,245,0.06),_transparent_60%)]"></div>

        <!-- Mesh Blobs -->
        <div class="mesh-blob mesh-blob-1 w-80 h-80 bg-[#0e48c1]/[0.04] top-10 left-10"></div>
        <div class="mesh-blob mesh-blob-2 w-64 h-64 bg-[#4f83f5]/[0.03] bottom-20 right-20"></div>

        <!-- Floating Particles -->
        <div class="particle particle-1 w-2 h-2 bg-[#0e48c1]/15 top-20 left-[10%]"></div>
        <div class="particle particle-2 w-3 h-3 bg-[#4f83f5]/10 top-32 right-[15%]"></div>
        <div class="particle particle-3 w-1.5 h-1.5 bg-[#0e48c1]/20 bottom-32 left-[20%]"></div>
        <div class="particle particle-1 w-2 h-2 bg-[#4f83f5]/10 bottom-20 right-[25%]" style="animation-delay: 2s"></div>
        <div class="particle particle-2 w-2.5 h-2.5 bg-[#0e48c1]/10 top-[40%] left-[5%]" style="animation-delay: 3s"></div>
        <div class="particle particle-3 w-1.5 h-1.5 bg-[#4f83f5]/15 top-[60%] right-[8%]" style="animation-delay: 1s"></div>

        <!-- Floating Geometric Shapes -->
        <svg class="geo-shape-1 absolute top-16 left-[8%] w-12 h-12 text-[#0e48c1]/[0.06]" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5">
            <rect x="6" y="6" width="36" height="36" rx="6"/>
        </svg>
        <svg class="geo-shape-2 absolute top-24 right-[12%] w-10 h-10 text-[#4f83f5]/[0.05]" viewBox="0 0 40 40" fill="none" stroke="currentColor" stroke-width="1.5">
            <polygon points="20,2 38,32 2,32"/>
        </svg>
        <svg class="geo-shape-3 absolute bottom-24 left-[12%] w-8 h-8 text-[#0e48c1]/[0.05]" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="1.5">
            <circle cx="16" cy="16" r="12"/>
        </svg>
        <svg class="geo-shape-1 absolute bottom-16 right-[10%] w-10 h-10 text-[#4f83f5]/[0.05]" viewBox="0 0 40 40" fill="none" stroke="currentColor" stroke-width="1.5" style="animation-delay: -4s">
            <path d="M20 2L38 20L20 38L2 20Z"/>
        </svg>

        <!-- Main Card Container -->
        <div class="w-full max-w-6xl bg-white/80 backdrop-blur-xl rounded-[2.5rem] shadow-[0_25px_60px_rgba(0,0,0,0.06)] overflow-hidden flex flex-col lg:flex-row min-h-[700px] border border-white/60 card-enter relative">

            <!-- Left Side -->
            <div class="relative w-full lg:w-[45%] bg-gradient-to-br from-[#f0f4ff] via-[#e8eeff] to-[#f4f6f8] p-10 lg:p-14 flex flex-col justify-between overflow-hidden">
                <!-- Decorative Blobs -->
                <div class="absolute -top-32 -right-32 w-96 h-96 rounded-full bg-gradient-to-br from-[#0e48c1]/10 to-transparent animate-glow blur-2xl"></div>
                <div class="absolute -bottom-48 left-1/2 -translate-x-1/2 w-[500px] h-[500px] rounded-full bg-gradient-to-tr from-[#4f83f5]/8 to-transparent blur-3xl"></div>

                <!-- Floating Particles on Left Panel -->
                <div class="particle particle-1 w-3 h-3 bg-[#0e48c1]/10 top-20 left-[20%]"></div>
                <div class="particle particle-2 w-2 h-2 bg-[#4f83f5]/10 top-40 right-[25%]"></div>
                <div class="particle particle-3 w-2.5 h-2.5 bg-[#0e48c1]/8 bottom-32 left-[30%]"></div>

                <!-- Decorative rotating ring -->
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[350px] h-[350px] border border-[#0e48c1]/[0.06] rounded-full animate-spin-slow"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[280px] h-[280px] border border-[#4f83f5]/[0.04] rounded-full animate-spin-slow" style="animation-direction: reverse; animation-duration: 25s"></div>

                <!-- Content -->
                <div class="relative z-10 flex flex-col h-full items-start">
                    <!-- Logo -->
                    <a href="{{ route('landing') }}" class="flex items-center gap-3 mb-16 lg:mb-20 group">
                        <div class="w-10 h-10 bg-gradient-to-br from-[#0e48c1] to-[#4f83f5] rounded-xl flex items-center justify-center text-white flex-shrink-0 shadow-[0_4px_15px_rgba(14,72,193,0.3)] group-hover:shadow-[0_6px_20px_rgba(14,72,193,0.5)] group-hover:scale-105 transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 3L1 9L5 11.18V17.18L12 21L19 17.18V11.18L21 10.09V17H23V9L12 3ZM18.82 9L12 12.72L5.18 9L12 5.28L18.82 9ZM17 15.99L12 18.72L7 15.99V12.27L12 15L17 12.27V15.99Z"/>
                            </svg>
                        </div>
                        <span class="font-bold text-xl tracking-tight text-gray-900">Scholar <span class="gradient-text">Metric</span></span>
                    </a>

                    <!-- Heading -->
                    <div class="max-w-[420px]">
                        <h1 class="text-3xl sm:text-4xl lg:text-[44px] font-bold leading-[1.2] text-gray-900 mb-6 tracking-tight">
                            Elevating Academic<br />
                            Excellence through<br />
                            <span class="gradient-text">Informed Feedback.</span>
                        </h1>
                        <p class="text-gray-500 text-base sm:text-[17px] leading-relaxed max-w-sm font-medium">
                            A sophisticated evaluation ecosystem designed for modern institutions and dedicated faculty.
                        </p>
                    </div>

                    <div class="flex-grow"></div>

                    <!-- Testimonial -->
                    <div class="glass-card rounded-2xl p-4 lg:p-5 max-w-[360px] shadow-[0_8px_30px_rgba(0,0,0,0.04)] flex items-center gap-4 w-full premium-border animate-float-slower">
                        <div class="flex -space-x-3">
                            <img class="w-9 h-9 rounded-full border-2 border-white object-cover shadow-md bg-gray-200" src="https://i.pravatar.cc/150?img=11" alt="Avatar">
                            <img class="w-9 h-9 rounded-full border-2 border-white object-cover shadow-md bg-gray-200" src="https://i.pravatar.cc/150?img=12" alt="Avatar">
                            <img class="w-9 h-9 rounded-full border-2 border-white object-cover shadow-md bg-gray-200" src="https://i.pravatar.cc/150?img=13" alt="Avatar">
                        </div>
                        <div>
                            <p class="text-gray-800 font-bold text-sm">Trusted by 2,000+</p>
                            <p class="text-gray-400 font-semibold text-xs">Educators worldwide</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side - Login Form -->
            <div class="w-full lg:w-[55%] flex flex-col justify-center p-8 sm:p-12 lg:p-20 xl:py-24 xl:px-28 bg-white/60 backdrop-blur-sm card-enter card-enter-delay">
                <div class="w-full max-w-[440px] mx-auto">
                    <!-- Header -->
                    <div class="mb-10 lg:mb-12">
                        <div class="inline-flex items-center gap-2 bg-[#0e48c1]/5 rounded-full px-3 py-1 mb-4">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#0e48c1] animate-pulse"></span>
                            <span class="text-[11px] font-bold text-[#0e48c1] uppercase tracking-wider">Secure Login</span>
                        </div>
                        <h2 class="text-[32px] font-bold text-gray-900 mb-2 tracking-tight">Welcome Back</h2>
                        <p class="text-gray-500 font-medium">Please select your role and enter your credentials.</p>
                    </div>

                    <!-- Role Selector -->
                    <div class="grid grid-cols-3 gap-3 sm:gap-4 mb-8">
                        <!-- Admin -->
                        <label class="cursor-pointer group">
                            <input type="radio" name="role" value="admin" form="login-form" class="peer sr-only" @checked(old('role', 'admin') === 'admin')>
                            <div class="role-glow border-2 border-gray-100 rounded-2xl p-4 sm:py-5 flex flex-col items-center justify-center gap-2 bg-white text-gray-400 peer-checked:border-[#0e48c1] peer-checked:text-[#0e48c1] peer-checked:bg-gradient-to-b peer-checked:from-[#f0f4ff] peer-checked:to-white peer-checked:shadow-[0_8px_25px_rgba(14,72,193,0.12)] hover:bg-gray-50 hover:border-gray-200 transition-all duration-300">
                                <div class="w-10 h-10 rounded-xl bg-current/5 flex items-center justify-center peer-checked:shadow-[0_4px_12px_rgba(14,72,193,0.15)] transition-all duration-300">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                </div>
                                <span class="text-[13px] font-bold mt-1">Admin</span>
                            </div>
                        </label>
                        <!-- Student -->
                        <label class="cursor-pointer group">
                            <input type="radio" name="role" value="student" form="login-form" class="peer sr-only" @checked(old('role') === 'student')>
                            <div class="role-glow border-2 border-gray-100 rounded-2xl p-4 sm:py-5 flex flex-col items-center justify-center gap-2 bg-gray-50/50 text-gray-500 peer-checked:border-[#0e48c1] peer-checked:bg-white peer-checked:text-[#0e48c1] peer-checked:bg-gradient-to-b peer-checked:from-[#f0f4ff] peer-checked:to-white peer-checked:shadow-[0_8px_25px_rgba(14,72,193,0.12)] hover:bg-gray-100/50 hover:border-gray-200 transition-all duration-300">
                                <div class="w-10 h-10 rounded-xl bg-current/5 flex items-center justify-center transition-all duration-300">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                </div>
                                <span class="text-[13px] font-bold mt-1">Student</span>
                            </div>
                        </label>
                        <!-- Faculty -->
                        <label class="cursor-pointer group">
                            <input type="radio" name="role" value="faculty" form="login-form" class="peer sr-only" @checked(old('role') === 'faculty')>
                            <div class="role-glow border-2 border-gray-100 rounded-2xl p-4 sm:py-5 flex flex-col items-center justify-center gap-2 bg-gray-50/50 text-gray-500 peer-checked:border-[#0e48c1] peer-checked:bg-white peer-checked:text-[#0e48c1] peer-checked:bg-gradient-to-b peer-checked:from-[#f0f4ff] peer-checked:to-white peer-checked:shadow-[0_8px_25px_rgba(14,72,193,0.12)] hover:bg-gray-100/50 hover:border-gray-200 transition-all duration-300">
                                <div class="w-10 h-10 rounded-xl bg-current/5 flex items-center justify-center transition-all duration-300">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                                </div>
                                <span class="text-[13px] font-bold mt-1">Faculty</span>
                            </div>
                        </label>
                    </div>

                    <form id="login-form" method="POST" action="{{ route('auth.attempt') }}">
                        @csrf
                        <!-- Institutional Email -->
                        <div class="mb-5">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Institutional Email</label>
                            <div class="relative flex items-center bg-[#f8fafc] rounded-xl overflow-hidden input-glow border border-gray-100 focus-within:border-blue-200 focus-within:bg-white transition-all duration-300">
                                <div class="pl-4 text-gray-400">
                                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                </div>
                                <input type="email" name="email" value="{{ old('email') }}" class="w-full bg-transparent px-3 py-3.5 text-gray-900 font-medium placeholder:text-gray-400 placeholder:font-normal focus:outline-none text-[15px]" placeholder="name@institution.edu">
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-2">
                                <label class="block text-sm font-bold text-gray-700">Password</label>
                                <a id="forgot-password-link" href="{{ route('password.request') }}" class="text-sm font-bold text-[#0e48c1] hover:text-[#0c3ca1] transition-colors duration-300 relative group">
                                    Forgot Password?
                                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-[#0e48c1] group-hover:w-full transition-all duration-300 rounded-full"></span>
                                </a>
                            </div>
                            <div class="relative flex items-center bg-[#f8fafc] rounded-xl overflow-hidden input-glow border border-gray-100 focus-within:border-blue-200 focus-within:bg-white transition-all duration-300">
                                <div class="pl-4 text-gray-400">
                                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                </div>
                                <input type="password" name="password" class="w-full bg-transparent px-3 py-3.5 pr-12 text-gray-900 font-medium placeholder:text-gray-400 placeholder:font-normal focus:outline-none text-[15px] tracking-widest" placeholder="••••••••">
                                <button type="button" id="toggle-password" class="absolute inset-y-0 right-4 flex items-center text-gray-400 hover:text-[#0e48c1] focus:outline-none transition-colors duration-300">
                                    <svg class="w-[18px] h-[18px] eye-open" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <svg class="w-[18px] h-[18px] eye-closed hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                                </button>
                            </div>
                        </div>

                        <!-- Errors -->
                        @error('email')
                            <div class="mb-4 flex items-center gap-2 text-red-500 text-sm font-bold bg-red-50 rounded-xl px-4 py-3 border border-red-100">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                {{ $message }}
                            </div>
                        @enderror
                        @error('password')
                            <div class="mb-4 flex items-center gap-2 text-red-500 text-sm font-bold bg-red-50 rounded-xl px-4 py-3 border border-red-100">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                {{ $message }}
                            </div>
                        @enderror
                        @error('role')
                            <div class="mb-4 flex items-center gap-2 text-red-500 text-sm font-bold bg-red-50 rounded-xl px-4 py-3 border border-red-100">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                {{ $message }}
                            </div>
                        @enderror

                        <!-- Checkbox -->
                        <div class="mb-8 flex items-center mt-1">
                            <input id="remember" name="remember" type="checkbox" @checked(old('remember')) class="premium-checkbox">
                            <label for="remember" class="ml-2.5 text-sm text-gray-500 font-semibold cursor-pointer select-none hover:text-gray-700 transition-colors duration-300">Remember Password</label>
                        </div>

                        <!-- Login Button -->
                        <button type="submit" class="magnetic-btn btn-shine w-full bg-gradient-to-r from-[#0e48c1] to-[#1a5cd6] hover:from-[#0c3ca1] hover:to-[#0e48c1] text-white font-bold rounded-xl py-4 transition-all duration-300 focus:ring-4 focus:ring-blue-300 focus:outline-none shadow-[0_8px_25px_rgba(14,72,193,0.25)] hover:shadow-[0_12px_35px_rgba(14,72,193,0.4)] flex items-center justify-center gap-2 transform active:scale-[0.98]">
                            <span>Login</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </button>
                    </form>

                    <div id="register-link" class="mt-8 text-center">
                        <p class="text-sm text-gray-500 font-medium">
                            Don't have an account?
                            <a href="/register" class="text-[#0e48c1] hover:text-[#0c3ca1] font-bold transition-colors duration-300 relative group">
                                Register
                                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-[#0e48c1] group-hover:w-full transition-all duration-300 rounded-full"></span>
                            </a>
                        </p>
                    </div>

                    <script>
                        (function () {
                            const registerLink = document.getElementById('register-link');
                            const roleInputs = document.querySelectorAll('input[name="role"]');

                            function toggleAdminOnlyElements() {
                                const selected = document.querySelector('input[name="role"]:checked');
                                const isAdmin = selected && selected.value === 'admin';
                                registerLink.style.display = isAdmin ? 'block' : 'none';
                            }

                            roleInputs.forEach(input => input.addEventListener('change', toggleAdminOnlyElements));
                            toggleAdminOnlyElements();

                            // Password toggle
                            const toggleBtn = document.getElementById('toggle-password');
                            const passwordInput = toggleBtn.closest('.relative').querySelector('input[type="password"]');
                            const eyeOpen = toggleBtn.querySelector('.eye-open');
                            const eyeClosed = toggleBtn.querySelector('.eye-closed');

                            toggleBtn.addEventListener('click', () => {
                                const isPassword = passwordInput.type === 'password';
                                passwordInput.type = isPassword ? 'text' : 'password';
                                eyeOpen.classList.toggle('hidden', !isPassword);
                                eyeClosed.classList.toggle('hidden', isPassword);
                            });

                            // Magnetic button effect
                            const submitBtn = document.querySelector('.magnetic-btn');
                            submitBtn.addEventListener('mousemove', (e) => {
                                const rect = submitBtn.getBoundingClientRect();
                                const x = e.clientX - rect.left - rect.width / 2;
                                const y = e.clientY - rect.top - rect.height / 2;
                                submitBtn.style.transform = `translate(${x * 0.15}px, ${y * 0.15}px)`;
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
                                    mouseX = e.clientX;
                                    mouseY = e.clientY;
                                    dot.style.display = 'block';
                                    ring.style.display = 'block';
                                    dot.style.left = mouseX + 'px';
                                    dot.style.top = mouseY + 'px';
                                });

                                const animateRing = () => {
                                    ringX += (mouseX - ringX) * 0.15;
                                    ringY += (mouseY - ringY) * 0.15;
                                    ring.style.left = ringX + 'px';
                                    ring.style.top = ringY + 'px';
                                    requestAnimationFrame(animateRing);
                                };
                                animateRing();

                                // Expand on interactive
                                document.querySelectorAll('a, button, label, .role-glow').forEach(el => {
                                    el.addEventListener('mouseenter', () => {
                                        ring.style.width = '44px';
                                        ring.style.height = '44px';
                                        ring.style.borderColor = 'rgba(14,72,193,0.35)';
                                        dot.style.transform = 'translate(-50%, -50%) scale(1.5)';
                                    });
                                    el.addEventListener('mouseleave', () => {
                                        ring.style.width = '28px';
                                        ring.style.height = '28px';
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
                <a href="#" class="hover:text-[#0e48c1] transition-colors duration-300">System Status</a>
            </div>
        </div>
    </div>
</x-layout>
