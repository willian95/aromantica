<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Size;

class SizeController extends Controller
{
    function fetchAll(){

        $sizes = Size::all();
        return response()->json(["sizes" => $sizes]);

    }
}
