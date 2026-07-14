<x-student>
    <div class="p-6 md:p-10 lg:p-12 pb-24 max-w-[1400px] mx-auto min-h-screen">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-10 gap-4">
            <div>
                <h1 class="text-[13px] font-bold text-gray-400 uppercase tracking-[0.2em] mb-1">Student Portal</h1>
                <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Profile Settings</h2>
            </div>
        </div>

        <!-- Success and Error Alerts -->
        @if (session('success'))
            <div class="mb-8 rounded-2xl border border-green-200 bg-green-50 p-4 text-sm font-semibold text-green-700 shadow-sm">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-8 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm font-semibold text-red-700 shadow-sm">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ session('error') }}
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-8 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm font-semibold text-red-700 shadow-sm">
                <div class="flex items-start gap-2">
                    <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <div class="flex-1">
                        <p class="font-bold mb-1">Please fix the errors below:</p>
                        <ul class="list-disc list-inside space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Left: Profile Picture Card & Stats -->
            <div class="space-y-8">
                <!-- Profile Picture Card -->
                <div class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.02)] flex flex-col items-center text-center">
                    <h3 class="text-lg font-bold text-gray-900 mb-6 w-full text-left">Profile Picture</h3>

                    <div class="relative group mb-6">
                        <div class="w-[180px] h-[180px] rounded-full overflow-hidden border-4 border-gray-50 shadow-md bg-gray-100 flex items-center justify-center">
                            <img id="avatar-preview" src="{{ $student->avatar_url }}" alt="{{ $student->name }}"
                                class="w-full h-full object-cover">
                        </div>
                    </div>

                    <div class="space-y-3 w-full">
                        <label for="avatar-input" class="w-full flex items-center justify-center gap-2 bg-[#0e48c1] text-white text-[13px] font-bold px-6 py-3 rounded-xl hover:bg-blue-800 transition-colors shadow-sm cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                            </svg>
                            Upload Picture
                        </label>

                        @if($student->avatar)
                            <button type="button" onclick="document.getElementById('remove-avatar-form').submit();"
                                class="w-full flex items-center justify-center gap-2 bg-white border border-red-200 text-red-600 text-[13px] font-bold px-6 py-3 rounded-xl hover:bg-red-50 hover:border-red-300 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Remove Picture
                            </button>
                        @endif
                    </div>

                    <p class="text-[11px] text-gray-400 font-medium mt-4">JPG, JPEG, PNG or WEBP. Max 2MB.</p>
                </div>

                <!-- Academic Progress Statistics -->
                <div class="bg-white rounded-[2rem] p-6 border border-gray-100 shadow-[0_4px_16px_rgb(0,0,0,0.02)]">
                    <h3 class="text-md font-bold text-gray-900 mb-4">Academic Progress</h3>
                    <div class="grid grid-cols-1 gap-4">
                        <div class="bg-[#f8fafc] rounded-2xl p-4 flex justify-between items-center">
                            <div>
                                <p class="text-[11px] text-gray-400 font-bold uppercase tracking-wide mb-0.5">Current GPA</p>
                                <p class="text-[11px] text-gray-400 font-semibold">Not tracked yet</p>
                            </div>
                            <span class="text-[24px] font-bold text-gray-900">N/A</span>
                        </div>
                        <div class="bg-[#f8fafc] rounded-2xl p-4 flex justify-between items-center">
                            <div>
                                <p class="text-[11px] text-gray-400 font-bold uppercase tracking-wide mb-0.5">Credits Enrolled</p>
                                <p class="text-[11px] text-[#0e48c1] font-semibold">All Active Courses</p>
                            </div>
                            <span class="text-[24px] font-bold text-gray-900">{{ $totalCredits }}</span>
                        </div>
                        <div class="bg-[#f8fafc] rounded-2xl p-4 flex justify-between items-center">
                            <div>
                                <p class="text-[11px] text-gray-400 font-bold uppercase tracking-wide mb-0.5">Feedback Activity</p>
                                <p class="text-[11px] font-semibold text-orange-500">{{ $feedbackRate >= 80 ? 'Exceptional Contributor' : ($feedbackRate >= 50 ? 'Good Contributor' : 'Needs Improvement') }}</p>
                            </div>
                            <span class="text-[24px] font-bold text-gray-900">{{ $feedbackRate }}%</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Personal Info, Password, and Privacy Cards -->
            <div class="lg:col-span-2 space-y-8">

                <!-- Personal Information -->
                <div class="bg-white rounded-[2rem] p-8 md:p-10 border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.02)]">
                    <h3 class="text-lg font-bold text-gray-900 mb-8 flex items-center gap-2">
                        <span class="w-1 h-5 bg-[#0e48c1] rounded-full"></span>
                        Personal Information
                    </h3>

                    <form method="POST" action="{{ route('student.profile.update', $student) }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Hidden File Input linked to upload button -->
                        <input id="avatar-input" type="file" name="avatar" accept="image/*" class="hidden" onchange="previewAvatar(event)">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-[13px] font-bold text-gray-700 mb-2.5">Full Name</label>
                                <input type="text" name="name" value="{{ old('name', $student->name) }}"
                                    class="w-full bg-[#f4f6f8] border border-transparent rounded-xl px-4 py-3.5 text-gray-900 font-medium placeholder:text-gray-400 placeholder:font-normal focus:outline-none focus:ring-2 focus:ring-[#0e48c1] focus:bg-white focus:border-blue-200 transition-all text-sm"
                                    placeholder="Muhammad Saad" required>
                            </div>

                            <div>
                                <label class="block text-[13px] font-bold text-gray-700 mb-2.5">Email Address</label>
                                <input type="email" name="email" value="{{ old('email', $student->email) }}"
                                    class="w-full bg-[#f4f6f8] border border-transparent rounded-xl px-4 py-3.5 text-gray-900 font-medium placeholder:text-gray-400 placeholder:font-normal focus:outline-none focus:ring-2 focus:ring-[#0e48c1] focus:bg-white focus:border-blue-200 transition-all text-sm"
                                    placeholder="saad@student.edu" required>
                            </div>

                            <div>
                                <label class="block text-[13px] font-bold text-gray-700 mb-2.5">Phone Number</label>
                                <input type="text" name="phone" value="{{ old('phone', $student->phone) }}"
                                    class="w-full bg-[#f4f6f8] border border-transparent rounded-xl px-4 py-3.5 text-gray-900 font-medium placeholder:text-gray-400 placeholder:font-normal focus:outline-none focus:ring-2 focus:ring-[#0e48c1] focus:bg-white focus:border-blue-200 transition-all text-sm"
                                    placeholder="+923001234567">
                            </div>

                            <div>
                                <label class="block text-[13px] font-bold text-gray-700 mb-2.5">Student ID / Roll No</label>
                                <input type="text" value="{{ $student->university_id ?? 'N/A' }}"
                                    class="w-full bg-gray-50 border border-gray-100 rounded-xl px-4 py-3.5 text-gray-400 font-medium text-sm focus:outline-none cursor-not-allowed"
                                    disabled readonly>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-[13px] font-bold text-gray-700 mb-2.5">Department</label>
                                <input type="text" value="{{ $student->department ?? 'N/A' }}"
                                    class="w-full bg-gray-50 border border-gray-100 rounded-xl px-4 py-3.5 text-gray-400 font-medium text-sm focus:outline-none cursor-not-allowed"
                                    disabled readonly>
                            </div>
                        </div>

                        <div class="flex justify-end pt-4">
                            <button type="submit" class="bg-[#0e48c1] text-white text-[14px] font-bold px-8 py-3.5 rounded-xl hover:bg-blue-800 transition-colors shadow-sm">
                                Save Profile
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Password Card -->
                <div class="bg-white rounded-[2rem] p-8 md:p-10 border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.02)]">
                    <h3 class="text-lg font-bold text-gray-900 mb-8 flex items-center gap-2">
                        <span class="w-1 h-5 bg-[#0e48c1] rounded-full"></span>
                        Change Password
                    </h3>

                    <form method="POST" action="{{ route('student.profile.password', $student) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">
                            <div>
                                <label class="block text-[13px] font-bold text-gray-700 mb-2.5">Current Password</label>
                                <input type="password" name="current_password"
                                    class="w-full bg-[#f4f6f8] border border-transparent rounded-xl px-4 py-3.5 text-gray-900 font-medium placeholder:text-gray-400 placeholder:font-normal focus:outline-none focus:ring-2 focus:ring-[#0e48c1] focus:bg-white focus:border-blue-200 transition-all text-sm"
                                    placeholder="••••••••" required>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-[13px] font-bold text-gray-700 mb-2.5">New Password</label>
                                    <input type="password" name="password"
                                        class="w-full bg-[#f4f6f8] border border-transparent rounded-xl px-4 py-3.5 text-gray-900 font-medium placeholder:text-gray-400 placeholder:font-normal focus:outline-none focus:ring-2 focus:ring-[#0e48c1] focus:bg-white focus:border-blue-200 transition-all text-sm"
                                        placeholder="Min. 8 characters" required>
                                </div>

                                <div>
                                    <label class="block text-[13px] font-bold text-gray-700 mb-2.5">Confirm New Password</label>
                                    <input type="password" name="password_confirmation"
                                        class="w-full bg-[#f4f6f8] border border-transparent rounded-xl px-4 py-3.5 text-gray-900 font-medium placeholder:text-gray-400 placeholder:font-normal focus:outline-none focus:ring-2 focus:ring-[#0e48c1] focus:bg-white focus:border-blue-200 transition-all text-sm"
                                        placeholder="••••••••" required>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end pt-4">
                            <button type="submit" class="bg-[#0e48c1] text-white text-[14px] font-bold px-8 py-3.5 rounded-xl hover:bg-blue-800 transition-colors shadow-sm">
                                Change Password
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Privacy Controls -->
                <div class="bg-white rounded-[2rem] p-8 md:p-10 border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.02)]">
                    <div class="flex items-center gap-2 mb-2">
                        <svg class="w-5 h-5 text-[#0e48c1]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        <h3 class="text-lg font-bold text-gray-900">Privacy Controls</h3>
                    </div>
                    <p class="text-[13px] text-gray-500 font-medium mb-6">Scholar Metric prioritizes your academic integrity. These settings control how your data is shared with faculty and administrators.</p>
                    <div class="space-y-4">
                        <!-- Toggle 1 -->
                        <div class="flex items-center gap-3 p-4 bg-[#f8fafc] rounded-2xl">
                            <div class="w-8 h-8 bg-blue-50 rounded-xl flex items-center justify-center text-[#0e48c1] shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-[13px] font-bold text-gray-900">Feedback Anonymity</p>
                                <p class="text-[11px] text-gray-400">Hide your identity in reviews</p>
                            </div>
                            <div class="w-10 h-6 bg-[#0e48c1] rounded-full relative cursor-pointer shrink-0">
                                <div class="absolute right-1 top-1 w-4 h-4 bg-white rounded-full shadow-sm"></div>
                            </div>
                        </div>
                        <!-- Toggle 2 -->
                        <div class="flex items-center gap-3 p-4 bg-[#f8fafc] rounded-2xl">
                            <div class="w-8 h-8 bg-blue-50 rounded-xl flex items-center justify-center text-[#0e48c1] shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-[13px] font-bold text-gray-900">Aggregate Sharing</p>
                                <p class="text-[11px] text-gray-400">Used for institutional metrics</p>
                            </div>
                            <div class="w-10 h-6 bg-[#0e48c1] rounded-full relative cursor-pointer shrink-0">
                                <div class="absolute right-1 top-1 w-4 h-4 bg-white rounded-full shadow-sm"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Hidden Form for Avatar Removal -->
    @if($student->avatar)
        <form id="remove-avatar-form" action="{{ route('student.profile.avatar.remove', $student) }}" method="POST" class="hidden">
            @csrf
        </form>
    @endif

    <script>
        function previewAvatar(event) {
            const input = event.target;
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('avatar-preview').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-student>
