<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center gap-4">
            {{ __('Leave Types') }}
            <a href="{{ route('leave-types.create') }}"
                class="text-center gap-1 w-20 px-4 py-2 text-sm font-medium text-white transition-colors duration-150 border border-transparent rounded-lg bg-purple-600 hover:bg-purple-700 active:bg-purple-800 focus:outline-none focus:ring-2 focus:ring-purple-300 focus:ring-offset-2">
                Add
            </a>
        </div>
    </x-slot>

    <div class="p-4 bg-white rounded-lg shadow-xs">
        <div class="overflow-hidden mb-8 w-full rounded-lg border shadow-xs">
            <div class="overflow-x-auto w-full">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase bg-gray-50 border-b">
                            <th class="px-4 py-3">Name</th>
                            <th class="px-4 py-3">Is Paid</th>
                            <th class="px-4 py-3">Modified By</th>
                            <th class="px-4 py-3 mr-8 flex justify-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y">
                        @forelse ($leaveTypes as $leaveType)
                            <tr class="text-gray-700">
                                <td class="px-4 py-3 text-sm">
                                    {{ $leaveType->name }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $leaveType->prettyIsPaid() }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $leaveType->updater?->full_name }}
                                </td>
                                <td class="px-4 py-3 text-sm flex justify-end gap-2">
                                    <a href="{{ route('leave-types.edit', ['leave_type' => $leaveType->id]) }}" class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 transition-colors duration-150 border border-transparent rounded-lg active:bg-gray-100 hover:bg-gray-200 focus:outline-none focus:shadow-outline-gray">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('leave-types.destroy', ['leave_type' => $leaveType->id]) }}" method="post" onsubmit="return confirm('Do you want to delete this record?')">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 transition-colors duration-150 border border-transparent rounded-lg active:bg-gray-100 hover:bg-gray-200 focus:outline-none focus:shadow-outline-gray">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4">No Data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div
                class="px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase bg-gray-50 border-t sm:grid-cols-9">
                {{ $leaveTypes->links() }}
            </div>
        </div>

    </div>
</x-app-layout>
