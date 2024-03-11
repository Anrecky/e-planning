@php
    $isBoxed = layoutConfig()['boxed'];
    $isAltMenu = layoutConfig()['alt-menu'];
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>{{ $pageTitle . ' | ' . env('APP_NAME') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ Vite::asset('resources/images/favicon.ico') }}" />
    @vite(['resources/scss/layouts/modern-light-menu/light/loader.scss'])
    @vite(['resources/scss/light/assets/components/font-icons.scss'])
    @vite(['resources/scss/dark/assets/components/font-icons.scss'])
    @if (Request::is('modern-light-menu/*'))
        @vite(['resources/layouts/modern-light-menu/loader.js'])
    @elseif (Request::is('modern-dark-menu/*'))
        @vite(['resources/layouts/modern-dark-menu/loader.js'])
    @elseif (Request::is('collapsible-menu/*'))
        @vite(['resources/layouts/collapsible-menu/loader.js'])
    @elseif (Request::is('horizontal-light-menu/*'))
        @vite(['resources/layouts/horizontal-light-menu/loader.js'])
    @elseif (Request::is('horizontal-dark-menu/*'))
        @vite(['resources/layouts/horizontal-dark-menu/loader.js'])
    @else
        @vite(['resources/layouts/modern-light-menu/loader.js'])
    @endif

    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/bootstrap/bootstrap.min.css') }}">
    @vite(['resources/scss/light/assets/main.scss', 'resources/scss/dark/assets/main.scss'])

    @if (
        !Request::routeIs('404') &&
            !Request::routeIs('maintenance') &&
            !Request::routeIs('signin') &&
            !Request::routeIs('signup') &&
            !Request::routeIs('lockscreen') &&
            !Request::routeIs('password-reset') &&
            !Request::routeIs('2Step') &&
            // Real Logins
            !Request::routeIs('login'))
        @if ($scrollspy == 1)
            @vite(['resources/scss/light/assets/scrollspyNav.scss', 'resources/scss/dark/assets/scrollspyNav.scss'])
        @endif
        <link rel="stylesheet" type="text/css" href="{{ asset('plugins/waves/waves.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('plugins/highlight/styles/monokai-sublime.css') }}">
        @vite(['resources/scss/light/plugins/perfect-scrollbar/perfect-scrollbar.scss'])


        @if (Request::is('modern-light-menu/*'))
            @vite(['resources/scss/layouts/modern-light-menu/light/structure.scss', 'resources/scss/layouts/modern-light-menu/dark/structure.scss'])
        @elseif (Request::is('modern-dark-menu/*'))
            @vite(['resources/scss/layouts/modern-dark-menu/light/structure.scss', 'resources/scss/layouts/modern-dark-menu/dark/structure.scss'])
        @elseif (Request::is('collapsible-menu/*'))
            @vite(['resources/scss/layouts/collapsible-menu/light/structure.scss', 'resources/scss/layouts/collapsible-menu/dark/structure.scss'])
        @elseif (Request::is('horizontal-light-menu/*'))
            @vite(['resources/scss/layouts/horizontal-light-menu/light/structure.scss', 'resources/scss/layouts/horizontal-light-menu/dark/structure.scss'])
        @elseif (Request::is('horizontal-dark-menu/*'))
            @vite(['resources/scss/layouts/horizontal-dark-menu/light/structure.scss', 'resources/scss/layouts/horizontal-dark-menu/dark/structure.scss'])
        @else
            @vite(['resources/scss/layouts/modern-light-menu/light/structure.scss', 'resources/scss/layouts/modern-light-menu/dark/structure.scss'])
        @endif

    @endif

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    {{ $headerFiles }}
    <!-- END GLOBAL MANDATORY STYLES -->

    <style>
        .menu,
        .submenu>.dropdown-toggle>div>span {
            text-wrap: wrap !important;
        }

        a.dropdown-toggle.collapsed::after,
        a.dropdown-toggle.collapsed::before {
            display: none !important;
        }

        #sidebar ul.menu-categories ul.submenu>li a {
            margin-left: 0.15rem;
            font-size: 0.75rem
        }

        #sidebar ul.menu-categories ul.submenu>li a::before {
            display: none !important;
        }

        #sidebar ul.menu-categories ul.submenu>li a::after {
            display: none !important;
        }

        #sidebar ul.menu-categories ul.submenu>li ul.sub-submenu>li a {
            margin-left: 2rem;
        }

        #sidebar ul.menu-categories ul.submenu>li ul.sub-submenu>li a::before {
            display: block !important;
        }

        #sidebar ul.menu-categories ul.submenu>li ul.sub-submenu>li a::after {
            display: block !important;
        }

        .feather-16 {
            width: 16px;
            height: 16px;
        }

        .feather-24 {
            width: 24px !important;
            height: 24px !important;
        }

        .feather-32 {
            width: 32px !important;
            height: 32px !important;
        }

        .feather-64 {
            width: 64px !important;
            height: 64px !important;
        }
    </style>
</head>

