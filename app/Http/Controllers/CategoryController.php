<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Product;

class CategoryController extends Controller
{
    function show($slug){

        $category = Category::where("slug", $slug)->first();
        return view("categories",["category" => $category]);
    
    }

    function productsCategory($page, $id){

        try{

            $skip = ($page - 1) * 20;

            $products = Product::where("category_id", $id)->with("ProductTypeSizes")->skip($skip)->take(20)->get();
            $productsCount = Product::count();

            return response()->json(["success" => true, "products" => $products, "productsCount" => $productsCount]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor"]);

        }

    }
}
