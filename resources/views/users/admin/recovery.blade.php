<x-admin>
    <div class="p-6 md:p-10 lg:p-12 pb-24 max-w-[1200px] mx-auto min-h-screen space-y-8">

        <!-- Breadcrumbs -->
        <nav class="text-sm font-semibold text-gray-500 flex items-center gap-2">
            <a href="/admin/students" class="hover:text-gray-900 transition-colors">Users</a>
            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <a href="{{ route('admin.users.edit', $user) }}" class="hover:text-gray-900 transition-colors">User Profile</a>
            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <span class="text-gray-900 font-bold">Reset Password</span>
        </nav>

        <!-- Header -->
        <div>
            <h1 class="text-[32px] font-bold text-gray-900 tracking-tight">Account Recovery</h1>
            <p class="text-gray-500 text-[15px] font-medium mt-1">Manage access credentials securely. All manual resets are logged for institutional auditing purposes.</p>
        </div>

        @if (session('success'))
            <div class="flash-message rounded-2xl border border-green-200 bg-green-50 px-6 py-4 text-sm font-bold text-green-700 shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="flash-message rounded-2xl border border-red-200 bg-red-50 px-6 py-4 text-sm font-bold text-red-700 shadow-sm">
                {{ session('error') }}
            </div>
        @endif

        <!-- Main Grid Layout -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">

            <!-- Left Column: Recovery Form (Spans 2 columns on XL) -->
            <div class="xl:col-span-2 space-y-8">

                <!-- User Card Info -->
                <div class="bg-white rounded-[2rem] p-6 border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.02)] flex flex-col sm:flex-row items-center gap-6">
                    <img class="w-16 h-16 rounded-full border-4 border-white shadow-md object-cover bg-gray-50 shrink-0"
                        src="{{ $user->avatar_url }}"
                        alt="{{ $user->name }}">
                    <div class="flex-grow text-center sm:text-left">
                        <div class="flex flex-col sm:flex-row sm:items-center gap-2 justify-center sm:justify-start">
                            <h2 class="text-[18px] font-extrabold text-gray-900">{{ $user->name }}</h2>
                            <span class="inline-flex self-center sm:self-auto px-2.5 py-0.5 bg-blue-50 text-[#0e48c1] text-[11px] font-extrabold rounded-full uppercase tracking-wider">
                                {{ ucfirst($user->role->value) }}
                            </span>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:items-center gap-x-4 gap-y-1 text-sm text-gray-500 font-medium mt-1.5 justify-center sm:justify-start">
                            <span class="flex items-center gap-1.5 justify-center sm:justify-start">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                {{ $user->email }}
                            </span>
                            <span class="hidden sm:inline text-gray-300">•</span>
                            <span class="flex items-center gap-1.5 justify-center sm:justify-start">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                Department of {{ $user->department ?? 'General' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Select Recovery Method Section -->
                <div class="bg-white rounded-[2rem] p-8 md:p-10 border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.02)] space-y-8">
                    <h3 class="text-[17px] font-extrabold text-gray-900 tracking-tight">Select Recovery Method</h3>

                    <!-- Send Recovery Link Subcard -->
                    <div class="border border-gray-100 bg-gray-50/50 rounded-2xl p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
                        <div class="flex items-start gap-4">
                            <div class="w-11 h-11 bg-white border border-gray-150 rounded-xl flex items-center justify-center shrink-0 shadow-sm text-gray-500">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 19v-8.93a2 2 0 01.89-1.664l8-5.333a2 2 0 012.22 0l8 5.333A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-2.25-1.5a2 2 0 00-2.22 0l-2.25 1.5M12 14.25v.75m0 0h.01"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-gray-900 flex items-center gap-1.5">
                                    Send Recovery Link
                                </h4>
                                <p class="text-xs text-gray-500 font-medium leading-relaxed mt-1">Generates a secure, time-sensitive link sent directly to the user's institutional email address.</p>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('admin.users.recovery.email', $user) }}" class="shrink-0">
                            @csrf
                            <button type="submit"
                                class="bg-white border-2 border-gray-200 text-[#0e48c1] hover:text-blue-800 hover:border-[#0e48c1]/30 font-bold rounded-xl py-3 px-5 text-sm transition-all shadow-sm flex items-center gap-2">
                                Send Email
                                <svg class="w-4 h-4 transform rotate-45" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                            </button>
                        </form>
                    </div>

                    <!-- Divider OR MANUAL OVERRIDE -->
                    <div class="relative flex py-4 items-center">
                        <div class="flex-grow border-t border-gray-100"></div>
                        <span class="flex-shrink mx-4 text-[10px] font-bold tracking-widest text-gray-400 uppercase">Or Manual Override</span>
                        <div class="flex-grow border-t border-gray-100"></div>
                    </div>

                    <!-- Generate Temporary Password Section -->
                    <form method="POST" action="{{ route('admin.users.recovery.password', $user) }}" class="space-y-6">
                        @csrf
                        <div class="space-y-4">
                            <div class="flex items-start gap-4">
                                <div class="w-11 h-11 bg-white border border-gray-150 rounded-xl flex items-center justify-center shrink-0 shadow-sm text-gray-500">
                                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m-3.414-1.414A2 2 0 1119 4V7h-3zM8.293 15.293a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414l4-4zM6 16v2h2v-2H6z"></path>
                                    </svg>
                                </div>
                                <div class="flex-grow">
                                    <h4 class="text-sm font-bold text-gray-900">Generate Temporary Password</h4>
                                </div>
                            </div>

                            <div class="flex gap-3 items-center">
                                <div class="relative flex-1">
                                    <input type="text" id="tempPasswordInput" name="password" readonly
                                        placeholder="Click generate..."
                                        class="w-full bg-[#f4f6f8] border border-transparent rounded-xl pl-4 pr-10 py-3.5 text-sm font-mono tracking-widest text-gray-900 focus:outline-none placeholder:text-gray-400 placeholder:font-sans placeholder:tracking-normal transition-all"
                                        value="{{ old('password') }}">
                                    <button type="button" onclick="copyPasswordToClipboard()"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors"
                                        title="Copy to clipboard">
                                        <svg id="copyIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path>
                                        </svg>
                                        <svg id="checkIcon" class="w-5 h-5 text-emerald-500 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </button>
                                </div>
                                <button type="button" onclick="generatePassword()"
                                    class="bg-gray-100 text-[#0e48c1] hover:bg-gray-200 font-bold px-6 py-3.5 rounded-xl text-sm transition-all shrink-0">
                                    Generate
                                </button>
                            </div>
                            @error('password')
                                <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="text-[12px] text-gray-400 font-semibold flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Communicating this password is the responsibility of the administrator.
                            </p>
                        </div>

                        <!-- Force Password Change checkbox -->
                        <div class="flex items-start gap-3 border-t border-gray-100 pt-6">
                            <input type="checkbox" name="force_change" value="1" id="forceChangeCheckbox"
                                class="mt-1 w-4 h-4 text-[#0e48c1] border-gray-300 rounded focus:ring-[#0e48c1] transition-all cursor-pointer"
                                @checked(old('force_change', 1))>
                            <label for="forceChangeCheckbox" class="cursor-pointer select-none">
                                <span class="block text-sm font-bold text-gray-900">Force password change on next login</span>
                                <span class="block text-xs text-gray-500 font-medium leading-relaxed mt-0.5">User will be prompted to create a new password immediately after authentication.</span>
                            </label>
                        </div>

                        <!-- Form submission action buttons -->
                        <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-100">
                            <a href="{{ route('admin.users.edit', $user) }}"
                                class="bg-white border-2 border-gray-250 text-gray-700 hover:bg-gray-50 hover:border-gray-350 px-8 py-3.5 rounded-xl text-sm font-bold transition-all shadow-sm">
                                Cancel
                            </a>
                            <button type="submit" id="confirmResetBtn" disabled
                                class="bg-[#0e48c1] hover:bg-blue-800 disabled:opacity-40 disabled:cursor-not-allowed text-white font-bold rounded-xl py-3.5 px-8 text-sm transition-all hover:shadow-[0_4px_12px_rgba(14,72,193,0.3)] shadow-[0_4px_10px_rgba(14,72,193,0.15)] flex items-center justify-center">
                                Confirm Reset
                            </button>
                        </div>
                    </form>
                </div>

            </div>

            <!-- Right Column: Compliance and Sidebar Warnings -->
            <div class="space-y-6 lg:space-y-8">

                <!-- Security Protocol Widget -->
                <div class="bg-white border border-gray-100 rounded-[2rem] p-7 shadow-sm space-y-6">
                    <div class="flex items-center gap-3">
                        <div class="text-blue-600 bg-blue-50 p-2 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <h3 class="text-[15px] font-bold text-gray-900">Security Protocol</h3>
                    </div>
                    <p class="text-xs text-gray-500 font-medium leading-relaxed">To maintain institutional compliance, all generated passwords must adhere to Scholar Metric's strict security entropy requirements.</p>

                    <ul class="space-y-4">
                        <li class="flex items-start gap-2.5">
                            <svg class="w-4 h-4 text-blue-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-xs text-gray-600 font-medium">Minimum of 14 characters in length.</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <svg class="w-4 h-4 text-blue-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-xs text-gray-600 font-medium">Must include mixed case, numbers, and symbols.</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <svg class="w-4 h-4 text-blue-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-xs text-gray-600 font-medium">Cannot contain the user's name, email, or common dictionary words.</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <svg class="w-4 h-4 text-blue-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-xs text-gray-600 font-medium">Expires automatically after 24 hours if unused.</span>
                        </li>
                    </ul>
                </div>

                <!-- Audit Notice Card -->
                <div class="bg-[#fdf0e9] border border-[#fbd4c2] rounded-[1.5rem] p-6 space-y-3 relative overflow-hidden shadow-sm">
                    <div class="flex items-center gap-2 text-[#c65e31]">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        <h4 class="text-xs font-black uppercase tracking-wider">Audit Notice</h4>
                    </div>
                    <p class="text-xs text-[#b85327] font-medium leading-relaxed">
                        This action is tied to your Admin ID. Ensure verbal or secure out-of-band communication for manual passwords.
                    </p>
                </div>

            </div>

        </div>

    </div>

    <!-- Password Generation and Copy script -->
    <script>
        function generatePassword() {
            const uppercase = "ABCDEFGHJKLMNPQRSTUVWXYZ";
            const lowercase = "abcdefghijkmnopqrstuvwxyz";
            const numbers = "23456789";
            const symbols = "!@#$%^&*()_+~-=[]{}|;:,.<>?";
            const allChars = uppercase + lowercase + numbers + symbols;

            let password = "";
            password += uppercase[Math.floor(Math.random() * uppercase.length)];
            password += lowercase[Math.floor(Math.random() * lowercase.length)];
            password += numbers[Math.floor(Math.random() * numbers.length)];
            password += symbols[Math.floor(Math.random() * symbols.length)];

            for (let i = 4; i < 16; i++) {
                password += allChars[Math.floor(Math.random() * allChars.length)];
            }

            password = password.split('').sort(() => 0.5 - Math.random()).join('');

            const input = document.getElementById('tempPasswordInput');
            input.value = password;

            // Enable submit button
            const confirmBtn = document.getElementById('confirmResetBtn');
            if (confirmBtn) {
                confirmBtn.disabled = false;
            }
        }

        async function copyPasswordToClipboard() {
            const input = document.getElementById('tempPasswordInput');
            if (!input.value) return;

            try {
                await navigator.clipboard.writeText(input.value);

                const copyIcon = document.getElementById('copyIcon');
                const checkIcon = document.getElementById('checkIcon');

                if (copyIcon && checkIcon) {
                    copyIcon.classList.add('hidden');
                    checkIcon.classList.remove('hidden');

                    setTimeout(() => {
                        checkIcon.classList.add('hidden');
                        copyIcon.classList.remove('hidden');
                    }, 2000);
                }
            } catch (err) {
                console.error('Failed to copy: ', err);
            }
        }
    </script>
</x-admin>
