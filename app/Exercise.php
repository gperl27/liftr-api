<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Workout;

class Exercise extends Model
{
  protected $fillable = [
		'name', 'weight', 'reps', 'sets'
	];

  public function workout(){
  	return $this->belongsTo(Workout::class);
  }
}
