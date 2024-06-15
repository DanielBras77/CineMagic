@extends('layouts.main')

@section('header-title', 'Estatísticas')

@section('main')
    <div class="flex justify-center">
        <div
            class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50 w-full">
            <h1 class="pl-3 pt-3 pb-8 font-semibold text-5xl text-gray-800 dark:text-gray-200 leading-tight">Estatísticas</h1>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="mt-6">
                    <h4 class="py-1 font-semibold text-gray-800 dark:text-gray-200 leading-tight">Dados sobre utilizadores</h4>
                    <br>
                    <p class="text-x2 text-gray-800 dark:text-gray-300">Total de Admistradores Ativos: {{ $numAdminsAtivos }}</p>
                    <p class="text-x2 text-gray-800 dark:text-gray-300">Total de Empregados Ativos: {{ $numEmployeesAtivos }}</p>
                    <p class="text-x2 text-gray-800 dark:text-gray-300">Total de Clientes Ativos: {{ $numCustomersAtivos }}</p>
                    <p class="text-x2 text-gray-800 dark:text-gray-300">Total de Utilizadores Bloqueados: {{ $numDeUserBloqueados }}</p>
                    <br>
                    <br>
                    <h4 class="py-1 font-semibold text-gray-800 dark:text-gray-200 leading-tight">Dados sobre o cinemas e os filmes</h4>
                    <br>
                    <p class="text-x2 text-gray-800 dark:text-gray-300">Número de gêneros disponíveis: {{ $total_genres }}</p>
                    <p class="text-x2 text-gray-800 dark:text-gray-300">Número de compras: {{ $totalPurchases }}</p>
                    <p class="text-x2 text-gray-800 dark:text-gray-300">Valor total das compras: {{ $totalPrices }}</p>
                </div>

                <div class="mt-6">
                    <h4 class="py-1 font-semibold text-gray-800 dark:text-gray-200 leading-tight flex justify-center grow">Percentagem dos generos</h4>
                    {!! $genresChart->container() !!}
                    {!! $genresChart->script() !!}
                </div>

                <div class="mt-6 ">
                    <h4 class="py-1 font-semibold text-gray-800 dark:text-gray-200 leading-tight flex justify-center grow">Vendas por Mes</h4>
                    {!! $purchasesChart->container() !!}
                    {!! $purchasesChart->script() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
