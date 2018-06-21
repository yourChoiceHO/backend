<?php

namespace App\Http\Controllers;

use App\Token;
use Illuminate\Http\Request;
use App\Referendum;
use Symfony\Component\Finder\Exception\AccessDeniedException;

class ReferendumController extends Controller
{
    public function index(){
        $referendum = DB::table('referendum')->get();
        return $referendum;
    }

    public function show(Request $request, $id){
        $token = $request->input('token');
        $info = Token::getClientOrElectionId($token);
        if(is_array($info)){
            if(in_array($id, array_column($info, 'election_id'))){
                $referendum = Referendum::findOrFail($id);
                if($referendum){
                    return $referendum;
                }
            }
        }else{
            $referendum = Referendum::whereIdReferendum($id)->where('client_id', '=', $info)->first();
            if($referendum){
                return $referendum;
            }
        }
        abort(403, 'Access Denied');
    }

    public function all(Request $request){
        $info = Token::getClientOrElectionId($request->input('token'));
        if(is_array($info)){
            $info = array_column($info, 'election_id');
            $result = null;
            foreach ($info as $id){
                $result[] = Referendum::whereElectionId($id);
            }
        }else{
            $result = Referendum::whereClientId($info)->get();
        }
        return $result;
    }

    public function store(Request $request)
    {
        $userArray = Token::getUserOrVoter($request->input('token'));
        if($userArray['type'] == 'user') {
            $user = $userArray['object'];
            $array = array(
                'text' => $request->input('text'),
                'constituency' => $request->input('constituency'),
                'yes' => $request->input('yes'),
                'no' => $request->input('no'),
                'election_id' => $request->input('election_id'),
                'client_id' => $user->client_id
            );
            return Referendum::create($array);
        }
        abort(403, 'Access Denied');
    }

    public function update(Request $request, $id)
    {
        $userArray = Token::getUserOrVoter($request->input('token'));
        if($userArray['type'] == 'user') {
            $user = $userArray['object'];
            $newText = $request->input('text');
            $newConstituency = $request->input('constituency');
            $newElectionId = $request->input('election_id');
            $newYes = $request->input('yes');
            $newNo = $request->input('no');

            $referendum = Referendum::whereIdReferendum($id)->where('client_id', '=', $user->client_id)->first();
            if($referendum) {
                $referendum->text = $newText ? $newText : $referendum->text;
                $referendum->constituency = $newConstituency ? $newConstituency : $referendum->constituency;
                $referendum->election_id = $newElectionId ? $newElectionId : $referendum->election_id;
                $referendum->yes = $newYes ? $newYes : $referendum->yes;
                $referendum->no = $newNo ? $newNo : $referendum->no;
                $referendum->save();
                return $referendum;
            }
        }
        abort(403, 'Access Denied');
    }

    public function destroy(Request $request, $id)
    {
        $userArray = Token::getUserOrVoter($request->input('token'));
        if($userArray['type'] == 'user') {
            $user = $userArray['object'];
            $referendum = Referendum::whereIdReferendum($id)->where('client_id', '=', $user->client_id)->first();
            if($referendum){
                $referendum->delete();
                return "true";
            }
        }
        abort(403, 'Access Denied');
    }


}
