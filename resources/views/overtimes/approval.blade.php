<x-app-layout>
    <x-slot name="header">
        {{ __('Manage Employee Overtime Requests') }}
    </x-slot>

    <div class="p-4 bg-white rounded-lg shadow-xs flex flex-col gap-3">
        <div class="overflow-hidden mb-8 w-full rounded-lg border shadow-xs">
            <div class="overflow-x-auto w-full">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase bg-gray-50 border-b">
                            <th class="px-4 py-3">Employee</th>
                            <th class="px-4 py-3">Details</th>
                            <th class="px-4 py-3">Purpose</th>
                            <th class="px-4 py-3">Approver(s)</th>
                            <th class="px-4 py-3">Comment</th>
                            <th class="px-4 py-3 mr-8 flex justify-end">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y">
                        @forelse($overtimes as $key => $overtime)
                            <tr class="text-gray-700">
                                <td class="px-4 py-3 text-sm">
                                    {{ $overtime->employee->full_name }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <span class="block"><strong>Date:</strong> {{ $overtime->time_start->format('d-M-Y') }}</span>
                                    <span class="block"><strong>Start:</strong> {{ $overtime->time_start->format('h:i a') }}</span>
                                    <span class="block"><strong>End:</strong> {{ $overtime->time_end->format('h:i a') }}</span>
                                    <span class="block"><strong>Total Hours:</strong> {{ $overtime->total_hours }}</span>
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
                                    @if (($overtime->employee->employmentDetail->supervisor_id === auth()->id() && $overtime->is_sp_approved === null) || ($overtime->employee->employmentDetail->manager_id === auth()->id() && $overtime->is_mng_approved === null))
                                        <textarea
                                            id="comment-{{$key}}"
                                            name="comment-{{$key}}"
                                            rows="5"
                                            class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                                            >{{ $overtime->comment }}</textarea>
                                    @else
                                        {{ $overtime->comment }}
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm h-full flex justify-end gap-2">
                                    @if (
                                        !in_array($overtime->status, [
                                            App\Enums\StatusEnum::APPROVED,
                                            App\Enums\StatusEnum::CANCELLED,
                                            App\Enums\StatusEnum::REJECTED,
                                        ]) &&
                                        (auth()->user()->role->name == App\Enums\RoleEnum::ADMIN->value || ($overtime->employee->employmentDetail->supervisor_id === auth()->id() && $overtime->is_sp_approved === null) || ($overtime->employee->employmentDetail->manager_id === auth()->id() && $overtime->is_mng_approved === null)))
                                        <form action="{{ route('overtimes.approved', compact('overtime')) }}" method="post" onsubmit="return confirm('Do you want to approved this overtime?')">
                                            @csrf
                                            <textarea id="approved-comment-{{$key}}" name="comment" class="hidden"></textarea>
                                            <button href="{{ route('overtimes.approved', compact('overtime')) }}" class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 transition-colors duration-150 border border-transparent rounded-lg active:bg-gray-100 hover:bg-gray-200 focus:outline-none focus:shadow-outline-gray">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 0 1-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 9.953 4.167 9.5 5 9.5h1.053c.472 0 .745.556.5.96a8.958 8.958 0 0 0-1.302 4.665c0 1.194.232 2.333.654 3.375Z" />
                                                </svg>
                                            </button>
                                        </form>
                                        <form action="{{ route('overtimes.rejected', compact('overtime')) }}" method="post" onsubmit="return confirm('Do you want to reject this overtime?')">
                                            @csrf
                                            <textarea id="rejected-comment-{{$key}}" name="comment" class="hidden"></textarea>
                                            <button type="submit" class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 transition-colors duration-150 border border-transparent rounded-lg active:bg-gray-100 hover:bg-gray-200 focus:outline-none focus:shadow-outline-gray">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.498 15.25H4.372c-1.026 0-1.945-.694-2.054-1.715a12.137 12.137 0 0 1-.068-1.285c0-2.848.992-5.464 2.649-7.521C5.287 4.247 5.886 4 6.504 4h4.016a4.5 4.5 0 0 1 1.423.23l3.114 1.04a4.5 4.5 0 0 0 1.423.23h1.294M7.498 15.25c.618 0 .991.724.725 1.282A7.471 7.471 0 0 0 7.5 19.75 2.25 2.25 0 0 0 9.75 22a.75.75 0 0 0 .75-.75v-.633c0-.573.11-1.14.322-1.672.304-.76.93-1.33 1.653-1.715a9.04 9.04 0 0 0 2.86-2.4c.498-.634 1.226-1.08 2.032-1.08h.384m-10.253 1.5H9.7m8.075-9.75c.01.05.027.1.05.148.593 1.2.925 2.55.925 3.977 0 1.487-.36 2.89-.999 4.125m.023-8.25c-.076-.365.183-.75.575-.75h.908c.889 0 1.713.518 1.972 1.368.339 1.11.521 2.287.521 3.507 0 1.553-.295 3.036-.831 4.398-.306.774-1.086 1.227-1.918 1.227h-1.053c-.472 0-.745-.556-.5-.96a8.95 8.95 0 0 0 .303-.54" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr class="text-gray-700">
                                <td class="px-4 py-3 text-sm text-center" colspan="6">
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let rows = {{ sizeof($overtimes->items()) }};

            for (let i = 0; i < rows; i++) {
                document.getElementById('comment-' + i).addEventListener('keyup', function() {
                    const approvedFormTextArea = document.getElementById('approved-comment-' + i);
                    const rejectedFormTextArea = document.getElementById('rejected-comment-' + i);
                    approvedFormTextArea.textContent = this.value;
                    rejectedFormTextArea.textContent = this.value;
                });
            }

            setTimeout(() => {
                for (let i = 0; i < rows; i++) {
                    const commentElement = document.getElementById('comment-' + i);
                    if (commentElement) {
                        commentElement.dispatchEvent(new Event('keyup'));
                    }
                }
            }, 1000);
        });
    </script>

</x-app-layout>
