<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Calls extends Model
{
    use HasFactory;

  protected $guarded = [];

  public function user()
  {
    return $this->belongsTo(User::class, 'user_id');
  }

  public function agent()
  {
    return $this->belongsTo(User::class, 'agent_id');
  }

  public function rating():HasOne
  {
    return $this->hasOne(Ratings::class, 'call_id','id');
  }
}
