@extends('layouts.app')

@section('title', 'Barang Bukti')

@section('content')

@php
    $user = auth()->user();
    $isAdmin = $user->roles->contains('name', 'admin');
@endphp


{{-- HEADER --}}
<div class="mb-7">
    <h1 class="mb-1 text-3xl font-bold text-[#0B1F3A]">Barang Bukti</h1>
    <p class="text-sm text-slate-500">Daftar barang bukti dari seluruh kasus investigasi.</p>
</div>


{{-- EVIDENCE LIST --}}
<div class="overflow-hidden rounded-xl border border-slate-200 bg-[#F8FAFC]">

    {{-- HEADER --}}
    <div class="border-b border-slate-200 px-5 py-5">
        <h2 class="text-lg font-bold text-[#0B1F3A]">Daftar Evidence</h2>
        <p class="mt-1 text-xs text-slate-400">Data barang bukti yang tercatat dalam sistem.</p>
    </div>


    {{-- TABLE --}}
    <div class="overflow-x-auto">

        <table class="w-full border-collapse">

            <thead class="bg-[#EEF3F8]">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">No</th>
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

                @forelse ($evidences as $evidence)

                    @php
                        $officerId = $user->officer?->id;

                        $isAssigned = false;

                        if ($officerId && $evidence->investigationCase) {
                            $isAssigned = $evidence->investigationCase->officers->contains(function ($officer) use ($officerId) {
                                return $officer->id === $officerId && $officer->pivot->status === 'Active';
                            });
                        }

                        $canEdit =
                            $evidence->record_status === 'Valid' &&
                            $user->hasPermission('evidence.update') &&
                            ($isAdmin || $isAssigned);

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


                    <tr class="transition hover:bg-[#EEF3F8]">

                        {{-- NO --}}
                        <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-500">
                            {{ $loop->iteration }}
                        </td>


                        {{-- CODE --}}
                        <td class="whitespace-nowrap px-5 py-4">
                            <span class="font-mono text-sm font-bold text-[#0B1F3A]">
                                {{ $evidence->evidence_code }}
                            </span>
                        </td>


                        {{-- NAME --}}
                        <td class="px-5 py-4">
                            <p class="max-w-[260px] truncate text-sm font-semibold text-slate-700">
                                {{ $evidence->name }}
                            </p>
                        </td>


                        {{-- CATEGORY --}}
                        <td class="px-5 py-4 text-sm text-slate-600">
                            {{ $evidence->category?->name ?? '-' }}
                        </td>


                        {{-- STORAGE LOCATION --}}
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-2 text-sm text-slate-600">

                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                </svg>

                                <span class="max-w-[220px] truncate">
                                    {{ $evidence->storage_location }}
                                </span>

                            </div>
                        </td>


                        {{-- PHYSICAL STATUS --}}
                        <td class="px-5 py-4">
                            <span class="inline-flex whitespace-nowrap rounded-full px-3 py-1 text-xs font-bold {{ $statusClass }}">
                                {{ $evidence->status }}
                            </span>
                        </td>


                        {{-- RECORD STATUS --}}
                        <td class="px-5 py-4">
                            <span class="inline-flex whitespace-nowrap rounded-full px-3 py-1 text-xs font-bold {{ $recordClass }}">
                                {{ $evidence->record_status }}
                            </span>
                        </td>


                        {{-- ACTION --}}
                        <td class="px-5 py-4">

                            <div class="flex flex-wrap gap-2">

                                <a href="{{ route('evidence.show', $evidence->id) }}" class="inline-flex min-h-9 items-center justify-center gap-2 rounded-lg border border-slate-300 bg-[#F8FAFC] px-3 text-sm font-medium text-slate-600 transition hover:bg-[#EEF3F8] hover:text-[#0B1F3A]">

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12 18 18.75 12 18.75 2.25 12 2.25 12Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>

                                    Detail
                                </a>


                                @if ($canEdit)

                                    <a href="{{ route('evidence.edit', $evidence->id) }}" class="inline-flex min-h-9 items-center justify-center gap-2 rounded-lg bg-[#2F80ED] px-3 text-sm font-semibold text-white transition hover:bg-blue-600">

                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.862 4.487Z" />
                                        </svg>

                                        Edit
                                    </a>

                                @endif

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="8" class="px-5 py-12 text-center">

                            <div class="mx-auto flex max-w-sm flex-col items-center">

                                <div class="mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-slate-400">

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5 12 3 3 7.5m18 0L12 12m9-4.5V16.5L12 21m0-9L3 7.5M12 12v9M3 7.5v9L12 21" />
                                    </svg>

                                </div>

                                <p class="text-sm font-semibold text-slate-600">
                                    Belum ada evidence.
                                </p>

                                <p class="mt-1 text-xs leading-5 text-slate-400">
                                    Barang bukti akan muncul setelah ditambahkan melalui kasus investigasi.
                                </p>

                            </div>

                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection