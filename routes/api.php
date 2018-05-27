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
Route::put('/party/{id}', 'PartyController@update');
Route::delete('/party/{id}', 'PartyController@destroy');

Route::get('/election/{id}', 'ElectionController@show');
Route::post('/election', 'ElectionController@store');
Route::post('/election/{id}/evaluate', 'ElectionController@evaluate');
Route::post('/election/{id}/vote)', 'ElectionController@vote');
Route::put('/election/{id}', 'ElectionController@update');
Route::delete('/election/{id}', 'ElectionController@destroy');

Route::get('/candidate/{id}', 'CandidateController@show');
Route::post('/candidate', 'CandidateController@store');
Route::put('/candidate/{id}', 'CandidateController@update');
Route::delete('/candidate/{id}', 'CandidateController@destroy');

Route::get('/vote/{id}', 'VoteController@show');
Route::post('/vote', 'VoteController@store');
Route::put('/vote/{id}', 'VoteController@update');
Route::delete('/vote/{id}', 'VoteController@destroy');

Route::get('/voter/{id}', 'VoterController@show');
Route::post('/voter', 'VoterController@store');
Route::put('/voter/{id}', 'VoterController@update');
Route::delete('/voter/{id}', 'VoterController@destroy');

Route::get('/client/{id}','ClientController@show');
Route::post('/client', 'ClientController@store');
Route::put('/client/{id}', 'ClientController@update');
Route::delete('/client/{id}', 'ClientController@destroy');

Route::get('/referendum/{id}','ReferendumController@show');
Route::post('/referendum', 'ReferendumController@store');
Route::put('/referendum/{id}', 'ReferendumController@update');
Route::delete('/referendum/{id}', 'ReferendumController@destroy');
