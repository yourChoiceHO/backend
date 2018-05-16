<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;

class ClientController extends Controller
{
    public function index(){
        $client = DB::table('clients')->get();
        return $client;
    }

    public function show($id){
        return Client::findOrFail($id);
    }

    public function store(Request $request)
    {
        $array = array(
            'typ' => $request->input('typ')

        );
        Client::create($array);
    }
}
