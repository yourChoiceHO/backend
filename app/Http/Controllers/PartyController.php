<?php

namespace App\Http\Controllers;

use App\Party;
use App\Token;
use Illuminate\Http\Request;
use DB;
use Symfony\Component\Finder\Exception\AccessDeniedException;

class PartyController extends Controller
{
    public function index(){
        //return "Hi i#m election";
        $party = DB::table('parties')->get();
        return $party;//view('viewapp')->with('elections', $election);
    }

    public function show(Request $request, $id){
        $token = $request->input('token');
        $info = Token::getClientOrElectionId($token);
        if(is_array($info)){
            if(in_array($id, array_column($info, 'election_id'))){
                $party = Party::findOrFail($id);
                if($party){
                    return $party;
                }
            }
        }else{
            $party = Party::whereIdParty($id)->where('client_id', '=', $info)->first();
            if($party){
                return $party;
            }
        }
        abort(403, 'Access Denied');
    }

    public function all(Request $request){
        $info = Token::getClientOrElectionId($request->input('token'));
        if(is_array($info)){
            $info = array_column($info, 'election_id');
            $result = null;
            foreach ($info as $id){
                $result[] = Party::whereElectionId($id);
            }
        }else{
            $result = Party::whereClientId($info)->get();
        }
        return $result;
    }

    public function store(Request $request)
    {
        $userArray = Token::getUserOrVoter($request->input('token'));
        if($userArray['type'] == 'user') {
            $user = $userArray['object'];
            $array = array(
                'name' => $request->input('name'),
                'text' => $request->input('text'),
                'constituency' => $request->input('constituency'),
                'election_id' => $request->input('election_id'),
                'vote' => $request->input('vote'),
                'client_id' => $user->client_id
            );
            return Party::create($array);
        }
        abort(403, 'Access Denied');
    }

    public function update(Request $request, $id)
    {
        $userArray = Token::getUserOrVoter($request->input('token'));
        if($userArray['type'] == 'user') {
            $user = $userArray['object'];
            $newName = $request->input('name');
            $newText = $request->input('text');
            $newConstituency = $request->input('constituency');
            $newElectionId = $request->input('election_id');
            $newVote = $request->input('vote');

            $party = Party::whereIdParty($id)->where('client_id', '=', $user->client_id)->first();
            if($party) {
                $party->name = $newName ? $newName : $party->name;
                $party->text = $newText ? $newText : $party->text;
                $party->constituency = $newConstituency ? $newConstituency : $party->constituency;
                $party->election_id = $newElectionId ? $newElectionId : $party->election_id;
                $party->vote = $newVote ? $newVote : $party->vote;
                $party->save();
                return $party;
            }
        }
        abort(403, 'Access Denied');
    }

    public function destroy(Request $request, $id)
    {
        $userArray = Token::getUserOrVoter($request->input('token'));
        if($userArray['type'] == 'user') {
            $user = $userArray['object'];
            $party = Party::whereIdParty($id)->where('client_id', '=', $user->client_id)->first();
            if($party){
                $party->delete();
                return "true";
            }
        }
        abort(403, 'Access Denied');
    }

}
