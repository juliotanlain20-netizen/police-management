@extends('layouts.app')

@section('title', 'Detail Pengaduan')

@section('content')

@php
    $user = auth()->user();

    $isOwner = $user->id === $complaint->user_id;

    $canEdit = $isOwner && in_array($complaint->status, [
        'Draft',
        'Need More Evidence'
    ]);

    $canDelete = $isOwner && !$complaint->investigationCase;

    $statusClass = match ($complaint->status) {
        'Draft' => 'bg-slate-100 text-slate-700',
        'Pending' => 'bg-amber-100 text-amber-800',
        'Need More Evidence' => 'bg-blue-100 text-blue-800',
        'Approved' => 'bg-emerald-100 text-emerald-800',
        'Rejected' => 'bg-rose-100 text-rose-800',
        default => 'bg-slate-100 text-slate-700'
    };
@endphp


{{-- PAGE HEADER --}}
<div class="mb-7 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">

    <div>
        <h1 class="mb-1 text-3xl font-bold text-[#0B1F3A]">Detail Pengaduan</h1>
        <p class="text-sm text-slate-500">Informasi lengkap mengenai pengaduan.</p>
    </div>

    <a href="{{ route('complaint') }}" class="inline-flex min-h-9 items-center justify-center gap-2 self-start rounded-lg border border-slate-300 bg-[#F8FAFC] px-4 text-sm font-medium text-slate-600 transition hover:bg-[#EEF3F8] hover:text-[#0B1F3A]">

        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
        </svg>

        Kembali
    </a>

</div>


{{-- DETAIL --}}
<div class="mb-6 overflow-hidden rounded-xl border border-slate-200 bg-[#F8FAFC]">

    <div class="flex flex-col gap-3 border-b border-slate-200 px-5 py-5 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-xl font-bold text-[#0B1F3A]">{{ $complaint->title }}</h2>

        <span class="inline-flex self-start whitespace-nowrap rounded-full px-3 py-1 text-xs font-bold {{ $statusClass }}">
            {{ $complaint->status }}
        </span>
    </div>

    <div class="grid grid-cols-1 gap-0 sm:grid-cols-2 xl:grid-cols-3">

        <div class="border-b border-slate-100 px-5 py-4 sm:border-r">
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400">Pelapor</p>
            <p class="text-sm font-semibold text-slate-700">{{ $complaint->user?->name ?? '-' }}</p>
        </div>

        <div class="border-b border-slate-100 px-5 py-4 xl:border-r">
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400">Kategori</p>
            <p class="text-sm font-semibold text-slate-700">{{ $complaint->category?->name ?? '-' }}</p>
        </div>

        <div class="border-b border-slate-100 px-5 py-4 sm:border-r xl:border-r-0">
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400">Lokasi Kejadian</p>
            <p class="text-sm font-semibold text-slate-700">{{ $complaint->location ?? '-' }}</p>
        </div>

        <div class="border-b border-slate-100 px-5 py-4 xl:border-b-0 xl:border-r">
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400">Tanggal Kejadian</p>
            <p class="text-sm font-semibold text-slate-700">{{ $complaint->incident_date ?? '-' }}</p>
        </div>

        <div class="border-b border-slate-100 px-5 py-4 sm:border-r sm:border-b-0">
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400">Dibuat Pada</p>
            <p class="text-sm font-semibold text-slate-700">{{ $complaint->created_at->format('d M Y H:i') }}</p>
        </div>

    </div>

    <div class="border-t border-slate-100 px-5 py-5">
        <p class="mb-2 text-xs font-semibold uppercase tracking-wide text-slate-400">Deskripsi</p>
        <p class="whitespace-pre-line text-sm leading-7 text-slate-600">{{ $complaint->description }}</p>
    </div>

</div>


