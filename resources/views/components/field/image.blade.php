{{--
    NOTE: we've used the match to define multiple versions of width class,
    to ensure that all specific width related classes are defined statically
    on the source code - this guarantees that the Tailwind builder
    detects the corresponding class.
    If we had used dynamically generated classes (e.g. "w-{{ $width }}") then
    the builder would not detect concrete values.
    Check documentation about dynamic classes:
    https://tailwindcss.com/docs/content-configuration#dynamic-class-names
--}}
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

    $maxHeightClass = match($width) {
        'full' => 'max-h-full',
        'xs' => 'max-h-32',
        'sm' => 'max-h-48',
        'md' => 'max-h-96',
        'lg' => 'max-h-[36rem]',
        'xl' => 'max-h-[72rem]',
        '1/3', '2/3', '1/4', '2/4', '3/4', '1/5', '2/5', '3/5', '4/5'  => 'max-h-full',
    };
@endphp
<div {{ $attributes }}>
    <div class="flex-col">
        <div class="block font-medium text-sm text-gray-700 dark:text-gray-300 mt-6">
            {{ $label }}
        </div>
        <img class="{{$widthClass}} {{$maxHeightClass}} aspect-auto"
             src="{{ $imageUrl }}">
        @if(!$readonly)
        <div class="{{$widthClass}} flex-col space-y-4 items-stretch mt-4">
            <div>
                <div class="flex flex-row items-center">
                    <input id="id_{{ $name }}" name="{{ $name }}" type="file"
                        accept="image/png, image/jpeg"
                        onchange="document.getElementById('id_{{ $name }}_selected_file').innerHTML= document.getElementById('id_{{ $name }}').files[0].name ?? ''"
                        class="hidden"/>
                        <label for="id_{{ $name }}"
                            class="min-w-32
                            px-4 py-2 mr-2 inline-block border border-transparent
                            rounded-md
                            font-medium text-sm tracking-widest
                            focus:outline-none focus:ring-2
                            focus:ring-indigo-500 dark:focus:ring-indigo-400
                            focus:ring-offset-2 transition ease-in-out duration-150
                            text-white dark:text-gray-900
                            bg-gray-800 dark:bg-gray-200
                            hover:bg-gray-900 dark:hover:bg-gray-100
                            focus:bg-gray-900 dark:focus:bg-gray-100
                            active:bg-gray-950 dark:active:bg-gray-50
                            cursor-pointer"
                        >Choose file</label>
                        <label id="id_{{ $name }}_selected_file"
                            class="text-sm text-slate-500 truncate"></label>
                    </div>
                @error( $name )
                    <div class="text-sm text-red-500">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            @if($deleteAllow)
            <div>
                <x-button
                    element="submit"
                    :text="$deleteTitle"
                    type="danger"
                    form="{{ $deleteForm }}"
                    />
            </div>
            @endif
        </div>
        @endif
    </div>
</div>
