<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
</head>

<body>

    <img src="../../../img/logoCinemagic.png" alt="" width="28" height="28">
    <h1><strong>Cine Magic</strong></h1>
    <p>
    <p>
        <strong>Id: </strong> {{$purchase->id}}
        <strong>Date: </strong> {{$purchase->date}}
    </p>
    </p>
    <p>
    <p>
        <strong>Customer E-mail: </strong> {!!$purchase->customer_email!!}
        <strong>Customer Name: </strong> {!!$purchase->customer_name!!}
    </p>
    </p>
    <p>
    <p>
        <strong>Nif: </strong> {{$purchase->nif}}
        <strong>Payment Type: </strong> {{$purchase->payment_type}}
        <strong>Payment Reference: </strong> {{$purchase->payment_ref}}
        <strong>Total Time: </strong> {{$purchase->total_price}}
    </p>
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
                <img src="{{$ticket->screening->movie->posterEncode64}}" alt="imagem" width="100">

            </td>
            <td>
            {{$ticket->screening->movie->title}}
            </td>
            <td>
                {{$ticket->screening->date}} {{$ticket->screening->start_time}}
            </td>
            <td>
                {{$ticket->seat->row}}{{$ticket->seat->seat_number}}
            </td>


        </tr>
        @endforeach
    </table>
</body>

</html>
