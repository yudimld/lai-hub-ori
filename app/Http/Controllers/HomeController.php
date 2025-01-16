<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed', // Pastikan new_password_confirmation ada
        ]);

        // Verifikasi current password
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            // Jika password tidak cocok, tampilkan error
            return back()->with('error', 'Current password is incorrect.');
        }

        // Update password
        Auth::user()->update([
            'password' => Hash::make($request->new_password),
        ]);

        // Kirim pesan sukses
        Session::flash('success', 'Your password has been changed successfully.');
        return back();
    }
}
