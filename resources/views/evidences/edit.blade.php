@extends('layouts.app')

@section('title', 'Edit Evidence')

@section('content')

@php
    $statusClass = match ($evidence->status) {
        'Stored' => 'bg-blue-100 text-blue-800',
        'Borrowed' => 'bg-amber-100 text-amber-800',
        'Returned' => 'bg-emerald-100 text-emerald-800',
        'Destroyed' => 'bg-rose-100 text-rose-800',
        default => 'bg-slate-100 text-slate-700'
    };

    $recordClass = match ($evidence->record_status) {
        'Valid' => 'bg-emerald-100 text-emerald-800',
        'Voided' => 'bg-rose-100 text-rose-800',
        default => 'bg-slate-100 text-slate-700'
    };
@endphp


{{-- HEADER --}}
<div class="mb-7 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">

    <div>
        <h1 class="mb-1 text-3xl font-bold text-[#0B1F3A]">Edit Evidence</h1>
        <p class="text-sm text-slate-500">
            Perbarui informasi barang bukti
            <span class="font-mono font-semibold text-slate-700">{{ $evidence->evidence_code }}</span>.
        </p>
    </div>


    <div class="flex flex-wrap items-center gap-2">

        <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold {{ $statusClass }}">
            {{ $evidence->status }}
        </span>

        <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold {{ $recordClass }}">
            {{ $evidence->record_status }}
        </span>

        <a href="{{ route('evidence.show', $evidence->id) }}" class="ml-0 inline-flex min-h-9 items-center justify-center gap-2 rounded-lg border border-slate-300 bg-[#F8FAFC] px-4 text-sm font-medium text-slate-600 transition hover:bg-[#EEF3F8] sm:ml-2">
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


{{-- EVIDENCE INFO --}}
<div class="mb-6 overflow-hidden rounded-xl border border-slate-200 bg-[#F8FAFC]">

    <div class="border-b border-slate-200 px-5 py-5">
        <h2 class="text-lg font-bold text-[#0B1F3A]">Informasi Evidence</h2>
        <p class="mt-1 text-xs text-slate-400">Informasi referensi evidence yang sedang diedit.</p>
    </div>


    <div class="grid grid-cols-1 sm:grid-cols-2">

        <div class="border-b border-slate-100 px-5 py-4 sm:border-b-0 sm:border-r">
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400">Investigation Case</p>

            @if ($evidence->investigationCase)

                <a href="{{ route('cases.show', $evidence->investigationCase->id) }}" class="inline-flex items-center gap-1.5 text-sm font-bold text-[#2F80ED] transition hover:text-blue-700 hover:underline">
                    {{ $evidence->investigationCase->case_number }}

                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                    </svg>
                </a>

            @else

                <p class="text-sm font-semibold text-slate-700">-</p>

            @endif
        </div>


        <div class="px-5 py-4">
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400">Record Status</p>

            <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold {{ $recordClass }}">
                {{ $evidence->record_status }}
            </span>
        </div>

    </div>

</div>


