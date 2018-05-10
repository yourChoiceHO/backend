<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'clients';
   // protected $fillable = ['typ'];// white list, wenn blacklist vorhanden, dann nicht erforderlich (laravel eloquent)
    protected $guarded = ['id_client'];//blacklist

    protected $primaryKey = 'id_client';


    //Relationships

    //Client KANN MEHREREN elections angehören
    public function elections() {
        return $this->belongsTo('App\Election');
    }

    //Client enthält EINEN ODER MEHRERE user
    public function users() {
        return $this->belongsTo('App\User');
    }

    //Functions

}
