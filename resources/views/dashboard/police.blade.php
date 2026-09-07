@extends('layouts.app')

@section('title', 'Dashboard Police')

@section('content')

<div class="mb-7">
    <h1 class="mb-1 text-3xl font-bold text-[#0B1F3A]">Dashboard Police</h1>
    <p class="text-sm text-slate-500">Selamat datang, {{ auth()->user()->name }}. Berikut ringkasan pekerjaan Anda.</p>
</div>

{{-- STATISTICS --}}
<div class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

    <div class="relative overflow-hidden rounded-xl border border-slate-200 bg-[#F8FAFC] p-5 transition hover:-translate-y-0.5 hover:shadow-md">
        <div class="absolute inset-x-0 top-0 h-[3px] bg-amber-400"></div>
        <p class="mb-2 text-sm text-slate-500">Pengaduan Baru</p>
        <p class="text-3xl font-bold text-[#0B1F3A]">{{ $stats['pending_complaints'] }}</p>
    </div>

    <div class="relative overflow-hidden rounded-xl border border-slate-200 bg-[#F8FAFC] p-5 transition hover:-translate-y-0.5 hover:shadow-md">
        <div class="absolute inset-x-0 top-0 h-[3px] bg-blue-500"></div>
        <p class="mb-2 text-sm text-slate-500">Kasus Aktif Saya</p>
        <p class="text-3xl font-bold text-[#0B1F3A]">{{ $stats['active_cases'] }}</p>
    </div>

    <div class="relative overflow-hidden rounded-xl border border-slate-200 bg-[#F8FAFC] p-5 transition hover:-translate-y-0.5 hover:shadow-md">
        <div class="absolute inset-x-0 top-0 h-[3px] bg-violet-500"></div>
        <p class="mb-2 text-sm text-slate-500">Barang Bukti</p>
        <p class="text-3xl font-bold text-[#0B1F3A]">{{ $stats['evidences'] }}</p>
    </div>

    <div class="relative overflow-hidden rounded-xl border border-slate-200 bg-[#F8FAFC] p-5 transition hover:-translate-y-0.5 hover:shadow-md">
        <div class="absolute inset-x-0 top-0 h-[3px] bg-emerald-500"></div>
        <p class="mb-2 text-sm text-slate-500">Selesai Bulan Ini</p>
        <p class="text-3xl font-bold text-[#0B1F3A]">{{ $stats['closed_this_month'] }}</p>
    </div>

</div>

{{-- CASES --}}
<div class="mb-6 overflow-hidden rounded-xl border border-slate-200 bg-[#F8FAFC]">

    <div class="flex items-center justify-between gap-4 border-b border-slate-200 px-5 py-5">
        <div>
            <h2 class="text-lg font-bold text-[#0B1F3A]">Kasus Saya</h2>
            <p class="mt-1 text-xs text-slate-400">Kasus aktif yang sedang ditugaskan kepada Anda.</p>
        </div>

        <a href="{{ route('cases.index') }}" class="inline-flex min-h-9 shrink-0 items-center justify-center rounded-lg border border-slate-300 bg-[#F8FAFC] px-4 text-sm font-medium text-slate-700 transition hover:bg-[#EEF3F8]">
            Lihat Semua
        </a>
    </div>

    <div class="overflow-x-auto">

        <table class="w-full border-collapse">

            <thead class="bg-[#EEF3F8]">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Nomor Kasus</th>
                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Judul</th>
                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Status</th>
                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Prioritas</th>
                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-200">

                @forelse ($assignedCases as $case)

                    @php
                        $statusClass = match ($case->status) {
                            'Open' => 'bg-blue-100 text-blue-800',
                            'In Progress' => 'bg-amber-100 text-amber-800',
                            'Closed' => 'bg-emerald-100 text-emerald-800',
                            default => 'bg-slate-100 text-slate-700'
                        };

                        $priorityClass = match ($case->priority) {
                            'High' => 'bg-rose-100 text-rose-800',
                            'Medium' => 'bg-amber-100 text-amber-800',
                            'Low' => 'bg-slate-100 text-slate-700',
                            default => 'bg-slate-100 text-slate-700'
                        };
                    @endphp

                    <tr class="transition hover:bg-[#EEF3F8]">
                        <td class="whitespace-nowrap px-5 py-4 text-sm font-semibold text-[#0B1F3A]">{{ $case->case_number }}</td>
                        <td class="px-5 py-4 text-sm text-slate-700">{{ $case->title }}</td>

                        <td class="px-5 py-4">
                            <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold {{ $statusClass }}">
                                {{ $case->status }}
                            </span>
                        </td>

                        <td class="px-5 py-4">
                            <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold {{ $priorityClass }}">
                                {{ $case->priority }}
                            </span>
                        </td>

                        <td class="px-5 py-4">
                            <a href="{{ route('cases.show', $case->id) }}" class="inline-flex min-h-9 items-center justify-center rounded-lg border border-slate-300 bg-[#F8FAFC] px-3 text-sm font-medium text-slate-700 transition hover:bg-[#EEF3F8]">
                                Detail
                            </a>
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="5" class="px-5 py-10 text-center text-sm text-slate-400">
                            Tidak ada kasus aktif yang ditugaskan kepada Anda.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

{{-- COMPLAINT --}}
<div class="overflow-hidden rounded-xl border border-slate-200 bg-[#F8FAFC]">

    <div class="flex items-center justify-between gap-4 border-b border-slate-200 px-5 py-5">
        <div>
            <h2 class="text-lg font-bold text-[#0B1F3A]">Pengaduan Menunggu Verifikasi</h2>
            <p class="mt-1 text-xs text-slate-400">Pengaduan Pending yang perlu diperiksa sebelum menjadi kasus.</p>
        </div>

        <a href="{{ route('complaint') }}" class="inline-flex min-h-9 shrink-0 items-center justify-center rounded-lg border border-slate-300 bg-[#F8FAFC] px-4 text-sm font-medium text-slate-700 transition hover:bg-[#EEF3F8]">
            Lihat Semua
        </a>
    </div>

    <div class="overflow-x-auto">

        <table class="w-full border-collapse">

            <thead class="bg-[#EEF3F8]">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Pelapor</th>
                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Judul</th>
                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Tanggal</th>
                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Status</th>
                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-200">

                @forelse ($pendingComplaints as $complaint)

                    <tr class="transition hover:bg-[#EEF3F8]">
                        <td class="px-5 py-4 text-sm font-medium text-slate-700">{{ $complaint->user?->name ?? '-' }}</td>
                        <td class="px-5 py-4 text-sm text-slate-700">{{ $complaint->title }}</td>
                        <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-500">{{ $complaint->created_at->format('d M Y') }}</td>

                        <td class="px-5 py-4">
                            <span class="inline-flex rounded-full bg-amber-100 px-3 py-1 text-xs font-bold text-amber-800">
                                {{ $complaint->status }}
                            </span>
                        </td>

                        <td class="px-5 py-4">
                            <a href="{{ route('complaint.show', $complaint->id) }}" class="inline-flex min-h-9 items-center justify-center rounded-lg bg-[#2F80ED] px-3 text-sm font-semibold text-white transition hover:bg-blue-600">
                                Review
                            </a>
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="5" class="px-5 py-10 text-center text-sm text-slate-400">
                            Tidak ada pengaduan yang menunggu verifikasi.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection