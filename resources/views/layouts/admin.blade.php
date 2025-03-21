<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <title>@yield('header-title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{asset('https://use.fontawesome.com/releases/v6.1.0/js/all.js')}}" crossorigin="anonymous"></script>
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app-admin.js'])


</head>

<body class="font-inter antialiased bg-slate-100 dark:bg-slate-900 text-slate-600 dark:text-slate-400"
    :class="{ 'sidebar-expanded': sidebarExpanded }" x-data="{ sidebarOpen: false, sidebarExpanded: localStorage.getItem('sidebar-expanded') == 'true' }" x-init="$watch('sidebarExpanded', value => localStorage.setItem('sidebar-expanded', value))">

    <!-- Page wrapper -->
    <div class="flex h-[100dvh] overflow-hidden">

        @include('layouts.admin_partials.sidebar')

        <!-- Content area-->
        <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden" x-ref="contentarea">

            @include('layouts.admin_partials.header')

            <main class="grow">
                @if (session('alert-msg'))
                    <x-alert type="{{ session('alert-type') ?? 'info' }}">
                        {!! session('alert-msg') !!}
                    </x-alert>
                @endif
                @if (!$errors->isEmpty())
                    <x-alert type="warning" message="Operation failed because there are validation errors!" />
                @endif
                @yield('main')
            </main>

        </div>

    </div>

</body>

</html>
