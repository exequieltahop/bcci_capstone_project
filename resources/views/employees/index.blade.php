<x-app-layout>

    <script src="{{ asset('js/shim.js') }}"></script>
    <script src="{{ asset('js/websdk.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ifvisible/1.0.6/ifvisible.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/async/3.2.4/async.min.js"></script>

    @vite(['resources/js/persona.js', 'resources/js/registerFingerprint.js'])

    <x-slot name="header">
        {{ __('Employees') }}
    </x-slot>

    <div class="p-4 bg-white rounded-lg shadow-xs flex flex-col gap-3">

        <div class="flex gap-2">

            <a href="{{ route('employees.create') }}"
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
                            <th class="px-4 py-3">Employee Code</th>
                            <th class="px-4 py-3">Name</th>
                            <th class="px-4 py-3">Email</th>
                            <th class="px-4 py-3">Role</th>
                            <th class="px-4 py-3">Position</th>
                            <th class="px-4 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y">
                        @forelse($employees as $employee)
                            <tr class="text-gray-700">
                                <td class="px-4 py-3 text-sm">
                                    {{ $employee->employee_code }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $employee->full_name }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $employee->email }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $employee->role->prettyCapName() }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ Str::upper($employee->employmentDetail?->position?->name) }}
                                </td>
                                <td class="px-4 py-3 flex gap-4">
                                    <a href="{{ route('employees.show', ['employee' => $employee]) }}"
                                        class="relative group text-blue-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>


                                        <span
                                            class="absolute left-1/2 bottom-full mb-2 hidden group-hover:flex -translate-x-1/2 px-2 py-1 text-xs text-white bg-gray-900 rounded shadow-lg">
                                            View
                                        </span>
                                    </a>
                                    <a href="{{ route('employees.edit', ['employee' => $employee]) }}"
                                        class="relative group text-yellow-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                        </svg>

                                        <span
                                            class="absolute left-1/2 bottom-full mb-2 hidden group-hover:flex -translate-x-1/2 px-2 py-1 text-xs text-white bg-gray-900 rounded shadow-lg">
                                            Edit
                                        </span>
                                    </a>


                                    @if ($employee->role->name !== 'admin')
                                        <form action="{{ route('employees.destroy', ['employee' => $employee]) }}"
                                            method="post"
                                            onsubmit="return confirm('Do you want to delete this record?')">
                                            @method('DELETE')
                                            @csrf

                                            <button type="submit" class="relative group text-red-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="size-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                </svg>
                                                <span
                                                    class="absolute left-1/2 bottom-full mb-2 hidden group-hover:flex -translate-x-1/2 px-2 py-1 text-xs text-white bg-gray-900 rounded shadow-lg">
                                                    Delete
                                                </span>
                                            </button>
                                        </form>



                                        <button type="button" class="relative group text-green-500"
                                            id="toggle-btn">
                                            <input type="hidden" name="employee_code" id="employee_code" value="{{$employee->employee_code}}">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M7.864 4.243A7.5 7.5 0 0 1 19.5 10.5c0 2.92-.556 5.709-1.568 8.268M5.742 6.364A7.465 7.465 0 0 0 4.5 10.5a7.464 7.464 0 0 1-1.15 3.993m1.989 3.559A11.209 11.209 0 0 0 8.25 10.5a3.75 3.75 0 1 1 7.5 0c0 .527-.021 1.049-.064 1.565M12 10.5a14.94 14.94 0 0 1-3.6 9.75m6.633-4.596a18.666 18.666 0 0 1-2.485 5.33" />
                                            </svg>


                                            <span
                                                class="absolute left-1/2 bottom-full mb-2 hidden group-hover:flex -translate-x-1/2 px-2 py-1 text-xs text-white bg-gray-900 rounded shadow-lg">
                                                Register Fingerprint
                                            </span>
                                        </button>
                                    @endif

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
            <div
                class="px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase bg-gray-50 border-t sm:grid-cols-9">
                {{ $employees->links() }}
            </div>
        </div>

    </div>

    @include('components.custom-modal')
</x-app-layout>
