<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',

        ]);
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            'status' => 'active',
        ];
        //attempt=mengechek email dan password
        if (Auth::attempt($credentials)) {
            //buat session dan buat session baru
            $request->session()->regenerate();
            return redirect()->route('complaint')->with('success', 'login succesfull');
            // return [
            //     'message' => 'Login berhasil',
            //     //ambil id user
            //     //ini yang ganti user_id=>1 di controller
            //     'user_id' => Auth::id()
            //     //auth::user(), mengembalikan object user
            //     //hampir semua data berdasarkan model
            // ];
        }
        return redirect()->route('login.form')->with('error', 'invalid credentials');
    }
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'nullable',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8',
        ], [
            'name.required' => 'harus isi nama',
            'email.required' => 'harus isi email',
            'email.unique' => 'email sudah ada',
            'password.required' => 'isi password',
            'password.confirmed' => 'pastikan dong',
            'password.min' => 'minimal 8 char',
        ]);
        DB::transaction(function () use ($request) {

            $user = User::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'status' => 'active',
            ]);
            $citizenRole = Role::where('name', 'citizen')->firstOrFail();
            $user->roles()->attach($citizenRole->id);
        });
        return redirect()->route('login.form')->with('success', 'registration succesfull!');
    }
    public function showLoginForm()
    {
        return view('auth.login');
    }
    public function showRegisterForm()
    {
        return view('auth.register');
    }
    public function logout(Request $request)
    {
        Auth::logout();
        //buang session lama
        $request->session()->invalidate();
        //buat token baru
        $request->session()->regenerateToken();
        return redirect()->route('login.form')->with('success', 'logout successful');
    }
}
