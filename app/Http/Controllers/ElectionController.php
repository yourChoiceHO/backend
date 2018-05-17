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

    public function show($id){
        return Election::findOrFail($id);
    }

    public function store(Request $request)
    {
        $array = array(
            //client doesn't exists yet'
            //'client_id'=> $request->input('client_id'),
            'typ' => $request->input('typ'),
            'text' => $request->input('text'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'state' => $request->input('state')
        );
        return Election::create($array);
    }


    /**
     * @param $id
     * @return Election|array
     * @throws \Exception
     */
    public function evaluate($id){
        /**
         * @var Election $result
         */
        $result = Election::findOrFail($id);
        return $result->evaluate();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function vote($id, Request $request){
        $result = Election::findOrFail($id);
        return $result->vote($request);

    }


    }
