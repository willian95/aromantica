<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cart;
use App\ProductTypeSize;

class CartController extends Controller
{
    function index(){

        return view("cart");

    }
    
    function store(Request $request){

        try{

            if(Cart::where("product_type_size_id", $request->productTypeSizeId)->where("user_id", \Auth::user()->id)->count() > 0){

                $cart = Cart::where("product_type_size_id", $request->productTypeSizeId)->where("user_id", \Auth::user()->id)->first();
                $cart->amount = $cart->amount + $request->amount;
                $cart->update();

            }else{

                $cart = new Cart;
                $cart->product_type_size_id = $request->productTypeSizeId;
                $cart->amount = $request->amount;
                $cart->user_id = \Auth::user()->id;
                $cart->save();

            }

            return response()->json(["success" => true, "msg" => "Producto añadido al carrito"]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }

    }

    function fetch(Request $request){

        try{

            $cart = Cart::where("user_id", \Auth::user()->id)->with("productTypeSize", "productTypeSize.product", "productTypeSize.size", "productTypeSize.type")->get();
            return response()->json(["success" => true, "products" => $cart]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]); 
        }

    }

    function guestFetch(Request $request){

        try{

            $guestProducts = [];
            foreach($request->cart as $cart){

                $product = ProductTypeSize::with("product", "size", "type")->where("id", $cart['productTypeSizeId'])->first();

                $guestProducts[] = [
                    "product" => $product,
                    "amount" => $cart['amount'] 
                ];

            }

            return response()->json(["success" => true, "guestProducts" => $guestProducts]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]); 
        }

    }

    function updateCartAmount(Request $request){

        Cart::where("product_type_size_id", $request->productTypeSizeId)->where("user_id", \Auth::user()->id)->update(["amount" => $request->amount]);        

    }

    function delete(Request $request){

        try{

            $cart = Cart::where("id", $request->id)->first();
            $cart->delete();

            return response()->json(["success" => true, "msg" => "Producto eliminado del carrito"]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }

    }

}
