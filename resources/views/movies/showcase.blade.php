@extends('layouts.main')

@section('header-title', 'List of Movies')

@section('main')
<div class="flex justify-center">
    <div class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden
                    shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">

        <x-movies.filter-card :filterAction="route('movies.showMovies')" :resetUrl="route('movies.showMovies')" :genres="$genres" :genre="old('genre', $filterByGenre)" :title="old('title', $filterByTitle)" :year="old('year', $filterByYear)" class="mb-6" />

        <div class="grid-cols-1 sm:grid md:grid-cols-4">
            @foreach($movies as $movie)
            <div class="mx-3 mt-6 flex flex-col rounded-lg bg-white text-surface shadow-secondary-1 sm:shrink-0 sm:grow sm:basis-0 transition-transform duration-500 transform hover:-translate-y-2 dark:bg-black dark:text-white">
                <a href="#Neste href deve de ir para a rota dos detalhes do movie!">
                    <img class="rounded-t-lg" src="{{$movie->posterFullUrl}}" alt="Movie Poster" />
                </a>
                <div class="p-6">
                    <h5 class="mt-2 mb-2 text-l font-medium leading-tight">{{$movie->title}}</h5>
                    <p class="text-base">{{$movie->year}}</p>
                </div>

                <div class="px-6">
                    <h5 class="text-sm font-medium leading-tight">Sessões:</h5>

                    @foreach($movie->nextScreenings as $screening)
                    <div class="mb-2"> <a href="{{ route('screenings.showcase', ['screening'=>$screening]) }}"> {{$screening->date.' '.$screening->start_time}}</a>
                    </div>
                    @endforeach


                </div>

            </div>
            @endforeach

            <div class=" mt-4">
                {{ $movies->links() }}
            </div>
        </div>
    </div>
    @endsection
