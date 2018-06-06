<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use DB;
use App\Vote;
use Illuminate\Http\Request;

/**
 * App\Election
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Candidate[] $candidates
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Party[] $parties
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Vote[] $votes
 * @mixin \Eloquent
 * @property int $id_election
 * @property int|null $client_id
 * @property string $typ
 * @property string|null $text
 * @property string $start_date
 * @property string $end_date
 * @property int $state
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Election whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Election whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Election whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Election whereIdElection($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Election whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Election whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Election whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Election whereTyp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Election whereUpdatedAt($value)
 */
class Election extends Model
{
    const STATE_INAKTIVE = 0;
    const STATE_AKTIVE = 1;

    const Europawahl = "Europawahl";
    const Bundestagswahl = "Bundestagswahl";
    const Landtagswahl = "Landtagswahl";
    const Buergermeisterwahl = "Buergermeisterwahl";
    const Referendum = "Referendum";
    const Kommunalwahl = "Kommunalwahl";
    const LandtagswahlBW = "LandtagswahlBW";
    const LandtagswahlSL = "LandtagswahlSL";

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

    private function getVotesForParties(){
        $result['votes_parties'] = Party::whereElectionId($this->id_election)->groupBy('election_id')->sum('vote');
        $result['parties'] = Party::whereElectionId($this->id_election)->groupBy("name")->selectRaw('*, sum(vote) as vote_number')->get();
        foreach ($result['parties'] as $party){
            $party['vote_percent'] = number_format((($party->getAttribute('vote_number') / $result['votes_parties']) * 100), 2);
        }
        return $result;
    }


    private function getVotesForCandidates(){
        $candidates = Candidate::whereElectionId($this->id_election)->orderBy("constituency")->get();
        $result['candidates'] = array();
        foreach ($candidates as $candidate){
            $constituency = $candidate->getAttribute('constituency');
            $max_vote = Candidate::whereElectionId($this->id_election)->where('constituency', '=', $constituency)->sum('vote');
            $candidate['vote_percent'] = number_format( (($candidate->getAttribute('vote') / $max_vote )* 100), 2);
            if(key_exists($constituency,$result['candidates'])){
                if($candidate->getAttribute('vote') > $result['candidates'][$constituency]->getAttribute('vote')){
                    $result['candidates'][$constituency] = $candidate;
                }
            }else{
                $result['candidates'][$constituency] = $candidate;
            }
        }
        return $result;
    }
    private function getVotesForConstituency($withParty = true, $withCandidate = true){
        $result = null;
        if($withCandidate) {
            $candidates = Candidate::whereElectionId($this->id_election)->orderBy("constituency")->get();
            foreach ($candidates as $candidate) {
                $constituency = $candidate->getAttribute('constituency');
                $max_vote = Candidate::whereElectionId($this->id_election)->where('constituency', '=', $constituency)->sum('vote');
                $candidate['vote_percent'] = number_format((($candidate->getAttribute('vote') / $max_vote) * 100), 2);
                $result[$constituency]['candidate'][] = $candidate;
            }
        }
        if($withParty) {
            $parties = Party::whereElectionId($this->id_election)->orderBy("constituency")->get();
            foreach ($parties as $party) {
                $constituency = $party->getAttribute('constituency');
                $max_vote = Party::whereElectionId($this->id_election)->where('constituency', '=', $constituency)->sum('vote');
                $party['vote_percent'] = number_format((($party->getAttribute('vote') / $max_vote) * 100), 2);
                $result[$constituency]['parties'][] = $party;
            }
        }
        return $result;
    }

    public function evaluate(){
        $result = null;
        if($this->typ == self::Bundestagswahl || $this->typ == self::Landtagswahl){
            $result['general'] = $this->getVotesForParties();
            $result['general'] = $this->getVotesForCandidates();
            $result['constituency'] = $this->getVotesForConstituency();
        } elseif($this->typ == self::Buergermeisterwahl|| $this->typ == self::Europawahl || $this->typ == self::LandtagswahlBW){
            $result['general'] = $this->getVotesForConstituency(false);
        } elseif ($this->typ == self::LandtagswahlSL){
            $result['general'] = $this->getVotesForConstituency(true, false);
        } elseif ($this->typ == self::Referendum) {
            $max_vote = Referendum::whereElectionId($this->id_election)->selectRaw("(yes + no) as votes")->get()->get(0)->getAttribute('votes');
            $referendum = Referendum::whereElectionId($this->id_election)->get()->get(0);
            $result['general']['text'] = $referendum->getAttribute("text");
            $result['general']['yes']['vote_number'] = $referendum->getAttribute("yes");
            $result['general']['yes']['vote_percent'] = number_format((($referendum->getAttribute("yes") / $max_vote) * 100), 2);
            $result['general']['no']['vote_number'] = $referendum->getAttribute("no");
            $result['general']['no']['vote_percent'] = number_format((($referendum->getAttribute("no") / $max_vote) * 100), 2);
        }
        return $result;
    }

