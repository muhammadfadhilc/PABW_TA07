<?php

namespace App\Http\Controllers;

use App\Services\SmartResidentData;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminAuthController extends Controller
{
    public function showLogin(): View
    {
        return view('smartresident.auth.login-admin');
    }

    public function login(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $admin = SmartResidentData::findAdmin($data['username'], $data['password']);

        if (!$admin) {
            return back()->withInput($request->only('username'))->withErrors([
                'login' => 'Username atau password admin salah!',
            ]);
        }

        session()->put('smartresident_admin', $admin);
        session()->forget('smartresident_user');

        return redirect()->route('admin.dashboard');
    }

    public function logout(): RedirectResponse
    {
        session()->forget('smartresident_admin');
        return redirect()->route('admin.login')->with('success', 'Sesi admin telah diakhiri.');
    }
}
