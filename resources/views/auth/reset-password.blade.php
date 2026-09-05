<x-layout>
    <div class="min-h-screen bg-[#f8fafc] flex flex-col justify-center items-center p-4 sm:p-6 lg:p-8">

        <div class="w-full max-w-6xl bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.05)] overflow-hidden flex flex-col lg:flex-row min-h-[700px] border border-gray-100">

            <div class="relative w-full lg:w-[45%] bg-[#f4f6f8] p-10 lg:p-14 flex flex-col justify-between overflow-hidden">
                <div class="absolute -top-32 -right-32 w-96 h-96 rounded-full bg-gradient-to-br from-[#e2e8f0] to-transparent opacity-60 blur-3xl"></div>
                <div class="absolute -bottom-48 left-1/2 -translate-x-1/2 w-[600px] h-[600px] rounded-full bg-gradient-to-tr from-[#cbd5e1] to-transparent opacity-40 blur-2xl"></div>

                <div class="relative z-10 flex flex-col h-full items-start">
                    <div class="flex items-center gap-3 mb-16 lg:mb-20">
                        <div class="w-10 h-10 bg-[#0e48c1] rounded-xl flex items-center justify-center text-white flex-shrink-0 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 3L1 9L5 11.18V17.18L12 21L19 17.18V11.18L21 10.09V17H23V9L12 3ZM18.82 9L12 12.72L5.18 9L12 5.28L18.82 9ZM17 15.99L12 18.72L7 15.99V12.27L12 15L17 12.27V15.99Z"/>
                            </svg>
                        </div>
                        <span class="font-bold text-xl tracking-tight text-[#0e48c1]">Scholar Metric</span>
                    </div>

                    <div class="max-w-[420px]">
                        <h1 class="text-3xl sm:text-4xl lg:text-[44px] font-bold leading-[1.2] text-gray-900 mb-6 tracking-tight">
                            Secure Access<br />
                            <span class="text-[#0e48c1]">Recovery.</span>
                        </h1>
                        <p class="text-gray-600 text-base sm:text-[17px] leading-relaxed max-w-sm font-medium">
                            Choose a strong new password to restore access to your admin portal and maintain institutional security.
                        </p>
                    </div>

                    <div class="flex-grow"></div>

                    <div class="bg-white/50 backdrop-blur-md rounded-2xl p-4 lg:p-5 border border-white/60 max-w-[340px] shadow-sm w-full">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-[#eff4ff] rounded-lg flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-4 h-4 text-[#0e48c1]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-800 mb-0.5">Secure Account Recovery</p>
                                <p class="text-xs text-gray-500 font-medium">Choose a strong new password to restore secure access to your portal account.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full lg:w-[55%] flex flex-col justify-center p-8 sm:p-12 lg:p-20 xl:py-24 xl:px-28 bg-white">
                <div class="w-full max-w-[440px] mx-auto">

                    <div class="mb-10">
                        <div class="flex items-center justify-between mb-2">
                            <span class="inline-flex items-center gap-1.5 text-[11px] font-bold uppercase tracking-widest text-[#0e48c1] bg-[#eff4ff] px-3 py-1.5 rounded-full">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                Account Recovery
                            </span>
                        </div>
                        <h2 class="text-[32px] font-bold text-gray-900 mb-2">Reset your password</h2>
                        <p class="text-gray-500 font-medium text-[15px]">Your reset link is valid. Enter a new password for your account.</p>
                    </div>

                    @if(session('status'))
                        <div class="flash-message mb-6 bg-green-50 border border-green-200 rounded-xl px-5 py-4 flex items-start gap-3">
                            <svg class="w-5 h-5 text-green-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-sm font-semibold text-green-700">{{ session('status') }}</p>
                        </div>
                    @endif

                    @error('email')
                        <div class="flash-message mb-5 bg-red-50 border border-red-200 rounded-xl px-5 py-3 text-sm font-semibold text-red-600">
                            {{ $message }}
                        </div>
                    @enderror

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="mb-5">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Institutional Email</label>
                            <div class="relative flex items-center bg-[#f8fafc] rounded-xl overflow-hidden focus-within:ring-2 focus-within:ring-[#0e48c1] focus-within:bg-white transition-all border border-transparent focus-within:border-blue-200">
                                <div class="pl-4 text-gray-400">
                                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <input type="email" name="email" value="{{ $email ?? old('email') }}"
                                    class="w-full bg-transparent px-3 py-3.5 text-gray-900 font-medium placeholder:text-gray-400 placeholder:font-normal focus:outline-none text-[15px]"
                                    readonly required>
                            </div>
                        </div>

                        <div class="mb-5">
                            <label class="block text-sm font-bold text-gray-700 mb-2">New Password</label>
                            <div class="relative flex items-center bg-[#f8fafc] rounded-xl overflow-hidden focus-within:ring-2 focus-within:ring-[#0e48c1] focus-within:bg-white transition-all border border-transparent focus-within:border-blue-200">
                                <div class="pl-4 text-gray-400">
                                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <input type="password" name="password"
                                    class="w-full bg-transparent px-3 py-3.5 text-gray-900 font-medium placeholder:text-gray-400 placeholder:font-normal focus:outline-none text-[15px] tracking-widest"
                                    placeholder="••••••••" required autofocus>
                            </div>
                            @error('password')
                                <p class="mt-1.5 text-xs font-semibold text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Confirm New Password</label>
                            <div class="relative flex items-center bg-[#f8fafc] rounded-xl overflow-hidden focus-within:ring-2 focus-within:ring-[#0e48c1] focus-within:bg-white transition-all border border-transparent focus-within:border-blue-200">
                                <div class="pl-4 text-gray-400">
                                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <input type="password" name="password_confirmation"
                                    class="w-full bg-transparent px-3 py-3.5 text-gray-900 font-medium placeholder:text-gray-400 placeholder:font-normal focus:outline-none text-[15px] tracking-widest"
                                    placeholder="••••••••" required>
                            </div>
                        </div>

                        <button type="submit"
                            class="w-full bg-[#0e48c1] hover:bg-[#0c3ca1] text-white font-bold rounded-xl py-4 transition-all focus:ring-4 focus:ring-blue-300 focus:outline-none shadow-[0_8px_20px_rgba(14,72,193,0.2)] hover:shadow-[0_8px_25px_rgba(14,72,193,0.3)] flex items-center justify-center gap-2 transform active:scale-[0.99]">
                            <span>Reset Password</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </button>
                    </form>

                    <div class="mt-8 text-center">
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-sm font-bold text-[#0e48c1] hover:underline">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back to Login
                        </a>
                    </div>
                </div>
            </div>

        </div>

        <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4 text-[13px] font-semibold text-gray-400 max-w-4xl text-center">
            <span>© {{ date('Y') }} Scholar Metric Academic Systems. All rights reserved.</span>
            <span class="hidden sm:inline text-gray-300">|</span>
            <div class="flex gap-4">
                <a href="#" class="hover:text-gray-600 transition-colors">Privacy Policy</a>
                <a href="#" class="hover:text-gray-600 transition-colors">Institutional Security</a>
            </div>
        </div>

    </div>
</x-layout>
