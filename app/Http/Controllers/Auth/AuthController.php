<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;

class AuthController extends Controller
{
    // Show login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle login
    public function login(Request $request)
    {
        // Validate the incoming request
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        // Attempt to log the user in
        if (Auth::attempt($credentials)) {
            $user = User::where('email', $request->email)->first();
            
            $existingToken = $user->tokens()->where('name', 'passport_token')->first();
    
            if (!$existingToken) {
                $token = $user->createToken('passport_token')->accessToken;
            } else {
                $token = $existingToken->accessToken;
            }
            // dd($token);
            $request->session()->put('passport_token', $token);

            $request->session()->regenerate();

            return redirect()->intended('/');
        }
    
        // If authentication fails, return back with an error message
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    // Show registration form
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Handle registration
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);


        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Registration successful! Please log in.');
    }

    // Handle logout
    public function logout(Request $request)
    {
        // Revoke the Passport token
        $user = Auth::user();
        $user->tokens->each(function ($token) {
            $token->delete();
        });

        // Log the user out and invalidate session
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
