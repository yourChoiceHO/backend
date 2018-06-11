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
        $token = $request->get('token');
        $info = Token::getClientOrElectionId($token);
        if(is_array($info)){
            if(in_array($id, array_column($info, 'id_election'))){
                return Candidate::findOrFail($id);
            }
        }else{
            return Candidate::whereIdCandidate($id)->where('client_id', '=', $info);
        }
        throw new AccessDeniedException("Zugriff verweigert", 403);
    }

    public function store(Request $request)
    {
        $userArray = Token::getUserOrVoter($request->get('token'));
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
        throw new AccessDeniedException("Zugriff verweigert", 403);
    }

    public function update(Request $request, $id)
    {
        $userArray = Token::getUserOrVoter($request->get('token'));
        if($userArray['type'] == 'user') {
            $user = $userArray['object'];
            $newLastName = $request->get('last_name');
            $newFirstName = $request->get('first_name');
            $newPartyId = $request->get('party_id');
            $newConstituency = $request->get('constituency');
            $newElectionId = $request->get('election_id');
            $newVote = $request->get('vote');

            $candidate = Candidate::whereIdCandidate($id)->where('client_id', '=', $user->client_id);
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
        throw new AccessDeniedException("Zugriff verweigert", 403);
    }

    public function destroy($id)
    {
        $candidate = Candidate::findOrFail($id);

        $destroyflag = $candidate->delete();
    }

}
