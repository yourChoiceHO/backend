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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/party/{id}','PartyController@show');
Route::post('/party', 'PartyController@store');

Route::get('/election/{id}', 'ElectionController@show');
Route::post('/election', 'ElectionController@store');
Route::get('/election/{id}/evaluate', 'ElectionController@evaluate');


Route::get('/candidate/{id}', 'CandidateController@show');
Route::post('/candidate', 'CandidateController@store');

Route::get('/vote/{id}', 'VoteController@show');
Route::post('/vote', 'VoteController@store');

Route::get('/voter/{id}', 'VoterController@show');
Route::post('/voter', 'VoterController@store');



Route::get('/client/{id}','ClientController@show');
Route::post('/client', 'ClientController@store');
Route::get('/referendum/{id}','ReferendumController@show');
Route::post('/referendum', 'ReferendumController@store');