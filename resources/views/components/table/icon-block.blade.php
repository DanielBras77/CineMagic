<div {{ $attributes->merge(['class' => ($blocked? 'hover:text-red-600': 'hover:text-green-600')]) }}>
    <form method="POST" action="{{ $action }}" class="w-6 h-6">
        @csrf
        @method('PATCH')
        <button type="submit" name="delete" class="w-6 h-6">

            @if ($blocked)

            <svg class="h-6 w-6 hover:stroke-2"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="1"  stroke-linecap="round"  stroke-linejoin="round">  <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />  <path d="M7 11V7a5 5 0 0 1 10 0v4" /></svg>
            @else

            <svg class="h-6 w-6 hover:stroke-2"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="1"  stroke-linecap="round"  stroke-linejoin="round">  <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />  <path d="M7 11V7a5 5 0 0 1 9.9-1" /></svg>
            @endif

            </svg>
        </button>
    </form>
</div>
