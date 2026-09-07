@extends('layouts.app')

@section('title', 'Detail Evidence')

@section('content')

@php
    $user = auth()->user();
    $isAdmin = $user->roles->contains('name', 'admin');
    $officerId = $user->officer?->id;
    $case = $evidence->investigationCase;

    $isAssigned = $officerId && $case
        ? $case->officers->contains(function ($officer) use ($officerId) {
            return $officer->id === $officerId && $officer->pivot->status === 'Active';
        })
        : false;

    $canMutate = $isAdmin || $isAssigned;

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
        <div class="mb-2 flex flex-wrap items-center gap-2">
            <h1 class="font-mono text-3xl font-bold text-[#0B1F3A]">{{ $evidence->evidence_code }}</h1>

            <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold {{ $statusClass }}">
                {{ $evidence->status }}
            </span>

            <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold {{ $recordClass }}">
                {{ $evidence->record_status }}
            </span>
        </div>

        <p class="text-sm text-slate-500">{{ $evidence->name }}</p>
    </div>


    <div class="flex flex-wrap gap-2">

        <a href="{{ route('evidence.index') }}" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-lg border border-slate-300 bg-[#F8FAFC] px-4 text-sm font-medium text-slate-600 transition hover:bg-[#EEF3F8] hover:text-[#0B1F3A]">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
            Kembali
        </a>


        @if (
            $evidence->record_status === 'Valid' &&
            $user->hasPermission('evidence.update') &&
            $canMutate
        )

            <a href="{{ route('evidence.edit', $evidence->id) }}" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-lg bg-[#2F80ED] px-4 text-sm font-semibold text-white transition hover:bg-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.862 4.487Z" />
                </svg>
                Edit Evidence
            </a>

        @endif

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


{{-- INFORMATION --}}
<div class="mb-6 overflow-hidden rounded-xl border border-slate-200 bg-[#F8FAFC]">

    <div class="flex flex-col gap-3 border-b border-slate-200 px-5 py-5 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h2 class="text-lg font-bold text-[#0B1F3A]">Informasi Evidence</h2>
            <p class="mt-1 text-xs text-slate-400">Informasi utama barang bukti yang tercatat dalam sistem.</p>
        </div>

        <div class="flex flex-wrap gap-2">
            <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold {{ $statusClass }}">{{ $evidence->status }}</span>
            <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold {{ $recordClass }}">{{ $evidence->record_status }}</span>
        </div>

    </div>


    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">

        <div class="border-b border-slate-100 px-5 py-4 sm:border-r">
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400">Evidence Code</p>
            <p class="font-mono text-sm font-bold text-[#0B1F3A]">{{ $evidence->evidence_code }}</p>
        </div>


        <div class="border-b border-slate-100 px-5 py-4 lg:border-r">
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400">Name</p>
            <p class="text-sm font-semibold text-slate-700">{{ $evidence->name }}</p>
        </div>


        <div class="border-b border-slate-100 px-5 py-4 sm:border-r lg:border-r-0">
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400">Category</p>
            <p class="text-sm font-semibold text-slate-700">{{ $evidence->category?->name ?? '-' }}</p>
        </div>


        <div class="border-b border-slate-100 px-5 py-4 lg:border-r">
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400">Investigation Case</p>

            @if ($case)

                <a href="{{ route('cases.show', $case->id) }}" class="inline-flex items-center gap-1.5 text-sm font-bold text-[#2F80ED] transition hover:text-blue-700 hover:underline">
                    {{ $case->case_number }}

                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                    </svg>
                </a>

            @else
                <p class="text-sm font-semibold text-slate-700">-</p>
            @endif
        </div>


        <div class="border-b border-slate-100 px-5 py-4 sm:border-r">
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400">Storage Location</p>

            <div class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                </svg>

                {{ $evidence->storage_location }}
            </div>
        </div>


        <div class="border-b border-slate-100 px-5 py-4">
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400">Physical Status</p>
            <p class="text-sm font-semibold text-slate-700">{{ $evidence->status }}</p>
        </div>


        <div class="px-5 py-4">
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400">Record Status</p>
            <p class="text-sm font-semibold text-slate-700">{{ $evidence->record_status }}</p>
        </div>

    </div>


    <div class="border-t border-slate-100 px-5 py-5">
        <p class="mb-2 text-xs font-semibold uppercase tracking-wide text-slate-400">Description</p>
        <p class="whitespace-pre-line text-sm leading-7 text-slate-600">{{ $evidence->description ?? '-' }}</p>
    </div>

</div>


{{-- ATTACHMENTS --}}
<div class="mb-6 overflow-hidden rounded-xl border border-slate-200 bg-[#F8FAFC]">

    <div class="flex flex-col gap-4 border-b border-slate-200 px-5 py-5 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h2 class="text-lg font-bold text-[#0B1F3A]">Evidence Attachments</h2>
            <p class="mt-1 text-xs text-slate-400">File yang terhubung dengan barang bukti ini.</p>
        </div>


        @if (
            $evidence->record_status === 'Valid' &&
            $user->hasPermission('evidence.manage_attachment') &&
            $canMutate
        )

            <button type="button" data-toggle-form="attachment-form" data-default-text="+ Tambah Attachment" class="inline-flex min-h-10 items-center justify-center rounded-lg bg-[#2F80ED] px-4 text-sm font-semibold text-white transition hover:bg-blue-600">
                + Tambah Attachment
            </button>

        @endif

    </div>


    <div class="overflow-x-auto">

        <table class="w-full border-collapse">

            <thead class="bg-[#EEF3F8]">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">File</th>
                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Type</th>
                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Size</th>
                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Uploaded</th>
                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Action</th>
                </tr>
            </thead>


            <tbody class="divide-y divide-slate-200">

                @forelse ($evidence->attachments as $attachment)

                    <tr class="transition hover:bg-[#EEF3F8]">

                        <td class="px-5 py-4">

                            <div class="flex min-w-[180px] items-center gap-3">

                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-blue-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739 10.682 20.43a4.5 4.5 0 0 1-6.364-6.364l9.546-9.546a3 3 0 0 1 4.243 4.243" />
                                    </svg>
                                </div>

                                <span class="max-w-[260px] truncate text-sm font-semibold text-slate-700">
                                    {{ $attachment->file_name }}
                                </span>

                            </div>

                        </td>


                        <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-500">
                            {{ $attachment->mime_type }}
                        </td>


                        <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-500">
                            {{ $attachment->file_size ? number_format($attachment->file_size / 1024, 2) . ' KB' : '-' }}
                        </td>


                        <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-500">
                            {{ $attachment->uploaded_at ? \Carbon\Carbon::parse($attachment->uploaded_at)->format('d M Y, H:i') : '-' }}
                        </td>


                        <td class="px-5 py-4">

                            <div class="flex flex-wrap gap-2">

                                <a href="{{ route('evidence.attachment.show', [$evidence->id, $attachment->id]) }}" target="_blank" rel="noopener noreferrer" class="inline-flex min-h-9 items-center justify-center rounded-lg border border-slate-300 bg-[#F8FAFC] px-3 text-sm font-medium text-slate-600 transition hover:bg-[#EEF3F8]">
                                    Lihat
                                </a>


                                <a href="{{ route('evidence.attachment.download', [$evidence->id, $attachment->id]) }}" class="inline-flex min-h-9 items-center justify-center rounded-lg border border-slate-300 bg-[#F8FAFC] px-3 text-sm font-medium text-slate-600 transition hover:bg-[#EEF3F8]">
                                    Download
                                </a>


                                @if (
                                    $evidence->record_status === 'Valid' &&
                                    $user->hasPermission('evidence.manage_attachment') &&
                                    $canMutate
                                )

                                    <form action="{{ route('evidence.attachment.destroy', [$evidence->id, $attachment->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" onclick="return confirm('Hapus attachment ini?')" class="inline-flex min-h-9 items-center justify-center rounded-lg border border-rose-200 bg-[#F8FAFC] px-3 text-sm font-medium text-rose-600 transition hover:bg-rose-50">
                                            Hapus
                                        </button>
                                    </form>

                                @endif

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="5" class="px-5 py-10 text-center">

                            <div class="mx-auto max-w-sm">
                                <p class="text-sm font-semibold text-slate-600">Belum ada attachment.</p>
                                <p class="mt-1 text-xs text-slate-400">Belum ada file yang terhubung dengan evidence ini.</p>
                            </div>

                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    {{-- ATTACHMENT FORM --}}
    @if (
        $evidence->record_status === 'Valid' &&
        $user->hasPermission('evidence.manage_attachment') &&
        $canMutate
    )

        <div id="attachment-form" class="border-t border-slate-200 bg-[#EEF3F8]/60 p-5" hidden>

            <h3 class="mb-4 text-base font-bold text-[#0B1F3A]">Tambah Attachment</h3>

            <form action="{{ route('evidence.attachment.store', $evidence->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="max-w-2xl">
                    <label for="attachment" class="mb-2 block text-sm font-semibold text-slate-700">Pilih File</label>

                    <input type="file" name="attachment" id="attachment" required class="block w-full cursor-pointer rounded-lg border border-slate-300 bg-[#F8FAFC] text-sm text-slate-500 file:mr-4 file:border-0 file:border-r file:border-slate-200 file:bg-[#EEF3F8] file:px-4 file:py-3 file:text-sm file:font-semibold file:text-slate-700 hover:file:bg-slate-100">
                </div>


                <div class="mt-5 flex flex-wrap gap-3">

                    <button type="submit" class="inline-flex min-h-10 items-center justify-center rounded-lg bg-[#2F80ED] px-4 text-sm font-semibold text-white transition hover:bg-blue-600">
                        Upload Attachment
                    </button>

                    <button type="button" data-toggle-form="attachment-form" class="inline-flex min-h-10 items-center justify-center rounded-lg border border-slate-300 bg-[#F8FAFC] px-4 text-sm font-medium text-slate-600 transition hover:bg-[#EEF3F8]">
                        Batal
                    </button>

                </div>

            </form>

        </div>

    @endif

</div>


{{-- HISTORY --}}
<div class="mb-6 overflow-hidden rounded-xl border border-slate-200 bg-[#F8FAFC]">

    <div class="border-b border-slate-200 px-5 py-5">
        <h2 class="text-lg font-bold text-[#0B1F3A]">Riwayat Evidence</h2>
        <p class="mt-1 text-xs text-slate-400">Riwayat perubahan yang terjadi pada evidence.</p>
    </div>


    <div class="overflow-x-auto">

        <table class="w-full border-collapse">

            <thead class="bg-[#EEF3F8]">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Waktu</th>
                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Activity</th>
                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">User</th>
                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Notes</th>
                </tr>
            </thead>


            <tbody class="divide-y divide-slate-200">

                @forelse ($evidence->evidenceHistory as $history)

                    <tr class="transition hover:bg-[#EEF3F8]">

                        <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-500">
                            {{ $history->created_at ? $history->created_at->format('d M Y, H:i') : '-' }}
                        </td>

                        <td class="px-5 py-4 text-sm font-semibold text-[#0B1F3A]">
                            {{ $history->activity }}
                        </td>

                        <td class="px-5 py-4 text-sm text-slate-600">
                            {{ $history->user?->name ?? '-' }}
                        </td>

                        <td class="px-5 py-4 text-sm text-slate-500">
                            {{ $history->notes ?? '-' }}
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="4" class="px-5 py-10 text-center text-sm text-slate-400">
                            Belum ada riwayat evidence.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>


{{-- DANGER ZONE --}}
@if (
    $evidence->record_status === 'Valid' &&
    $user->hasPermission('evidence.void') &&
    $canMutate
)

    <div class="overflow-hidden rounded-xl border border-rose-200 bg-rose-50/50">

        <div class="flex flex-col gap-4 p-5 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <div class="mb-2 flex items-center gap-2 text-rose-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-1.5a9 9 0 1 1-18 0 9 9 0 0 1 18 0ZM12 16.5h.008v.008H12V16.5Z" />
                    </svg>

                    <h2 class="text-lg font-bold">Danger Zone</h2>
                </div>

                <h3 class="text-sm font-semibold text-rose-800">Void Evidence</h3>

                <p class="mt-1 max-w-2xl text-sm leading-6 text-rose-700/80">
                    Gunakan aksi ini jika record evidence dinyatakan tidak valid. Evidence yang sudah di-void tidak dapat diedit kembali.
                </p>
            </div>


            <button type="button" data-toggle-form="void-form" data-default-text="Void Evidence" class="inline-flex min-h-10 shrink-0 items-center justify-center rounded-lg bg-rose-600 px-4 text-sm font-semibold text-white transition hover:bg-rose-700">
                Void Evidence
            </button>

        </div>


        <div id="void-form" class="border-t border-rose-200 bg-[#F8FAFC]/50 p-5" hidden>

            <form action="{{ route('evidence.void', $evidence->id) }}" method="POST" class="max-w-2xl">
                @csrf
                @method('PATCH')

                <label for="reason" class="mb-2 block text-sm font-semibold text-rose-800">Alasan Void</label>

                <textarea name="reason" id="reason" rows="5" required placeholder="Jelaskan alasan evidence dinyatakan tidak valid..." class="w-full resize-y rounded-lg border border-rose-200 bg-[#F8FAFC] px-3 py-3 text-sm leading-6 text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-rose-400 focus:ring-4 focus:ring-rose-100">{{ old('reason') }}</textarea>


                <div class="mt-4 flex flex-wrap gap-3">

                    <button type="submit" onclick="return confirm('Yakin ingin melakukan void pada evidence ini?')" class="inline-flex min-h-10 items-center justify-center rounded-lg bg-rose-600 px-4 text-sm font-semibold text-white transition hover:bg-rose-700">
                        Konfirmasi Void
                    </button>

                    <button type="button" data-toggle-form="void-form" class="inline-flex min-h-10 items-center justify-center rounded-lg border border-slate-300 bg-[#F8FAFC] px-4 text-sm font-medium text-slate-600 transition hover:bg-[#EEF3F8]">
                        Batal
                    </button>

                </div>

            </form>

        </div>

    </div>


@elseif ($evidence->record_status === 'Voided')

    <div class="rounded-xl border border-rose-200 bg-rose-50 p-5">

        <div class="flex items-start gap-3">

            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-rose-100 text-rose-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-1.5a9 9 0 1 1-18 0 9 9 0 0 1 18 0ZM12 16.5h.008v.008H12V16.5Z" />
                </svg>
            </div>

            <div>
                <p class="font-bold text-rose-800">Evidence ini sudah Voided.</p>
                <p class="mt-1 text-sm text-rose-600">Record evidence tidak dapat diedit kembali.</p>
            </div>

        </div>

    </div>

@endif

@endsection


@push('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-toggle-form]').forEach(function (button) {
        button.addEventListener('click', function () {
            const formId = button.dataset.toggleForm;
            const target = document.getElementById(formId);

            if (!target) return;

            const isHidden = target.hasAttribute('hidden');

            if (isHidden) {
                target.removeAttribute('hidden');

                if (button.dataset.defaultText) {
                    button.textContent = 'Tutup Form';
                }

                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'nearest'
                });
            } else {
                target.setAttribute('hidden', '');

                const opener = document.querySelector('[data-toggle-form="' + formId + '"][data-default-text]');

                if (opener) {
                    opener.textContent = opener.dataset.defaultText;
                }
            }
        });
    });
});
</script>

@endpush