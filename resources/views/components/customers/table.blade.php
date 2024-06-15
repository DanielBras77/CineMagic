<div {{ $attributes }}>
    <table class="table-auto border-collapse">
        <thead>
        <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
            <th class="px-2 py-2 text-left hidden lg:table-cell">Email</th>
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
        @foreach ($customers as $customer)
            <tr class="border-b border-b-gray-400 dark:border-b-gray-500">
                <td class="px-2 py-2 text-left hidden lg:table-cell">{{ $customer->email }}</td>
                <td class="px-2 py-2 text-left">{{ $customer->name }}</td>
                @if($showView)
                    @can('view', $customer)
                        <td>
                            <x-table.icon-show class="ps-3 px-0.5"
                                href="{{ route('customers.show', ['customer' => $customer]) }}"/>
                        </td>
                    @else
                        <td></td>
                    @endcan
                @endif
                @if($showEdit)
                    @can('update', $customer)
                        <td>
                            <x-table.icon-edit class="px-0.5"
                                href="{{ route('customers.edit', ['customer' => $customer]) }}"/>
                        </td>
                    @else
                        <td></td>
                    @endcan
                @endif
                @if($showDelete)
                    @can('delete', $customer)
                        <td>
                            <x-table.icon-delete class="px-0.5"
                                action="{{ route('customers.destroy', ['customer' => $customer]) }}"/>
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
