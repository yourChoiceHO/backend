<?php

namespace App\Http\Controllers;

use App\Election;
use App\User;
use App\Vote;
use Illuminate\Http\Request;

class ElectionController extends Controller
{
    public function index(){
        $election = DB::table('elections')->get();
        return $election;
    }

    public function show($id){
        return Election::findOrFail($id);
    }

    public function store(Request $request)
    {
        $array = array(
            'typ' => $request->input('typ'),
            'text' => $request->input('text'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'state' => $request->input('state')
        );
        Election::create($array);
    }

    public function show($id){
        return Election::findOrFail($id);
    }

    public function store(Request $request)
    {
        $array = array(
            'typ' => $request->input('typ'),
            'text' => $request->input('text'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'state' => $request->input('state')
        );
        Election::create($array);
    }

}
