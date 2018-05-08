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
}
