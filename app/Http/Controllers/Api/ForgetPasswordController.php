<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ForgetPasswordController extends Controller
{
    public function forgotPassword(ForgotPasswordRequest $request){
           
           Password::sendResetLink($request->only('email'));
 
           return response()->json([
                'message' => 'Reset password link sent to your email'
            ],200);    
    }

    public function resetPassword(Request $request,$token){
          return view('auth.reset-password', ['request' => $request]);
    }

    public function passwordStore(Request $request){
           
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed'],
        ]);
        
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        return redirect()->back()->with(['success' => 'Your password has been reset.']);
    }


}
