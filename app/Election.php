<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Election extends Model
{
    public $timestamps = true;

    protected $table = 'elections';
    // protected $fillable = ['typ'];// white list, wenn blacklist vorhanden, dann nicht erforderlich (laravel eloquent)
    protected $guarded = ['id_election', 'client_id'];//blacklist

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


}
