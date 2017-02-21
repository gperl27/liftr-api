<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class WorkoutsController extends Controller
{
  public function create(Request $request){
    // $this->validate($request, ['day' => 'required|string', 'week' => 'required|date']);
    if(! $user = JWTAuth::parseToken()->authenticate()){
      return response()->json(['msg' => 'User not found!'], 404);
    }

    // dd($user);
    // no need to do this!
    // $user = User::find($user->id);

    $user->workouts()->create($request->all());
    return $user->workouts()->get();
  }

  public function index(){
    if(! $user = JWTAuth::parseToken()->authenticate()){
      return response()->json(['msg' => 'User not found!'], 404);
    }

    return $user->workouts;
  }

  public function current_workout($date){
    if(! $user = JWTAuth::parseToken()->authenticate()){
      return response()->json(['msg' => 'User not found!'], 404);
    }
    // $user = User::find(1);

    // if($user->workouts()->where('day', $date)->exists()){
      $workout = $user->workouts()->with('exercises')->where('day', $date)->first();
      return response()->json($workout);
    // }
  }

  public function delete($date){
    if(! $user = JWTAuth::parseToken()->authenticate()){
      return response()->json(['msg' => 'User not found!'], 404);
    }
    // $user = User::find(1);
    $workout = $user->workouts()->with('exercises')->where('day', $date)->first();

    return response()->json($workout);
  }
}
