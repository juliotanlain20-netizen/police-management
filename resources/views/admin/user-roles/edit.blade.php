@extends('layouts.app')

@section('title', 'Manage User Roles')

@section('content')

@php
    $selectedRoles = old(
        'roles',
        $user->roles->pluck('id')->toArray()
    );

    $selectedRoles = array_map('strval', $selectedRoles);

    $isPoliceOfficer = (bool) $user->officer;
@endphp


{{-- HEADER --}}
<div class="mb-7 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">

    <div>
        <h1 class="mb-1 text-3xl font-bold text-[#0B1F3A]">Manage User Roles</h1>

        <p class="text-sm text-slate-500">
            Atur role yang dimiliki oleh
            <span class="font-semibold text-slate-700">{{ $user->name }}</span>.
        </p>
    </div>


    <a href="{{ route('user-role.index') }}" class="inline-flex min-h-10 items-center justify-center gap-2 self-start rounded-lg border border-slate-300 bg-[#F8FAFC] px-4 text-sm font-medium text-slate-600 transition hover:bg-[#EEF3F8] hover:text-[#0B1F3A]">
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


{{-- USER INFORMATION --}}
<div class="mb-6 overflow-hidden rounded-xl border border-slate-200 bg-[#F8FAFC]">

    <div class="flex flex-col gap-3 border-b border-slate-200 px-5 py-5 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h2 class="text-lg font-bold text-[#0B1F3A]">Informasi User</h2>
            <p class="mt-1 text-xs text-slate-400">Informasi akun yang sedang dikelola.</p>
        </div>


        @if ($isPoliceOfficer)

            <span class="inline-flex self-start rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-800">
                Police Officer
            </span>

        @else

            <span class="inline-flex self-start rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-700">
                Non Police
            </span>

        @endif

    </div>


    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4">

        <div class="border-b border-slate-100 px-5 py-4 sm:border-r lg:border-b-0">
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400">Nama</p>
            <p class="text-sm font-semibold text-slate-700">{{ $user->name }}</p>
        </div>


        <div class="border-b border-slate-100 px-5 py-4 lg:border-r lg:border-b-0">
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400">Email</p>
            <p class="break-all text-sm font-semibold text-slate-700">{{ $user->email }}</p>
        </div>


        <div class="border-b border-slate-100 px-5 py-4 sm:border-r sm:border-b-0">
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400">Phone</p>
            <p class="text-sm font-semibold text-slate-700">{{ $user->phone ?? '-' }}</p>
        </div>


        <div class="px-5 py-4">
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400">Police Officer</p>

            <p class="text-sm font-semibold {{ $isPoliceOfficer ? 'text-emerald-700' : 'text-slate-700' }}">
                {{ $isPoliceOfficer ? 'Yes' : 'No' }}
            </p>
        </div>

    </div>


    {{-- CURRENT ROLES --}}
    <div class="border-t border-slate-100 px-5 py-5">

        <p class="mb-3 text-xs font-semibold uppercase tracking-wide text-slate-400">Current Roles</p>


        <div class="flex flex-wrap gap-2">

            @forelse ($user->roles as $role)

                @php
                    $roleClass = match ($role->name) {
                        'admin' => 'bg-violet-100 text-violet-700',
                        'police' => 'bg-blue-100 text-blue-700',
                        'citizen' => 'bg-emerald-100 text-emerald-700',
                        'investigation_supervisor' => 'bg-amber-100 text-amber-700',
                        default => 'bg-slate-100 text-slate-700'
                    };
                @endphp

                <span class="inline-flex rounded-md px-2.5 py-1 text-xs font-semibold {{ $roleClass }}">
                    {{ ucwords(str_replace('_', ' ', $role->name)) }}
                </span>

            @empty

                <span class="text-sm italic text-slate-400">
                    User belum memiliki role.
                </span>

            @endforelse

        </div>

    </div>

</div>


{{-- NEEDS POLICE OFFICER --}}
@if (session('needs_officer'))

    <div class="mb-6 flex flex-col gap-4 rounded-xl border border-amber-200 border-l-4 border-l-amber-500 bg-amber-50 px-5 py-5 lg:flex-row lg:items-center lg:justify-between">

        <div class="flex items-start gap-3">

            <div class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-amber-100 text-amber-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-[18px] w-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0 3.75h.008v.008H12v-.008ZM10.34 3.75 2.57 17.25A1.5 1.5 0 0 0 3.87 19.5h16.26a1.5 1.5 0 0 0 1.3-2.25L13.66 3.75a1.5 1.5 0 0 0-2.6 0Z" />
                </svg>
            </div>


            <div>
                <h3 class="font-bold text-amber-900">User Belum Menjadi Police Officer</h3>

                <p class="mt-1 max-w-2xl text-sm leading-6 text-amber-800">
                    Role Police atau Investigation Supervisor hanya dapat diberikan setelah user terdaftar sebagai Police Officer.
                </p>
            </div>

        </div>


        <div class="flex shrink-0 flex-wrap gap-2">

            <a href="{{ route('user-role.edit', $user->id) }}" class="inline-flex min-h-10 items-center justify-center rounded-lg border border-amber-300 bg-[#F8FAFC] px-4 text-sm font-medium text-amber-800 transition hover:bg-amber-100">
                Batal
            </a>


            <a href="{{ route('police.create', ['user_id' => session('officer_user_id')]) }}" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-lg bg-[#2F80ED] px-4 text-sm font-semibold text-white transition hover:bg-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>

                Tambah Police Officer
            </a>

        </div>

    </div>

@endif


{{-- ROLE FORM --}}
<form action="{{ route('user-role.update', $user->id) }}" method="POST">
    @csrf
    @method('PATCH')


    <div class="overflow-hidden rounded-xl border border-slate-200 bg-[#F8FAFC]">

        <div class="border-b border-slate-200 px-5 py-5">
            <h2 class="text-lg font-bold text-[#0B1F3A]">Roles</h2>
            <p class="mt-1 text-xs text-slate-400">Pilih role yang akan dimiliki user.</p>
        </div>


        <div class="grid gap-4 p-5 md:grid-cols-2 xl:grid-cols-3">

            @foreach ($roles as $role)

                @php
                    $isSelected = in_array(
                        (string) $role->id,
                        $selectedRoles,
                        true
                    );

                    $isLockedPolice =
                        $role->name === 'police' &&
                        $isPoliceOfficer;

                    $isDisabledCitizen =
                        $role->name === 'citizen' &&
                        $isPoliceOfficer;

                    $roleDescription = match ($role->name) {
                        'citizen' => 'Akses dasar sebagai masyarakat.',
                        'police' => 'Akses operasional sebagai Police Officer.',
                        'admin' => 'Akses administrasi sistem.',
                        'investigation_supervisor' => 'Dapat melakukan assignment officer pada kasus.',
                        'author' => 'Role author.',
                        default => 'Role pengguna sistem.'
                    };
                @endphp


                {{-- POLICE LOCKED --}}
                @if ($isLockedPolice)

                    <input type="hidden" name="roles[]" value="{{ $role->id }}">

                    <label class="relative flex cursor-not-allowed items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 p-4">

                        <input type="checkbox" checked disabled class="mt-0.5 h-4 w-4 shrink-0 rounded border-emerald-300 text-emerald-600">

                        <span class="min-w-0 pr-16">

                            <strong class="block text-sm font-semibold text-emerald-900">
                                {{ ucwords(str_replace('_', ' ', $role->name)) }}
                            </strong>

                            <span class="mt-1 block text-xs leading-5 text-emerald-700">
                                Role ini dikelola melalui Police Management dan tidak dapat dicabut dari halaman ini.
                            </span>

                        </span>


                        <span class="absolute right-3 top-3 rounded-md bg-emerald-100 px-2 py-1 text-[10px] font-bold uppercase text-emerald-700">
                            Locked
                        </span>

                    </label>


                {{-- CITIZEN DISABLED --}}
                @elseif ($isDisabledCitizen)

                    <label class="relative flex cursor-not-allowed items-start gap-3 rounded-xl border border-slate-200 bg-[#EEF3F8] p-4 opacity-70">

                        <input type="checkbox" disabled class="mt-0.5 h-4 w-4 shrink-0 rounded border-slate-300">

                        <span class="min-w-0 pr-20">

                            <strong class="block text-sm font-semibold text-slate-600">
                                {{ ucwords(str_replace('_', ' ', $role->name)) }}
                            </strong>

                            <span class="mt-1 block text-xs leading-5 text-slate-500">
                                Role Citizen tidak tersedia untuk user yang sudah terdaftar sebagai Police Officer.
                            </span>

                        </span>


                        <span class="absolute right-3 top-3 rounded-md bg-slate-200 px-2 py-1 text-[10px] font-bold uppercase text-slate-500">
                            Unavailable
                        </span>

                    </label>


                {{-- NORMAL ROLE --}}
                @else

                    <label class="group relative flex cursor-pointer items-start gap-3 rounded-xl border border-slate-200 bg-[#F8FAFC] p-4 transition hover:border-blue-300 hover:bg-blue-50/40 has-[:checked]:border-blue-300 has-[:checked]:bg-blue-50">

                        <input type="checkbox" name="roles[]" value="{{ $role->id }}" @checked($isSelected) class="peer mt-0.5 h-4 w-4 shrink-0 cursor-pointer rounded border-slate-300 text-[#2F80ED] focus:ring-blue-200">


                        <span class="min-w-0 pr-6">

                            <strong class="block text-sm font-semibold text-slate-700 peer-checked:text-blue-800">
                                {{ ucwords(str_replace('_', ' ', $role->name)) }}
                            </strong>

                            <span class="mt-1 block text-xs leading-5 text-slate-500">
                                {{ $roleDescription }}
                            </span>

                        </span>


                        <span class="absolute right-3 top-3 hidden text-sm font-bold text-[#2F80ED] peer-checked:block">
                            ✓
                        </span>

                    </label>

                @endif

            @endforeach

        </div>


        {{-- FOOTER --}}
        <div class="flex flex-col gap-4 border-t border-slate-200 bg-[#EEF3F8]/60 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">

            <div>

                <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400">
                    Police Officer Status
                </p>

                <p class="text-sm font-semibold {{ $isPoliceOfficer ? 'text-emerald-700' : 'text-slate-700' }}">
                    {{ $isPoliceOfficer
                        ? 'Registered as Police Officer'
                        : 'Not Registered as Police Officer' }}
                </p>

            </div>


            <div class="flex flex-wrap gap-3">

                <a href="{{ route('user-role.index') }}" class="inline-flex min-h-10 items-center justify-center rounded-lg border border-slate-300 bg-[#F8FAFC] px-4 text-sm font-medium text-slate-600 transition hover:bg-slate-100">
                    Batal
                </a>


                <button type="submit" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-lg bg-[#2F80ED] px-4 text-sm font-semibold text-white transition hover:bg-blue-600">

                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.75H6.75A2.25 2.25 0 0 0 4.5 6v12a2.25 2.25 0 0 0 2.25 2.25h10.5A2.25 2.25 0 0 0 19.5 18V6.75L16.5 3.75ZM8.25 3.75v5.25h7.5V3.75M8.25 15h7.5" />
                    </svg>

                    Update Roles
                </button>

            </div>

        </div>

    </div>

</form>

@endsection