<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use DateTime;
use Carbon;

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

  public function current_week(){
    // if(! $user = JWTAuth::parseToken()->authenticate()){
    //   return response()->json(['msg' => 'User not found!'], 404);
    // }
    $user = User::find(1);

    $workouts = $user->workouts;
    // $currentWeek = $user->currentWeek;
    //will be checking against this to fix problem where refreshing takes users to previous or next weeks
    // $pageWasRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';
    // if($date && !$pageWasRefreshed){
    //     switch($date){
    //         case 'previous':
    //             $currentWeek--;
    //             $user->update(['currentWeek' => $currentWeek]);
    //             break;
    //         case 'next':
    //             $currentWeek++;
    //             $user->update(['currentWeek' => $currentWeek]);
    //             break;
    //         case 'current':
    //             $currentWeek = date('W');
    //             $user->update(['currentWeek' => $currentWeek]);
    //             break;
    //     }
    // }
    //Use Currentweek to delegate weeks
    //Refactor this
    // $dto = new DateTime();
    // $ret['monday'] = $dto->setISODate(date('Y'), $currentWeek)->format('Y-m-d');
    // $ret['sunday'] = $dto->modify('+6 days')->format('Y-m-d');
    // $monday = $ret['monday'];
    // $sunday = $ret['sunday'];
    // $weekof = $monday;

    $mondayWorkout = $this->findWorkout('Monday', $monday, $sunday, $workouts);
    $tuesdayWorkout = $this->findWorkout('Tuesday', $monday, $sunday, $workouts);
    $wednesdayWorkout = $this->findWorkout('Wednesday', $monday, $sunday, $workouts);
    $thursdayWorkout = $this->findWorkout('Thursday', $monday, $sunday, $workouts);
    $fridayWorkout = $this->findWorkout('Friday', $monday, $sunday, $workouts);
    // $saturdayWorkout = $this->findWorkout('Saturday', $monday, $sunday, $workouts);
    // $sundayWorkout = $this->findWorkout('Sunday', $monday, $sunday, $workouts);
    // if($mondayWorkout){
    //     $mondayExercises = $mondayWorkout->exercises;
    // }
    // if($tuesdayWorkout){
    //     $tuesdayExercises = $tuesdayWorkout->exercises;
    // }
    // if($wednesdayWorkout){
    //     $wednesdayExercises = $wednesdayWorkout->exercises;
    // }
    // if($thursdayWorkout){
    //     $thursdayExercises = $thursdayWorkout->exercises;
    // }
    // if($fridayWorkout){
    //     $fridayExercises = $fridayWorkout->exercises;
    // }
    // if($saturdayWorkout){
    //     $saturdayExercises = $saturdayWorkout->exercises;
    // }
    // if($sundayWorkout){
    //     $sundayExercises = $sundayWorkout->exercises;
    // }
    //

    //get the exercises of last week and current day for dashboard
    //for comparison week to week

    $lastweekDate = date('Y-m-d', strtotime('-1 week'));
    $lastweekWorkout = $workouts->where('week', $lastweekDate)->first();

    // if($lastweekWorkout){
    //     $lastweekExercises = $lastweekWorkout->exercises;
    // }
    return response()->json(compact('weekof',
                   'lastweekWorkout',
                   'mondayWorkout',
                   'tuesdayWorkout',
                   'wednesdayWorkout',
                   'thursdayWorkout',
                   'fridayWorkout'//,
                  // 'saturdayExercises', 'saturdayWorkout',
                  // 'sundayExercises', 'sundayWorkout'
              ));
    }

  private function findWorkout($day, $monday, $sunday, $workouts){
    // use 'with' exercise here
    return $workouts->where('week', '>=', $monday)
    ->where('week', '<=', $sunday)
    ->where('day' , $day )
    ->first();
  }
}
