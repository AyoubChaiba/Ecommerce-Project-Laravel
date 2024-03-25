<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class adminController extends Controller
{
    public function index () {
        return view('admin.pages.login');
    }
    public function login (Request $request) {
        $validator = Validator::make($request->all(),[
            "email" => "required|email",
            "password" => "required",
        ]);
        if ($validator->passes()) {
            if (Auth::guard('admin')->attempt(["email" => $request->email, "password" => $request->password,])) {
                return redirect()->route('admin.dashboard')->with('session','welcome administration');
            } else {
                return redirect()->route('admin.show')->with('error','email and password is incorrect');
            };
        } else {
            return redirect()->route('admin.show')
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }
    }
}
