@php
    $authUser = auth()->user();

    $initial = strtoupper(
        substr($authUser->name ?? 'U', 0, 1)
    );

    /*
     * Role yang paling relevan untuk ditampilkan.
     * Admin diprioritaskan karena user bisa memiliki
     * lebih dari satu role.
     */
    if ($authUser->roles->contains('name', 'admin')) {
        $roleLabel = 'Administrator';
    } elseif ($authUser->roles->contains('name', 'investigation_supervisor')) {
        $roleLabel = 'Investigation Supervisor';
    } elseif ($authUser->roles->contains('name', 'police')) {
        $roleLabel = 'Police Officer';
    } elseif ($authUser->roles->contains('name', 'citizen')) {
        $roleLabel = 'Citizen';
    } else {
        $roleLabel = 'User';
    }
@endphp


<header
    class="
        sticky
        top-0
        z-50
        flex
        min-h-16
        items-center
        justify-between
        gap-3

        border-b
        border-slate-200
        bg-[#F8FAFC]

        px-4

        shadow-[0_1px_3px_rgba(15,23,42,0.03)]

        sm:px-5

        md:min-h-[72px]
        md:gap-6
        md:px-[30px]
    "
>

    {{-- =====================================================
        LEFT
    ====================================================== --}}
    <div
        class="
            flex
            min-w-0
            items-center
            gap-3

            md:gap-3.5
        "
    >

        {{-- SIDEBAR TOGGLE --}}
        <button
            type="button"
            id="sidebarToggle"
            aria-label="Toggle sidebar"
            aria-controls="appSidebar"
            aria-expanded="true"
            class="
                flex
                h-9
                w-9
                shrink-0
                items-center
                justify-center

                rounded-lg

                border
                border-slate-200

                bg-[#EEF3F8]
                text-[#0B1F3A]

                transition-colors
                duration-150

                hover:border-blue-200
                hover:bg-blue-50

                focus:outline-none
                focus:ring-2
                focus:ring-[#2F80ED]/20

                md:h-[38px]
                md:w-[38px]
            "
        >

            {{-- Heroicon: Bars 3 --}}
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
                class="h-5 w-5"
                aria-hidden="true"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"
                />
            </svg>

        </button>


        {{-- BRAND --}}
        <div
            class="
                flex
                min-w-0
                flex-col
                gap-0.5
            "
        >

            <strong
                class="
                    truncate
                    text-[14px]
                    font-extrabold
                    tracking-[0.06em]
                    text-[#0B1F3A]

                    md:text-[15px]
                "
            >
                TRAKSA
            </strong>

            <span
                class="
                    hidden
                    truncate
                    text-[10px]
                    text-slate-400

                    sm:block
                "
            >
                Police Management System
            </span>

        </div>

    </div>


    {{-- =====================================================
        RIGHT USER AREA
    ====================================================== --}}
    <div
        class="
            flex
            shrink-0
            items-center
            gap-2

            sm:gap-3

            md:gap-[15px]
        "
    >

        {{-- USER PROFILE --}}
        <div
            class="
                flex
                items-center
                gap-2.5
            "
        >

            {{-- AVATAR --}}
            <div
                class="
                    flex
                    h-[34px]
                    w-[34px]
                    shrink-0
                    items-center
                    justify-center

                    rounded-lg

                    bg-gradient-to-br
                    from-[#0B1F3A]
                    to-[#2F80ED]

                    text-xs
                    font-extrabold
                    text-white

                    shadow-[0_4px_12px_rgba(47,128,237,0.16)]

                    md:h-[38px]
                    md:w-[38px]
                    md:rounded-[10px]
                    md:text-[13px]
                "
            >
                {{ $initial }}
            </div>


            {{-- USER INFORMATION --}}
            <div
                class="
                    hidden
                    max-w-[180px]
                    flex-col
                    gap-px

                    sm:flex
                "
            >

                <strong
                    class="
                        truncate
                        text-xs
                        font-bold
                        text-slate-800
                    "
                >
                    {{ $authUser->name }}
                </strong>

                <span
                    class="
                        truncate
                        text-[10px]
                        text-slate-400
                    "
                >
                    {{ $roleLabel }}
                </span>

            </div>

        </div>


        {{-- DIVIDER --}}
        <div
            class="
                hidden
                h-[30px]
                w-px
                bg-slate-200

                sm:block
            "
        ></div>


        {{-- =================================================
            LOGOUT
        ================================================== --}}
        <form
            action="{{ route('logout') }}"
            method="POST"
            class="m-0"
        >
            @csrf

            <button
                type="submit"
                onclick="return confirm('Yakin ingin logout?')"
                class="
                    inline-flex
                    h-9
                    items-center
                    justify-center
                    gap-1.5

                    rounded-lg

                    border
                    border-slate-200

                    bg-transparent

                    px-2.5

                    text-[11px]
                    font-semibold
                    text-slate-500

                    transition-colors
                    duration-150

                    hover:border-red-200
                    hover:bg-red-50
                    hover:text-red-600

                    focus:outline-none
                    focus:ring-2
                    focus:ring-red-500/15

                    sm:px-3
                "
            >

                {{-- Heroicon: Arrow Right On Rectangle --}}
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    class="h-[18px] w-[18px]"
                    aria-hidden="true"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="
                            M15.75 9
                            V5.25
                            A2.25 2.25 0 0 0
                            13.5 3
                            h-6
                            A2.25 2.25 0 0 0
                            5.25 5.25
                            v13.5
                            A2.25 2.25 0 0 0
                            7.5 21
                            h6
                            a2.25 2.25 0 0 0
                            2.25-2.25
                            V15

                            M18 15
                            l3-3
                            m0 0
                            -3-3
                            m3 3
                            H9
                        "
                    />
                </svg>

                <span class="hidden sm:inline">
                    Logout
                </span>

            </button>

        </form>

    </div>

</header>