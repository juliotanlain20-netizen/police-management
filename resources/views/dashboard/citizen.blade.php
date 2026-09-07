@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="mb-7">
    <h1 class="mb-1 text-3xl font-bold text-[#0B1F3A]">Dashboard</h1>
    <p class="text-sm text-slate-500">Selamat datang, {{ auth()->user()->name }}. Berikut ringkasan pengaduan Anda.</p>
</div>

<div class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5">

    <div class="relative overflow-hidden rounded-xl border border-slate-200 bg-[#F8FAFC] p-5 transition hover:-translate-y-0.5 hover:shadow-md">
        <div class="absolute inset-x-0 top-0 h-[3px] bg-blue-500"></div>
        <p class="mb-2 text-sm text-slate-500">Total Pengaduan</p>
        <p class="text-3xl font-bold text-[#0B1F3A]">{{ $stats['total'] }}</p>
    </div>

    <div class="relative overflow-hidden rounded-xl border border-slate-200 bg-[#F8FAFC] p-5 transition hover:-translate-y-0.5 hover:shadow-md">
        <div class="absolute inset-x-0 top-0 h-[3px] bg-amber-400"></div>
        <p class="mb-2 text-sm text-slate-500">Pending</p>
        <p class="text-3xl font-bold text-[#0B1F3A]">{{ $stats['pending'] }}</p>
    </div>

    <div class="relative overflow-hidden rounded-xl border border-slate-200 bg-[#F8FAFC] p-5 transition hover:-translate-y-0.5 hover:shadow-md">
        <div class="absolute inset-x-0 top-0 h-[3px] bg-sky-400"></div>
        <p class="mb-2 text-sm text-slate-500">Butuh Bukti</p>
        <p class="text-3xl font-bold text-[#0B1F3A]">{{ $stats['need_evidence'] }}</p>
    </div>

    <div class="relative overflow-hidden rounded-xl border border-slate-200 bg-[#F8FAFC] p-5 transition hover:-translate-y-0.5 hover:shadow-md">
        <div class="absolute inset-x-0 top-0 h-[3px] bg-emerald-500"></div>
        <p class="mb-2 text-sm text-slate-500">Approved</p>
        <p class="text-3xl font-bold text-[#0B1F3A]">{{ $stats['approved'] }}</p>
    </div>

    <div class="relative overflow-hidden rounded-xl border border-slate-200 bg-[#F8FAFC] p-5 transition hover:-translate-y-0.5 hover:shadow-md">
        <div class="absolute inset-x-0 top-0 h-[3px] bg-rose-500"></div>
        <p class="mb-2 text-sm text-slate-500">Rejected</p>
        <p class="text-3xl font-bold text-[#0B1F3A]">{{ $stats['rejected'] }}</p>
    </div>

</div>

<div class="overflow-hidden rounded-xl border border-slate-200 bg-[#F8FAFC]">

    <div class="flex flex-col gap-4 border-b border-slate-200 px-5 py-5 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-lg font-bold text-[#0B1F3A]">Pengaduan Terbaru</h2>

        <a href="{{ route('complaint.create') }}" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-lg bg-[#2F80ED] px-4 text-sm font-semibold text-white transition hover:bg-blue-600">

            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>

            Buat Pengaduan
        </a>
    </div>

    <div class="overflow-x-auto">

        <table class="w-full border-collapse">

            <thead class="bg-[#EEF3F8]">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Judul</th>
                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Tanggal</th>
                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Status</th>
                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-200">

                @forelse ($recentComplaints as $complaint)

                    @php
                        $badgeClass = match ($complaint->status) {
                            'Pending' => 'bg-amber-100 text-amber-800',
                            'Approved' => 'bg-emerald-100 text-emerald-800',
                            'Rejected' => 'bg-rose-100 text-rose-800',
                            'Need More Evidence' => 'bg-blue-100 text-blue-800',
                            default => 'bg-slate-100 text-slate-700'
                        };
                    @endphp

                    <tr class="transition hover:bg-[#EEF3F8]">
                        <td class="px-5 py-4 text-sm font-medium text-slate-800">{{ $complaint->title }}</td>
                        <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-500">{{ $complaint->created_at->format('d M Y') }}</td>

                        <td class="px-5 py-4">
                            <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold {{ $badgeClass }}">
                                {{ $complaint->status }}
                            </span>
                        </td>

                        <td class="px-5 py-4">
                            <a href="{{ route('complaint.show', $complaint->id) }}" class="inline-flex min-h-9 items-center justify-center rounded-lg border border-slate-300 bg-[#F8FAFC] px-3 text-sm font-medium text-slate-700 transition hover:bg-[#EEF3F8]">
                                Detail
                            </a>
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="4" class="px-5 py-10 text-center text-sm text-slate-400">
                            Belum ada pengaduan.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection