@extends('layouts.admin')

@section('header-title', 'List of Purchases')

@section('main')
    <div class="flex justify-center">
        <div class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden
                    shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">

                <x-purchases.filter-card
                :filterAction="route('purchases.index')"
                :resetUrl="route('purchases.index')"
                />

            <div class="font-base text-sm text-gray-700 dark:text-gray-300">
                <x-purchases.table :purchases="$purchases"
                    :showView="true"
                    />
            </div>
            <div class="mt-4">
                {{ $purchases->links() }}
            </div>
        </div>
    </div>
@endsection
