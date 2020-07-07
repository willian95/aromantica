<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Type;

class TypeController extends Controller
{
    function fetchAll(){

        $types = Type::all();
        return response()->json(["types" => $types]);

    }
}
