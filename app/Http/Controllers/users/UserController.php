<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
  public function users()
  {
    $users = User::with('roles')
      ->whereNot('id', auth()->id())
      ->orderByRaw('CASE WHEN status = "active" THEN 0 ELSE 1 END')
      ->get();
    return view('users.index',compact('users'));
  }
}
