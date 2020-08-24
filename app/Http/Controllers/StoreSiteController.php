<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Product;
use App\ProductTypeSize;
use App\Brand;

class StoreSiteController extends Controller
{
    
    function index(){

        return view("tienda");

    }

    function fetch(Request $request){

        $take = 20;
        $skip = ($request->page-1) * $take;

        try{

            if(isset($request->price) && $request->price > 0){
                
                $products = ProductTypeSize::with("product", "product.category", "product.brand", "type", "size")
                ->has("product")->has( "product.category")->has( "product.brand")->has( "type")->has( "size")
                ->whereHas("product", function($q) use($request){

                    if(isset($request->brands) && count($request->brands))
                    {
                        $brandArray = [];
                        foreach($request->brands as $brand){
                            array_push($brandArray, $brand);
                        }

                        $q->whereIn("brand_id", $brandArray);

                    }
                    
                    if(isset($request->categories) && count($request->categories))
                    {
                        $categoryArray = [];

                        foreach($request->categories as $category){
                            array_push($categoryArray, $category);
                        }

                        $q->whereIn("category_id", $categoryArray);

                    }
    
                    //dd($q->toSql());
    
                })->where("price", "<=", $request->price)->skip($skip)->take($take)->get();
                
                $productsCount = ProductTypeSize::with("product", "product.category", "product.brand", "type", "size")->whereHas("product", function($q) use($request){

                    if(isset($request->brands) && count($request->brands))
                    {
                        $brandArray = [];
                        foreach($request->brands as $brand){
                            array_push($brandArray, $brand);
                        }

                        $q->whereIn("brand_id", $brandArray);

                    }
                    
                    if(isset($request->categories) && count($request->categories))
                    {
                        $categoryArray = [];

                        foreach($request->categories as $category){
                            array_push($categoryArray, $category);
                        }

                        $q->whereIn("category_id", $categoryArray);

                    }
    
                    //dd($q->toSql());
    
                })->has("product")->has("product.category")->has( "product.brand")->has( "type")->has( "size")->where("price", "<=", $request->price)->count();

            }else{

                $products = ProductTypeSize::with("product", "product.category", "product.brand", "type", "size")->has("product")->has("product.category")->has( "product.brand")->has( "type")->has( "size")->whereHas("product", function($q) use($request){

                    if(isset($request->brands) && count($request->brands))
                    {
                        $brandArray = [];
                        foreach($request->brands as $brand){
                            array_push($brandArray, $brand);
                        }

                        $q->whereIn("brand_id", $brandArray);

                    }
                    
                    if(isset($request->categories) && count($request->categories))
                    {
                        $categoryArray = [];

                        foreach($request->categories as $category){
                            array_push($categoryArray, $category);
                        }

                        $q->whereIn("category_id", $categoryArray);

                    }
    
                })->where("price", ">", 0)->skip($skip)->take($take)->get();

                $productsCount = ProductTypeSize::with("product", "product.category", "product.brand", "type", "size")->has("product")->has("product.category")->has( "product.brand")->has( "type")->has( "size")->whereHas("product", function($q) use($request){

                    if(isset($request->brands) && count($request->brands))
                    {
                        $brandArray = [];
                        foreach($request->brands as $brand){
                            array_push($brandArray, $brand);
                        }

                        $q->whereIn("brand_id", $brandArray);

                    }
                    
                    if(isset($request->categories) && count($request->categories))
                    {
                        $categoryArray = [];

                        foreach($request->categories as $category){
                            array_push($categoryArray, $category);
                        }

                        $q->whereIn("category_id", $categoryArray);

                    }
    
                })->where("price", ">", 0)->count();

            }


            $price = ProductTypeSize::orderBy("price", "desc")->first();
            return response()->json(["success" => true, "products" => $products, "maxPrice" => $price->price, "productsCount" => $productsCount]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }
    }

    function fetchCategoriesCount(){

        try{

            $categoriesArray=[];
            $categories = Category::all();

            foreach($categories as $category){

                $categoriesArray[] = [
                    "id" => $category->id,
                    "name" => $category->name, 
                    "productsAmount" => ProductTypeSize::whereHas("product", function($q) use($category){

                        $q->where("category_id", $category->id);

                    })->count(),
                    "slug" => $category->slug

                ];

            }

            return response()->json(["success" => true, "categories" => $categoriesArray]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    function fetchBrands(){

        try{

            $brands = Brand::all();
            return response()->json(["success" => true, "brands" => $brands]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }

    }

    function showProductDetail($productTypeSizeId){

        $product = ProductTypeSize::with("product", "product.category", "product.brand", "type", "size")->has("product")->has("product.category")->has( "product.brand")->has( "type")->has( "size")->where("id", $productTypeSizeId)->first();
        
        $productTypeSizes = Product::where("slug", $product->product->slug)->with("productTypeSizes.size", "productTypeSizes.type", "productTypeSizes", "category", "brand")->has("productTypeSizes.size")->has("productTypeSizes.type")->has( "productTypeSizes")->has( "category")->has( "brand")->first();

        return view("storeProductDetail", ["product" => $product, "productTypeSizes" => $productTypeSizes]);

    }

}
