<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use App\Models\User;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logoutUser');
    }

    public function showLoginForm()
    {
        return view('logins.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        // leyandandu uniqe (Email + IP) mefeter
        $throttleKey = Str::lower($request->input('email')) . '|' . $request->ip();

        // mukeraw ke 3 gezi belay mehonun lemaregaget
        if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return redirect()->route('login')->with('error', "Too many attempts! Please wait $seconds seconds before trying again.");
        }

      
        if (Auth::attempt($credentials)) {
            // betekekel kegeba yetkoterwn error yatefaltal (Reset)
            RateLimiter::clear($throttleKey);
            return redirect()->route('dashboard');
        }

        // mgebat kalechale le 60 second yikoyal
        RateLimiter::hit($throttleKey, 60);

        $remaining = RateLimiter::remaining($throttleKey, 3);
        return redirect()->route('login')->with('error', "Invalid credentials! You have $remaining attempts remaining.");
    }

    public function logoutUser(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}