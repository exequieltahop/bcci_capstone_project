<x-app-layout>
    <x-slot name="header">
        {{ __('Create Benefit') }}
    </x-slot>

    <form action="{{ route('benefits.store') }}" method="POST" onsubmit="return confirm('Are you sure you want to create this record?')">
        @csrf
        <div class="max-w-xl mx-auto p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <header class="pb-3">
                <h2 class="text-lg font-medium text-gray-900">{{ __('Benefit Information') }}</h2>
            </header>

            <!-- Name -->
            <div class="mb-4">
                <div class="flex items-center mb-1">
                    <x-input-label for="name" :value="__('Name')" />
                    <span class="text-red-500">*</span>
                </div>
                <x-text-input
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                    autofocus
                    autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <!-- Buttons -->
            <div class="flex justify-end gap-2">
                <button type="submit" class="flex items-center gap-1 px-4 py-2 text-sm font-medium text-white transition-colors duration-150 border border-transparent rounded-lg bg-purple-600 hover:bg-purple-700 active:bg-purple-700 focus:outline-none focus:ring focus:ring-purple-300">
                    Submit
                </button>
                <a href="{{ route('benefits.index') }}" class="flex items-center gap-1 px-4 py-2 text-sm font-medium text-white transition-colors duration-150 border border-transparent rounded-lg bg-red-500 hover:bg-red-600 active:bg-red-600 focus:outline-none focus:ring focus:ring-red-200">
                    Cancel
                </a>
            </div>
        </div>
    </form>
</x-app-layout>
