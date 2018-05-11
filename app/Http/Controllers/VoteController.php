<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function index(){
        //return "Hi i#m election";
        $vote = DB::table('votes')->get();
        return $vote;//view('viewapp')->with('elections', $election);
    }
    public function show($id){
        return Vote::findOrFail($id);
    }
    public function store(Request $request)
    {
        $array = array(
            'voter_id' => $request->input('voter_id'),
            'election_id' => $request->input('election_id'),
            //'client_id' => $request->input('client_id'),
            'first_vote' => $request->input('first_vote'),
            'second_vote' => $request->input('second_vote'),
            'valid' => $request->input('valid')
        );
        return Vote::create($array);
    }
}
