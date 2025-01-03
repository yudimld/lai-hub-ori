<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    // public function store(LoginRequest $request): RedirectResponse
    // {
    //     $credentials = $request->only('username', 'password');

    //         if (Auth::attempt($credentials)) {
    //             $request->session()->regenerate();
    //             return redirect()->intended(RouteServiceProvider::HOME);
    //         }

    //     // Jika gagal, kembalikan ke halaman login dengan pesan error
    //     return back()->withErrors([
    //         'username' => 'The provided credentials do not match our records.',
    //     ])->onlyInput('username');

    //     $request->session()->regenerate();

    //     return redirect()->intended(RouteServiceProvider::HOME);
    // }

    public function store(LoginRequest $request): RedirectResponse
{
    $credentials = $request->only('username', 'password');

    if (Auth::attempt($credentials)) {
        // Regenerasi sesi untuk keamanan
        $request->session()->regenerate();

        // Tambahkan flash message
        session()->flash('success', 'Selamat datang di LAI-HUB!');

        // Redirect ke halaman utama
        return redirect()->intended(RouteServiceProvider::HOME);
    }

    // Jika gagal, kembalikan ke halaman login dengan pesan error
    return back()->withErrors([
        'username' => 'The provided credentials do not match our records.',
    ])->onlyInput('username');
}

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
