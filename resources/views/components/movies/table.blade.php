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


        <div {{ $attributes }}>
            <table class="table-auto border-collapse">
                <thead>
                    <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
                        <th class="px-2 py-2 text-left">Photo</th>
                        <th class="px-2 py-2 text-left">Title</th>
                        <th class="px-2 py-2 text-left">Genre</th>
                        <th class="px-2 py-2 text-left">Year</th>
                        @if($showView)
                        <th></th>
                        @endif
                        @if($showEdit)
                        <th></th>
                        @endif
                        @if($showDelete)
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>

                    @foreach ($movies as $movie)
                    <tr class="border-b border-b-gray-400 dark:border-b-gray-500">
                        <td class="px-2 py-2 text-left">
                            <img src="{{$theater->photoFullUrl}}" alt="Movie poster" width="100">
                        </td>
                        <td class="px-2 py-2 text-left">{{ $movie->title }}
                            
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
