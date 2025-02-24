<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Account;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
    
        $account = Account::where('email', $request->email)->first();
    
        if ($account && Hash::check($request->password, $account->password)) {
            Auth::login($account);
    
            $redirectRoutes = [
                'admin' => 'admin.dashboard',
                'bank_mini' => 'bank_mini.dashboard',
                'siswa' => 'siswa.dashboard'
            ];
    
            // Check if the role exists in the mapping
            if (isset($redirectRoutes[$account->role])) {
                return redirect()->route($redirectRoutes[$account->role]);
            }
    
            return redirect()->route('home'); // Default fallback
        }
    
        return back()->withErrors(['email' => 'Email atau password salah']);
    }
    

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
