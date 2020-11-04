<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Payment;
use App\ProductTypeSize;
use App\ProductPurchase;
use App\GuestUser;
use App\User;
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
                    if($productTypeSize->discount_percentage == 0){
                        $total = $total + ($productTypeSize->price * $guest["amount"]);
                    }else{
                        $total = $total + ($productTypeSize->price - ($productTypeSize->price * ($productTypeSize->discount_percentage/100))) * $guest["amount"];
                    }
                    
    
                }
            }
            

            if(\Auth::check()){

                $carts = Cart::where("user_id", \Auth::user()->id)->with("productTypeSize")->has("productTypeSize")->get();
                foreach($carts as $cart){

                    if($cart->productTypeSize->discount_percentage == 0){
                        $total = $total + ($cart->productTypeSize->price * $cart->amount);
                    }
                    else{

                        $total = $total + (($cart->productTypeSize->price - ($cart->productTypeSize->price * ($cart->productTypeSize->discount_percentage/100))) * $cart->amount);
                    }

                }

            }

            $response = $client->request('GET', "https://secure.epayco.co/validation/v1/reference/".$request->refPayco);
            $data = json_decode($response->getBody());

            $payment = new Payment;
            if($data->data->x_response == "Aceptada"){
                $payment->status = "aprobado";

                $shipping = $request->shippingData;
                $shipping["origin"]["number"] = "";
                $shipping["destination"]["number"] = "";

                //$shipping = $request->shippingData;
                //dump($shipping);
                /*$client = new \GuzzleHttp\Client(['headers' => ['Authorization' => 'Bearer 2acacff444ddd328fb8b7e64c94671740218643867cb7d69489d33ca77147c0d']]);
                $response = $client->post("https://api-test.envia.com/ship/generate", [
                    "json" => $shipping
                ]);*/

                
                //dump($shipping);
                
                $client = new \GuzzleHttp\Client(['headers' => ['Authorization' => 'Bearer 5e0ad0d945ccc05a410561f389dd2e4c035c84ad7d4269b13fd6d54d0b8e6d8c']]);
                $response = $client->post("https://api.envia.com/ship/generate", [
                    "json" => $shipping
                ]);
                
                $envia = json_decode($response->getBody());
                
                //dump($envia);
                
                $totalShippingCost = 0;
                foreach($envia->data as $shippingCost){
                    $totalShippingCost = $totalShippingCost + $shippingCost->totalPrice;
                }

                $payment->tracking_url = $envia->data[0]->trackUrl;
                $payment->tracking = $envia->data[0]->trackingNumber;
                $payment->label = $envia->data[0]->label;
                //$payment->shipping_cost = $envia->data[0]->totalPrice;
                $payment->shipping_cost = intval($totalShippingCost)+1;
                //dd($payment);
            }else{
                $payment->status = "rechazado";
                $payment->shipping_cost = 0;
            }
            $payment->total_products = $total;
            $payment->total = $total + $payment->shipping_cost;
            $payment->epayco_reference = $request->refPayco;
            $payment->order_id = $data->data->x_id_factura;
            if(\Auth::check()){
                $payment->user_id = \Auth::user()->id;
            }else{
                
                $guestUser = $request->guestUser;

                $guest = GuestUser::where("email", $guestUser["email"])->first();

                if(!$guest){
                    $guest = new GuestUser;
                    $guest->name = $guestUser["name"];
                    $guest->email = $guestUser["email"];
                    $guest->address = $guestUser["address"];
                    $guest->address = $guestUser["address"];
                    $guest->phone = $guestUser["phone"];
                    $guest->save();
                }

                $payment->guest_id = $guest->id;
            }

            if(\Auth::check()){
                $payment->address = \Auth::user()->address;
            } 
            $payment->save();

            if($payment->status == "aprobado"){

                if($guestCart != null){
                    foreach($guestCart as $guest){

                        $productTypeSize = ProductTypeSize::where("id", $guest["productTypeSizeId"])->first();
                        if($productTypeSize->discount_percentage == 0){
                            $total = $total + ($productTypeSize->price * $guest["amount"]);
                        }else{
                            $total = $total + ($productTypeSize->price - (($productTypeSize->discount_percentage/100) * $productTypeSize->price)) * $guest["amount"];
                        }
                        
        
                        $productPurchase = new ProductPurchase;
                        $productPurchase->amount = $guest["amount"];
                        if($productTypeSize->discount_percentage == 0){
                            $productPurchase->price = $productTypeSize->price;
                        }else{
                            $productPurchase->price = ($productTypeSize->price - ($productTypeSize->discount_percentage/100) * $productTypeSize->price);
                        }
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
    
                    $carts = Cart::where("user_id", \Auth::user()->id)->with("productTypeSize")->has("productTypeSize")->get();
                    foreach($carts as $cart){
                        
                        if($cart->productTypeSize->discount_percentage == 0){
                            $total = $total + ($cart->productTypeSize->price * $cart->amount);
                        }else{
                            $total = $total + (($cart->productTypeSize->price - (($cart->productTypeSize->discount_percentage/100)*$cart->productTypeSize->price)) * $cart->amount);
                        }
                        

                        $productPurchase = new ProductPurchase;
                        $productPurchase->amount = $cart->amount;
                        if($cart->productTypeSize->discount_percentage == 0){
                            $productPurchase->price = $cart->productTypeSize->price;
                        }else{
                            $productPurchase->price = $cart->productTypeSize->price - (($cart->productTypeSize->discount_percentage/100)*$cart->productTypeSize->price);
                        }
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

            $productsPurchased = ProductPurchase::where("payment_id", $payment->id)->with("productTypeSize", "productTypeSize.product", "productTypeSize.type", "productTypeSize.size")->has("productTypeSize")->has("productTypeSize.product")->has("productTypeSize.type")->has("productTypeSize.size")->get();

            if(\Auth::check()){

                $to_name = \Auth::user()->name;
                $to_email = \Auth::user()->email;
                $data = ["user" => User::where("id", \Auth::user()->id)->first(), "products" => $productsPurchased, "tracking_url" => $payment->tracking_url];
                

            }else{
                $guestUser = GuestUser::where("id", $payment->guest_id)->first();
                $to_name = $guestUser->name;
                $to_email = $guestUser->email;
                $data = ["user" => GuestUser::where("id", $guestUser->id)->first(), "products" => $productsPurchased, "tracking_url" => $payment->tracking_url];

            }

            

            //dd($productsPurchased->productTypeSize);
            \Mail::send("emails.purchase", $data, function($message) use ($to_name, $to_email) {

                $message->to($to_email, $to_name)->subject("¡Tu compra se ha realizado con éxito!");
                $message->from("ventas@aromantica.co", "Aromantica");

            });

            $to_name = "Admin";
            $to_email = "ventas@aromantica.co";
            //$data = ["user" => $user, "hash" => $hash];

            \Mail::send("emails.admin", $data, function($message) use ($to_name, $to_email) {

                $message->to($to_email, $to_name)->subject("¡Un cliente ha realizado una compra!");
                $message->from("ventas@aromantica.co", "Aromantica");

            });

            /*$to_name = "Felipe";
            $to_email = "info@myass.co";
            //$data = ["user" => $user, "hash" => $hash];

            \Mail::send("emails.admin", $data, function($message) use ($to_name, $to_email) {

                $message->to($to_email, $to_name)->subject("¡Un cliente ha realizado una compra!");
                $message->from("ventas@aromantica.co", "Aromantica");

            });*/


            return response()->json(["success" => true, "payment" => $payment]);
        }catch(\Exception $e){
            Log::info($e->getMessage());
            return response()->json(["success" => false, "err" => $e->getMessage(), "msg" => "Ha ocurrido un problema con su pago", "ln" => $e->getLine()]);
        }
    
    }

}
