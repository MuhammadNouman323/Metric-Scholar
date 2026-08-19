<x-admin>
    <div class="p-6 md:p-10 lg:p-12 pb-24 max-w-[1400px] mx-auto min-h-screen">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-10 gap-4">
            <div>
                <h1 class="text-[13px] font-bold text-gray-400 uppercase tracking-[0.2em] mb-1">Account Management</h1>
                <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Admin Profile</h2>
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

            <!-- Left: Profile Picture Card -->
            <div class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.02)] flex flex-col items-center text-center">
                <h3 class="text-lg font-bold text-gray-900 mb-6 w-full text-left">Profile Picture</h3>

                <div class="relative group mb-6">
                    <div class="w-[180px] h-[180px] rounded-full overflow-hidden border-4 border-gray-50 shadow-md bg-gray-100 flex items-center justify-center">
                        <img id="avatar-preview" src="{{ $admin->avatar_url }}" alt="{{ $admin->name }}"
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

                    @if($admin->avatar)
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

            <!-- Right: Personal Info & Password Cards -->
            <div class="lg:col-span-2 space-y-8">

                <!-- Personal Information -->
                <div class="bg-white rounded-[2rem] p-8 md:p-10 border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.02)]">
                    <h3 class="text-lg font-bold text-gray-900 mb-8 flex items-center gap-2">
                        <span class="w-1 h-5 bg-[#0e48c1] rounded-full"></span>
                        Personal Information
                    </h3>

                    <form method="POST" action="{{ route('admin.profile.update', $admin) }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Hidden File Input linked to upload button -->
                        <input id="avatar-input" type="file" name="avatar" accept="image/*" class="hidden" onchange="previewAvatar(event)">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-[13px] font-bold text-gray-700 mb-2.5">Full Name</label>
                                <input type="text" name="name" value="{{ old('name', $admin->name) }}"
                                    class="w-full bg-[#f4f6f8] border border-transparent rounded-xl px-4 py-3.5 text-gray-900 font-medium placeholder:text-gray-400 placeholder:font-normal focus:outline-none focus:ring-2 focus:ring-[#0e48c1] focus:bg-white focus:border-blue-200 transition-all text-sm"
                                    placeholder="Jane Doe" required>
                            </div>

                            <div>
                                <label class="block text-[13px] font-bold text-gray-700 mb-2.5">Email Address</label>
                                <input type="email" value="{{ $admin->email }}"
                                    class="w-full bg-gray-50 border border-gray-100 rounded-xl px-4 py-3.5 text-gray-400 font-medium text-sm focus:outline-none cursor-not-allowed"
                                    disabled readonly>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-[13px] font-bold text-gray-700 mb-2.5">Phone Number</label>
                                <input type="text" name="phone" value="{{ old('phone', $admin->phone) }}"
                                    class="w-full bg-[#f4f6f8] border border-transparent rounded-xl px-4 py-3.5 text-gray-900 font-medium placeholder:text-gray-400 placeholder:font-normal focus:outline-none focus:ring-2 focus:ring-[#0e48c1] focus:bg-white focus:border-blue-200 transition-all text-sm"
                                    placeholder="+1234567890">
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

                    <form method="POST" action="{{ route('admin.profile.password', $admin) }}" class="space-y-6">
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

            </div>

        </div>

    </div>

    <!-- Hidden Form for Avatar Removal -->
    @if($admin->avatar)
        <form id="remove-avatar-form" action="{{ route('admin.profile.avatar.remove', $admin) }}" method="POST" class="hidden">
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
</x-admin>
