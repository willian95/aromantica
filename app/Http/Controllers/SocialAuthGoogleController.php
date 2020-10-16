<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Socialite;
use Auth;
use Exception;

class SocialAuthGoogleController extends Controller
{
    public function redirect()
    {

        $driver = "google";
        if(url('/') == "https://www.aromantica.co"){
            $driver = "google";
        }else{
            \Redirect::away("https://www.aromantica.co/google/redirect");
        }

        dd($driver, url('/'));

        return Socialite::driver($driver)->redirect();
    }


    public function callback(Request $request)
    {
        try {
            
            $driver = "";
            if(url('/') == "https://www.aromantica.co"){
                $driver = "google";
            }

            $googleUser = Socialite::driver($driver)->user();
            $existUser = User::where('email',$googleUser->email)->first();
            
            if($existUser) {
                Auth::loginUsingId($existUser->id);
            }
            else {
                $user = new User;
                $user->name = $googleUser->name;
                $user->email = $googleUser->email;
                $user->google_id = $googleUser->id;
                //$user->password = md5(rand(1,10000));
                $user->save();
                Auth::loginUsingId($user->id);
            }
            return redirect()->to('/');
        } 
        catch (Exception $e) {
            return 'error';
        }
    }
}
