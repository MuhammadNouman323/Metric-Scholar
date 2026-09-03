@props(['position' => 'global'])

@php
    $user = auth()->user();
    $notifications = $user ? $user->notifications()->take(8)->get() : collect();
    $unreadCount = $user ? $user->unreadNotifications()->count() : 0;
    $uid = Str::random(6);
    $btnId = 'notif-btn-' . $uid;
    $panelId = 'notif-panel-' . $uid;
    $rootId = 'notif-root-' . $uid;
@endphp

<div id="{{ $rootId }}"
    class="fixed top-3.5 right-14 lg:top-5 lg:right-8 z-40 lg:z-[80] notif-root"
    data-notif-item="true">

    {{-- Bell Button --}}
    <button type="button"
        id="{{ $btnId }}"
        class="notif-trigger relative flex items-center justify-center w-9 h-9 md:w-10 md:h-10 rounded-xl bg-white/95 hover:bg-white text-slate-500 hover:text-[#0e48c1] shadow-sm hover:shadow-md border border-slate-200/80 hover:border-blue-200 transition-all duration-200 cursor-pointer focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#0e48c1]/40 active:scale-95 group"
        aria-label="Notifications" aria-haspopup="true" aria-expanded="false">
        <svg class="w-4.5 h-4.5 md:w-5 md:h-5 transition-transform duration-200 group-hover:rotate-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        @if($unreadCount > 0)
            <span class="notif-badge absolute -top-1 -right-1 flex items-center justify-center min-w-[18px] h-[18px] px-1 text-[10px] font-bold text-white bg-gradient-to-r from-red-500 to-rose-600 rounded-full shadow-[0_2px_6px_rgba(239,68,68,0.4)] ring-2 ring-white">
                {{ $unreadCount > 99 ? '99+' : $unreadCount }}
            </span>
        @endif
    </button>

    {{-- Dropdown Panel --}}
    <div id="{{ $panelId }}"
        class="notif-panel fixed left-3 right-3 top-[3.75rem] mt-0 w-auto max-w-[400px] max-h-[calc(100vh-90px)] sm:absolute sm:left-auto sm:right-0 sm:top-full sm:mt-2.5 sm:w-[380px] md:w-[400px] sm:max-h-[500px] flex flex-col z-[90] bg-white rounded-2xl border border-slate-200/80 overflow-hidden opacity-0 scale-95 pointer-events-none transition-all duration-200 ease-out origin-top-right shadow-[0_20px_50px_rgba(15,23,42,0.12),0_4px_16px_rgba(15,23,42,0.06)]">

        {{-- Arrow --}}
        <div class="absolute -top-1.5 right-3.5 md:right-4 w-3.5 h-3.5 bg-white border-t border-l border-slate-200/80 rotate-45 z-10"></div>

        {{-- Header --}}
        <div class="relative flex items-center justify-between px-4 py-3 md:px-5 md:py-3.5 border-b border-slate-100 bg-gradient-to-r from-slate-50/80 via-white to-white shrink-0">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-[#0e48c1]/10 text-[#0e48c1] flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h4 class="text-[13.5px] font-bold text-slate-900 leading-none">Notifications</h4>
                        @if($unreadCount > 0)
                            <span class="notif-count-badge px-1.5 py-0.5 text-[10px] font-bold text-[#0e48c1] bg-[#0e48c1]/10 rounded-md">{{ $unreadCount }} new</span>
                        @endif
                    </div>
                    <p class="text-[10.5px] text-slate-400 font-medium mt-0.5">Stay updated with your activities</p>
                </div>
            </div>
            @if($unreadCount > 0)
                <form method="POST" action="{{ route('notifications.mark-read') }}" class="inline notif-mark-read-form" onclick="event.stopPropagation()">
                    @csrf
                    <button type="submit"
                        class="notif-mark-all-btn inline-flex items-center gap-1 px-2.5 py-1.5 text-[11px] font-semibold text-[#0e48c1] bg-[#0e48c1]/[0.08] hover:bg-[#0e48c1]/[0.15] rounded-lg transition-all duration-150 cursor-pointer border-0 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#0e48c1]/30 active:scale-95">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                        </svg>
                        Mark all read
                    </button>
                </form>
            @endif
        </div>

        {{-- Notifications List --}}
        <div class="overflow-y-auto notif-scroll flex-1 divide-y divide-slate-100/80" style="max-height: min(380px, calc(100vh - 170px));">
            @forelse($notifications as $notification)
                <a href="{{ $notification->data['action_url'] ?? '#'}}"
                   class="notif-row relative flex items-start gap-3 px-4 py-3 md:px-5 md:py-3.5 transition-all duration-150 group no-underline
                          {{ $notification->unread()
                              ? 'bg-blue-50/40 hover:bg-blue-50/70 is-unread'
                              : 'hover:bg-slate-50/80 bg-white' }}">

                    {{-- Icon --}}
                    <div class="notif-row-icon w-8 h-8 md:w-9 md:h-9 rounded-xl flex items-center justify-center shrink-0 transition-transform duration-200 group-hover:scale-105 mt-0.5
                                {{ $notification->unread()
                                    ? 'bg-gradient-to-br from-[#0e48c1] to-[#3d6ae8] text-white shadow-[0_2px_8px_rgba(14,72,193,0.25)]'
                                    : 'bg-slate-100 text-slate-400' }}">
                        @if(str_contains($notification->type, 'EvaluationAvailable') || str_contains($notification->type, 'NewEvaluationScheduled'))
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        @elseif(str_contains($notification->type, 'EvaluationClosed'))
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        @elseif(str_contains($notification->type, 'FeedbackSubmitted'))
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                            </svg>
                        @else
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        @endif
                    </div>

                    {{-- Content --}}
                    <div class="min-w-0 flex-1">
                        <p class="notif-row-text text-[12.5px] leading-[1.4] {{ $notification->unread() ? 'font-semibold text-slate-900' : 'font-medium text-slate-600' }}">
                            {{ $notification->data['message'] ?? $notification->data['title'] ?? 'New Notification' }}
                        </p>
                        @if(isset($notification->data['evaluation_title']))
                            <p class="text-[11px] text-slate-400 mt-0.5 truncate font-medium">{{ $notification->data['evaluation_title'] }}</p>
                        @endif
                        <div class="flex items-center gap-1 mt-1">
                            <svg class="w-3 h-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-[10px] text-slate-400 font-medium">{{ $notification->created_at->diffForHumans() }}</span>
                        </div>
                    </div>

                    {{-- Unread Dot --}}
                    @if($notification->unread())
                        <div class="notif-unread-dot shrink-0 pt-1">
                            <span class="block w-2 h-2 bg-[#0e48c1] rounded-full shadow-[0_0_6px_rgba(14,72,193,0.5)]"></span>
                        </div>
                    @endif
                </a>
            @empty
                <div class="flex flex-col items-center justify-center py-10 px-6 text-center">
                    <div class="w-12 h-12 rounded-2xl bg-slate-100/80 flex items-center justify-center mb-3 text-slate-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </div>
                    <p class="text-[13px] font-bold text-slate-700">No notifications</p>
                    <p class="text-[11px] text-slate-400 mt-0.5 font-medium">You're all caught up with your updates</p>
                </div>
            @endforelse
        </div>

        {{-- Footer --}}
        @if($notifications->isNotEmpty())
            <div class="px-4 py-2 bg-slate-50/70 border-t border-slate-100 text-center shrink-0">
                <span class="text-[10.5px] font-medium text-slate-400">Showing recent notifications</span>
            </div>
        @endif
    </div>
</div>

<style>
    .notif-scroll::-webkit-scrollbar { width: 3px; }
    .notif-scroll::-webkit-scrollbar-track { background: transparent; }
    .notif-scroll::-webkit-scrollbar-thumb { background: rgba(100, 116, 139, 0.15); border-radius: 999px; }
    .notif-scroll::-webkit-scrollbar-thumb:hover { background: rgba(100, 116, 139, 0.3); }
    .notif-scroll { scrollbar-width: thin; scrollbar-color: rgba(100, 116, 139, 0.15) transparent; }
</style>

<script>
    (function () {
        var root = document.getElementById('{{ $rootId }}');
        if (!root) return;
        var btn = document.getElementById('{{ $btnId }}');
        var panel = document.getElementById('{{ $panelId }}');
        if (!btn || !panel) return;

        function setOpen(open) {
            if (open) {
                panel.classList.remove('opacity-0', 'scale-95', 'pointer-events-none');
                panel.classList.add('opacity-100', 'scale-100', 'pointer-events-auto');
                btn.classList.add('ring-2', 'ring-[#0e48c1]/30', 'text-[#0e48c1]', 'border-[#0e48c1]/30');
            } else {
                panel.classList.remove('opacity-100', 'scale-100', 'pointer-events-auto');
                panel.classList.add('opacity-0', 'scale-95', 'pointer-events-none');
                btn.classList.remove('ring-2', 'ring-[#0e48c1]/30', 'text-[#0e48c1]', 'border-[#0e48c1]/30');
            }
            btn.setAttribute('aria-expanded', String(open));
        }

        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            var isOpen = panel.classList.contains('opacity-100');
            document.querySelectorAll('.notif-panel').forEach(function (p) {
                if (p !== panel) {
                    p.classList.remove('opacity-100', 'scale-100', 'pointer-events-auto');
                    p.classList.add('opacity-0', 'scale-95', 'pointer-events-none');
                    var t = p.closest('.notif-root');
                    if (t) {
                        var trigger = t.querySelector('.notif-trigger');
                        if (trigger) {
                            trigger.setAttribute('aria-expanded', 'false');
                            trigger.classList.remove('ring-2', 'ring-[#0e48c1]/30', 'text-[#0e48c1]', 'border-[#0e48c1]/30');
                        }
                    }
                }
            });
            setOpen(!isOpen);
        });

        document.addEventListener('click', function (e) {
            if (!root.contains(e.target)) {
                setOpen(false);
            }
        });

        panel.addEventListener('click', function (e) {
            e.stopPropagation();
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') setOpen(false);
        });

        // AJAX Mark All As Read
        var markForm = root.querySelector('.notif-mark-read-form');
        if (markForm) {
            markForm.addEventListener('submit', function (e) {
                e.preventDefault();
                var tokenInput = markForm.querySelector('input[name="_token"]');
                var token = tokenInput ? tokenInput.value : '';

                fetch(markForm.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({})
                }).then(function (res) {
                    if (res.ok) {
                        // Remove badge
                        var badge = root.querySelector('.notif-badge');
                        if (badge) badge.remove();

                        var countBadge = root.querySelector('.notif-count-badge');
                        if (countBadge) countBadge.remove();

                        // Remove mark read button
                        markForm.remove();

                        // Update row styling
                        root.querySelectorAll('.notif-row.is-unread').forEach(function (row) {
                            row.classList.remove('bg-blue-50/40', 'hover:bg-blue-50/70', 'is-unread');
                            row.classList.add('bg-white', 'hover:bg-slate-50/80');

                            var icon = row.querySelector('.notif-row-icon');
                            if (icon) {
                                icon.className = 'notif-row-icon w-8 h-8 md:w-9 md:h-9 rounded-xl flex items-center justify-center shrink-0 transition-transform duration-200 group-hover:scale-105 mt-0.5 bg-slate-100 text-slate-400';
                            }

                            var text = row.querySelector('.notif-row-text');
                            if (text) {
                                text.classList.remove('font-semibold', 'text-slate-900');
                                text.classList.add('font-medium', 'text-slate-600');
                            }

                            var dot = row.querySelector('.notif-unread-dot');
                            if (dot) dot.remove();
                        });
                    } else {
                        markForm.submit();
                    }
                }).catch(function () {
                    markForm.submit();
                });
            });
        }
    })();
</script>
