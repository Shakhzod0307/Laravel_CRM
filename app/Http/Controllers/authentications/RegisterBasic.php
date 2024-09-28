<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterBasic extends Controller
{
  public function index()
  {
    return view('content.authentications.auth-register-basic');
  }
  public function store(Request $request)
  {
//      $request->validate([
//        'username' => 'required|string|max:250',
//        'first_name' => 'required|string|max:250',
//        'email' => 'required|string|email:rfc,dns|max:250|unique:users,email',
//        'password' => 'required|string|min:8|confirmed'
//      ]);
    $credentials = $request->only('username', 'first_name','email', 'password');
    $user = User::create([
          'username'=>$request->username,
          'first_name'=>$request->first_name,
          'email'=>$request->email,
          'password'=>Hash::make($request->password),
      ]);
      Auth::attempt($credentials);
      $request->session()->regenerate();

    $user->status= 'active';
    $user->save();
      return redirect()->route('dashboard-analytics')
        ->withSuccess('You have successfully registered & logged in!');

  }

}
