@extends('layouts.app')

@section('title', 'Detail Kasus')

@section('content')

@php
    $user = auth()->user();
    $isAdmin = $user->roles->contains('name', 'admin');
    $officerId = $user->officer?->id;

    $isAssigned = $officerId
        ? $case->officers->contains(function ($officer) use ($officerId) {
            return $officer->id === $officerId && $officer->pivot->status === 'Active';
        })
        : false;

    $canMutateCase = $isAdmin || $isAssigned;

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

    $openedForm = old('form_type');
@endphp


{{-- HEADER --}}
<div class="mb-7 flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">

    <div>
        <div class="mb-2 flex flex-wrap items-center gap-2">
            <h1 class="font-mono text-3xl font-bold text-[#0B1F3A]">{{ $case->case_number }}</h1>
            <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold {{ $statusClass }}">{{ $case->status }}</span>
            <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold {{ $priorityClass }}">{{ $case->priority }}</span>
        </div>

        <p class="text-sm text-slate-500">{{ $case->title }}</p>
    </div>


    <div class="flex flex-wrap gap-2">

        <a href="{{ route('cases.index') }}" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-lg border border-slate-300 bg-[#F8FAFC] px-4 text-sm font-medium text-slate-600 transition hover:bg-[#EEF3F8]">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
            Kembali
        </a>


        @if ($user->hasPermission('case.view_all'))

            <a href="{{ route('cases.summary.pdf', $case->id) }}" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-lg border border-slate-300 bg-[#F8FAFC] px-4 text-sm font-medium text-slate-600 transition hover:bg-[#EEF3F8]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625A3.375 3.375 0 0 0 16.125 8.25h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5A3.375 3.375 0 0 0 10.125 2.25H8.25m0 12.75h7.5m-7.5 3h4.5M10.5 2.25H5.625A1.875 1.875 0 0 0 3.75 4.125v15.75a1.875 1.875 0 0 0 1.875 1.875h12.75a1.875 1.875 0 0 0 1.875-1.875V11.25L10.5 2.25Z" />
                </svg>
                Download Summary
            </a>

        @endif


        @if ($user->hasPermission('case.update') && $canMutateCase)

            <a href="{{ route('cases.edit', $case->id) }}" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-lg bg-[#2F80ED] px-4 text-sm font-semibold text-white transition hover:bg-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.862 4.487Z" />
                </svg>
                Edit Case
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


{{-- CASE OVERVIEW --}}
<div class="mb-6 overflow-hidden rounded-xl border border-slate-200 bg-[#F8FAFC]">

    <div class="flex flex-col gap-3 border-b border-slate-200 px-5 py-5 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h2 class="text-lg font-bold text-[#0B1F3A]">Informasi Kasus</h2>
            <p class="mt-1 text-xs text-slate-400">Ringkasan informasi utama kasus investigasi.</p>
        </div>

        <div class="flex flex-wrap gap-2">
            <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold {{ $statusClass }}">{{ $case->status }}</span>
            <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold {{ $priorityClass }}">{{ $case->priority }}</span>
        </div>

    </div>


    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4">

        <div class="border-b border-slate-100 px-5 py-4 sm:border-r lg:border-b-0">
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400">Status</p>
            <p class="text-sm font-semibold text-slate-700">{{ $case->status }}</p>
        </div>

        <div class="border-b border-slate-100 px-5 py-4 lg:border-r lg:border-b-0">
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400">Priority</p>
            <p class="text-sm font-semibold text-slate-700">{{ $case->priority }}</p>
        </div>

        <div class="border-b border-slate-100 px-5 py-4 sm:border-r sm:border-b-0">
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400">Opened At</p>
            <p class="text-sm font-semibold text-slate-700">{{ $case->opened_at ? \Carbon\Carbon::parse($case->opened_at)->format('d M Y, H:i') : '-' }}</p>
        </div>

        <div class="px-5 py-4">
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400">Closed At</p>
            <p class="text-sm font-semibold text-slate-700">{{ $case->closed_at ? \Carbon\Carbon::parse($case->closed_at)->format('d M Y, H:i') : '-' }}</p>
        </div>

    </div>


    <div class="border-t border-slate-100 px-5 py-5">
        <p class="mb-2 text-xs font-semibold uppercase tracking-wide text-slate-400">Description</p>
        <p class="whitespace-pre-line text-sm leading-7 text-slate-600">{{ $case->description }}</p>
    </div>

</div>


{{-- COMPLAINT ASAL --}}
<div class="mb-6 overflow-hidden rounded-xl border border-slate-200 bg-[#F8FAFC]">

    <div class="flex flex-col gap-3 border-b border-slate-200 px-5 py-5 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h2 class="text-lg font-bold text-[#0B1F3A]">Complaint Asal</h2>
            <p class="mt-1 text-xs text-slate-400">Pengaduan masyarakat yang menjadi dasar kasus ini.</p>
        </div>


        @if ($case->complaint)

            <a href="{{ route('complaint.show', $case->complaint->id) }}" class="inline-flex min-h-9 items-center justify-center rounded-lg border border-slate-300 bg-[#F8FAFC] px-3 text-sm font-medium text-slate-600 transition hover:bg-[#EEF3F8]">
                Lihat Complaint
            </a>

        @endif

    </div>


    @if ($case->complaint)

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4">

            <div class="border-b border-slate-100 px-5 py-4 sm:border-r lg:border-b-0">
                <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400">Judul</p>
                <p class="text-sm font-semibold text-slate-700">{{ $case->complaint->title }}</p>
            </div>

            <div class="border-b border-slate-100 px-5 py-4 lg:border-r lg:border-b-0">
                <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400">Pelapor</p>
                <p class="text-sm font-semibold text-slate-700">{{ $case->complaint->user?->name ?? '-' }}</p>
            </div>

            <div class="border-b border-slate-100 px-5 py-4 sm:border-r sm:border-b-0">
                <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400">Lokasi</p>
                <p class="text-sm font-semibold text-slate-700">{{ $case->complaint->location ?? '-' }}</p>
            </div>

            <div class="px-5 py-4">
                <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400">Tanggal Kejadian</p>
                <p class="text-sm font-semibold text-slate-700">{{ $case->complaint->incident_date ?? '-' }}</p>
            </div>

        </div>


        {{-- COMPLAINT ATTACHMENTS --}}
        <div class="border-t border-slate-200">

            <div class="bg-[#EEF3F8]/60 px-5 py-3">
                <h3 class="text-sm font-bold text-[#0B1F3A]">Complaint Attachments</h3>
            </div>


            <div class="divide-y divide-slate-100">

                @forelse ($case->complaint->attachments as $attachment)

                    <div class="flex flex-col gap-3 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">

                        <div class="flex min-w-0 items-center gap-3">

                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739 10.682 20.43a4.5 4.5 0 0 1-6.364-6.364l9.546-9.546a3 3 0 0 1 4.243 4.243" />
                                </svg>
                            </div>

                            <div class="min-w-0">
                                <p class="truncate text-sm font-semibold text-slate-700">{{ $attachment->file_name }}</p>
                                <p class="mt-1 text-xs text-slate-400">{{ $attachment->mime_type }}</p>
                            </div>

                        </div>


                        <div class="flex flex-wrap gap-2">

                            <a href="{{ route('complaint.attachments.show', [$case->complaint->id, $attachment->id]) }}" target="_blank" rel="noopener noreferrer" class="inline-flex min-h-9 items-center justify-center rounded-lg border border-slate-300 bg-[#F8FAFC] px-3 text-sm font-medium text-slate-600 transition hover:bg-[#EEF3F8]">
                                Lihat
                            </a>

                            <a href="{{ route('complaint.attachments.download', [$case->complaint->id, $attachment->id]) }}" class="inline-flex min-h-9 items-center justify-center rounded-lg border border-slate-300 bg-[#F8FAFC] px-3 text-sm font-medium text-slate-600 transition hover:bg-[#EEF3F8]">
                                Download
                            </a>

                        </div>

                    </div>

                @empty

                    <div class="px-5 py-8 text-center text-sm text-slate-400">
                        Tidak ada attachment.
                    </div>

                @endforelse

            </div>

        </div>

    @else

        <div class="px-5 py-10 text-center text-sm text-slate-400">
            Complaint tidak tersedia.
        </div>

    @endif

</div>


{{-- OFFICERS --}}
<div class="mb-6 overflow-hidden rounded-xl border border-slate-200 bg-[#F8FAFC]">

    <div class="flex flex-col gap-4 border-b border-slate-200 px-5 py-5 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h2 class="text-lg font-bold text-[#0B1F3A]">Officer Ditugaskan</h2>
            <p class="mt-1 text-xs text-slate-400">Police Officer yang ditugaskan menangani kasus ini.</p>
        </div>


        @if ($user->hasPermission('case.assign_officer'))

            <button type="button" data-toggle-form="officer-form" data-default-text="+ Assign Officer" class="inline-flex min-h-10 items-center justify-center rounded-lg bg-[#2F80ED] px-4 text-sm font-semibold text-white transition hover:bg-blue-600">
                {{ $openedForm === 'officer' ? 'Tutup Form' : '+ Assign Officer' }}
            </button>

        @endif

    </div>


    <div class="overflow-x-auto">

        <table class="w-full border-collapse">

            <thead class="bg-[#EEF3F8]">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Officer</th>
                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Status Police</th>
                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Assignment</th>
                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Assigned At</th>

                    @if ($user->hasPermission('case.assign_officer'))
                        <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Action</th>
                    @endif
                </tr>
            </thead>


            <tbody class="divide-y divide-slate-200">

                @forelse ($case->officers as $officer)

                    <tr class="transition hover:bg-[#EEF3F8]">

                        <td class="px-5 py-4">
                            <a href="{{ route('police.show', $officer->id) }}" class="text-sm font-semibold text-[#0B1F3A] transition hover:text-[#2F80ED] hover:underline">
                                {{ $officer->user?->name ?? '-' }}
                            </a>
                        </td>


                        <td class="px-5 py-4">
                            <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold {{ $officer->status === 'Active' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-700' }}">
                                {{ $officer->status }}
                            </span>
                        </td>


                        <td class="px-5 py-4">
                            <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold {{ $officer->pivot->status === 'Active' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-700' }}">
                                {{ $officer->pivot->status }}
                            </span>
                        </td>


                        <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-500">
                            {{ $officer->pivot->assigned_at ? \Carbon\Carbon::parse($officer->pivot->assigned_at)->format('d M Y, H:i') : '-' }}
                        </td>


                        @if ($user->hasPermission('case.assign_officer'))

                            <td class="px-5 py-4">

                                <form method="POST" action="{{ route('case.officers.update', [$case->id, $officer->id]) }}">
                                    @csrf
                                    @method('PATCH')

                                    @if ($officer->pivot->status === 'Active')

                                        <input type="hidden" name="status" value="Inactive">

                                        <button type="submit" class="inline-flex min-h-9 items-center justify-center rounded-lg bg-rose-600 px-3 text-sm font-semibold text-white transition hover:bg-rose-700">
                                            Set Inactive
                                        </button>

                                    @else

                                        <input type="hidden" name="status" value="Active">

                                        <button type="submit" class="inline-flex min-h-9 items-center justify-center rounded-lg bg-emerald-600 px-3 text-sm font-semibold text-white transition hover:bg-emerald-700">
                                            Set Active
                                        </button>

                                    @endif

                                </form>

                            </td>

                        @endif

                    </tr>

                @empty

                    <tr>
                        <td colspan="{{ $user->hasPermission('case.assign_officer') ? 5 : 4 }}" class="px-5 py-10 text-center text-sm text-slate-400">
                            Belum ada officer yang ditugaskan.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    {{-- ASSIGN OFFICER FORM --}}
    @if ($user->hasPermission('case.assign_officer'))

        <div id="officer-form" class="border-t border-slate-200 bg-[#EEF3F8]/60 p-5" @if ($openedForm !== 'officer') hidden @endif>

            <h3 class="mb-4 text-base font-bold text-[#0B1F3A]">Assign Officer</h3>


            <form method="POST" action="{{ route('case.officers.store', $case->id) }}" class="max-w-2xl">
                @csrf

                <input type="hidden" name="form_type" value="officer">


                <label for="police_officer_id" class="mb-2 block text-sm font-semibold text-slate-700">Police Officer</label>

                <select name="police_officer_id" id="police_officer_id" required class="h-11 w-full rounded-lg border border-slate-300 bg-[#F8FAFC] px-3 text-sm text-slate-700 outline-none transition focus:border-[#2F80ED] focus:ring-4 focus:ring-blue-100">
                    <option value="">Pilih Officer</option>

                    @foreach ($police as $officer)
                        <option value="{{ $officer->id }}" @selected($openedForm === 'officer' && old('police_officer_id') == $officer->id)>
                            {{ $officer->user?->name ?? 'Officer #' . $officer->id }}
                        </option>
                    @endforeach
                </select>


                <div class="mt-5 flex flex-wrap gap-3">

                    <button type="submit" class="inline-flex min-h-10 items-center justify-center rounded-lg bg-[#2F80ED] px-4 text-sm font-semibold text-white transition hover:bg-blue-600">
                        Assign Officer
                    </button>

                    <button type="button" data-toggle-form="officer-form" class="inline-flex min-h-10 items-center justify-center rounded-lg border border-slate-300 bg-[#F8FAFC] px-4 text-sm font-medium text-slate-600 transition hover:bg-[#EEF3F8]">
                        Batal
                    </button>

                </div>

            </form>

        </div>

    @endif

</div>


{{-- SUSPECTS --}}
<div class="mb-6 overflow-hidden rounded-xl border border-slate-200 bg-[#F8FAFC]">

    <div class="flex flex-col gap-4 border-b border-slate-200 px-5 py-5 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h2 class="text-lg font-bold text-[#0B1F3A]">Suspects</h2>
            <p class="mt-1 text-xs text-slate-400">Daftar suspect yang terkait dengan kasus.</p>
        </div>


        @if ($user->hasPermission('suspect.create') && $canMutateCase)

            <button type="button" data-toggle-form="suspect-form" data-default-text="+ Tambah Suspect" class="inline-flex min-h-10 items-center justify-center rounded-lg bg-[#2F80ED] px-4 text-sm font-semibold text-white transition hover:bg-blue-600">
                {{ $openedForm === 'suspect' ? 'Tutup Form' : '+ Tambah Suspect' }}
            </button>

        @endif

    </div>


    <div class="overflow-x-auto">

        <table class="w-full border-collapse">

            <thead class="bg-[#EEF3F8]">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Name</th>
                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Identity Number</th>
                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Address</th>
                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Status</th>
                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Notes</th>
                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Action</th>
                </tr>
            </thead>


            <tbody class="divide-y divide-slate-200">

                @forelse ($case->suspects as $suspect)

                    @php
                        $suspectStatusClass = match ($suspect->status) {
                            'identified' => 'bg-blue-100 text-blue-800',
                            'wanted' => 'bg-amber-100 text-amber-800',
                            'detained' => 'bg-rose-100 text-rose-800',
                            'released' => 'bg-emerald-100 text-emerald-800',
                            default => 'bg-slate-100 text-slate-700'
                        };
                    @endphp


                    <tr class="transition hover:bg-[#EEF3F8]">

                        <td class="px-5 py-4 text-sm font-semibold text-slate-700">{{ $suspect->name }}</td>

                        <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-500">{{ $suspect->identity_number ?? '-' }}</td>

                        <td class="px-5 py-4 text-sm text-slate-500">{{ $suspect->address }}</td>

                        <td class="px-5 py-4">
                            <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold {{ $suspectStatusClass }}">
                                {{ ucfirst($suspect->status) }}
                            </span>
                        </td>

                        <td class="px-5 py-4 text-sm text-slate-500">{{ $suspect->notes ?? '-' }}</td>


                        <td class="px-5 py-4">

                            <div class="flex flex-wrap gap-2">

                                @if ($user->hasPermission('suspect.view'))

                                    <a href="{{ route('suspect.show', $suspect->id) }}" class="inline-flex min-h-9 items-center justify-center rounded-lg border border-slate-300 bg-[#F8FAFC] px-3 text-sm font-medium text-slate-600 transition hover:bg-[#EEF3F8]">
                                        Detail
                                    </a>

                                @endif


                                @if ($user->hasPermission('suspect.update') && $canMutateCase)

                                    <a href="{{ route('suspect.edit', $suspect->id) }}" class="inline-flex min-h-9 items-center justify-center rounded-lg bg-[#2F80ED] px-3 text-sm font-semibold text-white transition hover:bg-blue-600">
                                        Edit
                                    </a>

                                @endif

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="6" class="px-5 py-10 text-center text-sm text-slate-400">
                            Belum ada suspect pada kasus ini.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    {{-- TAMBAH SUSPECT FORM --}}
    @if ($user->hasPermission('suspect.create') && $canMutateCase)

        <div id="suspect-form" class="border-t border-slate-200 bg-[#EEF3F8]/60 p-5" @if ($openedForm !== 'suspect') hidden @endif>

            <h3 class="mb-4 text-base font-bold text-[#0B1F3A]">Tambah Suspect</h3>


            <form action="{{ route('suspect.store', $case->id) }}" method="POST">
                @csrf

                <input type="hidden" name="form_type" value="suspect">


                <div class="grid gap-5 md:grid-cols-2">

                    <div>
                        <label for="suspect_name" class="mb-2 block text-sm font-semibold text-slate-700">Name</label>
                        <input type="text" name="name" id="suspect_name" value="{{ $openedForm === 'suspect' ? old('name') : '' }}" required class="h-11 w-full rounded-lg border border-slate-300 bg-[#F8FAFC] px-3 text-sm text-slate-700 outline-none transition focus:border-[#2F80ED] focus:ring-4 focus:ring-blue-100">
                    </div>


                    <div>
                        <label for="suspect_identity_number" class="mb-2 block text-sm font-semibold text-slate-700">Identity Number</label>
                        <input type="text" name="identity_number" id="suspect_identity_number" value="{{ $openedForm === 'suspect' ? old('identity_number') : '' }}" class="h-11 w-full rounded-lg border border-slate-300 bg-[#F8FAFC] px-3 text-sm text-slate-700 outline-none transition focus:border-[#2F80ED] focus:ring-4 focus:ring-blue-100">
                    </div>


                    <div>
                        <label for="suspect_address" class="mb-2 block text-sm font-semibold text-slate-700">Address</label>
                        <input type="text" name="address" id="suspect_address" value="{{ $openedForm === 'suspect' ? old('address') : '' }}" required class="h-11 w-full rounded-lg border border-slate-300 bg-[#F8FAFC] px-3 text-sm text-slate-700 outline-none transition focus:border-[#2F80ED] focus:ring-4 focus:ring-blue-100">
                    </div>


                    <div>
                        <label for="suspect_status" class="mb-2 block text-sm font-semibold text-slate-700">Status</label>

                        <select name="status" id="suspect_status" required class="h-11 w-full rounded-lg border border-slate-300 bg-[#F8FAFC] px-3 text-sm text-slate-700 outline-none transition focus:border-[#2F80ED] focus:ring-4 focus:ring-blue-100">
                            @foreach (['identified', 'wanted', 'detained', 'released'] as $status)
                                <option value="{{ $status }}" @selected(($openedForm === 'suspect' ? old('status', 'identified') : 'identified') === $status)>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    <div class="md:col-span-2">
                        <label for="suspect_notes" class="mb-2 block text-sm font-semibold text-slate-700">Notes</label>

                        <textarea name="notes" id="suspect_notes" rows="4" class="w-full resize-y rounded-lg border border-slate-300 bg-[#F8FAFC] px-3 py-3 text-sm leading-6 text-slate-700 outline-none transition focus:border-[#2F80ED] focus:ring-4 focus:ring-blue-100">{{ $openedForm === 'suspect' ? old('notes') : '' }}</textarea>
                    </div>

                </div>


                <div class="mt-5 flex flex-wrap gap-3">

                    <button type="submit" class="inline-flex min-h-10 items-center justify-center rounded-lg bg-[#2F80ED] px-4 text-sm font-semibold text-white transition hover:bg-blue-600">
                        Simpan Suspect
                    </button>

                    <button type="button" data-toggle-form="suspect-form" class="inline-flex min-h-10 items-center justify-center rounded-lg border border-slate-300 bg-[#F8FAFC] px-4 text-sm font-medium text-slate-600 transition hover:bg-[#EEF3F8]">
                        Batal
                    </button>

                </div>

            </form>

        </div>

    @endif

</div>


{{-- EVIDENCES --}}
<div class="mb-6 overflow-hidden rounded-xl border border-slate-200 bg-[#F8FAFC]">

    <div class="flex flex-col gap-4 border-b border-slate-200 px-5 py-5 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h2 class="text-lg font-bold text-[#0B1F3A]">Evidences</h2>
            <p class="mt-1 text-xs text-slate-400">Barang bukti yang terdaftar pada kasus ini.</p>
        </div>


        @if ($user->hasPermission('evidence.create') && $canMutateCase)

            <button type="button" data-toggle-form="evidence-form" data-default-text="+ Tambah Evidence" class="inline-flex min-h-10 items-center justify-center rounded-lg bg-[#2F80ED] px-4 text-sm font-semibold text-white transition hover:bg-blue-600">
                {{ $openedForm === 'evidence' ? 'Tutup Form' : '+ Tambah Evidence' }}
            </button>

        @endif

    </div>


    <div class="overflow-x-auto">

        <table class="w-full border-collapse">

            <thead class="bg-[#EEF3F8]">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Evidence Code</th>
                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Name</th>
                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Category</th>
                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Storage Location</th>
                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Status</th>
                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Record Status</th>
                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Action</th>
                </tr>
            </thead>


            <tbody class="divide-y divide-slate-200">

                @forelse ($case->evidences as $evidence)

                    @php
                        $evidenceStatusClass = match ($evidence->status) {
                            'Stored' => 'bg-blue-100 text-blue-800',
                            'Borrowed' => 'bg-amber-100 text-amber-800',
                            'Returned' => 'bg-emerald-100 text-emerald-800',
                            'Destroyed' => 'bg-rose-100 text-rose-800',
                            default => 'bg-slate-100 text-slate-700'
                        };
                    @endphp


                    <tr class="transition hover:bg-[#EEF3F8]">

                        <td class="whitespace-nowrap px-5 py-4 font-mono text-sm font-bold text-[#0B1F3A]">{{ $evidence->evidence_code }}</td>

                        <td class="px-5 py-4 text-sm font-semibold text-slate-700">{{ $evidence->name }}</td>

                        <td class="px-5 py-4 text-sm text-slate-500">{{ $evidence->category?->name ?? '-' }}</td>

                        <td class="px-5 py-4 text-sm text-slate-500">{{ $evidence->storage_location }}</td>

                        <td class="px-5 py-4">
                            <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold {{ $evidenceStatusClass }}">
                                {{ $evidence->status }}
                            </span>
                        </td>

                        <td class="px-5 py-4">
                            <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold {{ $evidence->record_status === 'Valid' ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                                {{ $evidence->record_status }}
                            </span>
                        </td>


                        <td class="px-5 py-4">

                            <div class="flex flex-wrap gap-2">

                                @if ($user->hasPermission('evidence.view'))

                                    <a href="{{ route('evidence.show', $evidence->id) }}" class="inline-flex min-h-9 items-center justify-center rounded-lg border border-slate-300 bg-[#F8FAFC] px-3 text-sm font-medium text-slate-600 transition hover:bg-[#EEF3F8]">
                                        Detail
                                    </a>

                                @endif


                                @if ($evidence->record_status === 'Valid' && $user->hasPermission('evidence.update') && $canMutateCase)

                                    <a href="{{ route('evidence.edit', $evidence->id) }}" class="inline-flex min-h-9 items-center justify-center rounded-lg bg-[#2F80ED] px-3 text-sm font-semibold text-white transition hover:bg-blue-600">
                                        Edit
                                    </a>

                                @endif

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="7" class="px-5 py-10 text-center text-sm text-slate-400">
                            Belum ada evidence.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    {{-- TAMBAH EVIDENCE FORM --}}
    @if ($user->hasPermission('evidence.create') && $canMutateCase)

        <div id="evidence-form" class="border-t border-slate-200 bg-[#EEF3F8]/60 p-5" @if ($openedForm !== 'evidence') hidden @endif>

            <h3 class="mb-4 text-base font-bold text-[#0B1F3A]">Tambah Evidence</h3>


            <form action="{{ route('evidence.store', $case->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="form_type" value="evidence">


                <div class="grid gap-5 md:grid-cols-2">

                    <div>
                        <label for="evidence_code" class="mb-2 block text-sm font-semibold text-slate-700">Evidence Code</label>

                        <input type="text" name="evidence_code" id="evidence_code" value="{{ $openedForm === 'evidence' ? old('evidence_code') : '' }}" required class="h-11 w-full rounded-lg border border-slate-300 bg-[#F8FAFC] px-3 font-mono text-sm text-slate-700 outline-none transition focus:border-[#2F80ED] focus:ring-4 focus:ring-blue-100">
                    </div>


                    <div>
                        <label for="evidence_category_id" class="mb-2 block text-sm font-semibold text-slate-700">Category</label>

                        <select name="evidence_category_id" id="evidence_category_id" required class="h-11 w-full rounded-lg border border-slate-300 bg-[#F8FAFC] px-3 text-sm text-slate-700 outline-none transition focus:border-[#2F80ED] focus:ring-4 focus:ring-blue-100">
                            <option value="">Pilih Category</option>

                            @foreach ($evidenceCategories as $category)
                                <option value="{{ $category->id }}" @selected($openedForm === 'evidence' && old('evidence_category_id') == $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    <div>
                        <label for="evidence_name" class="mb-2 block text-sm font-semibold text-slate-700">Evidence Name</label>

                        <input type="text" name="name" id="evidence_name" value="{{ $openedForm === 'evidence' ? old('name') : '' }}" required class="h-11 w-full rounded-lg border border-slate-300 bg-[#F8FAFC] px-3 text-sm text-slate-700 outline-none transition focus:border-[#2F80ED] focus:ring-4 focus:ring-blue-100">
                    </div>


                    <div>
                        <label for="storage_location" class="mb-2 block text-sm font-semibold text-slate-700">Storage Location</label>

                        <input type="text" name="storage_location" id="storage_location" value="{{ $openedForm === 'evidence' ? old('storage_location') : '' }}" required class="h-11 w-full rounded-lg border border-slate-300 bg-[#F8FAFC] px-3 text-sm text-slate-700 outline-none transition focus:border-[#2F80ED] focus:ring-4 focus:ring-blue-100">
                    </div>


                    <div class="md:col-span-2">
                        <label for="evidence_description" class="mb-2 block text-sm font-semibold text-slate-700">Description</label>

                        <textarea name="description" id="evidence_description" rows="4" class="w-full resize-y rounded-lg border border-slate-300 bg-[#F8FAFC] px-3 py-3 text-sm leading-6 text-slate-700 outline-none transition focus:border-[#2F80ED] focus:ring-4 focus:ring-blue-100">{{ $openedForm === 'evidence' ? old('description') : '' }}</textarea>
                    </div>


                    <div class="md:col-span-2">
                        <label for="evidence_attachments" class="mb-2 block text-sm font-semibold text-slate-700">Evidence Attachments</label>

                        <input type="file" name="attachments[]" id="evidence_attachments" multiple class="block w-full cursor-pointer rounded-lg border border-slate-300 bg-[#F8FAFC] text-sm text-slate-500 file:mr-4 file:border-0 file:border-r file:border-slate-200 file:bg-[#EEF3F8] file:px-4 file:py-3 file:text-sm file:font-semibold file:text-slate-700 hover:file:bg-slate-100">

                        <p class="mt-2 text-xs text-slate-400">Bisa memilih lebih dari satu file.</p>
                    </div>

                </div>


                <div class="mt-5 flex flex-wrap gap-3">

                    <button type="submit" class="inline-flex min-h-10 items-center justify-center rounded-lg bg-[#2F80ED] px-4 text-sm font-semibold text-white transition hover:bg-blue-600">
                        Simpan Evidence
                    </button>

                    <button type="button" data-toggle-form="evidence-form" class="inline-flex min-h-10 items-center justify-center rounded-lg border border-slate-300 bg-[#F8FAFC] px-4 text-sm font-medium text-slate-600 transition hover:bg-[#EEF3F8]">
                        Batal
                    </button>

                </div>

            </form>

        </div>

    @endif

</div>


{{-- CASE HISTORY --}}
<div class="overflow-hidden rounded-xl border border-slate-200 bg-[#F8FAFC]">

    <div class="border-b border-slate-200 px-5 py-5">
        <h2 class="text-lg font-bold text-[#0B1F3A]">Riwayat Kasus</h2>
        <p class="mt-1 text-xs text-slate-400">Aktivitas yang tercatat selama proses investigasi.</p>
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

                @forelse ($case->histories as $history)

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
                            Belum ada riwayat kasus.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

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

                const opener = document.querySelector('[data-toggle-form="' + formId + '"][data-default-text]');

                if (opener) {
                    opener.textContent = 'Tutup Form';
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