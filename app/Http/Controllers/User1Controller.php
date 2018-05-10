<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class User1Controller extends Controller
{
    public function index(){
        $user = DB::table('users')->get();
        return $user;
    }
}
