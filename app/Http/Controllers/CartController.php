<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cart;
use App\ProductTypeSize;
use App\Http\Requests\CouponRequest;
use App\Coupon;
use App\CouponUser;
use App\CouponProduct;
use Carbon\Carbon;

class CartController extends Controller
{
    function index(){

        return view("cart");

    }
    
    function store(Request $request){

        try{    

            $productTypeSize = ProductTypeSize::find($request->productTypeSizeId);
            if(Cart::where("product_type_size_id", $request->productTypeSizeId)->where("user_id", \Auth::user()->id)->count() > 0){

                

                $cart = Cart::where("product_type_size_id", $request->productTypeSizeId)->where("user_id", \Auth::user()->id)->first();
                $cart->amount = $cart->amount + $request->amount;
                $cart->price = $productTypeSize->price;
                $cart->update();

            }else{

                $cart = new Cart;
                $cart->product_type_size_id = $request->productTypeSizeId;
                $cart->amount = $request->amount;
                $cart->user_id = \Auth::user()->id;

                if($productTypeSize->discount_percentage > 0){

                    $cart->price = $productTypeSize->price - ($productTypeSize->price * ($productTypeSize->discount_percentage / 100));

                }else{

                    $cart->price = $productTypeSize->price;

                }

                
                $cart->save();

            }

            return response()->json(["success" => true, "msg" => "Producto añadido al carrito"]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }

    }

    function fetch(Request $request){

        try{

            $cart = Cart::where("user_id", \Auth::user()->id)->with("productTypeSize", "productTypeSize.product", "productTypeSize.size", "productTypeSize.type")->has("productTypeSize")->has("productTypeSize.product")->has("productTypeSize.size")->has("productTypeSize.type")->get();
            return response()->json(["success" => true, "products" => $cart]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]); 
        }

    }

    function guestFetch(Request $request){

        try{

            $guestProducts = [];
            foreach($request->cart as $cart){

                $product = ProductTypeSize::with("product", "size", "type")->has("product")->has( "size")->has("type")->where("id", $cart['productTypeSizeId'])->first();

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

    function singleProductDiscount(CouponRequest $request){

        if(Cart::where("user_id", \Auth::user()->id)->where("is_used", true)->count() > 0){

            return response()->json(["success" => false, "msg" => "Ya has utilizado un cupón"]);

        }


        $coupon = Coupon::where("coupon_code", $request->coupon)->first();

        if(Carbon::createFromFormat('Y-m-d', $coupon->end_date)->lt(Carbon::now())){
            return response()->json(["success" => false, "msg" => "Cupón ha expirado"]);
        }

        if($coupon->total_discount == 'producto'){

            if(CouponUser::where("coupon_id", $coupon->id)->where("user_id", \Auth::user()->id)->where("is_used", false)->count() > 0 || $coupon->all_users == true){

                if(CouponProduct::where("coupon_id", $coupon->id)->where("product_type_size_id", $request->productTypeSizeId)->count() > 0 || $coupon->all_products == true){
    
                    $cart = Cart::where("user_id", \Auth::user()->id)->where("product_type_size_id", $request->productTypeSizeId)->first();
    
                    if($cart){
    
                        
                        
                        if($coupon->discount_type == "porcentual"){

                            $priceToSubstract = $cart->price * ($coupon->discount_amount / 100);
                            $cart->price = $cart->price - $priceToSubstract;

                        }else{

                            $cart->price = $cart->price - $coupon->discount_amount;

                        }
                        $cart->is_used = true;
                        $cart->update();

                        CouponUser::where("coupon_id", $coupon->id)->where("user_id", \Auth::user()->id)->update(["is_used" => true]);

                        return response()->json(["success" => true, "msg" => "Has obtenido un descuento"]);
    
                    }else{
    
                        return response()->json(["success" => false, "msg" => "Producto no existe"]);
    
                    }
    
                }else{
    
                    return response()->json(["success" => false, "msg" => "Este cupón no éste producto"]);
    
                }
    
            }else{
    
                return response()->json(["success" => false, "msg" => "Este cupón no está disponible para ti"]);
    
            }

        }else{

            return response()->json(["success" => false, "msg" => "Este cupón solo está disponible para el carrito completo"]);

        }


    }

    function fullCartDiscount(CouponRequest $request){

        if(Cart::where("user_id", \Auth::user()->id)->where("is_used", true)->count() > 0){

            return response()->json(["success" => false, "msg" => "Ya has utilizado un cupón"]);

        }

        $coupon = Coupon::where("coupon_code", $request->coupon)->first();


        if(Carbon::createFromFormat('Y-m-d', $coupon->end_date)->lt(Carbon::now())){
            return response()->json(["success" => false, "msg" => "Cupón ha expirado"]);
        }

        if($coupon->total_discount == 'carrito'){

            if(CouponUser::where("coupon_id", $coupon->id)->where("user_id", \Auth::user()->id)->where("is_used", false)->count() > 0 || $coupon->all_users == true){
    
                $carts = Cart::where("user_id", \Auth::user()->id)->get();
            
                foreach($carts as $cart){

                    if(CouponProduct::where("coupon_id", $coupon->id)->where("product_type_size_id", $cart->product_type_size_id)->count() > 0 || $coupon->all_products == true ){

                        $cartModel = Cart::find($cart->id);

                        if($coupon->discount_type == "porcentual"){

                            $priceToSubstract = $cartModel->price * ($coupon->discount_amount / 100);
                            $cartModel->price = $cartModel->price - $priceToSubstract;
    
                        }else{
    
                            $cartModel->price = $cartModel->price - $coupon->discount_amount;
    
                        }
                        $cartModel->is_used = true;
                        $cartModel->update();
                    }

                }

                return response()->json(["success" => true, "msg" => "Has obtenido un descuento"]);

    
            }else{
    
                return response()->json(["success" => false, "msg" => "Este cupón no está disponible para ti"]);
    
            }

        }else{

            return response()->json(["success" => false, "msg" => "Este cupón solo está disponible para descuento a un producto"]);

        }


    }

}
