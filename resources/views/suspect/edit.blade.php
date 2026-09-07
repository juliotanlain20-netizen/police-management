@extends('layouts.app')

@section('title', 'Edit Suspect')

@section('content')

@php
    $statusClass = match ($suspect->status) {
        'identified' => 'bg-blue-100 text-blue-800',
        'wanted' => 'bg-amber-100 text-amber-800',
        'detained' => 'bg-rose-100 text-rose-800',
        'released' => 'bg-emerald-100 text-emerald-800',
        default => 'bg-slate-100 text-slate-700'
    };
@endphp


{{-- HEADER --}}
<div class="mb-7 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">

    <div>
        <h1 class="mb-1 text-3xl font-bold text-[#0B1F3A]">Edit Suspect</h1>

        <p class="text-sm text-slate-500">
            Perbarui informasi suspect
            <span class="font-semibold text-slate-700">{{ $suspect->name }}</span>.
        </p>
    </div>


    <div class="flex flex-wrap items-center gap-2">

        <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold {{ $statusClass }}">
            {{ ucfirst($suspect->status) }}
        </span>

        <a href="{{ route('suspect.show', $suspect->id) }}" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-lg border border-slate-300 bg-[#F8FAFC] px-4 text-sm font-medium text-slate-600 transition hover:bg-[#EEF3F8] hover:text-[#0B1F3A]">
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


{{-- EDIT FORM --}}
<div class="overflow-hidden rounded-xl border border-slate-200 bg-[#F8FAFC]">

    <div class="border-b border-slate-200 px-5 py-5">
        <h2 class="text-lg font-bold text-[#0B1F3A]">Informasi Suspect</h2>
        <p class="mt-1 text-xs text-slate-400">Perbarui identitas, alamat, status, dan catatan suspect.</p>
    </div>


    <form action="{{ route('suspect.update', $suspect->id) }}" method="POST" class="p-5">
        @csrf
        @method('PATCH')


        <div class="grid gap-5 md:grid-cols-2">

            {{-- NAME --}}
            <div>
                <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">Name</label>

                <input type="text" name="name" id="name" value="{{ old('name', $suspect->name) }}" required class="h-11 w-full rounded-lg border border-slate-300 bg-[#F8FAFC] px-3 text-sm text-slate-700 outline-none transition focus:border-[#2F80ED] focus:ring-4 focus:ring-blue-100">
            </div>


            {{-- IDENTITY NUMBER --}}
            <div>
                <label for="identity_number" class="mb-2 block text-sm font-semibold text-slate-700">Identity Number</label>

                <input type="text" name="identity_number" id="identity_number" value="{{ old('identity_number', $suspect->identity_number) }}" class="h-11 w-full rounded-lg border border-slate-300 bg-[#F8FAFC] px-3 font-mono text-sm text-slate-700 outline-none transition focus:border-[#2F80ED] focus:ring-4 focus:ring-blue-100">
            </div>


            {{-- ADDRESS --}}
            <div>
                <label for="address" class="mb-2 block text-sm font-semibold text-slate-700">Address</label>

                <input type="text" name="address" id="address" value="{{ old('address', $suspect->address) }}" required class="h-11 w-full rounded-lg border border-slate-300 bg-[#F8FAFC] px-3 text-sm text-slate-700 outline-none transition focus:border-[#2F80ED] focus:ring-4 focus:ring-blue-100">
            </div>


            {{-- STATUS --}}
            <div>
                <label for="status" class="mb-2 block text-sm font-semibold text-slate-700">Status</label>

                <select name="status" id="status" required class="h-11 w-full rounded-lg border border-slate-300 bg-[#F8FAFC] px-3 text-sm text-slate-700 outline-none transition focus:border-[#2F80ED] focus:ring-4 focus:ring-blue-100">

                    @foreach (['identified', 'wanted', 'detained', 'released'] as $status)

                        <option value="{{ $status }}" @selected(old('status', $suspect->status) === $status)>
                            {{ ucfirst($status) }}
                        </option>

                    @endforeach

                </select>
            </div>


            {{-- NOTES --}}
            <div class="md:col-span-2">
                <label for="notes" class="mb-2 block text-sm font-semibold text-slate-700">Notes</label>

                <textarea name="notes" id="notes" rows="5" class="w-full resize-y rounded-lg border border-slate-300 bg-[#F8FAFC] px-3 py-3 text-sm leading-6 text-slate-700 outline-none transition focus:border-[#2F80ED] focus:ring-4 focus:ring-blue-100">{{ old('notes', $suspect->notes) }}</textarea>
            </div>

        </div>


        {{-- ACTION --}}
        <div class="mt-6 flex flex-wrap items-center gap-3 border-t border-slate-200 pt-5">

            <button type="submit" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-lg bg-[#2F80ED] px-4 text-sm font-semibold text-white transition hover:bg-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.75H6.75A2.25 2.25 0 0 0 4.5 6v12a2.25 2.25 0 0 0 2.25 2.25h10.5A2.25 2.25 0 0 0 19.5 18V6.75L16.5 3.75ZM8.25 3.75v5.25h7.5V3.75M8.25 15h7.5" />
                </svg>

                Update Suspect
            </button>


            <a href="{{ route('suspect.show', $suspect->id) }}" class="inline-flex min-h-10 items-center justify-center rounded-lg border border-slate-300 bg-[#F8FAFC] px-4 text-sm font-medium text-slate-600 transition hover:bg-[#EEF3F8]">
                Batal
            </a>

        </div>

    </form>

</div>

@endsection