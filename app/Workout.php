<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;

class Workout extends Model
{
  protected $fillable = [
      'day', 'week'
  ];
  public function user(){
    return $this->belongsTo(User::class);
  }
}
