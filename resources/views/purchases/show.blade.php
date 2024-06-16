@extends('layouts.main')

@section('header-title', 'Purchase Details')

@section('main')
<div class="justify-center">
    <div class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">
        <h3 class="text-xl font-medium w-96">Purchase Details</h3>
        <div class="mt-8 font-base text-sm text-gray-700 dark:text-gray-300">
            <p><strong>Date:</strong> {{ $purchase->date }}</p>
            <p><strong>Total Price:</strong> {{ number_format($purchase->total_price, 2) }} €</p>
            <h4 class="mt-4 mb-2 text-lg">Tickets:</h4>
            <table class="table w-full mt-8">
                <thead>
                    <tr>
                        <th>Photo</th>
                        <th>Movie</th>
                        <th>Screening Date</th>
                        <th>Seat</th>
                        <th>Price</th>
                        <th>QR Code</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($purchase->tickets as $ticket)
                    <tr>
                        <td class="flex mt-4 align-middle">
                            <img src="{{$ticket->screening->movie->posterFullUrl}}" alt="posterMovie" class="h-12 rounded-sm">
                        <td>{{ $ticket->screening->movie->title }}</td>
                        <td>{{ $ticket->screening->date }} {{ $ticket->screening->start_time }}</td>
                        <td>{{ $ticket->seat->row }}{{ $ticket->seat->seat_number }}</td>
                        <td>{{ number_format($ticket->price, 2) }} €</td>
                        <td><img src="data:image/png;base64,{{ $ticket->qrcode_url }}" alt="QR Code"></td>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="flex mt-4 justify-end">
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
