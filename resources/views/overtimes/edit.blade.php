<x-app-layout>
    <x-slot name="header">
        {{ __('Update Overtime Hours') }}
    </x-slot>

    <form action="{{ route('overtimes.update', compact('overtime')) }}" method="POST" onsubmit="return confirm('Are you sure you want to update this record?')">
        @method('PATCH')
        @csrf
        <div class="max-w-xl mx-auto p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <header class="pb-3">
                <h2 class="text-lg font-medium text-gray-900">{{ __('Overtime Information') }}</h2>
            </header>

            <input type="hidden" name="overtime_id" value="{{ $overtime->id }}" />

            <!-- Overtime Date Selection -->
            <div class="mb-4">
                <div class="flex items-center mb-1">
                    <x-input-label for="entry_id" :value="__('Date')" />
                    <span class="text-red-500">*</span>
                </div>
                <select
                    id="entry_id"
                    name="entry_id"
                    class="mt-1 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                    <option value=""> - - - </option>
                    @foreach ($entries as $entry)
                        <option
                            value="{{ $entry->id }}"
                            @if ($entry->id == (old('entry_id') ?? $overtime->entry_id)) selected @endif
                            data-date="{{ $entry->clock_in->format('d-M-Y') }}"
                            data-clock-in="{{ $entry->clock_in->format('h:i a') }}"
                            data-clock-out="{{ $entry->clock_out->format('h:i a') }}">
                            {{ $entry->clock_in->format('d-M-Y') }}
                        </option>
                    @endforeach
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('entry_id')" />
                <x-input-error class="mt-2" :messages="$errors->get('duplicate_ot')" />
            </div>

            <!-- Time Logs Section -->
            <div id="time-logs" class="hidden px-6 pt-4 pb-4 max-w-xl text-sm border border-gray mb-4">
                <h6 class="font-bold">Time Logs</h6>
                <p id="tl-clock-in" class="text-gray-600"></p>
                <p id="tl-clock-out" class="text-gray-600"></p>
            </div>

            <!-- Time Started Input -->
            <div class="mb-4">
                <div class="flex items-center mb-1">
                    <x-input-label for="time_start" :value="__('Time Started')" />
                    <span class="text-red-500">*</span>
                </div>
                <x-text-input
                    id="time_start"
                    name="time_start"
                    value="{{ (old('time_start') ?? $overtime->time_start->format('H:i')) }}"
                    class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                    type="time" />
                <x-input-error class="mt-2" :messages="$errors->get('time_start')" />
                <x-input-error class="mt-2" :messages="$errors->get('invalid_time_start')" />
            </div>

            <!-- Time Ended Input -->
            <div class="mb-4">
                <div class="flex items-center mb-1">
                    <x-input-label for="time_end" :value="__('Time Ended')" />
                    <span class="text-red-500">*</span>
                </div>
                <x-text-input
                    id="time_end"
                    name="time_end"
                    value="{{ (old('time_end') ?? $overtime->time_end->format('H:i')) }}"
                    class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                    type="time" />
                <x-input-error class="mt-2" :messages="$errors->get('time_end')" />
                <x-input-error class="mt-2" :messages="$errors->get('invalid_time_end')" />
            </div>

            <!-- Purpose Textarea -->
            <div class="mb-4">
                <div class="flex items-center mb-1">
                    <x-input-label for="purpose" :value="__('Purpose')" />
                    <span class="text-red-500">*</span>
                </div>
                <textarea
                    name="purpose"
                    id="purpose"
                    rows="5"
                    class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">{{ (old('purpose') ?? $overtime->purpose) }}</textarea>
                <x-input-error class="mt-2" :messages="$errors->get('purpose')" />
            </div>

            <!-- Buttons -->
            <div class="flex justify-end gap-2">
                <button type="submit" class="flex items-center gap-1 px-4 py-2 text-sm font-medium text-white transition-colors duration-150 border border-transparent rounded-lg bg-purple-600 hover:bg-purple-700 active:bg-purple-700 focus:outline-none focus:ring focus:ring-purple-300">
                    Submit
                </button>
                <a href="{{ route('overtimes.index') }}" class="flex items-center gap-1 px-4 py-2 text-sm font-medium text-white transition-colors duration-150 border border-transparent rounded-lg bg-red-500 hover:bg-red-600 active:bg-red-600 focus:outline-none focus:ring focus:ring-red-200">
                    Cancel
                </a>
            </div>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('entry_id').addEventListener('change', function() {
                const timeLogs = document.getElementById('time-logs');
                const entry    = this.options[this.selectedIndex];
                const date     = entry.getAttribute('data-date');
                const clockIn  = entry.getAttribute('data-clock-in');
                const clockOut = entry.getAttribute('data-clock-out');

                if (date === null) {
                    return false;
                }

                if (clockIn && clockOut) {
                    timeLogs.classList.remove('hidden');
                    document.getElementById('tl-clock-in').textContent  = `Clock In: ${date} ${clockIn}`;
                    document.getElementById('tl-clock-out').textContent = `Clock Out: ${date} ${clockOut}`;
                }
                else {
                    timeLogs.classList.remove('hidden');
                }
            });

            setTimeout(() => {
                const entryElement = document.getElementById('entry_id');
                if (entryElement) {
                    entryElement.dispatchEvent(new Event('change'));
                }
            }, 200);
        });
    </script>
</x-app-layout>
