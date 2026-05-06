<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
        public function index()
    {
        $admins = User::where('role', 'admin')->get();

        return view('admin.CRUDAuthAdmin.viewadminindex', compact('admins'));
    }

    // FORM CREATE
    public function create()
    {
        return view('admin.users.create');
    }

    // SIMPAN ADMIN
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
            'is_active' => 1
        ]);

        return redirect()->route('admin.users')->with('success', 'Admin berhasil ditambahkan');
    }

    // FORM EDIT
    public function edit($id)
    {
        $admin = User::findOrFail($id);

        return view('admin.users.edit', compact('admin'));
    }

    // UPDATE ADMIN
    public function update(Request $request, $id)
    {
        $admin = User::findOrFail($id);

        $admin->name = $request->name;
        $admin->email = $request->email;

        if ($request->password) {
            $admin->password = Hash::make($request->password);
        }

        $admin->save();

        return redirect()->route('admin.users')->with('success', 'Admin berhasil diupdate');
    }

    // DELETE ADMIN
    public function destroy($id)
    {
        User::findOrFail($id)->delete();

        return back()->with('success', 'Admin berhasil dihapus');
    }
}

