<x-app-layout>
    <x-slot name="header">
        {{ __('Payslip') }}
    </x-slot>

    <div class="p-4 bg-white rounded-lg shadow-xs flex flex-col gap-3">
        <div class="overflow-hidden mb-8 w-full rounded-lg border shadow-xs">
            <div class="overflow-x-auto w-full">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase bg-gray-50 border-b">
                            <th class="px-4 py-3">Date</th>
                            <th class="px-4 py-3">Total Earn</th>
                            <th class="px-4 py-3">Total Deductions</th>
                            <th class="px-4 py-3">Overall Total</th>
                            <th class="px-4 py-3">Date Created</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y">
                        @forelse($payslips as $payslip)
                            <tr class="text-gray-700">
                                <td class="px-4 py-3 text-sm">
                                    {{ $payslip->dateRange }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    ₱{{ number_format((float) $payslip->total_earn, 2, '.', ',') }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    ₱{{ number_format((float) $payslip->total_deductions, 2, '.', ',') }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    ₱{{ number_format((float) $payslip->overall_total, 2, '.', ',') }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $payslip->created_at->format('M d, Y') }}
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
                {{ $payslips->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
