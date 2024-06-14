@extends('layouts.admin')

@section('header-title', 'Edit Configuration')

@section('main')
<div class="flex justify-center">
    <div class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">
        <form method="POST" action="{{ route('configurations.update') }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="ticket_price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ticket Price</label>
                <input type="text" name="ticket_price" id="ticket_price" value="{{ old('ticket_price', $configuration->ticket_price) }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-800 dark:text-gray-50" required>
                @error('ticket_price')
                <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="registered_customer_ticket_discount" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Registered Customer Ticket Discount</label>
                <input type="text" name="registered_customer_ticket_discount" id="registered_customer_ticket_discount" value="{{ old('registered_customer_ticket_discount', $configuration->registered_customer_ticket_discount) }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-800 dark:text-gray-50" required>
                @error('registered_customer_ticket_discount')
                <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button element="submit" type="dark" text="Save" class="uppercase" />
            </div>
        </form>
    </div>
</div>
@endsection
