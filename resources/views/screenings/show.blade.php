@extends('layouts.admin')

@section('header-title', $movie->title)

@section('main')
<div class="flex flex-col space-y-6">
    <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg">
        <div class="max-full">
            <section>
                <header>
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        Movie "{{ $movie->title }}"
                    </h2>
                    <a class="h-48 w-48 md:h-72 md:w-72 md:min-w-72 md:max-w-72 mx-auto md:m-0" href="{{ route('movies.show', ['movie' => $movie]) }}">
                        <img class="h-full aspect-auto mx-auto rounded-full md:rounded-l-xl md:rounded-r-none" src="{{ $movie->poster_filename }}">
                    </a>
                </header>
                <div class="mt-6 space-y-4">
                    @include('movies.shared.fields', ['mode' => 'show'])
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
