<x-guest-layout>

    <script src="{{ asset('js/shim.js') }}"></script>
    <script src="{{ asset('js/websdk.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ifvisible/1.0.6/ifvisible.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/async/3.2.4/async.min.js"></script>

    @vite(['resources/js/customFingerprint.js'])

    <div class="flex overflow-y-auto flex-col md:flex-row">
        <div class="h-32 md:h-auto md:w-1/2">
            <img aria-hidden="true" class="object-cover w-full h-full"
                src="{{ asset('images/forgot-password-office.jpeg') }}" alt="Office" />
        </div>

        <div class="flex justify-center items-center p-6 sm:p-12 md:w-1/2">
            <div class="w-full">

                <div id="scanner-status" class="mb-4 text-center">
                    <p class="text-gray-600">Click to start fingerprint capture</p>
                </div>

                <div class="bg-white px-6 max-w-md mx-auto py-4 text-sm mb-4">
                    <div class="flex gap-1">
                        <x-input-label for="employee_code" :value="__('Employee ID Numer')" />
                        <span class="text-red-500">*</span>
                    </div>
                    <x-text-input id="employee_code" name="employee_code" type="text" class="mt-1 block w-full" :value="old('date_from')"
                        autofocus />
                </div>
                <div class="bg-white shadow-md rounded-lg px-6 max-w-md mx-auto border border-black py-4 text-sm">
                    <h6 class="font-bold ">Employee Information</h6>
                    <p class="text-gray-600" id="employee-name"></p>
                    <p class="text-gray-600" id="time-in-text"></p>
                    <p class="text-gray-600" id="time-out-text"></p>
                </div>

            </div>
        </div>
    </div>
</x-guest-layout>
