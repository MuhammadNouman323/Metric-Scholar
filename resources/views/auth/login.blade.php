<x-layout>
    <div class="min-h-screen bg-[#f8fafc] flex flex-col justify-center items-center p-4 sm:p-6 lg:p-8">
        
        <!-- Main Card Container -->
        <div class="w-full max-w-6xl bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.05)] overflow-hidden flex flex-col lg:flex-row min-h-[700px] border border-gray-100">
            
            <!-- Left Side - Light Gray with Abstract Pattern -->
            <div class="relative w-full lg:w-[45%] bg-[#f4f6f8] p-10 lg:p-14 flex flex-col justify-between overflow-hidden">
                <!-- Abstract Spherical Background Elements (simulated with CSS gradients) -->
                <!-- Top Right Sphere -->
                <div class="absolute -top-32 -right-32 w-96 h-96 rounded-full bg-gradient-to-br from-[#e2e8f0] to-transparent opacity-60 blur-3xl"></div>
                <!-- Bottom Center Sphere -->
                <div class="absolute -bottom-48 left-1/2 -translate-x-1/2 w-[600px] h-[600px] rounded-full bg-gradient-to-tr from-[#cbd5e1] to-transparent opacity-40 blur-2xl"></div>
                <!-- Network Graphic simulation (Placeholder text for the geometric lines in original image) -->
                <div class="absolute bottom-16 left-0 right-0 h-64 bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-white/20 via-transparent to-transparent opacity-50"></div>

                <!-- Content -->
                <div class="relative z-10 flex flex-col h-full items-start">
                    <!-- Logo -->
                    <div class="flex items-center gap-3 mb-16 lg:mb-20">
                        <div class="w-10 h-10 bg-[#0e48c1] rounded-xl flex items-center justify-center text-white flex-shrink-0 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 3L1 9L5 11.18V17.18L12 21L19 17.18V11.18L21 10.09V17H23V9L12 3ZM18.82 9L12 12.72L5.18 9L12 5.28L18.82 9ZM17 15.99L12 18.72L7 15.99V12.27L12 15L17 12.27V15.99Z"/>
                            </svg>
                        </div>
                        <span class="font-bold text-xl tracking-tight text-[#0e48c1]">Scholar Metric</span>
                    </div>

                    <!-- Heading & Paragraph -->
                    <div class="max-w-[420px]">
                        <h1 class="text-3xl sm:text-4xl lg:text-[44px] font-bold leading-[1.2] text-gray-900 mb-6 tracking-tight">
                            Elevating Academic<br />
                            Excellence through<br />
                            <span class="text-[#0e48c1]">Informed Feedback.</span>
                        </h1>
                        <p class="text-gray-600 text-base sm:text-[17px] leading-relaxed max-w-sm font-medium">
                            A sophisticated evaluation ecosystem designed for modern institutions and dedicated faculty.
                        </p>
                    </div>

                    <div class="flex-grow"></div>

                    <!-- Testimonial -->
                    <div class="bg-white/50 backdrop-blur-md rounded-2xl p-4 lg:p-5 border border-white/60 max-w-[340px] shadow-sm flex items-center gap-4 w-full">
                        <div class="flex -space-x-3">
                            <img class="w-9 h-9 rounded-full border-2 border-white object-cover shadow-sm bg-gray-200" src="https://i.pravatar.cc/150?img=11" alt="Avatar">
                            <img class="w-9 h-9 rounded-full border-2 border-white object-cover shadow-sm bg-gray-200" src="https://i.pravatar.cc/150?img=12" alt="Avatar">
                            <img class="w-9 h-9 rounded-full border-2 border-white object-cover shadow-sm bg-gray-200" src="https://i.pravatar.cc/150?img=13" alt="Avatar">
                        </div>
                        <div class="text-gray-600 font-semibold text-sm">Trusted by 2,000+ Educators</div>
                    </div>
                </div>
            </div>

            <!-- Right Side - Login Form -->
            <div class="w-full lg:w-[55%] flex flex-col justify-center p-8 sm:p-12 lg:p-20 xl:py-24 xl:px-28 bg-white">
                <div class="w-full max-w-[440px] mx-auto">
                    <!-- Header -->
                    <div class="mb-10 lg:mb-12">
                        <h2 class="text-[32px] font-bold text-gray-900 mb-2">Welcome Back</h2>
                        <p class="text-gray-500 font-medium">Please select your role and enter your credentials.</p>
                    </div>

                    <!-- Role Selector -->
                    <div class="grid grid-cols-3 gap-3 sm:gap-4 mb-8">
                        <!-- Admin (Active) -->
                        <label class="cursor-pointer">
                            <input type="radio" name="role" value="admin" form="login-form" class="peer sr-only" @checked(old('role', 'admin') === 'admin')>
                            <div class="border-2 border-gray-100 rounded-2xl p-4 sm:py-5 flex flex-col items-center justify-center gap-2 bg-white text-gray-400 transition-all peer-checked:border-[#0e48c1] peer-checked:text-[#0e48c1] peer-checked:shadow-[0_8px_20px_rgba(14,72,193,0.1)] hover:bg-gray-50">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                <span class="text-[13px] font-bold mt-1">Admin</span>
                            </div>
                        </label>
                        <!-- Student -->
                        <label class="cursor-pointer">
                            <input type="radio" name="role" value="student" form="login-form" class="peer sr-only" @checked(old('role') === 'student')>
                            <div class="border-2 border-gray-100 rounded-2xl p-4 sm:py-5 flex flex-col items-center justify-center gap-2 bg-gray-50/50 text-gray-500 transition-all peer-checked:border-[#0e48c1] peer-checked:bg-white peer-checked:text-[#0e48c1] peer-checked:shadow-[0_8px_20px_rgba(14,72,193,0.1)] hover:bg-gray-100/50">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                <span class="text-[13px] font-bold mt-1">Student</span>
                            </div>
                        </label>
                        <!-- Faculty -->
                        <label class="cursor-pointer">
                            <input type="radio" name="role" value="faculty" form="login-form" class="peer sr-only" @checked(old('role') === 'faculty')>
                            <div class="border-2 border-gray-100 rounded-2xl p-4 sm:py-5 flex flex-col items-center justify-center gap-2 bg-gray-50/50 text-gray-500 transition-all peer-checked:border-[#0e48c1] peer-checked:bg-white peer-checked:text-[#0e48c1] peer-checked:shadow-[0_8px_20px_rgba(14,72,193,0.1)] hover:bg-gray-100/50">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                                <span class="text-[13px] font-bold mt-1">Faculty</span>
                            </div>
                        </label>
                    </div>

                    <form id="login-form" method="POST" action="{{ route('auth.attempt') }}">
                        @csrf
                        <!-- Institutional Email -->
                        <div class="mb-5 relative">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Institutional Email</label>
                            <div class="relative flex items-center bg-[#f8fafc] rounded-xl overflow-hidden focus-within:ring-2 focus-within:ring-[#0e48c1] focus-within:bg-white transition-all border border-transparent focus-within:border-blue-200">
                                <div class="pl-4 text-gray-400">
                                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                </div>
                                <input type="email" name="email" value="{{ old('email') }}" class="w-full bg-transparent px-3 py-3.5 text-gray-900 font-medium placeholder:text-gray-400 placeholder:font-normal focus:outline-none text-[15px]" placeholder="name@institution.edu">
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="mb-6 relative">
                            <div class="flex justify-between items-center mb-2">
                                <label class="block text-sm font-bold text-gray-700">Password</label>
                                <a href="#" class="text-sm font-bold text-[#0e48c1] hover:underline">Forgot Password?</a>
                            </div>
                            <div class="relative flex items-center bg-[#f8fafc] rounded-xl overflow-hidden focus-within:ring-2 focus-within:ring-[#0e48c1] focus-within:bg-white transition-all border border-transparent focus-within:border-blue-200">
                                <div class="pl-4 text-gray-400">
                                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                </div>
                                <input type="password" name="password" class="w-full bg-transparent px-3 py-3.5 pr-12 text-gray-900 font-medium placeholder:text-gray-400 placeholder:font-normal focus:outline-none text-[15px] tracking-widest" placeholder="••••••••">
                                <button type="button" class="absolute inset-y-0 right-4 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none transition-colors">
                                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </button>
                            </div>
                        </div>

                        @error('email')
                            <div class="mb-4 text-red-500 text-sm font-bold">{{ $message }}</div>
                        @enderror

                        @error('role')
                            <div class="mb-4 text-red-500 text-sm font-bold">{{ $message }}</div>
                        @enderror

                        <!-- Checkbox -->
                        <div class="mb-8 flex items-center mt-1">
                            <input id="remember" name="remember" type="checkbox" @checked(old('remember')) class="w-4 h-4 text-[#0e48c1] bg-white border-gray-300 rounded focus:ring-[#0e48c1] focus:ring-2 cursor-pointer transition-colors shadow-sm">
                            <label for="remember" class="ml-2.5 text-sm text-gray-500 font-semibold cursor-pointer select-none">Remember Password</label>
                        </div>

                        <!-- Login Button -->
                        <button type="submit" class="w-full bg-[#0e48c1] hover:bg-[#0c3ca1] text-white font-bold rounded-xl py-4 transition-all focus:ring-4 focus:ring-blue-300 focus:outline-none shadow-[0_8px_20px_rgba(14,72,193,0.2)] hover:shadow-[0_8px_25px_rgba(14,72,193,0.3)] flex items-center justify-center gap-2 transform active:scale-[0.99]">
                            <span>Login</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </form>

                    <div id="register-link" class="mt-8 text-center">
                        <p class="text-sm text-gray-500 font-medium">
                            Don't have an account? <a href="/register" class="text-[#0e48c1] hover:text-[#0c3ca1] hover:underline font-bold transition-colors">Register</a>
                        </p>
                    </div>

                    <script>
                        (function () {
                            const registerLink = document.getElementById('register-link');
                            const roleInputs = document.querySelectorAll('input[name="role"]');

                            function toggleRegisterLink() {
                                const selected = document.querySelector('input[name="role"]:checked');
                                registerLink.style.display = (selected && selected.value === 'admin') ? 'block' : 'none';
                            }

                            roleInputs.forEach(input => input.addEventListener('change', toggleRegisterLink));
                            toggleRegisterLink();
                        })();
                    </script>
                </div>
            </div>

        </div>

        <!-- Footer -->
        <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4 text-[13px] font-semibold text-gray-400 max-w-4xl text-center">
            <span>© 2024 Scholar Metric Academic Systems. All rights reserved.</span>
            <span class="hidden sm:inline text-gray-300">|</span>
            <div class="flex gap-4">
                <a href="#" class="hover:text-gray-600 transition-colors">Privacy Policy</a>
                <a href="#" class="hover:text-gray-600 transition-colors">System Status</a>
            </div>
        </div>

    </div>
</x-layout>
