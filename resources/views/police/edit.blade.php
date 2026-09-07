@extends('layouts.app')

@section('title', 'Edit Police Officer')

@section('content')

@php
    $statusClass = $police->status === 'Active'
        ? 'bg-emerald-100 text-emerald-800'
        : 'bg-slate-100 text-slate-700';
@endphp


{{-- HEADER --}}
<div class="mb-7 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">

    <div>
        <h1 class="mb-1 text-3xl font-bold text-[#0B1F3A]">Edit Police Officer</h1>

        <p class="text-sm text-slate-500">
            Perbarui data kepolisian
            <span class="font-semibold text-slate-700">{{ $police->user?->name ?? 'Police Officer' }}</span>.
        </p>
    </div>


    <div class="flex flex-wrap items-center gap-2">

        <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold {{ $statusClass }}">
            {{ $police->status }}
        </span>

        <a href="{{ route('police.show', $police->id) }}" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-lg border border-slate-300 bg-[#F8FAFC] px-4 text-sm font-medium text-slate-600 transition hover:bg-[#EEF3F8] hover:text-[#0B1F3A]">

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


{{-- USER INFORMATION --}}
<div class="mb-6 overflow-hidden rounded-xl border border-slate-200 bg-[#F8FAFC]">

    <div class="border-b border-slate-200 px-5 py-5">
        <h2 class="text-lg font-bold text-[#0B1F3A]">Informasi Akun</h2>
        <p class="mt-1 text-xs text-slate-400">Data akun user yang terhubung dengan Police Officer.</p>
    </div>


    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">

        {{-- NAME --}}
        <div class="border-b border-slate-100 px-5 py-4 sm:border-r lg:border-b-0">
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400">Nama</p>
            <p class="text-sm font-semibold text-slate-700">{{ $police->user?->name ?? '-' }}</p>
        </div>


        {{-- EMAIL --}}
        <div class="border-b border-slate-100 px-5 py-4 lg:border-r lg:border-b-0">
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400">Email</p>
            <p class="break-all text-sm font-semibold text-slate-700">{{ $police->user?->email ?? '-' }}</p>
        </div>


        {{-- PHONE --}}
        <div class="px-5 py-4">
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400">Phone</p>
            <p class="text-sm font-semibold text-slate-700">{{ $police->user?->phone ?? '-' }}</p>
        </div>

    </div>

</div>


{{-- EDIT FORM --}}
<div class="overflow-hidden rounded-xl border border-slate-200 bg-[#F8FAFC]">

    <div class="border-b border-slate-200 px-5 py-5">
        <h2 class="text-lg font-bold text-[#0B1F3A]">Data Police Officer</h2>
        <p class="mt-1 text-xs text-slate-400">Ubah data pangkat, unit, NRP, alamat, dan status officer.</p>
    </div>


    <form action="{{ route('police.update', ['id' => $police->id]) }}" method="POST" class="p-5">
        @csrf
        @method('PATCH')


        <div class="grid gap-5 md:grid-cols-2">

            {{-- UNIT --}}
            <div>
                <label for="unit_id" class="mb-2 block text-sm font-semibold text-slate-700">Unit</label>

                <select name="unit_id" id="unit_id" required class="h-11 w-full rounded-lg border border-slate-300 bg-[#F8FAFC] px-3 text-sm text-slate-700 outline-none transition focus:border-[#2F80ED] focus:ring-4 focus:ring-blue-100">

                    @foreach ($units as $unit)
                        <option value="{{ $unit->id }}" @selected(old('unit_id', $police->unit_id) == $unit->id)>
                            {{ $unit->name }}
                        </option>
                    @endforeach

                </select>
            </div>


            {{-- RANK --}}
            <div>
                <label for="rank_id" class="mb-2 block text-sm font-semibold text-slate-700">Pangkat</label>

                <select name="rank_id" id="rank_id" required class="h-11 w-full rounded-lg border border-slate-300 bg-[#F8FAFC] px-3 text-sm text-slate-700 outline-none transition focus:border-[#2F80ED] focus:ring-4 focus:ring-blue-100">

                    @foreach ($ranks as $rank)
                        <option value="{{ $rank->id }}" @selected(old('rank_id', $police->rank_id) == $rank->id)>
                            {{ $rank->name }}
                        </option>
                    @endforeach

                </select>
            </div>


            {{-- NRP --}}
            <div>
                <label for="nrp" class="mb-2 block text-sm font-semibold text-slate-700">NRP</label>

                <input type="text" name="nrp" id="nrp" value="{{ old('nrp', $police->nrp) }}" required class="h-11 w-full rounded-lg border border-slate-300 bg-[#F8FAFC] px-3 font-mono text-sm text-slate-700 outline-none transition focus:border-[#2F80ED] focus:ring-4 focus:ring-blue-100">
            </div>


            {{-- STATUS --}}
            <div>
                <label for="status" class="mb-2 block text-sm font-semibold text-slate-700">Status</label>

                <select name="status" id="status" required class="h-11 w-full rounded-lg border border-slate-300 bg-[#F8FAFC] px-3 text-sm text-slate-700 outline-none transition focus:border-[#2F80ED] focus:ring-4 focus:ring-blue-100">
                    <option value="Active" @selected(old('status', $police->status) === 'Active')>Active</option>
                    <option value="Inactive" @selected(old('status', $police->status) === 'Inactive')>Inactive</option>
                </select>

                <p class="mt-2 text-xs text-slate-400">Officer berstatus Inactive tidak dapat menangani perubahan case.</p>
            </div>


            {{-- ADDRESS --}}
            <div class="md:col-span-2">
                <label for="address" class="mb-2 block text-sm font-semibold text-slate-700">Alamat</label>

                <textarea name="address" id="address" rows="5" required class="w-full resize-y rounded-lg border border-slate-300 bg-[#F8FAFC] px-3 py-3 text-sm leading-6 text-slate-700 outline-none transition focus:border-[#2F80ED] focus:ring-4 focus:ring-blue-100">{{ old('address', $police->address) }}</textarea>
            </div>

        </div>


        {{-- ACTION --}}
        <div class="mt-6 flex flex-wrap items-center gap-3 border-t border-slate-200 pt-5">

            <button type="submit" name="action" value="submit" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-lg bg-[#2F80ED] px-4 text-sm font-semibold text-white transition hover:bg-blue-600">

                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.75H6.75A2.25 2.25 0 0 0 4.5 6v12a2.25 2.25 0 0 0 2.25 2.25h10.5A2.25 2.25 0 0 0 19.5 18V6.75L16.5 3.75ZM8.25 3.75v5.25h7.5V3.75M8.25 15h7.5" />
                </svg>

                Simpan Perubahan
            </button>


            <a href="{{ route('police.show', $police->id) }}" class="inline-flex min-h-10 items-center justify-center rounded-lg border border-slate-300 bg-[#F8FAFC] px-4 text-sm font-medium text-slate-600 transition hover:bg-[#EEF3F8]">
                Batal
            </a>

        </div>

    </form>

</div>

@endsection