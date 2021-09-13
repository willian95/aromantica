<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\NewsletterRequest;
use App\User;
use App\Newsletter;

class PromotionController extends Controller
{
    
    function store(NewsletterRequest $request){


        if(User::where("email", $request->email)->count() > 0){
            return response()->json(["success" => false, "msg" => "Éste email le pertenece a un usuario"]);
        }

        $newsletter = new Newsletter;
        $newsletter->email = $request->email;
        $newsletter->save();

        return response()->json(["success" => true, "msg" => "Genial, has sido agregado"]);

    }

}
