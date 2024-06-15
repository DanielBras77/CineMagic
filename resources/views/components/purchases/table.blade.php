<div {{ $attributes }}>
    <table class="table-auto border-collapse">
        <thead>
        <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
                <th class="px-2 py-2 text-left">Date</th>
                <th class="px-2 py-2 text-left">Total Price</th>
                @if($showView)
                <th></th>
                @endif
        </tr>
        </thead>
        <tbody>
        @foreach ($purchases as $purchase)
            <tr class="border-b border-b-gray-400 dark:border-b-gray-500">
                <td class="px-2 py-2 text-left">{{ $purchase->date }}</td>
                <td class="px-2 py-2 text-left">{{ $purchase->customer_name }}</td>
                <td class="px-2 py-2 text-left">{{ number_format($purchase->total_price, 2) }} €</td>
                @if($showView)
                    @can('view', $purchase)
                        <td>
                            <x-table.icon-show class="ps-3 px-0.5"
                                href="{{ route('purchase.show', ['purchase' => $purchase->id]) }}"/>
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
