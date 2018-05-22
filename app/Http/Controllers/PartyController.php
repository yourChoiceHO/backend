<?php

namespace App\Http\Controllers;

use App\Party;
use Illuminate\Http\Request;
use DB;

class PartyController extends Controller
{
    public function index(){
        //return "Hi i#m election";
        $party = DB::table('parties')->get();
        return $party;//view('viewapp')->with('elections', $election);
    }

    public function show($id){
        return Party::findOrFail($id);
    }

    public function store(Request $request)
    {
        $array = array(
            'name' => $request->input('name'),
            'text' => $request->input('text'),
            'constituency' => $request->input('constituency'),
            'election_id' => $request->input('election_id'),
            'vote' => $request->input('vote')
        );
        return Party::create($array);
    }

    public function update(Request $request, $id)
    {
        $newName = $request->get('name');
        $newText = $request->get('text');
        $newConstituency = $request->get('constituency');
        $newElectionId = $request->get('election_id');
        $newVote = $request->get('vote');

        $party = Party::findOrFail($id);
        $party->name = $newName ? $newName : $party->name;
        $party->text = $newText ? $newText : $party->text;
        $party->constituency = $newConstituency ? $newConstituency : $party->constituency;
        $party->election_id = $newElectionId ? $newElectionId : $party->election_id;
        $party->vote = $newVote ? $newVote: $party->vote;

        $party->save();
    }
}
