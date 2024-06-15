@extends('layouts.main')

@section('header-title', 'Purchase History')

@section('main')
<div class="justify-center">
    <div class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">
        <h3 class="text-xl font-medium w-96 pl-2">Purchase History</h3>
        @if($purchases->isEmpty())
        <div class="flex items-center">
            <svg class="h-8 w-8 text-red-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
                <line x1="9" y1="9" x2="15" y2="15" />
                <line x1="15" y1="9" x2="9" y2="15" />
            </svg>
            <h3 class="text-xl w-96 pl-6">No Purchases Found</h3>
        </div>
        @else
        <div class="font-base text-sm text-gray-700 dark:text-gray-300">
            <table class="table w-full mt-8">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Total Price</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($purchases as $purchase)
                    <tr>
                        <td>{{ $purchase->date }}</td>
                        <td>{{ number_format($purchase->total_price, 2) }} €</td>
                        <td>
                            <a href="{{ route('purchase.show', ['purchase' => $purchase->id]) }}" class="text-blue-600">View Details</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>
@endsection
