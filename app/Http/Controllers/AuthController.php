<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login()
    {
        return view('front.auth.login');
    }

    public function proses_login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Kolom email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Kolom password harus diisi.',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return redirect()->back()->with('error', 'Email atau password salah. Silakan coba lagi.');
    }

    public function register()
    {
        return view('front.auth.register');
    }

    public function proses_register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique',
            'fullname' => 'required',
            'no_telp' => 'required',
            'otp' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ], [
            'username.required' => 'Kolom username harus diisi.',
            'username.unique' => 'Username sudah terdaftar.',
            'fullname.required' => 'Kolom nama lengkap harus diisi.',
            'no_telp.required' => 'Nomor handphone harus diisi',
            'otp.required' => 'Kolom otp harus diisi',
            'email.required' => 'Kolom email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Kolom password harus diisi.',
            'confirm_password.required' => 'Kolom konfirmasi password harus diisi.',
            'confirm_password.same' => 'Konfirmasi password harus cocok dengan password.',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return redirect()->back()->with('error', 'Email atau password salah. Silakan coba lagi.');
    }


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
