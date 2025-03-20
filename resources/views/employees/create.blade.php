<x-app-layout>
    <x-slot name="header">
        <div class="flex w-full">
            {{ __('Create Employees') }}

            <x-primary-button type="submit" id="triggerButton" class="ml-auto">Save</x-primary-button>
        </div>
    </x-slot>

    <form action="{{ route('employees.store') }}" method="POST" onsubmit="return confirm('Are you sure you want to create this record?')">
        @csrf
        <x-primary-button hidden id="targetButton" class="ml-auto">Save</x-primary-button>

        <div class="flex flex-col gap-5 mb-5">
            @include('employees.partials.user-information-form')
            @include('employees.partials.employment-detail-form')
            @include('employees.partials.payroll-information-form')
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
