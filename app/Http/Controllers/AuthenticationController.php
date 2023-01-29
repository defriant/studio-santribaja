<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthenticationController extends Controller
{
    public function login_attempt(Request $request)
    {
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            return redirect('/dashboard');
        } else {
            Session::flash('failed');
            return redirect()->back()->withInput($request->all());
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function change_password(Request $request)
    {
        $cekPass = Hash::check($request->oldPass, Auth::user()->password);

        if ($cekPass === true) {
            User::where('id', Auth::user()->id)->update([
                "password" => bcrypt($request->newPass)
            ]);
            return response()->json([
                "response" => "success",
                "message" => "Password changed successfully"
            ]);
        } else {
            return response()->json([
                "response" => "failed",
                "message" => "Old password is wrong !"
            ]);
        }
    }
}
