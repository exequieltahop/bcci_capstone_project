<div>
    <div class="p-4 m-8 bg-white rounded-lg shadow-xs space-y-4">
        <div class="text-center">
            <div id="timeDisplay" class="text-3xl font-bold"></div>
            <div id="dateDisplay" class="text-1xl mt-2"></div>
        </div>

        @if (!$hasClockedOutToday)
            <div x-show="confirmAction === false" class="flex justify-center gap-2 my-4">
                @if ($state === 'clock in')
                    <x-primary-button @click="confirmAction = true" class="bg-green-600 hover:bg-green-500">
                        Time In
                    </x-primary-button>
                @else
                    <x-primary-button @click="confirmAction = true" class="bg-red-800 hover:bg-red-700">
                        Time Out
                    </x-primary-button>
                @endif
            </div>
        @endif

        <div x-show="confirmAction" class="px-6 py-4 max-w-md mx-auto text-sm">
            <form action="{{ route('entries.'. str_replace(' ', '-', $state)) }}" method="POST">
                @csrf
            <div class="text-center">
                <p class="text-gray-600 font-bold">Are you sure you want to {{ $state }}?</p>
            </div>
            <div class="flex justify-center space-x-4 py-2">
                <button type="submit" class="w-[60px] px-4 py-2 text-sm font-medium text-white bg-purple-600 rounded-lg hover:bg-purple-700 focus:outline-none focus:ring focus:ring-purple-300 transition">
                    Yes
                </button>
                <button @click="confirmAction = false" type="button" class="w-[60px] px-4 py-2 text-sm font-medium text-white bg-red-500 rounded-lg hover:bg-red-600 focus:outline-none focus:ring focus:ring-red-300 transition">
                    No
                </button>
            </div>
            </form>
        </div>

        @if (isset($entry))
            <div class="bg-white shadow-md rounded-lg px-6 max-w-md mx-auto border border-black py-4 text-sm">
                <h6 class="font-bold ">Time Logs</h6>
                <p class="text-gray-600">Time In: {{ $entry->clock_in->format('d-M-Y h:i a') }}</p>
                <p class="text-gray-600">Time Out: {{ $entry->clock_out?->format('d-M-Y h:i a') }}</p>
            </div>
        @endif

    </div>
    <script>
        function updateDateTime() {
            const now = new Date();
            const timezone = "{{ config('app.timezone') }}";

            // Format time as HH:MM:SS
            const time = now.toLocaleTimeString('en-US', { timeZone: timezone, hour12: false });

            // Format date
            const dateOptions = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            const date = now.toLocaleDateString('en-US', dateOptions);

            // Update the HTML content
            document.getElementById('timeDisplay').textContent = time;
            document.getElementById('dateDisplay').textContent = date;
        }

        // Update the date and time every second
        setInterval(updateDateTime, 1000);

        // Initialize the date and time display
        updateDateTime();
    </script>
</div>
