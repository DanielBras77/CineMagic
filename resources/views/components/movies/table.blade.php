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
                    <img src="{{$movie->posterFullUrl}}" alt="Movie poster" width="100">
                </td>
                <td class="px-2 py-2 text-left">{{ $movie->title }}</td>


                <td class="border px-4 py-2">{{ $movie->genre->name }}</td>
                <td class="border px-4 py-2">{{ $movie->year }}</td>
                @if($showView)
                    @can('view', $movie)
                        <td>
                            <x-table.icon-show class="ps-3 px-0.5"
                                href="{{ route('movies.show', ['movie' => $movie]) }}"/>
                        </td>
                    @else
                        <td></td>
                    @endcan
                @endif
                @if($showEdit)
                    @can('update', $movie)
                        <td>
                            <x-table.icon-edit class="px-0.5"
                                href="{{ route('movies.edit', ['movie' => $movie]) }}"/>
                        </td>
                    @else
                        <td></td>
                    @endcan
                @endif
                @if($showDelete)
                    @can('delete', $movie)
                        <td>
                            <x-table.icon-delete class="px-0.5"
                                action="{{ route('movies.destroy', ['movie' => $movie]) }}"/>
                        </td>
                    @else
                        <td></td>
                    @endcan
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
