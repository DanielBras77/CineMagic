@extends('layouts.main')

@section('header-title', 'Shopping Cart')

@section('main')
<div class="justify-center">
    <div class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden
                    shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">
        @empty($cart)
        <h3 class="text-xl w-96 text-center">Cart is Empty</h3>
        @else
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
                    <td><img src="{{$item['screening']->movie->posterFullUrl}}" alt="" class="h-12">
                        <p class="my-1">
                            {{$item['screening']->movie->title}}
                        </p>
                    </td>
                    <td>{{$item['screening']->date.' '.$item['screening']->start_time}}</td>
                    <td>{{$item['screening']->theater->name}}</td>
                    <td>{{$item['seat']->row.$item['seat']->seat_number}}</td>
                    <td>
                        <x-table.icon-minus class="px-0.5" method="delete" action="{{route('cart.remove', ['id' => $id])}}"/>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
        <div class=" mt-12">
            <div class="flex justify-between space-x-12 items-end">
                <div>
                    <h3 class="mb-4 text-xl">Shopping Cart Confirmation </h3>
<!-- <form action="{{ route('cart.confirm') }}" method="post">
                        @csrf
                        <x-field.input name="student_number" label="Student Number" width="lg" :readonly="false" value="{{ old('student_number') }}" />
                        <x-button element="submit" type="dark" text="Confirm" class="mt-4" />
                    </form>
                </div>
                <div>
                    <form action="{{ route('cart.destroy') }}" method="post">
                        @csrf
                        @method('DELETE')
                        <x-button element="submit" type="danger" text="Clear Cart" class="mt-4" />
                    </form>-->
                </div>
            </div>
        </div>
        @endempty
    </div>
</div>
@endsection
