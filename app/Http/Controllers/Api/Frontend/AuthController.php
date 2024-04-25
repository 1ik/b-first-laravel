<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SocialLoginRequest;
use App\Http\Requests\UserRegistrationRequest;
use App\Jobs\SendActivationEmail;
use App\Mail\ActivationEmailNotification;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function login(LoginRequest $request){
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            if (auth()->user()->is_active==0) {
                return response()->json(['error' => 'Your account is not active, Please active your account from your email.'], 403);
            }
            if (auth()->user()->is_public==1) {
                $user = User::where('email', $request->email)->first();
                return response()->json([
                    'data'  => $user,
                    'token' => $user->createToken('visit-user-token')->plainTextToken,
                ]);   
            } else {
                return response()->json(['error' => 'This account is not public'], 403);
            }
        } else {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
    }

    public function socialLogin(SocialLoginRequest $request)
    {

        if($request->provider == 'google'){
            $user = User::where('email', $request->email)->first();

            if($user){
                $user->update([
                    'avatar' => $request->photo_url,
                    'provider' => $request->provider,
                    'provider_id' => $request->provider_id,
                    'access_token' => $request->access_token
                ]);
            }else{
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'avatar' => $request->photo_url,
                    'provider' => $request->provider,
                    'provider_id' => $request->provider_id,
                    'access_token' => $request->access_token,
                    'is_public' => 1,
                    'password' => ''
                ]);
            }
    
            return response()->json([
                'message'   => 'Successfully Login Complete',
                'data'      => $user,
                'token'     => $user->createToken('visit-user-token')->plainTextToken
            ], 200);   
        }
    }

    public function register(UserRegistrationRequest $request){
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'is_public' => 1,
            'password' => bcrypt($request->input('password')),
        ]);

        Mail::to($user->email)->send(new ActivationEmailNotification($user));

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user,
        ], JsonResponse::HTTP_CREATED);
    }

    public function activeUserAccount(User $user){
        $user->update(['is_active' => 1]);
        if($user->is_active == 1){
            return redirect()->route('activation-success')->with('message', 'Your account is already activated!');
        }
        return redirect()->route('activation-success')->with('message', 'Your account has been activated successfully!');
    }

    public function showSuccess()
    {
        return view('email.success');
    }

    // public function callback(string $provider)
    // {
    //     try {
    //         $user = Socialite::driver($provider)->stateless()->user();
    //     } catch (Exception $e) {
    //         return $this->sendFailedResponse($e->getMessage());
    //     }

    //     return empty( $user->email)
    //         ? "No id returned from {$provider} provider."
    //         : $this->loginOrCreateAccount($user, $provider);
    // }

    // protected function loginOrCreateAccount($providerUser, $provider)
    // {
    //     dd($providerUser);
    //     $user = User::where('email', $providerUser->getEmail())->first();

    //     if($user){
    //         $user->update([
    //             'avatar' => $providerUser->avatar,
    //             'provider' => $provider,
    //             'provider_id' => $providerUser->id,
    //             'access_token' => $providerUser->token
    //         ]);
    //     }else{
    //         $user = User::create([
    //             'name' => $providerUser->getName(),
    //             'email' => $providerUser->getEmail(),
    //             'avatar' => $providerUser->getAvatar(),
    //             'provider' => $provider,
    //             'provider_id' => $providerUser->getId(),
    //             'access_token' => $providerUser->token,
    //             'password' => ''
    //         ]);
    //     }

    //     return response()->json([
    //         'message'   => 'Successfully Login Complete',
    //     ], 200);
    // }
}
