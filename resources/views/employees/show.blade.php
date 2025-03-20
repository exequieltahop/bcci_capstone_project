<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row w-full gap-4">
            {{ __('Employee Information') }}

            @include('employees.partials.navigation')
        </div>
    </x-slot>

    <div class="flex flex-col gap-4 my-3">
        <div class="md:basis-1 p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <p class="text-lg my-2">{{ __('Personal Information') }}</p>

            <div class="flex flex-col gap-3">
                <div class="flex gap-2">
                    <span>Role:</span>
                    <small class="">
                        <span
                            class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium
                            @if ($user->role->name == App\Enums\RoleEnum::ADMIN->value) bg-red-100 text-red-800 @else bg-blue-100 text-blue-800 @endif">
                            {{ Str::title($user->role->name) }}
                        </span>
                    </small>
                </div>

                <div class="flex gap-2">
                    <span>Name:</span><b>{{ $user->full_name }}</b>
                </div>

                <div class="flex gap-2">
                    <span>Birth Date:</span><b>{{ $user->date_of_birth }}</b>
                </div>

                <div class="flex gap-2">
                    <span>Gender:</span><b>{{ Str::title($user->gender) }}</b>
                </div>

                <div class="flex gap-2">
                    <span>Address:</span><b>{{ Str::title($user->address) }}</b>
                </div>

                <div class="flex gap-2">
                    <span>Marital Status:</span><b>{{ Str::title($user->marital_status) }}</b>
                </div>

                <div class="flex gap-2">
                    <span>Contact Number:</span><b>{{ Str::title($user->contact_number) }}</b>
                </div>
            </div>
        </div>
        <div class="md:basis-1 p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <p class="text-lg my-2">{{ __('Employment Information') }}</p>

            <div class="flex flex-col gap-3">

                <div class="flex gap-2">
                    <span>Employee Code:</span><b>{{ $user->employee_code }}</b>
                </div>
                <div class="flex gap-2">
                    <span>Position:</span><b>{{ Str::title($user->employmentDetail?->position->name) }}</b>
                </div>

                <div class="flex gap-2">
                    <span>Department:</span><b>{{ $user->employmentDetail?->department }}</b>
                </div>

                <div class="flex gap-2">
                    <span>Manager:</span><b>{{ Str::title($user->employmentDetail?->manager->full_name) }}</b>
                </div>

                <div class="flex gap-2">
                    <span>Supervisor:</span><b>{{ Str::title($user->employmentDetail?->supervisor->full_name) }}</b>
                </div>

                <div class="flex gap-2">
                    <span>Employment Status:</span><b>{{ Str::title($user->employmentDetail?->employment_status) }}</b>
                </div>

                <div class="flex gap-2">
                    <span>Date Hired:</span><b>{{ $user->employmentDetail?->date_hired }}</b>
                </div>

                <div class="flex gap-2">
                    <span>Date Regularized:</span><b>{{ $user->employmentDetail?->date_regularized }}</b>
                </div>
            </div>
        </div>

        <div class="md:basis-1 p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <p class="text-lg my-2">{{ __('Payroll Information') }}</p>

            <div class="flex flex-col gap-3">

                <div class="flex gap-2">
                    <span>Basic Salary:</span><b>{{ Str::title($user->payrollInformation?->basic_salary) }}</b>
                </div>

                <div class="flex gap-2">
                    <span>Pay Mode:</span><b>{{ Str::title($user->payrollInformation?->pay_mode) }}</b>
                </div>

                <div class="flex gap-2">
                    <span>Payment Method:</span><b>{{ Str::title($user->payrollInformation?->payment_method) }}</b>
                </div>

                <div class="flex gap-2">
                    <span>Bank Account:</span><b>{{ Str::title($user->payrollInformation?->bank_account) }}</b>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
