<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Voter extends Model
{
    protected $table = 'voters';
    protected $fillable = ['last_name', 'first_name', 'UserID'];
    protected $guarded = ['id_voter', 'vote_id'];

    //jeder Voter MUSS GENAU EINE vote haben
    //Gegenstück zu $this->hasOne('App\Voter') in vote
    //erwartet, dass es in vote eine id gibt,die in voter dann als FK eingetragen wird
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    /*
    public function election() {
        return $this->belongsTo('App\Vote');
    }
    */
}
