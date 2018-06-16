<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vote;

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

    public function update(Request $request, $id)
    {
        $newElectionId = $request->input('election_id');
        $newClientId = $request->input('client_id');
        $newFirstVote = $request->input('first_vote');
        $newSecondVote = $request->input('second_vote');
        $newValid = $request->input('valid');

        $vote = Vote::findOrFail($id);
        $vote->election_id = $newElectionId ? $newElectionId : $vote->election_id;
        $vote->client_id = $newClientId ? $newClientId : $vote->client_id;
        $vote->first_vote = $newFirstVote ? $newFirstVote : $vote->first_vote;
        $vote->second_vote = $newSecondVote ? $newSecondVote : $vote->second_vote;
        $vote->valid = $newValid ? $newValid : $vote->valid;

        $vote->save();
    }

    public function destroy($id)
    {
        $vote = Vote::findOrFail($id);

        $destroyflag = $vote->delete();
    }

}
