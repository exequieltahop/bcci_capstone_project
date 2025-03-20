<?php

namespace App\Http\Controllers\WebAuthn;

use App\Models\User;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Laragear\WebAuthn\Http\Requests\AttestationRequest;
use Laragear\WebAuthn\Http\Requests\AttestedRequest;

use function response;

class WebAuthnRegisterController
{
    /**
     * Returns a challenge to be verified by the user device.
     *
     * @param  \Laragear\WebAuthn\Http\Requests\AttestationRequest  $request
     * @return \Illuminate\Contracts\Support\Responsable
     */
    public function options(AttestationRequest $request): Responsable
    {
        $authAdminId = auth()->user()->id;
        Session::put('authId', $authAdminId);

        $user = User::where('email', $request->email)->first();
        Auth::login($user);

        return $request
            ->fastRegistration()
            //            ->userless()
            //            ->allowDuplicates()
            ->toCreate();
    }

    /**
     * Registers a device for further WebAuthn authentication.
     *
     * @param  \Laragear\WebAuthn\Http\Requests\AttestedRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function register(AttestedRequest $request): Response
    {
        $request->save();

        $adminUser = User::find(Session::get('authId'));
        Session::forget('authId');

        Auth::login($adminUser);

        return response()->noContent();
    }
}
