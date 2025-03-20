<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("User information cannot be updated, due to tracking of employees. If the information is wrong kindly contact your Admin or HR.") }}
        </p>
    </header>

    {{-- <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form> --}}

    <div class="mt-6 space-y-6">

        <div>
            <x-input-label for="first_name" :value="__('First Name')" />
            <x-text-input id="first_name" type="text" class="mt-1 block w-full" :value="old('first_name', $user->first_name)" readonly autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
        </div>

        <div>
            <x-input-label for="middle_name" :value="__('Middle Name')" />
            <x-text-input id="middle_name" type="text" class="mt-1 block w-full" :value="old('middle_name', $user->middle_name)" readonly/>
            {{-- <x-input-error class="mt-2" :messages="$errors->get('middle_name')" /> --}}
        </div>

        <div>
            <x-input-label for="last_name" :value="__('Last Name')" />
            <x-text-input id="last_name" type="text" class="mt-1 block w-full" :value="old('last_name', $user->last_name)" readonly/>
            <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" readonly autocomplete="username" />
            {{-- <x-input-error class="mt-2" :messages="$errors->get('email')" /> --}}
        </div>

        <div>
            <x-input-label for="date_of_birth" :value="__('Date of Birth')" />
            <x-text-input id="date_of_birth" type="date" class="mt-1 block w-full" :value="old('date_of_birth', $user->date_of_birth)" readonly/>
            {{-- <x-input-error class="mt-2" :messages="$errors->get('date_of_birth')" /> --}}
        </div>

        <div>
            <x-input-label for="gender" :value="__('Gender')" />
            <x-text-input id="date_of_birth" type="text" class="mt-1 block w-full" value="{{ Str::title($user->gender) }}" readonly/>
            {{-- <x-input-error class="mt-2" :messages="$errors->get('gender')" /> --}}
        </div>
    </div>
</section>
