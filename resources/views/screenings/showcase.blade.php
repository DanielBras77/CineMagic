@extends('layouts.main')

@section('header-title', 'Screening: {{$screening->date . ', ' . $screening->start_time}}')

@section('main')
<main>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">
            <h3 class="text-2xl pb-3 font-semibold text-gray-800 dark:text-gray-300">
                Screening: {{$screening->date.' '.$screening->start_time}}
            </h3>
            <div class="flex flex-wrap">
                <div class="w-full md:w-1/3">
                    <img class="pt-3 w-5/6" src="{{$screening->movie->posterFullUrl}}" alt="Img do Movie">
                </div>
                <div class="w-full md:w-2/3 pl-6">
                    <h3 class="text-4xl pt-8 font-semibold text-gray-800 dark:text-gray-300">{{$screening->movie->title}}</h3>
                    <p class="text-xl text-gray-800 dark:text-gray-300"><strong>Year:</strong> {{$screening->movie->year}}</p>
                    <h3 class="mt-6 text-2xl pt-2 text-gray-800 dark:text-gray-300"><strong>Theater:</strong> {{$screening->theater->name}}</h3>
                    <p class="mt-8 pt-2 text-gray-800 dark:text-gray-300">{{$screening->movie->synopsis}}</p>
                    <p class="mt-16 text-gray-800 dark:text-gray-300">
                        <a href="{{$screening->movie->trailer_url}}"><strong>Trailer Url:</strong> {{$screening->movie->trailer_url}}</a>
                    </p>
                </div>
                <div class="mt-8 w-3/4 grow">
                    @if ($isSoldOut)
                    <div class="p-4 text-xl font-semibold text-center text-white bg-red-500 rounded">
                        Sold Out
                    </div>
                    @else
                    <form action="{{ route('cart.add', ['screening'=>$screening])}}" method="POST">
                        @csrf
                        <p>Lugares:</p>
                        @foreach ($screening->theater->rows as $row)
                        <div class="flex">
                            <strong class="mr-10 mt-5">{{ $row }}</strong>
                            <div class="flex justify-end">
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
                        <div class="flex justify-end mt-6">
                            <x-button element="submit" type="dark" text="Add to Cart" />
                        </div>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
