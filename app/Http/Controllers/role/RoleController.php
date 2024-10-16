<?php

namespace App\Http\Controllers\role;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
      $roles = Role::all();
      return view('roles.index',compact('roles'));
    }
    public function roles()
    {
      $roles = Role::all();
      return response()->json(['result'=>$roles],200);
    }

  public function create(Request $request)
  {
    $request->validate([
      'name' => 'required|string|unique:roles',
    ]);

    $role = Role::create([
      'name' => $request->name,
    ]);

    return response()->json(['result'=>$role],200);
  }
}
