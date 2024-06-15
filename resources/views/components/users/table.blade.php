<div {{ $attributes }}>
    <table class="table-auto border-collapse">
        <thead>
        <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
            <th class="px-2 py-2 text-left">Name</th>
            <th class="px-2 py-2 text-left hidden lg:table-cell">Email</th>
            <th class="px-2 py-2 text-left">Type</th>
            @if($showView)
                <th></th>
            @endif
            @if($showEdit)
                <th></th>
            @endif
            @if($showDelete)
                <th></th>
            @endif
            @if($showBlock)
                <th></th>
            @endif
        </tr>
        </thead>
        <tbody>
        @foreach ($users as $user)
            <tr class="border-b border-b-gray-400 dark:border-b-gray-500">
                <td class="px-2 py-2 text-left">{{ $user->name }}</td>
                <td class="px-2 py-2 text-left hidden lg:table-cell">{{ $user->email }}</td>
                <td class="px-2 py-2 text-left">{{ $user->type == 'E' ? 'Employee' : 'Admin' }}</td>
                @if($showView)
                    @can('view', $user)
                        <td>
                            <x-table.icon-show class="ps-3 px-0.5"
                                href="{{ route('users.show', ['user' => $user]) }}"/>
                        </td>
                    @else
                        <td></td>
                    @endcan
                @endif
                @if($showEdit)
                    @can('update', $user)
                        <td>
                            <x-table.icon-edit class="px-0.5"
                                href="{{ route('users.edit', ['user' => $user]) }}"/>
                        </td>
                    @else
                        <td></td>
                    @endcan
                @endif
                @if($showDelete)
                    @can('delete', $user)
                        <td>
                            <x-table.icon-delete class="px-0.5"
                                action="{{ route('users.destroy', ['user' => $user]) }}"/>
                        </td>
                    @else
                        <td></td>
                    @endcan
                @endif
                @if($showBlock)
                    @can('update', $user)
                        <td>
                            <x-table.icon-block class="px-0.5" :blocked="$user->blocked"
                                action="{{ route('users.updatedBlock', ['user' => $user]) }}"/>
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