<body @class([
    // 'layout-dark' => $isDark,
    'layout-boxed' => $isBoxed,
    'alt-menu' =>
        $isAltMenu || Request::routeIs('collapsibleMenu') ? true : false,
    'error' => Request::routeIs('404') ? true : false,
    'maintanence' => Request::routeIs('maintenance') ? true : false,
])
    @if ($scrollspy == 1) {{ $scrollspyConfig }} @else {{ '' }} @endif
    @if (Request::routeIs('fullWidth')) layout="full-width" @endif>

    <!-- BEGIN LOADER -->
    <x-layout-loader />
    <!--  END LOADER -->

    @if (
        !Request::routeIs('404') &&
            !Request::routeIs('maintenance') &&
            !Request::routeIs('signin') &&
            !Request::routeIs('signup') &&
            !Request::routeIs('lockscreen') &&
            !Request::routeIs('password-reset') &&
            !Request::routeIs('2Step') &&
            // Real Logins
            !Request::routeIs('login'))

        @if (!Request::routeIs('blank'))
            <!--  BEGIN NAVBAR  -->
            <x-custom.navbar.topbar classes="{{ $isBoxed ? 'container-xxl' : '' }}" />
            <!--  END NAVBAR  -->
        @endif

        <!--  BEGIN MAIN CONTAINER  -->
        <div class="main-container " id="container">

            <!--  BEGIN LOADER  -->
            <x-layout-overlay />
            <!--  END LOADER  -->
            <!--  BEGIN SIDEBAR  -->
            <x-custom.navbar.sidebar />
            <!--  END SIDEBAR  -->
            <!--  BEGIN CONTENT AREA  -->
            <div id="content" class="main-content {{ Request::routeIs('blank') ? 'ms-0 mt-0' : '' }}">

                @if ($scrollspy == 1)
                    <div class="container">
                        <div class="container">
                            {{ $slot }}
                        </div>
                    </div>
                @else
                    <div class="layout-px-spacing">
                        <div class="middle-content {{ $isBoxed ? 'container-xxl' : '' }} p-0">
                            {{ $slot }}
                        </div>
                    </div>
                @endif

                <!--  BEGIN FOOTER  -->
                <x-layout-footer />
                <!--  END FOOTER  -->

            </div>
            <!--  END CONTENT AREA  -->

        </div>
        <!--  END MAIN CONTAINER  -->
    @else
        {{ $slot }}
    @endif

    @if (
        !Request::routeIs('404') &&
            !Request::routeIs('maintenance') &&
            !Request::routeIs('signin') &&
            !Request::routeIs('signup') &&
            !Request::routeIs('lockscreen') &&
            !Request::routeIs('password-reset') &&
            !Request::routeIs('2Step') &&
            // Real Logins
            !Request::routeIs('login'))
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <script src="{{ asset('plugins/bootstrap/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
        <script src="{{ asset('plugins/mousetrap/mousetrap.min.js') }}"></script>
        <script src="{{ asset('plugins/waves/waves.min.js') }}"></script>
        <script src="{{ asset('plugins/highlight/highlight.pack.js') }}"></script>
        @if ($scrollspy == 1)
            @vite(['resources/assets/js/scrollspyNav.js'])
        @endif

        @if (Request::is('modern-light-menu/*'))
            @vite(['resources/layouts/modern-light-menu/app.js'])
        @elseif (Request::is('modern-dark-menu/*'))
            @vite(['resources/layouts/modern-dark-menu/app.js'])
        @elseif (Request::is('collapsible-menu/*'))
            @vite(['resources/layouts/collapsible-menu/app.js'])
        @elseif (Request::is('horizontal-light-menu/*'))
            @vite(['resources/layouts/horizontal-light-menu/app.js'])
        @elseif (Request::is('horizontal-dark-menu/*'))
            @vite(['resources/layouts/horizontal-dark-menu/app.js'])
        @else
            @vite(['resources/layouts/modern-light-menu/app.js'])
        @endif
        <!-- END GLOBAL MANDATORY STYLES -->

    @endif
    <script>
        window.Laravel = {
            csrfToken: "{{ csrf_token() }}",
            routes: {
                budgetImplementationStore: "{{ route('budget_implementation.store') }}",
                userStore: "{{ route('user.store') }}"
            }
            // Add other variables here
        };
    </script>
    @vite(['resources/js/app.js'])

    {{ $footerFiles }}
    <script type="module" src="{{ asset('plugins/font-icons/feather/feather.min.js') }}"></script>

    <script type="module">
        window.addEventListener('load', function() {
            feather.replace();
        })
    </script>

    <script>
        if (window.location.pathname !== '/login') {
            function updateClock() {
                const datetimeElement = document.getElementById('datetime-info');
                const currentDate = new Date();

                // Tentukan zona waktu
                let timezoneAbbreviation = '';
                const timezoneOffset = currentDate.getTimezoneOffset() / 60;
                if (timezoneOffset === -7) {
                    timezoneAbbreviation = 'WIB';
                } else if (timezoneOffset === -8) {
                    timezoneAbbreviation = 'WITA';
                } else if (timezoneOffset === -9) {
                    timezoneAbbreviation = 'WIT';
                }

                // Set zona waktu lokal ke Indonesia/Jakarta
                const options = {
                    weekday: 'long',
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    timeZone: 'Asia/Jakarta'
                };
                const formattedDatetime = currentDate.toLocaleString('id-ID', options);

                // Tampilkan informasi hari, tanggal, bulan, tahun, waktu lokal, dan zona waktu
                const fullDatetimeInfo = `${formattedDatetime} ${timezoneAbbreviation}`;
                datetimeElement.textContent = fullDatetimeInfo;
            }

            // Panggil updateClock setiap detik
            setInterval(updateClock, 1000);
        }
    </script>
</body>

</html>
