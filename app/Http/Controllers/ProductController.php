<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\ProductTypeSize;

class ProductController extends Controller
{
    
    function show($slug){

        try{

            $product = Product::where("slug", $slug)->with("productTypeSizes.size", "productTypeSizes.type", "productTypeSizes", "category", "brand")->has("productTypeSizes.size")->has("productTypeSizes.type")->has("productTypeSizes")->has("category")->has("brand")->first();
            //$types = ProductTypeSize::where("product_id", $product->id)->groupBy("type_id")->get();
            //$sizes = ProductTypeSize::where("product_id", $product->id)->groupBy("size_id")->get();

            return view("productDetail", ["product" => $product]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "err" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }

    }

}
