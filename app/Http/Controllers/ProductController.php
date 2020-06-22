<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\ProductTypeSize;

class ProductController extends Controller
{
    
    function show($slug){

        try{

            $product = Product::where("slug", $slug)->with("productTypeSizes.size", "productTypeSizes.type", "productTypeSizes", "category", "brand")->first();
            return view("productDetail", ["product" => $product]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "err" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }

    }

}
