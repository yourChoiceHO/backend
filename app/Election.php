<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use DB;

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
     * @param $id
     * @throws \Exception
     */
    public function evaluate($id){

        //find the election with the given id
        $electionToEvaluate = Election::findOrFail($id);
       // dd($electionToEvaluate);

        //check its type
        if($electionToEvaluate->typ == 'Europawahl'){
            //just candidate
            return Election::getVotesForCandidate($id);
        }
        else if($electionToEvaluate->typ == 'Bundestagswahl'){
            //dd('bundestagswahl');
            //parties
            $resultPartiesBTW = Election::getVotesForParties($id);

            //candidates
            $resultCandidatesBTW = Election::getVotesForCandidate($id);

            //$resultCandidateAndParty = $resultPartiesBTW->concat($resultCandidatesBTW);
            //dd($resultCandidateAndParty);
            //return $resultCandidateAndParty;
            return $resultPartiesBTW->concat($resultCandidatesBTW);
        }
        else if($electionToEvaluate->typ == 'Landtagswahl'){
            //parties
            $resultPartiesLTW = $this->getVotesForParties($id);

            //candidates
            $resultCandidatesLTW = Election::getVotesForCandidate($id);

            return $resultPartiesLTW->concat($resultCandidatesLTW);
        }
        else if($electionToEvaluate->typ == 'Bürgermeisterwahl'){
            //just candidate
            return Election::getVotesForCandidate($id);
        }
        else if($electionToEvaluate->typ == 'Referendum'){
            //wird gemacht sobald Referedum verfügbar ist
        }
        else{
            throw new \Exception('No votes for this election');
        }
    }

    /**
     * Hilfsfunktion für evaluate($id)
     * @param $id
     * @return \Illuminate\Support\Collection
     */
    public function getVotesForCandidate($id){
        $allResults = new Collection();
        $collection = collect(['CandidateOrParty','name', 'votes']);
        //get all candidates for this election
        $candidates = Candidate::where('election_id', $id)->get();
        //dd($candidates);
        //get the name and the votes for each candidate
        foreach($candidates as $candidate){
            $allResults = $collection->combine(['Candidate', $candidate->last_name, $candidate->vote]);
        }
        //dd($allResults);
        return $allResults;
    }

    /**
     * Hilfsfunktion für evaluate($id)
     * @param $id
     * @return \Illuminate\Support\Collection
     */
    public function getVotesForParties($id){
        $allResults = new Collection();
        $collection = collect(['CandidateOrParty','name', 'votes']);
        //get all parties for this election
        $parties = Party::where('election_id', $id)->get();
        //dd($parties);
        //get the name and the votes of each party
        foreach($parties as $party){
            $allResults = $collection->combine(['Party', $party->name, $party->vote]);
        }
        //dd($allResults);
        return $allResults;
    }
}