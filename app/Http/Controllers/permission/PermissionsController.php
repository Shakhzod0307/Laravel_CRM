<?php

namespace App\Http\Controllers\permission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsController extends Controller
{
  public function index()
  {
    $permissions = Permission::with('roles')->get();

    return view('permissions.index', compact('permissions'));
  }
  public function roles()
  {
    $permissions = Permission::with('roles')->get();

    return response()->json(['result'=>$permissions],200);
  }

  public function create(Request $request)
  {
    $request->validate([
      'name' => 'required|string|unique:roles',
    ]);

    $permission = Permission::create([
      'name' => $request->name,
    ]);

    return response()->json(['result'=>$permission],200);
  }
}
