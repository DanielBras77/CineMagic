@extends('layouts.main')

@section('header-title', 'List of Administratives')

@section('main')
    <div class="flex justify-center">
        <div class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden
                    shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">
            <x-administratives.filter-card
                :filterAction="route('administratives.index')"
                :resetUrl="route('administratives.index')"
                :name="old('name', $filterByName)"
                class="mb-6"
                />
            <div class="flex items-center gap-4 mb-4">
                <x-button
                    href="{{ route('administratives.create') }}"
                    text="Create a new administrative"
                    type="success"/>
            </div>
            <div class="font-base text-sm text-gray-700 dark:text-gray-300">
                <x-administratives.table :administratives="$administratives"
                    :showView="true"
                    :showEdit="true"
                    :showDelete="true"
                    />
            </div>
            <div class="mt-4">
                {{ $administratives->links() }}
            </div>
        </div>
    </div>
@endsection
