<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $validasi = [
            'username' => "required",
            'password' => "required",
        ];
        $mesages = [
            "username.required" => "Username wajib diisi",
            "password.required" => "Password wajib diisi"
        ];
        $validation = Validator::make($request->all(),$validasi,$mesages);
        if($validation->fails()){
            return back()->withErrors($validation)
                ->withInput();
        }
        $credentials = [
            "username" => $request->username,
            "password" => $request->password,
        ];
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()
                ->intended('/')
                ->with('success', 'Login berhasil. Selamat datang!');
        }

        return back()->withErrors([
            'error_validasi' => 'Username atau password salah.',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')
            ->with('logout_success', 'Anda telah berhasil logout.');
    }
}