{{-- EDIT FORM --}}
<div class="overflow-hidden rounded-xl border border-slate-200 bg-[#F8FAFC]">

    <div class="border-b border-slate-200 px-5 py-5">
        <h2 class="text-lg font-bold text-[#0B1F3A]">Edit Data Evidence</h2>
        <p class="mt-1 text-xs text-slate-400">Perbarui data barang bukti yang tersimpan dalam sistem.</p>
    </div>


    <form action="{{ route('evidence.update', $evidence->id) }}" method="POST" class="p-5">
        @csrf
        @method('PATCH')


        <div class="grid gap-5 md:grid-cols-2">

            {{-- EVIDENCE CODE --}}
            <div>
                <label for="evidence_code" class="mb-2 block text-sm font-semibold text-slate-700">Evidence Code</label>

                <input type="text" name="evidence_code" id="evidence_code" value="{{ old('evidence_code', $evidence->evidence_code) }}" required class="h-11 w-full rounded-lg border border-slate-300 bg-[#F8FAFC] px-3 font-mono text-sm text-slate-700 outline-none transition focus:border-[#2F80ED] focus:ring-4 focus:ring-blue-100">
            </div>


            {{-- CATEGORY --}}
            <div>
                <label for="evidence_category_id" class="mb-2 block text-sm font-semibold text-slate-700">Category</label>

                <select name="evidence_category_id" id="evidence_category_id" required class="h-11 w-full rounded-lg border border-slate-300 bg-[#F8FAFC] px-3 text-sm text-slate-700 outline-none transition focus:border-[#2F80ED] focus:ring-4 focus:ring-blue-100">

                    @foreach ($categories as $category)

                        <option value="{{ $category->id }}" @selected(old('evidence_category_id', $evidence->evidence_category_id) == $category->id)>
                            {{ $category->name }}
                        </option>

                    @endforeach

                </select>
            </div>


            {{-- NAME --}}
            <div>
                <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">Name</label>

                <input type="text" name="name" id="name" value="{{ old('name', $evidence->name) }}" required class="h-11 w-full rounded-lg border border-slate-300 bg-[#F8FAFC] px-3 text-sm text-slate-700 outline-none transition focus:border-[#2F80ED] focus:ring-4 focus:ring-blue-100">
            </div>


            {{-- STORAGE LOCATION --}}
            <div>
                <label for="storage_location" class="mb-2 block text-sm font-semibold text-slate-700">Storage Location</label>

                <div class="relative">

                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-[18px] w-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                        </svg>
                    </span>

                    <input type="text" name="storage_location" id="storage_location" value="{{ old('storage_location', $evidence->storage_location) }}" required class="h-11 w-full rounded-lg border border-slate-300 bg-[#F8FAFC] pl-10 pr-3 text-sm text-slate-700 outline-none transition focus:border-[#2F80ED] focus:ring-4 focus:ring-blue-100">

                </div>
            </div>


            {{-- STATUS --}}
            <div class="md:col-span-2">
                <label for="status" class="mb-2 block text-sm font-semibold text-slate-700">Physical Status</label>

                <select name="status" id="status" required class="h-11 w-full rounded-lg border border-slate-300 bg-[#F8FAFC] px-3 text-sm text-slate-700 outline-none transition focus:border-[#2F80ED] focus:ring-4 focus:ring-blue-100">

                    @foreach (['Stored', 'Borrowed', 'Returned', 'Destroyed'] as $status)

                        <option value="{{ $status }}" @selected(old('status', $evidence->status) === $status)>
                            {{ $status }}
                        </option>

                    @endforeach

                </select>

                <p class="mt-2 text-xs text-slate-400">Status menunjukkan kondisi atau posisi fisik barang bukti saat ini.</p>
            </div>


            {{-- DESCRIPTION --}}
            <div class="md:col-span-2">
                <label for="description" class="mb-2 block text-sm font-semibold text-slate-700">Description</label>

                <textarea name="description" id="description" rows="6" placeholder="Tambahkan deskripsi barang bukti..." class="w-full resize-y rounded-lg border border-slate-300 bg-[#F8FAFC] px-3 py-3 text-sm leading-6 text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-[#2F80ED] focus:ring-4 focus:ring-blue-100">{{ old('description', $evidence->description) }}</textarea>
            </div>

        </div>


        {{-- ACTION --}}
        <div class="mt-6 flex flex-wrap items-center gap-3 border-t border-slate-200 pt-5">

            <button type="submit" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-lg bg-[#2F80ED] px-4 text-sm font-semibold text-white transition hover:bg-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.75H6.75A2.25 2.25 0 0 0 4.5 6v12a2.25 2.25 0 0 0 2.25 2.25h10.5A2.25 2.25 0 0 0 19.5 18V6.75L16.5 3.75ZM8.25 3.75v5.25h7.5V3.75M8.25 15h7.5" />
                </svg>

                Update Evidence
            </button>


            <a href="{{ route('evidence.show', $evidence->id) }}" class="inline-flex min-h-10 items-center justify-center rounded-lg border border-slate-300 bg-[#F8FAFC] px-4 text-sm font-medium text-slate-600 transition hover:bg-[#EEF3F8]">
                Batal
            </a>

        </div>

    </form>

</div>

@endsection