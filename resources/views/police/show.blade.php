@extends('layouts.app')

@section('title', 'Detail Police Officer')

@section('content')

@php
    $user = auth()->user();
    $isAdmin = $user->roles->contains('name', 'admin');

    $statusClass = $police->status === 'Active'
        ? 'bg-emerald-100 text-emerald-800'
        : 'bg-slate-100 text-slate-700';

    $initial = strtoupper(substr($police->user?->name ?? 'P', 0, 1));
@endphp


{{-- HEADER --}}
<div class="mb-7 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">

    <div>
        <h1 class="mb-1 text-3xl font-bold text-[#0B1F3A]">Detail Police Officer</h1>
        <p class="text-sm text-slate-500">Informasi profil dan data kepolisian officer.</p>
    </div>


    <div class="flex flex-wrap gap-2">

        <a href="{{ route('police.index') }}" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-lg border border-slate-300 bg-[#F8FAFC] px-4 text-sm font-medium text-slate-600 transition hover:bg-[#EEF3F8] hover:text-[#0B1F3A]">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>

            Kembali
        </a>


        @if ($isAdmin)

            <a href="{{ route('police.edit', $police->id) }}" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-lg bg-[#2F80ED] px-4 text-sm font-semibold text-white transition hover:bg-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.862 4.487Z" />
                </svg>

                Edit Police
            </a>

        @endif

    </div>

</div>


{{-- PROFILE SUMMARY --}}
<div class="mb-6 overflow-hidden rounded-xl border border-slate-200 bg-[#F8FAFC]">

    <div class="flex flex-col gap-5 p-5 sm:flex-row sm:items-center">

        {{-- AVATAR --}}
        <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-blue-50 text-2xl font-bold text-[#2F80ED]">
            {{ $initial }}
        </div>


        {{-- PROFILE --}}
        <div class="min-w-0 flex-1">

            <div class="mb-1 flex flex-wrap items-center gap-2">

                <h2 class="truncate text-xl font-bold text-[#0B1F3A]">
                    {{ $police->user?->name ?? '-' }}
                </h2>

                <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold {{ $statusClass }}">
                    {{ $police->status }}
                </span>

            </div>


            <p class="truncate text-sm text-slate-500">
                {{ $police->user?->email ?? '-' }}
            </p>


            <div class="mt-3 flex flex-wrap gap-x-5 gap-y-2 text-xs text-slate-500">

                <span>
                    NRP:
                    <strong class="font-mono text-slate-700">{{ $police->nrp }}</strong>
                </span>

                <span class="inline-flex items-center gap-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 18.75l-2.813-1.012A9.75 9.75 0 1 1 18 6.75c0 1.228-.228 2.404-.644 3.487" />
                    </svg>

                    {{ $police->rank?->name ?? 'Pangkat tidak tersedia' }}
                </span>

                <span class="inline-flex items-center gap-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15v18h-15V3Zm3 4.5h.008v.008H7.5V7.5Zm0 4h.008v.008H7.5V11.5Zm0 4h.008v.008H7.5V15.5Zm4-8h.008v.008H11.5V7.5Zm0 4h.008v.008H11.5V11.5Zm0 4h.008v.008H11.5V15.5Zm4-8h.008v.008H15.5V7.5Zm0 4h.008v.008H15.5V11.5Zm0 4h.008v.008H15.5V15.5Z" />
                    </svg>

                    {{ $police->unit?->name ?? 'Unit tidak tersedia' }}
                </span>

            </div>

        </div>

    </div>

</div>


{{-- DETAIL INFORMATION --}}
<div class="overflow-hidden rounded-xl border border-slate-200 bg-[#F8FAFC]">

    <div class="border-b border-slate-200 px-5 py-5">
        <h2 class="text-lg font-bold text-[#0B1F3A]">Informasi Police Officer</h2>
        <p class="mt-1 text-xs text-slate-400">Data identitas dan penempatan officer.</p>
    </div>


    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">

        {{-- ID --}}
        <div class="border-b border-slate-100 px-5 py-4 sm:border-r">
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400">ID Officer</p>
            <p class="text-sm font-semibold text-slate-700">#{{ $police->id }}</p>
        </div>


        {{-- NRP --}}
        <div class="border-b border-slate-100 px-5 py-4 lg:border-r">
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400">NRP</p>
            <p class="font-mono text-sm font-bold text-[#0B1F3A]">{{ $police->nrp }}</p>
        </div>


        {{-- RANK --}}
        <div class="border-b border-slate-100 px-5 py-4 sm:border-r lg:border-r-0">
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400">Pangkat</p>
            <p class="text-sm font-semibold text-slate-700">{{ $police->rank?->name ?? '-' }}</p>
        </div>


        {{-- UNIT --}}
        <div class="border-b border-slate-100 px-5 py-4 lg:border-r">
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400">Unit</p>
            <p class="text-sm font-semibold text-slate-700">{{ $police->unit?->name ?? '-' }}</p>
        </div>


        {{-- PHONE --}}
        <div class="border-b border-slate-100 px-5 py-4 sm:border-r">
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400">Phone</p>

            <div class="flex items-center gap-2 text-sm font-semibold text-slate-700">

                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372a1.5 1.5 0 0 0-1.025-1.423l-4.423-1.474a1.5 1.5 0 0 0-1.676.527l-1.02 1.36a12.035 12.035 0 0 1-6.724-6.724l1.36-1.02a1.5 1.5 0 0 0 .527-1.676L7.295 3.275A1.5 1.5 0 0 0 5.872 2.25H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                </svg>

                {{ $police->user?->phone ?? '-' }}
            </div>
        </div>


        {{-- EMAIL --}}
        <div class="border-b border-slate-100 px-5 py-4 lg:border-b">
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400">Email</p>

            <div class="flex min-w-0 items-center gap-2 text-sm font-semibold text-slate-700">

                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5A2.25 2.25 0 0 1 19.5 19.5h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0-8.659 5.768a1.875 1.875 0 0 1-2.082 0L2.25 6.75" />
                </svg>

                <span class="truncate">{{ $police->user?->email ?? '-' }}</span>
            </div>
        </div>

    </div>


    {{-- ADDRESS --}}
    <div class="border-t border-slate-100 px-5 py-5">

        <p class="mb-2 text-xs font-semibold uppercase tracking-wide text-slate-400">Alamat</p>

        <div class="flex items-start gap-2 text-sm leading-7 text-slate-600">

            <svg xmlns="http://www.w3.org/2000/svg" class="mt-1 h-4 w-4 shrink-0 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
            </svg>

            <p class="whitespace-pre-line">{{ $police->address ?? '-' }}</p>
        </div>

    </div>

</div>

@endsection