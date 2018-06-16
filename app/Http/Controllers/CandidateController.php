<?php

namespace App\Http\Controllers;

use App\Candidate;
use App\Token;
use Illuminate\Http\Request;
use DB;
use Symfony\Component\Finder\Exception\AccessDeniedException;

class CandidateController extends Controller
{
    public function index(){
        //return "Hi i#m election";
        $candidate = DB::table('candidates')->get();
        return $candidate;//view('viewapp')->with('elections', $election);
    }

    public function show(Request $request, $id){
        $token = $request->input('token');
        $info = Token::getClientOrElectionId($token);
        if(is_array($info)){
            if(in_array($id, array_column($info, 'id_election'))){
                return Candidate::findOrFail($id);
            }
        }else{
            return Candidate::whereIdCandidate($id)->where('client_id', '=', $info)->first();
        }
        abort(403, 'Access Denied');
    }

    public function all(Request $request){
        $info = Token::getClientOrElectionId($request->input('token'));
        if(is_array($info)){
            $info = array_column($info, 'id_election');
            $result = null;
            foreach ($info as $id){
                $result[] = Candidate::whereElectionId($id);
            }
        }else{
            $result = Candidate::whereClientId($info);
        }
        return $result;
    }

    public function store(Request $request)
    {
        $userArray = Token::getUserOrVoter($request->input('token'));
        if($userArray['type'] == 'user') {
            $user = $userArray['object'];
            $array = array(
                'last_name' => $request->input('last_name'),
                'first_name' => $request->input('first_name'),
                'party_id' => $request->input('party_id'),
                'constituency' => $request->input('constituency'),
                'election_id' => $request->input('election_id'),
                'vote' => $request->input('vote'),
                'client_id' => $user->client_id
            );
            return Candidate::create($array);
        }
        abort(403, 'Access Denied');
    }

    public function update(Request $request, $id)
    {
        $userArray = Token::getUserOrVoter($request->input('token'));
        if($userArray['type'] == 'user') {
            $user = $userArray['object'];
            $newLastName = $request->input('last_name');
            $newFirstName = $request->input('first_name');
            $newPartyId = $request->input('party_id');
            $newConstituency = $request->input('constituency');
            $newElectionId = $request->input('election_id');
            $newVote = $request->input('vote');

            $candidate = Candidate::whereIdCandidate($id)->where('client_id', '=', $user->client_id)->first();
            if($candidate) {
                $candidate->last_name = $newLastName ? $newLastName : $candidate->last_name;
                $candidate->first_name = $newFirstName ? $newFirstName : $candidate->first_name;
                $candidate->party_id = $newPartyId ? $newPartyId : $candidate->party_id;
                $candidate->constituency = $newConstituency ? $newConstituency : $candidate->constituency;
                $candidate->election_id = $newElectionId ? $newElectionId : $candidate->election_id;
                $candidate->vote = $newVote ? $newVote : $candidate->vote;
                $candidate->save();
                return $candidate;
            }
        }
        abort(403, 'Access Denied');
    }

    public function destroy($id)
    {
        $candidate = Candidate::findOrFail($id);

        $destroyflag = $candidate->delete();
    }

}
