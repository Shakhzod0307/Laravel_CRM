<?php

namespace App\Http\Controllers\chat;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{

  public function users()
  {
    $users = User::with('roles')
      ->whereNot('id', auth()->id())
      ->orderByRaw('CASE WHEN status = "active" THEN 0 ELSE 1 END')
      ->get();
//    dd($users);
    return view('chat.index',compact('users'));
  }


  public function index(User $user)
  {
    $messages =  Message::query()
      ->where(function ($query) use ($user) {
        $query->where('sender_id', auth()->id())
          ->where('receiver_id', $user->id);
      })
      ->orWhere(function ($query) use ($user) {
        $query->where('sender_id', $user->id)
          ->where('receiver_id', auth()->id());
      })
      ->with(['sender', 'receiver'])
      ->orderBy('created_at', 'asc')
      ->get();
    return response()->json(['data'=>$messages],200);
  }

  public function show(User $user)
  {
    return view('chat.chatting', [
      'user' => $user
    ]);
  }

  public function sendMessage(Request $request, User $user)
  {
    $message = Message::create([
      'sender_id' => auth()->id(),
      'receiver_id' => $user->id,
      'text' => $request->input('message')
    ]);

    broadcast(new MessageSent($message));

    return response()->json($message);
  }
}
