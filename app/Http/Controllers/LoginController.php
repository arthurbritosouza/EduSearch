<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic_folder;
use App\Models\Users;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function login_form(Request $request){
        // dd("caiu");
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            return redirect()->route('home');
        }

        throw ValidationException::withMessages([
            'email' => [trans('auth.failed')],
        ]);
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function register_user_form(Request $request){
        // dd("cao");
        // dd($request->name);
        $u = new Users;
        $u->name = $request->get("name");
        $u->email = $request->get("email");
        $u->password = bcrypt($request->get('password'));

        $u->save();

        return redirect()->route("login");
    }


}
