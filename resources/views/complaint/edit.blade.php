@extends('layouts.app')

@section('title', 'Edit Pengaduan')

@section('content')

<div class="mb-7 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
    <div>
        <h1 class="mb-1 text-3xl font-bold text-[#0B1F3A]">Edit Pengaduan</h1>
        <p class="text-sm text-slate-500">Perbarui informasi dan attachment pengaduan Anda.</p>
    </div>

    <a href="{{ route('complaint.show', $complaint->id) }}" class="inline-flex min-h-9 items-center justify-center gap-2 self-start rounded-lg border border-slate-300 bg-[#F8FAFC] px-4 text-sm font-medium text-slate-600 transition hover:bg-[#EEF3F8] hover:text-[#0B1F3A]">
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


{{-- INFORMASI PENGADUAN --}}
<div class="mb-6 overflow-hidden rounded-xl border border-slate-200 bg-[#F8FAFC]">

    <div class="border-b border-slate-200 px-5 py-5">
        <h2 class="text-lg font-bold text-[#0B1F3A]">Informasi Pengaduan</h2>
        <p class="mt-1 text-xs text-slate-400">Perbarui informasi utama dari pengaduan.</p>
    </div>

    <form action="{{ route('complaint.update', $complaint->id) }}" method="POST" class="p-5">
        @csrf
        @method('PATCH')

        <div class="grid gap-5 md:grid-cols-2">

            {{-- TITLE --}}
            <div class="md:col-span-2">
                <label for="title" class="mb-2 block text-sm font-semibold text-slate-700">Judul</label>
                <input type="text" name="title" id="title" value="{{ old('title', $complaint->title) }}" required class="h-11 w-full rounded-lg border border-slate-300 bg-[#F8FAFC] px-3 text-sm text-slate-700 outline-none transition focus:border-[#2F80ED] focus:ring-4 focus:ring-blue-100">
            </div>

            {{-- CATEGORY --}}
            <div>
                <label for="category_id" class="mb-2 block text-sm font-semibold text-slate-700">Kategori</label>

                <select name="category_id" id="category_id" required class="h-11 w-full rounded-lg border border-slate-300 bg-[#F8FAFC] px-3 text-sm text-slate-700 outline-none transition focus:border-[#2F80ED] focus:ring-4 focus:ring-blue-100">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id', $complaint->category_id) == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- DATE --}}
            <div>
                <label for="incident_date" class="mb-2 block text-sm font-semibold text-slate-700">Tanggal Kejadian</label>
                <input type="date" name="incident_date" id="incident_date" value="{{ old('incident_date', $complaint->incident_date) }}" required class="h-11 w-full rounded-lg border border-slate-300 bg-[#F8FAFC] px-3 text-sm text-slate-700 outline-none transition focus:border-[#2F80ED] focus:ring-4 focus:ring-blue-100">
            </div>

            {{-- LOCATION --}}
            <div class="md:col-span-2">
                <label for="location" class="mb-2 block text-sm font-semibold text-slate-700">Lokasi Kejadian</label>
                <input type="text" name="location" id="location" value="{{ old('location', $complaint->location) }}" required class="h-11 w-full rounded-lg border border-slate-300 bg-[#F8FAFC] px-3 text-sm text-slate-700 outline-none transition focus:border-[#2F80ED] focus:ring-4 focus:ring-blue-100">
            </div>

            {{-- DESCRIPTION --}}
            <div class="md:col-span-2">
                <label for="description" class="mb-2 block text-sm font-semibold text-slate-700">Deskripsi</label>
                <textarea name="description" id="description" rows="7" required class="w-full resize-y rounded-lg border border-slate-300 bg-[#F8FAFC] px-3 py-3 text-sm leading-6 text-slate-700 outline-none transition focus:border-[#2F80ED] focus:ring-4 focus:ring-blue-100">{{ old('description', $complaint->description) }}</textarea>
            </div>

        </div>


        {{-- ACTION --}}
        <div class="mt-6 flex flex-wrap items-center gap-3 border-t border-slate-200 pt-5">

            <button type="submit" name="action" value="save" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-lg border border-slate-300 bg-[#F8FAFC] px-4 text-sm font-semibold text-slate-700 transition hover:bg-[#EEF3F8]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.75H6.75A2.25 2.25 0 0 0 4.5 6v12a2.25 2.25 0 0 0 2.25 2.25h10.5A2.25 2.25 0 0 0 19.5 18V6.75L16.5 3.75ZM8.25 3.75v5.25h7.5V3.75M8.25 15h7.5" />
                </svg>
                Simpan Perubahan
            </button>

            @if (in_array($complaint->status, ['Draft', 'Need More Evidence']))
                <button type="submit" name="action" value="submit" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-lg bg-[#2F80ED] px-4 text-sm font-semibold text-white transition hover:bg-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.27 3.125A59.77 59.77 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L6 12Zm0 0h7.5" />
                    </svg>

                    {{ $complaint->status === 'Draft' ? 'Submit Pengaduan' : 'Resubmit Pengaduan' }}
                </button>
            @endif

        </div>

    </form>

</div>


{{-- TAMBAH ATTACHMENT --}}
<div class="mb-6 overflow-hidden rounded-xl border border-slate-200 bg-[#F8FAFC]">

    <div class="border-b border-slate-200 px-5 py-5">
        <h2 class="text-lg font-bold text-[#0B1F3A]">Tambah Attachment</h2>
        <p class="mt-1 text-xs text-slate-400">Tambahkan file pendukung untuk pengaduan ini.</p>
    </div>

    <form action="{{ route('complaint.attachments.store', $complaint->id) }}" method="POST" enctype="multipart/form-data" class="p-5">
        @csrf

        <div class="max-w-2xl">
            <label for="attachment" class="mb-2 block text-sm font-semibold text-slate-700">Pilih File</label>

            <input type="file" name="attachment" id="attachment" required class="block w-full cursor-pointer rounded-lg border border-slate-300 bg-[#F8FAFC] text-sm text-slate-500 file:mr-4 file:border-0 file:border-r file:border-slate-200 file:bg-[#EEF3F8] file:px-4 file:py-3 file:text-sm file:font-semibold file:text-slate-700 hover:file:bg-slate-100">

            <p class="mt-2 text-xs text-slate-400">Pilih file yang relevan sebagai bukti atau dokumen pendukung.</p>
        </div>

        <button type="submit" class="mt-5 inline-flex min-h-10 items-center justify-center gap-2 rounded-lg bg-[#2F80ED] px-4 text-sm font-semibold text-white transition hover:bg-blue-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Tambah Attachment
        </button>

    </form>

</div>


{{-- ATTACHMENT SAAT INI --}}
<div class="mb-6 overflow-hidden rounded-xl border border-slate-200 bg-[#F8FAFC]">

    <div class="border-b border-slate-200 px-5 py-5">
        <h2 class="text-lg font-bold text-[#0B1F3A]">Attachment Saat Ini</h2>
        <p class="mt-1 text-xs text-slate-400">File yang saat ini terpasang pada pengaduan.</p>
    </div>

    <div class="divide-y divide-slate-100">

        @forelse ($complaint->attachments as $attachment)

            <div class="flex flex-col gap-4 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">

                <div class="flex min-w-0 items-center gap-3">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739 10.682 20.43a4.5 4.5 0 0 1-6.364-6.364l9.546-9.546a3 3 0 0 1 4.243 4.243l-9.193 9.193a1.5 1.5 0 0 1-2.121-2.121l8.485-8.485" />
                        </svg>
                    </div>

                    <div class="min-w-0">
                        <p class="truncate text-sm font-semibold text-slate-700">{{ $attachment->file_name }}</p>
                        <p class="mt-1 text-xs text-slate-400">{{ $attachment->mime_type }}</p>
                    </div>

                </div>


                <div class="flex flex-wrap gap-2">

                    <a href="{{ route('complaint.attachments.show', [$complaint->id, $attachment->id]) }}" target="_blank" rel="noopener noreferrer" class="inline-flex min-h-9 items-center justify-center gap-2 rounded-lg border border-slate-300 bg-[#F8FAFC] px-3 text-sm font-medium text-slate-600 transition hover:bg-[#EEF3F8]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12 18 18.75 12 18.75 2.25 12 2.25 12Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                        Lihat
                    </a>

                    <a href="{{ route('complaint.attachments.download', [$complaint->id, $attachment->id]) }}" class="inline-flex min-h-9 items-center justify-center gap-2 rounded-lg border border-slate-300 bg-[#F8FAFC] px-3 text-sm font-medium text-slate-600 transition hover:bg-[#EEF3F8]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M7.5 10.5 12 15m0 0 4.5-4.5M12 15V3" />
                        </svg>
                        Download
                    </a>

                    <form action="{{ route('complaint.attachments.destroy', [$complaint->id, $attachment->id]) }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <button type="submit" onclick="return confirm('Hapus attachment ini?')" class="inline-flex min-h-9 items-center justify-center gap-2 rounded-lg border border-rose-200 bg-[#F8FAFC] px-3 text-sm font-medium text-rose-600 transition hover:bg-rose-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21L18.16 19.673A2.25 2.25 0 0 1 15.916 21H8.084a2.25 2.25 0 0 1-2.244-2.327L4.772 5.79" />
                            </svg>
                            Hapus
                        </button>
                    </form>

                </div>

            </div>

        @empty

            <div class="px-5 py-10 text-center">
                <div class="mx-auto mb-3 flex h-11 w-11 items-center justify-center rounded-full bg-slate-100 text-slate-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739 10.682 20.43a4.5 4.5 0 0 1-6.364-6.364l9.546-9.546a3 3 0 0 1 4.243 4.243" />
                    </svg>
                </div>

                <p class="text-sm font-medium text-slate-500">Belum ada attachment.</p>
            </div>

        @endforelse

    </div>

</div>

@endsection