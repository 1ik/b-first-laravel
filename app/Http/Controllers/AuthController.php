<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function redirect(string $provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback(string $provider)
    {
        dd('333');
        $oAuthUser = Socialite::driver($provider)->user();

       // More logic to handle login or registration will be added later
    }
}
