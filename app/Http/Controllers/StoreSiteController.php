<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Product;

class StoreSiteController extends Controller
{
    
    function index(){

        return view("tienda");

    }

    function fetch(Request $request){



    }

    function fetchCategoriesCount(){

        try{

            $categoriesArray=[];
            $categories = Category::all();

            foreach($categories as $category){

                $categoriesArray[] = [

                    "name" => $category->name,
                    "productsAmount" => Product::where("category_id", $category->id)->count(),
                    "slug" => $category->slug

                ];

            }

            return response()->json(["success" => true, "categories" => $categoriesArray]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

}
