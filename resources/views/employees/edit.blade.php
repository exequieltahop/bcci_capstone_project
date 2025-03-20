<x-app-layout>
    <x-slot name="header">
        <div class="flex w-full">
            {{ __('Update Employees') }}

            <x-primary-button type="submit" id="triggerButton" class="ml-auto">Save</x-primary-button>
        </div>
    </x-slot>

    <form action="{{ route('employees.update', ['employee' => $user->id]) }}" method="POST"
        onsubmit="return confirm('Are you sure you want to update this record?')">
        @csrf
        @method('PUT')
        <x-primary-button hidden id="targetButton" class="ml-auto">Save</x-primary-button>

        <div class="flex flex-col gap-5 mb-5">

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <header>
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('User Information') }}
                    </h2>
                </header>

                <div class="flex flex-col md:flex-row gap-3 mb-4">
                    <div class="flex-1">
                        <div class="flex gap-1">
                            <x-input-label for="first_name" :value="__('First Name')" />
                            <span class="text-red-500">*</span>
                        </div>
                        <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full"
                            :value="old('first_name') ?? $user->first_name" autofocus autocomplete="name" />
                        <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
                    </div>

                    <div class="flex-1">
                        <div class="m-1">
                            <x-input-label for="middle_name" :value="__('Middle Name')" />
                        </div>
                        <x-text-input id="middle_name" name="middle_name" type="text" class="mt-1 block w-full"
                            :value="old('middle_name') ?? $user->middle_name" autofocus autocomplete="name" />
                    </div>

                    <div class="flex-1">
                        <div class="flex gap-1">
                            <x-input-label for="last_name" :value="__('Last Name')" />
                            <span class="text-red-500">*</span>
                        </div>
                        <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full"
                            :value="old('last_name') ?? $user->last_name" autofocus autocomplete="name" />
                        <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
                    </div>
                </div>

                <div class="flex flex-col md:flex-row gap-3 mb-4">
                    <div class="flex-1">
                        <div class="flex gap-1">
                            <x-input-label for="gender" :value="__('Gender')" />
                            <span class="text-red-500">*</span>
                        </div>
                        <select name="gender" id="gender"
                            class="mt-1 block w-full py-2 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                            <option value="">Select one</option>
                            @foreach (App\Enums\GenderEnum::cases() as $gender)
                                <option value="{{ $gender }}" @if ($user->gender == $gender->value) selected @endif>
                                    {{ Str::title($gender->value) }}</option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('gender')" />
                    </div>

                    <div class="flex-1">
                        <div class="flex gap-1">
                            <x-input-label for="marital_status" :value="__('Marital Status')" />
                            <span class="text-red-500">*</span>
                        </div>
                        <select name="marital_status" id="marital_status"
                            class="mt-1 block w-full py-2 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                            <option value="">Select one</option>
                            @foreach (App\Enums\CivilStatusEnum::cases() as $civilStatus)
                                <option value="{{ $civilStatus }}" @if ($user->marital_status == $civilStatus->value) selected @endif>
                                    {{ Str::title($civilStatus->value) }}</option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('marital_status')" />
                    </div>

                    <div class="flex-1">
                        <div class="flex gap-1">
                            <x-input-label for="date_of_birth" :value="__('Date of Birth')" />
                            <span class="text-red-500">*</span>
                        </div>
                        <input type="date" name="date_of_birth" id="date_of_birth" value="{{ $user->date_of_birth }}"
                            class="mt-1 block w-full py-2 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                        <x-input-error class="mt-2" :messages="$errors->get('date_of_birth')" />
                    </div>
                </div>

                <div class="max-w-xl mb-4">
                    <div class="flex gap-1">
                        <x-input-label for="contact_number" :value="__('Contact Number')" />
                        <span class="text-red-500">*</span>
                    </div>
                    <x-text-input id="contact_number" name="contact_number" type="text" class="mt-1 block w-full"
                        :value="$user->contact_number" autofocus autocomplete="contact_number" />
                    <x-input-error class="mt-2" :messages="$errors->get('contact_number')" />
                </div>

                <div class="max-w-xl mb-4">
                    <div class="flex gap-1">
                        <x-input-label for="email" :value="__('Email')" />
                        <span class="text-red-500">*</span>
                    </div>
                    <x-text-input id="email" type="email" class="mt-1 block w-full" :value="$user->email" autofocus
                        autocomplete="email" disabled />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                </div>

                <div class="w-full mb-4">
                    <div class="flex gap-1">
                        <x-input-label for="address" :value="__('Address')" />
                        <span class="text-red-500">*</span>
                    </div>
                    <x-text-input id="address" name="address" type="text" class="mt-1 block w-full"
                        :value="$user->address" autofocus autocomplete="address" />
                    <x-input-error class="mt-2" :messages="$errors->get('address')" />
                </div>

                <div class="flex flex-col md:flex-row gap-3 mb-4">
                    <div class="flex-4">
                        <div class="flex gap-1">
                            <x-input-label for="can_approve" :value="__('Can Approve')" />
                            <span class="text-red-500">*</span><small>(This user can allow to approve leaves and overtime)</small>
                        </div>
                        <select name="can_approve" id="can_approve" class="mt-1 block w-full py-2 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                            <option value="1" @if($user->can_approve) selected @endif>Yes</option>
                            <option value="0" @if(!$user->can_approve) selected @endif>No</option>
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('can_approve')" />
                    </div>
                </div>
            </div>


            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <header>
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Employment Details') }}
                    </h2>
                </header>

                <div class="max-w-xl mb-4">
                    <div class="flex-1">
                        <div class="flex gap-1">
                            <x-input-label for="employee_code" :value="__('Employee ID Number')" />
                            <span class="text-red-500">*</span>
                        </div>
                        <x-text-input id="employee_code" name="employee_code" type="text" class="mt-1 block w-full" :value="old('employee_code', $user->employee_code)"  autofocus autocomplete="name" />
                        <x-input-error class="mt-2" :messages="$errors->get('employee_code')" />
                    </div>
                </div>

                <div class="flex flex-col md:flex-row gap-3 mb-4">
                    <div class="flex-1">
                        <div class="flex gap-1">
                            <x-input-label for="position" :value="__('Position')" />
                            <span class="text-red-500">*</span>
                        </div>
                        <select name="position" id="position"
                            class="mt-1 block w-full py-2 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                            @foreach ($categories as $category)
                                <optgroup label="{{ $category->name }}">
                                    @foreach ($category->positions as $position)
                                        <option value="{{ $position->id }}"
                                            @if ($position->id == old('position') || $position->id == $user->employmentDetail->position_id) selected @endif>
                                            {{ Str::title($position->name) }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('position')" />
                    </div>

                    <div class="flex-1">
                        <div class="flex gap-1">
                            <x-input-label for="department" :value="__('Department')" />
                            <span class="text-red-500">*</span>
                        </div>
                        <x-text-input id="department" name="department" type="text" class="mt-1 block w-full"
                            :value="$user->employmentDetail->department" autofocus autocomplete="name" />
                        <x-input-error class="mt-2" :messages="$errors->get('department')" />
                    </div>
                </div>

                <div class="max-w-xl mb-4">
                    <div class="flex gap-1">
                        <x-input-label for="manager" :value="__('Manager')" />
                    </div>
                    <select name="manager" id="manager"
                        class="mt-1 block w-full py-2 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                        @foreach ($positions as $position)
                            <optgroup label="{{ $position->name }}">
                                @foreach ($position->employmentDetails as $employmentDetail)
                                    <option value="{{ $employmentDetail->user->id }}"
                                        @if ($employmentDetail->user->id == old('manager') || $employmentDetail->user->id == $user->employmentDetail->manager_id) selected @endif>
                                        {{ Str::title($employmentDetail->user->full_name) }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('manager')" />
                </div>

                <div class="max-w-xl mb-4">
                    <div class="flex gap-1">
                        <x-input-label for="supervisor" :value="__('Supervisor')" />
                    </div>
                    <select name="supervisor" id="supervisor"
                        class="mt-1 block w-full py-2 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                        @foreach ($positions as $position)
                            <optgroup label="{{ $position->name }}">
                                @foreach ($position->employmentDetails as $employmentDetail)
                                    <option value="{{ $employmentDetail->user->id }}"
                                        @if (
                                            $employmentDetail->user->id == old('supervisor') ||
                                                $employmentDetail->user->id == $user->employmentDetail->supervisor_id) selected @endif>
                                        {{ Str::title($employmentDetail->user->full_name) }}
                                    </option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('manager')" />
                </div>

                <div class="max-w-xl mb-4">
                    <div class="flex gap-1">
                        <x-input-label for="employment_status" :value="__('Employment Status')" />
                        <span class="text-red-500">*</span>
                    </div>
                    <select name="employment_status" id="employment_status"
                        class="mt-1 block w-full py-2 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                        <option value="">Select one</option>
                        @foreach (App\Enums\EmploymentStatusEnum::cases() as $employmentStatus)
                            <option value="{{ $employmentStatus }}" @if ($user->employmentDetail->employment_status == $employmentStatus->value) selected @endif>
                                {{ Str::title($employmentStatus->value) }}</option>
                        @endforeach
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('employment_status')" />
                </div>

                <div class="flex flex-col md:flex-row gap-3 mb-4">
                    <div class="flex-1">
                        <div class="flex gap-1">
                            <x-input-label for="date_hired" :value="__('Date Hired')" />
                            <span class="text-red-500">*</span>
                        </div>
                        <input type="date" name="date_hired" id="date_hired"
                            value="{{ $user->employmentDetail->date_hired }}"
                            class="mt-1 block w-full py-2 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                        <x-input-error class="mt-2" :messages="$errors->get('date_hired')" />
                    </div>

                    <div class="flex-1">
                        <div class="flex gap-1">
                            <x-input-label for="date_regularized" :value="__('Date Regulation')" />
                            <span class="text-red-500">*</span>
                        </div>
                        <input type="date" name="date_regularized" id="date_regularized"
                            value="{{ $user->employmentDetail->date_regularized }}"
                            class="mt-1 block w-full py-2 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                        <x-input-error class="mt-2" :messages="$errors->get('date_regularized')" />
                    </div>
                </div>
            </div>



            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <header>
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Payroll Information') }}
                    </h2>
                </header>

                <div class="max-w-xl mb-4">
                    <div class="flex gap-1">
                        <x-input-label for="basic_salary" :value="__('Basic Salary')" />
                        <span class="text-red-500">*</span>
                    </div>
                    <x-text-input id="basic_salary" name="basic_salary" type="number" class="mt-1 block w-full"
                        :value="old('basic_salary') ?? $user->payrollInformation?->basic_salary" autofocus autocomplete="name" />
                    <x-input-error class="mt-2" :messages="$errors->get('basic_salary')" />
                </div>

                <div class="max-w-xl mb-4">
                    <div class="flex gap-1">
                        <x-input-label for="pay_mode" :value="__('Pay Mode')" />
                        <span class="text-red-500">*</span>
                    </div>
                    <select name="pay_mode" id="pay_mode"
                        class="mt-1 block w-full py-2 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                        <option value="">Select one</option>
                        @foreach (App\Enums\PayModeEnum::cases() as $paymode)
                            <option value="{{ $paymode }}" @if ($user->payrollInformation?->pay_mode == $paymode->value) selected @endif>
                                {{ Str::title($paymode->value) }}</option>
                        @endforeach
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('pay_mode')" />
                </div>

                <div class="flex flex-col md:flex-row gap-3 mb-4">
                    <div class="flex-1">
                        <div class="flex gap-1">
                            <x-input-label for="payment_method" :value="__('Payment Method')" />
                            <span class="text-red-500">*</span>
                        </div>
                        <select name="payment_method" id="payment_method"
                            class="mt-1 block w-full py-2 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                            <option value="">Select one</option>
                            @foreach (App\Enums\PaymentMethodEnum::cases() as $paymentMethod)
                                <option value="{{ $paymentMethod }}"
                                    @if ($user->payrollInformation?->payment_method == $paymentMethod->value) selected @endif>
                                    {{ Str::title($paymentMethod->value) }}</option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('payment_method')" />
                    </div>

                    <div class="flex-1">
                        <div class="flex gap-1">
                            <x-input-label for="bank_account" :value="__('Bank Account')" />
                            <span class="text-gray-500 text-sm">(If applicable)</span>
                        </div>
                        <x-text-input id="bank_account" name="bank_account" type="text" class="mt-1 block w-full"
                            :value="old('bank_account') ?? $user->payrollInformation?->bank_account" autofocus autocomplete="name" />
                        <x-input-error class="mt-2" :messages="$errors->get('bank_account')" />
                    </div>
                </div>

            </div>

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
