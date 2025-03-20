<x-app-layout>
    <x-slot name="header">
        @if (@if (auth()->user()->role->name == App\Enums\RoleEnum::ADMIN->value))
            {{ __('Employees Timesheet Logs') }}
        @endif
        @if (auth()->user()->role->name == App\Enums\RoleEnum::EMPLOYEE->value)
            {{ __('Timesheet Logs') }}
        @endif
    </x-slot>

    {{-- IF ADMIN --}}
    @if (auth()->user()->role->name == App\Enums\RoleEnum::ADMIN->value)
        <div class="p-4 bg-white rounded-lg shadow-xs flex flex-col gap-3">
            <div class="overflow-hidden mb-8 w-full rounded-lg border shadow-xs">
                <div class="overflow-x-auto w-full">
                    <table class="w-full whitespace-no-wrap">
                        <thead>
                            <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase bg-gray-50 border-b">
                                <th class="px-4 py-3">Date</th>
                                <th class="px-4 py-3">Clock In/Out</th>
                                <th class="px-4 py-3">Tardiness (mins)</th>
                                <th class="px-4 py-3">Undertime (mins)</th>
                                <th class="px-4 py-3">Hours Worked</th>
                                <th class="px-4 py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y">
                            {{-- @forelse($entries as $entry)
                                <tr class="text-gray-700">
                                    <td class="px-4 py-3 text-sm">
                                        {{ $entry->clock_in->format('d-M-Y') }}
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        <span class="block">In: {{ $entry->clock_in->format('h:i a') }}</span>
                                        <span class="block">Out: {{ $entry->clock_out?->format('h:i a') }}</span>
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        {{ $entry->tardiness }}
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        {{ $entry->undertime }}
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        {{ $entry->hours_worked }}
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        
                                    </td>
                                </tr>
                            @empty
                                <tr class="text-gray-700">
                                    <td class="px-4 py-3 text-sm text-center" colspan="4">
                                        No data
                                    </td>
                                </tr>
                            @endforelse --}}
                        </tbody>
                    </table>
                </div>
                <div class="px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase bg-gray-50 border-t sm:grid-cols-9">
                    {{ $entries->links() }}
                </div>
            </div>
        </div>
    @endif

    {{-- IF EMPLOYEE --}}
    @if (auth()->user()->role->name == App\Enums\RoleEnum::EMPLOYEE->value)
        <div class="p-4 bg-white rounded-lg shadow-xs flex flex-col gap-3">
            <div class="overflow-hidden mb-8 w-full rounded-lg border shadow-xs">
                <div class="overflow-x-auto w-full">
                    <table class="w-full whitespace-no-wrap">
                        <thead>
                            <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase bg-gray-50 border-b">
                                <th class="px-4 py-3">Date</th>
                                <th class="px-4 py-3">Clock In/Out</th>
                                <th class="px-4 py-3">Tardiness (mins)</th>
                                <th class="px-4 py-3">Undertime (mins)</th>
                                <th class="px-4 py-3">Hours Worked</th>
                                <th class="px-4 py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y">
                            @forelse($entries as $entry)
                                <tr class="text-gray-700">
                                    <td class="px-4 py-3 text-sm">
                                        {{ $entry->clock_in->format('d-M-Y') }}
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        <span class="block">In: {{ $entry->clock_in->format('h:i a') }}</span>
                                        <span class="block">Out: {{ $entry->clock_out?->format('h:i a') }}</span>
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        {{ $entry->tardiness }}
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        {{ $entry->undertime }}
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        {{ $entry->hours_worked }}
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        
                                    </td>
                                </tr>
                            @empty
                                <tr class="text-gray-700">
                                    <td class="px-4 py-3 text-sm text-center" colspan="4">
                                        No data
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase bg-gray-50 border-t sm:grid-cols-9">
                    {{ $entries->links() }}
                </div>
            </div>
        </div>
    @endif
</x-app-layout>
