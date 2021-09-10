<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Brand;
use App\Product;
use App\ProductTypeSize;

class SearchController extends Controller
{
    
    function index(){
        return view("search");
    }

    function search(Request $request){

        $brands = Brand::all();
        $brandId = "";
        $type = $request->type;
        $words = [];

        $searchText = $request->searchText;
        $searchText = str_replace("Á", "A", $searchText);
        $searchText = str_replace("É", "E", $searchText);
        $searchText = str_replace("Í", "I", $searchText);
        $searchText = str_replace("Ó", "O", $searchText);
        $searchText = str_replace("Ú", "U", $searchText);
        
        foreach($brands as $brand){

            if(strpos(strtoupper($searchText), strtoupper($brand->name)) > -1){

                $brandId = $brand->id;

            }

        }

        if(isset($searchText)){
            $words = explode(' ',strtolower($searchText)); // coloco cada palabra en un espacio del array

            $words = array_unique($words); //eliminamos las palabras duplicadas
            $words = array_values($words); // reordenamos el array
        }
        
        
        $skip = ($request->page-1) * 20;
    

        if($brandId != ""){
            
            $products = ProductTypeSize::whereHas("product", function ($query) use($words, $brandId) {
            
                for ($i = 0; $i < count($words); $i++){
                    if($words[$i] != ""){
                        //$query->orWhere('description', "like", "%".$words[$i]."%");
                        $query->orWhere('name', "like", "%".$words[$i]."%");
                        //$query->orWhere('description', "like", "%".$words[$i]."%");
                    }
                }   

                $query->where("brand_id", $brandId);
                
            })->with("product.brand", "product.category", "product", "type", "size")->has("product.brand")->has("product.category")->has("product")->has("type")->has("size")->where(function ($query) use($request) {

                if(isset($request->type)){
                    $query->where("type_id", $request->type);
                }

                if(isset($request->size)){
                    $query->where("size_id", $request->size);
                }

            })->skip($skip)->take(20)->get();

            /*if(count($products) == 0){
                
                $products = Product::with("brand", "category", "ProductTypeSizes")->where("brand_id", $brandId)->skip($skip)->take(20)->get();

            }*/

    
            $productsCount = ProductTypeSize::whereHas("product", function ($query) use($words, $brandId) {
            
                for ($i = 0; $i < count($words); $i++){
                    if($words[$i] != ""){
                        //$query->orWhere('description', "like", "%".$words[$i]."%");
                        $query->orWhere('name', "like", "%".$words[$i]."%");
                        $query->orWhere('description', "like", "%".$words[$i]."%");
                    }
                }   

                $query->where("brand_id", $brandId);
                
            })->with("product.brand", "product.category", "product", "type", "size")->has("product.brand")->has("product.category")->has("product")->has("type")->has("size")->where(function ($query) use($request) {

                if(isset($request->type)){
                    $query->where("type_id", $request->type);
                }

                if(isset($request->size)){
                    $query->where("size_id", $request->size);
                }

            })->count();
        
        }else{
            //dd(count($words));
            if(count($words) <= 0){
                
                $products = ProductTypeSize::with("product.brand", "product.category", "product", "type", "size")->has("product.brand")->has("product.category")->has("product")->has("type")->has("size")->where(function ($query) use($request) {
    
                    if(isset($request->type)){
                        $query->where("type_id", $request->type);
                    }
    
                    if(isset($request->size)){
                        $query->where("size_id", $request->size);
                    }
    
                })->skip($skip)->take(20)->get();
                
                //dd($products);

                $productsCount = ProductTypeSize::with("product.brand", "product.category", "product", "type", "size")->has("product.brand")->has("product.category")->has("product")->has("type")->has("size")->where(function ($query) use($request) {
    
                    if(isset($request->type)){
                        $query->where("type_id", $request->type);
                    }
    
                    if(isset($request->size)){
                        $query->where("size_id", $request->size);
                    }
    
                })->count();
                
            }else{
                $products = ProductTypeSize::whereHas("product", function ($query) use($words) {
            
                    for ($i = 0; $i < count($words); $i++){
                        if($words[$i] != ""){
                            //$query->orWhere('description', "like", "%".$words[$i]."%");
                            $query->where('name', "like", "%".$words[$i]."%");
                            //$query->orWhere('description', "like", "%".$words[$i]."%");
                        }
                    }   
                    
                })->with("product.brand", "product.category", "product", "type", "size")->has("product.brand")->has("product.category")->has("product")->has("type")->has("size")->where(function ($query) use($request) {
    
                    if(isset($request->type)){
                        $query->where("type_id", $request->type);
                    }
    
                    if(isset($request->size)){
                        $query->where("size_id", $request->size);
                    }
    
                })->skip($skip)->take(20)->get();
        
                $productsCount = ProductTypeSize::whereHas("product", function ($query) use($words) {
                
                    for ($i = 0; $i < count($words); $i++){
                        if($words[$i] != ""){
                            //$query->orWhere('description', "like", "%".$words[$i]."%");
                            $query->where('name', "like", "%".$words[$i]."%");
                            //$query->orWhere('description', "like", "%".$words[$i]."%");
                        }
                    }   
                    
                })->with("product.brand", "product.category", "product", "type", "size")->has("product.brand")->has("product.category")->has("product")->has("type")->has("size")->where(function ($query) use($request) {
    
                    if(isset($request->type)){
                        $query->where("type_id", $request->type);
                    }
    
                    if(isset($request->size)){
                        $query->where("size_id", $request->size);
                    }
    
                })->count();
            }

        }

        return response()->json(["products" => $products, "productsCount" => $productsCount]);


    }

    function words(Request $request){

        $productTitles = [];
        $brandTitles = Brand::where("name", "like", "%".$request->search."%")->take(2)->get();
        
        if(count($brandTitles) == 0){
            $productTitles = Product::with("brand")->has("brand")->where("name", "like", "%".$request->search."%")->take(3)->get();
        }else{

            $productTitles = Product::with("brand")->has("brand")->where("name", "like", "%".$request->search."%")->take(3 - count($brandTitles))->get();

        }

        return response()->json(["success" => true, "brandTitles" => $brandTitles, "productTitles" => $productTitles]);

    }

}
