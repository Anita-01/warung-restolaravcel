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
        $credentials = $request->validate([
            'name' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->role == 'admin') {
                return redirect()->route('dashboardadmin');
            }

            return redirect()->route('index');
        }

        return back()->with('error', 'Name atau password salah');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('index')
            ->with('success', 'Berhasil logout');
    }
}