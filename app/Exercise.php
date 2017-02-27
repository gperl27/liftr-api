<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Workout;
use App\User;

class Exercise extends Model
{
  protected $fillable = [
		'name', 'weight', 'reps', 'sets'
	];

  public function workout(){
  	return $this->belongsTo(Workout::class);
  }

  public function user(){
  	return $this->workout->belongsTo(User::class);
  }
}
