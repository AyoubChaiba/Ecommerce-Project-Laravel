<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class homeAdminController extends Controller
{
    public function index() {
        return view('admin.pages.dashboard');
    }

    public function logOut() {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.show')->with('notice', '');
    }
}
