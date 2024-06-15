<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/pdf.css') }}">

    <!--Fonts-->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{asset('https://use.fontawesome.com/releases/v6.1.0/js/all.js')}}" crossorigin="anonymous"></script>
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Rubik', sans-serif;
        }
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        th, td {
            padding: 15px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body class="p-4 bg-white">
    <div class="container p-4 pt-6 mx-auto md:p-6 lg:p-12">
        <img src="{{ asset('img/logoCinemagic.png') }}" alt="logoCineMagic" width="28" height="28" class="mb-4">
        <h1 class="mb-2 text-3xl font-bold">CineMagic</h1>
        <h5 class="mb-2 text-lg font-medium">Date: {{ $purchase->date }}</h5>

        <div class="flex flex-wrap mb-4">
            <div class="w-full p-4 md:w-1/2 xl:w-1/3">
                <p class="mb-2 text-lg font-medium">
                    <strong>Customer Name: </strong> {!! $purchase->customer_name !!}
                </p>
                <p class="mb-2 text-lg font-medium">
                    <strong>Customer E-mail: </strong> {!! $purchase->customer_email !!}
                </p>
            </div>
            <div class="w-full p-4 md:w-1/2 xl:w-1/3">
                <p class="mb-2 text-lg font-medium">
                    <strong>Nif: </strong> {{ $purchase->nif }}
                </p>
                <p class="mb-2 text-lg font-medium">
                    <strong>Payment Type: </strong> {{ $purchase->payment_type }}
                </p>
                <p class="mb-2 text-lg font-medium">
                    <strong>Payment Reference: </strong> {{ $purchase->payment_ref }}
                </p>
                <p class="mb-2 text-lg font-medium">
                    <strong>Total Price: </strong> {{ number_format($purchase->total_price, 2) }}€
                </p>
            </div>
        </div>

        <p class="mb-4 text-lg font-medium"><strong>Items:</strong></p>
        <table class="w-full mb-4">
            <tr class="bg-gray-100">
                <th class="px-4 py-2">Movie</th>
                <th class="px-4 py-2">Title</th>
                <th class="px-4 py-2">Screening</th>
                <th class="px-4 py-2">Seat</th>
            </tr>
            @foreach ($purchase->tickets as $ticket)
            <tr>
                <td class="px-4 py-2">
                    <img src="{{ $ticket->screening->movie->posterEncode64 }}" alt="imagem" width="100" class="rounded" />
                </td>
                <td class="px-4 py-2">
                    {{ $ticket->screening->movie->title }}
                </td>
                <td class="px-4 py-2">
                    {{ $ticket->screening->date }} {{ $ticket->screening->start_time }}
                </td>
                <td class="px-4 py-2">
                    {{ $ticket->seat->row }}{{ $ticket->seat->seat_number }}
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</body>

</html>
