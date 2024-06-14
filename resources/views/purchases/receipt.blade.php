<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>

    <!-- Scripts AND CSS Fileds -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

    <img src="{{ asset('img/logoCinemagic.png') }}" alt="logoCineMagic" width="28" height="28">
    <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">CineMagic</span>
    <h5 class="mt-2 mb-2 text-l font-medium leading-tight">Id: {{ $purchase->id }}</h5>
    <h5 class="mt-2 mb-2 text-l font-medium leading-tight">Date: {{ $purchase->date }}</h5>

    <p>
        <strong>Customer E-mail: </strong> {!! $purchase->customer_email !!}
        <strong>Customer Name: </strong> {!! $purchase->customer_name !!}
    </p>
    <p>
        <strong>Nif: </strong> {{ $purchase->nif }}
        <strong>Payment Type: </strong> {{ $purchase->payment_type }}
        <strong>Payment Reference: </strong> {{ $purchase->payment_ref }}
        <strong>Total Time: </strong> {{ $purchase->total_price }}
    </p>

    <p><strong>Items:</strong></p>
    <table style="border-spacing: 10px">
        <th>Movie</th>
        <th>Title</th>
        <th>Screening</th>
        <th>Seat</th>
        @foreach ($purchase->tickets as $ticket)
        <tr>
            <td>
                <img src="{{ $ticket->screening->movie->posterEncode64 }}" alt="imagem" width="100">
            </td>
            <td>
                {{ $ticket->screening->movie->title }}
            </td>
            <td>
                {{ $ticket->screening->date }} {{ $ticket->screening->start_time }}
            </td>
            <td>
                {{ $ticket->seat->row }}{{ $ticket->seat->seat_number }}
            </td>
        </tr>
        @endforeach
    </table>
</body>

</html>