{{-- ATTACHMENTS --}}
<div class="mb-6 overflow-hidden rounded-xl border border-slate-200 bg-[#F8FAFC]">

    <div class="border-b border-slate-200 px-5 py-5">
        <h2 class="text-lg font-bold text-[#0B1F3A]">Attachment</h2>
        <p class="mt-1 text-xs text-slate-400">Dokumen atau file pendukung yang dilampirkan pada pengaduan.</p>
    </div>

    <div class="divide-y divide-slate-100">

        @forelse ($complaint->attachments as $attachment)

            <div class="flex flex-col gap-4 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">

                <div class="flex min-w-0 items-center gap-3">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739 10.682 20.43a4.5 4.5 0 0 1-6.364-6.364l9.546-9.546a3 3 0 0 1 4.243 4.243l-9.193 9.193a1.5 1.5 0 0 1-2.121-2.121l8.485-8.485" />
                        </svg>
                    </div>

                    <div class="min-w-0">
                        <p class="truncate text-sm font-semibold text-slate-700">{{ $attachment->file_name }}</p>
                        <p class="mt-1 text-xs text-slate-400">{{ $attachment->mime_type }}</p>
                    </div>

                </div>

                <div class="flex shrink-0 flex-wrap gap-2">

                    <a href="{{ route('complaint.attachments.show', [$complaint->id, $attachment->id]) }}" target="_blank" rel="noopener noreferrer" class="inline-flex min-h-9 items-center justify-center gap-2 rounded-lg border border-slate-300 bg-[#F8FAFC] px-3 text-sm font-medium text-slate-600 transition hover:bg-[#EEF3F8]">

                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12 18 18.75 12 18.75 2.25 12 2.25 12Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>

                        Lihat
                    </a>

                    <a href="{{ route('complaint.attachments.download', [$complaint->id, $attachment->id]) }}" class="inline-flex min-h-9 items-center justify-center gap-2 rounded-lg border border-slate-300 bg-[#F8FAFC] px-3 text-sm font-medium text-slate-600 transition hover:bg-[#EEF3F8]">

                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M7.5 10.5 12 15m0 0 4.5-4.5M12 15V3" />
                        </svg>

                        Download
                    </a>

                </div>

            </div>

        @empty

            <div class="px-5 py-10 text-center">
                <div class="mx-auto mb-3 flex h-11 w-11 items-center justify-center rounded-full bg-slate-100 text-slate-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739 10.682 20.43a4.5 4.5 0 0 1-6.364-6.364l9.546-9.546a3 3 0 0 1 4.243 4.243" />
                    </svg>
                </div>

                <p class="text-sm font-medium text-slate-500">Belum ada attachment.</p>
            </div>

        @endforelse

    </div>

</div>