    /**
     * @param Request $request
     * @return bool
     * @throws \Exception
     */
    public function vote(Request $request){
        //TODO Wie komme ich an die election_id (nicht im request enthalten) oder bereits wg route (s. api.php) selektiert? Oder Route::pattern(???)
        //TODO Inhalt von first_vote und second_vote? Nur 1 und 0? Wie erfolgt Zuordnung zu Kandidaten und Partei?
        //TODO Unterteilung nach Wahltyp um zu wissen, ob nur eine Stimme z.B. nur Kandidaten erforderlich ist
        $myVote = new Vote();

        if($this->typ == self::Kommunalwahl) {
            $candidates = $request->get('candidates');
            foreach ($candidates as $candidate) {
                $candidate_edit = Candidate::whereIdCandidate($candidate['id_candidate']);
                $candidate_edit->setAttribute("vote", ($candidate_edit->getAttribute("vote") + 1));
                $candidate_edit->save();
                $party = Party::whereIdParty($candidate['party_id']);
                $party->setAttribute("vote", $party->getAttribute("vote") + 1);
            }
        }


        $id_election = $this->id_election;
        $voter_id = $request->get('voter_id');
        $voter = Voter::where('election_id', '=', $id_election)->andWhere('voter_id', '=', $voter_id);
        if(!$voter){
                $valid = $request->get('valid');
                $first_vote = $request->get('first_vote');
                $second_vote= $request->get('second_vote');
                if($valid && $first_vote && $second_vote){
                    if($this->typ == "Bundestagswahl") {
                        $party_id = $request->get('party_id');
                        $party = Party::where('id_party', '=', $party_id);
                        $party->vote++;
                        $party->save();
                        $candidate_id = $request->get("candidate_id");
                        $candidate = Candidate::where("id_candidate", '=', $candidate_id);
                        $candidate->vote++;
                        $candidate->save();
                      }
                    $vote = new Vote();
                    $vote->election_id = $id_election;
                    $vote->voter_id = $voter_id;
                    $vote->first_vote = true;
                    $vote->second_vote = true;
                    $vote->valid = true;
                    $vote->save();
                }elseif($first_vote && $second_vote){
                    $vote = new Vote();
                    $vote->election_id = $id_election;
                    $vote->voter_id = $voter_id;
                    $vote->first_vote = true;
                    $vote->second_vote = true;
                    $vote->valid = false;
                    $vote->save();
                }else{
                    //throw new Exception
                }

                $this->voteFor(null, null, "yes");
                $this->voteFor($candidate_id);


        }







        //vote not valid
        if($request->valid == 0){
            $myVote->valid = 0;
            return true;
        }
        //vote valid
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

               // $this->updateVotesForParties($request);
            }

            else{
                //Stimme soll gültig sein, aber enthält keine Zweitstimme
                throw new \InvalidArgumentException('vote is valid, but there is no valid second_vote');
            }
        }
        $myVote->save();
        return true;
    }

    //TODO Update Wahlstimme wie?
    //TODO Bezeichnung election_id oder id_election
    //TODO Welchen Übergabeparameter $request oder $myVote? Welchen Übergabeparameter bei update
    //TODO same for candidate
    public function updateVotesForParties(Request $request){
        //get party
        $party=Party::where('election_id', '=', $this->id_election, 'AND', 'id_party', '=', $this->id_party)->get();
        $party->vote++;
        $this->update($party);
    }

    public function updateVotesForCandidates(Request $request){
        //get party
        $candidate=Candidate::where('election_id', '=', $this->id_election, 'AND', 'id_candidate', '=', $this->id_candidate)->get();
        $candidate->vote++;
        $this->update($candidate);
    }

    private function voteFor($candidate_id = null, $party_id = null, $referendum = null){

    }


    public function addParties(Request $request){
        $files = $request->file('upload');
            $allParties[] = array();
            $csv = array_map('str_getcsv', file($files));
            array_walk($csv, function (&$a) use ($csv) {
               $a = array_combine($csv[0], $a);
            });
            array_shift($csv);

            foreach ($csv as $parties){
                $party = array(
                    'name' => $parties['name'],
                    'text' => $parties['text'],
                    'constituency' => $parties['constituency'],
                    'election_id' => $this->id_election,
                    'vote' => 0
                );
                $partyCreated = Party::create($party);
                array_push($allParties, $partyCreated);
            }
        array_shift($allParties);

        return $allParties;
    }

    public function addCandidates(Request $request){
        $files = $request->file('upload');

        $allCandidates[] = array();
            $csv = array_map('str_getcsv', file($files));
            array_walk($csv, function (&$a) use ($csv) {
                $a = array_combine($csv[0], $a);
            });
            array_shift($csv);
            foreach ($csv as $candidates){
                $party = Party::whereElectionId($this->id_election)->where('name', $candidates['party'])->get()->get(0);
                $candidate = array(
                    'last_name' => $candidates['last_name'],
                    'first_name' => $candidates['first_name'],
                    'party_id' => $party->getAttribute('id_party'),
                    'constituency' => $candidates['constituency'],
                    'election_id' => $this->id_election,
                    'vote' => 0
                );
                $candidateCreated = Candidate::create($candidate);
                array_push($allCandidates, $candidateCreated);
            }
        array_shift($allCandidates);
        return $allCandidates;
    }

    public function addVoters(Request $request)
    {
        $files = $request->file('upload');

        $allVoters[] = array();

            $csv = array_map('str_getcsv', file($files));
            array_walk($csv, function (&$a) use ($csv) {
                $a = array_combine($csv[0], $a);
            });
            array_shift($csv);
            foreach ($csv as $voters){
            $voter = array(
                'last_name' => $voters['last_name'],
                'first_name' => $voters['first_name'],
                'hash' => $voters['hash'],
                'constituency' => $voters['constituency']
            );
            $voterCreated = Voter::create($voter);
            array_push($allVoters, $voterCreated);
        }
        array_shift($allVoters);

        return $allVoters;
    }

}