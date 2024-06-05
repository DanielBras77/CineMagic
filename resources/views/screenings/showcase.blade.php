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
                    <h3>{{$screening->movie->title}}</h3>
                    <p>{{$screening->theater->name}}</p>
                    <p>Lugares:</p>
                    @foreach($screening->theater->rows as $row)
                    <p>
                        <strong>{{$row}}</strong>
                        @foreach($screening->theater->seatsRow($row) as $seat)
                            @if($screening->tickets()->where('seat_id', $seat->id)->count())
                                <input type="checkbox" disabled>
                            @else
                            <input type="checkbox" name="seats[]" value="{{$seat->seat_number}}">
                            @endif
                            {{$seat->seat_number}}
                        @endforeach
                    </p>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
