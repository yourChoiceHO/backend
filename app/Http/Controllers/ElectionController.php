<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ElectionController extends Controller
{
    public function index(){
        $election = DB::table('elections')->get();
        return $election;
    }
}
