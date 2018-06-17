<?php

namespace App\Http\Controllers;

use App\Token;
use App\User;
use App\Voter;
use Illuminate\Http\Request;
use Symfony\Component\Finder\Exception\AccessDeniedException;

class TokenController extends Controller
{

    /**
     * @param Request $request
     * @return array
     * @throws \HttpException
     */
    public function authUser(Request $request){
        $password = $request->input('password');
        $username = $request->input('username');
        $password = hash('sha256', $password);
        $user = User::wherePassword($password)->where('username', '=', $username)->first();
        if($user){
            $tokenOld = Token::whereUserId($user->id_user)->first();
            if($tokenOld){
                $tokenOld->delete();
            }
            $token = new Token();
            $token->user_id = $user->id_user;
            $token->remember_token = str_random(50);
            $token->save();
            return array('token' => $token->remember_token, 'role' => $user->role, 'id' => $user->id_user);
        }
        abort(403, 'Wrong Password or Username');
    }

    /**
     * @param Request $request
     * @return array
     * @throws \HttpException
     */
    public function authVoter(Request $request){
        $password = $request->input('password');
        $hash = $request->input('hash');
        $voter = Voter::wherePassword($password)->where('hash', '=', $hash)->first();
        if($voter){
            $token = new Token();
            $token->voter_id = $voter->id_voter;
            $token->remember_token = str_random(50);
            $token->save();
            return array('token' => $token->remember_token, 'role' => 3, 'id' => $voter->id_voter);
        }
        abort(403, 'Wrong Password or Username');
    }
}
