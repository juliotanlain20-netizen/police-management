@php
    $user = auth()->user();

    $isAdmin = $user->roles
        ->contains('name', 'admin');

    /*
    |--------------------------------------------------------------------------
    | Sidebar reusable classes
    |--------------------------------------------------------------------------
    */

    $linkBase = '
        group
        flex
        min-h-[42px]
        items-center
        gap-3
        rounded-lg
        px-3
        text-[13px]
        font-medium
        transition-colors
        duration-150
    ';

    $linkActive = '
        bg-gradient-to-r
        from-[#2F80ED]/30
        to-[#2F80ED]/10
        text-white
        shadow-[inset_3px_0_0_#2F80ED]
    ';

    $linkInactive = '
        text-slate-300
        hover:bg-[#F8FAFC]/[0.07]
        hover:text-white
    ';

    $iconClass = '
        h-5
        w-5
        shrink-0
    ';
@endphp


{{-- =========================================================
    SIDEBAR
========================================================= --}}
<aside
    id="appSidebar"
    class="
        sticky
        top-0
        flex
        h-screen
        w-[250px]
        min-w-[250px]
        shrink-0
        flex-col
        overflow-hidden
        bg-[#0B1F3A]
        text-white

        transition-[transform,margin]
        duration-300
        ease-in-out

        max-md:fixed
        max-md:inset-y-0
        max-md:left-0
        max-md:z-[200]
        max-md:h-dvh
        max-md:w-[270px]
        max-md:min-w-[270px]
        max-md:-translate-x-full
        max-md:shadow-2xl
    "
>
    {{-- =====================================================
        BRAND
    ====================================================== --}}
    <div
        class="
            flex
            min-h-[76px]
            shrink-0
            items-center
            gap-3

            border-b
            border-white/10

            px-[18px]
            py-3.5
        "
    >

        <img
            src="{{ asset('image/traksa-logo.png') }}"
            alt="TRAKSA"
            class="
                block
                h-[46px]
                w-[46px]
                shrink-0

                rounded-lg
                bg-[#F8FAFC]
                p-1

                object-contain
            "
        >


        <div class="min-w-0">

            <strong
                class="
                    block
                    text-[15px]
                    font-extrabold
                    tracking-[0.08em]
                    text-white
                "
            >
                TRAKSA
            </strong>

            <span
                class="
                    mt-0.5
                    block
                    whitespace-nowrap
                    text-[10px]
                    text-[#8ba2bd]
                "
            >
                Police Management
            </span>

        </div>

    </div>


    {{-- =====================================================
        NAVIGATION
    ====================================================== --}}
    <nav
        class="
            flex
            flex-1
            flex-col
            gap-1

            overflow-y-auto

            px-3.5
            py-5

            md:overflow-hidden
        "
    >

        {{-- =================================================
            MENU
        ================================================== --}}
        <p
            class="
                mb-[7px]
                ml-2.5
                mr-2.5

                text-[10px]
                font-bold
                uppercase
                tracking-[0.12em]

                text-[#6f89a8]
            "
        >
            Menu
        </p>


        {{-- DASHBOARD --}}
        <a
            href="{{ route('dashboard') }}"
            class="
                {{ $linkBase }}

                {{
                    request()->routeIs('dashboard')
                        ? $linkActive
                        : $linkInactive
                }}
            "
        >

            {{-- Home Icon --}}
            <svg
                class="{{ $iconClass }}"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.6"
                stroke="currentColor"
                aria-hidden="true"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="
                        M2.25 12
                        8.954 5.296
                        c.44-.439
                        1.152-.439
                        1.591 0
                        L21.75 12

                        M4.5 9.75
                        v10.125
                        c0 .621
                        .504 1.125
                        1.125 1.125

                        H9.75
                        v-4.875
                        c0-.621
                        .504-1.125
                        1.125-1.125
                        h2.25
                        c.621 0
                        1.125.504
                        1.125 1.125
                        V21

                        h4.125
                        c.621 0
                        1.125-.504
                        1.125-1.125
                        V9.75
                    "
                />
            </svg>

            <span>
                Dashboard
            </span>

        </a>


        {{-- PENGADUAN --}}
        <a
            href="{{ route('complaint') }}"
            class="
                {{ $linkBase }}

                {{
                    request()->routeIs('complaint*')
                        ? $linkActive
                        : $linkInactive
                }}
            "
        >

            {{-- Document Icon --}}
            <svg
                class="{{ $iconClass }}"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.6"
                stroke="currentColor"
                aria-hidden="true"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="
                        M6.75 3.75
                        h7.5
                        l3 3
                        v13.5
                        H6.75
                        a1.5 1.5 0 0 1-1.5-1.5
                        V5.25
                        a1.5 1.5 0 0 1 1.5-1.5
                        Z

                        M9 11.25
                        h6

                        M9 15
                        h6
                    "
                />
            </svg>

            <span>
                Pengaduan
            </span>

        </a>


        {{-- =================================================
            OPERASIONAL
        ================================================== --}}
        @if (
            $user->hasPermission('case.view_all') ||
            $user->hasPermission('evidence.view') ||
            (
                $user->hasPermission('police.view_all') &&
                !$isAdmin
            )
        )

            <p
                class="
                    mb-[7px]
                    ml-2.5
                    mr-2.5
                    mt-5

                    text-[10px]
                    font-bold
                    uppercase
                    tracking-[0.12em]

                    text-[#6f89a8]
                "
            >
                Operasional
            </p>

        @endif


        {{-- CASE --}}
        @if ($user->hasPermission('case.view_all'))

            <a
                href="{{ route('cases.index') }}"
                class="
                    {{ $linkBase }}

                    {{
                        request()->routeIs('cases.*')
                            ? $linkActive
                            : $linkInactive
                    }}
                "
            >

                {{-- Folder Icon --}}
                <svg
                    class="{{ $iconClass }}"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.6"
                    stroke="currentColor"
                    aria-hidden="true"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="
                            M3.75 6.75
                            A1.5 1.5 0 0 1 5.25 5.25
                            h4.2
                            l1.8 2.25
                            h7.5
                            a1.5 1.5 0 0 1 1.5 1.5
                            v8.25
                            a1.5 1.5 0 0 1-1.5 1.5
                            H5.25
                            a1.5 1.5 0 0 1-1.5-1.5
                            V6.75
                            Z
                        "
                    />
                </svg>

                <span>
                    Kasus
                </span>

            </a>

        @endif


        {{-- EVIDENCE --}}
        @if ($user->hasPermission('evidence.view'))

            <a
                href="{{ route('evidence.index') }}"
                class="
                    {{ $linkBase }}

                    {{
                        request()->routeIs('evidence.*')
                            ? $linkActive
                            : $linkInactive
                    }}
                "
            >

                {{-- Evidence / Box Icon --}}
                <svg
                    class="{{ $iconClass }}"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.6"
                    stroke="currentColor"
                    aria-hidden="true"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="
                            M4.5 7.5
                            12 3.75
                            19.5 7.5
                            12 11.25
                            4.5 7.5
                            Z

                            M4.5 7.5
                            v9
                            L12 20.25
                            l7.5-3.75
                            v-9

                            M12 11.25
                            v9
                        "
                    />
                </svg>

                <span>
                    Barang Bukti
                </span>

            </a>

        @endif


        {{-- =================================================
            POLICE BIASA
        ================================================== --}}
        @if (
            $user->hasPermission('police.view_all') &&
            !$isAdmin
        )

            <a
                href="{{ route('police.index') }}"
                class="
                    {{ $linkBase }}

                    {{
                        request()->routeIs('police.*')
                            ? $linkActive
                            : $linkInactive
                    }}
                "
            >

                {{-- User Icon --}}
                <svg
                    class="{{ $iconClass }}"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.6"
                    stroke="currentColor"
                    aria-hidden="true"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="
                            M15.75 6.75
                            a3.75 3.75 0 1 1-7.5 0
                            3.75 3.75 0 0 1 7.5 0
                            Z

                            M4.5 20.25
                            a7.5 7.5 0 0 1 15 0
                        "
                    />
                </svg>

                <span>
                    Penyidik
                </span>

            </a>

        @endif


        {{-- =================================================
            ADMINISTRATION
        ================================================== --}}
        @if ($isAdmin)

            <p
                class="
                    mb-[7px]
                    ml-2.5
                    mr-2.5
                    mt-5

                    text-[10px]
                    font-bold
                    uppercase
                    tracking-[0.12em]

                    text-[#6f89a8]
                "
            >
                Administration
            </p>


            {{-- KELOLA POLICE --}}
            <a
                href="{{ route('police.index') }}"
                class="
                    {{ $linkBase }}

                    {{
                        request()->routeIs('police.*')
                            ? $linkActive
                            : $linkInactive
                    }}
                "
            >

                {{-- Police/User Icon --}}
                <svg
                    class="{{ $iconClass }}"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.6"
                    stroke="currentColor"
                    aria-hidden="true"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="
                            M15.75 6.75
                            a3.75 3.75 0 1 1-7.5 0
                            3.75 3.75 0 0 1 7.5 0
                            Z

                            M4.5 20.25
                            a7.5 7.5 0 0 1 15 0
                        "
                    />
                </svg>

                <span>
                    Kelola Police
                </span>

            </a>


            {{-- USER & ROLE --}}
            <a
                href="{{ route('user-role.index') }}"
                class="
                    {{ $linkBase }}

                    {{
                        request()->routeIs('user-role.*')
                            ? $linkActive
                            : $linkInactive
                    }}
                "
            >

                {{-- Users Icon --}}
                <svg
                    class="{{ $iconClass }}"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.6"
                    stroke="currentColor"
                    aria-hidden="true"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="
                            M12 8.25
                            a3 3 0 1 1-6 0
                            3 3 0 0 1 6 0
                            Z

                            M2.25 19.5
                            a6.75 6.75 0 0 1 13.5 0

                            M17.25 5.25
                            a2.25 2.25 0 1 1 0 4.5

                            M18 13.5
                            a5.25 5.25 0 0 1 3.75 1.57
                        "
                    />
                </svg>

                <span>
                    User & Role
                </span>

            </a>


            {{-- ROLE PERMISSIONS --}}
            <a
                href="{{ route('role-permission.index') }}"
                class="
                    {{ $linkBase }}

                    {{
                        request()->routeIs('role-permission.*')
                            ? $linkActive
                            : $linkInactive
                    }}
                "
            >

                {{-- Shield Icon --}}
                <svg
                    class="{{ $iconClass }}"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.6"
                    stroke="currentColor"
                    aria-hidden="true"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="
                            M12 3
                            19.5 6
                            v5.25
                            c0 4.35-2.79 8.25-7.5 9.75
                            -4.71-1.5-7.5-5.4-7.5-9.75
                            V6
                            L12 3
                            Z

                            m9 9
                            -2.25 2.25
                            -1.5-1.5
                        "
                    />
                </svg>

                <span>
                    Role Permissions
                </span>

            </a>

        @endif

    </nav>

</aside>


{{-- =========================================================
    MOBILE OVERLAY
========================================================= --}}
<div
    id="sidebarOverlay"
    class="
        invisible
        fixed
        inset-0
        z-[190]

        bg-slate-950/50

        opacity-0

        transition-all
        duration-300

        md:hidden
    "
></div>