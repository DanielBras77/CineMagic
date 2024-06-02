<div>
    <!-- Sidebar backdrop (mobile only) -->
    <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-40 lg:hidden lg:z-auto transition-opacity duration-200" :class="sidebarOpen ? 'opacity-100' : 'opacity-0 pointer-events-none'" aria-hidden="true" x-cloak></div>

    <!-- Sidebar -->
    <div id="sidebar" class="flex flex-col absolute z-40 left-0 top-0 lg:static lg:left-auto lg:top-auto lg:translate-x-0 h-screen overflow-y-scroll lg:overflow-y-auto no-scrollbar w-64 lg:w-20 lg:sidebar-expanded:!w-64 2xl:!w-64 shrink-0 bg-slate-800 p-4 transition-all duration-200 ease-in-out" :class="sidebarOpen ? 'translate-x-0' : '-translate-x-64'" @click.outside="sidebarOpen = false" @keydown.escape.window="sidebarOpen = false" x-cloak="lg">

        <!-- Sidebar header -->
        <div class="flex justify-between mb-10 pr-3 sm:px-1">
            <!-- Close button -->
            <button class="lg:hidden text-slate-500 hover:text-slate-400" @click.stop="sidebarOpen = !sidebarOpen" aria-controls="sidebar" :aria-expanded="sidebarOpen">
                <span class="sr-only">Close sidebar</span>
                <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.7 18.7l1.4-1.4L7.8 13H20v-2H7.8l4.3-4.3-1.4-1.4L4 12z" />
                </svg>
            </button>
            <!-- Logo -->
            <div class="hidden lg:sidebar-expanded:block text-xl pt-1 text-white">Dashboard</div>
            <a class="block" href="#">
                <svg class="w-[35px] h-[35px] text-white" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" />
                    <line x1="4" y1="19" x2="20" y2="19" />
                    <polyline points="4 15 8 9 12 11 16 6 20 10" />
                </svg>
            </a>
        </div>

        <!-- Links -->
        <div class="space-y-8">
            <!-- Pages group -->
            <div>

                <h3 class="text-xs uppercase text-slate-500 font-semibold pl-3">
                    <span class="hidden lg:block lg:sidebar-expanded:hidden 2xl:hidden text-center w-6" aria-hidden="true">•••</span>
                    <span class="lg:hidden lg:sidebar-expanded:block 2xl:block">Pages</span>
                </h3>
                <ul class="mt-3">
                    <!-- Dashboard -->

                    @can('viewAny', App\Models\Genre::class)
                    @php
                    $options = [];
                    $options['All Genres'] = route('genres.index');
                    @endphp

                    @can('create', App\Models\Genre::class)
                    @php
                    $options['Add Genre'] = route('genres.create');
                    @endphp
                    @endcan
                    <x-menus.admin-group-menu-items title="Genres" :options="$options">
                        <svg class="w-6 h-6 text-gray-400 dark:text-white" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" />
                            <rect x="4" y="4" width="16" height="16" rx="2" />
                            <line x1="4" y1="12" x2="20" y2="12" />
                            <line x1="12" y1="4" x2="12" y2="20" />
                        </svg>


                    </x-menus.admin-group-menu-items>
                    @endcan

                    @can('viewAny', App\Models\Theater::class)
                    @php
                    $options = [];
                    $options['All Theaters'] = route('theaters.index');
                    @endphp

                    @can('create', App\Models\Theater::class)
                    @php
                    $options['Add Theater'] = route('theaters.create');
                    @endphp
                    @endcan
                    <x-menus.admin-group-menu-items class="mt-2" title="Theaters" :options="$options">
                        <svg class="w-6 h-6 text-gray-400 dark:text-white" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" />
                            <line x1="3" y1="21" x2="21" y2="21" />
                            <line x1="3" y1="10" x2="21" y2="10" />
                            <polyline points="5 6 12 3 19 6" />
                            <line x1="4" y1="10" x2="4" y2="21" />
                            <line x1="20" y1="10" x2="20" y2="21" />
                            <line x1="8" y1="14" x2="8" y2="17" />
                            <line x1="12" y1="14" x2="12" y2="17" />
                            <line x1="16" y1="14" x2="16" y2="17" />
                        </svg>

                    </x-menus.admin-group-menu-items>
                    @endcan


                    @can('viewAny', App\Models\Movie::class)
                    @php
                    $options = [];
                    $options['All Movies'] = route('movies.index');
                    @endphp

                    @can('create', App\Models\Movie::class)
                    @php
                    $options['Add Movie'] = route('movies.create');
                    @endphp
                    @endcan
                    <x-menus.admin-group-menu-items class="mt-2" title="Movies" :options="$options">
                        <svg class="w-6 h-6 text-gray-400 dark:text-white" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="2" width="20" height="20" rx="2.18" ry="2.18" />
                            <line x1="7" y1="2" x2="7" y2="22" />
                            <line x1="17" y1="2" x2="17" y2="22" />
                            <line x1="2" y1="12" x2="22" y2="12" />
                            <line x1="2" y1="7" x2="7" y2="7" />
                            <line x1="2" y1="17" x2="7" y2="17" />
                            <line x1="17" y1="17" x2="22" y2="17" />
                            <line x1="17" y1="7" x2="22" y2="7" />
                        </svg>
                    </x-menus.admin-group-menu-items>
                    @endcan

                    <!-- Only one option -->
                    <x-menus.admin-group-menu-items class="mt-2" title="Voltar ao site" :options="['Home' => route('home')]">
                        <svg class="w-6 h-6 text-gray-400 dark:text-white" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" />
                            <polyline points="5 12 3 12 12 3 21 12 19 12" />
                            <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                            <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                        </svg>
                    </x-menus.admin-group-menu-items>

                </ul>

            </div>

        </div>

        <!-- Expand / collapse button -->
        <div class="pt-3 hidden lg:inline-flex 2xl:hidden justify-end mt-auto">
            <div class="px-3 py-2">
                <button @click="sidebarExpanded = !sidebarExpanded">
                    <span class="sr-only">Expand / collapse sidebar</span>
                    <svg class="w-6 h-6 fill-current sidebar-expanded:rotate-180" viewBox="0 0 24 24">
                        <path class="text-slate-400" d="M19.586 11l-5-5L16 4.586 23.414 12 16 19.414 14.586 18l5-5H7v-2z" />
                        <path class="text-slate-600" d="M3 23H1V1h2z" />
                    </svg>
                </button>
            </div>
        </div>

    </div>
</div>
