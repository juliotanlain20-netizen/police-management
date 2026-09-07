@extends('layouts.app')

@section('title', 'Tambah Police Officer')

@section('content')

{{-- HEADER --}}
<div class="mb-7 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">

    <div>
        <h1 class="mb-1 text-3xl font-bold text-[#0B1F3A]">Tambah Police Officer</h1>
        <p class="text-sm text-slate-500">Buat data Police Officer dari user yang sudah terdaftar.</p>
    </div>

    <a href="{{ route('police.index') }}" class="inline-flex min-h-10 items-center justify-center gap-2 self-start rounded-lg border border-slate-300 bg-[#F8FAFC] px-4 text-sm font-medium text-slate-600 transition hover:bg-[#EEF3F8] hover:text-[#0B1F3A]">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
        </svg>
        Kembali
    </a>

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


{{-- CREATE FORM --}}
<div class="overflow-hidden rounded-xl border border-slate-200 bg-[#F8FAFC]">

    <div class="border-b border-slate-200 px-5 py-5">
        <h2 class="text-lg font-bold text-[#0B1F3A]">Data Police Officer</h2>
        <p class="mt-1 text-xs text-slate-400">Pilih akun user lalu lengkapi informasi kepolisian.</p>
    </div>


    <form action="{{ route('police.store') }}" method="POST" class="p-5">
        @csrf


        {{-- USER --}}
        <div class="mb-5">

            <label for="user_id" class="mb-2 block text-sm font-semibold text-slate-700">User</label>

            <select name="user_id" id="user_id" required class="h-11 w-full rounded-lg border border-slate-300 bg-[#F8FAFC] px-3 text-sm text-slate-700 outline-none transition focus:border-[#2F80ED] focus:ring-4 focus:ring-blue-100">

                <option value="">Pilih User</option>

                @foreach ($users as $user)

                    <option value="{{ $user->id }}" @selected(old('user_id') == $user->id)>
                        {{ $user->name }}
                        — {{ $user->email }}
                        — Role: {{ $user->roles->pluck('name')->implode(', ') ?: '-' }}
                    </option>

                @endforeach

            </select>

            <p class="mt-2 text-xs text-slate-400">Pilih akun user yang akan dijadikan Police Officer.</p>

        </div>


        <div class="grid gap-5 md:grid-cols-2">

            {{-- UNIT --}}
            <div>
                <label for="unit_id" class="mb-2 block text-sm font-semibold text-slate-700">Unit</label>

                <select name="unit_id" id="unit_id" required class="h-11 w-full rounded-lg border border-slate-300 bg-[#F8FAFC] px-3 text-sm text-slate-700 outline-none transition focus:border-[#2F80ED] focus:ring-4 focus:ring-blue-100">

                    <option value="">Pilih Unit</option>

                    @foreach ($units as $unit)
                        <option value="{{ $unit->id }}" @selected(old('unit_id') == $unit->id)>
                            {{ $unit->name }}
                        </option>
                    @endforeach

                </select>
            </div>


            {{-- RANK --}}
            <div>
                <label for="rank_id" class="mb-2 block text-sm font-semibold text-slate-700">Pangkat</label>

                <select name="rank_id" id="rank_id" required class="h-11 w-full rounded-lg border border-slate-300 bg-[#F8FAFC] px-3 text-sm text-slate-700 outline-none transition focus:border-[#2F80ED] focus:ring-4 focus:ring-blue-100">

                    <option value="">Pilih Pangkat</option>

                    @foreach ($ranks as $rank)
                        <option value="{{ $rank->id }}" @selected(old('rank_id') == $rank->id)>
                            {{ $rank->name }}
                        </option>
                    @endforeach

                </select>
            </div>


            {{-- NRP --}}
            <div class="md:col-span-2">
                <label for="nrp" class="mb-2 block text-sm font-semibold text-slate-700">NRP</label>

                <input type="text" name="nrp" id="nrp" value="{{ old('nrp') }}" placeholder="Masukkan NRP" required class="h-11 w-full rounded-lg border border-slate-300 bg-[#F8FAFC] px-3 font-mono text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-[#2F80ED] focus:ring-4 focus:ring-blue-100">
            </div>


            {{-- ADDRESS --}}
            <div class="md:col-span-2">
                <label for="address" class="mb-2 block text-sm font-semibold text-slate-700">Alamat</label>

                <textarea name="address" id="address" rows="5" placeholder="Masukkan alamat Police Officer" required class="w-full resize-y rounded-lg border border-slate-300 bg-[#F8FAFC] px-3 py-3 text-sm leading-6 text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-[#2F80ED] focus:ring-4 focus:ring-blue-100">{{ old('address') }}</textarea>
            </div>

        </div>


        {{-- ACTION --}}
        <div class="mt-6 flex flex-wrap items-center gap-3 border-t border-slate-200 pt-5">

            <button type="submit" name="action" value="submit" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-lg bg-[#2F80ED] px-4 text-sm font-semibold text-white transition hover:bg-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>

                Simpan Police Officer
            </button>


            <a href="{{ route('police.index') }}" class="inline-flex min-h-10 items-center justify-center rounded-lg border border-slate-300 bg-[#F8FAFC] px-4 text-sm font-medium text-slate-600 transition hover:bg-[#EEF3F8]">
                Batal
            </a>

        </div>

    </form>

</div>

@endsection