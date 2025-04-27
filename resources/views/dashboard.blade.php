<x-app-layout>
    <x-slot name="header">
        {{ __('Dashboard') }}
    </x-slot>

    @if (auth()->user()->role->name == App\Enums\RoleEnum::ADMIN->value)
    <section class="container-fluid">
        <h3>Welcome back Admin!</h3>

        {{-- DISPLAY STATISTICS --}}
        <div class="row">
            {{-- TOTAL LOGIN TODAY --}}
            <div class="col-3 col-sm-3 m-2">
                <div class="bg-success p-3 text-white rounded shadow-lg">
                    <small>TOTAL LOGS TODAY</small>
                    <h3>
                        <i class="bi bi-person-walking"></i>
                        {{$today_login}}
                    </h3>
                </div>
            </div>

        @else
            @include('components.dtr-login')
        @endif
    </section>
</x-app-layout>