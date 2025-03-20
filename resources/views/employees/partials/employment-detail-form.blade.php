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
            <x-text-input id="employee_code" name="employee_code" type="text" class="mt-1 block w-full" :value="old('employee_code')"  autofocus autocomplete="name" />
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
                            <option value="{{ $position->id }}" @if ($position->id == old('position')) selected @endif>
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
            <x-text-input id="department" name="department" type="text" class="mt-1 block w-full" :value="old('department')"
                autofocus autocomplete="name" />
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
                            @if ($employmentDetail->user->id == old('manager')) selected @endif>
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
                            @if ($employmentDetail->user->id == old('supervisor')) selected @endif>
                            {{ Str::title($employmentDetail->user->full_name) }}</option>
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
                <option value="{{ $employmentStatus }}">{{ Str::title($employmentStatus->value) }}</option>
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
                class="mt-1 block w-full py-2 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
            <x-input-error class="mt-2" :messages="$errors->get('date_hired')" />
        </div>

        <div class="flex-1">
            <div class="flex gap-1">
                <x-input-label for="date_regularized" :value="__('Date Regulation')" />
                <span class="text-red-500">*</span>
            </div>
            <input type="date" name="date_regularized" id="date_regularized"
                class="mt-1 block w-full py-2 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
            <x-input-error class="mt-2" :messages="$errors->get('date_regularized')" />
        </div>
    </div>
</div>
