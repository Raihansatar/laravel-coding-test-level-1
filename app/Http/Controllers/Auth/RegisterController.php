<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function register()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        if ($validator->fails()) {
            if($request->wantsJson()){
                return response()->json([
                    "message" => "Invalid input",
                    "error" => $validator->getMessageBag()
                ], 400);
            }else{
                return back()->with('error', $validator->getMessageBag());
            }
        }

        $data = $request->all();

        DB::beginTransaction();
        try {
            User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            DB::commit();

            return $request->wantsJson()
                ? response()->json(["message" => "User successfully register. You can login now"], 200)
                : redirect()
                    ->route('login')
                    ->with('success', "User successfully register. You can login now");

        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
            return $request->wantsJson()
                ? response()->json(["message" => "Failed to register user."], 200)
                : back()
                    ->with('error', "Failed to register user");
        }
    }
}
