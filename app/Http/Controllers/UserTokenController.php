<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

class UserTokenController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
                'device_name' => 'required'
            ]);

            $user = User::where('email', $request->get('email'))->first();

            if (!$user && !Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => 'Email no existe o no coincide'
                ]);
            }

            return response()->json([
                'token' => $user->createToken($request->device_name)->plainTextToken
            ]);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors(), 
            'message' => $e->getMessage()], 422);
        }
    }
}
