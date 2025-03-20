<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row w-full gap-4">
            {{ __('My Leaves') }}

        </div>
    </x-slot>

    <div class="p-4 bg-white rounded-lg shadow-xs flex flex-col gap-3">

        {{-- <div class="inline-flex overflow-hidden mb-4 w-full bg-white rounded-lg shadow-md">
            <div class="flex justify-center items-center w-12 bg-blue-500">
                <svg class="w-6 h-6 text-white fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM21.6667 28.3333H18.3334V25H21.6667V28.3333ZM21.6667 21.6666H18.3334V11.6666H21.6667V21.6666Z">
                    </path>
                </svg>
            </div>

            <div class="px-4 py-2 -mx-3">
                <div class="mx-3">
                    <span class="font-semibold text-blue-500">Info</span>
                    <p class="text-sm text-gray-600">Sample table page</p>
                </div>
            </div>
        </div> --}}

        <div class="flex gap-2 mb-4">
            @foreach ($leaveCredits as $leaveCredit)
                <span>{{ $leaveCredit->leaveType->name }} - {{ $leaveCredit->balance }}</span>
            @endforeach
            <a href="{{ route('leaves.create') }}"
                class="px-4 py-2 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring ml-auto">
                Add
            </a>
        </div>

        <div class="overflow-hidden mb-8 w-full rounded-lg border shadow-xs">
            <div class="overflow-x-auto w-full">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase bg-gray-50 border-b">
                            <th class="px-4 py-3">Date</th>
                            <th class="px-4 py-3">Credit Deduction</th>
                            <th class="px-4 py-3">Approvers</th>
                            <th class="px-4 py-3">Reason</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Remarks</th>
                            <th class="px-4 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y">
                        @forelse($leaves as $leave)
                            <tr class="text-gray-700">
                                <td class="px-4 py-3 text-sm">
                                    {{ $leave->date }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $leave->total_credit }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <p>{{ $leave->user->employmentDetail->supervisor->full_name }} :
                                        {{ Str::title($leave->is_sp_approval_status) }}</p>
                                    <p>{{ $leave->user->employmentDetail->manager->full_name }} :
                                        {{ Str::title($leave->is_mgr_approval_status) }}</p>
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $leave->reason }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ Str::title($leave->status) }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $leave->remarks }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    @if (
                                        !in_array($leave->status, [
                                            App\Enums\StatusEnum::APPROVED->value,
                                            App\Enums\StatusEnum::CANCELLED->value,
                                            App\Enums\StatusEnum::REJECTED->value,
                                        ]))
                                        <a href="{{ route('leaves.cancel-page', ['leave' => $leave]) }}"
                                            class="px-4 py-2 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-lg active:bg-red-600 hover:bg-red-700 focus:outline-none focus:ring ml-auto">Cancel</a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr class="text-gray-700">
                                <td class="px-4 py-3 text-sm text-center" colspan="8">
                                    No data
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div
                class="px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase bg-gray-50 border-t sm:grid-cols-9">
                {{ $leaves->links() }}
            </div>
        </div>

    </div>
</x-app-layout>
