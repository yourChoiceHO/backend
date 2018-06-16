<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;

/**
 * App\Token
 *
 * @property int $id_token
 * @property int|null $user_id
 * @property int|null $voter_id
 * @property string|null $remember_token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Token whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Token whereIdToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Token whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Token whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Token whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Token whereVoterId($value)
 * @mixin \Eloquent
 */
class Token extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'voter_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];
    protected $primaryKey = 'id_token';


    public function user(){
        $this->belongsTo('App\User');
    }
    public function voter(){
        $this->belongsTo('App\Voter');
    }

    public static function getClientOrElectionId($token){
        $token = Token::whereRememberToken($token)->first();
        if($token){
            if($token->user_id){
                $user = User::findOrFail($token->user_id);
                return $user->client_id;
            }elseif ($token->voter_id){
                $voter = Voter::whereIdVoter($token->voter_id);
                $result = \DB::select('SELECT e.id_election FROM elections e, parties p, candidates c, referendums r WHERE (p.constituency = '.$voter->constituency.' AND e.id_election = p.election_id) OR (c.constituency = '.$voter->constituency.' AND e.id_election = c.election_id) OR (r.constituency = '.$voter->constituency.' AND e.id_election = r.election_id) GROUP BY e.id_election');
                return $result;
            }
        }
        abort(403, 'Access Denied');
    }

    public static function getUserOrVoter($token){
        $token = Token::whereRememberToken($token)->first();
        if($token){
            if($token->user_id){
                $user = User::findOrFail($token->user_id);
                return array('type' => 'user', 'object' => $user);
            }elseif ($token->voter_id){
                $voter = Voter::findOrFail($token->voter_id);
                return array('type' => 'voter', 'object' => $voter);
            }
        }
        abort(403, 'Access Denied');
    }

}
