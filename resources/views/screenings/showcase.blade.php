@extends('layouts.main')

@section('header-title', 'Screening: {{$screening->date . ', ' . $screening->start_time}}')

@section('main')
<main>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">
            <h3 class="pb-3 font-semibold text-lg text-gray-800 dark:text-gray-300">
                Screening: {{$screening->date.' '.$screening->start_time}}
            </h3>
            <div class="flex">
                <div>
                    <img src="{{$screening->movie->posterFullUrl}}" alt="Img do Movie">
                </div>
                <div class="grow">
                    <form action="{{ route('cart.add', ['screening'=>$screening])}}" method="POST">
                        @csrf
                        <h3>{{$screening->movie->title}}</h3>
                        <p>{{$screening->theater->name}}</p>
                        <p>Lugares:</p>
                        @foreach ($screening->theater->rows as $row)
                        <div class="flex">
                            <strong class="mr-10 mt-5">{{ $row }}</strong>
                            <div class="flex ">
                                @foreach ($screening->theater->seatsRow($row) as $seat)
                                @if ($screening->tickets()->where('seat_id', $seat->id)->count())

                                <div class="relative mt-3 ml-2">
                                    <input class="sr-only peer" type="checkbox" disabled id="row{{ $row}}seat{{ $seat->seat_number }}">
                                    <label class=" w-10 h-10 bg-red-500 border border-gray-300 rounded-lg inline-block text-center pt-2" for="row{{ $row}}seat{{ $seat->seat_number }}">{{ $seat->seat_number }}</label>
                                </div>

                                @else
                                <div class="relative mt-3 ml-2 ">
                                    <input class="sr-only peer" type="checkbox" value="{{ $seat->id }}" name="seats[]" id="row{{ $row}}seat{{ $seat->seat_number }}">
                                    <label class=" w-10 h-10 bg-white border border-gray-300 rounded-lg cursor-pointer focus:outline-none hover:bg-gray-50 peer-checked:ring-green-500 peer-checked:ring-2 peer-checked:border-transparent inline-block text-center pt-2 text-gray-600" for="row{{ $row}}seat{{ $seat->seat_number }}">{{ $seat->seat_number }}</label>

                                    <div class="absolute hidden w-5 h-5 peer-checked:blocked  top-5 right-10">
                                    </div>
                                </div>
                                @endif
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                        <x-button element="submit" type="dark" text="Add to Cart" />
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
