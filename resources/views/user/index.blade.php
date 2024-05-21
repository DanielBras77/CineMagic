@extends('layouts.main')

@section('header-title', 'List of Users')

@section('main')
    <div class="flex justify-center">
        <div class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden
                    shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">
            <x-users.filter-card
                :filterAction="route('user.index')"
                :resetUrl="route('user.index')"
                :email="$email"
                class="mb-6"
                />
            <div class="flex items-center gap-4 mb-4">
                <x-button
                    href="{{ route('user.create') }}"
                    text="Create a new user"
                    type="success"/>
            </div>
            <div class="mt-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection
