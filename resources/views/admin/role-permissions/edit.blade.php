@extends('layouts.app')

@section('title', 'Manage Role Permissions')

@section('content')

@php
    $selectedPermissions = old(
        'permissions',
        $role->permissions->pluck('id')->toArray()
    );

    $selectedPermissions = array_map('strval', $selectedPermissions);

    $groupedPermissions = $permissions->groupBy(function ($permission) {
        return explode('.', $permission->slug)[0];
    });

    $groupLabels = [
        'complaint' => 'Complaint',
        'case' => 'Investigation Case',
        'police' => 'Police Officer',
        'evidence' => 'Evidence',
        'suspect' => 'Suspect',
    ];

    $roleInitial = match ($role->name) {
        'admin' => 'A',
        'police' => 'P',
        'citizen' => 'C',
        'investigation_supervisor' => 'S',
        default => strtoupper(substr($role->name, 0, 1))
    };

    $roleIconClass = match ($role->name) {
        'admin' => 'bg-violet-100 text-violet-700',
        'police' => 'bg-blue-100 text-blue-700',
        'citizen' => 'bg-emerald-100 text-emerald-700',
        'investigation_supervisor' => 'bg-amber-100 text-amber-700',
        default => 'bg-slate-100 text-slate-700'
    };
@endphp


{{-- HEADER --}}
<div class="mb-7 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">

    <div>
        <h1 class="mb-1 text-3xl font-bold text-[#0B1F3A]">Manage Role Permissions</h1>

        <p class="text-sm text-slate-500">
            Atur hak akses untuk role
            <span class="font-semibold text-slate-700">
                {{ ucwords(str_replace('_', ' ', $role->name)) }}
            </span>.
        </p>
    </div>


    <a href="{{ route('role-permission.index') }}" class="inline-flex min-h-10 items-center justify-center gap-2 self-start rounded-lg border border-slate-300 bg-[#F8FAFC] px-4 text-sm font-medium text-slate-600 transition hover:bg-[#EEF3F8] hover:text-[#0B1F3A]">
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


{{-- ROLE INFO --}}
<div class="mb-6 overflow-hidden rounded-xl border border-slate-200 bg-[#F8FAFC]">

    <div class="flex items-center gap-4 p-5">

        <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl text-lg font-bold {{ $roleIconClass }}">
            {{ $roleInitial }}
        </div>


        <div>

            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400">
                Role
            </p>

            <h2 class="text-xl font-bold text-[#0B1F3A]">
                {{ ucwords(str_replace('_', ' ', $role->name)) }}
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Saat ini memiliki
                <strong class="text-slate-700">{{ $role->permissions->count() }}</strong>
                permission.
            </p>

        </div>

    </div>

</div>


