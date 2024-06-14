@extends('layouts.main')

@section('header-title', 'Screening: {{$screening->date . ', ' . $screening->start_time}}')

@section('main')
<main>
    <div class="py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="p-6 my-4 overflow-hidden text-gray-900 bg-white shadow-sm dark:bg-gray-900 sm:rounded-lg dark:text-gray-50">
            <h3 class="pb-3 text-2xl font-semibold text-gray-800 dark:text-gray-300">
                Screening: {{$screening->date.' '.$screening->start_time}}
            </h3>
            <div class="flex flex-wrap">
                <div class="w-full md:w-1/3">
                    <img class="w-5/6 pt-3" src="{{$screening->movie->posterFullUrl}}" alt="Img do Movie">
                </div>
                <div class="w-full pl-6 md:w-2/3">
                    <h3 class="pt-8 text-4xl font-semibold text-gray-800 dark:text-gray-300">{{$screening->movie->title}}</h3>
                    <p class="text-xl text-gray-800 dark:text-gray-300"><strong>Year:</strong> {{$screening->movie->year}}</p>
                    <h3 class="pt-2 mt-6 text-2xl text-gray-800 dark:text-gray-300"><strong>Theater:</strong> {{$screening->theater->name}}</h3>
                    <p class="pt-2 mt-8 text-gray-800 dark:text-gray-300">{{$screening->movie->synopsis}}</p>
                </div>
                <div class="w-3/4 mt-8 grow">
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
                                <strong class="mt-5 mr-10">{{ $row }}</strong>
                                <div class="flex justify-end">
                                    @foreach ($screening->theater->seatsRow($row) as $seat)
                                    @if ($screening->tickets()->where('seat_id', $seat->id)->count())
                                    <div class="relative mt-3 ml-2">
                                        <input class="sr-only peer" type="checkbox" disabled id="row{{ $row }}seat{{ $seat->seat_number }}">
                                        <label class="inline-block w-10 h-10 pt-2 text-center bg-red-500 border border-gray-300 rounded-lg" for="row{{ $row }}seat{{ $seat->seat_number }}">{{ $seat->seat_number }}</label>
                                    </div>
                                    @else
                                    <div class="relative mt-3 ml-2">
                                        <input class="sr-only peer" type="checkbox" value="{{ $seat->id }}" name="seats[]" id="row{{ $row }}seat{{ $seat->seat_number }}">
                                        <label class="inline-block w-10 h-10 pt-2 text-center text-gray-600 bg-white border border-gray-300 rounded-lg cursor-pointer focus:outline-none hover:bg-gray-50 peer-checked:ring-green-500 peer-checked:ring-2 peer-checked:border-transparent" for="row{{ $row }}seat{{ $seat->seat_number }}">{{ $seat->seat_number }}</label>
                                        <div class="absolute hidden w-5 h-5 peer-checked:block top-5 right-10">
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
