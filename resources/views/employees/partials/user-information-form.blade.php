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
            <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full" :value="old('first_name')"  autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
        </div>

        <div class="flex-1">
            <div class="m-1">
                <x-input-label for="middle_name" :value="__('Middle Name')" />
            </div>
            <x-text-input id="middle_name" name="middle_name" type="text" class="mt-1 block w-full" :value="old('middle_name')" autofocus autocomplete="name" />
        </div>

        <div class="flex-1">
            <div class="flex gap-1">
                <x-input-label for="last_name" :value="__('Last Name')" />
                <span class="text-red-500">*</span>
            </div>
            <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full" :value="old('last_name')"  autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
        </div>
    </div>

    <div class="flex flex-col md:flex-row gap-3 mb-4">
        <div class="flex-1">
            <div class="flex gap-1">
                <x-input-label for="gender" :value="__('Gender')" />
                <span class="text-red-500">*</span>
            </div>
            <select name="gender" id="gender" class="mt-1 block w-full py-2 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                <option value="">Select one</option>
                @foreach (App\Enums\GenderEnum::cases() as $gender)
                    <option value="{{ $gender }}">{{ Str::title($gender->value) }}</option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('gender')" />
        </div>

        <div class="flex-1">
            <div class="flex gap-1">
                <x-input-label for="marital_status" :value="__('Marital Status')" />
                <span class="text-red-500">*</span>
            </div>
            <select name="marital_status" id="marital_status" class="mt-1 block w-full py-2 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                <option value="">Select one</option>
                @foreach (App\Enums\CivilStatusEnum::cases() as $civilStatus)
                    <option value="{{ $civilStatus }}">{{ Str::title($civilStatus->value) }}</option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('marital_status')" />
        </div>

        <div class="flex-1">
            <div class="flex gap-1">
                <x-input-label for="date_of_birth" :value="__('Date of Birth')" />
                <span class="text-red-500">*</span>
            </div>
            <input type="date" name="date_of_birth" id="date_of_birth" class="mt-1 block w-full py-2 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
            <x-input-error class="mt-2" :messages="$errors->get('date_of_birth')" />
        </div>
    </div>

    <div class="max-w-xl mb-4">
        <div class="flex gap-1">
            <x-input-label for="contact_number" :value="__('Contact Number')" />
            <span class="text-red-500">*</span>
        </div>
        <x-text-input id="contact_number" name="contact_number" type="text" class="mt-1 block w-full" :value="old('contact_number')"  autofocus autocomplete="contact_number" />
        <x-input-error class="mt-2" :messages="$errors->get('contact_number')" />
    </div>

    <div class="max-w-xl mb-4">
        <div class="flex gap-1">
            <x-input-label for="email" :value="__('Email')" />
            <span class="text-red-500">*</span>
        </div>
        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email')"  autofocus autocomplete="email" />
        <x-input-error class="mt-2" :messages="$errors->get('email')" />
    </div>

    <div class="max-w-xl mb-4">
        <div class="flex gap-1">
            <x-input-label for="address" :value="__('Address')" />
            <span class="text-red-500">*</span>
        </div>
        <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="old('address')"  autofocus autocomplete="address" />
        <x-input-error class="mt-2" :messages="$errors->get('address')" />
    </div>

    <div class="flex flex-col md:flex-row gap-3 mb-4">
        <div class="flex-4">
            <div class="flex gap-1">
                <x-input-label for="can_approve" :value="__('Can Approve')" />
                <span class="text-red-500">*</span><small>(This user can allow to approve leaves and overtime)</small>
            </div>
            <select name="can_approve" id="can_approve" class="mt-1 block w-full py-2 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                <option value="1">Yes</option>
                <option value="0" selected>No</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('can_approve')" />
        </div>
    </div>
</div>
