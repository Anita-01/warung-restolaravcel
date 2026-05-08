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
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin'
        ]);

        return redirect()->route('admin.users.index')
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

        $admin->update([
            'name' => $request->name,
            'email' => $request->email
        ]);

        // update password jika diisi
        if ($request->password) {
            $admin->update([
                'password' => Hash::make($request->password)
            ]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'Admin berhasil diupdate');
    }


    public function destroy($id)
    {
        User::findOrFail($id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Admin berhasil dihapus'
        ]);
    }
}