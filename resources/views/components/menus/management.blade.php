<x-menus.menu-item href="{{ $href }}" selectable="{{ $selectable }}" selected="{{ $selected }}">
    <x-slot name="content">
        <div class="z-20 me-1 inline-flex items-center bg-transparent justify-center">
            <div class="relative inline-flex items-center">
                <svg class="h-6 w-6 text-gray" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" />
                    <path d="M3.5 5.5l1.5 1.5l2.5 -2.5" />
                    <path d="M3.5 11.5l1.5 1.5l2.5 -2.5" />
                    <path d="M3.5 17.5l1.5 1.5l2.5 -2.5" />
                    <line x1="11" y1="6" x2="20" y2="6" />
                    <line x1="11" y1="12" x2="20" y2="12" />
                    <line x1="11" y1="18" x2="20" y2="18" />
                </svg>
                <div class="block sm:hidden ms-3 text-white">
                    <p>Management</p>
                </div>
            </div>
        </div>
    </x-slot>
</x-menus.menu-item>
