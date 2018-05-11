<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class VoterController extends Controller
{
    public function index(){
        //return "Hi i#m election";
        $voter = DB::table('voters')->get();
        return $voter;//view('viewapp')->with('elections', $election);
    }

    public function show($id){
        return Voter::findOrFail($id);
    }

    public function store(Request $request)
    {
        $array = array(
            'last_name' => $request->input('last_name'),
            'first_name' => $request->input('first_name'),
            'hash' => $request->input('hash'),
            'constituency' => $request->input('constituency')
        );
        return Voter::create($array);
    }
}
