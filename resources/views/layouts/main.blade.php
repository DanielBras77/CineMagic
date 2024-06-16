<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Icon and Title -->
    <title>CineMagic</title>
    @vite('resources/js/app.js')
    <link rel="icon" type="image/png" href="../../../img/logoCinemagic.png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{asset('https://use.fontawesome.com/releases/v6.1.0/js/all.js')}}" crossorigin="anonymous"></script>
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;700&display=swap" rel="stylesheet">

    <!-- Scripts AND CSS Fileds -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-800">
        <!-- Navigation Menu -->
        <nav class="bg-white border-b border-gray-100 dark:bg-gray-900 dark:border-gray-800">
            <!-- Navigation Menu Full Container -->
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Logo + Menu Items + Hamburger -->
                <div class="relative flex flex-col justify-between px-6 sm:flex-row sm:px-0 grow">
                    <!-- Logo -->
                    <div class="shrink-0 -ms-4">
                        <a href="{{ route('home')}}">
                            <div class="h-16 w-20 bg-no-repeat bg-center bg-contain bg-[url('../img/logoCinemagic.png')] dark:bg-[url('../img/logoCinemagic.png')]"></div>
                        </a>
                    </div>
                    <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">CineMagic</span>

                    <!-- Menu Items -->
                    <div id="menu-container" class="flex flex-col items-stretch invisible h-0 grow sm:flex-row sm:visible sm:h-auto ms-14">
                        <form class="mt-3 mx-auto flex justify-center w-full">
                            <div class="relative w-full max-w-lg">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 mb-2 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                    </svg>
                                </div>
                                <input type="search" id="default-search" class="block w-full p-2.5 ps-10 text-sm text-gray-900 border border-gray-300 rounded-full bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search Movies" required />
                                <x-button element="submit" class="text-white text-sm mt-[-4px] absolute end-2.5 top-1/2 transform -translate-y-1/2 " type="dark" text="Search" />
                            </div>
                        </form>

                        @auth

                        <!-- Menu Item: Cart -->
                        @if(Auth::user()->type == 'C')
                        <x-menus.cart href="{{ route('cart.show') }}" selectable="0" selected="1" total="{{ session('total_seats', 0) }}" />
                        @endif

                        <x-menus.submenu selectable="0" uniqueName="submenu_user">
                            <x-slot:content>
                                <div class="pe-1">
                                    <img src="{{ Auth::user()->photoFullUrl}}" class="rounded-full w-11 h-11 min-w-11 min-h-11">
                                </div>
                                <div class="ps-1 sm:max-w-[calc(100vw-39rem)] md:max-w-[calc(100vw-41rem)] lg:max-w-[calc(100vw-46rem)] xl:max-w-[34rem] truncate">
                                    {{ Auth::user()->name }}
                                </div>
                                </x-slot>
                                <hr>
                                @if(Auth::user()->type == 'A')
                                <x-menus.submenu-item content="Dashboard" selectable="0" href="{{route('dashboard')}}" />
                                @endif
                                @if(Auth::user()->type == 'C')
                                <x-menus.submenu-item content="Profile" selectable="0" href="{{ route('profile.edit') }}" />
                                @endif
                                @if(Auth::user()->type == 'C')
                                <x-menus.submenu-item content="Histórico" selectable="0" href="{{ route('purchase.history') }}" />
                                @endif

                                <hr>
                                <form id="form_to_logout_from_menu" method="POST" action="{{ route('logout') }}" class="hidden">
                                    @csrf
                                </form>
                                <a class="px-3 py-4 border-b-2 border-transparent
                                        text-sm font-medium leading-5 inline-flex h-auto
                                        text-gray-500 dark:text-gray-400
                                        hover:text-gray-700 dark:hover:text-gray-300
                                        hover:bg-gray-100 dark:hover:bg-gray-800
                                        focus:outline-none
                                        focus:text-gray-700 dark:focus:text-gray-300
                                        focus:bg-gray-100 dark:focus:bg-gray-800" href="#" onclick="event.preventDefault();
                                    document.getElementById('form_to_logout_from_menu').submit();">
                                    Log Out
                                </a>
                        </x-menus.submenu>

                        @else
                        <!-- Menu Item: Login -->
                        <x-menus.menu-item content="Login" selectable="1" href="{{ route('login') }}" selected="{{ Route::currentRouteName() == 'login'}}" />

                        <!--Menu Item: Registo -->
                        <x-menus.menu-item content="Register" selectable="1" href="{{ route('register') }}" selected="{{ Route::currentRouteName() == 'register'}}" />
                        @endauth
                    </div>
                    <!-- Hamburger -->
                    <div class="absolute top-0 right-0 flex pt-3 text-black sm:hidden pe-3 dark:text-gray-50">
                        <button id="hamburger_btn">
                            <svg class="w-8 h-8" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path id="hamburger_btn_open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                <path class="invisible" id="hamburger_btn_close" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <main>
            <div class="py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
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
    @vite('resources/js/app.js')
</body>

</html>
