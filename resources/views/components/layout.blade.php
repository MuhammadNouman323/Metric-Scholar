<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/jpeg" href="{{ asset('favicon.jpg') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Outfit:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <title>{{ $title ?? 'Scholar Metric' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        *, *::before, *::after { -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; }
        html { font-family: 'Inter', 'Outfit', system-ui, -apple-system, sans-serif; scroll-behavior: smooth; }
        body { overflow-x: hidden; }
        .font-outfit { font-family: 'Outfit', 'Inter', sans-serif; }

        /* Scroll Progress Bar */
        #scroll-progress {
            position: fixed; top: 0; left: 0; height: 3px; width: 0%; z-index: 9999;
            background: linear-gradient(90deg, #0e48c1, #4f83f5, #0e48c1);
            background-size: 200% 100%;
            animation: shimmer-progress 2s ease-in-out infinite;
            transition: width 0.1s linear;
            border-radius: 0 4px 4px 0;
            box-shadow: 0 0 12px rgba(14,72,193,0.5);
        }
        @keyframes shimmer-progress {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #0e48c1, #4f83f5);
            border-radius: 999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, #0a3aa0, #3d6ae8);
        }
        * { scrollbar-width: thin; scrollbar-color: #0e48c1 transparent; }

        /* Selection */
        ::selection { background: rgba(14,72,193,0.15); color: #0e48c1; }

        /* Smooth page transitions */
        main > .min-h-full { animation: contentFadeIn 0.4s ease-out; }
        @keyframes contentFadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Focus visible ring */
        :focus-visible {
            outline: none;
            box-shadow: 0 0 0 2px rgba(14,72,193,0.3);
            border-radius: 8px;
        }

        /* Reduced motion */
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.001ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.001ms !important;
                scroll-behavior: auto !important;
            }
        }
    </style>
</head>

<body class="antialiased text-slate-900 font-sans bg-slate-50">
    <!-- Scroll Progress -->
    <div id="scroll-progress"></div>

    {{ $slot }}

    <script>
        (function() {
            var bar = document.getElementById('scroll-progress');
            if (!bar) return;
            var doc = document.documentElement;
            window.addEventListener('scroll', function() {
                var scrollTop = doc.scrollTop || document.body.scrollTop;
                var scrollHeight = doc.scrollHeight - doc.clientHeight;
                var pct = scrollHeight > 0 ? (scrollTop / scrollHeight) * 100 : 0;
                bar.style.width = pct + '%';
            }, { passive: true });
        })();

        (function() {
            document.querySelectorAll('.flash-message').forEach(function(el) {
                setTimeout(function() {
                    el.style.transition = 'opacity 0.5s ease';
                    el.style.opacity = '0';
                    setTimeout(function() { el.remove(); }, 500);
                }, 5000);
            });
        })();
    </script>
</body>

</html>
