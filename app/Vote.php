<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Vote
 *
 * @property-read \App\Election $election
 * @property-read \App\Voter $voter
 * @mixin \Eloquent
 * @property int $id_vote
 * @property int $voter_id
 * @property int $election_id
 * @property int $first_vote
 * @property int|null $second_vote
 * @property int $valid
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Vote whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Vote whereElectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Vote whereFirstVote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Vote whereIdVote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Vote whereSecondVote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Vote whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Vote whereValid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Vote whereVoterId($value)
 */
class Vote extends Model
{
    protected $table = 'votes';
    protected $fillable = ['voter_id',  'election_id',  'client_id', 'first_vote', 'second_vote', 'valid'];
    protected $primaryKey = 'id_vote';


// DEFINE RELATIONSHIPS --------------------------------------------------

//jeder Vote MUSS GENAU EINE election haben
//Gegenstück zu $this->hasMany('App\Vote') in election
//erwartet, dass es in election eine id gibt,die in vote dann als FK eingetragen wird
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function election() {
        return $this->belongsTo('App\Election');
    }
//jeder Vote MUSS GENAU EINEN voter haben
//Gegenstück zu $this->hasMany('App\Voter') in voter
//erwartet, dass es in voter eine id gibt,die in vote dann als FK eingetragen wird
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function voter()
    {
        return $this->belongsTo('App\Voter');
    }
//noch fraglich ob das stimmt
//jeder Vote MUSS GENAU EINEN client haben
//Gegenstück zu $this->hasMany('App\Voter') in client
//erwartet, dass es in client eine id gibt,die in vote dann als FK eingetragen wird
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    /*
    public function client() {
        return $this->belongsTo('App\Client');
    }
    */
}
