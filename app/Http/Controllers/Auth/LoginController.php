<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $remember_me = $request->has('remember') ? true : false;

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password], $remember_me)){
            $request->session()->regenerate();
            return redirect()->route('event.index');
        }
        return redirect()->back()->with('error', 'User not found.');

    }
}
