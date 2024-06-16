@extends('layouts.main')

@section('header-title', 'Purchase Details')

@section('main')
<div class="justify-center">
    <div class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">
        <h3 class="text-xl font-medium w-96">Purchase Details</h3>
        <div class="mt-8 font-base text-sm text-gray-700 dark:text-gray-300">
            <p class="text-lg"><strong>Date:</strong> {{ $purchase->date }}</p>
            <br>
            <p class="text-lg"><strong>Total Price:</strong> {{ number_format($purchase->total_price, 2) }} €</p>

            <h4 class="mt-4 mb-2 text-lg">Tickets:</h4>
            <table class="w-full border-collapse border border-gray-200 mt-8">
                <thead>
                    <tr class="bg-gray-100 dark:bg-gray-800">
                        <th class="py-2 px-4 border-r">Poster</th>
                        <th class="py-2 px-4 border-r">Movie</th>
                        <th class="py-2 px-4 border-r">Screening</th>
                        <th class="py-2 px-4 border-r">Seat</th>
                        <th class="py-2 px-4">Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($purchase->tickets as $ticket)
                    <tr class="border-b border-gray-200">
                        <td class="py-2 px-4 text-center">
                            <img src="{{ $ticket->screening->movie->posterFullUrl }}" alt="posterMovie" class="h-12 rounded-sm inline-block">
                        </td>
                        <td class="py-2 px-4 text-center">{{ $ticket->screening->movie->title }}</td>
                        <td class="py-2 px-4 text-center">{{ $ticket->screening->date }} {{ $ticket->screening->start_time }}</td>
                        <td class="py-2 px-4 text-center">{{ $ticket->seat->row }}{{ $ticket->seat->seat_number }}</td>
                        <td class="py-2 px-4 text-center">{{ number_format($ticket->price, 2) }} €</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-8 flex justify-end">
                @if ($purchase->receipt_pdf_filename)
                <a href="{{ route('purchase.getReceipt', ['purchase' => $purchase->id]) }}" class="text-blue-600">View Receipt</a>
                @else
                <span class="text-gray-500">No receipt available</span>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
