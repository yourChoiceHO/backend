<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    protected $table = 'candidates';
    protected $fillable = ['last_name', 'first_name', 'consituency', 'vote'];
    protected $guarded = ['id_candidate', 'party_id', 'election_id'];

    // DEFINE RELATIONSHIPS --------------------------------------------------

    //jeder Kandidat MUSS GENAU EINE election haben
    //Gegenstück zu $this->hasMany('App\Candidate') in election
    //erwartet, dass es in election eine id gibt,die in candidate dann als FK eingetragen wird
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function election() {
        return $this->belongsTo('App\Election');
    }

    //jeder Kandidat KANN KEINE ODER EINEN Partei haben
    public function parties() {
        return $this->belongsTo('App\Party');
    }

    //FUNCTIONS-------------------------------------------------------------

    public function getAllNames($candidates){
        foreach($candidates as $candidate){
            return $candidate->name;
        }
    }
}
