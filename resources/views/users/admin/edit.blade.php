<x-admin>
    <div class="p-6 md:p-10 lg:p-12 pb-24 max-w-[1000px] mx-auto min-h-screen space-y-8">

        <!-- Header with Back Button -->
        <div class="flex items-center gap-4">
            <a href="{{ $user->role->value === 'faculty' ? '/admin/faculty' : '/admin/students' }}"
                class="flex items-center justify-center w-10 h-10 rounded-xl bg-white border border-gray-200 text-gray-500 hover:text-gray-900 hover:border-gray-300 transition-all shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-[28px] font-bold text-gray-900 tracking-tight">Edit User Profile</h1>
                <p class="text-gray-500 text-[14px] font-medium">Manage user details and system access levels.</p>
            </div>
        </div>

        @if (session('success'))
            <div class="rounded-2xl border border-green-200 bg-green-50 px-6 py-4 text-sm font-bold text-green-700 shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-8">
            @csrf
            @method('PUT')

            <!-- Main Form Card -->
            <div class="bg-white rounded-[2rem] p-8 md:p-10 border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.02)] space-y-10">
                
                <!-- Personal Details Section -->
                <div class="space-y-6">
                    <div class="flex items-center gap-3 border-b border-gray-100 pb-4">
                        <div class="text-[#0e48c1] bg-blue-50 p-2 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <h2 class="text-[17px] font-bold text-gray-900">Personal Details</h2>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[13px] font-bold text-gray-700 mb-2.5">Full Name</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                class="w-full bg-[#f4f6f8] border border-transparent rounded-xl px-4 py-3.5 text-gray-900 font-medium placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0e48c1] focus:bg-white focus:border-blue-200 transition-all text-sm"
                                placeholder="Dr. Julian Casablancas">
                            @error('name')
                                <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-[13px] font-bold text-gray-700 mb-2.5">Institutional Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                class="w-full bg-[#f4f6f8] border border-transparent rounded-xl px-4 py-3.5 text-gray-900 font-medium placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0e48c1] focus:bg-white focus:border-blue-200 transition-all text-sm"
                                placeholder="julian.c@scholarmetric.edu">
                            @error('email')
                                <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Academic Role Section -->
                <div class="space-y-6">
                    <div class="flex items-center gap-3 border-b border-gray-100 pb-4">
                        <div class="text-[#0e48c1] bg-blue-50 p-2 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h2 class="text-[17px] font-bold text-gray-900">Academic Role</h2>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="relative">
                            <label class="block text-[13px] font-bold text-gray-700 mb-2.5">Primary Role</label>
                            <select name="role"
                                class="w-full bg-[#f4f6f8] border border-transparent rounded-xl px-4 py-3.5 text-gray-900 font-medium appearance-none focus:outline-none focus:ring-2 focus:ring-[#0e48c1] focus:bg-white focus:border-blue-200 transition-all cursor-pointer text-sm">
                                <option value="student" @selected(old('role', $user->role->value) === 'student')>Student</option>
                                <option value="faculty" @selected(old('role', $user->role->value) === 'faculty')>Faculty</option>
                                <option value="admin" @selected(old('role', $user->role->value) === 'admin')>Admin</option>
                            </select>
                            <div class="absolute inset-y-0 right-4 top-[32px] flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                            @error('role')
                                <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="relative">
                            <label class="block text-[13px] font-bold text-gray-700 mb-2.5">Department</label>
                            <select name="department"
                                class="w-full bg-[#f4f6f8] border border-transparent rounded-xl px-4 py-3.5 text-gray-900 font-medium appearance-none focus:outline-none focus:ring-2 focus:ring-[#0e48c1] focus:bg-white focus:border-blue-200 transition-all cursor-pointer text-sm">
                                <option value="">Assign department</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept }}" @selected(old('department', $user->department) === $dept)>{{ $dept }}</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-4 top-[32px] flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                            @error('department')
                                <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Security & Access Section -->
                <div class="space-y-6">
                    <div class="flex items-center gap-3 border-b border-gray-100 pb-4">
                        <div class="text-[#0e48c1] bg-blue-50 p-2 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <h2 class="text-[17px] font-bold text-gray-900">Security & Access</h2>
                    </div>

                    <!-- Password Management Card -->
                    <div class="bg-gray-50/50 border border-gray-100 rounded-2xl p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-white border border-gray-150 rounded-xl flex items-center justify-center shrink-0 shadow-sm text-gray-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-gray-900">Password Management</h3>
                                <p class="text-xs text-gray-500 font-medium leading-relaxed mt-1">Initiate a secure password reset flow. An email will be sent to the user's institutional address.</p>
                            </div>
                        </div>
                        <a href="{{ route('admin.users.recovery', $user) }}"
                            class="shrink-0 bg-white border-2 border-gray-250 text-[#0e48c1] hover:text-blue-800 hover:border-[#0e48c1]/30 font-bold rounded-xl py-3 px-6 text-sm transition-all shadow-sm">
                            Reset Password
                        </a>
                    </div>

                    <!-- Account Status Card -->
                    <div class="bg-gray-50/50 border border-gray-100 rounded-2xl p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
                        <div>
                            <h3 class="text-sm font-bold text-gray-900">Account Status</h3>
                            <p class="text-xs text-gray-500 font-medium leading-relaxed mt-1">Toggle to immediately enable or disable access to Scholar Metric.</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <span id="statusLabel" class="text-sm font-bold text-gray-900">{{ $user->is_active ? 'Active' : 'Inactive' }}</span>
                            <!-- Toggle switch -->
                            <label class="relative inline-flex items-center cursor-pointer select-none">
                                <input type="checkbox" id="statusToggleCheckbox" name="is_active" value="1" @checked($user->is_active) class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#0e48c1]"></div>
                            </label>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Footer Buttons -->
            <div class="flex items-center justify-end gap-4">
            <a href="{{ $user->role->value === 'faculty' ? '/admin/faculty' : '/admin/students' }}"
                    class="bg-white border-2 border-gray-200 text-gray-700 hover:bg-gray-50 hover:border-gray-300 px-8 py-3.5 rounded-xl text-sm font-bold transition-all shadow-sm">
                    Cancel
                </a>
                <button type="submit"
                    class="bg-[#0e48c1] hover:bg-blue-800 text-white font-bold rounded-xl py-3.5 px-8 text-sm transition-all hover:shadow-[0_4px_12px_rgba(14,72,193,0.3)] shadow-[0_4px_10px_rgba(14,72,193,0.15)] flex items-center justify-center gap-2">
                    Save Changes
                </button>
            </div>
        </form>
    </div>

    <!-- AJAX script to toggle status immediately -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const checkbox = document.getElementById('statusToggleCheckbox');
            const label = document.getElementById('statusLabel');

            if (checkbox && label) {
                checkbox.addEventListener('change', async (e) => {
                    const isActive = checkbox.checked;
                    label.textContent = isActive ? 'Active' : 'Inactive';

                    try {
                        const response = await fetch("{{ route('admin.users.toggle-status', $user) }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ is_active: isActive })
                        });

                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }

                        const data = await response.json();
                        // Optional: trigger custom visual checkmark/alert or toast notification here.
                    } catch (error) {
                        console.error('Error toggling status:', error);
                        // Revert checkbox state on error
                        checkbox.checked = !isActive;
                        label.textContent = !isActive ? 'Active' : 'Inactive';
                        alert('Could not update status. Please try again.');
                    }
                });
            }
        });
    </script>
</x-admin>
