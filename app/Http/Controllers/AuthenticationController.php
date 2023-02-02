<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\validation\ValidationException;


class AuthenticationController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required',
            'device_name' => 'required|string',
        ]);

        $user = User::whereEmail($request->email)->first();
        if (! $user || ! Hash::check($request->password, $user->password)) {
          throw ValidationException::withMessages([
              'email' => ['The provided credentials are incorrect.'],
          ]);
      }

        return[
            'access_token' => $user->createToken($request->device_name)->plainTextToken,
            'user' => $user,
        
        ];

   

    }
    

    public function logout(Request $request)
    {
      return $request->user()->currentAccessToken()->delete();
    }

    public function register(Request $request)
    {
      $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|unique:users,email',
        'password' => 'required|confirmed'
      ]);

      return User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),


      ]);
    }

    public  function profile(Request $request){
      return $request->User();

    }
}
