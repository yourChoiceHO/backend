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

    protected $fillable = ['client_id', 'typ', 'text', 'start_date', 'end_date', 'state'];
    protected $guarded = ['id_election'];
    protected $primaryKey = 'id_election';


    // DEFINE RELATIONSHIPS --------------------------------------------------

    //Eine Wahl MUSS GENAU EINEN client haben
    /*
    public function client() {
        return $this->belongsTo('App\Client');
    }
    */

    //Eine election KANN MEHRERE parties haben
    //trägt meine id als FK in party ein
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function parties() {
        return $this->hasMany('App\Party');
    }

    //Eine election KANN GENAU EINEN candidates haben
    //trägt meine id als FK in candidate ein
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function candidates() {
        return $this->hasMany('App\Candidate');
    }

    //Eine election KANN MEHRERE votes haben
    //trägt meine id als FK in vote ein
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function votes() {
        return $this->hasMany('App\Vote');
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

        //find the election with the given id
       // dd($electionToEvaluate);

        //check its type
        if($this->typ == 'Europawahl'){
            //just candidate
            $result['Candidates']= $this->getVotesForCandidate();
            return $result;
        }
        else if($this->typ == 'Bundestagswahl'){
            //dd('bundestagswahl');
            //parties
            //parties
            $result['Parties'] = $this->getVotesForParties();

            //candidates
            $result['Candidates']= $this->getVotesForCandidate();

            //$resultCandidateAndParty = $resultPartiesBTW->concat($resultCandidatesBTW);
            //dd($resultCandidateAndParty);
            //return $resultCandidateAndParty;
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
        $candidates = Candidate::where('election_id', '=', $this->id_election)->get();
        //dd($candidates);
        //get the name and the votes for each candidate
        $result = array();
        foreach($candidates as $key => $candidate){
            $result[$key]['name'] = $candidate->last_name;
            $result[$key]['votes'] = $candidate->vote;
        }
        //dd($allResults);
        return $result;
    }

    /**
     * Hilfsfunktion für evaluate($id)
     * @return array
     */
    public function getVotesForParties(){
        //get all parties for this election
        $parties = Party::where('election_id', '=', $this->id_election)->get();
        //dd($parties);
        //get the name and the votes of each party
        $result = array();
        foreach($parties as $key => $party){
            $result[$key]['name'] = $party->name;
            $result[$key]['vote'] = $party->vote;
        }
        //dd($allResults);
        return $result;
    }
}