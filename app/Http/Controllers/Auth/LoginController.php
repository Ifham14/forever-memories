<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Providers\RouteServiceProvider;
use App\Models\User;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // public function login(Request $request)
    // {
    //     $credentials = $request->validate([
    //         'email' => ['required', 'email'],
    //         'password' => ['required'],
    //     ]);
    //     $remember = $request->boolean('remember');
    //     if (Auth::attempt($credentials, $remember)) {
    //         $request->session()->regenerate();
            
    //         $user = Auth::user();
    //         //Redirect based on role
    //         if ($user->role === 'admin') {
    //             return redirect()->intended('/admin/dashboard');
    //         }

    //         return redirect()->intended('/dashboard');
    //     }
    //     return back()
    //         ->withErrors(['email' => 'The provided credentials do not match our records.'])
    //         ->withInput()
    //         ->with('message', 'Login failed: Invalid email or password.')
    //         ->with('type', 'error');
    // }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !\Hash::check($credentials['password'], $user->password)) {
            return back()
                ->withErrors(['email' => 'The provided credentials do not match our records.'])
                ->withInput()
                ->with('message', 'Login failed: Invalid email or password.')
                ->with('type', 'error');
        }

        if (!$user->is_active) {
            return back()
                ->withErrors(['email' => 'Your account is not activated yet. Please contact the administrator.'])
                ->withInput()
                ->with('message', 'Login failed: Account is inactive.')
                ->with('type', 'error');
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        // Redirect based on role
        if ($user->role === 'admin') {
            return redirect()->intended('/admin/dashboard');
        }

        return redirect()->intended('/dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}