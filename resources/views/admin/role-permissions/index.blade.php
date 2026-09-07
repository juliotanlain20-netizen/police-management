@extends('layouts.app')

@section('title', 'Role Permissions')

@section('content')

{{-- HEADER --}}
<div class="mb-7">

    <h1 class="mb-1 text-3xl font-bold text-[#0B1F3A]">Role Permissions</h1>

    <p class="text-sm text-slate-500">
        Atur hak akses yang dimiliki setiap role dalam sistem.
    </p>

</div>


{{-- ROLE GRID --}}
<div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">

    @forelse ($roles as $role)

        @php
            $roleInitial = match ($role->name) {
                'admin' => 'A',
                'police' => 'P',
                'citizen' => 'C',
                'investigation_supervisor' => 'S',
                default => 'R'
            };

            $roleIconClass = match ($role->name) {
                'admin' => 'bg-violet-100 text-violet-700',
                'police' => 'bg-blue-100 text-blue-700',
                'citizen' => 'bg-emerald-100 text-emerald-700',
                'investigation_supervisor' => 'bg-amber-100 text-amber-700',
                default => 'bg-slate-100 text-slate-700'
            };
        @endphp


        <div class="flex min-h-[280px] flex-col overflow-hidden rounded-xl border border-slate-200 bg-[#F8FAFC] transition hover:-translate-y-0.5 hover:shadow-md">

            {{-- CARD HEADER --}}
            <div class="flex items-start justify-between gap-4 border-b border-slate-200 px-5 py-5">

                <div class="min-w-0">

                    <h2 class="truncate text-lg font-bold text-[#0B1F3A]">
                        {{ ucwords(str_replace('_', ' ', $role->name)) }}
                    </h2>

                    <p class="mt-1 text-xs text-slate-400">
                        {{ $role->permissions->count() }}
                        {{ $role->permissions->count() === 1 ? 'permission' : 'permissions' }}
                    </p>

                </div>


                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl text-sm font-bold {{ $roleIconClass }}">
                    {{ $roleInitial }}
                </div>

            </div>


            {{-- PERMISSIONS --}}
            <div class="flex flex-1 flex-wrap content-start gap-2 p-5">

                @forelse ($role->permissions as $permission)

                    <span class="inline-flex h-fit rounded-md border border-slate-200 bg-[#EEF3F8] px-2.5 py-1.5 font-mono text-[11px] font-semibold text-slate-600">
                        {{ $permission->slug }}
                    </span>

                @empty

                    <div class="flex w-full items-center justify-center rounded-lg border border-dashed border-slate-300 bg-[#EEF3F8] px-4 py-8 text-center">

                        <div>

                            <div class="mx-auto mb-2 flex h-9 w-9 items-center justify-center rounded-full bg-slate-200 text-slate-400">

                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-6v10.5A2.25 2.25 0 0 1 18.75 19.5H5.25A2.25 2.25 0 0 1 3 17.25V6.75A2.25 2.25 0 0 1 5.25 4.5h13.5A2.25 2.25 0 0 1 21 6.75Z" />
                                </svg>

                            </div>

                            <p class="text-sm font-semibold text-slate-500">
                                Belum memiliki permission.
                            </p>

                        </div>

                    </div>

                @endforelse

            </div>


            {{-- CARD FOOTER --}}
            <div class="border-t border-slate-200 bg-[#EEF3F8]/60 px-5 py-4">

                <a href="{{ route('role-permission.edit', $role->id) }}" class="inline-flex min-h-10 w-full items-center justify-center gap-2 rounded-lg bg-[#2F80ED] px-4 text-sm font-semibold text-white transition hover:bg-blue-600">

                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15.75A3.75 3.75 0 1 0 12 8.25a3.75 3.75 0 0 0 0 7.5Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12a7.5 7.5 0 0 0-.11-1.275l2.06-1.605-2.25-3.897-2.43.982a7.5 7.5 0 0 0-2.205-1.275L14.25 2.25h-4.5l-.315 2.68a7.5 7.5 0 0 0-2.205 1.275L4.8 5.223 2.55 9.12l2.06 1.605A7.5 7.5 0 0 0 4.5 12c0 .434.037.86.11 1.275L2.55 14.88l2.25 3.897 2.43-.982a7.5 7.5 0 0 0 2.205 1.275l.315 2.68h4.5l.315-2.68a7.5 7.5 0 0 0 2.205-1.275l2.43.982 2.25-3.897-2.06-1.605A7.5 7.5 0 0 0 19.5 12Z" />
                    </svg>

                    Manage Permissions

                </a>

            </div>

        </div>

    @empty

        <div class="md:col-span-2 xl:col-span-3">

            <div class="rounded-xl border border-slate-200 bg-[#F8FAFC] px-5 py-14 text-center">

                <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-slate-400">

                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975M15.75 6.75a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Zm6 5.25a9.75 9.75 0 1 1-19.5 0 9.75 9.75 0 0 1 19.5 0Z" />
                    </svg>

                </div>

                <p class="text-sm font-semibold text-slate-600">Belum ada role.</p>
                <p class="mt-1 text-xs text-slate-400">Role belum tersedia di dalam sistem.</p>

            </div>

        </div>

    @endforelse

</div>

@endsection