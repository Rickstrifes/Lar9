<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Session;
use Hash;

class AuthController extends Controller
{
    public function login() {

        return view('auth.login');
    }

    public function authenticate(Request $Request) {

        $credentials = $Request->only('email', 'password');
        if(Auth::attempt($credentials)) {
            return redirect('posts');
        } else {
            return redirect('login')->with('error_message', 'Wrong email or password');
        }
    }

    public function logout() {

        Session::flush();
        Auth::logout();

        return redirect('login');

    }

    public function register_form() {
        return view('Auth.register');
    }

    public function register(Request $Request) {
        $Request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);


        User::create([
            'name' => $Request->post('name'),
            'email' => $Request->post('email'),
            'password' => Hash::make($Request->post('password'))
        ]);

        return redirect('login');
    }
}
