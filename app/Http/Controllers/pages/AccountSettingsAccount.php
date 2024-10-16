<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountSettingsAccount extends Controller
{
  public function index()
  {
    $user = Auth::user();
    return view('content.pages.pages-account-settings-account',compact('user'));
  }

  public function update(UpdateRequest $request)
  {
      $user = Auth::user();
//      dd($request->all());
      $user->first_name=$request->first_name;
      $user->last_name=$request->last_name;
      $user->email=$request->email;
      $user->phone=$request->phone;
      if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = $user->id.'_'.$image->getClientOriginalName();
        $image->storeAs('public/user/images', $imageName);
        $user->image = $imageName;
      }
      $user->organization=$request->organization;
      $user->language=$request->language;
      $user->state=$request->state;
      $user->zip_code=$request->zip_code;
      $user->address=$request->address;
      $user->country=$request->country;
      $user->currency=$request->currency;
      $user->save();
      return back()->with('success','Profile updated successfully!');

  }

}
