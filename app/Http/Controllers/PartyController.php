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
        $token = $request->get('token');
        $info = Token::getClientOrElectionId($token);
        if(is_array($info)){
            if(in_array($id, array_column($info, 'id_election'))){
                return Party::findOrFail($id);
            }
        }else{
            return Party::whereIdParty($id)->where('client_id', '=', $info)->first();
        }
        abort(403, 'Access Denied');
    }

    public function all(Request $request){
        $info = Token::getClientOrElectionId($request->get('token'));
        if(is_array($info)){
            $info = array_column($info, 'id_election');
            $result = null;
            foreach ($info as $id){
                $result[] = Party::whereElectionId($id);
            }
        }else{
            $result = Party::whereClientId($info);
        }
        return $result;
    }

    public function store(Request $request)
    {
        $userArray = Token::getUserOrVoter($request->get('token'));
        if($userArray['type'] == 'user') {
            $user = $userArray['object'];
            $array = array(
                'name' => $request->get('name'),
                'text' => $request->get('text'),
                'constituency' => $request->get('constituency'),
                'election_id' => $request->get('election_id'),
                'vote' => $request->get('vote'),
                'client_id' => $user->client_id
            );
            return Party::create($array);
        }
        abort(403, 'Access Denied');
    }

    public function update(Request $request, $id)
    {
        $userArray = Token::getUserOrVoter($request->get('token'));
        if($userArray['type'] == 'user') {
            $user = $userArray['object'];
            $newName = $request->get('name');
            $newText = $request->get('text');
            $newConstituency = $request->get('constituency');
            $newElectionId = $request->get('election_id');
            $newVote = $request->get('vote');

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

    public function destroy($id)
    {
        $party = Party::findOrFail($id);

        $destroyflag = $party->delete();
    }

}
