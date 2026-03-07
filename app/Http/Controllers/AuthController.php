<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin() { return view('auth.login'); }

    public function login(Request $request) {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('/');
        }
        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function logout() {
        Auth::logout();
        return redirect('/login');
    }
}
