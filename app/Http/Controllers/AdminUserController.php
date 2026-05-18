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

    public function create()
    {
        return view('admin.CRUDAuthAdmin.addadmin');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'password_plain' => $request->password,
            'role' => 'admin',
            'is_active' => 1
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Admin berhasil ditambahkan'
            ]);
        }

        return redirect()->route('admin.users')
            ->with('success', 'Admin berhasil ditambahkan');
    }
    public function edit($id)
    {
        $admin = User::findOrFail($id);

        return view('admin.CRUDAuthAdmin.editadmin', compact('admin'));
    }

    public function update(Request $request, $id)
    {
        $admin = User::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $admin->id,
            'password' => 'nullable|min:6'
        ]);

        $admin->name = $request->name;
        $admin->email = $request->email;

        if ($request->filled('password')) {
            $admin->password = Hash::make($request->password);
        }

        $admin->save();

        return redirect()->route('admin.users')
            ->with('success', 'Admin berhasil diupdate');
    }

    public function destroy($id)
    {
        $admin = User::findOrFail($id);
        $admin->delete();

        return response()->json([
            'success' => true,
            'message' => 'Admin berhasil dihapus'
        ]);
    }

}