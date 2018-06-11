<?php

namespace App\Http\Controllers;

use App\Token;
use App\Voter;
use Illuminate\Http\Request;
use Symfony\Component\Finder\Exception\AccessDeniedException;

class TokenController extends Controller
{
    public function auth(Request $request){
        $password = $request->get('password');
        $hash = $request->get('hash');
        $voter = Voter::wherePassword($password)->where('hash', '=', $hash);
        if($voter){
            $token = new Token();
            $token->voter_id = $voter->id_voter;
            $token->remember_token = str_random(10);
            return array('token' => $token->remember_token);
        }
        throw new AccessDeniedException("Password oder Hash ist falsch", 404);
    }
}
