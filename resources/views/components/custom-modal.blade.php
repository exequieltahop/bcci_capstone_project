<div id="tailwind-modal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black bg-opacity-50">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-4 border-b">
                <h3 class="text-lg font-bold">Fingerprint Registration</h3>
                <button type="button" class="text-gray-400 hover:text-gray-600" id="toggle-btn">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <!-- Modal Body -->
            <div class="p-4">
                <div id="scanner-status" class="mb-4 text-center">
                    <p class="text-gray-600">Place your fingerprint to register</p>
                </div>

                <div class="flex justify-center mt-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.864 4.243A7.5 7.5 0 0 1 19.5 10.5c0 2.92-.556 5.709-1.568 8.268M5.742 6.364A7.465 7.465 0 0 0 4.5 10.5a7.464 7.464 0 0 1-1.15 3.993m1.989 3.559A11.209 11.209 0 0 0 8.25 10.5a3.75 3.75 0 1 1 7.5 0c0 .527-.021 1.049-.064 1.565M12 10.5a14.94 14.94 0 0 1-3.6 9.75m6.633-4.596a18.666 18.666 0 0 1-2.485 5.33" />
                      </svg>
                </div>

            </div>
            <!-- Modal Footer -->
            <div class="flex justify-end p-4 border-t">
                <button class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded hover:bg-gray-200"
                id="toggle-btn">Close</button>
            </div>
        </div>
    </div>
</div>
