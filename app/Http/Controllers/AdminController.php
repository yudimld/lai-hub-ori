<?php

namespace App\Http\Controllers;

use App\Models\User; 
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Ambil semua data pengguna dari koleksi MongoDB
        $users = User::all();

        // Kirim data pengguna ke view
        return view('admin.dashboard-admin', compact('users'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username', // Tambahkan validasi unique
            'email' => 'required|email|unique:users,email',
            'id_card' => 'required|string|max:255|unique:users,id_card',
            'role' => 'required|string',
            'password' => 'required|string|min:6|confirmed' // Password harus dikonfirmasi
            
        ]);
      
        // Simpan pengguna baru dengan password yang di-hash
        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'id_card' => $request->id_card,
            'role' => $request->role,
            'password' => bcrypt($request->password) // Hash password
        ]);
    
        return redirect()->route('admin.dashboard')->with('success', 'User added successfully.');
    }
    

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id, // Validasi unique dengan pengecualian user saat ini
            'email' => 'required|email|unique:users,email,' . $id, // Validasi unique untuk email
            'id_card' => 'required|string|max:255|unique:users,id_card,' . $id, // Validasi unique untuk id_card
            'role' => 'required|string',
            'password' => 'nullable|string|min:6|confirmed' // Password opsional
        ]);
    
        $user = User::findOrFail($id);
    
        // Update data pengguna
        $user->update([
            'name' => $request->name,
            'username' => $request->username, 
            'email' => $request->email,
            'id_card' => $request->id_card,
            'role' => $request->role,
            'password' => $request->password ? bcrypt($request->password) : $user->password // Update password jika ada
        ]);
    
        return redirect()->route('admin.dashboard')->with('success', 'User updated successfully.');
    }    
    

    public function destroy($id)
    {
        // Hapus data pengguna
        $user = User::findOrFail($id);
        $user->delete();

        // Redirect kembali ke dashboard admin dengan pesan sukses
        return redirect()->route('admin.dashboard')->with('success', 'User deleted successfully.');
    }
}
