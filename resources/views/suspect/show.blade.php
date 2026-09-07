@extends('layouts.app')

@section('title', 'Detail Suspect')

@section('content')

@php
    $user = auth()->user();
    $case = $suspect->case;

    $isAdmin = $user->roles->contains('name', 'admin');
    $officerId = $user->officer?->id;

    $isAssigned = false;

    if ($officerId && $case) {
        $isAssigned = $case->officers->contains(function ($officer) use ($officerId) {
            return $officer->id === $officerId
                && $officer->pivot->status === 'Active';
        });
    }

    $canEdit =
        $user->hasPermission('suspect.update')
        && ($isAdmin || $isAssigned);

    $caseStatusClass = match ($case?->status) {
        'Open' => 'bg-blue-100 text-blue-800',
        'In Progress' => 'bg-amber-100 text-amber-800',
        'Closed' => 'bg-emerald-100 text-emerald-800',
        default => 'bg-slate-100 text-slate-700'
    };

    $suspectStatusClass = match ($suspect->status) {
        'identified' => 'bg-blue-100 text-blue-800',
        'wanted' => 'bg-amber-100 text-amber-800',
        'detained' => 'bg-rose-100 text-rose-800',
        'released' => 'bg-emerald-100 text-emerald-800',
        default => 'bg-slate-100 text-slate-700'
    };

    $priorityClass = match ($case?->priority) {
        'High' => 'bg-rose-100 text-rose-800',
        'Medium' => 'bg-amber-100 text-amber-800',
        'Low' => 'bg-slate-100 text-slate-700',
        default => 'bg-slate-100 text-slate-700'
    };
@endphp


{{-- HEADER --}}
<div class="mb-7 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">

    <div>
        <h1 class="mb-1 text-3xl font-bold text-[#0B1F3A]">Detail Suspect</h1>
        <p class="text-sm text-slate-500">Informasi lengkap suspect pada kasus investigasi.</p>
    </div>


    <div class="flex flex-wrap gap-2">

        @if ($case)

            <a href="{{ route('cases.show', $case->id) }}" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-lg border border-slate-300 bg-[#F8FAFC] px-4 text-sm font-medium text-slate-600 transition hover:bg-[#EEF3F8] hover:text-[#0B1F3A]">

                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>

                Kembali ke Case
            </a>

        @endif


        @if ($canEdit)

            <a href="{{ route('suspect.edit', $suspect->id) }}" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-lg bg-[#2F80ED] px-4 text-sm font-semibold text-white transition hover:bg-blue-600">

                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.862 4.487Z" />
                </svg>

                Edit Suspect
            </a>

        @endif

    </div>

</div>


{{-- SUSPECT INFORMATION --}}
<div class="mb-6 overflow-hidden rounded-xl border border-slate-200 bg-[#F8FAFC]">

    <div class="flex flex-col gap-3 border-b border-slate-200 px-5 py-5 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h2 class="text-lg font-bold text-[#0B1F3A]">Informasi Suspect</h2>
            <p class="mt-1 text-xs text-slate-400">Data identitas dan status suspect.</p>
        </div>

        <span class="inline-flex self-start rounded-full px-3 py-1 text-xs font-bold {{ $suspectStatusClass }}">
            {{ ucfirst($suspect->status) }}
        </span>

    </div>


    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">

        {{-- NAME --}}
        <div class="border-b border-slate-100 px-5 py-4 sm:border-r lg:border-b-0">
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400">Name</p>
            <p class="text-sm font-semibold text-slate-700">{{ $suspect->name }}</p>
        </div>


        {{-- IDENTITY NUMBER --}}
        <div class="border-b border-slate-100 px-5 py-4 lg:border-r lg:border-b-0">
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400">Identity Number</p>
            <p class="font-mono text-sm font-semibold text-slate-700">{{ $suspect->identity_number ?? '-' }}</p>
        </div>


        {{-- STATUS --}}
        <div class="px-5 py-4">
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400">Status</p>
            <p class="text-sm font-semibold text-slate-700">{{ ucfirst($suspect->status) }}</p>
        </div>

    </div>


    {{-- ADDRESS --}}
    <div class="border-t border-slate-100 px-5 py-5">

        <p class="mb-2 text-xs font-semibold uppercase tracking-wide text-slate-400">Address</p>

        <div class="flex items-start gap-2 text-sm leading-7 text-slate-600">

            <svg xmlns="http://www.w3.org/2000/svg" class="mt-1 h-4 w-4 shrink-0 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
            </svg>

            <p class="whitespace-pre-line">{{ $suspect->address ?? '-' }}</p>

        </div>

    </div>


    {{-- NOTES --}}
    <div class="border-t border-slate-100 px-5 py-5">

        <p class="mb-2 text-xs font-semibold uppercase tracking-wide text-slate-400">Notes</p>

        <p class="whitespace-pre-line text-sm leading-7 text-slate-600">
            {{ $suspect->notes ?? '-' }}
        </p>

    </div>

</div>


{{-- INVESTIGATION CASE --}}
<div class="overflow-hidden rounded-xl border border-slate-200 bg-[#F8FAFC]">

    <div class="flex flex-col gap-3 border-b border-slate-200 px-5 py-5 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h2 class="text-lg font-bold text-[#0B1F3A]">Investigation Case</h2>
            <p class="mt-1 text-xs text-slate-400">Kasus investigasi yang terhubung dengan suspect.</p>
        </div>


        @if ($case)

            <span class="inline-flex self-start rounded-full px-3 py-1 text-xs font-bold {{ $caseStatusClass }}">
                {{ $case->status }}
            </span>

        @endif

    </div>


    @if ($case)

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4">

            {{-- CASE NUMBER --}}
            <div class="border-b border-slate-100 px-5 py-4 sm:border-r lg:border-b-0">
                <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400">Case Number</p>
                <p class="font-mono text-sm font-bold text-[#0B1F3A]">{{ $case->case_number }}</p>
            </div>


            {{-- CASE TITLE --}}
            <div class="border-b border-slate-100 px-5 py-4 lg:border-r lg:border-b-0">
                <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400">Case Title</p>
                <p class="text-sm font-semibold text-slate-700">{{ $case->title }}</p>
            </div>


            {{-- CASE STATUS --}}
            <div class="border-b border-slate-100 px-5 py-4 sm:border-r sm:border-b-0">
                <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400">Case Status</p>

                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-bold {{ $caseStatusClass }}">
                    {{ $case->status }}
                </span>
            </div>


            {{-- PRIORITY --}}
            <div class="px-5 py-4">
                <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400">Priority</p>

                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-bold {{ $priorityClass }}">
                    {{ $case->priority }}
                </span>
            </div>

        </div>


        <div class="border-t border-slate-100 px-5 py-4">

            <a href="{{ route('cases.show', $case->id) }}" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-lg border border-slate-300 bg-[#F8FAFC] px-4 text-sm font-medium text-slate-600 transition hover:bg-[#EEF3F8] hover:text-[#0B1F3A]">

                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.644C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.575 3.007 9.963 7.178.07.207.07.431 0 .638C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.575-3.007-9.963-7.178Z" />
                </svg>

                Lihat Detail Case
            </a>

        </div>

    @else

        <div class="px-5 py-12 text-center">

            <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-slate-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </div>

            <p class="text-sm font-semibold text-slate-600">Investigation case tidak tersedia.</p>

        </div>

    @endif

</div>

@endsection