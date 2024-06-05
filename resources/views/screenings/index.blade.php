@extends('layouts.admin')

@section('header-title', 'List of Movies')

@section('main')
    <div class="flex justify-center">
        <div class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden
                    shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">

                <x-movies.filter-card
                :filterAction="route('movies.index')"
                :resetUrl="route('movies.index')"
                :genres="$genres"
                :genre="old('genre', $filterByGenre)"
                :title="old('title', $filterByTitle)"
                :year="old('year', $filterByYear)"
                class="mb-6"
                />
            @can('create', App\Models\Movie::class)
                <div class="flex items-center gap-4 mb-4">
                    <x-button
                        href="{{ route('movies.create') }}"
                        text="Create a new movie"
                        type="success"/>
                </div>
            @endcan
            <div class="font-base text-sm text-gray-700 dark:text-gray-300">
                <x-movies.table :movies="$movies"
                    :showView="true"
                    :showEdit="true"
                    :showDelete="true"
                    />
            </div>
            <div class="mt-4">
                {{ $movies->links() }}
            </div>
        </div>
    </div>
@endsection
