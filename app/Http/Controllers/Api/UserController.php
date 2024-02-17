<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(LoginRequest $request) {
        $creds = $request->validated();
        $user = User::where('email', $creds['email'])->first();
        
        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response(['error' => 1, 'message' => 'invalid credentials'], 401);
        }

        if (config('delete_previous_access_tokens_on_login', false)) {
            $user->tokens()->delete();
        }

        $plainTextToken = $user->createToken('api-token')->plainTextToken;

        return response([
            'success' => true,
            'token' => $plainTextToken,
            'email'=>$user->email,
            'name'=>$user->name,
            'expire' => now()->addDay(1) ],  200);
    }

    public function logout(Request $request)
    {
        if ($request->user()) {

            $request->user()->currentAccessToken()->delete();
            return response()->json(['message' => 'Successfully logged out']);
        }

    }
}
