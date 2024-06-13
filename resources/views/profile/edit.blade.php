@extends('layouts.main')

@section('header-title', 'Profile')

@section('main')
<div class="flex flex-col min-h-screen pt-6 bg-gray-100 sm:pt-0 dark:bg-gray-800">
    <div class="w-full py-4 pt-6 mt-6 overflow-hidden bg-white shadow-md sm:max-w-xl dark:bg-gray-800" style="margin-top: 0; padding-top: 0;">
        <x-slot name="header">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                {{ __('Profile') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8 dark:bg-gray-6">
                <!-- Início do grid -->
                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    <!-- Coluna do formulário -->
                    <div class="md:col-span-2">
                        <div class="p-4 bg-white shadow sm:p-8 dark:bg-gray-800 sm:rounded-lg">
                            <div class="max-w-xl">
                                @include('profile.partials.update-profile-information-form')
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Fim do grid -->

                <div class="p-4 bg-white shadow sm:p-8 dark:bg-gray-800 sm:rounded-lg">
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
    </div>
</div>
@endsection
