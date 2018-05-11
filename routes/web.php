<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
//Route::get('/election', 'ElectionController@index');

Route::get('/client', 'ClientController@index');

Route::post('/client', 'ClientController@index');

Route::get('/election', 'ElectionController@index');

Route::post('/election', 'ElectionController@index');

Route::get('/referendum', 'ReferendumController@index');

Route::post('/referendum', 'ReferendumController@index');

Route::get('/candidate', 'CandidateController@index');

//Route::get('/party', 'PartyController@index');

//Route::get('/vote', 'VoteController@index');

//Route::get('/voter', 'VoterController@index');

//Route::post('/election', 'ElectionController@index');

//Route::post('/candidate', 'CandidateController@index');

//Route::post('/party', 'PartyController@index');

//Route::post('/vote', 'VoteController@index');

//Route::post('/voter', 'VoterController@index');




