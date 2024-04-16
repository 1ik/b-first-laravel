<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function login(LoginRequest $request){
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            if (auth()->user()->is_public==1) {
                $user = Auth::user();
                return response()->json(['user' => $user]);   
            } else {
                return response()->json(['error' => 'This account is not public'], 403);
            }
        } else {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
    }

    public function socialLogin(Request $request,string $provider=null)
    {
        return Socialite::driver($provider)->stateless()->redirect()->getTargetUrl();
    }

    public function callback(string $provider)
    {
        try {
            $user = Socialite::driver($provider)->stateless()->user();
        } catch (Exception $e) {
            return $this->sendFailedResponse($e->getMessage());
        }

        return empty( $user->email)
            ? "No id returned from {$provider} provider."
            : $this->loginOrCreateAccount($user, $provider);
    }

    protected function loginOrCreateAccount($providerUser, $provider)
    {
        $user = User::where('email', $providerUser->getEmail())->first();

        if($user){
            $user->update([
                'avatar' => $providerUser->avatar,
                'provider' => $provider,
                'provider_id' => $providerUser->id,
                'access_token' => $providerUser->token
            ]);
        }else{
            $user = User::create([
                'name' => $providerUser->getName(),
                'email' => $providerUser->getEmail(),
                'avatar' => $providerUser->getAvatar(),
                'provider' => $provider,
                'provider_id' => $providerUser->getId(),
                'access_token' => $providerUser->token,
                'password' => ''
            ]);
        }

        return response()->json([
            'message'   => 'Successfully Login Complete',
        ], 200);
    }
}
