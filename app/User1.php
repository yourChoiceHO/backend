<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User1 extends Model
{
    protected $table = 'users';
    // protected $fillable = ['typ'];// white list, wenn blacklist vorhanden, dann nicht erforderlich (laravel eloquent)
    protected $guarded = ['id_user', 'client_id'];//blacklist

    protected $primaryKey = 'id_user';


    //Relationships

    //User MUSS EINEM client angehören
    public function client() {
        return $this->belongsTo('App\Client');
    }

    //Functions
}
