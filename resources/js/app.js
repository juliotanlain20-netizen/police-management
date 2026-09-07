document.addEventListener('DOMContentLoaded', () => {

    const sidebar =
        document.getElementById('appSidebar');

    const overlay =
        document.getElementById('sidebarOverlay');

    const toggle =
        document.getElementById('sidebarToggle');


    if (!sidebar || !overlay || !toggle) {
        return;
    }


    const desktop =
        window.matchMedia('(min-width: 768px)');


    /*
    |--------------------------------------------------------------------------
    | MOBILE OPEN
    |--------------------------------------------------------------------------
    */

    function openMobileSidebar() {

        sidebar.classList.remove(
            '-translate-x-full'
        );

        sidebar.classList.add(
            'translate-x-0'
        );


        overlay.classList.remove(
            'invisible',
            'opacity-0'
        );

        overlay.classList.add(
            'visible',
            'opacity-100'
        );


        document.body.classList.add(
            'overflow-hidden'
        );


        toggle.setAttribute(
            'aria-expanded',
            'true'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | MOBILE CLOSE
    |--------------------------------------------------------------------------
    */

    function closeMobileSidebar() {

        sidebar.classList.remove(
            'translate-x-0'
        );

        sidebar.classList.add(
            '-translate-x-full'
        );


        overlay.classList.remove(
            'visible',
            'opacity-100'
        );

        overlay.classList.add(
            'invisible',
            'opacity-0'
        );


        document.body.classList.remove(
            'overflow-hidden'
        );


        toggle.setAttribute(
            'aria-expanded',
            'false'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | DESKTOP TOGGLE
    |--------------------------------------------------------------------------
    */

    function toggleDesktopSidebar() {

        sidebar.classList.toggle(
            '-ml-[250px]'
        );


        const collapsed =
            sidebar.classList.contains(
                '-ml-[250px]'
            );


        toggle.setAttribute(
            'aria-expanded',
            collapsed ? 'false' : 'true'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | BURGER
    |--------------------------------------------------------------------------
    */

    toggle.addEventListener('click', () => {

        if (desktop.matches) {

            toggleDesktopSidebar();

            return;
        }


        if (
            sidebar.classList.contains(
                '-translate-x-full'
            )
        ) {

            openMobileSidebar();

        } else {

            closeMobileSidebar();

        }

    });


    /*
    |--------------------------------------------------------------------------
    | OVERLAY
    |--------------------------------------------------------------------------
    */

    overlay.addEventListener(
        'click',
        closeMobileSidebar
    );


    /*
    |--------------------------------------------------------------------------
    | ESCAPE
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'keydown',
        (event) => {

            if (
                event.key === 'Escape' &&
                !desktop.matches
            ) {

                closeMobileSidebar();

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | SCREEN CHANGE
    |--------------------------------------------------------------------------
    */

    desktop.addEventListener(
        'change',
        (event) => {

            document.body.classList.remove(
                'overflow-hidden'
            );


            overlay.classList.remove(
                'visible',
                'opacity-100'
            );

            overlay.classList.add(
                'invisible',
                'opacity-0'
            );


            /*
             * Masuk desktop
             */
            if (event.matches) {

                sidebar.classList.remove(
                    '-translate-x-full',
                    'translate-x-0'
                );


                const collapsed =
                    sidebar.classList.contains(
                        '-ml-[250px]'
                    );

                toggle.setAttribute(
                    'aria-expanded',
                    collapsed ? 'false' : 'true'
                );

                return;
            }


            /*
             * Masuk mobile
             *
             * Hilangkan desktop collapse dan
             * tutup sidebar.
             */
            sidebar.classList.remove(
                '-ml-[250px]',
                'translate-x-0'
            );

            sidebar.classList.add(
                '-translate-x-full'
            );


            toggle.setAttribute(
                'aria-expanded',
                'false'
            );

        }
    );

});