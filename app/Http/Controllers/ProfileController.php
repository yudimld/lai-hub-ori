<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function changePassword(Request $request)
    {
        \Log::info('Request received in changePassword', $request->all());
    
        // Validasi password baru
        $request->validate([
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        \Log::info('New password validation passed');
    
        // Validasi panjang current_password secara manual dengan minimum 6 karakter
        $trimmedPassword = trim($request->current_password);
        \Log::info('Length of current_password: ' . strlen($trimmedPassword));
        if (!isset($request->current_password) || strlen($trimmedPassword) < 6) {
            \Log::error('Current password is less than 6 characters: ' . strlen($trimmedPassword));
            return back()->with('error', 'Current password must be at least 6 characters.');
        }
    
        // Periksa apakah current_password cocok dengan hash di database
        if (!Hash::check($trimmedPassword, Auth::user()->password)) {
            \Log::info('Password mismatch for user: ' . Auth::id());
            return back()->with('error', 'Current password is incorrect');
        }
        \Log::info('Current password verified');
    
        // Update password
        $updateResult = Auth::user()->update([
            'password' => Hash::make($request->new_password),
        ]);
    
        if ($updateResult) {
            \Log::info('Password updated successfully for user: ' . Auth::id());
            return back()->with('success', 'Password successfully changed');
        } else {
            \Log::error('Failed to update password for user: ' . Auth::id());
            return back()->with('error', 'Failed to update password');
        }
    }
    
}
