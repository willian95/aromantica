<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    
    function index(){
        return view("checkout");
    }

    function billingNumber(){
        
        $random = Str::random(8)."-".uniqid();

        return response()->json(["billindNumber" => strtoupper($random)]);
    }

}
