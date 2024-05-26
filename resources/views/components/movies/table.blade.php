<div {{ $attributes->merge(['class' => 'overflow-x-auto']) }}>
    <table class="min-w-full bg-white dark:bg-gray-800">
        <thead>
            <tr>
                <th class="px-4 py-2">Title</th>
                @if($showGenre)
                    <th class="px-4 py-2">Genre</th>
                @endif
                <th class="px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($movies as $movie)
                <tr>
                    <td class="border px-4 py-2">{{ $movie->title }}</td>
                    @if($showGenre)
                        <td class="border px-4 py-2">{{ $movie->genre->name }}</td>
                    @endif
                    <td class="border px-4 py-2">
                        @if($showView)
                            <a href="{{ route('movies.show', $movie) }}" class="text-blue-500">View</a>
                        @endif
                        @if($showEdit)
                            <a href="{{ route('movies.edit', $movie) }}" class="text-yellow-500">Edit</a>
                        @endif
                        @if($showDelete)
                            <form action="{{ route('movies.destroy', $movie) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500">Delete</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
