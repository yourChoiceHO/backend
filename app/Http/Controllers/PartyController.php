<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class PartyController extends Controller
{
    public function index(){
        //return "Hi i#m election";
        $party = DB::table('parties')->get();
        return $party;//view('viewapp')->with('elections', $election);
    }
}
