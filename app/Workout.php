<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;
use App\Exercise;

class Workout extends Model
{
  protected $fillable = [
      'day', 'week'
  ];
  public function user(){
    return $this->belongsTo(User::class);
  }

  public function exercises(){
    return $this->hasMany(Exercise::class);
  }
}
