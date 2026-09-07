@extends('layouts.app')

@section('title', 'User & Role')

@section('content')

{{-- HEADER --}}
<div class="mb-7">
    <h1 class="mb-1 text-3xl font-bold text-[#0B1F3A]">User & Role</h1>
    <p class="text-sm text-slate-500">Kelola role yang dimiliki setiap user dalam sistem.</p>
</div>


{{-- USER LIST --}}
<div class="overflow-hidden rounded-xl border border-slate-200 bg-[#F8FAFC]">

    {{-- CARD HEADER --}}
    <div class="border-b border-slate-200 px-5 py-5">
        <h2 class="text-lg font-bold text-[#0B1F3A]">Daftar User</h2>
        <p class="mt-1 text-xs text-slate-400">Lihat akun user dan role yang sedang dimiliki.</p>
    </div>


    {{-- TABLE --}}
    <div class="overflow-x-auto">

        <table class="w-full border-collapse">

            <thead class="bg-[#EEF3F8]">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">No</th>
                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">User</th>
                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Phone</th>
                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Status</th>
                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Roles</th>
                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Action</th>
                </tr>
            </thead>


            <tbody class="divide-y divide-slate-200">

                @forelse ($users as $user)

                    <tr class="transition hover:bg-[#EEF3F8]">

                        {{-- NO --}}
                        <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-500">
                            {{ $loop->iteration }}
                        </td>


                        {{-- USER --}}
                        <td class="px-5 py-4">

                            <div class="min-w-[190px]">

                                <p class="text-sm font-semibold text-slate-700">
                                    {{ $user->name }}
                                </p>

                                <p class="mt-1 text-xs text-slate-400">
                                    {{ $user->email }}
                                </p>

                            </div>

                        </td>


                        {{-- PHONE --}}
                        <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-500">
                            {{ $user->phone ?? '-' }}
                        </td>


                        {{-- STATUS --}}
                        <td class="px-5 py-4">

                            <span class="inline-flex whitespace-nowrap rounded-full px-3 py-1 text-xs font-bold {{ $user->status === 'active' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-700' }}">
                                {{ ucfirst($user->status) }}
                            </span>

                        </td>


                        {{-- ROLES --}}
                        <td class="px-5 py-4">

                            <div class="flex min-w-[180px] flex-wrap gap-1.5">

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

                                    <span class="text-xs italic text-slate-400">
                                        Belum memiliki role.
                                    </span>

                                @endforelse

                            </div>

                        </td>


                        {{-- ACTION --}}
                        <td class="px-5 py-4">

                            <a href="{{ route('user-role.edit', $user->id) }}" class="inline-flex min-h-9 items-center justify-center gap-2 whitespace-nowrap rounded-lg bg-[#2F80ED] px-3 text-sm font-semibold text-white transition hover:bg-blue-600">

                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12a7.5 7.5 0 0 0-.11-1.275l2.06-1.605-2.25-3.897-2.43.982a7.5 7.5 0 0 0-2.205-1.275L14.25 2.25h-4.5l-.315 2.68a7.5 7.5 0 0 0-2.205 1.275L4.8 5.223 2.55 9.12l2.06 1.605A7.5 7.5 0 0 0 4.5 12c0 .434.037.86.11 1.275L2.55 14.88l2.25 3.897 2.43-.982a7.5 7.5 0 0 0 2.205 1.275l.315 2.68h4.5l.315-2.68a7.5 7.5 0 0 0 2.205-1.275l2.43.982 2.25-3.897-2.06-1.605A7.5 7.5 0 0 0 19.5 12Z" />
                                </svg>

                                Manage Roles

                            </a>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="6" class="px-5 py-14 text-center">

                            <div class="mx-auto flex max-w-sm flex-col items-center">

                                <div class="mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-slate-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.1a7.5 7.5 0 0 1 15 0A17.9 17.9 0 0 1 12 21.75 17.9 17.9 0 0 1 4.5 20.1Z" />
                                    </svg>
                                </div>

                                <p class="text-sm font-semibold text-slate-600">Belum ada user.</p>
                                <p class="mt-1 text-xs text-slate-400">Data user belum tersedia.</p>

                            </div>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection