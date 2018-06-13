<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Referendum
 *
 * @property-read \App\Election $election
 * @mixin \Eloquent
 * @property int $id_referendum
 * @property string $text
 * @property int $constituency
 * @property int $election_id
 * @property int $yes
 * @property int $no
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Referendum whereConstituency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Referendum whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Referendum whereElectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Referendum whereIdReferendum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Referendum whereNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Referendum whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Referendum whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Referendum whereYes($value)
 * @property int $client_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Referendum whereClientId($value)
 */
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
