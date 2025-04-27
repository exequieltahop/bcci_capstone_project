<x-app-layout>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>

    <x-slot name="header">
        @if (auth()->user()->role->name == App\Enums\RoleEnum::ADMIN->value)
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
            <div class="overflow-x-auto w-full p-3">
                <table class="w-full whitespace-no-wrap" id="employee-timesheet-logs-table">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase bg-primary text-white border-b">
                            <th class="px-4 py-3">Date</th>
                            <th class="px-4 py-3">Clock In/Out</th>
                            <th class="px-4 py-3">Tardiness (mins)</th>
                            <th class="px-4 py-3">Undertime (mins)</th>
                            <th class="px-4 py-3">Hours Worked</th>
                            {{-- <th class="px-4 py-3">Status</th> --}}
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y">
                        @foreach($entries as $entry)
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
                                {{-- <td class="px-4 py-3 text-sm">

                                </td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase bg-gray-50 border-b">
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
        </div>
    </div>
    @endif

    @if (auth()->user()->role->name == "admin")
        <script>
            document.addEventListener('DOMContentLoaded', ()=>{
                const employee_time_sheet_logs = new DataTable('#employee-timesheet-logs-table', {
                    responsive : true
                });
            });
        </script>
    @endif

    @if (auth()->user()->role->name == "employee")
        <script>
            document.addEventListener('DOMContentLoaded', ()=>{
                // const employee_time_sheet_logs = new DataTable('#employee-timesheet-logs-table', {
                //     responsive : true
                // })
            });
        </script>
    @endif

</x-app-layout>