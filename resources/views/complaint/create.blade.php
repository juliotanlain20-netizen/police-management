@extends('layouts.app')

@section('title', 'Buat Pengaduan')

@section('content')

<div class="mb-7 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
    <div>
        <h1 class="mb-1 text-3xl font-bold text-[#0B1F3A]">Buat Pengaduan</h1>
        <p class="text-sm text-slate-500">Lengkapi informasi pengaduan yang ingin Anda sampaikan.</p>
    </div>

    <a href="{{ route('complaint') }}" class="inline-flex min-h-9 items-center justify-center gap-2 self-start rounded-lg border border-slate-300 bg-[#F8FAFC] px-4 text-sm font-medium text-slate-600 transition hover:bg-[#EEF3F8] hover:text-[#0B1F3A]">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
        </svg>
        Kembali
    </a>
</div>


{{-- VALIDATION ERROR --}}
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


{{-- FORM --}}
<div class="overflow-hidden rounded-xl border border-slate-200 bg-[#F8FAFC]">

    <div class="border-b border-slate-200 px-5 py-5">
        <h2 class="text-lg font-bold text-[#0B1F3A]">Informasi Pengaduan</h2>
        <p class="mt-1 text-xs text-slate-400">Isi informasi kejadian dan lampirkan bukti pendukung jika tersedia.</p>
    </div>

    <form action="{{ route('complaint.store') }}" method="POST" enctype="multipart/form-data" class="p-5">
        @csrf

        <div class="grid gap-5 md:grid-cols-2">

            {{-- TITLE --}}
            <div class="md:col-span-2">
                <label for="title" class="mb-2 block text-sm font-semibold text-slate-700">Judul Pengaduan</label>

                <input type="text" name="title" id="title" value="{{ old('title') }}" placeholder="Masukkan judul pengaduan" required class="h-11 w-full rounded-lg border border-slate-300 bg-[#F8FAFC] px-3 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-[#2F80ED] focus:ring-4 focus:ring-blue-100">
            </div>


            {{-- CATEGORY --}}
            <div>
                <label for="category_id" class="mb-2 block text-sm font-semibold text-slate-700">Kategori</label>

                <select name="category_id" id="category_id" required class="h-11 w-full rounded-lg border border-slate-300 bg-[#F8FAFC] px-3 text-sm text-slate-700 outline-none transition focus:border-[#2F80ED] focus:ring-4 focus:ring-blue-100">
                    <option value="">Pilih Kategori</option>

                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>


            {{-- INCIDENT DATE --}}
            <div>
                <label for="incident_date" class="mb-2 block text-sm font-semibold text-slate-700">Tanggal Kejadian</label>

                <input type="date" name="incident_date" id="incident_date" value="{{ old('incident_date') }}" required class="h-11 w-full rounded-lg border border-slate-300 bg-[#F8FAFC] px-3 text-sm text-slate-700 outline-none transition focus:border-[#2F80ED] focus:ring-4 focus:ring-blue-100">
            </div>


            {{-- LOCATION --}}
            <div class="md:col-span-2">
                <label for="location" class="mb-2 block text-sm font-semibold text-slate-700">Lokasi Kejadian</label>

                <div class="relative">
                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-[18px] w-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                        </svg>
                    </span>

                    <input type="text" name="location" id="location" value="{{ old('location') }}" placeholder="Masukkan lokasi kejadian" required class="h-11 w-full rounded-lg border border-slate-300 bg-[#F8FAFC] pl-10 pr-3 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-[#2F80ED] focus:ring-4 focus:ring-blue-100">
                </div>
            </div>


            {{-- DESCRIPTION --}}
            <div class="md:col-span-2">
                <label for="description" class="mb-2 block text-sm font-semibold text-slate-700">Deskripsi</label>

                <textarea name="description" id="description" rows="7" placeholder="Jelaskan kronologi atau detail pengaduan..." required class="w-full resize-y rounded-lg border border-slate-300 bg-[#F8FAFC] px-3 py-3 text-sm leading-6 text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-[#2F80ED] focus:ring-4 focus:ring-blue-100">{{ old('description') }}</textarea>
            </div>


            {{-- ATTACHMENTS --}}
            <div class="md:col-span-2">
                <label for="attachments" class="mb-2 block text-sm font-semibold text-slate-700">Bukti Awal</label>

                <div class="rounded-lg border border-dashed border-slate-300 bg-[#EEF3F8]/60 p-4">
                    <div class="mb-3 flex items-start gap-3">
                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-blue-100 text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-[18px] w-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739 10.682 20.43a4.5 4.5 0 0 1-6.364-6.364l9.546-9.546a3 3 0 0 1 4.243 4.243l-9.193 9.193a1.5 1.5 0 0 1-2.121-2.121l8.485-8.485" />
                            </svg>
                        </div>

                        <div>
                            <p class="text-sm font-semibold text-slate-700">Lampirkan bukti pendukung</p>
                            <p class="mt-1 text-xs text-slate-400">Opsional. Anda dapat memilih lebih dari satu file.</p>
                        </div>
                    </div>

                    <input type="file" name="attachments[]" id="attachments" multiple class="block w-full cursor-pointer rounded-lg border border-slate-300 bg-[#F8FAFC] text-sm text-slate-500 file:mr-4 file:border-0 file:border-r file:border-slate-200 file:bg-[#EEF3F8] file:px-4 file:py-3 file:text-sm file:font-semibold file:text-slate-700 hover:file:bg-slate-100">
                </div>
            </div>

        </div>


        {{-- ACTION --}}
        <div class="mt-6 flex flex-wrap items-center gap-3 border-t border-slate-200 pt-5">

            <button type="submit" name="action" value="draft" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-lg border border-slate-300 bg-[#F8FAFC] px-4 text-sm font-semibold text-slate-700 transition hover:bg-[#EEF3F8]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.75H6.75A2.25 2.25 0 0 0 4.5 6v12a2.25 2.25 0 0 0 2.25 2.25h10.5A2.25 2.25 0 0 0 19.5 18V6.75L16.5 3.75ZM8.25 3.75v5.25h7.5V3.75M8.25 15h7.5" />
                </svg>

                Simpan Draft
            </button>


            <button type="submit" name="action" value="submit" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-lg bg-[#2F80ED] px-4 text-sm font-semibold text-white transition hover:bg-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.27 3.125A59.77 59.77 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L6 12Zm0 0h7.5" />
                </svg>

                Kirim Pengaduan
            </button>

        </div>

    </form>

</div>

@endsection