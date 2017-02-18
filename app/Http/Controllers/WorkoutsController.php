<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class WorkoutsController extends Controller
{
  public function create(Request $request){
    // $this->validate($request, ['day' => 'required|string', 'week' => 'required|date']);
    // dd($request->request);
    $user = User::find($request->user_id);
    $user->workouts()->create($request->all());
    return $user->workouts()->get();
  }
}
