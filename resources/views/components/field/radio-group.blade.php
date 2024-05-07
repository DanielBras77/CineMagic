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
    }
@endphp
<div {{ $attributes->merge(['class' => "$widthClass"]) }}>
    <input name="{{ $name }}" type="hidden" value="">
    <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">
        {{ $label }}
    </label>
    <div class="flex flex-wrap ps-2">
        @foreach ($options as $key => $optionText)
            <div class="h-10 pe-12 inline-flex items-center">
                <input id="id_{{ $name }}_{{$key}}" name="{{ $name }}" type="radio" value="{{ $key }}"
                    {{ $value == $key ? 'checked' : '' }}
                    class="appearance-none
                        mt-0.5 w-6 h-6
                        bg-white dark:bg-gray-900
                        text-black dark:text-gray-50
                        @error($name)
                            border-red-500 dark:border-red-500
                        @else
                            border-gray-300 dark:border-gray-700
                        @enderror
                        focus:border-indigo-500 dark:focus:border-indigo-400
                        focus:ring-indigo-500 dark:focus:ring-indigo-400
                        rounded-full shadow-sm
                        disabled:text-gray-500
                        disabled:shadow-none
                        disabled:opacity-100
                        disabled:select-none"
                        @required($required)
                        @disabled($readonly)
                        autofocus="autofocus"
                    >
                <label class="ml-2 font-normal text-base text-black dark:text-gray-50" for="id_{{ $name }}_{{$key}}">
                    {{ $optionText }}
                </label>
            </div>
        @endforeach
    </div>
    @error( $name )
        <div class="text-sm text-red-500">
            {{ $message }}
        </div>
    @enderror
</div>
