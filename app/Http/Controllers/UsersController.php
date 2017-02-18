<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

class UsersController extends Controller
{
  protected function create_user(Request $request)
  {
      return User::create([
          'name' => $request->name,
          'email' => $request->email,
          'password' => bcrypt($request->password),
          'currentWeek' => $request->currentWeek,
      ]);
  }
}
