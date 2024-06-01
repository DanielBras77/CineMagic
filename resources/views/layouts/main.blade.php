<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Icon and Title -->
    <title>CineMagic</title>
    <link rel="icon" type="image/png" href="../../../img/logoCinemagic.png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;700&display=swap" rel="stylesheet">

    <!-- Scripts AND CSS Fileds -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-800">
        <!-- Navigation Menu -->
        <nav class="bg-white dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800">
            <!-- Navigation Menu Full Container -->
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Logo + Menu Items + Hamburger -->
                <div class="relative flex flex-col sm:flex-row px-6 sm:px-0 grow justify-between">
                    <!-- Logo -->
                    <div class="shrink-0 -ms-4">
                        <a href="{{ route('home')}}">
                            <div class="h-16 w-20 bg-no-repeat bg-center bg-contain bg-[url('../img/logoCinemagic.png')] dark:bg-[url('../img/logoCinemagic.png')]"></div>
                        </a>
                    </div>
                    <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">CineMagic</span>

                    <!-- Menu Items -->
                    <div id="menu-container" class="grow flex flex-col sm:flex-row items-stretch
                    invisible h-0 sm:visible sm:h-auto ms-14">

                        <!-- Menu Item: Home
                        <x-menus.menu-item content="Home" href="#" selected="#" />-->
                        <!-- Menu Item: Movies
                        <x-menus.menu-item content="Movies" selectable="1" href="{{ route('movies.index') }}" selected="{{ Route::currentRouteName() == 'movies.index'}}" />
                        -->

                        <form class="mt-3 mx-auto">
                            <div class="absolute">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                    </svg>
                                </div>
                                <input type="search" id="default-search" class="block w-full p-2.5 ps-10 text-sm text-gray-900 border border-gray-300 rounded-full bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search Movies" required />
                                <x-button element="submit" class="text-white absolute end-2.5 bottom-0.5" type="dark" text="Search" />
                            </div>
                        </form>


                        <!-- <div class="grow"></div> -->


                        <!-- Menu Item: Cart -->
                        <x-menus.cart href="#" selectable="0" selected="1" total="2" />

                        @auth
                        <x-menus.submenu selectable="0" uniqueName="submenu_user">
                            <x-slot:content>
                                <div class="pe-1">
                                    <img src="{{ Auth::user()->photoFullUrl}}" class="w-11 h-11 min-w-11 min-h-11 rounded-full">
                                </div>
                                {{-- ATENÇÃO - ALTERAR FORMULA DE CALCULO DAS LARGURAS MÁXIMAS QUANDO O MENU FOR ALTERADO --}}
                                <div class="ps-1 sm:max-w-[calc(100vw-39rem)] md:max-w-[calc(100vw-41rem)] lg:max-w-[calc(100vw-46rem)] xl:max-w-[34rem] truncate">
                                    {{ Auth::user()->name }}
                                </div>
                                </x-slot>
                                <hr>
                                <x-menus.submenu-item content="Dashboard" selectable="0" href="{{route('dashboard')}}" />
                                <x-menus.submenu-item content="Profile" selectable="0" href="#" />
                                <x-menus.submenu-item content="Change Password" selectable="0" href="{{ route('profile.edit.password') }}" />

                                <hr>
                                <form id="form_to_logout_from_menu" method="POST" action="{{ route('logout') }}" class="hidden">
                                    @csrf
                                </form>
                                <x-menus.submenu-item content="Log Out" selectable="0" form="form_to_logout_from_menu" />
                        </x-menus.submenu>
                        @else
                        <!-- Menu Item: Login -->
                        <x-menus.menu-item content="Login" selectable="1" href="{{ route('login') }}" selected="{{ Route::currentRouteName() == 'login'}}" />
                        @endauth
                    </div>
                    <!-- Hamburger -->
                    <div class="absolute right-0 top-0 flex sm:hidden pt-3 pe-3 text-black dark:text-gray-50">
                        <button id="hamburger_btn">
                            <svg class="h-8 w-8" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path id="hamburger_btn_open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                <path class="invisible" id="hamburger_btn_close" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Heading -->
        <!--<header class="bg-white dark:bg-gray-900 shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    @yield('header-title')
                </h2>
            </div>
        </header>-->

        <main>
            <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                @if (session('alert-msg'))
                <x-alert type="{{ session('alert-type') ?? 'info' }}">
                    {!! session('alert-msg') !!}
                </x-alert>
                @endif
                @if (!$errors->isEmpty())
                <x-alert type="warning" message="Operation failed because there are validation errors!" />
                @endif
                @yield('main')
            </div>
        </main>
    </div>
</body>

</html>
