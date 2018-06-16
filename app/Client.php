<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Client
 *
 * @property-read \App\Election $elections
 * @property-read \App\User $users
 * @mixin \Eloquent
 * @property int $id_client
 * @property string $typ
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereIdClient($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereTyp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereUpdatedAt($value)
 */
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
