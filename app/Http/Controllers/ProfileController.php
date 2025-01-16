<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function changePassword(Request $request)
    {
        // Validasi password baru
        $request->validate([
            'new_password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        // Cek panjang current_password
        $trimmedPassword = trim($request->current_password);
        if (!isset($request->current_password) || strlen($trimmedPassword) < 6) {
            return back()->with('error', 'Current password must be at least 6 characters.');
        }

        // Verifikasi current_password
        if (!Hash::check($trimmedPassword, Auth::user()->password)) {
            return back()->with('error', 'Current password is incorrect');
        }
        
        try {
            // Update password
            $updateResult = Auth::user()->update([
                'password' => Hash::make($request->new_password),
            ]);

            // Cek apakah update berhasil
            if ($updateResult) {
                return back()->with('password_change_success', 'Password successfully changed');
            } else {
                return back()->with('error', 'Failed to update password');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update password');
        }
    }
}
