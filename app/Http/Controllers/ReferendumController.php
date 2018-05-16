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
}
