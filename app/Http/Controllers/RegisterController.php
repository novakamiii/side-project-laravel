<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function __invoke(Request $request)
    {
        $userData = $request->validate([
            'name' => ['required', 'string'],
            'username' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $userData['password'] = bcrypt($userData['password']);

        $user = User::create($userData);

        Auth::login($user);

        return redirect()->route('Home');

    }
}
