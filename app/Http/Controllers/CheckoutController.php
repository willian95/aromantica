<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Payment;
use App\ProductTypeSize;
use App\ProductPurchase;
use App\Cart;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    
    function index(){
        return view("checkout");
    }

    function signature(Request $request){
        
        $billingNumber = strtoupper(Str::random(8).'-'.uniqid());
        $hash = md5('82433^1d321ba074d13cb580da34031bc7192331a73fed^'.$billingNumber.'^'.$request->total.'^COP');

        return response()->json(["hash" => $hash, "billingNumber" => $billingNumber, "total" => $request->total]);
    }

    function productSession(Request $request){

        session(["cart" => $request->guestCart]);
        
    }

    function response(Request $request){

        $refPayco = $request->ref_payco;
        return view("paymentConfirmation", ["ref" => $refPayco]);

    }

    function confirmation(Request $request){

        try{

            if(Payment::where("epayco_reference", $request->refPayco)->count() > 0){
                return response()->json(["success" => false, "msg" => "Esta referencia ya ha sido utilizada"]);
            }

            $total= 0;
            $client = new \GuzzleHttp\Client();
            $guestCart = $request->guestCart;

            if($guestCart != null){
                foreach($guestCart as $guest){

                    $productTypeSize = ProductTypeSize::where("id", $guest["productTypeSizeId"])->first();
                    $total = $total + ($productTypeSize->price * $guest["amount"]);
    
                }
            }
            

            if(\Auth::check()){

                $carts = Cart::where("user_id", \Auth::user()->id)->with("productTypeSize")->get();
                foreach($carts as $cart){

                    $total = $total + ($cart->productTypeSize->price * $cart->amount);

                }

            }

            $response = $client->request('GET', "https://secure.epayco.co/validation/v1/reference/".$request->refPayco);
            $data = json_decode($response->getBody());

            $payment = new Payment;
            if($data->data->x_response == "Aceptada"){
                $payment->status = "aprobado";
            }else{
                $payment->status = "rechazado";
            }
            $payment->total_products = $total;
            $payment->shipping_cost = 0;
            $payment->total = $total;
            $payment->epayco_reference = $request->refPayco;
            $payment->order_id = $data->data->x_id_factura;
            if(\Auth::check()){
                $payment->user_id = \Auth::user()->id;
            }
            $payment->tracking = 0;
            if(\Auth::check()){
                $payment->address = \Auth::user()->address;
            } 
            $payment->save();

            if($payment->status == "aprobado"){

                if($guestCart != null){
                    foreach($guestCart as $guest){

                        $productTypeSize = ProductTypeSize::where("id", $guest["productTypeSizeId"])->first();
                        $total = $total + ($productTypeSize->price * $guest["amount"]);
        
                        $productPurchase = new ProductPurchase;
                        $productPurchase->amount = $guest["amount"];
                        $productPurchase->price = $productTypeSize->price;
                        $productPurchase->shipping_cost = 0;
                        $productPurchase->payment_id = $payment->id;
                        $productPurchase->product_type_size_id = $guest["productTypeSizeId"];
                        $productPurchase->save();
        
                        $productTypeSizeStock = ProductTypeSize::where("id", $guest["productTypeSizeId"])->first();
                        $total = $productTypeSizeStock->stock - $guest["amount"];
                        $productTypeSizeStock->stock = $total;
                        $productTypeSizeStock->update();
        
                    }
                }
    
                if(\Auth::check()){
    
                    $carts = Cart::where("user_id", \Auth::user()->id)->with("productTypeSize")->get();
                    foreach($carts as $cart){
    
                        $total = $total + ($cart->productTypeSize->price * $cart->amount);
    
                        $productPurchase = new ProductPurchase;
                        $productPurchase->amount = $cart->amount;
                        $productPurchase->price = $cart->productTypeSize->price;
                        $productPurchase->shipping_cost = 0;
                        $productPurchase->payment_id = $payment->id;
                        $productPurchase->product_type_size_id = $cart->product_type_size_id;
                        $productPurchase->save();
    
                        $productTypeSizeStock = ProductTypeSize::where("id", $cart->product_type_size_id)->first();
                        $total = $productTypeSizeStock->stock - $cart->amount;
                        $productTypeSizeStock->stock = $total;
                        $productTypeSizeStock->update();
    
                    }

                    Cart::where("user_id", \Auth::user()->id)->delete();
    
                }

            }            
            
            return response()->json(["success" => true, "payment" => $payment]);
        }catch(\Exception $e){
            Log::info($e->getMessage());
            return response()->json(["success" => false, "err" => $e->getMessage(), "msg" => "Ha ocurrido un problema con su pago", "ln" => $e->getLine()]);
        }
    
    }

}
