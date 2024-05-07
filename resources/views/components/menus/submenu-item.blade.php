@if($selectable)
    @if($selected)
        <a class="px-3 py-4 border-b-2 border-b-indigo-400 dark:border-b-indigo-500
                text-sm font-medium leading-5 inline-flex h-auto
                text-gray-900 dark:text-gray-100
                hover:text-gray-700 dark:hover:text-gray-300
                hover:bg-gray-100 dark:hover:bg-gray-800
                focus:outline-none focus:border-indigo-700 dark:focus:border-indigo-300"
            href="{{ $href }}">
            {{ $content }}
        </a>
    @else
        <a class="px-3 py-4 border-b-2 border-transparent
                text-sm font-medium leading-5 inline-flex h-auto
                text-gray-500 dark:text-gray-400
                hover:border-gray-300 dark:hover:border-gray-700
                hover:text-gray-700 dark:hover:text-gray-300
                hover:bg-gray-100 dark:hover:bg-gray-800

                focus:outline-none focus:border-gray-300 dark:focus:border-gray-700
                focus:text-gray-700 dark:focus:text-gray-300"
            href="{{ $href }}">
            {{ $content }}
        </a>
    @endif
@else
    <a class="px-3 py-4 border-b-2 border-transparent
                text-sm font-medium leading-5 inline-flex h-auto
                text-gray-500 dark:text-gray-400
                hover:text-gray-700 dark:hover:text-gray-300
                hover:bg-gray-100 dark:hover:bg-gray-800

                focus:outline-none
                focus:text-gray-700 dark:focus:text-gray-300
                focus:bg-gray-100 dark:focus:bg-gray-800"
            href="{{ $href }}">
        {{ $content }}
    </a>
@endif
