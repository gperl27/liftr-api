<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1' ], function(){
 /**********
  * Auth *
  *********/
  Route::get('/get_authorized_user', 'AuthenticateController@getAuthenticatedUser');
  Route::post('/authenticate', 'AuthenticateController@authenticate');
 /*********
  * Users *
  *********/
  Route::post('/create_user', 'UsersController@create');
  /*********
  * Workouts *
  *********/
  Route::post('/create_workout', 'WorkoutsController@create')->middleware('jwt.auth');

  Route::resource('workout', 'WorkoutsController');
});
