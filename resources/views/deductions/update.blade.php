<x-app-layout>
    <x-slot name="header">
        {{ __('Update Deduction') }}
    </x-slot>

    <form action="{{ route('deductions.update', ['deduction' => $deduction->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to update this record?')">
        @method('PUT')
        @csrf
        <div class="max-w-xl mx-auto p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <header class="pb-3">
                <h2 class="text-lg font-medium text-gray-900">{{ __('Employee Deduction Benefits') }}</h2>
            </header>

            <input type="hidden" name="user_id" value="{{ $employee->id }}">

            <!-- Benefit Selection -->
            <div class="mb-4">
                <div class="flex items-center mb-1">
                    <x-input-label for="benefit" :value="__('Benefit')" />
                    <span class="text-red-500">*</span>
                </div>
                <select
                    id="benefit"
                    name="benefit"
                    class="mt-1 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                    <option value=""> - - - </option>
                    @foreach ($benefits as $benefit)x
                        <option value="{{ $benefit->id }}" @if($benefit->id == $deduction->benefit_id) selected @endif >{{ $benefit->name }}</option>
                    @endforeach
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('benefit')" />
            </div>

            <!-- Amount -->
            <div class="mb-4">
                <div class="flex items-center mb-1">
                    <x-input-label for="amount" :value="__('Amount')" />
                    <span class="text-red-500">*</span>
                </div>
                <x-text-input
                    id="amount"
                    name="amount"
                    value="{{ old('amount') ?? $deduction->amount }}"
                    class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                    type="number"
                    autofocus
                    autocomplete="amount" />
                <x-input-error class="mt-2" :messages="$errors->get('amount')" />
            </div>

            <!-- Buttons -->
            <div class="flex justify-end gap-2">
                <button type="submit" class="flex items-center gap-1 px-4 py-2 text-sm font-medium text-white transition-colors duration-150 border border-transparent rounded-lg bg-purple-600 hover:bg-purple-700 active:bg-purple-700 focus:outline-none focus:ring focus:ring-purple-300">
                    Submit
                </button>
                <a href="{{ route('employees.deductions', ['employee_id' => $employee->id]) }}" class="flex items-center gap-1 px-4 py-2 text-sm font-medium text-white transition-colors duration-150 border border-transparent rounded-lg bg-red-500 hover:bg-red-600 active:bg-red-600 focus:outline-none focus:ring focus:ring-red-200">
                    Cancel
                </a>
            </div>
        </div>
    </form>
</x-app-layout>
