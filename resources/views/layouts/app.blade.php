<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">
    <title>
        @yield('title', 'Traksa')
    </title>
    {{-- <link rel="stylesheet"href="{{ asset('css/app.css') }}"> --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')

</head>

<body>

    <div class="app-shell">
        @include('partials.sidebar')
        <div class="app-main">
            @include('partials.navbar')
            <main class="content">
                @include('partials.flash-message')
                @yield('content')
            </main>
            @include('partials.footer')
        </div>
    </div>
    @stack('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const toggle =
        document.getElementById('sidebarToggle');

    const overlay =
        document.getElementById('sidebarOverlay');


    if (!toggle) {
        return;
    }


    function isMobile() {
        return window.innerWidth <= 760;
    }


    function closeMobileSidebar() {

        document.body.classList.remove(
            'sidebar-open'
        );

        toggle.setAttribute(
            'aria-expanded',
            'false'
        );
    }


    toggle.addEventListener('click', function () {

        if (isMobile()) {

            document.body.classList.toggle(
                'sidebar-open'
            );

            toggle.setAttribute(
                'aria-expanded',
                document.body.classList.contains(
                    'sidebar-open'
                )
                    ? 'true'
                    : 'false'
            );

            return;
        }


        document.body.classList.toggle(
            'sidebar-collapsed'
        );

        toggle.setAttribute(
            'aria-expanded',
            document.body.classList.contains(
                'sidebar-collapsed'
            )
                ? 'false'
                : 'true'
        );

    });


    if (overlay) {

        overlay.addEventListener(
            'click',
            closeMobileSidebar
        );

    }


    window.addEventListener('resize', function () {

        if (!isMobile()) {

            document.body.classList.remove(
                'sidebar-open'
            );

        }

    });

});
</script>
</body>

</html>