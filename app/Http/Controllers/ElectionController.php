<?php

namespace App\Http\Controllers;

use App\Election;
use App\Http\Resources\Candidate;
use App\Token;
use App\User;
use App\Vote;
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
        $token = $request->get('token');
        $info = Token::getClientOrElectionId($token);
        if(is_array($info)){
            if(in_array($id, array_column($info, 'id_election'))){
                return Election::whereElectionId($id)->where('state', '=', Election::FREIGEGEBEN)->first();
            }
        }elseif ($info){
            return Election::whereIdElection($id)->where('client_id', '=', $info)->first();
        }
        abort(403, 'Access Denied');
    }

    public function all(Request $request){
        $info = Token::getClientOrElectionId($request->get('token'));
        if(is_array($info)){
            $info = array_column($info, 'id_election');
            $result = null;
            foreach ($info as $id){
                $election = Election::whereElectionId($id)->where('state', '=', Election::FREIGEGEBEN)->first();
                if($election){
                    $result[] = $election;
                }
            }
        }else{
            $result = Election::whereClientId($info);
        }
        return $result;
    }

    public function store(Request $request)
    {
        $userArray = Token::getUserOrVoter($request->get('token'));
        if($userArray['type'] == 'user') {
            $user = $userArray['object'];
            $array = array(
                //client doesn't exists yet'
                'client_id'=> $user->client_id,
                'typ' => $request->get('typ'),
                'text' => $request->get('text'),
                'start_date' => $request->get('start_date'),
                'end_date' => $request->get('end_date'),
                'state' => $request->get('state')
            );
            return Election::create($array);
        }
        abort(403, 'Access Denied');
    }

    public function update(Request $request, $id)
    {
        $userArray = Token::getUserOrVoter($request->get('token'));
        if($userArray['type'] == 'user') {
            $user = $userArray['object'];
            $newTyp = $request->get('typ');
            $newText = $request->get('text');
            $newStartDate = $request->get('start_date');
            $newEndDate = $request->get('end_date');
            $newState = $request->get('state');

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
        $userArray = Token::getUserOrVoter($request->get('token'));
        if($userArray['type'] == 'user') {
            $user = $userArray['object'];
            $election = Election::whereIdElection($id)->where('client_id', '=', $user->client_id)->first();
            if($election){
                $destroyflag = $election->delete();
                return $destroyflag;
            }
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
        return $election->parties();
    }

    public function candidates(Request $request, $id){
        $election = $this->show($request, $id);
        return $election->candidates();
    }

    public function referendums(Request $request, $id){
        $election = $this->show($request, $id);
        return $election->referendums();
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
