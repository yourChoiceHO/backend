<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Voter
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Vote[] $vote
 * @mixin \Eloquent
 * @property int $id_voter
 * @property string $last_name
 * @property string $first_name
 * @property string $hash
 * @property int $constituency
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Voter whereConstituency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Voter whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Voter whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Voter whereHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Voter whereIdVoter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Voter whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Voter whereUpdatedAt($value)
 */
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
