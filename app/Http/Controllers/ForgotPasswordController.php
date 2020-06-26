<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\UpdatePasswordRequest;
use Illuminate\Support\Str;
use App\User;

class ForgotPasswordController extends Controller
{
    
    function index(){

        return view("forgotPassword");

    }

    function forgot(ForgotPasswordRequest $request){

        try{

            $user = User::where("email", $request->email)->first();
            if($user){

                $hash = Str::random(32).uniqid();
                $user->recovery_hash = $hash;
                $user->update();

                $data = ["user" => $user, "hash" => $hash];
                $to_name = $user->name;
                $to_email = $user->email;

                \Mail::send("emails.forgotPassword", $data, function($message) use ($to_name, $to_email) {

                    $message->to($to_email, $to_name)->subject("¡Recuperar contraseña!");
                    $message->from("ventas@aromantica.co", env("MAIL_FROM_NAME"));
    
                });

                return response()->json(["success" => true, "msg" => "Revisa tu bandeja de correo"]);

            }else{

                return response()->json(["success" => false, "msg" => "El correo ingresado no existe"]);

            }

        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }


    }


    function check($hash){

        try{

            $user = User::where("recovery_hash", $hash)->first();
            return view("passwordChange", ["user" => $user]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }

    }

    function update(UpdatePasswordRequest $request){

        try{

            $user = User::where("id", $request->id)->first();
            $user->password = bcrypt($request->password);
            $user->save();

            return response()->json(["success" => true, "msg" => "Contraseña recuperada exitosamente"]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }

    }

}
