@php
$colors = match($type) {
'primary' => 'text-blue-900 dark:text-blue-500
bg-blue-200 dark:bg-gray-800
border-blue-500 dark:border-blue-800',
'secondary' => 'text-gray-900 dark:text-gray-400
bg-gray-200 dark:bg-gray-800
border-gray-500 dark:border-gray-600',
'success' => 'text-green-800 dark:text-green-300
border-green-300 dark:border-green-700
bg-green-50 dark:bg-gray-800',
'danger' => 'text-red-800 dark:text-red-400
border-red-300 dark:border-red-700
bg-red-50 dark:bg-gray-800',
'warning' => 'text-yellow-800 dark:text-yellow-500
border-yellow-300 dark:border-yellow-600
bg-yellow-50 dark:bg-gray-800',
'info' => 'text-blue-800 dark:text-blue-400
bg-blue-50 dark:bg-gray-800
border-blue-300 dark:border-blue-900',
'light' => 'text-gray-500 dark:text-gray-600
bg-gray-50 dark:bg-gray-800
border-gray-300 dark:border-gray-700',
default => 'text-white dark:text-gray-900
bg-gray-800 dark:bg-gray-200
border-gray-950 dark:border-gray-50',
}
@endphp
<div id="{{ $randomId }}" {{ $attributes->merge(['class' =>
'flex items-center p-4 ps-8 mb-2
text-sm font-medium
border rounded-lg ' . $colors]) }}>
    <div>
        @if ($slot->isEmpty())
        {{ $message }}
        @else
        {{ $slot }}
        @endif
    </div>
    <button type="button" class="ms-auto -mx-1.5 -my-1.5 p-1.5 rounded-lg
inline-flex items-center justify-center h-8 w-8" onclick="document.getElementById('{{ $randomId }}').style.display = 'none'">
        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
        </svg>
    </button>
</div>
