<x-app-layout>
    <x-slot name="header">
        {{ __('Manage Employee Filed Leave Requests') }}
    </x-slot>

    <div class="p-4 bg-white rounded-lg shadow-xs flex flex-col gap-3">
        <div class="flex gap-2 justify-end">
            <form id="approve-all-form" action="{{ route('leaves.bulkApprove') }}" method="post"> @csrf
                <button
                    class="px-4 py-2 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-green-600 border border-transparent rounded-lg active:bg-green-600 hover:bg-green-700 focus:outline-none focus:ring"
                    type="button" onclick="submitApproveAllForm()">Bulk Approve</button>
            </form>
        </div>
        <div class="overflow-hidden mb-8 w-full rounded-lg border shadow-xs">

            <div class="overflow-x-auto w-full">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase bg-gray-50 border-b">
                            <th class="px-4 py-3"><input type="checkbox" name="leave-checkbox" id="leave-checkbox"></th>
                            <th class="px-4 py-3">Date</th>
                            <th class="px-4 py-3">Credit Deduction</th>
                            <th class="px-4 py-3">Requestor</th>
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
                                    <input type="checkbox" name="leaves[]" id="leaves" class="leaves" value="{{ $leave->id }}">
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $leave->date }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $leave->total_credit }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $leave->user->fullName }}
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
                                <td class="px-4 py-3 text-sm flex gap-2">
                                    @if (
                                        !in_array($leave->status, [
                                            App\Enums\StatusEnum::APPROVED->value,
                                            App\Enums\StatusEnum::CANCELLED->value,
                                            App\Enums\StatusEnum::REJECTED->value,
                                        ]) &&
                                            (auth()->user()->role->name == App\Enums\RoleEnum::ADMIN->value ||
                                                ((auth()->id() == $leave->user->employmentDetail->manager_id && $leave->is_mgr_approval_status) ||
                                                    (auth()->id() == $leave->user->employmentDetail->supervisor_id && $leave->is_sp_approval_status))))
                                        <form action="{{ route('leaves.approve-operation', ['leave' => $leave]) }}"
                                            method="post">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="px-4 py-2 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-green-600 border border-transparent rounded-lg active:bg-green-600 hover:bg-green-700 focus:outline-none focus:ring">Approve</button>
                                        </form>
                                    @endif

                                    @if (
                                        !in_array($leave->status, [
                                            App\Enums\StatusEnum::APPROVED->value,
                                            App\Enums\StatusEnum::CANCELLED->value,
                                            App\Enums\StatusEnum::REJECTED->value,
                                        ]))
                                        <a href="{{ route('leaves.cancel-page', ['leave' => $leave]) }}"
                                            class="px-4 py-2 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-lg active:bg-red-600 hover:bg-red-700 focus:outline-none focus:ring">Cancel</a>
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

    <script>
        document.getElementById('leave-checkbox').addEventListener('change', function() {
            let checkboxes = document.querySelectorAll('.leaves');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });

        function submitApproveAllForm() {
            let form = document.getElementById('approve-all-form');
            let checkboxes = document.querySelectorAll('.leaves:checked');
            checkboxes.forEach(checkbox => {
                let input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'leaves[]';
                input.value = checkbox.value;
                form.appendChild(input);
            });
            form.submit();
        }
    </script>
</x-app-layout>
