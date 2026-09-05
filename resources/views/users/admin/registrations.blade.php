<x-admin>
    <div class="p-6 md:p-10 lg:p-12 pb-24 max-w-[1400px] mx-auto min-h-screen space-y-8">

        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div class="flex flex-col gap-2">
                <h1 class="text-[32px] font-bold text-gray-900 mb-2 tracking-tight">Registration History</h1>
                <p class="text-gray-500 text-[15px] font-medium">Complete record of accounts registered across the institution.</p>
            </div>
            <!-- Total Card -->
            <div class="bg-[#0e48c1] text-white rounded-[1.5rem] p-7 relative overflow-hidden w-full md:w-auto">
                <div class="absolute -right-6 -top-6 w-[140px] h-[140px] bg-blue-500/30 rounded-full blur-2xl pointer-events-none"></div>
                <div class="absolute right-4 bottom-4 w-12 h-12 border-[5px] border-blue-400/30 rounded-full pointer-events-none"></div>
                <div class="absolute right-12 bottom-2 w-16 h-16 bg-blue-400/20 rounded-full pointer-events-none"></div>

                <h3 class="text-[11px] font-bold tracking-widest text-blue-200 uppercase mb-2 z-10">Total Registered</h3>
                <div class="text-[44px] font-extrabold leading-none tracking-tight mb-3 z-10">{{ number_format($totalRegistrations) }}</div>
                <div class="flex items-center text-[12px] font-bold text-blue-200 z-10">
                    <svg class="w-4 h-4 mr-2 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Institutional accounts
                </div>
            </div>
            <a href="{{ route('admin.users') }}"
                class="flex items-center gap-2 bg-white border-2 border-gray-200 text-gray-700 px-6 py-3 rounded-xl text-sm font-bold hover:border-[#0e48c1] hover:text-[#0e48c1] transition-all duration-200 whitespace-nowrap">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                New Registration
            </a>
        </div>

        <!-- Table View -->
        <div class="bg-white rounded-[2rem] overflow-hidden shadow-sm border border-gray-100">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[900px]">
                    <thead>
                        <tr class="bg-gradient-to-r from-gray-50 to-gray-100/50 border-b border-gray-200/80">
                            <th class="px-6 py-5 text-[11px] font-extrabold text-gray-600 uppercase tracking-widest">User</th>
                            <th class="px-6 py-5 text-[11px] font-extrabold text-gray-600 uppercase tracking-widest">Email</th>
                            <th class="px-6 py-5 text-[11px] font-extrabold text-gray-600 uppercase tracking-widest">Role</th>
                            <th class="px-6 py-5 text-[11px] font-extrabold text-gray-600 uppercase tracking-widest">Department</th>
                            <th class="px-6 py-5 text-[11px] font-extrabold text-gray-600 uppercase tracking-widest">Registered</th>
                            <th class="px-6 py-5 text-[11px] font-extrabold text-gray-600 uppercase tracking-widest">Status</th>
                            <th class="px-6 py-5 text-[11px] font-extrabold text-gray-600 uppercase tracking-widest text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($registrations as $user)
                            @php
                                $roleBadge = match ($user->role) {
                                    \App\Enums\Role::Admin => 'bg-purple-100 text-purple-700',
                                    \App\Enums\Role::Faculty => 'bg-blue-100 text-blue-700',
                                    \App\Enums\Role::Student => 'bg-emerald-100 text-emerald-700',
                                };
                            @endphp
                            <tr class="hover:bg-blue-50/40 transition-colors duration-150 group">
                                <td class="px-6 py-6 whitespace-nowrap">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="flex items-center gap-3">
                                        <img class="w-10 h-10 rounded-full border-2 border-gray-200 object-cover shadow-sm" src="{{ $user->avatar_url }}" alt="{{ $user->name }}">
                                        <span class="text-[14px] font-bold text-gray-900 group-hover:text-[#0e48c1] transition-colors">{{ $user->name }}</span>
                                    </a>
                                </td>
                                <td class="px-6 py-6 whitespace-nowrap">
                                    <span class="text-[13px] font-medium text-gray-600">{{ $user->email }}</span>
                                </td>
                                <td class="px-6 py-6 whitespace-nowrap">
                                    <span class="inline-flex px-3 py-1.5 text-[12px] font-bold rounded-lg {{ $roleBadge }}">{{ $user->role->label() }}</span>
                                </td>
                                <td class="px-6 py-6 whitespace-nowrap">
                                    <span class="text-[13px] font-medium text-gray-600">{{ $user->department ?: 'General' }}</span>
                                </td>
                                <td class="px-6 py-6 whitespace-nowrap">
                                    <span class="text-[13px] font-medium text-gray-600">{{ $user->created_at->format('M d, Y') }}</span>
                                </td>
                                <td class="px-6 py-6 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2.5 h-2.5 rounded-full {{ $user->is_active ? 'bg-emerald-500' : 'bg-gray-400' }} shadow-sm"></span>
                                        <span class="text-[13px] font-bold text-gray-900">{{ $user->is_active ? 'Active' : 'Inactive' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-6 whitespace-nowrap text-right">
                                    <a href="{{ route('admin.users.edit', $user) }}"
                                        class="p-1.5 text-[#0e48c1] hover:bg-blue-100 rounded-lg transition-colors duration-150">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center">
                                    <p class="text-gray-500 font-medium">No registrations found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            {{ $registrations->links('vendor.pagination.admin') }}
        </div>

    </div>
</x-admin>