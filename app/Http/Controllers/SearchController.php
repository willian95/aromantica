<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Brand;
use App\Product;

class SearchController extends Controller
{
    
    function index(){
        return view("search");
    }

    function search(Request $request){

        $brands = Brand::all();
        $brandId = "";
        $type = $request->type;

        foreach($brands as $brand){

            if(strpos(strtoupper($request->searchText), strtoupper($brand->name)) > -1){

                $brandId = $brand->id;

            }

        }

        $words = explode(' ',strtolower($request->searchText)); // coloco cada palabra en un espacio del array

        $words = array_unique($words); //eliminamos las palabras duplicadas
        $words = array_values($words); // reordenamos el array
        
        
        $skip = ($request->page-1) * 20;
        
        if($brandId != ""){
            
            $products = Product::where(function ($query) use($words) {
            
                for ($i = 0; $i < count($words); $i++){
                    if($words[$i] != ""){
                        //$query->orWhere('description', "like", "%".$words[$i]."%");
                        $query->orWhere('name', "like", "%".$words[$i]."%");
                        $query->orWhere('description', "like", "%".$words[$i]."%");
                    }
                }   
                
            })->with("brand", "category", "ProductTypeSizes")->where("brand_id", $brandId)->whereHas("ProductTypeSizes", function ($query) use($request) {
                
                if($request->type != null)
                    $query->where('type_id', $request->type);
                if($request->size != null)
                    $query->where('size_id', $request->size);
            
            })->skip($skip)->take(20)->get();

            if(count($products) == 0){
                
                $products = Product::with("brand", "category", "ProductTypeSizes")->where("brand_id", $brandId)->skip($skip)->take(20)->get();

            }

    
            $productsCount = Product::where(function ($query) use($words) {
                
                for ($i = 0; $i < count($words); $i++){
                    if($words[$i] != ""){
                        //$query->orWhere('description', "like", "%".$words[$i]."%");
                        $query->orWhere('name', "like", "%".$words[$i]."%");
                        $query->orWhere('description', "like", "%".$words[$i]."%");
                    }
                }   
                  
            })->with("brand", "category", "ProductTypeSizes")->where("brand_id", $brandId)->whereHas("ProductTypeSizes", function ($query) use($request) {
                
                if($request->type != null)
                    $query->where('type_id', $request->type);
                if($request->size != null)
                    $query->where('size_id', $request->size);
            
            })->count();
        
        }else{

            $products = Product::with("category", "brand", "ProductTypeSizes")
            ->where(function ($query) use($words) {
                for ($i = 0; $i < count($words); $i++){
                    if($words[$i] != ""){
                        //$query->orWhere('description', "like", "%".$words[$i]."%");
                        $query->orWhere('name', "like", "%".$words[$i]."%");
                        $query->orWhere('description', "like", "%".$words[$i]."%");
                    }
                }      
            })
            ->skip($skip)->whereHas("ProductTypeSizes", function ($query) use($request) {
                
                if($request->type != null)
                    $query->where('type_id', $request->type);
                if($request->size != null)
                    $query->where('size_id', $request->size);
            
            })->take(20)->get();
    
            $productsCount = Product::with("category", "brand", "ProductTypeSizes")
            ->where(function ($query) use($words) {
                for ($i = 0; $i < count($words); $i++){
                    if($words[$i] != ""){
                        //$query->orWhere('description', "like", "%".$words[$i]."%");
                        $query->orWhere('name', "like", "%".$words[$i]."%");
                        $query->orWhere('description', "like", "%".$words[$i]."%");
                    }
                }      
            })
            ->whereHas("ProductTypeSizes", function ($query) use($request) {
                
                if($request->type != null)
                    $query->where('type_id', $request->type);
                if($request->size != null)
                    $query->where('size_id', $request->size);
            
            })->count();

        }

        return response()->json(["products" => $products, "productsCount" => $productsCount]);


    }

    function words(Request $request){

        $productTitles = [];
        $brandTitles = Brand::where("name", "like", "%".$request->search."%")->take(2)->get();
        
        if(count($brandTitles) == 0){
            $productTitles = Product::with("brand")->where("name", "like", "%".$request->search."%")->take(3)->get();
        }else{

            $productTitles = Product::with("brand")->where("name", "like", "%".$request->search."%")->take(3 - count($brandTitles))->get();

        }

        return response()->json(["success" => true, "brandTitles" => $brandTitles, "productTitles" => $productTitles]);

    }

}
