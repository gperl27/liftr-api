<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Workout;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class WorkoutsController extends Controller
{
  public function create(Request $request){
    if(! $user = JWTAuth::parseToken()->authenticate()){
      return response()->json(['msg' => 'User not found!'], 404);
    }

    $w = $user->workouts()->create($request->all());
    $workout = Workout::with('exercises')->find($w->id);

    return response()->json(['workout' => $workout, 'workouts' => $user->workouts()->get()]);
  }

  public function index(){
    if(! $user = JWTAuth::parseToken()->authenticate()){
      return response()->json(['msg' => 'User not found!'], 404);
    }

    return $user->workouts;
  }

  public function update_name(Request $request){
    Workout::find($request->id)->update(['name' => $request->name]);
    $workout = Workout::with('exercises')->find($request->id);

    if(! $user = JWTAuth::parseToken()->authenticate()){
      return response()->json(['msg' => 'User not found!'], 404);
    }

    return response()->json(['workout' => $workout, 'workouts' => $user->workouts()->get()]);
  }

  public function current_workout($date){
    if(! $user = JWTAuth::parseToken()->authenticate()){
      return response()->json(['msg' => 'User not found!'], 404);
    }
    // $user = User::find(1);

    // if($user->workouts()->where('day', $date)->exists()){
      $workout = $user->workouts()->with('exercises')->where('day', $date)->first();
    // } else {
      // $workout = 'No workout today';
      // $user->workouts()->create(['day' => $date]);
      // $workout = $user->workouts()->with('exercises')->where('day', $date)->first();
    // }
      return response()->json($workout);
    // }
  }

  public function destroy(Request $request){
    if(! $user = JWTAuth::parseToken()->authenticate()){
      return response()->json(['msg' => 'User not found!'], 404);
    }

    // may want to query using user in the future
    Workout::find($request->workoutId)->delete();

    // basically hardcoding empty object for now, will want to use dates
    // in case of multiple workouts per day the future
    $workout = (object) [];

    return response()->json(['workout' => $workout, 'workouts' => $user->workouts()->get()]);
  }
}
