<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
  public function users()
  {
    return view('users.index');
  }
  public function usersList(Request $request)
  {
    $searchQuery = $request->input('search', '');
    if ($searchQuery){
      $users = User::with('roles')
        ->where('id', '!=', auth()->id())
        ->when($searchQuery, function ($query) use ($searchQuery) {
          $query->where(function ($q) use ($searchQuery) {
            $q->where('first_name', 'LIKE', "%{$searchQuery}%")
              ->orWhere('last_name', 'LIKE', "%{$searchQuery}%")
              ->orWhere('email', 'LIKE', "%{$searchQuery}%")
              ->orWhere('username', 'LIKE', "%{$searchQuery}%");
          });
        })
        ->orderByRaw('CASE WHEN status = "active" THEN 0 ELSE 1 END')
        ->paginate(20);
    }else{
      $users = User::with('roles')
        ->whereNot('id', auth()->id())
        ->orderByRaw('CASE WHEN status = "active" THEN 0 ELSE 1 END')
        ->paginate(20);
    }

    return response()->json(['data'=>$users],200);
  }

  public function account()
  {
    return view('users.account');
  }

}
