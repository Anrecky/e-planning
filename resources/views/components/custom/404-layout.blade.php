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
    @vite(['resources/layouts/modern-light-menu/loader.js'])

    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/bootstrap/bootstrap.min.css') }}">
    @vite(['resources/scss/light/assets/main.scss', 'resources/scss/dark/assets/main.scss'])

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    {{ $headerFiles }}
    <!-- END GLOBAL MANDATORY STYLES -->
</head>

<body @class([
    // 'layout-dark' => $isDark,
    'layout-boxed' => $isBoxed,
    'alt-menu' =>
        $isAltMenu || Request::routeIs('collapsibleMenu') ? true : false,
    'error' => true,
    'maintanence' => Request::routeIs('maintenance') ? true : false,
])
    @if ($scrollspy == 1) {{ $scrollspyConfig }} @else {{ '' }} @endif
    @if (Request::routeIs('fullWidth')) layout="full-width" @endif>

    <!-- BEGIN LOADER -->
    <x-layout-loader />
    <!--  END LOADER -->

    {{ $slot }}

    @vite(['resources/js/app.js'])
    {{ $footerFiles }}
    <script type="module" src="{{ asset('plugins/font-icons/feather/feather.min.js') }}"></script>

    <script type="module">
        window.addEventListener('load', function() {
            feather.replace();
        })
    </script>
</body>

</html>
