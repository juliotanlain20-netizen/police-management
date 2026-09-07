<footer
    class="
        relative
        mt-12
        overflow-hidden

        border-t
        border-slate-200

        bg-gradient-to-br
        from-slate-50
        to-blue-50/70

        px-5
        pb-5
        pt-9

        text-slate-600

        sm:px-7
        md:px-9
        md:pt-10
    "
>

    {{-- =====================================================
        DECORATION
    ====================================================== --}}
    <div
        class="
            pointer-events-none
            absolute
            -right-28
            -top-32

            h-[220px]
            w-[520px]

            rounded-full
            border-[40px]
            border-[#2F80ED]/[0.045]
        "
    ></div>


    {{-- =====================================================
        MAIN CONTENT
    ====================================================== --}}
    <div
        class="
            relative
            z-10

            mx-auto
            mb-8
            grid
            max-w-[1300px]

            grid-cols-1
            gap-8

            sm:grid-cols-2

            lg:grid-cols-[minmax(260px,1.3fr)_minmax(230px,1fr)_minmax(210px,.8fr)]
            lg:gap-12
        "
    >

        {{-- =================================================
            BRAND
        ================================================== --}}
        <div class="sm:pr-8 lg:pr-0">

            <div
                class="
                    flex
                    items-center
                    gap-3
                "
            >

                <img
                    src="{{ asset('image/traksa-logo.png') }}"
                    alt="TRAKSA"
                    class="
                        h-[54px]
                        w-[54px]
                        shrink-0

                        rounded-[10px]

                        border
                        border-slate-200

                        bg-[#F8FAFC]
                        p-1

                        object-contain
                    "
                >


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
                            text-[17px]
                            font-extrabold
                            tracking-[0.08em]
                            text-[#0B1F3A]
                        "
                    >
                        TRAKSA
                    </strong>

                    <span
                        class="
                            text-[11px]
                            text-slate-500
                        "
                    >
                        Police Management System
                    </span>

                </div>

            </div>


            <p
                class="
                    mt-[18px]
                    max-w-[330px]

                    text-xs
                    leading-5
                    text-slate-500
                "
            >
                Sistem Manajemen Barang Bukti dan
                Pengaduan Masyarakat.
            </p>

        </div>


        {{-- =================================================
            CONTACT
        ================================================== --}}
        <div>

            <h3
                class="
                    mb-[18px]
                    mt-1

                    text-[13px]
                    font-bold
                    text-[#0B1F3A]
                "
            >
                Hubungi Saya
            </h3>


            {{-- PHONE --}}
            <a
                href="tel:082259860425"
                class="
                    group

                    mb-3
                    flex
                    w-fit
                    items-center
                    gap-2.5

                    text-xs
                    text-slate-500

                    transition-all
                    duration-150

                    hover:translate-x-0.5
                    hover:text-[#2F80ED]
                "
            >

                <span
                    class="
                        flex
                        h-7
                        w-7
                        shrink-0
                        items-center
                        justify-center

                        rounded-full

                        bg-blue-100
                        text-[#2F80ED]
                    "
                >

                    {{-- Heroicon Phone --}}
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.6"
                        stroke="currentColor"
                        class="h-3.5 w-3.5"
                        aria-hidden="true"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25A2.25 2.25 0 0 0 21.75 19.5v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102A1.125 1.125 0 0 0 5.872 2.25H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z"
                        />
                    </svg>

                </span>

                <span>
                    0822-5986-0425
                </span>

            </a>


            {{-- EMAIL --}}
            <a
                href="mailto:juliotanlain20@gmail.com"
                class="
                    group

                    flex
                    w-fit
                    items-center
                    gap-2.5

                    text-xs
                    text-slate-500

                    transition-all
                    duration-150

                    hover:translate-x-0.5
                    hover:text-[#2F80ED]
                "
            >

                <span
                    class="
                        flex
                        h-7
                        w-7
                        shrink-0
                        items-center
                        justify-center

                        rounded-full

                        bg-blue-100
                        text-[#2F80ED]
                    "
                >

                    {{-- Heroicon Envelope --}}
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.6"
                        stroke="currentColor"
                        class="h-3.5 w-3.5"
                        aria-hidden="true"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M21.75 6.75v10.5A2.25 2.25 0 0 1 19.5 19.5h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0-8.658 5.355a2.25 2.25 0 0 1-2.184 0L2.25 6.75"
                        />
                    </svg>

                </span>

                <span>
                    juliotanlain20@gmail.com
                </span>

            </a>

        </div>


        {{-- =================================================
            SOCIAL
        ================================================== --}}
        <div>

            <h3
                class="
                    mb-[18px]
                    mt-1

                    text-[13px]
                    font-bold
                    text-[#0B1F3A]
                "
            >
                Temukan Saya
            </h3>


            <a
                href="https://www.instagram.com/julio_tan17?stkn=b2d6Z3RpYWE5OTQy"
                target="_blank"
                rel="noopener noreferrer"
                class="
                    inline-flex
                    items-center
                    gap-3

                    rounded-[9px]

                    border
                    border-slate-200

                    bg-[#F8FAFC]/70

                    px-3
                    py-2.5

                    text-[#0B1F3A]

                    transition-all
                    duration-150

                    hover:-translate-y-0.5
                    hover:border-blue-200
                    hover:bg-[#F8FAFC]
                "
            >

                <span
                    class="
                        flex
                        h-[34px]
                        w-[34px]
                        shrink-0
                        items-center
                        justify-center

                        rounded-full

                        bg-gradient-to-br
                        from-[#2F80ED]
                        to-[#0B1F3A]

                        text-white
                    "
                >

                    {{-- Heroicons tidak punya brand Instagram.
                         Kita pakai camera icon. --}}
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.6"
                        stroke="currentColor"
                        class="h-4 w-4"
                        aria-hidden="true"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M6.75 6.75h.008v.008H6.75V6.75Zm3.75 0h6.75A2.25 2.25 0 0 1 19.5 9v7.5a2.25 2.25 0 0 1-2.25 2.25H6.75A2.25 2.25 0 0 1 4.5 16.5V9a2.25 2.25 0 0 1 2.25-2.25h.75l1.125-1.5h6.75l1.125 1.5"
                        />

                        <circle
                            cx="12"
                            cy="12.75"
                            r="3"
                        />
                    </svg>

                </span>


                <div
                    class="
                        flex
                        flex-col
                        gap-0.5
                    "
                >

                    <span
                        class="
                            text-[9px]
                            uppercase
                            tracking-[0.08em]
                            text-slate-400
                        "
                    >
                        Instagram
                    </span>

                    <strong class="text-xs">
                        @julio_tan17
                    </strong>

                </div>

            </a>

        </div>

    </div>


    {{-- =====================================================
        BOTTOM
    ====================================================== --}}
    <div
        class="
            relative
            z-10

            mx-auto
            flex
            max-w-[1300px]

            flex-col
            items-start
            gap-1

            border-t
            border-slate-200

            pt-[18px]

            text-[10px]
            text-slate-400

            sm:flex-row
            sm:items-center
            sm:justify-between
            sm:gap-5
        "
    >

        <p class="m-0">
            &copy; {{ date('Y') }} TRAKSA.
            All rights reserved.
        </p>

        <span>
            Police Management System
        </span>

    </div>


    {{-- =====================================================
        BACK TO TOP
    ====================================================== --}}
    <button
        type="button"
        id="footerBackTop"
        aria-label="Kembali ke atas"
        title="Kembali ke atas"
        class="
            absolute
            right-5
            top-6
            z-20

            flex
            h-[38px]
            w-[38px]
            items-center
            justify-center

            rounded-full

            border-0

            bg-[#0B1F3A]
            text-white

            shadow-[0_7px_18px_rgba(11,31,58,0.18)]

            transition-all
            duration-150

            hover:-translate-y-0.5
            hover:bg-[#2F80ED]

            focus:outline-none
            focus:ring-2
            focus:ring-[#2F80ED]/25

            md:right-7
            md:top-7
            md:h-[42px]
            md:w-[42px]
        "
    >

        {{-- Heroicon Arrow Up --}}
        <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.8"
            stroke="currentColor"
            class="h-5 w-5"
            aria-hidden="true"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="m4.5 10.5 7.5-7.5 7.5 7.5M12 3v18"
            />
        </svg>

    </button>

</footer>


@push('scripts')

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const backTop =
            document.getElementById('footerBackTop');

        if (!backTop) {
            return;
        }

        backTop.addEventListener('click', function () {

            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });

        });

    });
</script>

@endpush