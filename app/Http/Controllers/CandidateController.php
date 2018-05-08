<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class CandidateController extends Controller
{
    public function index(){
        //return "Hi i#m election";
        $candidate = DB::table('candidates')->get();
        return $candidate;//view('viewapp')->with('elections', $election);
    }
}
