<x-admin>
    <div class="p-6 md:p-10 lg:p-12 pb-24 max-w-[1400px] mx-auto min-h-screen">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-10 gap-5">
            <div>
                <h1 class="text-[32px] font-bold text-gray-900 mb-1.5 tracking-tight">Create New User</h1>
                <p class="text-gray-500 text-[15px] font-medium">Register a single student or faculty member to the
                    institutional database.</p>
            </div>

        </div>

        <!-- Main Grid -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 lg:gap-8 w-full">

            <!-- Form Card (Col Span 2) -->
            <div
                class="xl:col-span-2 bg-white rounded-[2rem] p-8 md:p-10 border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.02)] h-full flex flex-col">

                @if (session('success'))
                    <div
                        class="mb-4 bg-green-50 text-green-700 p-4 rounded-xl text-sm font-bold border border-green-100">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.users.store') }}" class="flex flex-col h-full space-y-8">
                    @csrf
                    <!-- Top Row -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 lg:gap-8">
                        <div>
                            <label class="block text-[13px] font-bold text-gray-700 mb-2.5">Full Name</label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                class="w-full bg-[#f4f6f8] border border-transparent rounded-xl px-4 py-3.5 text-gray-900 font-medium placeholder:text-gray-400 placeholder:font-normal focus:outline-none focus:ring-2 focus:ring-[#0e48c1] focus:bg-white focus:border-blue-200 transition-all text-sm"
                                placeholder="Dr. Julian Casablancas">
                            @error('name')
                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-[13px] font-bold text-gray-700 mb-2.5">Institutional Email</label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                class="w-full bg-[#f4f6f8] border border-transparent rounded-xl px-4 py-3.5 text-gray-900 font-medium placeholder:text-gray-400 placeholder:font-normal focus:outline-none focus:ring-2 focus:ring-[#0e48c1] focus:bg-white focus:border-blue-200 transition-all text-sm"
                                placeholder="julian.c@scholarmetric.edu">
                            @error('email')
                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Middle Row -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 lg:gap-8">
                        <div class="relative">
                            <label class="block text-[13px] font-bold text-gray-700 mb-2.5">Role Selection</label>
                            <select name="role"
                                class="w-full bg-[#f4f6f8] border border-transparent rounded-xl px-4 py-3.5 text-gray-900 font-medium appearance-none focus:outline-none focus:ring-2 focus:ring-[#0e48c1] focus:bg-white focus:border-blue-200 transition-all cursor-pointer text-sm">
                                <option value="">Select user role</option>
                                <option value="Student" {{ old('role') == 'Student' ? 'selected' : '' }}>Student
                                </option>
                                <option value="Faculty" {{ old('role') == 'Faculty' ? 'selected' : '' }}>Faculty
                                </option>
                                <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            <div class="absolute inset-y-0 right-4 top-[32px] flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                            @error('role')
                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="relative">
                            <label class="block text-[13px] font-bold text-gray-700 mb-2.5">Department</label>
                            <select name="department"
                                class="w-full bg-[#f4f6f8] border border-transparent rounded-xl px-4 py-3.5 text-gray-900 font-medium appearance-none focus:outline-none focus:ring-2 focus:ring-[#0e48c1] focus:bg-white focus:border-blue-200 transition-all cursor-pointer text-sm">
                                <option value="">Assign department</option>
                                <option value="Computer Science"
                                    {{ old('department') == 'Computer Science' ? 'selected' : '' }}>Computer Science
                                </option>
                                <option value="Mathematics" {{ old('department') == 'Mathematics' ? 'selected' : '' }}>
                                    Mathematics</option>
                                <option value="Applied Physics"
                                    {{ old('department') == 'Applied Physics' ? 'selected' : '' }}>Applied Physics
                                </option>
                                <option value="Bio-Chemistry"
                                    {{ old('department') == 'Bio-Chemistry' ? 'selected' : '' }}>Bio-Chemistry</option>
                            </select>
                            <div class="absolute inset-y-0 right-4 top-[32px] flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                            @error('department')
                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Bottom Row: Password -->
                    <div class="mt-2">
                        <label class="block text-[13px] font-bold text-gray-700 mb-2.5">Temporary Password</label>
                        <div
                            class="relative flex items-center bg-[#f4f6f8] rounded-xl overflow-hidden focus-within:ring-2 focus-within:ring-[#0e48c1] focus-within:bg-white transition-all border border-transparent focus-within:border-blue-200">
                            <input type="password" name="password"
                                class="w-full bg-transparent px-4 py-3.5 pr-28 text-gray-900 font-bold placeholder:text-gray-400 placeholder:font-normal focus:outline-none tracking-widest text-lg"
                                placeholder="••••••••••••" value="password123">
                            <button type="button"
                                onclick="document.querySelector('input[name=\'password\']').value = Math.random().toString(36).slice(-8);"
                                class="absolute right-2 bg-transparent text-[#0e48c1] hover:text-[#0c3ca1] font-bold text-[13px] px-3 py-1.5 rounded transition-colors uppercase tracking-wider">
                                Generate
                            </button>
                        </div>
                        @error('password')
                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                        <p class="text-[12px] text-gray-400 font-medium mt-3">User will be prompted to change this
                            password on first login.</p>
                    </div>

                    <div class="flex-grow"></div>

                    <!-- Submit Button -->
                    <div class="pt-4 flex justify-end">
                        <button type="submit"
                            class="w-full sm:w-auto bg-[#0e48c1] hover:bg-blue-800 text-white font-bold rounded-xl py-3.5 px-8 transition-all hover:shadow-[0_4px_12px_rgba(14,72,193,0.3)] shadow-[0_4px_10px_rgba(14,72,193,0.15)] flex items-center justify-center gap-3 transform active:scale-[0.98]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                                </path>
                            </svg>
                            <span>Create User Account</span>
                        </button>
                    </div>

                </form>
            </div>

            <!-- Side Column -->
            <div class="space-y-6 lg:space-y-8 h-full flex flex-col">

                <!-- Recent Registrations Card -->
                <div
                    class="bg-white rounded-[2rem] p-7 border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.02)] flex-1">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-[17px] font-bold text-gray-900">Recent Registrations</h3>
                        <span
                            class="bg-blue-50 text-[#0e48c1] text-[10px] font-bold px-2 py-0.5 rounded shadow-sm">LIVE</span>
                    </div>

                    <div class="space-y-6">
                        @forelse($recentUsers as $user)
                            <!-- User Card -->
                            <div class="flex gap-4 items-center">
                                <img class="w-11 h-11 rounded-full border-2 border-white shadow-sm object-cover bg-gray-50"
                                    src="{{ $user->avatar_url }}"
                                    alt="{{ $user->name }}">
                                <div class="flex-1 min-w-0">
                                    <p class="text-[14px] font-bold text-gray-900 truncate">{{ $user->name }}</p>
                                    <p class="text-[12px] text-gray-500 truncate font-medium">{{ ucfirst($user->role->value) }} <span
                                            class="mx-1">•</span> {{ $user->department ?? 'N/A' }}</p>
                                </div>
                                <span
                                    class="text-[10px] font-bold text-gray-400 shrink-0">{{ $user->created_at->diffForHumans() }}</span>
                            </div>
                        @empty
                            <div class="text-sm text-gray-500 font-medium text-center py-4">No recent registrations
                                found.</div>
                        @endforelse
                    </div>

                    <div class="mt-8 pt-4">
                        <a href="#"
                            class="block w-full text-center text-[#0e48c1] hover:text-[#0c3ca1] text-[13px] font-bold transition-colors">
                            View Registration History &rarr;
                        </a>
                    </div>
                </div>

                <!-- System Tip Widget -->
                <div
                    class="bg-[#fcece3] border border-[#fac8b1] rounded-[1.5rem] p-6 flex gap-4 shadow-sm relative overflow-hidden">
                    <div class="absolute inset-0 bg-white/20 backdrop-blur-[1px]"></div>
                    <div class="relative z-10 shrink-0 mt-0.5">
                        <div class="text-[#c55d31] bg-white/60 p-1.5 rounded-full shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>
</x-admin>
