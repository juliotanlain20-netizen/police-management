@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')

<div class="mb-7">
    <h1 class="mb-1 text-3xl font-bold text-[#0B1F3A]">Dashboard Admin</h1>
    <p class="text-sm text-slate-500">Selamat datang, {{ auth()->user()->name }}. Berikut ringkasan sistem TRAKSA.</p>
</div>

{{-- STATISTICS --}}
<div class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5">

    <div class="relative overflow-hidden rounded-xl border border-slate-200 bg-[#F8FAFC] p-5 transition hover:-translate-y-0.5 hover:shadow-md">
        <div class="absolute inset-x-0 top-0 h-[3px] bg-indigo-500"></div>
        <p class="mb-2 text-sm text-slate-500">Total User</p>
        <p class="text-3xl font-bold text-[#0B1F3A]">{{ $stats['users'] }}</p>
    </div>

    <div class="relative overflow-hidden rounded-xl border border-slate-200 bg-[#F8FAFC] p-5 transition hover:-translate-y-0.5 hover:shadow-md">
        <div class="absolute inset-x-0 top-0 h-[3px] bg-emerald-500"></div>
        <p class="mb-2 text-sm text-slate-500">Police Aktif</p>
        <p class="text-3xl font-bold text-[#0B1F3A]">{{ $stats['active_police'] }}</p>
    </div>

    <div class="relative overflow-hidden rounded-xl border border-slate-200 bg-[#F8FAFC] p-5 transition hover:-translate-y-0.5 hover:shadow-md">
        <div class="absolute inset-x-0 top-0 h-[3px] bg-amber-400"></div>
        <p class="mb-2 text-sm text-slate-500">Pengaduan Pending</p>
        <p class="text-3xl font-bold text-[#0B1F3A]">{{ $stats['pending_complaints'] }}</p>
    </div>

    <div class="relative overflow-hidden rounded-xl border border-slate-200 bg-[#F8FAFC] p-5 transition hover:-translate-y-0.5 hover:shadow-md">
        <div class="absolute inset-x-0 top-0 h-[3px] bg-blue-500"></div>
        <p class="mb-2 text-sm text-slate-500">Kasus Aktif</p>
        <p class="text-3xl font-bold text-[#0B1F3A]">{{ $stats['active_cases'] }}</p>
    </div>

    <div class="relative overflow-hidden rounded-xl border border-slate-200 bg-[#F8FAFC] p-5 transition hover:-translate-y-0.5 hover:shadow-md">
        <div class="absolute inset-x-0 top-0 h-[3px] bg-violet-500"></div>
        <p class="mb-2 text-sm text-slate-500">Barang Bukti</p>
        <p class="text-3xl font-bold text-[#0B1F3A]">{{ $stats['evidences'] }}</p>
    </div>

</div>

{{-- RECENT CASES --}}
<div class="mb-6 overflow-hidden rounded-xl border border-slate-200 bg-[#F8FAFC]">

    <div class="flex items-center justify-between gap-4 border-b border-slate-200 px-5 py-5">
        <h2 class="text-lg font-bold text-[#0B1F3A]">Kasus Terbaru</h2>

        <a href="{{ route('cases.index') }}" class="inline-flex min-h-9 items-center justify-center rounded-lg border border-slate-300 bg-[#F8FAFC] px-4 text-sm font-medium text-slate-700 transition hover:bg-[#EEF3F8]">
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

                @forelse ($recentCases as $case)

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
                            Belum ada kasus.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>
    </div>

</div>

{{-- PENDING COMPLAINTS --}}
<div class="mb-6 overflow-hidden rounded-xl border border-slate-200 bg-[#F8FAFC]">

    <div class="flex items-center justify-between gap-4 border-b border-slate-200 px-5 py-5">
        <div>
            <h2 class="text-lg font-bold text-[#0B1F3A]">Pengaduan Menunggu Verifikasi</h2>
            <p class="mt-1 text-xs text-slate-400">Pengaduan berstatus Pending yang membutuhkan pemeriksaan.</p>
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
                            Tidak ada pengaduan Pending.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>
    </div>

</div>

{{-- ADMINISTRATION --}}
<div class="overflow-hidden rounded-xl border border-slate-200 bg-[#F8FAFC]">

    <div class="border-b border-slate-200 px-5 py-5">
        <h2 class="text-lg font-bold text-[#0B1F3A]">Administrasi</h2>
        <p class="mt-1 text-xs text-slate-400">Kelola penyidik, role pengguna, dan hak akses sistem.</p>
    </div>

    <div class="grid gap-4 p-5 sm:grid-cols-2 lg:grid-cols-3">

        <a href="{{ route('police.index') }}" class="group flex items-center gap-4 rounded-xl border border-slate-200 p-4 transition hover:border-blue-200 hover:bg-blue-50/50">
            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-blue-100 text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.25a7.5 7.5 0 0 1 15 0" />
                </svg>
            </div>

            <div>
                <h3 class="text-sm font-bold text-[#0B1F3A]">Kelola Police</h3>
                <p class="mt-1 text-xs text-slate-400">Kelola data dan status penyidik.</p>
            </div>
        </a>

        <a href="{{ route('user-role.index') }}" class="group flex items-center gap-4 rounded-xl border border-slate-200 p-4 transition hover:border-blue-200 hover:bg-blue-50/50">
            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-indigo-100 text-indigo-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766v-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.75a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                </svg>
            </div>

            <div>
                <h3 class="text-sm font-bold text-[#0B1F3A]">User & Role</h3>
                <p class="mt-1 text-xs text-slate-400">Atur role untuk setiap pengguna.</p>
            </div>
        </a>

        <a href="{{ route('role-permission.index') }}" class="group flex items-center gap-4 rounded-xl border border-slate-200 p-4 transition hover:border-blue-200 hover:bg-blue-50/50">
            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-violet-100 text-violet-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M12 3 4.5 6v5.25c0 4.35 2.79 8.25 7.5 9.75 4.71-1.5 7.5-5.4 7.5-9.75V6L12 3Z" />
                </svg>
            </div>

            <div>
                <h3 class="text-sm font-bold text-[#0B1F3A]">Role Permissions</h3>
                <p class="mt-1 text-xs text-slate-400">Atur hak akses setiap role.</p>
            </div>
        </a>

    </div>

</div>

@endsection