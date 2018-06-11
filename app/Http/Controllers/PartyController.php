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
            return Party::whereIdParty($id)->where('client_id', '=', $info);
        }
        throw new AccessDeniedException("Zugriff verweigert", 403);
    }

    public function all(Request $request){

    }

    public function store(Request $request)
    {
        $userArray = Token::getUserOrVoter($request->get('token'));
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
        throw new AccessDeniedException("Zugriff verweigert", 403);
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

            $party = Party::whereIdParty($id)->where('client_id', '=', $user->client_id);
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
        throw new AccessDeniedException("Zugriff verweigert", 403);
    }

    public function destroy($id)
    {
        $party = Party::findOrFail($id);

        $destroyflag = $party->delete();
    }

}
