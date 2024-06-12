<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
</head>

<body>
    <p>
        <strong>Date: </strong> {{$purchase->date}}
    </p>
    <p>
        <strong>Customer Name: </strong> {!!$purchase->customer_name!!}
    </p>
    <p>
        <strong>Nif: </strong> {{$purchase->nif}}
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
