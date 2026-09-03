<x-layout>
    <style>
        html, body { overflow: hidden; height: 100%; }

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

        @keyframes pulse-dot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(1.5); }
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

        <!-- Main Card Container -->
        <div class="w-full max-w-6xl bg-white/80 backdrop-blur-xl rounded-[2.5rem] shadow-[0_25px_60px_rgba(0,0,0,0.06)] overflow-hidden flex flex-col lg:flex-row min-h-[700px] border border-white/60 card-enter relative">

            <!-- Left Side -->
            <div class="relative w-full lg:w-[45%] bg-gradient-to-br from-[#f0f4ff] via-[#e8eeff] to-[#f4f6f8] p-10 lg:p-14 flex flex-col justify-between overflow-hidden">
                <div class="absolute -top-32 -right-32 w-96 h-96 rounded-full bg-gradient-to-br from-[#0e48c1]/10 to-transparent animate-glow blur-2xl"></div>
                <div class="absolute -bottom-48 left-1/2 -translate-x-1/2 w-[500px] h-[500px] rounded-full bg-gradient-to-tr from-[#4f83f5]/8 to-transparent blur-3xl"></div>
                <div class="particle particle-1 w-3 h-3 bg-[#0e48c1]/10 top-20 left-[20%]"></div>
                <div class="particle particle-2 w-2 h-2 bg-[#4f83f5]/10 top-40 right-[25%]"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[350px] h-[350px] border border-[#0e48c1]/[0.06] rounded-full animate-spin-slow"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[280px] h-[280px] border border-[#4f83f5]/[0.04] rounded-full animate-spin-slow" style="animation-direction: reverse; animation-duration: 25s"></div>

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
                            Secure Access<br />
                            <span class="gradient-text">Recovery.</span>
                        </h1>
                        <p class="text-gray-500 text-base sm:text-[17px] leading-relaxed max-w-sm font-medium">
                            Protecting the integrity of institutional data begins with secure account management.
                        </p>
                    </div>

                    <div class="flex-grow"></div>

                    <!-- Info Card -->
                    <div class="glass-card rounded-2xl p-4 lg:p-5 max-w-[360px] shadow-[0_8px_30px_rgba(0,0,0,0.04)] w-full premium-border animate-float-slower">
                        <div class="flex items-start gap-3">
                            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-[#0e48c1]/10 to-[#4f83f5]/10 flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-4 h-4 text-[#0e48c1]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-800 mb-0.5">Secure Account Recovery</p>
                                <p class="text-xs text-gray-500 font-medium leading-relaxed">A time-sensitive reset link is emailed to your institutional address.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side - Form -->
            <div class="w-full lg:w-[55%] flex flex-col justify-center p-8 sm:p-12 lg:p-20 xl:py-24 xl:px-28 bg-white/60 backdrop-blur-sm card-enter card-enter-delay">
                <div class="w-full max-w-[440px] mx-auto">
                    <!-- Header -->
                    <div class="mb-10">
                        <div class="inline-flex items-center gap-2 bg-[#0e48c1]/5 rounded-full px-3 py-1 mb-4">
                            <svg class="w-3 h-3 text-[#0e48c1]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            <span class="text-[11px] font-bold text-[#0e48c1] uppercase tracking-wider">Account Recovery</span>
                        </div>
                        <h2 class="text-[32px] font-bold text-gray-900 mb-2 tracking-tight">Forgot your password?</h2>
                        <p class="text-gray-500 font-medium text-[15px]">Enter your institutional email and we'll send you a secure reset link.</p>
                    </div>

                    <!-- Success Message -->
                    @if(session('status'))
                        <div class="mb-6 bg-emerald-50 border border-emerald-200/60 rounded-xl px-5 py-4 flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-emerald-400 to-emerald-500 flex items-center justify-center shrink-0 mt-0.5 shadow-[0_2px_8px_rgba(16,185,129,0.3)]">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <p class="text-sm font-semibold text-emerald-700">{{ session('status') }}</p>
                        </div>
                    @endif

                    <!-- WebSocket Reset Link -->
                    <div id="reset-link-container" class="mb-6 hidden"></div>

                    <!-- Error -->
                    @error('email')
                        <div class="mb-5 flex items-center gap-2 text-red-500 text-sm font-bold bg-red-50 rounded-xl px-4 py-3 border border-red-100">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $message }}
                        </div>
                    @enderror

                    <!-- Form -->
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="mb-5">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Institutional Email</label>
                            <div class="relative flex items-center bg-[#f8fafc] rounded-xl overflow-hidden input-glow border border-gray-100 focus-within:border-blue-200 focus-within:bg-white transition-all duration-300">
                                <div class="pl-4 text-gray-400">
                                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <input type="email" name="email" value="{{ old('email') }}"
                                    class="w-full bg-transparent px-3 py-3.5 text-gray-900 font-medium placeholder:text-gray-400 placeholder:font-normal focus:outline-none text-[15px]"
                                    placeholder="name@institution.edu"
                                    required autofocus>
                            </div>
                        </div>

                        <!-- WebSocket Status -->
                        <div id="ws-status" class="mb-7 glass-card rounded-xl px-4 py-3 flex items-center gap-3 premium-border">
                            <div id="ws-indicator" class="w-2.5 h-2.5 rounded-full bg-gray-300 transition-colors duration-300"></div>
                            <span id="ws-text" class="text-xs font-semibold text-gray-500">Connecting to real-time service...</span>
                        </div>

                        <button id="submit-btn" type="submit"
                            class="magnetic-btn btn-shine w-full bg-gradient-to-r from-[#0e48c1] to-[#1a5cd6] hover:from-[#0c3ca1] hover:to-[#0e48c1] text-white font-bold rounded-xl py-4 transition-all duration-300 focus:ring-4 focus:ring-blue-300 focus:outline-none shadow-[0_8px_25px_rgba(14,72,193,0.25)] hover:shadow-[0_12px_35px_rgba(14,72,193,0.4)] flex items-center justify-center gap-2 transform active:scale-[0.98]">
                            <span>Send Reset Link</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </button>
                    </form>

                    <!-- Back to login -->
                    <div class="mt-8 text-center">
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-sm font-bold text-[#0e48c1] hover:text-[#0c3ca1] transition-colors duration-300 group">
                            <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Back to Login
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4 text-[13px] font-semibold text-gray-400 max-w-4xl text-center">
            <span>&copy; {{ date('Y') }} Scholar Metric Academic Systems. All rights reserved.</span>
            <span class="hidden sm:inline text-gray-300">|</span>
            <div class="flex gap-4">
                <a href="#" class="hover:text-[#0e48c1] transition-colors duration-300">Privacy Policy</a>
                <a href="#" class="hover:text-[#0e48c1] transition-colors duration-300">Institutional Security</a>
            </div>
        </div>
    </div>

    @php($resetChannelToken = session('reset_channel_token'))
    @if($resetChannelToken)
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const wsIndicator = document.getElementById('ws-indicator');
                const wsText = document.getElementById('ws-text');
                const resetLinkContainer = document.getElementById('reset-link-container');

                function setWsStatus(color, text) {
                    if (wsIndicator) wsIndicator.className = 'w-2.5 h-2.5 rounded-full transition-colors duration-300 ' + color;
                    if (wsText) wsText.textContent = text;
                }

                if (window.Echo) {
                    setWsStatus('bg-yellow-400', 'Connecting to real-time service...');

                    window.Echo.connector.pusher.connection.bind('connected', function () {
                        setWsStatus('bg-blue-500', 'Connected. Waiting for reset link...');
                    });

                    window.Echo.connector.pusher.connection.bind('disconnected', function () {
                        setWsStatus('bg-red-500', 'Disconnected. Refresh to re-enable real-time updates.');
                    });

                    window.Echo.connector.pusher.connection.bind('error', function () {
                        setWsStatus('bg-red-500', 'Connection error. Refresh page.');
                    });

                    window.Echo.private('reset.{{ $resetChannelToken }}')
                        .listen('PasswordResetLinkCreated', function (e) {
                            setWsStatus('bg-emerald-500', 'Reset link received!');

                            resetLinkContainer.innerHTML =
                                '<div class="bg-emerald-50 border border-emerald-200/60 rounded-xl px-5 py-4">' +
                                '<div class="flex items-center gap-2 mb-2">' +
                                '<div class="w-6 h-6 rounded-md bg-gradient-to-br from-emerald-400 to-emerald-500 flex items-center justify-center shadow-[0_2px_6px_rgba(16,185,129,0.3)]">' +
                                '<svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></div>' +
                                '<p class="text-xs font-bold text-emerald-700 uppercase tracking-wider">Reset Link Generated</p></div>' +
                                '<a href="' + e.resetUrl + '" class="text-sm font-semibold text-[#0e48c1] hover:underline break-all">' +
                                e.resetUrl + '</a></div>';
                            resetLinkContainer.classList.remove('hidden');

                            document.getElementById('submit-btn').disabled = true;
                            document.getElementById('submit-btn').classList.add('opacity-50', 'cursor-not-allowed');
                        });
                } else {
                    setWsStatus('bg-gray-300', 'Real-time service unavailable (Echo not loaded).');
                }

                // Magnetic button
                const submitBtn = document.getElementById('submit-btn');
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
                    document.querySelectorAll('a, button').forEach(el => {
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
            });
        </script>
    @endif
</x-layout>
