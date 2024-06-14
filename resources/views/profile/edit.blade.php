@extends('layouts.main')

@section('header-title', 'Profile')

@section('main')

@if(Auth::user()->type == 'C')
<div class="flex flex-col min-h-screen pt-6 bg-gray-100 sm:pt-0 dark:bg-gray-800">
    <div class="w-full py-4 pt-6 mt-6 overflow-hidden bg-white shadow-md sm:max-w-xl dark:bg-gray-800">
        <x-slot name="header">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-white">
                {{ __('Profile') }}
            </h2>
        </x-slot>
    </div>
    <div class="grid grid-cols-1 gap-4 py-12 mx-auto md:grid-cols-3 max-w-7xl sm:px-6 lg:px-8">
        <div class="justify-start p-4 bg-white shadow md:col-span-2 sm:p-8 dark:bg-gray-800 sm:rounded-lg">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>
        <div class="p-4 bg-white shadow md:col-span-1 sm:p-8 dark:bg-gray-800 sm:rounded-lg">
            <div class="p-4 bg-white shadow md:col-span-1 sm:p-8 dark:bg-gray-800 sm:rounded-lg">
                <div class="pb-6">
                    <x-field.image
                        name="photo_file"
                        label="Photo"
                        width="md"
                        deleteTitle="Delete Photo"
                        :deleteAllow="true"
                        :imageUrl="$user->photoFullUrl"
                        class="rounded-lg"/>
                </div>
            </div>
        </div>
        <div class="justify-start p-4 bg-white shadow md:col-span-2 sm:p-8 dark:bg-gray-800 sm:rounded-lg">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>
        <div class="p-4 bg-white shadow sm:p-8 dark:bg-gray-800 sm:rounded-lg">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</div>
@endif
@endsection
