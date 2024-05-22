@extends('layouts.main')

@section('header-title', 'User "' . $user->name  . '"')

@section('main')
<div class="flex flex-col space-y-6">
    <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg">
        <div class="max-full">
            <section>
                <div class="flex flex-wrap justify-end items-center gap-4 mb-4">
                    <x-button
                        href="{{ route('user.create', ['user' => $user]) }}"
                        text="New"
                        type="success"/>
                    <x-button
                        href="{{ route('user.edit', ['user' => $user]) }}"
                        text="Edit"
                        type="primary"/>
                    <form method="POST" action="{{ route('user.destroy', ['user' => $user]) }}">
                        @csrf
                        @method('DELETE')
                        <x-button
                            element="submit"
                            text="Delete"
                            type="danger"/>
                    </form>
                </div>
                <header>
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        User "{{ $user->name }}"
                    </h2>
                </header>
                @include('user.shared.fields', ['mode' => 'show'])

                <h3 class="pt-16 pb-4 text-2xl font-medium text-gray-900 dark:text-gray-100">
                    Apresentar alguma coisa
                </h3>
            </section>
        </div>
    </div>
</div>
@endsection
