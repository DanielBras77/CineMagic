{{--
    NOTE: we've used the match to define multiple versions of the button (by Type),
    to ensure that all specific color related classes are defined statically
    on the source code - this guarantees that the Tailwind builder
    detects the corresponding class.
    If we had used dynamically generated classes (e.g. "bg-{{ $color }}-800") then
    the builder would not detect concrete values.
    Check documentation about dynamic classes:
    https://tailwindcss.com/docs/content-configuration#dynamic-class-names
--}}
@php
    $colors = match($type) {
        'primary' => 'text-white dark:text-gray-900
                        bg-blue-600 dark:bg-blue-400
                        hover:bg-blue-700 dark:hover:bg-blue-300
                        focus:bg-blue-700 dark:focus:bg-blue-300
                        active:bg-blue-800 dark:active:bg-blue-200',
        'secondary' => 'text-white dark:text-gray-700
                        bg-gray-500 dark:bg-gray-400
                        hover:bg-gray-600 dark:hover:bg-gray-300
                        focus:bg-gray-600 dark:focus:bg-gray-300
                        active:bg-gray-700 dark:active:bg-gray-200',
        'success' => 'text-white dark:text-gray-900
                        bg-green-700 dark:bg-green-200
                        hover:bg-green-800 dark:hover:bg-green-100
                        focus:bg-green-800 dark:focus:bg-green-100
                        active:bg-green-900 dark:active:bg-green-100',
        'danger' => 'text-white dark:text-gray-900
                        bg-red-600 dark:bg-red-200
                        hover:bg-red-700 dark:hover:bg-red-100
                        focus:bg-red-700 dark:focus:bg-red-100
                        active:bg-red-800 dark:active:bg-red-100',
        'warning' => 'text-gray-900 dark:text-gray-200
                        bg-amber-400 dark:bg-amber-600
                        hover:bg-amber-300 dark:hover:bg-amber-700
                        focus:bg-amber-300 dark:focus:bg-amber-700
                        active:bg-amber-300 dark:active:bg-amber-700',
        'info' => 'text-gray-900 dark:text-gray-200
                        bg-cyan-400 dark:bg-cyan-600
                        hover:bg-cyan-300 dark:hover:bg-cyan-700
                        focus:bg-cyan-300 dark:focus:bg-cyan-700
                        active:bg-cyan-300 dark:active:bg-cyan-700',
        'light' => 'text-gray-900 dark:text-gray-200
                        bg-slate-50 dark:bg-slate-600
                        hover:bg-slate-200 dark:hover:bg-slate-700
                        focus:bg-slate-200 dark:focus:bg-slate-700
                        active:bg-slate-200 dark:active:bg-slate-700',
        'link' => 'text-blue-500
                        border-gray-200',
        default => 'text-white dark:text-gray-900
                        bg-gray-800 dark:bg-gray-200
                        hover:bg-gray-900 dark:hover:bg-gray-100
                        focus:bg-gray-900 dark:focus:bg-gray-100
                        active:bg-gray-950 dark:active:bg-gray-50',
    }
@endphp
<div {{ $attributes }}>
    @if ($element == 'a')
        <a href="{{ $href }}"
            class="px-4 py-2 inline-block border border-transparent rounded-md
                    font-medium text-sm tracking-widest
                    focus:outline-none focus:ring-2
                    focus:ring-indigo-500 dark:focus:ring-indigo-400
                    focus:ring-offset-2 transition ease-in-out duration-150 {{ $colors }}">
            {{ $text }}
        </a>
    @else
        <button type="{{ $element }}" {{ $buttonName ? "name='$buttonName'" : '' }}
            @if(($element == 'submit') && ($attributes->has('form')))
                {{ $attributes->merge(['form' => '#']) }}
            @endif
            class="px-4 py-2 inline-block border border-transparent rounded-md
                    font-medium text-sm tracking-widest
                    focus:outline-none focus:ring-2
                    focus:ring-indigo-500 dark:focus:ring-indigo-400
                    focus:ring-offset-2 transition ease-in-out duration-150 {{ $colors }}">
            {{ $text }}
        </button>
    @endif
</div>
