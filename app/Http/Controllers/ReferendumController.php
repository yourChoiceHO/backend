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
            return Referendum::whereIdReferendum($id)->where('client_id', '=', $info);
        }
        throw new AccessDeniedException("Zugriff verweigert", 403);
    }

    public function store(Request $request)
    {
        $userArray = Token::getUserOrVoter($request->get('token'));
        if($userArray['type'] == 'user') {
            $user = $userArray['object'];
            $array = array(
                'text' => $request->input('text'),
                'constituency' => $request->input('constituency'),
                'yes' => $request->input('yes'),
                'no' => $request->input('no'),
                'client_id' => $user->client_id
            );
            Referendum::create($array);
        }
        throw new AccessDeniedException("Zugriff verweigert", 403);
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

            $referendum = Referendum::whereIdReferendum($id)->where('client_id', '=', $user->client_id);
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
        throw new AccessDeniedException("Zugriff verweigert", 403);
    }

    public function destroy($id)
    {
        $referendum = Referendum::findOrFail($id);

        $destroyflag = $referendum->delete();
    }


}
