<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

class UsersController extends Controller
{
  protected function create(Request $request)
  {
      return User::create([
          'name' => $request->name,
          'email' => $request->email,
          'password' => bcrypt($request->password),
          'currentWeek' => $request->currentWeek,
      ]);
  }
}
