@extends('layouts.main')

@section('header-title', 'Movies On Show')

@section('main')
<main>

    <h1 class="mt-6 pt-5 pb-10 font-semibold text-5xl text-gray-800 dark:text-gray-200 leading-tight">Movies On Show</h1>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-18">
        <div class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-2xl text-gray-900 dark:text-gray-50">

            <!-- Mostrar os géneros de forma dinâmica
            @foreach ($genres as $genre)
            <button type="button" class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4
                focus:ring-gray-300 font-medium rounded-full text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700
                dark:focus:ring-gray-700 dark:border-gray-700">{{ $genre->name }}</button>
            @endforeach-->

            <h3 class="pb-3 font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight">
                Movies On Show
            </h3>
            <p class="py-3 font-medium text-gray-700 dark:text-gray-300">
                CINEMA - Página Inicial
            </p>
        </div>
    </div>
</main>
@endsection
