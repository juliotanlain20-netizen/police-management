@extends('layouts.app')

@section('title', 'Edit Kasus')

@section('content')

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


{{-- HEADER --}}
<div class="mb-7 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">

    <div>
        <h1 class="mb-1 text-3xl font-bold text-[#0B1F3A]">Edit Kasus</h1>
        <p class="text-sm text-slate-500">
            Perbarui informasi kasus investigasi
            <span class="font-mono font-semibold text-slate-700">{{ $case->case_number }}</span>.
        </p>
    </div>


    <div class="flex flex-wrap items-center gap-2">

        <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold {{ $statusClass }}">
            {{ $case->status }}
        </span>

        <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold {{ $priorityClass }}">
            {{ $case->priority }}
        </span>

        <a href="{{ route('cases.show', $case->id) }}" class="ml-0 inline-flex min-h-9 items-center justify-center gap-2 rounded-lg border border-slate-300 bg-[#F8FAFC] px-4 text-sm font-medium text-slate-600 transition hover:bg-[#EEF3F8] sm:ml-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>

            Kembali
        </a>

    </div>

</div>


{{-- VALIDATION ERRORS --}}
@if ($errors->any())

    <div class="mb-6 rounded-xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm text-rose-700">

        <p class="mb-2 font-semibold">Periksa kembali data berikut:</p>

        <ul class="list-disc space-y-1 pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>

    </div>

@endif


{{-- CASE INFO --}}
<div class="mb-6 overflow-hidden rounded-xl border border-slate-200 bg-[#F8FAFC]">

    <div class="border-b border-slate-200 px-5 py-5">
        <h2 class="text-lg font-bold text-[#0B1F3A]">Informasi Kasus</h2>
        <p class="mt-1 text-xs text-slate-400">Informasi referensi kasus yang sedang diedit.</p>
    </div>


    <div class="grid grid-cols-1 sm:grid-cols-2">

        <div class="border-b border-slate-100 px-5 py-4 sm:border-b-0 sm:border-r">
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400">Case Number</p>
            <p class="font-mono text-sm font-bold text-[#0B1F3A]">{{ $case->case_number }}</p>
        </div>


        <div class="px-5 py-4">
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400">Opened At</p>
            <p class="text-sm font-semibold text-slate-700">
                {{ $case->opened_at ? \Carbon\Carbon::parse($case->opened_at)->format('d M Y, H:i') : '-' }}
            </p>
        </div>

    </div>

</div>


{{-- EDIT FORM --}}
<div class="overflow-hidden rounded-xl border border-slate-200 bg-[#F8FAFC]">

    <div class="border-b border-slate-200 px-5 py-5">
        <h2 class="text-lg font-bold text-[#0B1F3A]">Edit Data Kasus</h2>
        <p class="mt-1 text-xs text-slate-400">Perbarui informasi utama dan status proses investigasi.</p>
    </div>


    <form action="{{ route('cases.update', $case->id) }}" method="POST" class="p-5">
        @csrf
        @method('PATCH')


        <div class="grid gap-5 md:grid-cols-2">

            {{-- TITLE --}}
            <div class="md:col-span-2">
                <label for="title" class="mb-2 block text-sm font-semibold text-slate-700">Judul Kasus</label>

                <input type="text" name="title" id="title" value="{{ old('title', $case->title) }}" required class="h-11 w-full rounded-lg border border-slate-300 bg-[#F8FAFC] px-3 text-sm text-slate-700 outline-none transition focus:border-[#2F80ED] focus:ring-4 focus:ring-blue-100">
            </div>


            {{-- DESCRIPTION --}}
            <div class="md:col-span-2">
                <label for="description" class="mb-2 block text-sm font-semibold text-slate-700">Deskripsi</label>

                <textarea name="description" id="description" rows="6" required class="w-full resize-y rounded-lg border border-slate-300 bg-[#F8FAFC] px-3 py-3 text-sm leading-6 text-slate-700 outline-none transition focus:border-[#2F80ED] focus:ring-4 focus:ring-blue-100">{{ old('description', $case->description) }}</textarea>
            </div>


            {{-- STATUS --}}
            <div>
                <label for="status" class="mb-2 block text-sm font-semibold text-slate-700">Status Kasus</label>

                <select name="status" id="status" required class="h-11 w-full rounded-lg border border-slate-300 bg-[#F8FAFC] px-3 text-sm text-slate-700 outline-none transition focus:border-[#2F80ED] focus:ring-4 focus:ring-blue-100">

                    <option value="Open" @selected(old('status', $case->status) === 'Open')>Open</option>
                    <option value="In Progress" @selected(old('status', $case->status) === 'In Progress')>In Progress</option>
                    <option value="Closed" @selected(old('status', $case->status) === 'Closed')>Closed</option>

                </select>

                <p class="mt-2 text-xs text-slate-400">Status menunjukkan tahap penanganan kasus saat ini.</p>
            </div>


            {{-- PRIORITY --}}
            <div>
                <label for="priority" class="mb-2 block text-sm font-semibold text-slate-700">Priority</label>

                <select name="priority" id="priority" required class="h-11 w-full rounded-lg border border-slate-300 bg-[#F8FAFC] px-3 text-sm text-slate-700 outline-none transition focus:border-[#2F80ED] focus:ring-4 focus:ring-blue-100">

                    <option value="Low" @selected(old('priority', $case->priority) === 'Low')>Low</option>
                    <option value="Medium" @selected(old('priority', $case->priority) === 'Medium')>Medium</option>
                    <option value="High" @selected(old('priority', $case->priority) === 'High')>High</option>

                </select>

                <p class="mt-2 text-xs text-slate-400">Priority menentukan tingkat urgensi penanganan kasus.</p>
            </div>

        </div>


        {{-- CLOSED INFORMATION --}}
        @if ($case->status === 'Closed')

            <div class="mt-5 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-4">

                <div class="flex items-start gap-3">

                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-emerald-100 text-emerald-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-[18px] w-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                        </svg>
                    </div>

                    <div>
                        <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-emerald-600">Closed At</p>

                        <p class="text-sm font-semibold text-emerald-800">
                            {{ $case->closed_at ? \Carbon\Carbon::parse($case->closed_at)->format('d M Y, H:i') : '-' }}
                        </p>
                    </div>

                </div>

            </div>

        @endif


        {{-- ACTION --}}
        <div class="mt-6 flex flex-wrap items-center gap-3 border-t border-slate-200 pt-5">

            <button type="submit" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-lg bg-[#2F80ED] px-4 text-sm font-semibold text-white transition hover:bg-blue-600">

                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.75H6.75A2.25 2.25 0 0 0 4.5 6v12a2.25 2.25 0 0 0 2.25 2.25h10.5A2.25 2.25 0 0 0 19.5 18V6.75L16.5 3.75ZM8.25 3.75v5.25h7.5V3.75M8.25 15h7.5" />
                </svg>

                Simpan Perubahan
            </button>


            <a href="{{ route('cases.show', $case->id) }}" class="inline-flex min-h-10 items-center justify-center rounded-lg border border-slate-300 bg-[#F8FAFC] px-4 text-sm font-medium text-slate-600 transition hover:bg-[#EEF3F8]">
                Batal
            </a>

        </div>

    </form>

</div>

@endsection