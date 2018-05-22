<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Referendum;

class ReferendumController extends Controller
{
    public function index(){
        $referendum = DB::table('referendum')->get();
        return $referendum;
    }

    public function show($id){
        return Referendum::findOrFail($id);
    }

    public function store(Request $request)
    {
        $array = array(
            'text' => $request->input('text'),
            'constituency' => $request->input('constituency'),
            'yes' => $request->input('yes'),
            'no' => $request->input('no')
        );
        Referendum::create($array);
    }

    public function update(Request $request, $id)
    {
        $newText = $request->get('text');
        $newConstituency = $request->get('constituency');
        $newElectionId = $request->get('election_id');
        $newYes = $request->get('yes');
        $newNo = $request->get('no');

        $referendum = Referendum::findOrFail($id);
        $referendum->text = $newText ? $newText : $referendum->text;
        $referendum->constituency = $newConstituency ? $newConstituency : $referendum->constituency;
        $referendum->election_id = $newElectionId ? $newElectionId : $referendum->election_id;
        $referendum->yes = $newYes ? $newYes: $referendum->yes;
        $referendum->no = $newNo ? $newNo: $referendum->no;

        $referendum->save();
    }
}
