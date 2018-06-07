<?php

namespace App\Http\Controllers;

use App\Election;
use App\Http\Resources\Candidate;
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

    public function update(Request $request, $id)
    {
        $newClientId = $request->get('client_id');
        $newTyp = $request->get('typ');
        $newText = $request->get('text');
        $newStartDate = $request->get('start_date');
        $newEndDate = $request->get('end_date');
        $newState = $request->get('state');

        $election = Election::findOrFail($id);
        $election->client_id = $newClientId ? $newClientId : $election->client_id;
        $election->typ = $newTyp ? $newTyp : $election->typ;
        $election->text = $newText? $newText : $election->text;
        $election->start_date = $newStartDate ? $newStartDate : $election->start_date;
        $election->end_date = $newEndDate ? $newEndDate: $election->end_date;
        $election->state = $newState ? $newState: $election->state;

        $election->save();
    }

    public function destroy($id)
    {
        $election = Election::findOrFail($id);

        $destroyflag = $election->delete();
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
     * @param Request $request
     * @return mixed
     */
    public function vote($id, Request $request){
        $result = Election::findOrFail($id);
        return $result->vote($request);

    }

    public function addParties(Request $request, $id){
        $result = Election::findOrFail($id);
        return $result->addParties($request);
    }

    public function addCandidates(Request $request, $id){
        $result = Election::findOrFail($id);
        return $result->addCandidates($request);
    }

    public function addVoters(Request $request, $id){
        $result = Election::findOrFail($id);
        return $result->addVoters($request);
    }

}
