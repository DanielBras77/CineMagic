<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <!--Fonts-->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('https://use.fontawesome.com/releases/v6.1.0/js/all.js') }}" crossorigin="anonymous"></script>
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Rubik', sans-serif;
        }

        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 15px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: start;
            /* Alterado de center para start */
            margin-bottom: 1rem;
        }

        .header img {
            margin-right: 10px;
        }

        .header h1 {
            margin: 0;
        }

        /* Estilo adicionado para centralizar a tabela */
        .table-container {
            display: flex;
            justify-content: center;
        }
    </style>
</head>

<body>
    <div>
        <div>
            <img src="{{ asset('img/cinemagic_c_txtpng.png') }}" alt="logoCineMagic" width="224" height="59">
        </div>
        <br>
        <h5>Ticket Id: {{ $purchase->id }}</h5>
        <h5>Date: {{ $purchase->date }}</h5>

        <div>
            <div>
                <p>
                    <strong>Customer Name: </strong> {!! $purchase->customer_name !!}
                </p>
                <p>
                    <strong>Customer E-mail: </strong> {!! $purchase->customer_email !!}
                </p>
            </div>
            <div>
                <p>
                    <strong>NIF: </strong> {{ $purchase->nif }}
                </p>
                <p>
                    <strong>Payment Type: </strong> {{ $purchase->payment_type }}
                </p>
                <p>
                    <strong>Payment Reference: </strong> {{ $purchase->payment_ref }}
                </p>
                <p>
                    <strong>Total Price: </strong> {{ number_format($purchase->total_price, 2) }}€
                </p>
                <br>
                <p>
                    <strong>Items: </strong>
                </p>
            </div>
        </div>

        <div class="table-container">
            <table class="w-full mb-4">
                <tr class="bg-gray-100">
                    <th class="px-4 py-2">Movie</th>
                    <th class="px-4 py-2">Title</th>
                    <th class="px-4 py-2">Screening</th>
                    <th class="px-4 py-2">Seat</th>
                    <th class="px-4 py-2">Theater</th>
                    <th class="px-4 py-2">QR Code</th>
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
                    <td class="px-4 py-2">
                        {{ $ticket->screening->theater->name }}
                    </td>
                    <td class="px-4 py-2">
                        <img src="{{ $ticket->qr_code_url }}" alt="QR Code" width="100" class="rounded" />
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</body>

</html>
