<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class HomeController extends Controller
{
    
    function fetch(){

        try{

            $products = Product::take(12)->has("brand")->has("productTypeSizes")->with("brand", "productTypeSizes")->get();
            return response()->json(["success" => true, "products" => $products]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "err" => "Error en el servidor", "ln" => $e->getLine()]);

        }

    }

}
