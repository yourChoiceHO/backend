<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Voter extends Model
{
    protected $table = 'voters';
    protected $fillable = ['last_name', 'first_name', 'hash', 'constituency'];
    protected $guarded = ['id_voter'];
    protected $primaryKey = 'id_voter';


// DEFINE RELATIONSHIPS --------------------------------------------------

//jeder Voter hat mehrere votes
//Gegenstück zu $this->belongsTo('App\Voter') in vote
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function vote()
    {
        return $this->hasMany('App\Vote');
    }
}
