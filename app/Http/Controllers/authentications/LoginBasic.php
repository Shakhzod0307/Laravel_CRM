<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginBasic extends Controller
{
  public function index()
  {
    return view('content.authentications.auth-login-basic');
  }

  public function login(Request $request)
  {
    $credentials = $request->validate([
      'username' => ['required'],
      'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
      $request->session()->regenerate();
      $user = Auth::user();
      $user->status= 'active';
      $user->save();
      return redirect()->route('dashboard-analytics')
        ->withSuccess('You have successfully registered & logged in!');
    }

    return back()->withErrors([
      'username' => 'The provided credentials do not match our records.',
    ])->onlyInput('username');
  }

}
