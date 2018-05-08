<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class VoteController extends Controller
{
    public function index(){
        //return "Hi i#m election";
        $vote = DB::table('votes')->get();
        return $vote;//view('viewapp')->with('elections', $election);
    }
}
