@extends('layouts.panel')

@section('page-title', 'Customer Service')
@section('page-description', 'Laporkan bug, sampaikan kendala, atau chat langsung dengan admin.')

@section('content')
    @php
        $lightChatBgUrl = str_replace(' ', '%20', \Illuminate\Support\Facades\Storage::disk('public')->url('chatbox bg/chat box.cerah mode.jpg'));
        $darkChatBgUrl = str_replace(' ', '%20', \Illuminate\Support\Facades\Storage::disk('public')->url('chatbox bg/chat box.drak mode.jpg'));
        $user = Auth::user();
        $isAdmin = $isAdmin ?? (($user->role ?? 'user') === 'admin');
        $threads = $threads ?? collect();
        $thread = $thread ?? null;
        $selectedIssueType = old('issue_type', $thread?->issue_type ?? '');
        $issueGuidance = [
            'bug' => [
                'prompt' => 'Jelaskan bug yang kamu temukan, langkahnya, dan apa yang seharusnya terjadi.',
                'placeholder' => 'Contoh: ketika saya klik tombol pinjam, halaman tidak merespons...',
            ],
            'password' => [
                'prompt' => 'Jelaskan kendala lupa password atau akses akun yang kamu alami.',
                'placeholder' => 'Contoh: saya lupa password dan tidak bisa login ke akun...',
            ],
            'transaction' => [
                'prompt' => 'Jelaskan masalah transaksi yang terjadi dengan detail.',
                'placeholder' => 'Contoh: transaksi sudah berhasil tapi status belum berubah...',
            ],
            'borrow' => [
                'prompt' => 'Jelaskan masalah peminjaman, status, atau kendala pengambilan buku.',
                'placeholder' => 'Contoh: status peminjaman tidak muncul atau buku belum bisa diambil...',
            ],
            'lost_book' => [
                'prompt' => 'Jelaskan laporan buku hilang dan informasi yang perlu diketahui admin.',
                'placeholder' => 'Contoh: saya ingin melaporkan buku hilang atau rusak...',
            ],
            'other' => [
                'prompt' => 'Tulis pesanmu dengan bebas dan jelaskan kebutuhanmu kepada admin.',
                'placeholder' => 'Tulis pesan kamu di sini...',
            ],
        ];
        $selectedIssuePrompt = $issueGuidance[$selectedIssueType]['prompt'] ?? 'Pilih jenis masalah terlebih dahulu agar admin lebih cepat membantu.';
        $selectedIssuePlaceholder = $issueGuidance[$selectedIssueType]['placeholder'] ?? 'Pilih jenis masalah terlebih dahulu...';
        $activeThreadId = $thread->id ?? null;
        $messages = $thread?->messages ?? collect();
    @endphp

    <style>
        .support-room-shell {
            position: relative;
            overflow: hidden;
        }

        .support-room-bg {
            position: absolute;
            inset: 0;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            transform: scale(1.02);
        }

        .support-room-overlay {
            position: absolute;
            inset: 0;
            background:
                linear-gradient(180deg, rgba(255, 255, 255, 0.20), rgba(255, 255, 255, 0.82)),
                linear-gradient(135deg, rgba(255, 255, 255, 0.12), rgba(255, 255, 255, 0.10));
        }

        .support-room-content {
            position: relative;
            z-index: 1;
        }

        .support-kpi,
        .support-hero,
        .support-inbox,
        .support-chat,
        .support-topic,
        .support-empty,
        .support-composer,
        .support-message,
        .support-message-self,
        .support-message-other,
        .support-select {
            backdrop-filter: blur(18px);
        }

        html.theme-dark .support-room-bg-light {
            display: none !important;
        }

        html.theme-dark .support-room-bg-dark {
            display: block !important;
        }

        html:not(.theme-dark) .support-room-shell .support-room-overlay {
            background:
                linear-gradient(180deg, rgba(255, 255, 255, 0.28), rgba(248, 250, 252, 0.84)),
                linear-gradient(135deg, rgba(255, 255, 255, 0.12), rgba(241, 245, 249, 0.20));
        }

        html:not(.theme-dark) .support-room-shell .support-hero,
        html:not(.theme-dark) .support-room-shell .support-kpi,
        html:not(.theme-dark) .support-room-shell .support-inbox,
        html:not(.theme-dark) .support-room-shell .support-chat,
        html:not(.theme-dark) .support-room-shell .support-topic,
        html:not(.theme-dark) .support-room-shell .support-empty,
        html:not(.theme-dark) .support-room-shell .support-composer,
        html:not(.theme-dark) .support-room-shell .support-inbox-card {
            background-color: rgba(255, 255, 255, 0.88) !important;
            border-color: rgba(226, 232, 240, 0.92) !important;
        }

        html:not(.theme-dark) .support-room-shell .support-kpi p:first-child,
        html:not(.theme-dark) .support-room-shell .support-thread-count,
        html:not(.theme-dark) .support-room-shell .support-inbox-time,
        html:not(.theme-dark) .support-room-shell .support-inbox-preview,
        html:not(.theme-dark) .support-room-shell .support-thread-email,
        html:not(.theme-dark) .support-room-shell .support-sidebar-meta {
            color: #94a3b8 !important;
        }

        html:not(.theme-dark) .support-room-shell .support-hero .text-slate-600,
        html:not(.theme-dark) .support-room-shell .support-topic,
        html:not(.theme-dark) .support-room-shell .support-empty .support-sidebar-meta {
            color: #334155 !important;
        }

        html:not(.theme-dark) .support-room-shell .support-composer textarea {
            color: #0f172a !important;
            background-color: rgba(255, 255, 255, 0.55) !important;
        }

        html:not(.theme-dark) .support-room-shell .support-composer textarea::placeholder {
            color: #94a3b8 !important;
        }

        html:not(.theme-dark) .support-room-shell .support-select,
        html:not(.theme-dark) .support-room-shell .support-composer textarea,
        html:not(.theme-dark) .support-room-shell .support-issue-select {
            background-color: rgba(255, 255, 255, 0.88) !important;
            border-color: rgba(203, 213, 225, 0.96) !important;
        }

        html:not(.theme-dark) .support-room-shell .support-message-self {
            background: linear-gradient(135deg, #2563eb, #1d4ed8) !important;
            color: #f8fbff !important;
        }

        html:not(.theme-dark) .support-room-shell .support-message-other {
            background: rgba(255, 255, 255, 0.94) !important;
            color: #334155 !important;
            border-color: rgba(226, 232, 240, 0.92) !important;
        }

        html:not(.theme-dark) .support-room-shell #supportMessages {
            background-color: rgba(248, 250, 252, 0.64) !important;
        }

        html:not(.theme-dark) .support-room-shell .support-message img {
            --tw-ring-color: rgba(226, 232, 240, 0.95) !important;
        }

        html:not(.theme-dark) .support-room-shell .support-message {
            box-shadow: none !important;
        }

        html:not(.theme-dark) .support-room-shell .support-inbox-card.is-active {
            background-color: rgba(219, 234, 254, 0.88) !important;
            border-color: rgba(125, 211, 252, 0.95) !important;
        }

        html:not(.theme-dark) .support-room-shell .support-inbox-card:hover {
            background-color: rgba(248, 250, 252, 0.98) !important;
        }

        html:not(.theme-dark) .support-room-shell .support-icon {
            background-color: rgba(224, 242, 254, 0.94) !important;
            color: #0284c7 !important;
        }

        html:not(.theme-dark) .support-room-shell .support-inbox-name {
            color: #0f172a !important;
        }

        html:not(.theme-dark) .support-room-shell .support-inbox-tag {
            background-color: rgba(241, 245, 249, 0.95) !important;
            color: #475569 !important;
        }

        html:not(.theme-dark) .support-room-shell .support-thread-count {
            color: #64748b !important;
        }

        html:not(.theme-dark) .support-room-shell .support-sidebar-card {
            background-color: rgba(255, 255, 255, 0.88) !important;
            border-color: rgba(226, 232, 240, 0.92) !important;
        }

        html:not(.theme-dark) .support-room-shell .support-sidebar-card:hover {
            background-color: rgba(248, 250, 252, 0.98) !important;
        }

        html:not(.theme-dark) .support-room-shell .support-sidebar-card.is-active {
            background-color: rgba(219, 234, 254, 0.88) !important;
            border-color: rgba(125, 211, 252, 0.95) !important;
        }

        html:not(.theme-dark) .support-room-shell .support-sidebar-title {
            color: #0f172a !important;
        }

        html:not(.theme-dark) .support-room-shell .support-sidebar-meta,
        html:not(.theme-dark) .support-room-shell .support-sidebar-preview,
        html:not(.theme-dark) .support-room-shell .support-sidebar-badge {
            color: #64748b !important;
        }

        .support-composer textarea {
            min-height: 76px;
            max-height: 220px;
            overflow: hidden;
        }

        html.theme-dark .support-room-shell .support-room-overlay {
            background:
                linear-gradient(180deg, rgba(6, 10, 18, 0.18), rgba(6, 10, 18, 0.68)),
                linear-gradient(135deg, rgba(6, 10, 18, 0.10), rgba(6, 10, 18, 0.22));
        }

        html.theme-dark .support-room-shell .support-hero,
        html.theme-dark .support-room-shell .support-kpi,
        html.theme-dark .support-room-shell .support-inbox,
        html.theme-dark .support-room-shell .support-chat,
        html.theme-dark .support-room-shell .support-topic,
        html.theme-dark .support-room-shell .support-empty,
        html.theme-dark .support-room-shell .support-composer,
        html.theme-dark .support-room-shell .support-inbox-card {
            background-color: rgba(12, 18, 31, 0.94) !important;
            border-color: rgba(148, 163, 184, 0.16) !important;
        }

        html.theme-dark .support-room-shell .support-kpi p:first-child,
        html.theme-dark .support-room-shell .support-thread-count,
        html.theme-dark .support-room-shell .support-inbox-time,
        html.theme-dark .support-room-shell .support-inbox-preview,
        html.theme-dark .support-room-shell .support-thread-email,
        html.theme-dark .support-room-shell .support-sidebar-meta {
            color: #9fb0c7 !important;
        }

        html.theme-dark .support-room-shell .support-hero .text-slate-600,
        html.theme-dark .support-room-shell .support-topic,
        html.theme-dark .support-room-shell .support-empty .support-sidebar-meta {
            color: #dbe7f5 !important;
        }

        html.theme-dark .support-room-shell .support-composer textarea {
            color: #edf4ff !important;
            background-color: rgba(11, 18, 32, 0.92) !important;
        }

        html.theme-dark .support-room-shell .support-composer textarea::placeholder {
            color: #7f8ca1 !important;
        }

        html.theme-dark .support-room-shell .support-select,
        html.theme-dark .support-room-shell .support-composer textarea,
        html.theme-dark .support-room-shell .support-issue-select {
            background-color: rgba(11, 18, 32, 0.92) !important;
            border-color: rgba(148, 163, 184, 0.20) !important;
        }

        html.theme-dark .support-room-shell .support-message-self {
            background: linear-gradient(135deg, #2563eb, #1d4ed8) !important;
            color: #f8fbff !important;
        }

        html.theme-dark .support-room-shell .support-message-other {
            background: rgba(12, 18, 31, 0.92) !important;
            color: #e5edf8 !important;
            border-color: rgba(148, 163, 184, 0.18) !important;
        }

        html.theme-dark .support-room-shell #supportMessages {
            background-color: transparent !important;
        }

        html.theme-dark .support-room-shell .support-message img {
            --tw-ring-color: rgba(148, 163, 184, 0.22) !important;
        }

        html.theme-dark .support-room-shell .support-icon {
            background-color: rgba(37, 99, 235, 0.22) !important;
            color: #dbeafe !important;
            border: 1px solid rgba(96, 165, 250, 0.18);
        }

        html.theme-dark .support-room-shell .support-avatar-ring {
            --tw-ring-color: rgba(148, 163, 184, 0.22) !important;
        }

        html.theme-dark .support-room-shell .support-inbox-card:hover {
            background-color: rgba(17, 24, 39, 0.98) !important;
        }

        html.theme-dark .support-room-shell .support-inbox-card.is-active {
            background-color: rgba(18, 32, 52, 0.98) !important;
            border-color: rgba(96, 165, 250, 0.32) !important;
        }

        html.theme-dark .support-room-shell .support-inbox-name {
            color: #f8fbff !important;
        }

        html.theme-dark .support-room-shell .support-inbox-tag {
            background-color: rgba(30, 41, 59, 0.92) !important;
            color: #cbd5e1 !important;
        }

        html.theme-dark .support-room-shell .support-sidebar-card {
            background-color: rgba(12, 18, 31, 0.94) !important;
            border-color: rgba(148, 163, 184, 0.16) !important;
        }

        html.theme-dark .support-room-shell .support-sidebar-card:hover {
            background-color: rgba(17, 24, 39, 0.98) !important;
        }

        html.theme-dark .support-room-shell .support-sidebar-card.is-active {
            background-color: rgba(18, 32, 52, 0.98) !important;
            border-color: rgba(96, 165, 250, 0.32) !important;
        }

        html.theme-dark .support-room-shell .support-sidebar-title {
            color: #f8fbff !important;
        }

        html.theme-dark .support-room-shell .support-sidebar-meta,
        html.theme-dark .support-room-shell .support-sidebar-preview,
        html.theme-dark .support-room-shell .support-sidebar-badge {
            color: #9fb0c7 !important;
        }
    </style>

    <div class="mx-auto max-w-7xl space-y-6">
        @if (session('success'))
            <div class="rounded-3xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        <div class="support-hero relative overflow-hidden rounded-[2rem] border border-slate-100 bg-white p-6 shadow-xl shadow-slate-200/60 sm:p-8">
            <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(6,182,212,0.12),transparent_30%),radial-gradient(circle_at_bottom_left,rgba(59,130,246,0.08),transparent_28%)]"></div>
            <div class="relative flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
                <div class="max-w-3xl">
                    <div class="inline-flex items-center gap-2 rounded-full border border-cyan-100 bg-cyan-50 px-3 py-1 text-xs font-bold uppercase tracking-[0.22em] text-cyan-700">
                        <span class="h-2 w-2 rounded-full bg-cyan-500"></span>
                        Customer Service
                    </div>
                    <h1 class="mt-4 text-3xl font-black tracking-tight text-slate-900 sm:text-4xl">
                        Ruang Chat <span class="text-cyan-600">Bantuan</span>
                    </h1>
                    <p class="mt-4 max-w-2xl text-base leading-7 text-slate-600">
                        Laporkan bug, sampaikan masalah, atau kirim pesan ke admin seperti percakapan DM. Semua pesan tersimpan agar mudah ditindaklanjuti.
                    </p>
                </div>

                <div class="grid w-full max-w-sm grid-cols-2 gap-3">
                    <div class="support-kpi rounded-3xl border border-slate-200 bg-slate-50 p-4 shadow-sm">
                        <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-slate-400">Respons</p>
                        <p class="mt-2 text-sm font-semibold text-slate-900">Balasan admin</p>
                    </div>
                    <div class="support-kpi rounded-3xl border border-slate-200 bg-slate-50 p-4 shadow-sm">
                        <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-slate-400">Jenis</p>
                        <p class="mt-2 text-sm font-semibold text-slate-900">Bug dan keluhan</p>
                    </div>
                    <div class="support-kpi rounded-3xl border border-slate-200 bg-slate-50 p-4 shadow-sm">
                        <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-slate-400">Mode</p>
                        <p class="mt-2 text-sm font-semibold text-slate-900">Chat langsung</p>
                    </div>
                    <div class="support-kpi rounded-3xl border border-slate-200 bg-slate-50 p-4 shadow-sm">
                        <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-slate-400">Status</p>
                        <p class="mt-2 text-sm font-semibold text-slate-900">{{ $isAdmin ? 'Inbox admin' : 'Pesan user' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid gap-6 {{ $isAdmin ? 'lg:grid-cols-[24rem_1fr]' : 'grid-cols-1' }}">
            @if ($isAdmin)
                <aside class="support-inbox support-sidebar-card rounded-[2rem] border border-slate-100 bg-white shadow-xl shadow-slate-200/40">
                    <div class="border-b border-slate-100 px-5 py-5">
                        <p class="support-sidebar-meta text-xs font-bold uppercase tracking-[0.22em] text-slate-400">Inbox</p>
                        <h2 class="support-sidebar-title mt-2 text-2xl font-black text-slate-900">Pesan Masuk</h2>
                        <p class="support-sidebar-meta mt-2 text-sm text-slate-500">Klik akun untuk membuka room chat dan membalas pesan user.</p>
                    </div>

                    <div class="max-h-[70vh] overflow-y-auto p-3">
                        @forelse ($threads as $conversation)
                            @php
                                $isActive = (int) $activeThreadId === (int) $conversation->id;
                                $latestBody = $conversation->latestMessage?->body ?? 'Belum ada pesan';
                            @endphp
                            <a href="{{ route('support.index', ['thread' => $conversation->id]) }}" class="support-inbox-card mb-2 block rounded-[1.5rem] border p-4 transition {{ $isActive ? 'is-active border-cyan-200 bg-cyan-50 shadow-sm' : 'border-slate-100 bg-white hover:border-cyan-100 hover:bg-slate-50' }}">
                                <div class="flex items-start gap-3">
                                    <img src="{{ $conversation->user->profilePhotoUrl() }}" alt="{{ $conversation->user->name }}" class="support-avatar-ring h-12 w-12 rounded-2xl object-cover ring-2 ring-white shadow-sm">
                                    <div class="min-w-0 flex-1">
                                        <div class="flex items-center justify-between gap-3">
                                            <p class="support-inbox-name truncate font-bold text-slate-900">{{ $conversation->user->name }}</p>
                                            <span class="support-inbox-time shrink-0 text-[11px] text-slate-400">
                                                {{ $conversation->last_message_at ? $conversation->last_message_at->diffForHumans() : 'Baru' }}
                                            </span>
                                        </div>
                                        <p class="support-inbox-preview mt-1 truncate text-sm text-slate-500">{{ \Illuminate\Support\Str::limit($latestBody, 54) }}</p>
                                        <div class="mt-3 flex items-center gap-2">
                                            @if ($conversation->unread_admin_count > 0)
                                                <span class="inline-flex items-center rounded-full bg-rose-100 px-2.5 py-1 text-[11px] font-bold text-rose-600">{{ $conversation->unread_admin_count }}</span>
                                            @endif
                                            <span class="support-inbox-tag inline-flex items-center rounded-full bg-slate-100 px-2.5 py-1 text-[11px] font-semibold text-slate-500">User</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="support-sidebar-card rounded-[1.75rem] border border-dashed border-slate-200 bg-slate-50 p-8 text-center">
                                <div class="support-icon mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-white text-cyan-600 shadow-sm">
                                    <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 12a8 8 0 018-8h0a8 8 0 018 8v2a4 4 0 01-4 4h-1l-2 3v-3H8a4 4 0 01-4-4v-2z"></path>
                                    </svg>
                                </div>
                                <p class="support-sidebar-title mt-4 text-sm font-bold text-slate-900">Belum ada pesan masuk</p>
                                <p class="support-sidebar-meta mt-2 text-sm text-slate-500">Saat user mengirim laporan, percakapan akan muncul di sini.</p>
                            </div>
                        @endforelse
                    </div>
                </aside>
            @endif

            <section class="support-chat support-room-shell flex min-h-[70vh] flex-col overflow-hidden rounded-[2rem] border border-slate-100 bg-white shadow-xl shadow-slate-200/40">
                <div class="support-room-bg support-room-bg-light" style="background-image: url('{{ $lightChatBgUrl }}');"></div>
                <div class="support-room-bg support-room-bg-dark hidden" style="background-image: url('{{ $darkChatBgUrl }}');"></div>
                <div class="support-room-overlay"></div>

                <div class="support-room-content border-b border-slate-100 px-5 py-5 sm:px-6">
                    @if ($thread)
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                            <div class="flex items-center gap-3">
                                <div class="support-icon flex h-12 w-12 items-center justify-center rounded-2xl bg-cyan-50 text-cyan-700">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 12a8 8 0 018-8h0a8 8 0 018 8v2a4 4 0 01-4 4h-1l-2 3v-3H8a4 4 0 01-4-4v-2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="support-thread-count text-xs font-bold uppercase tracking-[0.22em] text-slate-400">{{ $isAdmin ? 'Percakapan User' : 'Customer Service' }}</p>
                                    <h2 class="support-inbox-name mt-1 text-2xl font-black text-slate-900">
                                        {{ $isAdmin ? $thread->user->name : 'Admin Support' }}
                                    </h2>
                                    <p class="support-thread-email mt-1 text-sm text-slate-500">
                                        {{ $isAdmin ? ($thread->user->email ?? 'Akun user') : 'Kirim keluhan, bug, atau pertanyaan ke admin.' }}
                                    </p>
                                </div>
                            </div>

                            <div class="support-sidebar-card rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-600">
                                {{ $thread->messages->count() }} pesan
                            </div>
                        </div>
                        @if (! $isAdmin)
                            <div class="support-topic mt-4 inline-flex flex-wrap items-center gap-2 rounded-2xl border border-cyan-100 bg-cyan-50 px-4 py-3 text-sm text-cyan-800">
                                <span class="support-thread-count text-xs font-bold uppercase tracking-[0.18em] text-cyan-500">Topik</span>
                                <span class="font-semibold">{{ $issueOptions[$selectedIssueType] ?? 'Belum dipilih' }}</span>
                                <span class="text-cyan-700/80">- {{ $selectedIssuePrompt }}</span>
                            </div>
                        @elseif ($thread)
                            <div class="support-topic mt-4 inline-flex flex-wrap items-center gap-2 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-600">
                                <span class="support-thread-count text-xs font-bold uppercase tracking-[0.18em] text-slate-400">Topik</span>
                                <span class="font-semibold text-slate-900">{{ $thread->issue_type_label }}</span>
                                <span>{{ $thread->issue_prompt }}</span>
                            </div>
                        @endif
                    @else
                        <div class="flex items-center gap-3">
                            <div class="support-icon flex h-12 w-12 items-center justify-center rounded-2xl bg-cyan-50 text-cyan-700">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 12a8 8 0 018-8h0a8 8 0 018 8v2a4 4 0 01-4 4h-1l-2 3v-3H8a4 4 0 01-4-4v-2z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="support-thread-count text-xs font-bold uppercase tracking-[0.22em] text-slate-400">Customer Service</p>
                                <h2 class="support-inbox-name mt-1 text-2xl font-black text-slate-900">Pilih percakapan</h2>
                            </div>
                        </div>
                    @endif
                </div>

                <div id="supportMessages" class="support-room-content flex-1 space-y-4 overflow-y-auto px-4 py-5 sm:px-6">
                    @if ($thread && $messages->count() > 0)
                        @foreach ($messages as $message)
                            @php
                                $isMine = $isAdmin ? $message->sender_role === 'admin' : $message->sender_role === 'user';
                            @endphp
                            <div class="flex {{ $isMine ? 'justify-end' : 'justify-start' }}">
                                <div class="flex max-w-[82%] items-end gap-2 {{ $isMine ? 'flex-row-reverse' : 'flex-row' }}">
                                    <img src="{{ $message->sender->profilePhotoUrl() }}" alt="{{ $message->sender->name }}" class="h-9 w-9 rounded-2xl object-cover ring-2 ring-slate-700/40 shadow-sm">
                                    <div class="support-message rounded-[1.5rem] px-4 py-3 {{ $isMine ? 'support-message-self' : 'support-message-other border' }}">
                                        <div class="flex items-center justify-between gap-4">
                                            <p class="text-xs font-bold uppercase tracking-[0.18em] {{ $isMine ? 'text-cyan-100' : 'text-slate-400' }}">
                                                {{ $message->sender->name }}
                                            </p>
                                            <p class="shrink-0 text-[11px] {{ $isMine ? 'text-cyan-100/80' : 'text-slate-400' }}">
                                                {{ $message->created_at->translatedFormat('d M Y H:i') }}
                                            </p>
                                        </div>
                                        <p class="mt-2 whitespace-pre-wrap text-sm leading-6 {{ $isMine ? 'text-white' : 'text-slate-200' }}">{{ $message->body }}</p>
                                        @if ($message->read_at && $isMine)
                                            <p class="mt-2 text-[11px] {{ $isMine ? 'text-cyan-100/80' : 'text-slate-400' }}">Terkirim</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="flex min-h-[28rem] items-center justify-center">
                            <div class="support-empty max-w-md rounded-[1.75rem] border border-dashed border-slate-200 bg-white p-8 text-center">
                                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-cyan-50 text-cyan-700">
                                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 12a8 8 0 018-8h0a8 8 0 018 8v2a4 4 0 01-4 4h-1l-2 3v-3H8a4 4 0 01-4-4v-2z"></path>
                                    </svg>
                                </div>
                                <h3 class="mt-4 text-lg font-bold text-slate-900">Mulai percakapan</h3>
                                <p class="mt-2 text-sm leading-6 text-slate-500">
                                    {{ $isAdmin ? 'Pilih akun di daftar inbox untuk membaca dan membalas pesan.' : 'Tulis keluhan atau pertanyaan pertama kamu di kolom bawah.' }}
                                </p>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="support-composer border-t border-slate-100 bg-white px-4 py-4 sm:px-6">
                    <form id="supportComposeForm" action="{{ route('support.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="thread_id" value="{{ $thread->id ?? '' }}">
                        @if (! $isAdmin)
                            <div class="space-y-2">
                                <div class="flex items-center justify-between gap-3">
                                    <label for="supportIssueType" class="text-sm font-semibold text-slate-900">Pilih jenis masalah</label>
                                    <span class="text-[11px] font-bold uppercase tracking-[0.18em] text-cyan-500">Wajib dipilih</span>
                                </div>
                                <select
                                    id="supportIssueType"
                                    name="issue_type"
                                    required
                                    class="support-issue-select w-full rounded-[1.25rem] border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-cyan-400 focus:bg-white focus:ring-4 focus:ring-cyan-100"
                                >
                                    <option value="">Pilih masalah yang ingin kamu laporkan</option>
                                    @foreach ($issueOptions as $key => $label)
                                        <option value="{{ $key }}" @selected($selectedIssueType === $key)>{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('issue_type')
                                    <p class="text-sm text-rose-600">{{ $message }}</p>
                                @enderror
                                <p id="supportIssueHelper" class="text-xs leading-5 text-slate-500">{{ $selectedIssuePrompt }}</p>
                            </div>
                        @else
                            <input type="hidden" name="issue_type" value="{{ $thread?->issue_type }}">
                        @endif

                        <div class="rounded-[1.75rem] border border-slate-200 bg-slate-50 p-3 transition focus-within:border-cyan-400 focus-within:bg-white focus-within:ring-4 focus-within:ring-cyan-100">
                            <div class="relative">
                                <label for="supportBody" class="sr-only">Tulis pesan</label>
                                <textarea
                                    id="supportBody"
                                    name="body"
                                    rows="2"
                                    @disabled(! $thread || (! $isAdmin && ! $selectedIssueType))
                                    placeholder="{{ $thread ? ($isAdmin ? 'Tulis balasan untuk user...' : $selectedIssuePlaceholder) : 'Pilih percakapan terlebih dahulu' }}"
                                    class="w-full resize-none rounded-[1.25rem] border-0 bg-transparent px-1 py-1 pr-16 pb-16 text-sm leading-6 text-slate-900 outline-none placeholder:text-slate-400 disabled:cursor-not-allowed disabled:text-slate-400"
                                >{{ old('body') }}</textarea>
                                <button
                                    type="submit"
                                    @disabled(! $thread || (! $isAdmin && ! $selectedIssueType))
                                    class="absolute bottom-3 right-3 inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-cyan-600 text-white shadow-lg shadow-cyan-600/20 transition hover:bg-cyan-500 hover:shadow-cyan-600/30 disabled:cursor-not-allowed disabled:bg-slate-300 disabled:shadow-none"
                                    aria-label="Kirim pesan"
                                >
                                    <svg class="h-5 w-5 -translate-x-px translate-y-px" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M22 2L11 13"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M22 2l-7 20-4-9-9-4 20-7z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        @error('body')
                            <p class="text-sm text-rose-600">{{ $message }}</p>
                        @enderror

                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                            <p class="text-xs text-slate-500">
                                @if ($isAdmin)
                                    Balasan akan terkirim langsung ke user yang dipilih.
                                @else
                                    Tekan Enter untuk kirim, Shift+Enter untuk baris baru.
                                @endif
                            </p>

                            @unless ($isAdmin)
                                <button
                                    type="button"
                                    id="supportClearButton"
                                    class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:border-rose-200 hover:bg-rose-50 hover:text-rose-600"
                                >
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6h18"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 6V4h8v2"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6l1 14h10l1-14"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11v5"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 11v5"></path>
                                    </svg>
                                    Bersihkan Obrolan
                                </button>
                            @endunless
                        </div>
                    </form>
                    @unless ($isAdmin)
                        <form id="supportClearForm" action="{{ route('support.clear') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    @endunless
                </div>
            </section>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        (function () {
            const supportMessages = document.getElementById('supportMessages');
            if (supportMessages) {
                requestAnimationFrame(function () {
                    supportMessages.scrollTop = supportMessages.scrollHeight;
                });
            }

            const supportForm = document.getElementById('supportComposeForm');
            const supportBody = document.getElementById('supportBody');
            const supportIssueType = document.getElementById('supportIssueType');
            const supportIssueHelper = document.getElementById('supportIssueHelper');
            const supportClearButton = document.getElementById('supportClearButton');
            const supportClearForm = document.getElementById('supportClearForm');

            const issueContent = @json($issueGuidance);

            const defaultPrompt = 'Pilih jenis masalah terlebih dahulu agar admin lebih cepat membantu.';
            const defaultPlaceholder = 'Pilih jenis masalah terlebih dahulu...';

            function updateComposerState() {
                if (!supportIssueType || !supportBody) {
                    return;
                }

                const selectedType = supportIssueType.value;
                const selectedContent = issueContent[selectedType] || null;
                const isSelected = Boolean(selectedType);

                supportBody.disabled = !isSelected;
                supportBody.placeholder = selectedContent ? selectedContent.placeholder : defaultPlaceholder;
                if (supportIssueHelper) {
                    supportIssueHelper.textContent = selectedContent ? selectedContent.prompt : defaultPrompt;
                }
                if (supportForm) {
                    const submitButton = supportForm.querySelector('button[type="submit"]');
                    if (submitButton) {
                        submitButton.disabled = !isSelected;
                    }
                }

                resizeBody();
            }

            function resizeBody() {
                if (!supportBody) {
                    return;
                }

                if (supportBody.disabled) {
                    supportBody.style.height = '76px';
                    return;
                }

                supportBody.style.height = 'auto';
                const nextHeight = Math.min(supportBody.scrollHeight, 220);
                supportBody.style.height = Math.max(nextHeight, 76) + 'px';
            }

            if (supportIssueType) {
                updateComposerState();
                supportIssueType.addEventListener('change', updateComposerState);
            }

            if (supportBody && supportForm) {
                resizeBody();
                supportBody.addEventListener('input', resizeBody);
                supportBody.addEventListener('keydown', function (event) {
                    if (event.key === 'Enter' && ! event.shiftKey && ! supportBody.disabled) {
                        event.preventDefault();
                        if (typeof supportForm.requestSubmit === 'function') {
                            supportForm.requestSubmit();
                        } else {
                            supportForm.submit();
                        }
                    }
                });
            }

            if (supportClearButton && supportClearForm) {
                supportClearButton.addEventListener('click', function () {
                    const confirmed = window.confirm('Bersihkan obrolan ini dan mulai dari awal?');
                    if (confirmed) {
                        supportClearForm.submit();
                    }
                });
            }

            window.addEventListener('themechange', resizeBody);
        })();
    </script>
@endpush