{{-- OWNER ACTION --}}
@if ($isOwner)

    <div class="mb-6 overflow-hidden rounded-xl border border-slate-200 bg-[#F8FAFC]">

        <div class="border-b border-slate-200 px-5 py-5">
            <h2 class="text-lg font-bold text-[#0B1F3A]">Aksi Pengaduan</h2>
            <p class="mt-1 text-xs text-slate-400">Kelola pengaduan yang Anda buat.</p>
        </div>

        <div class="flex flex-wrap gap-3 p-5">

            @if ($canEdit)

                <a href="{{ route('complaint.edit', $complaint->id) }}" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-lg bg-[#2F80ED] px-4 text-sm font-semibold text-white transition hover:bg-blue-600">

                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.862 4.487Z" />
                    </svg>

                    Edit Pengaduan
                </a>

            @endif


            @if ($canDelete)

                <form action="{{ route('complaint.destroy', $complaint->id) }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <button type="submit" onclick="return confirm('Yakin ingin menghapus pengaduan ini?')" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-lg bg-rose-600 px-4 text-sm font-semibold text-white transition hover:bg-rose-700">

                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166M19.228 5.79 18.16 19.673A2.25 2.25 0 0 1 15.916 21H8.084a2.25 2.25 0 0 1-2.244-2.327L4.772 5.79M18 5.79A48.108 48.108 0 0 0 12 5.25c-2.04 0-4.043.127-6 .372M10.5 5.25V4.125A1.125 1.125 0 0 1 11.625 3h.75A1.125 1.125 0 0 1 13.5 4.125V5.25" />
                        </svg>

                        Hapus Pengaduan
                    </button>
                </form>

            @endif

            @if (!$canEdit && !$canDelete)
                <p class="text-sm text-slate-400">Tidak ada aksi yang tersedia untuk pengaduan ini.</p>
            @endif

        </div>

    </div>

@endif


{{-- REVIEW POLICE / ADMIN --}}
@if ($complaint->status === 'Pending' && (
    $user->hasPermission('complaint.request_more_evidence') ||
    $user->hasPermission('complaint.reject') ||
    $user->hasPermission('case.create')
))

    <div class="mb-6 overflow-hidden rounded-xl border border-slate-200 bg-[#F8FAFC]">

        <div class="border-b border-slate-200 px-5 py-5">
            <h2 class="text-lg font-bold text-[#0B1F3A]">Review Pengaduan</h2>
            <p class="mt-1 text-xs text-slate-400">Tentukan tindak lanjut untuk pengaduan Pending ini.</p>
        </div>


        {{-- REVIEW ACTIONS --}}
        @if (
            $user->hasPermission('complaint.request_more_evidence') ||
            $user->hasPermission('complaint.reject')
        )

            <div class="flex flex-wrap gap-3 border-b border-slate-200 p-5">

                @if ($user->hasPermission('complaint.request_more_evidence'))

                    <form action="{{ route('complaint.requestMoreEvidence', $complaint->id) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <button type="submit" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-lg bg-amber-500 px-4 text-sm font-semibold text-white transition hover:bg-amber-600">

                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-1.5a9 9 0 1 1-18 0 9 9 0 0 1 18 0ZM12 16.5h.008v.008H12V16.5Z" />
                            </svg>

                            Minta Bukti Tambahan
                        </button>
                    </form>

                @endif


                @if ($user->hasPermission('complaint.reject'))

                    <form action="{{ route('complaint.reject', $complaint->id) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <button type="submit" onclick="return confirm('Tolak pengaduan ini?')" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-lg bg-rose-600 px-4 text-sm font-semibold text-white transition hover:bg-rose-700">
                            Reject
                        </button>
                    </form>

                @endif

            </div>

        @endif


        {{-- CONVERT TO CASE --}}
        @if ($user->hasPermission('case.create'))

            <div class="p-5">

                <div class="mb-5">
                    <h3 class="text-base font-bold text-[#0B1F3A]">Konversi Menjadi Kasus</h3>
                    <p class="mt-1 text-xs text-slate-400">Buat kasus investigasi berdasarkan pengaduan ini.</p>
                </div>


                @if ($errors->any())

                    <div class="mb-5 rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                        <ul class="list-disc space-y-1 pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>

                @endif


                <form action="{{ route('cases.store', $complaint->id) }}" method="POST" class="max-w-2xl">
                    @csrf

                    <div class="grid gap-4 sm:grid-cols-2">

                        <div>
                            <label for="case_number" class="mb-2 block text-sm font-semibold text-slate-700">Nomor Kasus</label>

                            <input type="text" name="case_number" id="case_number" value="{{ old('case_number') }}" placeholder="Contoh: CASE-2026-001" required class="h-11 w-full rounded-lg border border-slate-300 bg-[#F8FAFC] px-3 text-sm text-slate-700 outline-none transition focus:border-[#2F80ED] focus:ring-4 focus:ring-blue-100">
                        </div>


                        <div>
                            <label for="priority" class="mb-2 block text-sm font-semibold text-slate-700">Prioritas</label>

                            <select name="priority" id="priority" required class="h-11 w-full rounded-lg border border-slate-300 bg-[#F8FAFC] px-3 text-sm text-slate-700 outline-none transition focus:border-[#2F80ED] focus:ring-4 focus:ring-blue-100">
                                <option value="">Pilih Prioritas</option>
                                <option value="Low" @selected(old('priority') === 'Low')>Low</option>
                                <option value="Medium" @selected(old('priority') === 'Medium')>Medium</option>
                                <option value="High" @selected(old('priority') === 'High')>High</option>
                            </select>
                        </div>

                    </div>


                    <button type="submit" class="mt-5 inline-flex min-h-10 items-center justify-center gap-2 rounded-lg bg-[#2F80ED] px-4 text-sm font-semibold text-white transition hover:bg-blue-600">

                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>

                        Jadikan Kasus
                    </button>

                </form>

            </div>

        @endif

    </div>

@endif


{{-- ALREADY CONVERTED TO CASE --}}
@if (
    $complaint->status === 'Approved' &&
    $complaint->investigationCase &&
    $user->hasPermission('case.view_all')
)

    <div class="overflow-hidden rounded-xl border border-emerald-200 bg-emerald-50/50">

        <div class="flex flex-col gap-4 p-5 sm:flex-row sm:items-center sm:justify-between">

            <div class="flex items-start gap-3">

                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-emerald-100 text-emerald-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M12 3 4.5 6v5.25c0 4.35 2.79 8.25 7.5 9.75 4.71-1.5 7.5-5.4 7.5-9.75V6L12 3Z" />
                    </svg>
                </div>

                <div>
                    <h2 class="text-base font-bold text-emerald-900">Kasus Investigasi</h2>
                    <p class="mt-1 text-sm text-emerald-700">Pengaduan ini telah dikonversi menjadi kasus.</p>
                </div>

            </div>

            <a href="{{ route('cases.show', $complaint->investigationCase->id) }}" class="inline-flex min-h-10 shrink-0 items-center justify-center gap-2 rounded-lg bg-emerald-600 px-4 text-sm font-semibold text-white transition hover:bg-emerald-700">
                Lihat Kasus

                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                </svg>
            </a>

        </div>

    </div>

@endif

@endsection