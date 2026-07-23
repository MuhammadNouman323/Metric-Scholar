<x-layout>
    <div class="min-h-screen flex items-center justify-center bg-white px-6">
        <div class="text-center max-w-lg">
            <h1 class="text-[120px] font-bold text-gray-100 leading-none mb-4">500</h1>
            <h2 class="text-2xl font-bold text-gray-900 mb-3">Server error</h2>
            <p class="text-gray-500 font-medium mb-8">Something went wrong on our end. Please try again later.</p>
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2 bg-[#0e48c1] hover:bg-[#0c3ca1] text-white font-bold rounded-xl px-6 py-3.5 transition-all focus:ring-4 focus:ring-blue-300 shadow-[0_8px_20px_rgba(14,72,193,0.2)]">
                Go Home
            </a>
        </div>
    </div>
</x-layout>
