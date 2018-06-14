<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use DB;
use App\Voter;

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
    public function all(Request $request){
        $info = Token::getClientOrElectionId($request->input('token'));
        if(is_array($info)){
            abort(403, 'Access Denied');
        }else{
            $result = Voter::whereClientId($info);
        }
        return $result;
    }

    public function store(Request $request)
    {
        $userArray = Token::getUserOrVoter($request->input('token'));
        if($userArray['type'] == 'user') {
            $user = $userArray['object'];
            $array = array(
                //client doesn't exists yet'
                'client_id'=> $user->client_id,
                'last_name' => $request->input('last_name'),
                'first_name' => $request->input('first_name'),
                'hash' => $request->input('hash'),
                'constituency' => $request->input('constituency')
            );
            return Voter::create($array);
        }
        abort(403, 'Access Denied');

    }

    public function update(Request $request, $id)
    {
        $newLastName = $request->input('last_name');
        $newFirstName = $request->input('first_name');
        $newHash = $request->input('hash');
        $newConstituency = $request->input('constituency');

        $voter = Voter::findOrFail($id);
        $voter->last_name = $newLastName ? $newLastName : $voter->last_name;
        $voter->first_name = $newFirstName ? $newFirstName : $voter->first_name;
        $voter->hash = $newHash ? $newHash : $voter->party_id;
        $voter->constituency = $newConstituency ? $newConstituency : $voter->constituency;

        $voter->save();
    }

    public function destroy($id)
    {
        $voter = Voter::findOrFail($id);

        $destroyflag = $voter->delete();
    }
}
