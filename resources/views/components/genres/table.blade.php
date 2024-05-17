<div {{ $attributes }}>
    <table class="table-auto border-collapse">
        <thead>
        <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
            <th class="px-2 py-2 text-left hidden lg:table-cell">Code</th>
            <th class="px-2 py-2 text-left">Name</th>
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
        @foreach ($genres as $genre)
            <tr class="border-b border-b-gray-400 dark:border-b-gray-500">
                <td class="px-2 py-2 text-left hidden lg:table-cell">{{ $genre->code }}</td>
                <td class="px-2 py-2 text-left">{{ $genre->name }}</td>
                @if($showView)
                    @can('view', $genre)
                        <td>
                            <x-table.icon-show class="ps-3 px-0.5"
                                href="{{ route('genres.show', ['genre' => $genre]) }}"/>
                        </td>
                    @else
                        <td></td>
                    @endcan
                @endif
                @if($showEdit)
                    @can('update', $genre)
                        <td>
                            <x-table.icon-edit class="px-0.5"
                                href="{{ route('genres.edit', ['genre' => $genre]) }}"/>
                        </td>
                    @else
                        <td></td>
                    @endcan
                @endif
                @if($showDelete)
                    @can('delete', $genre)
                        <td>
                            <x-table.icon-delete class="px-0.5"
                                action="{{ route('genres.destroy', ['genre' => $genre]) }}"/>
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
