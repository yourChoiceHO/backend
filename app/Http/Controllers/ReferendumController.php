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
        $token = $request->get('token');
        $info = Token::getClientOrElectionId($token);
        if(is_array($info)){
            if(in_array($id, array_column($info, 'id_election'))){
                return Referendum::findOrFail($id);
            }
        }else{
            return Referendum::whereIdReferendum($id)->where('client_id', '=', $info)->first();
        }
        abort(403, 'Access Denied');
    }

    public function all(Request $request){
        $info = Token::getClientOrElectionId($request->get('token'));
        if(is_array($info)){
            $info = array_column($info, 'id_election');
            $result = null;
            foreach ($info as $id){
                $result[] = Referendum::whereElectionId($id);
            }
        }else{
            $result = Referendum::whereClientId($info);
        }
        return $result;
    }

    public function store(Request $request)
    {
        $userArray = Token::getUserOrVoter($request->get('token'));
        if($userArray['type'] == 'user') {
            $user = $userArray['object'];
            $array = array(
                'text' => $request->get('text'),
                'constituency' => $request->get('constituency'),
                'yes' => $request->get('yes'),
                'no' => $request->get('no'),
                'client_id' => $user->client_id
            );
            Referendum::create($array);
        }
        abort(403, 'Access Denied');
    }

    public function update(Request $request, $id)
    {
        $userArray = Token::getUserOrVoter($request->get('token'));
        if($userArray['type'] == 'user') {
            $user = $userArray['object'];
            $newText = $request->get('text');
            $newConstituency = $request->get('constituency');
            $newElectionId = $request->get('election_id');
            $newYes = $request->get('yes');
            $newNo = $request->get('no');

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

    public function destroy($id)
    {
        $referendum = Referendum::findOrFail($id);

        $destroyflag = $referendum->delete();
    }


}
