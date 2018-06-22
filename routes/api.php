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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::post('/login/voter', 'TokenController@authVoter');
Route::post('/login/user', 'TokenController@authUser');

Route::get('/party/{id}','PartyController@show');
Route::get('/party', 'PartyController@all');
Route::post('/party', 'PartyController@store');
Route::put('/party/{id}', 'PartyController@update');
Route::delete('/party/{id}', 'PartyController@destroy');

Route::get('/test', 'ElectionController@test');

Route::get('/election/{id}', 'ElectionController@show');
Route::get('/election', 'ElectionController@all');
Route::get('/election/{id}/evaluate', 'ElectionController@evaluate');
Route::post('/election/{id}/evaluate', 'ElectionController@evaluate');
Route::get('/election/{id}/parties', 'ElectionController@parties');
Route::get('/election/{id}/candidates', 'ElectionController@candidates');
Route::get('/election/{id}/referendums', 'ElectionController@referendums');
Route::get('/election/{id}/constituency', 'ElectionController@constituency');
Route::get('/election/{id}/constituency/{cid}', 'ElectionController@constituencyWithId');
Route::post('/election', 'ElectionController@store');
Route::post('/election/{id}/vote', 'ElectionController@vote');
Route::post('/election/{id}/addParties', 'ElectionController@addParties');
Route::post('/election/{id}/addCandidates', 'ElectionController@addCandidates');
Route::post('/election/{id}/addVoters', 'ElectionController@addVoters');
Route::post('/election/{id}/addReferendums', 'ElectionController@addReferendums');
Route::put('/election/{id}', 'ElectionController@update');
Route::delete('/election/{id}', 'ElectionController@destroy');
Route::delete('/election/{id}/removeParties/{cid}', 'ElectionController@removeParties');
Route::delete('/election/{id}/removeCandidates/{cid}', 'ElectionController@removeCandidates');
Route::delete('/election/{id}/removeVoters/{cid}', 'ElectionController@removeVoters');
Route::delete('/election/{id}/removeReferendums/{cid}', 'ElectionController@removeReferendums');
Route::delete('/election/{id}/constituency//{cid}', 'ElectionController@removeConstituency');


Route::get('/candidate/{id}', 'CandidateController@show');
Route::get('/candidate', 'CandidateController@all');
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
