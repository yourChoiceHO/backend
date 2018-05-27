<?php

namespace App\Http\Controllers;

use App\Candidate;
use Illuminate\Http\Request;
use DB;

class CandidateController extends Controller
{
    public function index(){
        //return "Hi i#m election";
        $candidate = DB::table('candidates')->get();
        return $candidate;//view('viewapp')->with('elections', $election);
    }

    public function show($id){
        return Candidate::findOrFail($id);
    }

    public function store(Request $request)
    {
        $array = array(
            'last_name' => $request->input('last_name'),
            'first_name' => $request->input('first_name'),
            'party_id' => $request->input('party_id'),
            'constituency' => $request->input('constituency'),
            'election_id' => $request->input('election_id'),
            'vote' => $request->input('vote')
        );
        return Candidate::create($array);
    }

    public function update(Request $request, $id)
    {
        $newLastName = $request->get('last_name');
        $newFirstName = $request->get('first_name');
        $newPartyId = $request->get('party_id');
        $newConstituency = $request->get('constituency');
        $newElectionId = $request->get('election_id');
        $newVote = $request->get('vote');

        $candidate = Candidate::findOrFail($id);
        $candidate->last_name = $newLastName ? $newLastName : $candidate->last_name;
        $candidate->first_name = $newFirstName ? $newFirstName : $candidate->first_name;
        $candidate->party_id = $newPartyId ? $newPartyId : $candidate->party_id;
        $candidate->constituency = $newConstituency ? $newConstituency : $candidate->constituency;
        $candidate->election_id = $newElectionId ? $newElectionId : $candidate->election_id;
        $candidate->vote = $newVote ? $newVote: $candidate->vote;

        $candidate->save();
    }

    public function destroy($id)
    {
        $candidate = Candidate::findOrFail($id);

        $destroyflag = $candidate->delete();
    }

}
