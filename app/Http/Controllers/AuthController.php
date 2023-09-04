<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login()
    {
        return view('login.form');
    }

    public function register()
    {
        return view('Registrasi.form');
    }

    public function aksiregister(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            // 'level'=> 'required'
        ]);

        $data = [
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            // "level"=> $request->level,
        ];

        // //jika kasi tambah user berhasil

        $create = User::create($data);

        // dd($data);
        if ($create) {
            return redirect('/form-login')->withSuccess('akun anda telah terdaftar');
        }

        // //jika tidak
        else {
            return redirect()
                ->back()
                ->withInput();
        }
    }

    public function aksilogin(Request $request)
    {
        $request->validate([
            "email" => "required|email",
            "password" => "required",
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user(); // Mendapatkan instance pengguna yang sudah diautentikasi
            // Masukkan data ke sesi: id, name, dll.
            $data = [
                'id' => $user->id,
                'name' => $user->name,
                'level' => $user->level,
            ];
            session($data);

            return redirect("/Dashboard/")->with('success', 'Anda Berhasil Login');
        } else {
            return redirect()->back()->withErrors('Email atau Password Salah!');
        }
    }



    // public function index( User $user)
    // {
    //     $data = $user->all();
    //     // cek login, kalo udah login, masuk ke halaman dashboard
    //     if (Auth::check()) {
    //         dd($data);
    //         return view('Dashboard.prosesleveling',compact('userSession','data'));
    //     }

    //     return view('Login.form');
    // }

    public function destroy()
    {
        Auth::logout(); // Logout pengguna

        Session::invalidate(); // Mencabut sesi saat ini
        Session::flush(); // Menghapus semua data sesi

        return redirect('/form-login')->with('success', 'Anda Telah Logout'); // Alihkan dengan pesan sukses
    }
}
