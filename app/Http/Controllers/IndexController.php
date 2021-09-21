<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    
    function index(Request $request){

        return view('welcome', ["showModal" => $request->modal]);

    }

}
