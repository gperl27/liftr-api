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

  // Route::get('/', function(){
  //   return 'Test me';
  // })->middleware('jwt.auth');
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
  Route::get('/current_workout/{date}', 'WorkoutsController@current_workout')->middleware('jwt.auth');
  Route::get('/workouts', 'WorkoutsController@index')->middleware('jwt.auth');
  Route::post('/workout/update_name', 'WorkoutsController@update_name')->middleware('jwt.auth');
  Route::post('/workout/create', 'WorkoutsController@create')->middleware('jwt.auth');
  Route::post('/workout/destroy', 'WorkoutsController@destroy')->middleware('jwt.auth');
  /*************
   * Exercises *
   *************/
   Route::get('/exercises' , 'ExercisesController@index');
   Route::get('/exercise/{name}' , 'ExercisesController@show')->middleware('jwt.auth');
   Route::post('/exercise/create', 'ExercisesController@create')->middleware('jwt.auth');
   Route::post('/exercise/{exercise_id}/update', 'ExercisesController@update')->middleware('jwt.auth');
   Route::post('/exercise/destroy', 'ExercisesController@destroy')->middleware('jwt.auth');


});
