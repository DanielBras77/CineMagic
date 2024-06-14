<div {{ $attributes }}>
    <table class="table-auto border-collapse">
        <thead>
            <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
                <th class="px-2 py-2 text-left">Name</th>
                <th class="px-2 py-2 text-left hidden lg:table-cell">Email</th>
                <th></th> <!-- Coluna para ações -->
            </tr>
        </thead>
        <tbody>
            @foreach ($customers as $customer)
            <tr class="border-b border-b-gray-400 dark:border-b-gray-500">
                <td class="px-2 py-2 text-left">{{ $customer->user->name }}</td>
                <td class="px-2 py-2 text-left hidden lg:table-cell">{{ $customer->user->email }}</td>
                <td>
                    <div class="flex gap-2">
                        @if($showDelete)
                        @can('delete', $customer->user)
                        <form method="POST" action="{{ route('customers.destroy', ['customer' => $customer]) }}">
                            @csrf
                            @method('DELETE')
                            <x-table.icon-delete class="px-0.5" action="{{ route('customers.destroy', ['customer' => $customer]) }}" />
                        </form>
                        @endcan
                        @endif
                        @if($showBlock)
                        @can('update', $customer->user)
                        <form method="POST" action="{{ route('customers.updatedBlock', ['user' => $customer->user]) }}">
                            @csrf
                            @method('PATCH')
                            <x-table.icon-block class="px-0.5" :blocked="$customer->user->blocked" action="{{ route('customers.updatedBlock', ['user' => $customer->user]) }}" />
                        </form>
                        @endcan
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
