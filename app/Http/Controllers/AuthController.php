<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerate();

        return redirect()->route('login');
    }
}
