@extends('layouts.main')

@section('header-title', 'Shopping Cart')

@section('main')
<div class="justify-center">
    <div class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">
        @empty($cart)
        <div class="flex items-center">
            <svg class="h-8 w-8 text-red-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
                <line x1="9" y1="9" x2="15" y2="15" />
                <line x1="15" y1="9" x2="9" y2="15" />
            </svg>
            <h3 class="text-xl w-96 pl-6">Cart is Empty</h3>
        </div>
        @else
        <div class="mb-6">
            <h3 class="text-xl font-medium w-96 pl-2">Shopping Cart Confirmation</h3>
        </div>
        <div class="font-base text-sm text-gray-700 dark:text-gray-300">
            <table class="table w-full">
                <tr>
                    <th>Filme</th>
                    <th>Sessão</th>
                    <th>Sala</th>
                    <th>Lugar</th>
                    <th></th>
                </tr>
                @foreach($cart as $id=>$item)
                <tr>
                    <td class="flex mt-4 align-middle">
                        <img src="{{$item['screening']->movie->posterFullUrl}}" alt="posterMovie" class="h-12 rounded-sm">
                        <p class="ml-9">
                            {{$item['screening']->movie->title}}
                        </p>
                    </td>
                    <td>{{$item['screening']->date.' '.$item['screening']->start_time}}</td>
                    <td>{{$item['screening']->theater->name}}</td>
                    <td>{{$item['seat']->row.$item['seat']->seat_number}}</td>
                    <td>
                        <x-table.icon-minus class="px-0.5" method="delete" action="{{route('cart.remove', ['id' => $id])}}" />
                    </td>
                </tr>
                @endforeach
            </table>
        </div>

        <div class="mt-8 flex justify-end">
            <h3 class="text-lg font-semibold">Total Price: {{ number_format($total_price, 2) }} €</h3>
        </div>

        <div class="mt-8 space-x-4">
            <form action="{{ route('cart.confirm') }}" method="post">
                @csrf
                <div class="mt-12 flex flex-wrap">
                    <div class="flex grow">
                        <x-field.input name="customer_name" label="Customer Name" width="lg" :readonly="false" value="{{ old('customer_name', Auth::user()?->name) }}" />
                    </div>
                    <div class="flex grow -ml-40">
                        <x-field.input name="customer_email" label="Customer Email" width="lg" :readonly="false" value="{{ old('customer_email', Auth::user()?->email) }}" />
                    </div>
                </div>
                <div class="mt-6 flex flex-wrap">
                    <div class="flex grow">
                        <x-field.input name="nif" label="NIF" width="lg" :readonly="false" value="{{ old('nif', Auth::user()?->customer?->nif) }}" />
                    </div>
                    <div class="flex grow -ml-36">
                        <x-field.radio-group name="payment_type" label="Type of payment" :readonly="false" value="{{ old('payment_type', Auth::user()?->customer?->payment_type) }}" :options="[
                            'MBWAY' => 'MBWAY',
                            'VISA' => 'VISA',
                            'PAYPAL' => 'PAYPAL'
                        ]" />
                    </div>
                </div>
                <div class="mt-6 flex">
                    <x-field.input name="payment_ref" label="Payment Ref" width="lg" :readonly="false" value="{{ old('payment_ref', Auth::user()?->customer?->payment_ref) }}" />
                </div>
                <div class="flex grow justify-end">
                    <x-button element="submit" type="dark" text="Confirm" class="mt-6 mr-4" />
                </div>
            </form>

            <form action="{{ route('cart.destroy') }}" method="post">
                @csrf
                @method('DELETE')
                <x-button element="submit" type="danger" text="Clear Cart" class="mt-6" />
            </form>
        </div>
        @endempty
    </div>
</div>
@endsection
