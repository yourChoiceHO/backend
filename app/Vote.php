<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
