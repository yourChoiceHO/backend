<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Party
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Candidate[] $candidates
 * @property-read \App\Election $election
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Party partyGTFive()
 * @mixin \Eloquent
 * @property int $id_party
 * @property string $name
 * @property string|null $text
 * @property int $constituency
 * @property int $election_id
 * @property int $vote
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Party whereConstituency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Party whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Party whereElectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Party whereIdParty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Party whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Party whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Party whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Party whereVote($value)
 * @property int $client_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Party whereClientId($value)
 */
class Party extends Model
{
    //const something= 5;
    //es werden keine timestamps benötigt
    //public $timestamps = false;

    //Abbildung DB-Entität <-> Klasse
    //Klasse parties nutzt Entität Party
    //@var string  -> was bedeutet das, bzw. für was ist es da?
    protected $table = 'parties';

    //Spalten auf die zugegriffen werden darf
    protected $fillable = ['name', 'text', 'constituency', 'election_id','vote', 'client_id'];
    //election_id und id nicht, sollen generiert werden beim erstellen
    //und nur automatisch gesetzt werden können
    protected $guarded = ['id_party'];
    protected $primaryKey = 'id_party';



    // DEFINE RELATIONSHIPS --------------------------------------------------

        //jede Partei MUSS GENAU EINE election haben
        //Gegenstück zu $this->hasMany('App\Party') in election
        //erwartet, dass es in election eine id gibt,die in party dann als FK eingetragen wird
        /**
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function election() {
            return $this->belongsTo('App\Election');
        }

    //jede Partei KANN KEINEN, EINEN ODER MEHRERE(???, laut DB-Modell nicht) Kandidaten haben
    public function candidates() {
        return $this->hasMany('App\Candidate');
    }

    //FUNCTIONS-------------------------------------------------------------

    /*
    public function setElection(Election election) {
        $this.election_id = election.election_id;
    }
    */

    //Wip
    //soll eigentlich die stärkste Parei zurückgeben, aber mit was vergleichen
    public function scopePartyGTFive($query){
        return $query->where('vote','>','5');
    }

    //
    public function getAllNames($parties){
        foreach($parties as $party){
            return $party->name;
        }
    }
}
