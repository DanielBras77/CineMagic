<div {{ $attributes->merge(['class' => 'hover:text-red-600']) }}>
    <form method="POST" action="{{ $action }}"  class="w-6 h-6">
        @csrf
        @if(strtoupper($method) != 'POST')
            @method(strtoupper($method))
        @endif
        <button type="submit" name="minus" class="w-6 h-6">
            <svg  class="hover:stroke-2 w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
        </button>
    </form>
</div>
