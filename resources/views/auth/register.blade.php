<x-layout>
    <div class="min-h-screen flex flex-col lg:flex-row">
        <!-- Left Side - Blue Branding -->
        <div class="relative bg-blue-900 text-white flex flex-col justify-between p-8 lg:p-16 h-full min-h-[50vh] lg:min-h-screen lg:w-[45%] overflow-hidden">
            <!-- Background Image Overlay (simulating the architectural building image in the provided design) -->
            <div class="absolute inset-0 z-0">
                <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2070&auto=format&fit=crop" class="w-full h-full object-cover opacity-30" alt="Architecture background">
                <div class="absolute inset-0 bg-blue-900/40 mix-blend-multiply"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-blue-900 via-blue-900/60 to-transparent"></div>
            </div>

            <!-- Content -->
            <div class="relative z-10 flex flex-col h-full justify-between">
                <div>
                    <!-- Logo -->
                    <div class="flex items-center gap-3 mb-16 lg:mb-24">
                        <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-blue-900 flex-shrink-0 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 3L1 9L5 11.18V17.18L12 21L19 17.18V11.18L21 10.09V17H23V9L12 3ZM18.82 9L12 12.72L5.18 9L12 5.28L18.82 9ZM17 15.99L12 18.72L7 15.99V12.27L12 15L17 12.27V15.99Z"/>
                            </svg>
                        </div>
                        <span class="font-bold text-xl tracking-tight">Scholar Metric</span>
                    </div>

                    <!-- Heading & Paragraph -->
                    <div class="max-w-xl left-content">
                        <h1 class="text-4xl lg:text-5xl xl:text-6xl font-bold leading-[1.1] mb-6">
                            Institutional<br/>
                            Excellence<br/>
                            through<br/>
                            Administrative<br/>
                            Precision.
                        </h1>
                        <p class="text-blue-100 text-base lg:text-lg xl:text-xl leading-relaxed max-w-md">
                            A robust academic evaluation ecosystem designed for modern universities. Streamlining tenure reviews, faculty feedback, and departmental performance with surgical accuracy.
                        </p>
                    </div>
                </div>

                <!-- Testimonial Box -->
                <div class="mt-16 lg:mt-24">
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-5 lg:p-6 border border-white/20 max-w-sm">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="flex -space-x-2">
                                <img class="w-8 h-8 lg:w-9 lg:h-9 rounded-full border-2 border-blue-900 object-cover" src="https://i.pravatar.cc/150?img=11" alt="Avatar">
                                <img class="w-8 h-8 lg:w-9 lg:h-9 rounded-full border-2 border-blue-900 object-cover" src="https://i.pravatar.cc/150?img=12" alt="Avatar">
                                <div class="w-8 h-8 lg:w-9 lg:h-9 rounded-full border-2 border-blue-900 bg-gray-200 text-gray-700 flex items-center justify-center text-[10px] lg:text-xs font-semibold z-10">+4k</div>
                            </div>
                            <div class="text-blue-50 font-medium text-sm lg:text-base">Trusted by 450+ Institutions</div>
                        </div>
                        <p class="text-xs lg:text-sm text-blue-100/90 leading-relaxed font-medium">
                            "The transition to Scholar Metric redefined how our department handles faculty growth and evaluation cycles."
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - White Registration Form -->
        <div class="w-full lg:w-[55%] flex items-center justify-center p-6 sm:p-12 lg:p-16 xl:p-24 bg-white relative">
            <div class="w-full max-w-md lg:max-w-lg xl:max-w-[480px]">
                <div class="mb-10 lg:mb-12">
                    <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Admin Registration</h2>
                    <p class="text-gray-500 font-medium text-sm lg:text-base">Create an institutional administrator account.</p>
                </div>

                <form>
                    <!-- Full Name -->
                    <div class="mb-5 lg:mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Full Name</label>
                        <input type="text" class="w-full bg-gray-50/50 border border-transparent rounded-xl px-4 py-3 text-gray-900 font-medium placeholder:text-gray-400 placeholder:font-normal focus:outline-none focus:ring-2 focus:ring-blue-600 focus:bg-white focus:border-blue-200 transition-all" placeholder="Dr. Julian Vane">
                    </div>

                    <!-- Institutional Email -->
                    <div class="mb-5 lg:mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Institutional Email</label>
                        <div class="relative flex items-center bg-gray-50/50 rounded-xl overflow-hidden focus-within:ring-2 focus-within:ring-blue-600 focus-within:bg-white transition-all border border-transparent focus-within:border-blue-200">
                            <input type="text" class="flex-1 bg-transparent px-4 py-3 text-gray-900 font-medium placeholder:text-gray-400 placeholder:font-normal focus:outline-none" placeholder="j.vane">
                            <span class="pr-5 font-medium text-gray-500 text-sm whitespace-nowrap hidden sm:block">@scholarmetric.edu</span>
                        </div>
                    </div>

                    <!-- ID and Department -->
                    <div class="flex flex-col sm:flex-row gap-5 mb-5 lg:mb-6">
                        <div class="flex-1">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Administrator ID</label>
                            <input type="text" class="w-full bg-gray-50/50 border border-transparent rounded-xl px-4 py-3 text-gray-900 font-medium placeholder:text-gray-400 placeholder:font-normal focus:outline-none focus:ring-2 focus:ring-blue-600 focus:bg-white focus:border-blue-200 transition-all" placeholder="ADM-9942">
                        </div>
                        <div class="flex-1">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Department/Unit</label>
                            <input type="text" class="w-full bg-gray-50/50 border border-transparent rounded-xl px-4 py-3 text-gray-900 font-medium placeholder:text-gray-400 placeholder:font-normal focus:outline-none focus:ring-2 focus:ring-blue-600 focus:bg-white focus:border-blue-200 transition-all" placeholder="Arts & Sciences">
                        </div>
                    </div>

                    <!-- Access Level -->
                    <div class="mb-5 lg:mb-6 relative">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Access Level</label>
                        <select class="w-full bg-gray-50/50 border border-transparent rounded-xl px-4 py-3 text-gray-900 font-medium appearance-none focus:outline-none focus:ring-2 focus:ring-blue-600 focus:bg-white focus:border-blue-200 transition-all cursor-pointer">
                            <option>Full Access</option>
                            <option>Partial Access</option>
                            <option>Read Only</option>
                        </select>
                        <div class="absolute inset-y-0 right-4 top-[30px] flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="mb-6 lg:mb-8 relative">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                        <div class="relative">
                            <!-- Since value is given in design as dots, let's just make it blank with placeholder or actual dots. A placeholder is fine. -->
                            <!-- Or using value="password" if we want to visually simulate the dots. But it's a form, we'll just omit value. -->
                            <input type="password" class="w-full bg-gray-50/50 border border-transparent rounded-xl px-4 py-3 pr-12 text-gray-900 font-medium placeholder:text-gray-400 placeholder:font-normal focus:outline-none focus:ring-2 focus:ring-blue-600 focus:bg-white focus:border-blue-200 transition-all" placeholder="••••••••••••">
                            <button type="button" class="absolute inset-y-0 right-4 flex items-center text-gray-500 hover:text-gray-700 p-1 transition-colors">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Checkbox -->
                    <div class="mb-10 flex items-start">
                        <div class="flex items-center h-5 mt-0.5">
                            <input id="terms" type="checkbox" class="w-4 h-4 text-blue-700 bg-gray-50 border-gray-300 rounded focus:ring-blue-600 focus:ring-2 cursor-pointer">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="terms" class="text-gray-600 font-medium cursor-pointer select-none">I agree to the institutional data privacy terms.</label>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full bg-[#0e48c1] hover:bg-blue-800 text-white font-semibold rounded-xl py-4 transition-colors focus:ring-4 focus:ring-blue-300 focus:outline-none shadow-sm flex items-center justify-center">
                        Create Admin Account
                    </button>
                </form>

                <p class="mt-8 text-center text-sm text-gray-600 font-medium">
                    Already have an account? <a href="/" class="text-[#0e48c1] hover:text-blue-800 hover:underline font-semibold transition-colors">Sign In</a>
                </p>
            </div>
        </div>
    </div>
</x-layout>
