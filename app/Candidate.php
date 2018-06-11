<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Candidate
 *
 * @property-read \App\Election $election
 * @property-read \App\Party $parties
 * @mixin \Eloquent
 * @property int $id_candidate
 * @property string $last_name
 * @property string $first_name
 * @property int|null $party_id
 * @property int $constituency
 * @property int $election_id
 * @property int $vote
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Candidate whereConstituency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Candidate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Candidate whereElectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Candidate whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Candidate whereIdCandidate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Candidate whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Candidate wherePartyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Candidate whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Candidate whereVote($value)
 * @property int $client_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Candidate whereClientId($value)
 */
class Candidate extends Model
{
    protected $table = 'candidates';
    protected $fillable = ['last_name', 'first_name', 'party_id', 'constituency', 'election_id', 'vote', 'client_id'];
    protected $guarded = ['id_candidate'];
    protected $primaryKey = 'id_candidate';

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
