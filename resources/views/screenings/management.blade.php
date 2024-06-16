@extends('layouts.main')

@section('header-title', 'Screenings Management')

@section('main')
<main>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">
            <h3 class="text-2xl pb-3 font-semibold text-gray-800 dark:text-gray-300">
                Upcoming Screenings (Next 2 Weeks)
            </h3>
            <div class="flex justify-end">
                <x-button element="submit" type="white" text="My Screenings" />
            </div>

            <div class="font-base text-sm text-gray-700 dark:text-gray-300 mt-8">
                <table class="table w-full">
                    <tr>
                        <th>Movie</th>
                        <th>Session</th>
                        <th>Theater</th>
                        <th></th>
                    </tr>
                    @foreach($screenings as $screening)
                    <tr>
                        <td class="flex mt-4 align-middle">
                            <img src="{{$screening->movie->posterFullUrl}}" alt="Movie Poster" class="h-12 rounded-sm">
                            <p class="ml-4">
                                {{$screening->movie->title}}
                            </p>
                        </td>
                        <td>{{$screening->date . ' ' . $screening->start_time}}</td>
                        <td>{{$screening->theater->name}}</td>
                        <td class="flex justify-end">
                            <x-button element="submit" type="dark" text="Add to My Screenings" />
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</main>
@endsection
