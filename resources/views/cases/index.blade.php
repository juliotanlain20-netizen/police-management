@extends('layouts.app')

@section('title', 'Kasus Investigasi')

@section('content')

<div class="mb-7">
    <h1 class="mb-1 text-3xl font-bold text-[#0B1F3A]">Kasus Investigasi</h1>
    <p class="text-sm text-slate-500">Daftar kasus yang telah dibuat dari pengaduan masyarakat.</p>
</div>


<div class="overflow-hidden rounded-xl border border-slate-200 bg-[#F8FAFC]">

    {{-- HEADER --}}
    <div class="border-b border-slate-200 px-5 py-5">
        <h2 class="text-lg font-bold text-[#0B1F3A]">Daftar Kasus</h2>
        <p class="mt-1 text-xs text-slate-400">Cari dan filter kasus investigasi yang tercatat dalam sistem.</p>
    </div>


    {{-- SEARCH & FILTER --}}
    <div class="border-b border-slate-200 bg-[#EEF3F8]/60 px-5 py-4">

        <form action="{{ route('cases.index') }}" method="GET" class="flex flex-col gap-3 lg:flex-row lg:items-center">

            {{-- SEARCH --}}
            <div class="relative flex-1">

                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-[18px] w-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m1.35-5.4a6.75 6.75 0 1 1-13.5 0 6.75 6.75 0 0 1 13.5 0Z" />
                    </svg>
                </span>

                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nomor kasus, judul, atau deskripsi..." class="h-10 w-full rounded-lg border border-slate-300 bg-[#F8FAFC] pl-10 pr-4 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-[#2F80ED] focus:ring-4 focus:ring-blue-100">
            </div>


            {{-- STATUS --}}
            <div class="relative lg:w-[190px]">

                <select name="status" class="h-10 w-full cursor-pointer appearance-none rounded-lg border border-slate-300 bg-[#F8FAFC] px-3 pr-9 text-sm text-slate-700 outline-none transition focus:border-[#2F80ED] focus:ring-4 focus:ring-blue-100">
                    <option value="">Semua Status</option>
                    <option value="Open" @selected(request('status') === 'Open')>Open</option>
                    <option value="In Progress" @selected(request('status') === 'In Progress')>In Progress</option>
                    <option value="Closed" @selected(request('status') === 'Closed')>Closed</option>
                </select>

                <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 9-7.5 7.5L4.5 9" />
                    </svg>
                </span>

            </div>


            {{-- PRIORITY --}}
            <div class="relative lg:w-[190px]">

                <select name="priority" class="h-10 w-full cursor-pointer appearance-none rounded-lg border border-slate-300 bg-[#F8FAFC] px-3 pr-9 text-sm text-slate-700 outline-none transition focus:border-[#2F80ED] focus:ring-4 focus:ring-blue-100">
                    <option value="">Semua Prioritas</option>
                    <option value="High" @selected(request('priority') === 'High')>High</option>
                    <option value="Medium" @selected(request('priority') === 'Medium')>Medium</option>
                    <option value="Low" @selected(request('priority') === 'Low')>Low</option>
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
            @if (request()->filled('q') || request()->filled('status') || request()->filled('priority'))

                <a href="{{ route('cases.index') }}" class="inline-flex h-10 items-center justify-center rounded-lg border border-slate-300 bg-[#F8FAFC] px-4 text-sm font-medium text-slate-600 transition hover:bg-slate-100">
                    Reset
                </a>

            @endif

        </form>

    </div>


    {{-- FILTER RESULT --}}
    @if (request()->filled('q') || request()->filled('status') || request()->filled('priority'))

        <div class="border-b border-slate-200 px-5 py-3 text-xs text-slate-500">

            Ditemukan
            <strong class="text-slate-700">{{ $cases->count() }}</strong>
            kasus

            @if (request()->filled('q'))
                untuk pencarian
                <strong class="text-slate-700">"{{ request('q') }}"</strong>
            @endif

            @if (request()->filled('status'))
                dengan status
                <strong class="text-slate-700">{{ request('status') }}</strong>
            @endif

            @if (request()->filled('priority'))
                dan prioritas
                <strong class="text-slate-700">{{ request('priority') }}</strong>
            @endif

        </div>

    @endif


    {{-- TABLE --}}
    <div class="overflow-x-auto">

        <table class="w-full border-collapse">

            <thead class="bg-[#EEF3F8]">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Nomor Kasus</th>
                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Judul</th>
                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Status</th>
                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Prioritas</th>
                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Dibuka</th>
                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Aksi</th>
                </tr>
            </thead>


            <tbody class="divide-y divide-slate-200">

                @forelse ($cases as $case)

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

                        <td class="whitespace-nowrap px-5 py-4">
                            <span class="font-mono text-sm font-bold text-[#0B1F3A]">
                                {{ $case->case_number }}
                            </span>
                        </td>


                        <td class="px-5 py-4">
                            <p class="max-w-[380px] truncate text-sm font-semibold text-slate-700">
                                {{ $case->title }}
                            </p>
                        </td>


                        <td class="px-5 py-4">
                            <span class="inline-flex whitespace-nowrap rounded-full px-3 py-1 text-xs font-bold {{ $statusClass }}">
                                {{ $case->status }}
                            </span>
                        </td>


                        <td class="px-5 py-4">
                            <span class="inline-flex whitespace-nowrap rounded-full px-3 py-1 text-xs font-bold {{ $priorityClass }}">
                                {{ $case->priority }}
                            </span>
                        </td>


                        <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-500">
                            {{ $case->opened_at
                                ? \Carbon\Carbon::parse($case->opened_at)->format('d M Y')
                                : '-' }}
                        </td>


                        <td class="px-5 py-4">

                            <a href="{{ route('cases.show', $case->id) }}" class="inline-flex min-h-9 items-center justify-center gap-2 rounded-lg border border-slate-300 bg-[#F8FAFC] px-3 text-sm font-medium text-slate-600 transition hover:bg-[#EEF3F8] hover:text-[#0B1F3A]">

                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12 18 18.75 12 18.75 2.25 12 2.25 12Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>

                                Detail
                            </a>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="6" class="px-5 py-12 text-center">

                            <div class="mx-auto flex max-w-sm flex-col items-center">

                                <div class="mb-3 flex h-11 w-11 items-center justify-center rounded-full bg-slate-100 text-slate-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6.75V4.875A1.875 1.875 0 0 0 14.625 3h-5.25A1.875 1.875 0 0 0 7.5 4.875V6.75m-3 0h15A1.5 1.5 0 0 1 21 8.25v10.5a1.5 1.5 0 0 1-1.5 1.5h-15A1.5 1.5 0 0 1 3 18.75V8.25a1.5 1.5 0 0 1 1.5-1.5Z" />
                                    </svg>
                                </div>


                                @if (request()->filled('q') || request()->filled('status') || request()->filled('priority'))

                                    <p class="text-sm font-semibold text-slate-600">
                                        Tidak ada kasus yang ditemukan.
                                    </p>

                                    <p class="mt-1 text-xs text-slate-400">
                                        Coba ubah kata pencarian atau filter yang digunakan.
                                    </p>

                                @else

                                    <p class="text-sm font-semibold text-slate-600">
                                        Belum ada kasus investigasi.
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