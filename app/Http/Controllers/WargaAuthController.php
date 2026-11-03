<?php

namespace App\Http\Controllers;

use App\Services\SmartResidentData;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WargaAuthController extends Controller
{
    public function showLogin(): View
    {
        return view('smartresident.auth.login-warga');
    }

    public function login(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $warga = SmartResidentData::findWarga($data['username'], $data['password']);

        if (!$warga) {
            return back()->withInput($request->only('username'))->withErrors([
                'login' => 'Username atau password salah!',
            ]);
        }

        session()->put('smartresident_user', $warga);
        session()->forget('smartresident_admin');

        return redirect()->route('warga.dashboard');
    }

    public function showRegister(): View
    {
        return view('smartresident.auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'max:50'],
            'password' => ['required', 'string', 'min:4'],
        ]);

        if (SmartResidentData::usernameExists($data['username'])) {
            return back()->withInput($request->except('password'))->withErrors([
                'username' => 'Username sudah terdaftar! Gunakan username lain.',
            ]);
        }

        SmartResidentData::addWarga($data['nama'], $data['username'], $data['password']);

        return redirect()->route('warga.login')->with('success', 'Registrasi akun warga berhasil! Silakan login.');
    }

    public function logout(): RedirectResponse
    {
        session()->forget('smartresident_user');
        return redirect()->route('smartresident.home')->with('success', 'Anda berhasil logout.');
    }
}
