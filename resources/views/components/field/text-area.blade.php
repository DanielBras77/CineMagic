@php
    $widthClass = match($width) {
        'full' => 'w-full',
        'xs' => 'w-20',
        'sm' => 'w-32',
        'md' => 'w-64',
        'lg' => 'w-96',
        'xl' => 'w-[48rem]',
        '1/3' => 'w-1/3',
        '2/3' => 'w-2/3',
        '1/4' => 'w-1/4',
        '2/4' => 'w-2/4',
        '3/4' => 'w-3/4',
        '1/5' => 'w-1/5',
        '2/5' => 'w-2/5',
        '3/5' => 'w-3/5',
        '4/5' => 'w-4/5',
    };
    $heightClass = match($height) {
        'xs' => 'h-[63px]',
        'sm' => 'h-[88px]',
        'md' => 'h-[134px]',
        'lg' => 'h-[206px]',
        'xl' => 'h-[420px]',
    };
@endphp
<div {{ $attributes->merge(['class' => "$widthClass"]) }}>
    <label class="block font-medium text-sm text-gray-700 dark:text-gray-300" for="id_{{ $name }}">
        {{ $label }}
    </label>
    <textarea id="id_{{ $name }}" name="{{ $name }}"
        class="appearance-none block
            mt-1 w-full {{ $heightClass }}
            bg-white dark:bg-gray-900
            text-black dark:text-gray-50
            @error($name)
                border-red-500 dark:border-red-500
            @else
                border-gray-300 dark:border-gray-700
            @enderror
            focus:border-indigo-500 dark:focus:border-indigo-400
            focus:ring-indigo-500 dark:focus:ring-indigo-400
            rounded-md shadow-sm
            disabled:rounded-none disabled:shadow-none
            disabled:border-transparent
            disabled:opacity-100
            disabled:select-none
            {{ !$resizable || $readonly ? 'resize-none' : 'resize-y' }}"
            @required($required)
            @disabled($readonly)
            autofocus="autofocus"
        >{{ $value }}</textarea>
    @error( $name )
        <div class="text-sm text-red-500">
            {{ $message }}
        </div>
    @enderror
</div>
