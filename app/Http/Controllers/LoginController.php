<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(){
        return view('login');
    }

    public function auth(Request $request){
        $validated=$request->validate([
            'username'=>'required',
            'password'=>'required'
        ]);

        if(Auth::attempt($validated)){
            return redirect()->route('dashboard.index');
        }
          return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->onlyInput('username');
    }
}
