<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center gap-4">
            {{ __('My Overtime') }}
            <a href="{{ route('overtimes.create') }}" class="flex items-center gap-1 px-4 py-2 text-sm font-medium text-white transition-colors duration-150 border border-transparent rounded-lg bg-purple-600 hover:bg-purple-700 active:bg-purple-700 focus:outline-none focus:ring focus:ring-purple-300">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 26 26" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                </svg>
                <span>File Overtime</span>
            </a>
        </div>
    </x-slot>

    <div class="p-4 bg-white rounded-lg shadow-xs flex flex-col gap-3">
        <div class="overflow-hidden mb-8 w-full rounded-lg border shadow-xs">
            <div class="overflow-x-auto w-full">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase bg-gray-50 border-b">
                            <th class="px-4 py-3">Date</th>
                            <th class="px-4 py-3">Time</th>
                            <th class="px-4 py-3">Purpose</th>
                            <th class="px-4 py-3">Approver(s)</th>
                            <th class="px-4 py-3">Comment</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 mr-10 flex justify-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y">
                        @forelse($overtimes as $overtime)
                            <tr class="text-gray-700">
                                <td class="px-4 py-3 text-sm">
                                    {{ $overtime->time_start->format('d-M-Y') }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <span class="block">Start: {{ $overtime->time_start->format('h:i a') }}</span>
                                    <span class="block">End: {{ $overtime->time_end->format('h:i a') }}</span>
                                    <span class="block">Total Hours: {{ $overtime->total_hours }}</span>
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $overtime->purpose }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    @if ($overtime->employee->employmentDetail?->supervisor !== null)
                                        <span class="block">
                                            {{ $overtime->employee->employmentDetail?->supervisor?->full_name }}: {{ $overtime->is_sp_approved === true ? 'Approved' : ($overtime->is_sp_approved === false ? 'Rejected' : 'Pending') }}
                                        </span>
                                    @endif
                                    @if ($overtime->employee->employmentDetail?->manager !== null)
                                        <span class="block">
                                            {{ $overtime->employee->employmentDetail?->manager?->full_name }}: {{ $overtime->is_mng_approved === true ? 'Approved' : ($overtime->is_mng_approved === false ? 'Rejected' : 'Pending') }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $overtime->comment }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <span class="px-2 py-1 font-semibold leading-tight text-{{ $statusColor[$overtime->status->value] }}-600 bg-{{ $statusColor[$overtime->status->value] }}-100 rounded-full">
                                        {{ Str::title($overtime->status->value) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm flex justify-end gap-2">
                                    @if ($overtime->status->value === 'pending')
                                        <a href="{{ route('overtimes.edit', ['overtime' => $overtime->id]) }}" class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 transition-colors duration-150 border border-transparent rounded-lg active:bg-gray-100 hover:bg-gray-200 focus:outline-none focus:shadow-outline-gray">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('overtimes.destroy', ['overtime' => $overtime->id]) }}" method="post" onsubmit="return confirm('Do you want to delete this record?')">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 transition-colors duration-150 border border-transparent rounded-lg active:bg-gray-100 hover:bg-gray-200 focus:outline-none focus:shadow-outline-gray">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr class="text-gray-700">
                                <td class="py-4 text-sm text-center" colspan="7">
                                    No data
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase bg-gray-50 border-t sm:grid-cols-9">
                {{ $overtimes->links() }}
            </div>
        </div>

    </div>
</x-app-layout>
