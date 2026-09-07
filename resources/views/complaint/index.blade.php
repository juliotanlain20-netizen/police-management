@extends('layouts.app')

@section('title', 'Pengaduan')

@section('content')

@php
    $canViewAll = auth()->user()->hasPermission('complaint.view_all');
@endphp

<div class="mb-7">
    <h1 class="mb-1 text-3xl font-bold text-[#0B1F3A]">Pengaduan</h1>

    <p class="text-sm text-slate-500">
        {{ $canViewAll
            ? 'Tinjau dan kelola pengaduan masyarakat.'
            : 'Lihat dan kelola pengaduan yang Anda buat.' }}
    </p>
</div>


<div class="overflow-hidden rounded-xl border border-slate-200 bg-[#F8FAFC]">

    {{-- HEADER --}}
    <div class="flex flex-col gap-4 border-b border-slate-200 px-5 py-5 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h2 class="text-lg font-bold text-[#0B1F3A]">
                {{ $canViewAll ? 'Daftar Pengaduan' : 'Pengaduan Saya' }}
            </h2>

            <p class="mt-1 text-xs text-slate-400">
                {{ $canViewAll
                    ? 'Cari dan filter pengaduan masyarakat.'
                    : 'Cari dan filter pengaduan yang telah Anda buat.' }}
            </p>
        </div>

        @if (!$canViewAll)
            <a href="{{ route('complaint.create') }}" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-lg bg-[#2F80ED] px-4 text-sm font-semibold text-white transition hover:bg-blue-600">

                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>

                Buat Pengaduan
            </a>
        @endif

    </div>


    {{-- SEARCH & FILTER --}}
    <div class="border-b border-slate-200 bg-[#EEF3F8]/60 px-5 py-4">

        <form action="{{ route('complaint') }}" method="GET" class="flex flex-col gap-3 md:flex-row md:items-center">

            {{-- Pertahankan scope kalau sedang mode "mine" --}}
            @if (request('scope'))
                <input type="hidden" name="scope" value="{{ request('scope') }}">
            @endif


            {{-- SEARCH --}}
            <div class="relative flex-1">

                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-[18px] w-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m1.35-5.4a6.75 6.75 0 1 1-13.5 0 6.75 6.75 0 0 1 13.5 0Z" />
                    </svg>
                </span>

                <input type="text" name="q" value="{{ request('q') }}" placeholder="{{ $canViewAll ? 'Cari judul, deskripsi, atau pelapor...' : 'Cari judul atau deskripsi...' }}" class="h-10 w-full rounded-lg border border-slate-300 bg-[#F8FAFC] pl-10 pr-4 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-[#2F80ED] focus:ring-4 focus:ring-blue-100">
            </div>


            {{-- STATUS --}}
            <div class="relative md:w-[220px]">

                <select name="status" class="h-10 w-full cursor-pointer appearance-none rounded-lg border border-slate-300 bg-[#F8FAFC] px-3 pr-9 text-sm text-slate-700 outline-none transition focus:border-[#2F80ED] focus:ring-4 focus:ring-blue-100">

                    <option value="">Semua Status</option>
                    <option value="Draft" @selected(request('status') === 'Draft')>Draft</option>
                    <option value="Pending" @selected(request('status') === 'Pending')>Pending</option>
                    <option value="Need More Evidence" @selected(request('status') === 'Need More Evidence')>Need More Evidence</option>
                    <option value="Approved" @selected(request('status') === 'Approved')>Approved</option>
                    <option value="Rejected" @selected(request('status') === 'Rejected')>Rejected</option>

                </select>

                <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 9-7.5 7.5L4.5 9" />
                    </svg>
                </span>

            </div>


            {{-- SEARCH BUTTON --}}
            <button type="submit" class="inline-flex h-10 items-center justify-center gap-2 rounded-lg bg-[#0B1F3A] px-4 text-sm font-semibold text-white transition hover:bg-[#12396b]">

                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m1.35-5.4a6.75 6.75 0 1 1-13.5 0 6.75 6.75 0 0 1 13.5 0Z" />
                </svg>

                Cari
            </button>


            {{-- RESET --}}
            @if (request()->filled('q') || request()->filled('status'))
                <a href="{{ route('complaint', request('scope') ? ['scope' => request('scope')] : []) }}" class="inline-flex h-10 items-center justify-center rounded-lg border border-slate-300 bg-[#F8FAFC] px-4 text-sm font-medium text-slate-600 transition hover:bg-slate-100">
                    Reset
                </a>
            @endif

        </form>

    </div>


    {{-- RESULT INFO --}}
    @if (request()->filled('q') || request()->filled('status'))
        <div class="border-b border-slate-200 px-5 py-3 text-xs text-slate-500">

            Ditemukan
            <strong class="text-slate-700">{{ $complaints->count() }}</strong>
            pengaduan

            @if (request()->filled('q'))
                untuk pencarian
                <strong class="text-slate-700">"{{ request('q') }}"</strong>
            @endif

            @if (request()->filled('status'))
                dengan status
                <strong class="text-slate-700">{{ request('status') }}</strong>
            @endif

        </div>
    @endif


    {{-- TABLE --}}
    <div class="overflow-x-auto">

        <table class="w-full border-collapse">

            <thead class="bg-[#EEF3F8]">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Judul</th>

                    @if ($canViewAll)
                        <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Pelapor</th>
                    @endif

                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Status</th>
                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Tanggal</th>
                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-200">

                @forelse ($complaints as $complaint)

                    @php
                        $badgeClass = match ($complaint->status) {
                            'Draft' => 'bg-slate-100 text-slate-700',
                            'Pending' => 'bg-amber-100 text-amber-800',
                            'Need More Evidence' => 'bg-blue-100 text-blue-800',
                            'Approved' => 'bg-emerald-100 text-emerald-800',
                            'Rejected' => 'bg-rose-100 text-rose-800',
                            default => 'bg-slate-100 text-slate-700'
                        };
                    @endphp

                    <tr class="transition hover:bg-[#EEF3F8]">

                        <td class="px-5 py-4">
                            <p class="max-w-[420px] truncate text-sm font-semibold text-[#0B1F3A]">
                                {{ $complaint->title }}
                            </p>
                        </td>

                        @if ($canViewAll)
                            <td class="px-5 py-4 text-sm text-slate-600">
                                {{ $complaint->user?->name ?? '-' }}
                            </td>
                        @endif

                        <td class="px-5 py-4">
                            <span class="inline-flex whitespace-nowrap rounded-full px-3 py-1 text-xs font-bold {{ $badgeClass }}">
                                {{ $complaint->status }}
                            </span>
                        </td>

                        <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-500">
                            {{ $complaint->created_at->format('d M Y') }}
                        </td>

                        <td class="px-5 py-4">
                            <a href="{{ route('complaint.show', $complaint->id) }}" class="inline-flex min-h-9 items-center justify-center rounded-lg border border-slate-300 bg-[#F8FAFC] px-3 text-sm font-medium text-slate-700 transition hover:bg-[#EEF3F8]">
                                Detail
                            </a>
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="{{ $canViewAll ? 5 : 4 }}" class="px-5 py-12 text-center">

                            <div class="mx-auto flex max-w-sm flex-col items-center">
                                <div class="mb-3 flex h-11 w-11 items-center justify-center rounded-full bg-slate-100 text-slate-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m1.35-5.4a6.75 6.75 0 1 1-13.5 0 6.75 6.75 0 0 1 13.5 0Z" />
                                    </svg>
                                </div>

                                <p class="text-sm font-semibold text-slate-600">
                                    Tidak ada pengaduan yang ditemukan.
                                </p>

                                @if (request()->filled('q') || request()->filled('status'))
                                    <p class="mt-1 text-xs text-slate-400">
                                        Coba ubah kata pencarian atau filter status.
                                    </p>
                                @else
                                    <p class="mt-1 text-xs text-slate-400">
                                        Belum ada pengaduan.
                                    </p>
                                @endif
                            </div>

                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection