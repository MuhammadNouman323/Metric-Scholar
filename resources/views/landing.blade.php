<x-layout>
    <style>
        html { scroll-behavior: smooth; }

        /* ---- Scroll Reveal ---- */
        .reveal {
            opacity: 0;
            transform: translateY(32px);
            transition: opacity 0.9s cubic-bezier(0.22, 1, 0.36, 1),
                        transform 0.9s cubic-bezier(0.22, 1, 0.36, 1);
        }
        .reveal.revealed { opacity: 1; transform: none; }

        /* ---- Floating Animations ---- */
        @keyframes float-slow {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-18px) rotate(1deg); }
        }
        @keyframes float-slower {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(12px) rotate(-1deg); }
        }
        @keyframes float-reverse {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-10px) scale(1.02); }
        }
        .animate-float-slow { animation: float-slow 6s ease-in-out infinite; }
        .animate-float-slower { animation: float-slower 7s ease-in-out infinite; }
        .animate-float-reverse { animation: float-reverse 5s ease-in-out infinite; }

        /* ---- Pulse Ring ---- */
        @keyframes pulse-ring {
            0% { box-shadow: 0 0 0 0 rgba(14, 72, 193, 0.3); }
            70% { box-shadow: 0 0 0 14px rgba(14, 72, 193, 0); }
            100% { box-shadow: 0 0 0 0 rgba(14, 72, 193, 0); }
        }
        .animate-pulse-ring { animation: pulse-ring 2.5s ease-out infinite; }

        /* ---- Gradient Shift ---- */
        @keyframes gradient-shift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        .animate-gradient {
            background-size: 200% 200%;
            animation: gradient-shift 4s ease infinite;
        }

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

        /* ---- Gradient Text ---- */
        .gradient-text {
            background: linear-gradient(135deg, #0e48c1, #4f83f5, #0e48c1);
            background-size: 200% 200%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gradient-shift 4s ease infinite;
        }

        /* ---- Glass Card ---- */
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.6);
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
            background: linear-gradient(135deg, rgba(14,72,193,0.2), rgba(79,131,245,0.1), rgba(14,72,193,0.2));
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            pointer-events: none;
        }

        /* ---- Floating Particles (CSS-only) ---- */
        .particle {
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
        }
        @keyframes drift-1 {
            0%, 100% { transform: translate(0, 0) scale(1); opacity: 0.5; }
            25% { transform: translate(30px, -40px) scale(1.1); opacity: 0.7; }
            50% { transform: translate(-20px, -80px) scale(0.9); opacity: 0.4; }
            75% { transform: translate(40px, -30px) scale(1.05); opacity: 0.6; }
        }
        @keyframes drift-2 {
            0%, 100% { transform: translate(0, 0) scale(1); opacity: 0.4; }
            33% { transform: translate(-40px, -50px) scale(1.15); opacity: 0.6; }
            66% { transform: translate(20px, -90px) scale(0.85); opacity: 0.3; }
        }
        @keyframes drift-3 {
            0%, 100% { transform: translate(0, 0); opacity: 0.3; }
            50% { transform: translate(50px, -60px); opacity: 0.6; }
        }
        .particle-1 { animation: drift-1 8s ease-in-out infinite; }
        .particle-2 { animation: drift-2 10s ease-in-out infinite; }
        .particle-3 { animation: drift-3 12s ease-in-out infinite; }

        /* ---- Rating bar shimmer ---- */
        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        .bar-shimmer {
            background: linear-gradient(90deg, #0e48c1 0%, #4f83f5 40%, #7ba8ff 50%, #4f83f5 60%, #0e48c1 100%);
            background-size: 200% 100%;
            animation: shimmer 3s ease-in-out infinite;
        }

        /* ---- Counter Animation ---- */
        @keyframes count-up {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ---- Hero mockup glow ring ---- */
        @keyframes ring-rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .ring-glow {
            position: absolute;
            border-radius: 50%;
            border: 2px solid transparent;
            border-top-color: rgba(14,72,193,0.15);
            border-right-color: rgba(79,131,245,0.1);
            animation: ring-rotate 15s linear infinite;
        }

        /* ---- Step connector pulse ---- */
        @keyframes dash-flow {
            to { stroke-dashoffset: -20; }
        }

        /* ---- Premium Button Shine ---- */
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
                rgba(255,255,255,0.25) 50%,
                rgba(255,255,255,0.1) 55%,
                transparent 100%
            );
            transform: rotate(25deg) translateX(-150%);
            transition: transform 0.6s ease;
        }
        .btn-shine:hover::after {
            transform: rotate(25deg) translateX(150%);
        }

        /* ---- Testimonial quote glow ---- */
        .quote-glow {
            position: relative;
        }
        .quote-glow::before {
            content: '\201C';
            position: absolute;
            top: -10px;
            left: 10px;
            font-size: 80px;
            font-family: Georgia, serif;
            color: rgba(14,72,193,0.06);
            line-height: 1;
            pointer-events: none;
        }

        /* ---- Scroll Progress Bar ---- */
        #scroll-progress {
            position: fixed;
            top: 0;
            left: 0;
            height: 3px;
            background: linear-gradient(90deg, #0e48c1, #4f83f5, #7ba8ff);
            z-index: 9999;
            width: 0%;
            transition: width 0.1s linear;
        }

        /* ---- Spotlight Card Effect ---- */
        .spotlight-card {
            --mouse-x: 50%;
            --mouse-y: 50%;
            position: relative;
        }
        .spotlight-card::after {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: inherit;
            opacity: 0;
            transition: opacity 0.4s ease;
            background: radial-gradient(
                400px circle at var(--mouse-x) var(--mouse-y),
                rgba(14,72,193,0.08),
                transparent 40%
            );
            pointer-events: none;
        }
        .spotlight-card:hover::after {
            opacity: 1;
        }

        /* ---- Marquee ---- */
        @keyframes marquee {
            from { transform: translateX(0); }
            to { transform: translateX(-50%); }
        }
        .animate-marquee {
            animation: marquee 30s linear infinite;
        }
        .animate-marquee:hover {
            animation-play-state: paused;
        }

        /* ---- Wave Divider ---- */
        .wave-divider {
            width: 100%;
            line-height: 0;
            overflow: hidden;
        }
        .wave-divider svg {
            width: 100%;
            height: auto;
            display: block;
        }

        /* ---- Staggered Reveal ---- */
        .stagger-reveal > * {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity 0.7s cubic-bezier(0.22, 1, 0.36, 1),
                        transform 0.7s cubic-bezier(0.22, 1, 0.36, 1);
        }
        .stagger-reveal.revealed > *:nth-child(1) { transition-delay: 0ms; opacity: 1; transform: none; }
        .stagger-reveal.revealed > *:nth-child(2) { transition-delay: 80ms; opacity: 1; transform: none; }
        .stagger-reveal.revealed > *:nth-child(3) { transition-delay: 160ms; opacity: 1; transform: none; }
        .stagger-reveal.revealed > *:nth-child(4) { transition-delay: 240ms; opacity: 1; transform: none; }
        .stagger-reveal.revealed > *:nth-child(5) { transition-delay: 320ms; opacity: 1; transform: none; }
        .stagger-reveal.revealed > *:nth-child(6) { transition-delay: 400ms; opacity: 1; transform: none; }

        /* ---- Animated Underline Nav ---- */
        .nav-link-animated {
            position: relative;
        }
        .nav-link-animated::after {
            content: '';
            position: absolute;
            bottom: 2px;
            left: 50%;
            width: 0;
            height: 2px;
            background: #0e48c1;
            border-radius: 2px;
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        .nav-link-animated:hover::after {
            width: 60%;
        }

        /* ---- Floating Geometric Shapes ---- */
        @keyframes geo-float-1 {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            25% { transform: translate(15px, -25px) rotate(90deg); }
            50% { transform: translate(-10px, -50px) rotate(180deg); }
            75% { transform: translate(20px, -20px) rotate(270deg); }
        }
        @keyframes geo-float-2 {
            0%, 100% { transform: translate(0, 0) rotate(0deg) scale(1); }
            50% { transform: translate(-30px, -40px) rotate(180deg) scale(1.1); }
        }
        @keyframes geo-float-3 {
            0%, 100% { transform: translate(0, 0) rotate(45deg); }
            50% { transform: translate(25px, -35px) rotate(225deg); }
        }
        .geo-shape-1 { animation: geo-float-1 12s ease-in-out infinite; }
        .geo-shape-2 { animation: geo-float-2 15s ease-in-out infinite; }
        .geo-shape-3 { animation: geo-float-3 18s ease-in-out infinite; }

        /* ---- Magnetic Button ---- */
        .magnetic-btn {
            transition: transform 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        /* ---- Glow Border ---- */
        @keyframes border-glow {
            0%, 100% { opacity: 0.3; }
            50% { opacity: 0.8; }
        }
        .animate-border-glow {
            animation: border-glow 3s ease-in-out infinite;
        }

        /* ---- Hero Text Word Reveal ---- */
        .word-reveal .word {
            display: inline-block;
            opacity: 0;
            transform: translateY(20px) rotateX(40deg);
            transition: opacity 0.5s ease, transform 0.6s cubic-bezier(0.22, 1, 0.36, 1);
            transform-origin: bottom center;
        }
        .word-reveal.revealed .word {
            opacity: 1;
            transform: translateY(0) rotateX(0deg);
        }

        /* ---- Premium Gradient Mesh BG ---- */
        @keyframes mesh-move {
            0%, 100% { transform: translate(0, 0) scale(1); }
            25% { transform: translate(30px, -20px) scale(1.05); }
            50% { transform: translate(-20px, 15px) scale(0.95); }
            75% { transform: translate(15px, 25px) scale(1.02); }
        }
        .mesh-blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            pointer-events: none;
        }
        .mesh-blob-1 { animation: mesh-move 20s ease-in-out infinite; }
        .mesh-blob-2 { animation: mesh-move 25s ease-in-out infinite reverse; }
        .mesh-blob-3 { animation: mesh-move 18s ease-in-out infinite; animation-delay: -5s; }
    </style>

    <!-- Scroll Progress -->
    <div id="scroll-progress"></div>

    <!-- Custom Cursor -->
    <div id="cursor-dot"
        class="hidden md:block fixed w-3 h-3 bg-[#0e48c1]/40 rounded-full pointer-events-none z-[9998] mix-blend-difference transition-transform duration-150 ease-out"
        style="transform: translate(-50%, -50%)"></div>
    <div id="cursor-ring"
        class="hidden md:block fixed w-8 h-8 border-2 border-[#0e48c1]/20 rounded-full pointer-events-none z-[9998] transition-all duration-300 ease-out"
        style="transform: translate(-50%, -50%)"></div>

    <!-- ==================== NAVBAR ==================== -->
    <header id="navbar"
        class="fixed top-0 inset-x-0 z-50 transition-all duration-500 border-b border-transparent">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-[72px]">
                <!-- Logo -->
                <a href="{{ route('landing') }}" class="flex items-center gap-3 group">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-[#0e48c1] to-[#4f83f5] rounded-xl flex items-center justify-center text-white shadow-[0_8px_25px_rgba(14,72,193,0.3)] group-hover:shadow-[0_8px_30px_rgba(14,72,193,0.5)] group-hover:scale-105 transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M12 3L1 9L5 11.18V17.18L12 21L19 17.18V11.18L21 10.09V17H23V9L12 3ZM18.82 9L12 12.72L5.18 9L12 5.28L18.82 9ZM17 15.99L12 18.72L7 15.99V12.27L12 15L17 12.27V15.99Z" />
                        </svg>
                    </div>
                    <span class="font-bold text-xl tracking-tight text-gray-900">Scholar <span
                            class="text-[#0e48c1]">Metric</span></span>
                </a>

                <!-- Desktop Nav -->
                <nav class="hidden md:flex items-center gap-1 glass-card rounded-full px-2 py-1.5 shadow-sm">
                    <a href="#features"
                        class="nav-link-animated px-4 py-2 text-sm font-semibold text-gray-600 hover:text-[#0e48c1] hover:bg-white/80 rounded-full transition-all duration-300">Features</a>
                    <a href="#how-it-works"
                        class="nav-link-animated px-4 py-2 text-sm font-semibold text-gray-600 hover:text-[#0e48c1] hover:bg-white/80 rounded-full transition-all duration-300">How
                        it works</a>
                    <a href="#testimonials"
                        class="nav-link-animated px-4 py-2 text-sm font-semibold text-gray-600 hover:text-[#0e48c1] hover:bg-white/80 rounded-full transition-all duration-300">Testimonials</a>
                </nav>

                <!-- Desktop Actions -->
                <div class="hidden md:flex items-center gap-3">
                    <a href="{{ route('login') }}"
                        class="px-5 py-2.5 text-sm font-bold text-gray-700 hover:text-[#0e48c1] transition-colors duration-300">Login</a>
                    <a href="{{ route('register') }}"
                        class="btn-shine px-5 py-2.5 bg-gradient-to-r from-[#0e48c1] to-[#1a5cd6] hover:from-[#0c3ca1] hover:to-[#0e48c1] text-white text-sm font-bold rounded-xl shadow-[0_8px_20px_rgba(14,72,193,0.25)] hover:shadow-[0_8px_30px_rgba(14,72,193,0.4)] transition-all duration-300 active:scale-[0.97]">Get
                        Started</a>
                </div>

                <!-- Mobile Toggle -->
                <button id="mobile-menu-btn" type="button"
                    class="md:hidden w-11 h-11 flex items-center justify-center rounded-xl glass-card text-gray-700 hover:bg-white/90 transition-all duration-300"
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
            class="md:hidden hidden mx-4 mb-4 rounded-2xl glass-card shadow-[0_20px_60px_rgba(0,0,0,0.1)] p-3">
            <nav class="flex flex-col gap-1">
                <a href="#features"
                    class="mobile-link px-4 py-3 text-sm font-bold text-gray-700 hover:bg-[#0e48c1]/5 hover:text-[#0e48c1] rounded-xl transition-all duration-300">Features</a>
                <a href="#how-it-works"
                    class="mobile-link px-4 py-3 text-sm font-bold text-gray-700 hover:bg-[#0e48c1]/5 hover:text-[#0e48c1] rounded-xl transition-all duration-300">How
                    it works</a>
                <a href="#testimonials"
                    class="mobile-link px-4 py-3 text-sm font-bold text-gray-700 hover:bg-[#0e48c1]/5 hover:text-[#0e48c1] rounded-xl transition-all duration-300">Testimonials</a>
                <div class="flex gap-2 pt-2 mt-2 border-t border-gray-100">
                    <a href="{{ route('login') }}"
                        class="mobile-link flex-1 text-center px-4 py-3 text-sm font-bold text-gray-700 border border-gray-200 rounded-xl hover:bg-gray-50 transition-all duration-300">Login</a>
                    <a href="{{ route('register') }}"
                        class="mobile-link flex-1 text-center px-4 py-3 text-sm font-bold bg-gradient-to-r from-[#0e48c1] to-[#1a5cd6] text-white rounded-xl hover:from-[#0c3ca1] hover:to-[#0e48c1] transition-all duration-300">Get
                        Started</a>
                </div>
            </nav>
        </div>
    </header>

    <!-- ==================== HERO ==================== -->
    <section class="relative pt-36 pb-16 lg:pt-44 lg:pb-24 overflow-hidden">
        <!-- Animated Background -->
        <div class="absolute inset-0 -z-20 bg-gradient-to-b from-[#f0f4ff] via-white to-white"></div>

        <!-- Decorative Radials -->
        <div class="absolute -top-40 -right-40 -z-10 w-[700px] h-[700px] rounded-full bg-[radial-gradient(circle_at_center,_rgba(14,72,193,0.12),_transparent_60%)] animate-glow"></div>
        <div class="absolute top-40 -left-52 -z-10 w-[600px] h-[600px] rounded-full bg-[radial-gradient(circle_at_center,_rgba(79,131,245,0.08),_transparent_60%)]"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 -z-10 w-[900px] h-[500px] bg-[radial-gradient(ellipse_at_center,_rgba(14,72,193,0.04),_transparent_70%)]"></div>

        <!-- Floating Particles -->
        <div class="particle particle-1 w-2 h-2 bg-[#0e48c1]/20 top-32 left-[15%] -z-10"></div>
        <div class="particle particle-2 w-3 h-3 bg-[#4f83f5]/15 top-48 right-[20%] -z-10"></div>
        <div class="particle particle-3 w-1.5 h-1.5 bg-[#0e48c1]/25 top-64 left-[35%] -z-10"></div>
        <div class="particle particle-1 w-2.5 h-2.5 bg-[#4f83f5]/10 top-20 right-[35%] -z-10" style="animation-delay: 2s"></div>
        <div class="particle particle-2 w-1.5 h-1.5 bg-[#0e48c1]/15 bottom-40 left-[25%] -z-10" style="animation-delay: 3s"></div>
        <div class="particle particle-3 w-2 h-2 bg-[#4f83f5]/20 bottom-32 right-[30%] -z-10" style="animation-delay: 1s"></div>

        <!-- Floating Geometric Shapes -->
        <svg class="geo-shape-1 absolute top-36 left-[8%] -z-10 w-16 h-16 text-[#0e48c1]/[0.07]" viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-width="1.5">
            <rect x="8" y="8" width="48" height="48" rx="8"/>
        </svg>
        <svg class="geo-shape-2 absolute top-24 right-[12%] -z-10 w-12 h-12 text-[#4f83f5]/[0.06]" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5">
            <polygon points="24,2 46,38 2,38"/>
        </svg>
        <svg class="geo-shape-3 absolute bottom-36 left-[12%] -z-10 w-10 h-10 text-[#0e48c1]/[0.05]" viewBox="0 0 40 40" fill="none" stroke="currentColor" stroke-width="1.5">
            <circle cx="20" cy="20" r="16"/>
        </svg>
        <svg class="geo-shape-1 absolute bottom-24 right-[8%] -z-10 w-14 h-14 text-[#4f83f5]/[0.06]" viewBox="0 0 56 56" fill="none" stroke="currentColor" stroke-width="1.5" style="animation-delay: -4s">
            <path d="M28 4L52 28L28 52L4 28Z"/>
        </svg>
        <svg class="geo-shape-2 absolute top-[45%] left-[3%] -z-10 w-8 h-8 text-[#0e48c1]/[0.04]" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="1.5" style="animation-delay: -7s">
            <polygon points="16,1 31,12 25,30 7,30 1,12"/>
        </svg>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto reveal">
                <!-- Badge -->
                <div
                    class="inline-flex items-center gap-2 glass-card rounded-full pl-2 pr-4 py-1.5 shadow-[0_4px_20px_rgba(0,0,0,0.04)] mb-8 premium-border">
                    <span
                        class="bg-gradient-to-r from-[#0e48c1] to-[#4f83f5] text-white text-[11px] font-extrabold uppercase tracking-wider px-2.5 py-1 rounded-full shadow-[0_2px_10px_rgba(14,72,193,0.3)]">New</span>
                    <span class="text-[13px] font-semibold text-gray-600">Smarter faculty evaluations are here</span>
                </div>

                <h1
                    class="text-4xl sm:text-5xl lg:text-[64px] font-extrabold tracking-tight leading-[1.08] text-gray-900 mb-6 word-reveal">
                    <span class="word">Elevating</span> <span class="word">Academic</span> <span class="word">Excellence</span> <span class="word">through</span>
                    <span class="word gradient-text">Informed</span> <span class="word gradient-text">Feedback.</span>
                </h1>

                <p class="text-lg sm:text-xl text-gray-500 font-medium leading-relaxed max-w-2xl mx-auto mb-10">
                    Scholar Metric is a sophisticated evaluation ecosystem that turns anonymous course feedback into
                    actionable insights for students, faculty, and administrators.
                </p>

                <!-- CTAs -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-14">
                    <a href="{{ route('register') }}"
                        class="magnetic-btn btn-shine w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-4 bg-gradient-to-r from-[#0e48c1] to-[#1a5cd6] hover:from-[#0c3ca1] hover:to-[#0e48c1] text-white font-bold rounded-xl shadow-[0_8px_25px_rgba(14,72,193,0.3)] hover:shadow-[0_12px_35px_rgba(14,72,193,0.45)] transition-all duration-300 focus:ring-4 focus:ring-blue-300 focus:outline-none transform active:scale-[0.98]">
                        Get Started Free
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                    <a href="#features"
                        class="magnetic-btn w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-4 glass-card hover:bg-white text-gray-800 font-bold rounded-xl shadow-sm hover:shadow-md transition-all duration-300 active:scale-[0.98] premium-border">
                        Explore Features
                    </a>
                </div>

                <!-- Trust row -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <div class="flex -space-x-3">
                        <img class="w-9 h-9 rounded-full border-2 border-white object-cover shadow-md bg-gray-200"
                            src="https://i.pravatar.cc/150?img=32" alt="Educator avatar">
                        <img class="w-9 h-9 rounded-full border-2 border-white object-cover shadow-md bg-gray-200"
                            src="https://i.pravatar.cc/150?img=12" alt="Educator avatar">
                        <img class="w-9 h-9 rounded-full border-2 border-white object-cover shadow-md bg-gray-200"
                            src="https://i.pravatar.cc/150?img=53" alt="Educator avatar">
                        <img class="w-9 h-9 rounded-full border-2 border-white object-cover shadow-md bg-gray-200"
                            src="https://i.pravatar.cc/150?img=26" alt="Educator avatar">
                        <span
                            class="w-9 h-9 rounded-full border-2 border-white bg-gradient-to-br from-[#0e48c1] to-[#4f83f5] text-white text-[10px] font-extrabold flex items-center justify-center shadow-md">2k+</span>
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
                    class="absolute inset-x-8 top-10 bottom-0 -z-10 bg-gradient-to-b from-[#0e48c1]/20 via-[#4f83f5]/10 to-transparent blur-3xl rounded-full animate-glow">
                </div>

                <!-- Decorative rotating ring -->
                <div class="ring-glow w-[110%] h-[110%] -top-[5%] -left-[5%] absolute -z-10"></div>

                <!-- Floating card: notification (left) -->
                <div
                    class="hidden lg:flex animate-float-slow absolute -left-16 top-24 z-20 items-center gap-3 glass-card rounded-2xl shadow-[0_20px_60px_rgba(0,0,0,0.08)] p-4 pr-6 premium-border">
                    <div
                        class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-400 to-emerald-500 text-white flex items-center justify-center flex-shrink-0 shadow-[0_4px_15px_rgba(16,185,129,0.3)]">
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
                    class="hidden lg:flex animate-float-slower absolute -right-14 bottom-24 z-20 items-center gap-3 glass-card rounded-2xl shadow-[0_20px_60px_rgba(0,0,0,0.08)] p-4 pr-6 premium-border">
                    <div class="relative w-11 h-11 flex-shrink-0">
                        <svg class="w-11 h-11 -rotate-90" viewBox="0 0 36 36">
                            <circle cx="18" cy="18" r="15.5" fill="none" stroke="#eef2f7" stroke-width="4" />
                            <circle cx="18" cy="18" r="15.5" fill="none" stroke="url(#scoreGrad)" stroke-width="4"
                                stroke-linecap="round" stroke-dasharray="87 97.4" />
                            <defs>
                                <linearGradient id="scoreGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                                    <stop offset="0%" stop-color="#0e48c1" />
                                    <stop offset="100%" stop-color="#4f83f5" />
                                </linearGradient>
                            </defs>
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
                    class="bg-white/90 backdrop-blur-sm rounded-[2rem] border border-gray-200/60 shadow-[0_40px_100px_-20px_rgba(13,38,89,0.2)] overflow-hidden">
                    <!-- Window bar -->
                    <div class="flex items-center gap-3 px-5 py-3.5 border-b border-gray-100 bg-gradient-to-r from-[#fafbfc] to-[#f8fafc]">
                        <div class="flex gap-1.5">
                            <span class="w-3 h-3 rounded-full bg-gradient-to-br from-red-400 to-red-500 shadow-[0_2px_6px_rgba(248,113,113,0.4)]"></span>
                            <span class="w-3 h-3 rounded-full bg-gradient-to-br from-amber-400 to-amber-500 shadow-[0_2px_6px_rgba(251,191,36,0.4)]"></span>
                            <span class="w-3 h-3 rounded-full bg-gradient-to-br from-emerald-400 to-emerald-500 shadow-[0_2px_6px_rgba(52,211,153,0.4)]"></span>
                        </div>
                        <div
                            class="mx-auto flex items-center gap-2 bg-white/80 border border-gray-100 rounded-lg px-4 py-1.5 text-xs font-semibold text-gray-400">
                            <svg class="w-3 h-3 text-emerald-500" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 1a5 5 0 00-5 5v3H6a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V11a2 2 0 00-2-2h-1V6a5 5 0 00-5-5zm-3 8V6a3 3 0 116 0v3H9z" />
                            </svg>
                            app.scholarmetric.edu/dashboard
                        </div>
                    </div>

                    <div class="grid grid-cols-12">
                        <!-- Mini sidebar -->
                        <div class="hidden md:flex col-span-1 flex-col items-center gap-2 py-6 border-r border-gray-100 bg-[#fafbfc]/80">
                            <div
                                class="w-9 h-9 rounded-xl bg-gradient-to-br from-[#0e48c1] to-[#4f83f5] text-white flex items-center justify-center shadow-[0_6px_15px_rgba(14,72,193,0.35)]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h4v-6h4v6h4a1 1 0 001-1V10" />
                                </svg>
                            </div>
                            <div class="w-9 h-9 rounded-xl text-gray-300 flex items-center justify-center hover:text-gray-400 transition-colors cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <div class="w-9 h-9 rounded-xl text-gray-300 flex items-center justify-center hover:text-gray-400 transition-colors cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                            <div class="w-9 h-9 rounded-xl text-gray-300 flex items-center justify-center hover:text-gray-400 transition-colors cursor-pointer">
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
                                    class="hidden sm:inline-flex items-center gap-1.5 bg-gradient-to-r from-emerald-50 to-emerald-100/50 text-emerald-600 text-[11px] font-extrabold px-3 py-1.5 rounded-full border border-emerald-200/50">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Live
                                </span>
                            </div>

                            <!-- Stat cards -->
                            <div class="grid grid-cols-3 gap-3 mb-6">
                                <div class="rounded-2xl border border-gray-100 bg-gradient-to-br from-[#f8fafc] to-white p-4 hover:shadow-md transition-shadow duration-300">
                                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wide">Avg. Rating</p>
                                    <p class="text-2xl font-extrabold gradient-text mt-1">4.7<span
                                            class="text-sm text-gray-400 font-bold">/5</span></p>
                                    <p class="text-[11px] font-bold text-emerald-500 mt-1 flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"/></svg>
                                        +0.4 vs last term
                                    </p>
                                </div>
                                <div class="rounded-2xl border border-gray-100 bg-gradient-to-br from-[#f8fafc] to-white p-4 hover:shadow-md transition-shadow duration-300">
                                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wide">Responses</p>
                                    <p class="text-2xl font-extrabold text-gray-900 mt-1">1,284</p>
                                    <p class="text-[11px] font-bold text-[#0e48c1] mt-1">86% participation</p>
                                </div>
                                <div class="rounded-2xl border border-gray-100 bg-gradient-to-br from-[#f8fafc] to-white p-4 hover:shadow-md transition-shadow duration-300">
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
                                    <div class="h-2.5 bg-gray-100 rounded-full overflow-hidden">
                                        <div class="h-full w-[94%] bar-shimmer rounded-full"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between text-xs font-bold mb-1.5">
                                        <span class="text-gray-700">Course Materials</span>
                                        <span class="text-[#0e48c1]">88%</span>
                                    </div>
                                    <div class="h-2.5 bg-gray-100 rounded-full overflow-hidden">
                                        <div class="h-full w-[88%] bar-shimmer rounded-full" style="animation-delay: 0.5s"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between text-xs font-bold mb-1.5">
                                        <span class="text-gray-700">Fair Assessment</span>
                                        <span class="text-[#0e48c1]">91%</span>
                                    </div>
                                    <div class="h-2.5 bg-gray-100 rounded-full overflow-hidden">
                                        <div class="h-full w-[91%] bar-shimmer rounded-full" style="animation-delay: 1s"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between text-xs font-bold mb-1.5">
                                        <span class="text-gray-700">Approachability</span>
                                        <span class="text-[#0e48c1]">96%</span>
                                    </div>
                                    <div class="h-2.5 bg-gray-100 rounded-full overflow-hidden">
                                        <div class="h-full w-[96%] bar-shimmer rounded-full" style="animation-delay: 1.5s"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right panel -->
                        <div class="col-span-12 md:col-span-4 border-t md:border-t-0 md:border-l border-gray-100 p-5 sm:p-7 bg-gradient-to-b from-[#fafbfc]/80 to-white">
                            <!-- Score ring -->
                            <div class="flex flex-col items-center py-2 mb-6">
                                <div class="relative w-32 h-32">
                                    <svg class="w-32 h-32 -rotate-90" viewBox="0 0 120 120">
                                        <circle cx="60" cy="60" r="52" fill="none" stroke="#eef2f7" stroke-width="10" />
                                        <circle cx="60" cy="60" r="52" fill="none" stroke="url(#ringGrad)" stroke-width="10"
                                            stroke-linecap="round" stroke-dasharray="307 327" />
                                        <defs>
                                            <linearGradient id="ringGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                                                <stop offset="0%" stop-color="#0e48c1" />
                                                <stop offset="100%" stop-color="#4f83f5" />
                                            </linearGradient>
                                        </defs>
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
                                    class="flex items-start gap-2.5 bg-white border border-gray-100 rounded-xl p-3 shadow-sm hover:shadow-md transition-shadow duration-300">
                                    <div
                                        class="w-7 h-7 rounded-lg bg-gradient-to-br from-blue-50 to-blue-100 text-[#0e48c1] flex items-center justify-center text-[11px] font-extrabold flex-shrink-0">
                                        ★</div>
                                    <p class="text-xs text-gray-600 font-medium leading-snug">"Explains complex topics
                                        with real-world examples."</p>
                                </div>
                                <div
                                    class="flex items-start gap-2.5 bg-white border border-gray-100 rounded-xl p-3 shadow-sm hover:shadow-md transition-shadow duration-300">
                                    <div
                                        class="w-7 h-7 rounded-lg bg-gradient-to-br from-blue-50 to-blue-100 text-[#0e48c1] flex items-center justify-center text-[11px] font-extrabold flex-shrink-0">
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

    <!-- ==================== TRUSTED BY MARQUEE ==================== -->
    <section class="py-12 lg:py-16 relative overflow-hidden">
        <div class="absolute inset-0 -z-10 bg-gradient-to-b from-white via-[#f8fafc]/50 to-white"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-8 reveal">
            <p class="text-center text-sm font-bold uppercase tracking-[0.2em] text-gray-400">Trusted by leading institutions worldwide</p>
        </div>
        <div class="relative">
            <!-- Fade edges -->
            <div class="absolute left-0 top-0 bottom-0 w-24 bg-gradient-to-r from-white to-transparent z-10 pointer-events-none"></div>
            <div class="absolute right-0 top-0 bottom-0 w-24 bg-gradient-to-l from-white to-transparent z-10 pointer-events-none"></div>
            <div class="flex animate-marquee">
                @foreach(['Northfield University', 'Crestwood College', 'Pacific Institute of Technology', 'Harborview State', 'Oakridge Academy', 'Summit University', 'Westlake Polytechnic', 'Brighton School of Arts', 'Northfield University', 'Crestwood College', 'Pacific Institute of Technology', 'Harborview State', 'Oakridge Academy', 'Summit University', 'Westlake Polytechnic', 'Brighton School of Arts'] as $i => $name)
                    <div class="flex-shrink-0 mx-6 lg:mx-10 flex items-center gap-3 px-6 py-3 rounded-xl border border-gray-100 bg-white/60 backdrop-blur-sm hover:border-[#0e48c1]/20 hover:shadow-[0_4px_20px_rgba(14,72,193,0.06)] transition-all duration-300 cursor-default group">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-gray-100 to-gray-50 flex items-center justify-center text-[#0e48c1]/60 group-hover:text-[#0e48c1] transition-colors duration-300">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <span class="text-sm font-bold text-gray-500 group-hover:text-gray-800 transition-colors duration-300 whitespace-nowrap">{{ $name }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Wave Divider -->
    <div class="wave-divider -mt-1">
        <svg viewBox="0 0 1440 60" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
            <path d="M0 30C240 60 480 0 720 30C960 60 1200 0 1440 30V60H0V30Z" fill="white" fill-opacity="0.5"/>
            <path d="M0 40C240 55 480 15 720 40C960 55 1200 15 1440 40V60H0V40Z" fill="#f8fafc" fill-opacity="0.3"/>
        </svg>
    </div>

    <!-- ==================== STATS STRIP ==================== -->
    <section class="border-y border-gray-100/60 bg-gradient-to-r from-[#f8fafc] via-white to-[#f8fafc] backdrop-blur">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
            <dl class="grid grid-cols-2 lg:grid-cols-4 gap-x-6 gap-y-10 text-center stagger-reveal">
                <div class="reveal">
                    <dt class="order-2 mt-2 text-sm font-bold uppercase tracking-wider text-gray-400">Active Educators
                    </dt>
                    <dd class="order-1 text-4xl lg:text-5xl font-extrabold gradient-text tracking-tight" data-counter="2000" data-suffix="+">0</dd>
                </div>
                <div class="reveal" style="transition-delay: 100ms">
                    <dt class="order-2 mt-2 text-sm font-bold uppercase tracking-wider text-gray-400">Evaluations
                        Processed</dt>
                    <dd class="order-1 text-4xl lg:text-5xl font-extrabold text-gray-900 tracking-tight" data-counter="58" data-suffix="k+">0</dd>
                </div>
                <div class="reveal" style="transition-delay: 200ms">
                    <dt class="order-2 mt-2 text-sm font-bold uppercase tracking-wider text-gray-400">Departments</dt>
                    <dd class="order-1 text-4xl lg:text-5xl font-extrabold text-gray-900 tracking-tight" data-counter="120" data-suffix="+">0</dd>
                </div>
                <div class="reveal" style="transition-delay: 300ms">
                    <dt class="order-2 mt-2 text-sm font-bold uppercase tracking-wider text-gray-400">Satisfaction Rate
                    </dt>
                    <dd class="order-1 text-4xl lg:text-5xl font-extrabold gradient-text tracking-tight" data-counter="96" data-suffix="%">0</dd>
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

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5 lg:gap-7 stagger-reveal">
                <!-- Feature 1 -->
                <div
                    class="reveal spotlight-card group bg-white rounded-[2rem] border border-gray-100 p-8 shadow-[0_10px_35px_rgba(0,0,0,0.04)] hover:shadow-[0_25px_60px_rgba(14,72,193,0.12)] hover:-translate-y-2 transition-all duration-500 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-[#0e48c1]/[0.02] to-[#4f83f5]/[0.04] opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div
                        class="relative w-[52px] h-[52px] rounded-2xl bg-gradient-to-br from-[#0e48c1]/10 to-[#4f83f5]/10 text-[#0e48c1] flex items-center justify-center mb-6 group-hover:bg-gradient-to-br group-hover:from-[#0e48c1] group-hover:to-[#4f83f5] group-hover:text-white group-hover:shadow-[0_8px_25px_rgba(14,72,193,0.35)] transition-all duration-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                        </svg>
                    </div>
                    <h3 class="relative text-lg font-extrabold text-gray-900 mb-2.5">Anonymous Feedback</h3>
                    <p class="relative text-[15px] text-gray-500 font-medium leading-relaxed">
                        Students share honest, identity-protected course reviews — so the signal is real, not filtered
                        by fear.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div
                    class="reveal spotlight-card group bg-white rounded-[2rem] border border-gray-100 p-8 shadow-[0_10px_35px_rgba(0,0,0,0.04)] hover:shadow-[0_25px_60px_rgba(14,72,193,0.12)] hover:-translate-y-2 transition-all duration-500 relative overflow-hidden"
                    style="transition-delay: 100ms">
                    <div class="absolute inset-0 bg-gradient-to-br from-[#0e48c1]/[0.02] to-[#4f83f5]/[0.04] opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div
                        class="relative w-[52px] h-[52px] rounded-2xl bg-gradient-to-br from-[#0e48c1]/10 to-[#4f83f5]/10 text-[#0e48c1] flex items-center justify-center mb-6 group-hover:bg-gradient-to-br group-hover:from-[#0e48c1] group-hover:to-[#4f83f5] group-hover:text-white group-hover:shadow-[0_8px_25px_rgba(14,72,193,0.35)] transition-all duration-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h3 class="relative text-lg font-extrabold text-gray-900 mb-2.5">Real-time Analytics</h3>
                    <p class="relative text-[15px] text-gray-500 font-medium leading-relaxed">
                        Live dashboards turn every submission into trends, ratings, and comparisons the moment they
                        arrive.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div
                    class="reveal spotlight-card group bg-white rounded-[2rem] border border-gray-100 p-8 shadow-[0_10px_35px_rgba(0,0,0,0.04)] hover:shadow-[0_25px_60px_rgba(14,72,193,0.12)] hover:-translate-y-2 transition-all duration-500 relative overflow-hidden"
                    style="transition-delay: 200ms">
                    <div class="absolute inset-0 bg-gradient-to-br from-[#0e48c1]/[0.02] to-[#4f83f5]/[0.04] opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div
                        class="relative w-[52px] h-[52px] rounded-2xl bg-gradient-to-br from-[#0e48c1]/10 to-[#4f83f5]/10 text-[#0e48c1] flex items-center justify-center mb-6 group-hover:bg-gradient-to-br group-hover:from-[#0e48c1] group-hover:to-[#4f83f5] group-hover:text-white group-hover:shadow-[0_8px_25px_rgba(14,72,193,0.35)] transition-all duration-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <h3 class="relative text-lg font-extrabold text-gray-900 mb-2.5">Course Management</h3>
                    <p class="relative text-[15px] text-gray-500 font-medium leading-relaxed">
                        Organize departments, courses, enrollments, and assignments in a clean, structured catalog.
                    </p>
                </div>

                <!-- Feature 4 -->
                <div
                    class="reveal spotlight-card group bg-white rounded-[2rem] border border-gray-100 p-8 shadow-[0_10px_35px_rgba(0,0,0,0.04)] hover:shadow-[0_25px_60px_rgba(14,72,193,0.12)] hover:-translate-y-2 transition-all duration-500 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-[#0e48c1]/[0.02] to-[#4f83f5]/[0.04] opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div
                        class="relative w-[52px] h-[52px] rounded-2xl bg-gradient-to-br from-[#0e48c1]/10 to-[#4f83f5]/10 text-[#0e48c1] flex items-center justify-center mb-6 group-hover:bg-gradient-to-br group-hover:from-[#0e48c1] group-hover:to-[#4f83f5] group-hover:text-white group-hover:shadow-[0_8px_25px_rgba(14,72,193,0.35)] transition-all duration-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </div>
                    <h3 class="relative text-lg font-extrabold text-gray-900 mb-2.5">Guided Evaluation Workflows</h3>
                    <p class="relative text-[15px] text-gray-500 font-medium leading-relaxed">
                        Step-by-step evaluation builders let admins launch structured review cycles in minutes.
                    </p>
                </div>

                <!-- Feature 5 -->
                <div
                    class="reveal spotlight-card group bg-white rounded-[2rem] border border-gray-100 p-8 shadow-[0_10px_35px_rgba(0,0,0,0.04)] hover:shadow-[0_25px_60px_rgba(14,72,193,0.12)] hover:-translate-y-2 transition-all duration-500 relative overflow-hidden"
                    style="transition-delay: 100ms">
                    <div class="absolute inset-0 bg-gradient-to-br from-[#0e48c1]/[0.02] to-[#4f83f5]/[0.04] opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div
                        class="relative w-[52px] h-[52px] rounded-2xl bg-gradient-to-br from-[#0e48c1]/10 to-[#4f83f5]/10 text-[#0e48c1] flex items-center justify-center mb-6 group-hover:bg-gradient-to-br group-hover:from-[#0e48c1] group-hover:to-[#4f83f5] group-hover:text-white group-hover:shadow-[0_8px_25px_rgba(14,72,193,0.35)] transition-all duration-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h3 class="relative text-lg font-extrabold text-gray-900 mb-2.5">Reports & Exports</h3>
                    <p class="relative text-[15px] text-gray-500 font-medium leading-relaxed">
                        Generate polished summaries and export to PDF or print-ready formats for committees and
                        accreditation.
                    </p>
                </div>

                <!-- Feature 6 -->
                <div
                    class="reveal spotlight-card group bg-white rounded-[2rem] border border-gray-100 p-8 shadow-[0_10px_35px_rgba(0,0,0,0.04)] hover:shadow-[0_25px_60px_rgba(14,72,193,0.12)] hover:-translate-y-2 transition-all duration-500 relative overflow-hidden"
                    style="transition-delay: 200ms">
                    <div class="absolute inset-0 bg-gradient-to-br from-[#0e48c1]/[0.02] to-[#4f83f5]/[0.04] opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div
                        class="relative w-[52px] h-[52px] rounded-2xl bg-gradient-to-br from-[#0e48c1]/10 to-[#4f83f5]/10 text-[#0e48c1] flex items-center justify-center mb-6 group-hover:bg-gradient-to-br group-hover:from-[#0e48c1] group-hover:to-[#4f83f5] group-hover:text-white group-hover:shadow-[0_8px_25px_rgba(14,72,193,0.35)] transition-all duration-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <h3 class="relative text-lg font-extrabold text-gray-900 mb-2.5">Role-based Access</h3>
                    <p class="relative text-[15px] text-gray-500 font-medium leading-relaxed">
                        Tailored dashboards for admins, faculty, and students — everyone sees exactly what matters to
                        them.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Wave Divider -->
    <div class="wave-divider">
        <svg viewBox="0 0 1440 50" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
            <path d="M0 25C360 50 720 0 1080 25C1260 37.5 1350 43.75 1440 25V50H0V25Z" fill="#f4f6f8" fill-opacity="0.5"/>
        </svg>
    </div>

    <!-- ==================== HOW IT WORKS ==================== -->
    <section id="how-it-works" class="py-20 lg:py-28 relative overflow-hidden">
        <!-- Background -->
        <div class="absolute inset-0 -z-10 bg-gradient-to-b from-[#f4f6f8]/50 via-white to-[#f4f6f8]/50"></div>
        <div
            class="absolute -bottom-40 left-1/2 -translate-x-1/2 -z-10 w-[700px] h-[500px] rounded-full bg-[radial-gradient(ellipse_at_center,_rgba(14,72,193,0.05),_transparent_70%)]">
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
                <div class="hidden md:block absolute top-[52px] left-[16%] right-[16%]">
                    <svg class="w-full h-4" preserveAspectRatio="none">
                        <line x1="0" y1="8" x2="100%" y2="8" stroke="url(#dashGrad)" stroke-width="2" stroke-dasharray="8 6" />
                        <defs>
                            <linearGradient id="dashGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                                <stop offset="0%" stop-color="#0e48c1" stop-opacity="0.1" />
                                <stop offset="50%" stop-color="#0e48c1" stop-opacity="0.3" />
                                <stop offset="100%" stop-color="#0e48c1" stop-opacity="0.1" />
                            </linearGradient>
                        </defs>
                    </svg>
                </div>

                <!-- Step 1 -->
                <div class="reveal relative text-center px-4">
                    <div
                        class="relative z-10 w-[104px] h-[104px] mx-auto mb-7 rounded-[2rem] bg-white border border-blue-100 shadow-[0_15px_40px_rgba(14,72,193,0.12)] flex items-center justify-center rotate-3 hover:rotate-0 hover:scale-105 transition-all duration-500">
                        <div
                            class="w-[76px] h-[76px] rounded-3xl bg-gradient-to-br from-[#0e48c1] to-[#4f83f5] flex items-center justify-center text-white shadow-[0_8px_25px_rgba(14,72,193,0.35)] -rotate-3 group-hover:rotate-0 transition-all duration-500">
                            <svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>
                        <span
                            class="absolute -top-2.5 -right-2.5 w-8 h-8 rounded-full bg-white border border-blue-100 shadow-md flex items-center justify-center text-[13px] font-extrabold text-[#0e48c1] rotate-6">1</span>
                    </div>
                    <span
                        class="inline-block bg-gradient-to-r from-[#0e48c1]/10 to-[#4f83f5]/10 text-[#0e48c1] text-[11px] font-extrabold uppercase tracking-wider px-3 py-1 rounded-full mb-3">Admin</span>
                    <h3 class="text-xl font-extrabold text-gray-900 mb-3">Create an Evaluation</h3>
                    <p class="text-[15px] text-gray-500 font-medium leading-relaxed max-w-xs mx-auto">
                        Admins build a guided evaluation in three quick steps — pick courses, set criteria, publish.
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="reveal relative text-center px-4" style="transition-delay: 150ms">
                    <div
                        class="relative z-10 w-[104px] h-[104px] mx-auto mb-7 rounded-[2rem] bg-white border border-blue-100 shadow-[0_15px_40px_rgba(14,72,193,0.12)] flex items-center justify-center -rotate-2 hover:rotate-0 hover:scale-105 transition-all duration-500">
                        <div
                            class="w-[76px] h-[76px] rounded-3xl bg-gradient-to-br from-[#0e48c1] to-[#4f83f5] flex items-center justify-center text-white shadow-[0_8px_25px_rgba(14,72,193,0.35)] rotate-2 hover:rotate-0 transition-all duration-500">
                            <svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                            </svg>
                        </div>
                        <span
                            class="absolute -top-2.5 -right-2.5 w-8 h-8 rounded-full bg-white border border-blue-100 shadow-md flex items-center justify-center text-[13px] font-extrabold text-[#0e48c1] rotate-6">2</span>
                    </div>
                    <span
                        class="inline-block bg-gradient-to-r from-[#0e48c1]/10 to-[#4f83f5]/10 text-[#0e48c1] text-[11px] font-extrabold uppercase tracking-wider px-3 py-1 rounded-full mb-3">Student</span>
                    <h3 class="text-xl font-extrabold text-gray-900 mb-3">Submit Honest Feedback</h3>
                    <p class="text-[15px] text-gray-500 font-medium leading-relaxed max-w-xs mx-auto">
                        Students rate courses and write anonymous reviews through a fast, friendly interface.
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="reveal relative text-center px-4" style="transition-delay: 300ms">
                    <div
                        class="relative z-10 w-[104px] h-[104px] mx-auto mb-7 rounded-[2rem] bg-white border border-blue-100 shadow-[0_15px_40px_rgba(14,72,193,0.12)] flex items-center justify-center rotate-2 hover:rotate-0 hover:scale-105 transition-all duration-500">
                        <div
                            class="w-[76px] h-[76px] rounded-3xl bg-gradient-to-br from-[#0e48c1] to-[#4f83f5] flex items-center justify-center text-white shadow-[0_8px_25px_rgba(14,72,193,0.35)] -rotate-2 hover:rotate-0 transition-all duration-500">
                            <svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </div>
                        <span
                            class="absolute -top-2.5 -right-2.5 w-8 h-8 rounded-full bg-white border border-blue-100 shadow-md flex items-center justify-center text-[13px] font-extrabold text-[#0e48c1] rotate-6">3</span>
                    </div>
                    <span
                        class="inline-block bg-gradient-to-r from-[#0e48c1]/10 to-[#4f83f5]/10 text-[#0e48c1] text-[11px] font-extrabold uppercase tracking-wider px-3 py-1 rounded-full mb-3">Faculty</span>
                    <h3 class="text-xl font-extrabold text-gray-900 mb-3">Act on Insights</h3>
                    <p class="text-[15px] text-gray-500 font-medium leading-relaxed max-w-xs mx-auto">
                        Faculty unlock analytics and trend reports that highlight strengths and where to grow next.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Wave Divider -->
    <div class="wave-divider">
        <svg viewBox="0 0 1440 50" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
            <path d="M0 25C360 0 720 50 1080 25C1260 12.5 1350 6.25 1440 25V50H0V25Z" fill="white"/>
        </svg>
    </div>

    <!-- ==================== TESTIMONIALS ==================== -->
    <section id="testimonials" class="py-20 lg:py-28 relative">
        <div class="absolute top-1/2 -left-40 -z-10 w-[500px] h-[500px] rounded-full bg-[radial-gradient(circle_at_center,_rgba(14,72,193,0.05),_transparent_65%)]"></div>

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
                    class="reveal bg-white rounded-[2rem] border border-gray-100 p-8 shadow-[0_10px_35px_rgba(0,0,0,0.04)] hover:shadow-[0_25px_60px_rgba(14,72,193,0.1)] hover:-translate-y-1.5 transition-all duration-500 flex flex-col quote-glow">
                    <div class="flex gap-1 text-amber-400 mb-5" aria-label="5 out of 5 stars">
                        @foreach ([1, 2, 3, 4, 5] as $star)
                            <svg class="w-4 h-4 drop-shadow-[0_1px_3px_rgba(251,191,36,0.4)]" fill="currentColor" viewBox="0 0 24 24">
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
                    class="reveal bg-white rounded-[2rem] border border-gray-100 p-8 shadow-[0_10px_35px_rgba(0,0,0,0.04)] hover:shadow-[0_25px_60px_rgba(14,72,193,0.1)] hover:-translate-y-1.5 transition-all duration-500 flex flex-col quote-glow"
                    style="transition-delay: 100ms">
                    <div class="flex gap-1 text-amber-400 mb-5" aria-label="5 out of 5 stars">
                        @foreach ([1, 2, 3, 4, 5] as $star)
                            <svg class="w-4 h-4 drop-shadow-[0_1px_3px_rgba(251,191,36,0.4)]" fill="currentColor" viewBox="0 0 24 24">
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
                    class="reveal bg-white rounded-[2rem] border border-gray-100 p-8 shadow-[0_10px_35px_rgba(0,0,0,0.04)] hover:shadow-[0_25px_60px_rgba(14,72,193,0.1)] hover:-translate-y-1.5 transition-all duration-500 flex flex-col quote-glow"
                    style="transition-delay: 200ms">
                    <div class="flex gap-1 text-amber-400 mb-5" aria-label="5 out of 5 stars">
                        @foreach ([1, 2, 3, 4, 5] as $star)
                            <svg class="w-4 h-4 drop-shadow-[0_1px_3px_rgba(251,191,36,0.4)]" fill="currentColor" viewBox="0 0 24 24">
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
                class="relative overflow-hidden rounded-[2.5rem] bg-gradient-to-br from-[#0e48c1] via-[#1257d8] to-[#0c3ca1] px-6 py-16 sm:px-12 lg:px-20 lg:py-20 text-center shadow-[0_35px_80px_-15px_rgba(14,72,193,0.5)]">
                <!-- Decorative blobs -->
                <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full bg-white/10 blur-3xl pointer-events-none animate-glow"></div>
                <div
                    class="absolute -bottom-32 -left-20 w-[420px] h-[420px] rounded-full bg-white/10 blur-3xl pointer-events-none animate-glow" style="animation-delay: 1.5s"></div>
                <div
                    class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[400px] bg-[radial-gradient(ellipse_at_center,_rgba(255,255,255,0.08),_transparent_70%)] pointer-events-none">
                </div>
                <!-- Grid pattern overlay -->
                <div class="absolute inset-0 opacity-[0.03] pointer-events-none" style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cpath d=&quot;M0 0h60v60H0z&quot; fill=&quot;none&quot;/%3E%3Cpath d=&quot;M60 0v60M0 0h60&quot; stroke=&quot;white&quot; stroke-width=&quot;0.5&quot;/%3E%3C/svg%3E')"></div>

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
                            class="magnetic-btn btn-shine w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-4 bg-white text-[#0e48c1] font-extrabold rounded-xl shadow-[0_10px_35px_rgba(0,0,0,0.2)] hover:bg-blue-50 hover:shadow-[0_15px_40px_rgba(0,0,0,0.25)] transition-all duration-300 active:scale-[0.98]">
                            Create Free Account
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                        <a href="{{ route('login') }}"
                            class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-4 border-2 border-white/30 hover:border-white/60 hover:bg-white/10 text-white font-bold rounded-xl transition-all duration-300 active:scale-[0.98]">
                            Sign In
                        </a>
                    </div>
                    <p class="mt-7 text-sm font-semibold text-blue-200/70">
                        No credit card required · Cancel anytime
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== FOOTER ==================== -->
    <footer class="border-t border-gray-100 bg-gradient-to-b from-[#f4f6f8]/60 to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 lg:py-16">
            <div class="grid gap-10 lg:grid-cols-12">
                <!-- Brand -->
                <div class="lg:col-span-5">
                    <a href="{{ route('landing') }}" class="flex items-center gap-3 mb-5 group">
                        <div class="w-10 h-10 bg-gradient-to-br from-[#0e48c1] to-[#4f83f5] rounded-xl flex items-center justify-center text-white shadow-[0_8px_25px_rgba(14,72,193,0.3)] group-hover:shadow-[0_8px_30px_rgba(14,72,193,0.5)] group-hover:scale-105 transition-all duration-300">
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
                        <img class="w-9 h-9 rounded-full border-2 border-white object-cover shadow-md bg-gray-200"
                            src="https://i.pravatar.cc/150?img=11" alt="Community member">
                        <img class="w-9 h-9 rounded-full border-2 border-white object-cover shadow-md bg-gray-200"
                            src="https://i.pravatar.cc/150?img=12" alt="Community member">
                        <img class="w-9 h-9 rounded-full border-2 border-white object-cover shadow-md bg-gray-200"
                            src="https://i.pravatar.cc/150?img=13" alt="Community member">
                    </div>
                </div>

                <!-- Links -->
                <div class="lg:col-span-7 grid grid-cols-2 sm:grid-cols-3 gap-8">
                    <div>
                        <h4 class="text-sm font-extrabold uppercase tracking-wider text-gray-900 mb-4">Product</h4>
                        <ul class="space-y-3 text-[15px] font-medium text-gray-500">
                            <li><a href="#features" class="hover:text-[#0e48c1] transition-colors duration-300">Features</a></li>
                            <li><a href="#how-it-works" class="hover:text-[#0e48c1] transition-colors duration-300">How it works</a>
                            </li>
                            <li><a href="#testimonials" class="hover:text-[#0e48c1] transition-colors duration-300">Testimonials</a>
                            </li>
                            <li><a href="{{ route('register') }}" class="hover:text-[#0e48c1] transition-colors duration-300">Get
                                    started</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-sm font-extrabold uppercase tracking-wider text-gray-900 mb-4">Roles</h4>
                        <ul class="space-y-3 text-[15px] font-medium text-gray-500">
                            <li><a href="{{ route('login') }}" class="hover:text-[#0e48c1] transition-colors duration-300">Admin
                                    portal</a></li>
                            <li><a href="{{ route('login') }}" class="hover:text-[#0e48c1] transition-colors duration-300">Faculty
                                    portal</a></li>
                            <li><a href="{{ route('login') }}" class="hover:text-[#0e48c1] transition-colors duration-300">Student
                                    portal</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-sm font-extrabold uppercase tracking-wider text-gray-900 mb-4">Support</h4>
                        <ul class="space-y-3 text-[15px] font-medium text-gray-500">
                            <li><a href="#" class="hover:text-[#0e48c1] transition-colors duration-300">Privacy Policy</a></li>
                            <li><a href="#" class="hover:text-[#0e48c1] transition-colors duration-300">System Status</a></li>
                            <li><a href="#" class="hover:text-[#0e48c1] transition-colors duration-300">Contact</a></li>
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
                    <span class="w-2 h-2 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.5)]"></span>
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
                    navbar.classList.add('bg-white/85', 'backdrop-blur-md', 'shadow-[0_10px_40px_rgba(0,0,0,0.08)]', 'border-gray-100/60');
                } else {
                    navbar.classList.remove('bg-white/85', 'backdrop-blur-md', 'shadow-[0_10px_40px_rgba(0,0,0,0.08)]', 'border-gray-100/60');
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
            }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

            document.querySelectorAll('.reveal, .stagger-reveal, .word-reveal').forEach(el => observer.observe(el));
        })();

        // Scroll Progress Bar
        (function () {
            const bar = document.getElementById('scroll-progress');
            window.addEventListener('scroll', () => {
                const scrollTop = document.documentElement.scrollTop;
                const scrollHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
                bar.style.width = (scrollTop / scrollHeight * 100) + '%';
            }, { passive: true });
        })();

        // Animated Counters
        (function () {
            const counters = document.querySelectorAll('[data-counter]');
            let animated = false;

            const animateCounters = () => {
                if (animated) return;
                const firstCounter = counters[0];
                if (!firstCounter) return;

                const rect = firstCounter.getBoundingClientRect();
                if (rect.top < window.innerHeight * 0.85) {
                    animated = true;
                    counters.forEach(counter => {
                        const target = parseInt(counter.dataset.counter);
                        const suffix = counter.dataset.suffix || '';
                        const duration = 2000;
                        const start = performance.now();

                        const easeOutQuart = (t) => 1 - Math.pow(1 - t, 4);

                        const tick = (now) => {
                            const elapsed = now - start;
                            const progress = Math.min(elapsed / duration, 1);
                            const eased = easeOutQuart(progress);
                            const current = Math.round(target * eased);

                            if (target >= 1000) {
                                counter.textContent = current.toLocaleString() + suffix;
                            } else {
                                counter.textContent = current + suffix;
                            }

                            if (progress < 1) requestAnimationFrame(tick);
                        };
                        requestAnimationFrame(tick);
                    });
                }
            };

            window.addEventListener('scroll', animateCounters, { passive: true });
            animateCounters();
        })();

        // Spotlight Card Effect
        (function () {
            document.querySelectorAll('.spotlight-card').forEach(card => {
                card.addEventListener('mousemove', (e) => {
                    const rect = card.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;
                    card.style.setProperty('--mouse-x', x + 'px');
                    card.style.setProperty('--mouse-y', y + 'px');
                });
            });
        })();

        // Custom Cursor
        (function () {
            if (window.matchMedia('(pointer: fine)').matches) {
                const dot = document.getElementById('cursor-dot');
                const ring = document.getElementById('cursor-ring');
                let mouseX = 0, mouseY = 0;
                let ringX = 0, ringY = 0;

                document.addEventListener('mousemove', (e) => {
                    mouseX = e.clientX;
                    mouseY = e.clientY;
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

                // Expand ring on interactive elements
                document.querySelectorAll('a, button, .spotlight-card').forEach(el => {
                    el.addEventListener('mouseenter', () => {
                        ring.style.width = '48px';
                        ring.style.height = '48px';
                        ring.style.borderColor = 'rgba(14,72,193,0.4)';
                        dot.style.transform = 'translate(-50%, -50%) scale(1.5)';
                    });
                    el.addEventListener('mouseleave', () => {
                        ring.style.width = '32px';
                        ring.style.height = '32px';
                        ring.style.borderColor = 'rgba(14,72,193,0.2)';
                        dot.style.transform = 'translate(-50%, -50%) scale(1)';
                    });
                });
            }
        })();

        // Magnetic Button Effect
        (function () {
            document.querySelectorAll('.magnetic-btn').forEach(btn => {
                btn.addEventListener('mousemove', (e) => {
                    const rect = btn.getBoundingClientRect();
                    const x = e.clientX - rect.left - rect.width / 2;
                    const y = e.clientY - rect.top - rect.height / 2;
                    btn.style.transform = `translate(${x * 0.2}px, ${y * 0.2}px)`;
                });
                btn.addEventListener('mouseleave', () => {
                    btn.style.transform = 'translate(0, 0)';
                });
            });
        })();

        // Smooth parallax on floating particles
        (function () {
            const particles = document.querySelectorAll('.particle');
            window.addEventListener('mousemove', (e) => {
                const x = (e.clientX / window.innerWidth - 0.5) * 20;
                const y = (e.clientY / window.innerHeight - 0.5) * 20;
                particles.forEach((p, i) => {
                    const speed = (i + 1) * 0.5;
                    p.style.transform = `translate(${x * speed}px, ${y * speed}px)`;
                });
            }, { passive: true });
        })();

        // Feature card tilt on mouse
        (function () {
            document.querySelectorAll('.spotlight-card').forEach(card => {
                card.addEventListener('mousemove', (e) => {
                    const rect = card.getBoundingClientRect();
                    const x = (e.clientX - rect.left) / rect.width - 0.5;
                    const y = (e.clientY - rect.top) / rect.height - 0.5;
                    card.style.transform = `perspective(800px) rotateY(${x * 5}deg) rotateX(${-y * 5}deg) translateY(-8px)`;
                });
                card.addEventListener('mouseleave', () => {
                    card.style.transform = 'perspective(800px) rotateY(0) rotateX(0) translateY(0)';
                });
            });
        })();
    </script>
</x-layout>
