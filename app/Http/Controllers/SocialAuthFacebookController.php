<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use Socialite;

class SocialAuthFacebookController extends Controller
{
    
    public function redirect()
    {
        return Socialite::driver("facebook")->redirect();
    }

    public function callback()
    {
        // Obtenemos los datos del usuario
        $social_user = Socialite::driver("facebook")->user(); 
        // Comprobamos si el usuario ya existe
        if ($user = User::where('email', $social_user->email)->first()) { 
            //return $this->authAndRedirect($user); // Login y redirección
            Auth::loginUsingId($user->id);
        } else {  
            // En caso de que no exista creamos un nuevo usuario con sus datos.
            $user = new User;
            $user->name = $social_user->name;
            $user->email = $social_user->email;
            $user->facebook_id = $social_user->id;
            $user->save();
            Auth::loginUsingId($user->id);

        }

        return redirect()->to('/');

    }

}
