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

            if ($request->wantsJson()) {
                $token = Auth::user()->createToken('authToken')->plainTextToken;
            }else{
                $request->session()->regenerate();
            }

            return $request->wantsJson()
                ? response()->json([
                    "message" => "Successfully login",
                    'access_token' => $token,
                    'token_type' => 'Bearer'], 200)
                :  redirect()->route('event.index')->with('success', 'Successfully login');
        }
        return $request->wantsJson()
            ? response()->json(["message" => "User not found"], 200)
            :  redirect()->back()->with('error', 'User not found');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return $request->wantsJson()
                ? response()->json(["message" => "Logout Successfully"], 200)
                :  redirect()->route('login')->with('success', 'Logout Successfully');
    }
}
