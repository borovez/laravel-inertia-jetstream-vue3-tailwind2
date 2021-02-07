<?php

namespace App\Actions\Authentication;

use App\Models\User;
use App\Rules\ReCaptchaRule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthenticateLoginAttempt
{
    public function __invoke($request)
    {
        Validator::make($request->all(), [
            'recaptcha_token' => ['required', new ReCaptchaRule($request->recaptcha_token)],
        ])->validate();

        $user = User::where('email', $request->email)->first();

        if ($user &&
            Hash::check($request->password, $user->password)) {
            return $user;
        }
    }
}
