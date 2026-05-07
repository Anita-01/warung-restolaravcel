<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginAdminController extends Controller
{
    public function loginForm()
    {
        return view('admin.loginadmin');
    }

public function login(Request $request)
{
    $request->validate([
        'login' => 'required',
        'password' => 'required',
    ]);

    $field = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

    $credentials = [
        $field => $request->login,
        'password' => $request->password,
    ];

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        return redirect()->route('dashboardadmin');
    }

    return back()->with('error', 'Name/email atau password salah');
}

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Berhasil logout');
    }
}