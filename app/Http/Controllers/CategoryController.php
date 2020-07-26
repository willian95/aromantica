<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\ProductTypeSize;

class CategoryController extends Controller
{
    function show($slug){

        $category = Category::where("slug", $slug)->first();
        return view("categories",["category" => $category]);
    
    }

    function productsCategory($page, $id){

        try{

            $skip = ($page - 1) * 20;

            $products = ProductTypeSize::with("product", "product.category", "product.brand", "type", "size")->whereHas("product.category", function($q) use($id){
                $q->where("id", $id);
            })->skip($skip)->take(20)->get();
            $productsCount = ProductTypeSize::count();

            return response()->json(["success" => true, "products" => $products, "productsCount" => $productsCount]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }
}
