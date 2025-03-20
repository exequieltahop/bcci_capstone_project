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
        <x-text-input id="basic_salary" name="basic_salary" type="number" class="mt-1 block w-full" :value="old('basic_salary')"  autofocus autocomplete="name" />
        <x-input-error class="mt-2" :messages="$errors->get('basic_salary')" />
    </div>

    <div class="max-w-xl mb-4">
        <div class="flex gap-1">
            <x-input-label for="pay_mode" :value="__('Pay Mode')" />
            <span class="text-red-500">*</span>
        </div>
        <select name="pay_mode" id="pay_mode" class="mt-1 block w-full py-2 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
            <option value="">Select one</option>
            @foreach (App\Enums\PayModeEnum::cases() as $paymode)
                <option value="{{ $paymode }}">{{ Str::title($paymode->value) }}</option>
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
            <select name="payment_method" id="payment_method" class="mt-1 block w-full py-2 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                <option value="">Select one</option>
                @foreach (App\Enums\PaymentMethodEnum::cases() as $paymentMethod)
                    <option value="{{ $paymentMethod }}">{{ Str::title($paymentMethod->value) }}</option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('payment_method')" />
        </div>

        <div class="flex-1">
            <div class="flex gap-1">
                <x-input-label for="bank_account" :value="__('Bank Account')" />
                <span class="text-gray-500 text-sm">(If applicable)</span>
            </div>
            <x-text-input id="bank_account" name="bank_account" type="text" class="mt-1 block w-full" :value="old('bank_account')" autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('bank_account')" />
        </div>
    </div>

</div>
