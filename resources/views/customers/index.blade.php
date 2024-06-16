@extends('layouts.admin')

@section('header-title', 'List of Customers')

@section('main')
    <div class="flex justify-center">
        <div class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden
                    shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">

                <x-customers.filter-card
            :filterAction="route('customers.index')"
            :resetUrl="route('customers.index')"
            :name="old('name', $filterByName)"
            class="mb-6"/>

            <div class="font-base text-sm text-gray-700 dark:text-gray-300">
                <x-customers.table :customers="$customers"
                    :showDelete="true"
                    :showBlock="true"
                    />
            </div>
            <div class="mt-4">
                {{ $customers->links() }}
            </div>
        </div>
    </div>
@endsection
