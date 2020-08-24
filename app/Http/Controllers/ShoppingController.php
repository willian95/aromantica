<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Payment;


class ShoppingController extends Controller
{
    
    function index(){

        return view("shoppings");

    }

    function fetch($page = 1){

        try{

            $skip = ($page - 1) * 20;

            $shoppings = Payment::with("productPurchases", "user", "productPurchases.productTypeSize", "productPurchases.productTypeSize.product", "productPurchases.productTypeSize.product.brand", "productPurchases.productTypeSize.type", "productPurchases.productTypeSize.size")
            ->has("productPurchases")->has( "user")->has( "productPurchases.productTypeSize")->has( "productPurchases.productTypeSize.product")->has( "productPurchases.productTypeSize.product.brand")->has( "productPurchases.productTypeSize.type")->has( "productPurchases.productTypeSize.size")
            ->skip($skip)->take(20)->where("payments.user_id", \Auth::user()->id)->orderBy("id", "desc")->get();

            $shoppingsCount = Payment::with("productPurchases", "user", "productPurchases.productTypeSize", "productPurchases.productTypeSize.product", "productPurchases.productTypeSize.type", "productPurchases.productTypeSize.product.brand", "productPurchases.productTypeSize.size")->has("productPurchases")->has( "user")->has( "productPurchases.productTypeSize")->has( "productPurchases.productTypeSize.product")->has( "productPurchases.productTypeSize.product.brand")->has( "productPurchases.productTypeSize.type")->has( "productPurchases.productTypeSize.size")->where("payments.user_id", \Auth::user()->id)->count();

            return response()->json(["success" => true, "shoppings" => $shoppings, "shoppingsCount" => $shoppingsCount]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "err" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }

    }

}
