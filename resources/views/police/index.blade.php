@extends('layouts.app')

@section('title', 'Police Officers')

@section('content')

@php
    $user = auth()->user();
    $isAdmin = $user->roles->contains('name', 'admin');
@endphp


{{-- HEADER --}}
<div class="mb-7 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">

    <div>
        <h1 class="mb-1 text-3xl font-bold text-[#0B1F3A]">
            {{ $isAdmin ? 'Kelola Police' : 'Daftar Penyidik' }}
        </h1>

        <p class="text-sm text-slate-500">
            @if ($isAdmin)
                Kelola data Police Officer yang terdaftar dalam sistem.
            @else
                Daftar Police Officer dan unit penyidik.
            @endif
        </p>
    </div>


    @if ($isAdmin)

        <a href="{{ route('police.create') }}" class="inline-flex min-h-10 items-center justify-center gap-2 self-start rounded-lg bg-[#2F80ED] px-4 text-sm font-semibold text-white transition hover:bg-blue-600">

            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>

            Tambah Police
        </a>

    @endif

</div>


{{-- POLICE LIST --}}
<div class="overflow-hidden rounded-xl border border-slate-200 bg-[#F8FAFC]">

    {{-- CARD HEADER --}}
    <div class="border-b border-slate-200 px-5 py-5">
        <h2 class="text-lg font-bold text-[#0B1F3A]">Police Officers</h2>
        <p class="mt-1 text-xs text-slate-400">Data officer yang tercatat dalam sistem.</p>
    </div>

{{-- SEARCH --}}
<div class="border-b border-slate-200 bg-[#EEF3F8]/60 px-5 py-4">

    <form action="{{ route('police.index') }}" method="GET" class="flex flex-col gap-3 sm:flex-row sm:items-center">

        <div class="relative flex-1">

            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-[18px] w-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m1.35-5.4a6.75 6.75 0 1 1-13.5 0 6.75 6.75 0 0 1 13.5 0Z" />
                </svg>
            </span>

            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama, email, NRP, pangkat, atau unit..." class="h-10 w-full rounded-lg border border-slate-300 bg-[#F8FAFC] pl-10 pr-4 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-[#2F80ED] focus:ring-4 focus:ring-blue-100">

        </div>


        <button type="submit" class="inline-flex h-10 items-center justify-center gap-2 rounded-lg bg-[#0B1F3A] px-4 text-sm font-semibold text-white transition hover:bg-[#12396b]">

            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m1.35-5.4a6.75 6.75 0 1 1-13.5 0 6.75 6.75 0 0 1 13.5 0Z" />
            </svg>

            Cari
        </button>


        @if (request()->filled('q'))

            <a href="{{ route('police.index') }}" class="inline-flex h-10 items-center justify-center rounded-lg border border-slate-300 bg-[#F8FAFC] px-4 text-sm font-medium text-slate-600 transition hover:bg-slate-100">
                Reset
            </a>

        @endif

    </form>

</div>
    {{-- TABLE --}}
    <div class="overflow-x-auto">

        <table class="w-full border-collapse">

            <thead class="bg-[#EEF3F8]">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">No</th>
                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Nama</th>
                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">NRP</th>
                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Pangkat</th>
                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Unit</th>
                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Phone</th>
                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Status</th>
                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Action</th>
                </tr>
            </thead>


            <tbody class="divide-y divide-slate-200">

                @forelse ($police as $officer)

                    <tr class="transition hover:bg-[#EEF3F8]">

                        {{-- NO --}}
                        <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-500">
                            {{ $loop->iteration }}
                        </td>


                        {{-- NAME --}}
                        <td class="px-5 py-4">

                            <div class="min-w-[180px]">

                                <p class="text-sm font-semibold text-slate-700">
                                    {{ $officer->user?->name ?? '-' }}
                                </p>

                                <p class="mt-1 text-xs text-slate-400">
                                    {{ $officer->user?->email ?? '-' }}
                                </p>

                            </div>

                        </td>


                        {{-- NRP --}}
                        <td class="whitespace-nowrap px-5 py-4">
                            <span class="font-mono text-sm font-semibold text-[#0B1F3A]">
                                {{ $officer->nrp }}
                            </span>
                        </td>


                        {{-- RANK --}}
                        <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-600">
                            {{ $officer->rank?->name ?? '-' }}
                        </td>


                        {{-- UNIT --}}
                        <td class="px-5 py-4 text-sm text-slate-600">
                            {{ $officer->unit?->name ?? '-' }}
                        </td>


                        {{-- PHONE --}}
                        <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-500">
                            {{ $officer->user?->phone ?? '-' }}
                        </td>


                        {{-- STATUS --}}
                        <td class="px-5 py-4">

                            <span class="inline-flex whitespace-nowrap rounded-full px-3 py-1 text-xs font-bold {{ $officer->status === 'Active' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-700' }}">
                                {{ $officer->status }}
                            </span>

                        </td>


                        {{-- ACTION --}}
                        <td class="px-5 py-4">

                            <div class="flex flex-wrap gap-2">

                                <a href="{{ route('police.show', $officer->id) }}" class="inline-flex min-h-9 items-center justify-center gap-2 rounded-lg border border-slate-300 bg-[#F8FAFC] px-3 text-sm font-medium text-slate-600 transition hover:bg-[#EEF3F8] hover:text-[#0B1F3A]">

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12 18 18.75 12 18.75 2.25 12 2.25 12Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>

                                    Detail
                                </a>


                                @if ($isAdmin)

                                    <a href="{{ route('police.edit', $officer->id) }}" class="inline-flex min-h-9 items-center justify-center gap-2 rounded-lg bg-[#2F80ED] px-3 text-sm font-semibold text-white transition hover:bg-blue-600">

                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.862 4.487Z" />
                                        </svg>

                                        Edit
                                    </a>

                                @endif

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="8" class="px-5 py-12 text-center">

                            <div class="mx-auto flex max-w-sm flex-col items-center">

                                <div class="mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-slate-400">

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.1a7.5 7.5 0 0 1 15 0A17.9 17.9 0 0 1 12 21.75 17.9 17.9 0 0 1 4.5 20.1Z" />
                                    </svg>

                                </div>

                                <p class="text-sm font-semibold text-slate-600">Belum ada Police Officer.</p>
                                <p class="mt-1 text-xs text-slate-400">Data Police Officer belum tersedia.</p>


                                @if ($isAdmin)

                                    <a href="{{ route('police.create') }}" class="mt-4 inline-flex min-h-10 items-center justify-center gap-2 rounded-lg bg-[#2F80ED] px-4 text-sm font-semibold text-white transition hover:bg-blue-600">
                                        + Tambah Police
                                    </a>

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