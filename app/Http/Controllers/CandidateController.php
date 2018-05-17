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
}
