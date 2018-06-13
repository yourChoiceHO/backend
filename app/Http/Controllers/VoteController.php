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
            'voter_id' => $request->get('voter_id'),
            'election_id' => $request->get('election_id'),
            //'client_id' => $request->get('client_id'),
            'first_vote' => $request->get('first_vote'),
            'second_vote' => $request->get('second_vote'),
            'valid' => $request->get('valid')
        );
        return Vote::create($array);
    }

    public function update(Request $request, $id)
    {
        $newElectionId = $request->get('election_id');
        $newClientId = $request->get('client_id');
        $newFirstVote = $request->get('first_vote');
        $newSecondVote = $request->get('second_vote');
        $newValid = $request->get('valid');

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
