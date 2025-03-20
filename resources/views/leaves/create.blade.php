<x-app-layout>
    <x-slot name="header">
        <div class="flex w-full">
            {{ __('Create Leave') }}

            <x-primary-button type="submit" id="triggerButton" class="ml-auto">Save</x-primary-button>
        </div>
    </x-slot>

    <form action="{{ route('leaves.store') }}" method="POST"
        onsubmit="return confirm('Are you sure you want to create this record?')">
        @csrf
        <x-primary-button hidden id="targetButton" class="ml-auto">Save</x-primary-button>

        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <header>
                <h2 class="text-lg font-medium text-gray-900">
                    {{ __('Leave Information') }}
                </h2>
            </header>

            <div class="max-w-xl mb-4">
                <div class="flex gap-1">
                    <x-input-label for="leave_type" :value="__('Leave Type')" />
                    <span class="text-red-500">*</span>
                </div>
                <select name="leave_type" id="leave_type"
                    class="mt-1 block w-full py-2 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                    <option value="">Select one</option>
                    @foreach ($leaveCredits as $leaveCredit)
                        <option value="{{ $leaveCredit->leaveType->id }}"
                            @if ($leaveCredit->leaveType->id == old('leave_type')) selected @endif>
                            {{ Str::title($leaveCredit->leaveType->name) }} ({{ Str::title($leaveCredit->prettyCredit()) }}) - {{ $leaveCredit->balance }}
                        </option>
                    @endforeach
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('leave_type')" />
            </div>

            <div class="max-w-xl mb-4">
                <div class="flex gap-1">
                    <x-input-label for="date_from" :value="__('Date From')" />
                    <span class="text-red-500">*</span>
                </div>
                <x-text-input id="date_from" name="date_from" type="date" class="mt-1 block w-full" :value="old('date_from')"
                    autofocus autocomplete="date" />
                <x-input-error class="mt-2" :messages="$errors->get('date_from')" />
            </div>

            <div class="max-w-xl mb-4">
                <div class="flex gap-1">
                    <x-input-label for="date_to" :value="__('Date To')" />
                    <span class="text-red-500">*</span>
                </div>
                <x-text-input id="date_to" name="date_to" type="date" class="mt-1 block w-full" :value="old('date_to')"
                    autofocus autocomplete="date" />
                <x-input-error class="mt-2" :messages="$errors->get('date_to')" />
            </div>

            <div class="max-w-xl mb-4">
                <div class="flex gap-1">
                    <x-input-label for="type" :value="__('Type')" />
                    <span class="text-red-500">*</span>
                </div>
                <select name="type" id="type"
                    class="mt-1 block w-full py-2 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                    <option value="">Select one</option>
                    {{-- <option value="0.5" @if (old('type') == '0.5') selected @endif>Half Day</option> --}}
                    <option value="1" @if (old('type') == '1') selected @endif>Whole Day</option>
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('type')" />
            </div>

            <div class="max-w-xl mb-4">
                <div class="flex gap-1">
                    <x-input-label for="reason" :value="__('Reason')" />
                    <span class="text-red-500">*</span>
                </div>
                <textarea name="reason" id="reason" cols="100" rows="10"
                    class="mt-1 border-gray-300 rounded-md shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 focus-within:text-primary-600">{{ old('reason') }}</textarea>
                <x-input-error class="mt-2" :messages="$errors->get('reason')" />
            </div>
    </form>

    <script>
        // Get the buttons by their IDs
        const targetButton = document.getElementById('targetButton');
        const triggerButton = document.getElementById('triggerButton');

        // Add an event listener to the trigger button
        triggerButton.addEventListener('click', function() {
            // Programmatically trigger a click on the target button
            targetButton.click();
        });
    </script>
</x-app-layout>
