<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\ApiResponseTrait;
use Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use ApiResponseTrait;

    public function register(Request $request)
    {
        $attr = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name'     => $attr['name'],
            'password' => bcrypt($attr['password']),
            'email'    => $attr['email'],
        ]);

        $token = $user->createToken('API Token')->plainTextToken;

        return $this->respondSuccess([
            'access_token' => $token,
            'token_type'   => 'Bearer',
        ]);
    }

    public function login(Request $request)
    {
        $attr = $request->validate([
            'email'    => 'required|string|email',
            'password' => 'required|string|min:6',
        ]);

        if (! Auth::attempt($attr)) {
            return $this->respondError('Credentials not match', 401);
        }

        $token = Auth::user()->createToken('API Token')->plainTextToken;

        return $this->respondSuccess([
            'access_token' => $token,
            'token_type'   => 'Bearer',
        ]);
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();

        return [
            'message' => 'Tokens Revoked',
        ];
    }

    public function me()
    {
        return $this->respondOk(new UserResource(auth()->user()));
    }
}
