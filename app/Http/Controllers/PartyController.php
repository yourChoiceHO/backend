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
            'vote' => $request->input('state')
        );
        return Party::create($array);
    }
}
