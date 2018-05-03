<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Election extends Model
{
    public $timestamps = true;

    protected $table = 'elections';

    protected $fillable = ['typ', 'text', 'start_date', 'end_date', 'state'];
    protected $guarded = ['id_election', 'client_id'];


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




}
