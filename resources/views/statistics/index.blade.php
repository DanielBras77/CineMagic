@extends('layouts.admin')

@section('header-title', 'List of Purchases')

@section('main')
<div class="flex justify-center">
    <div class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50 w-full">
        <h1 class="pl-3 pt-3 pb-8 font-semibold text-5xl text-gray-800 dark:text-gray-200 leading-tight">Statistics</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- User Data Section -->
            <div class="mt-6">
                <h4 class="py-1 font-semibold text-gray-800 dark:text-gray-200 leading-tight mb-5">User Data</h4>
                <p class="text-xl text-gray-800 dark:text-gray-300">Total Active Administrators: {{ $numAdminsAtivos }}</p>
                <p class="text-xl text-gray-800 dark:text-gray-300">Total Active Employees: {{ $numEmployeesAtivos }}</p>
                <p class="text-xl text-gray-800 dark:text-gray-300">Total Active Customers: {{ $numCustomersAtivos }}</p>
                <p class="text-xl text-gray-800 dark:text-gray-300">Total Blocked Users: {{ $numDeUserBloqueados }}</p>
            </div>

            <!-- Cinema/Movies Data Section -->
            <div class="mt-6">
                <h4 class="py-1 font-semibold text-gray-800 dark:text-gray-200 leading-tight mb-5">Cinema/Movies Data</h4>
                <p class="text-xl text-gray-800 dark:text-gray-300">Number of genres available: {{ $total_genres }}</p>
                <p class="text-xl text-gray-800 dark:text-gray-300">Number of purchases: {{ $totalPurchases }}</p>
                <p class="text-xl text-gray-800 dark:text-gray-300">Total purchase value: {{ $totalPrices }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-8">
            <!-- Genres Chart Section -->
            <div class="mt-6">
                <h4 class="py-1 font-semibold text-gray-800 dark:text-gray-200 leading-tight text-center">Movies By Genre</h4>
                <div class="mt-6">
                    {!! $genresChart->container() !!}
                    {!! $genresChart->script() !!}
                </div>
            </div>

            <!-- Purchases Chart Section -->
            <div class="mt-6">
                <h4 class="py-1 font-semibold text-gray-800 dark:text-gray-200 leading-tight text-center">Tickets By Month</h4>
                <div class="mt-6">
                    {!! $purchasesChart->container() !!}
                    {!! $purchasesChart->script() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
