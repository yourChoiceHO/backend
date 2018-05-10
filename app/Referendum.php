<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Referendum extends Model
{
    protected $table = 'referendums';
    // protected $fillable = ['typ'];// white list, wenn blacklist vorhanden, dann nicht erforderlich (laravel eloquent)
    protected $guarded = ['id_referendum', 'election_id'];//blacklist

    protected $primaryKey = 'id_referendum';

    //Relationships


    //Referendum MUSS EINER election angehören

    public function election() {
        return $this->belongsTo('App\Election');
    }
}
