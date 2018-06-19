<?php

namespace App\Http\Controllers;

use App\Election;
use App\Http\Resources\Candidate;
use App\Party;
use App\Referendum;
use App\Token;
use App\User;
use App\Vote;
use App\Voter;
use Illuminate\Http\Request;
use DB;
use Symfony\Component\Finder\Exception\AccessDeniedException;

class ElectionController extends Controller
{
     //
    public function index(){
        //return "Hi i#m election";
        $election = DB::table('elections')->get();
        return $election;//view('viewapp')->with('elections', $election);
    }

    public function show(Request $request, $id){
        $token = $request->input('token');
        $info = Token::getClientOrElectionId($token);
        if(is_array($info)){
            if(in_array($id, array_column($info, 'election_id'))){
                return Election::whereIdElection($id)->where('state', '=', Election::FREIGEGEBEN)->first();
            }
        }elseif ($info){
            return Election::whereIdElection($id)->where('client_id', '=', $info)->first();
        }
        abort(403, 'Access Denied');
    }

    public function all(Request $request){
        $info = Token::getClientOrElectionId($request->input('token'));
        if(is_array($info)){
            $info = array_column($info, 'election_id');
            $result = null;
            foreach ($info as $id){
                $election = Election::whereIdElection($id)->whereIn('state', [Election::FREIGEGEBEN, Election::IM_GANGE])->first();
                $voters = Token::getVoters($request->input('token'));
                $votes = Vote::whereIn('voter_id', $voters)->get(array('election_id'))->toArray();

                if($election) {
                    if(!(in_array($election->getAttribute('id_election'), array_column($votes, 'election_id')))) {
                        if ($election->getAttribute('state') == Election::FREIGEGEBEN && strtotime($election->getAttribute('start_date')) <= time()) {
                            $election->setAttribute('state', Election::IM_GANGE);
                            $election->save();
                        }
                        if (($election->getAttribute('state') == Election::FREIGEGEBEN || $election->getAttribute('state') == Election::IM_GANGE) && strtotime($election->getAttribute('end_date')) <= time()) {
                            $election->setAttribute('state', Election::ABGESCHLOSSEN);
                            $election->save();
                            continue;

                        }
                        $result[] = $election;
                    }
                }
            }
        }else{
            $elections= Election::whereClientId($info)->get();
            foreach ($elections as $election){
                if($election->getAttribute('state') == Election::FREIGEGEBEN && strtotime($election->getAttribute('start_date')) <= time()){
                    $election->setAttribute('state', Election::IM_GANGE);
                    $election->save();
                }
                if(($election->getAttribute('state') == Election::FREIGEGEBEN || $election->getAttribute('state') == Election::IM_GANGE) && strtotime($election->getAttribute('end_date')) >= time()){
                    $election->setAttribute('state', Election::ABGESCHLOSSEN);
                    $election->save();

                }
                $result[] = $election;
            }
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
                'typ' => $request->input('typ'),
                'text' => $request->input('text'),
                'start_date' => $request->input('start_date'),
                'end_date' => $request->input('end_date'),
                'state' => $request->input('state')
            );
            return Election::create($array);
        }
        abort(403, 'Access Denied');
    }

    public function update(Request $request, $id)
    {
        $userArray = Token::getUserOrVoter($request->input('token'));
        if($userArray['type'] == 'user') {
            $user = $userArray['object'];
            $newTyp = $request->input('typ');
            $newText = $request->input('text');
            $newStartDate = $request->input('start_date');
            $newEndDate = $request->input('end_date');
            $newState = $request->input('state');

            $election = Election::whereIdElection($id)->where('client_id', '=', $user->client_id)->first();
            if($election) {
                $election->typ = $newTyp ? $newTyp : $election->typ;
                $election->text = $newText ? $newText : $election->text;
                $election->start_date = $newStartDate ? $newStartDate : $election->start_date;
                $election->end_date = $newEndDate ? $newEndDate : $election->end_date;
                $election->state = $newState ? $newState : $election->state;

                $election->save();
                return $election;
            }
        }
        abort(403, 'Access Denied');
    }

    public function destroy(Request $request, $id)
    {
        $userArray = Token::getUserOrVoter($request->input('token'));
        if($userArray['type'] == 'user') {
            $user = $userArray['object'];
            $election = Election::whereIdElection($id)->where('client_id', '=', $user->client_id)->first();
            if($election){
                $election->delete();
            }
            return "true";
        }
        abort(403, 'Access Denied');
    }

    public function test(){
        $voter = \DB::select('SELECT e.id_election FROM elections e, parties p, candidates c, referendums r WHERE (p.constituency = 1 AND e.id_election = p.election_id) OR (c.constituency = 1 AND e.id_election = c.election_id) OR (r.constituency = 1 AND e.id_election = r.election_id) GROUP BY e.id_election');
        $voter = array_column($voter, 'id_election');
        return $voter;
    }

    public function parties(Request $request, $id){
        $election = $this->show($request, $id);
        return Party::whereElectionId($election->id_election)->get();
    }

    public function candidates(Request $request, $id){
        $election = $this->show($request, $id);
        return \App\Candidate::whereElectionId($election->id_election)->get();
    }

    public function referendums(Request $request, $id){
        $election = $this->show($request, $id);
        return Referendum::whereElectionId($election->id_election)->get();
    }


    public function evaluate($id, Request $request){
        /**
         * @var Election $result
         */
        $userArray = Token::getUserOrVoter($request->input('token'));
        if($userArray['type'] == 'user') {
            $result = Election::findOrFail($id);
            return $result->evaluate();
        }
        abort(403, 'Access Denied');
    }

    /**
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function vote($id, Request $request){
        $result = Election::find($id);
        return $result->vote($request);

    }

    public function addParties(Request $request, $id){
        $result = Election::find($id);
        return $result->addParties($request);
    }

    public function addCandidates(Request $request, $id){
        $result = Election::find($id);
        return $result->addCandidates($request);
    }

    public function addVoters(Request $request, $id){
        $result = Election::find($id);
        return $result->addVoters($request);
    }

    public function addReferendums(Request $request, $id){
        $result = Election::find($id);
        return $result->addReferendums($request);
    }

}
