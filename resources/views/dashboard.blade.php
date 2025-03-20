<x-app-layout>
    <x-slot name="header">
        {{ __('Dashboard') }}
    </x-slot>

    @if (auth()->user()->role->name == App\Enums\RoleEnum::ADMIN->value)
        <h3>Welcome back Admin!</h3>

        {{-- DISPLAY STATISTICS --}}
        <div class="row">
            {{-- TOTAL LOGIN TODAY --}}
            <div class="col-3 col-sm-3 m-2">
                <div class="bg-success p-3 text-white rounded shadow-lg">
                    <span>TOTAL LOGS TODAY</span>
                    <h3>
                        <i class="bi bi-person-walking"></i>
                        {{$today_login}}
                    </h3>
                </div>
            </div>
            {{-- <div class="col-3 col-sm-3 p-2">
                <div class="bg-success">
                    <span>TOTAL LOGS TODAY</span>
                    <h5>{{$today_login}}</h5>
                </div>
            </div>
            <div class="col-3 col-sm-3 p-2">
                <div class="bg-success">
                    <span>TOTAL LOGS TODAY</span>
                    <h5>{{$today_login}}</h5>
                </div>
            </div> --}}
        </div>

    @else
        @include('components.dtr-login')
    @endif
</x-app-layout>
