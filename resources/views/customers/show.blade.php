@extends('layouts.admin')

@section('header-title', $customer->name)

@section('main')
<div class="flex flex-col space-y-6">
    <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg">
        <div class="max-full">
            <section>
                <div class="flex flex-wrap justify-end items-center gap-4 mb-4">
                    @can('delete', $customer)
                    <form method="POST" action="{{ route('users.destroy', ['user' => $customer]) }}">
                        @csrf
                        @method('DELETE')
                        <x-button element="submit" text="Delete" type="danger" />
                    </form>
                    @endcan
                    @can('block', $customer)
                    <form method="POST" action="{{ route('users.updatedBlock', ['user' => $customer]) }}">
                        @csrf
                        @method('PATCH')
                        <x-button element="submit" text="Block" type="danger" />
                    </form>
                    @endcan
                </div>
                <header>
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        User "{{ $customer->name }}"
                    </h2>
                </header>
                <div class="mt-6 space-y-4">
                    @include('customers.shared.fields', ['mode' => 'show'])
                </div>
            </section>
        </div>
    </div>
</div>
@endsection