{{-- PERMISSION FORM --}}
<form action="{{ route('role-permission.update', $role->id) }}" method="POST">
    @csrf
    @method('PATCH')


    <div class="grid gap-5 lg:grid-cols-2">

        @forelse ($groupedPermissions as $group => $groupPermissions)

            <div class="overflow-hidden rounded-xl border border-slate-200 bg-[#F8FAFC]">

                {{-- GROUP HEADER --}}
                <div class="flex items-center justify-between gap-4 border-b border-slate-200 bg-[#EEF3F8]/60 px-5 py-4">

                    <div>

                        <h2 class="text-base font-bold text-[#0B1F3A]">
                            {{ $groupLabels[$group] ?? ucfirst($group) }}
                        </h2>

                        <p class="mt-1 text-xs text-slate-400">
                            {{ $groupPermissions->count() }}
                            {{ $groupPermissions->count() === 1 ? 'permission' : 'permissions' }}
                        </p>

                    </div>


                    <button type="button" data-permission-group="{{ $group }}" class="inline-flex min-h-9 items-center justify-center rounded-lg border border-blue-200 bg-blue-50 px-3 text-xs font-semibold text-blue-700 transition hover:bg-blue-100">
                        Select All
                    </button>

                </div>


                {{-- PERMISSIONS --}}
                <div class="space-y-2 p-4">

                    @foreach ($groupPermissions as $permission)

                        <label class="group flex cursor-pointer items-start gap-3 rounded-lg border border-slate-200 bg-[#F8FAFC] p-3 transition hover:border-blue-300 hover:bg-blue-50/40">

                            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" data-group="{{ $group }}" @checked(in_array((string) $permission->id, $selectedPermissions, true)) class="mt-0.5 h-4 w-4 shrink-0 cursor-pointer rounded border-slate-300 text-[#2F80ED] focus:ring-blue-200">


                            <span class="min-w-0">

                                <strong class="block text-sm font-semibold text-slate-700">
                                    {{ $permission->name }}
                                </strong>

                                <span class="mt-1 block break-all font-mono text-[11px] text-slate-400">
                                    {{ $permission->slug }}
                                </span>

                            </span>

                        </label>

                    @endforeach

                </div>

            </div>

        @empty

            <div class="rounded-xl border border-slate-200 bg-[#F8FAFC] px-5 py-14 text-center lg:col-span-2">

                <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-slate-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>

                <p class="text-sm font-semibold text-slate-600">
                    Belum ada permission.
                </p>

                <p class="mt-1 text-xs text-slate-400">
                    Permission belum tersedia di dalam sistem.
                </p>

            </div>

        @endforelse

    </div>


    {{-- SAVE BAR --}}
    <div class="sticky bottom-4 z-20 mt-6 flex flex-col gap-4 rounded-xl border border-slate-200 bg-[#F8FAFC]/95 px-5 py-4 shadow-lg backdrop-blur sm:flex-row sm:items-center sm:justify-between">

        <div class="text-sm text-slate-500">

            <strong id="selected-permission-count" class="text-lg font-bold text-[#0B1F3A]">
                0
            </strong>

            <span>permission dipilih</span>

        </div>


        <div class="flex flex-wrap gap-3">

            <a href="{{ route('role-permission.index') }}" class="inline-flex min-h-10 items-center justify-center rounded-lg border border-slate-300 bg-[#F8FAFC] px-4 text-sm font-medium text-slate-600 transition hover:bg-[#EEF3F8]">
                Batal
            </a>


            <button type="submit" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-lg bg-[#2F80ED] px-4 text-sm font-semibold text-white transition hover:bg-blue-600">

                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.75H6.75A2.25 2.25 0 0 0 4.5 6v12a2.25 2.25 0 0 0 2.25 2.25h10.5A2.25 2.25 0 0 0 19.5 18V6.75L16.5 3.75ZM8.25 3.75v5.25h7.5V3.75M8.25 15h7.5" />
                </svg>

                Update Permissions

            </button>

        </div>

    </div>

</form>

@endsection


@push('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {
    const permissionCheckboxes = document.querySelectorAll('input[name="permissions[]"]');
    const counter = document.getElementById('selected-permission-count');

    function updateCounter() {
        const selected = document.querySelectorAll('input[name="permissions[]"]:checked').length;

        if (counter) {
            counter.textContent = selected;
        }
    }

    function updateGroupButton(group) {
        const checkboxes = document.querySelectorAll('input[data-group="' + group + '"]');
        const button = document.querySelector('[data-permission-group="' + group + '"]');

        if (!button || checkboxes.length === 0) return;

        const allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);

        button.textContent = allChecked
            ? 'Clear'
            : 'Select All';
    }

    document.querySelectorAll('[data-permission-group]').forEach(function (button) {
        button.addEventListener('click', function () {
            const group = button.dataset.permissionGroup;
            const checkboxes = document.querySelectorAll('input[data-group="' + group + '"]');

            const allChecked = Array.from(checkboxes).every(
                checkbox => checkbox.checked
            );

            checkboxes.forEach(function (checkbox) {
                checkbox.checked = !allChecked;
            });

            updateCounter();
            updateGroupButton(group);
        });
    });

    permissionCheckboxes.forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            updateCounter();
            updateGroupButton(checkbox.dataset.group);
        });
    });

    updateCounter();

    document.querySelectorAll('[data-permission-group]').forEach(function (button) {
        updateGroupButton(button.dataset.permissionGroup);
    });
});
</script>

@endpush