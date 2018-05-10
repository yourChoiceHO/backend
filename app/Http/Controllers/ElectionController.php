<?php

namespace App\Http\Controllers;

use App\Election;
use App\User;
use App\Vote;
use Illuminate\Http\Request;
use DB;

class ElectionController extends Controller
{
     //
    public function index(){
        //return "Hi i#m election";
        $election = DB::table('elections')->get();
        return $election;//view('viewapp')->with('elections', $election);
    }
}
