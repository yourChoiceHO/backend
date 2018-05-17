<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use DB;
use App\Vote;

class Election extends Model
{
    const STATE_INAKTIVE = 0;
    const STATE_AKTIVE = 1;

    public $timestamps = true;

    protected $table = 'elections';
    // protected $fillable = ['typ'];// white list, wenn blacklist vorhanden, dann nicht erforderlich (laravel eloquent)
    protected $guarded = ['id_election', 'client_id'];//blacklist

    protected $fillable = ['client_id', 'typ', 'text', 'start_date', 'end_date', 'state'];
    protected $guarded = ['id_election'];
    protected $primaryKey = 'id_election';

    //Relationships


    //Election MUSS EINEN client enthalten//TODO oder keine??

    public function client() {
        return $this->hasOne('App\Client');
    }

    //Election KANN MEHRERE parties enthalten
    public function parties() {
        return $this->hasMany('App\Party');
    }

    //Election KANN MEHRERE candidates enthalten
    public function candidates() {
        return $this->hasMany('App\Candidate');
    }

    //Election KANN MEHRERE votes enthalten
    public function votes() {
        return $this->hasMany('App\Vote');
    }

    //Election KANN EIN referendum enthalten
    public function referendum() {
        return $this->hasOne('App\Vote');
    }


    //FUNCTIONS-------------------------------------------------------------

    //hab ich noch nicht wirklich verstanden...
    //kommt doch jetzt immer 1 zurück, und ist nicht mit state "verbunden"?
    public function isAktive(){
        return self::STATE_AKTIVE;
    }


    /**
     * bisher alles nur als Gesamtergebnis
     * @throws \Exception
     */
    public function evaluate(){

        //check its type
        if($this->typ == 'Europawahl'){
            //just candidate
            $result['Candidates']= $this->getVotesForCandidate();
            return $result;
        }
        else if($this->typ == 'Bundestagswahl'){
            //parties
            $result['Parties'] = $this->getVotesForParties();

            //candidates
            $result['Candidates']= $this->getVotesForCandidate();

            return $result;
        }
        else if($this->typ == 'Landtagswahl'){
            //parties
            $result['Parties'] = $this->getVotesForParties();

            //candidates
            $result['Candidates']= $this->getVotesForCandidate();

            return $result;
        }
        else if($this->typ == 'Bürgermeisterwahl'){
            //just candidate
            $result['Candidates']= $this->getVotesForCandidate();
            return $result;
        }
        else if($this->typ == 'Referendum'){
            //wird gemacht sobald Referedum verfügbar ist
        }
        else{
            throw new \Exception('No votes for this election');
        }
    }

    /**
     * Hilfsfunktion für evaluate($id)
     * @return array
     */
    public function getVotesForCandidate(){

        //get all candidates for this election
        $candidates = Candidate::where('election_id', '=', $this->id_election)->get();;
        //get the name and the votes for each candidate
        $result = array();
        foreach($candidates as $key => $candidate){
            $result[$key]['name'] = $candidate->last_name;
            $result[$key]['votes'] = $candidate->vote;
        }
        return $result;
    }


    /**
     * Hilfsfunktion für evaluate($id)
     * @return array
     */
    public function getVotesForParties(){
        //get all parties for this election
        $parties = Party::where('election_id', '=', $this->id_election)->get();
        //get the name and the votes of each party
        $result = array();
        foreach($parties as $key => $party){
            $result[$key]['name'] = $party->name;
            $result[$key]['vote'] = $party->vote;
        }
        return $result;
    }

    /**
     * @param Request $request
     * @return bool
     * @throws \Exception
     */
    public function vote(Request $request){
        $myVote = new Vote();
        if($request->valid == 0){
            $myVote->valid = 0;
            return true;
        }
        else{
            if($request->first_vote == 1){
                $myVote->first_vote = 1;
            }
            else{
                //Stimme soll gültig sein, aber enthält keine Erststimme
                throw new \InvalidArgumentException('vote is valid, but there is no valid first_vote');
            }
            if($request->second_vote == 1){
                $myVote->second_vote = 1;
            }
        }
        $myVote->save();
        return true;
    }
}