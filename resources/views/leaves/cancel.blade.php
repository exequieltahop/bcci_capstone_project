<x-app-layout>
    <x-slot name="header">
        <div class="flex w-full">
            {{ __('Cancel Leave') }}

            <x-primary-button type="submit" id="triggerButton" class="ml-auto">Save</x-primary-button>
        </div>
    </x-slot>

    <form action="{{ route('leaves.cancel-operation', ['leave' => $leave]) }}" method="POST"
        onsubmit="return confirm('Are you sure you want to create this record?')">
        @csrf
        @method('PATCH')
        <x-primary-button hidden id="targetButton" class="ml-auto">Save</x-primary-button>

        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <header>
                <h2 class="text-lg font-medium text-gray-900">
                    {{ __('Leave Information') }}
                </h2>
            </header>

            <div class="max-w-xl mb-4">
                <div class="flex gap-1">
                    <x-input-label for="remarks" :value="__('Remarks')" />
                    <span class="text-red-500">*</span>
                </div>
                <textarea name="remarks" id="remarks" cols="100" rows="10"
                    class="mt-1 border-gray-300 rounded-md shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 focus-within:text-primary-600">{{ old('remarks') ?? $leave->remarks }}</textarea>
                <x-input-error class="mt-2" :messages="$errors->get('remarks')" />
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
