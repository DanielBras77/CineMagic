@extends('layouts.admin')

@section('header-title', $user->name)

@section('main')
<div class="flex flex-col space-y-6">
    <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg">
        <div class="max-full">
            <section>
                <div class="flex flex-wrap justify-end items-center gap-4 mb-4">
                    @can('create', App\Models\User::class)
                    <x-button
                        href="{{ route('users.create') }}"
                        text="New"
                        type="success"/>
                    @endcan
                    @can('view', $user)
                    <x-button
                        href="{{ route('users.show', ['user' => $user]) }}"
                        text="View"
                        type="info"/>
                    @endcan
                    @can('delete', $user)
                    <form method="POST" action="{{ route('users.destroy', ['user' => $user]) }}">
                        @csrf
                        @method('DELETE')
                        <x-button
                            element="submit"
                            text="Delete"
                            type="danger"/>
                    </form>
                    @endcan
                </div>
                <header>
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        Edit user "{{ $user->name }}"
                    </h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-300  mb-6">
                        Click on "Save" button to store the information.
                    </p>
                </header>

                <form method="POST" action="{{ route('users.update', ['user' => $user]) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mt-6 space-y-4">
                        @include('users.shared.fields', ['mode' => 'edit'])
                    </div>
                    <div class="flex mt-6">
                        <x-button element="submit" type="dark" text="Save" class="uppercase"/>
                        <x-button element="a" type="light" text="Cancel" class="uppercase ms-4"
                                    href="{{ url()->full() }}"/>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>
@endsection

