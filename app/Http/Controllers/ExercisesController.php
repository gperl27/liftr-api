<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Exercise;
use App\Workout;
use JWTAuth;

class ExercisesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      // if(! $user = JWTAuth::parseToken()->authenticate()){
      //   return response()->json(['msg' => 'User not found!'], 404);
      // }
      $user = User::find(1);

      $exercises = Exercise::whereHas('workout', function($query) use ($user) {
                                             $query->where('user_id' , $user->id); })
                                            ->get();
      // by name for now
      $uniqueExercises = $exercises->unique('name')->values()->all();
      return response()->json($uniqueExercises);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
      if(! $user = JWTAuth::parseToken()->authenticate()){
        return response()->json(['msg' => 'User not found!'], 404);
      }

      if(!Workout::where('day', $request->date)->exists()){
        $user->workouts()->create(['day' => $request->date]);
      }

      $workout = Workout::where('day', $request->date)->first();
      $workout->exercises()->create($request->except('date'));

      return Workout::with('exercises')->find($workout->id);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($name)
    {
      if(! $user = JWTAuth::parseToken()->authenticate()){
        return response()->json(['msg' => 'User not found!'], 404);
      }

      $currentExerciseStats = Exercise::with('workout')->where('name', $name)
                                       ->whereHas('workout', function($query) use ($user) {
                                         $query->where('user_id' , $user->id); })
                                       ->where('weight', '!=', null)
                                       ->where('reps' , '!=', null)
                                       ->where('sets', '!=', null)
                                       ->get();

      return response()->json($currentExerciseStats);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $exercise = Exercise::find($id);
      $workout_id = $exercise->workout->id;
      $exercise->update($request->all());

      return Workout::with('exercises')->find($workout_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
      $exercise = Exercise::find($request->id);
      $workout_id = $exercise->workout->id;
      Exercise::find($request->id)->delete();

      return Workout::with('exercises')->find($workout_id);
    }
}
