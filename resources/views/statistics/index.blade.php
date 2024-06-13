<!-- resources/views/statistics/index.blade.php -->

@extends('layouts.main')

@section('header-title', 'Estatísticas')

@section('main')
<main>
    <h1 class="mt-6 pt-5 pb-10 font-semibold text-5xl text-gray-800 dark:text-gray-200 leading-tight">Estatísticas</h1>

    <!-- Caixa -->
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-18">
        <div class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-2xl text-gray-900 dark:text-gray-50">
            <h3 class="pb-3 font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight">
                Estatísticas de Bilheteira
            </h3>
            <form action="{{ route('statistics.filter') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="genre_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Gênero</label>
                        <select name="genre_code" id="genre_code" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-300">
                            <option value="">Todos</option>
                            @foreach($genres as $code => $name)
                                <option value="{{ $code }}" {{ isset($selectedGenre) && $selectedGenre->code == $code ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mt-6">
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md shadow-sm hover:bg-indigo-700">Filtrar</button>
                </div>
            </form>

            <div class="mt-6">
                <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200 leading-tight">Resultados</h4>
                <p class="py-3 font-medium text-gray-700 dark:text-gray-300">
                    Total de Bilhetes Vendidos{{ isset($selectedGenre) ? ' por ' . $selectedGenre->name : '' }}: {{ $statistics->total_tickets }}
                </p>
                <p class="py-3 font-medium text-gray-700 dark:text-gray-300">
                    Receita Total{{ isset($selectedGenre) ? ' por ' . $selectedGenre->name : '' }}: {{ $statistics->total_revenue }}
                </p>
            </div>
        </div>
    </div>
</main>
@endsection
