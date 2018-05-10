<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReferendumController extends Controller
{
    public function index(){
        $referendum = DB::table('referendum')->get();
        return $referendum;
    }
}
