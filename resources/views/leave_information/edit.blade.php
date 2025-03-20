<x-app-layout>
    <x-slot name="header">
        <div class="flex w-full">
            {{ __('Update Employee Leave Credits') }}

            <x-primary-button type="submit" id="triggerButton" class="ml-auto">Save</x-primary-button>
        </div>
    </x-slot>

    <form
        action="{{ route('employees.leave-information-update', ['employee_id' => request()->employee_id, 'leave_information_id' => $leaveInformation->id]) }}"
        method="POST" onsubmit="return confirm('Are you sure you want to update this record?')">
        @csrf
        @method('PUT')
        <x-primary-button hidden id="targetButton" class="ml-auto">Update</x-primary-button>

        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">

            <div class="max-w-xl mb-4">
                <div class="flex gap-1">
                    <x-input-label for="leave_type" :value="__('Leave Type')" />
                    <span class="text-red-500">*</span>
                </div>
                <select name="leave_type" id="leave_type"
                    class="mt-1 block w-full py-2 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                    <option value="" selected>Select one</option>
                    @foreach ($leaveTypes as $leaveType)
                        <option value="{{ $leaveType->id }}" @if ($leaveType->id == old('leave_type') || $leaveInformation->leave_type_id == $leaveType->id) selected @endif>
                            {{ $leaveType->name }}</option>
                    @endforeach
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('leave_type')" />
            </div>

            <div class="max-w-xl mb-4">
                <div class="flex gap-1">
                    <x-input-label for="balance" :value="__('Balance')" />
                    <span class="text-red-500">*</span>
                </div>
                <x-text-input id="balance" name="balance" type="number" class="mt-1 block w-full" :value="old('balance') ?? $leaveInformation->balance"
                    autofocus autocomplete="balance" />
                <x-input-error class="mt-2" :messages="$errors->get('balance')" />
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
