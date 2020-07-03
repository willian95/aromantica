<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', function () {
    //return view('welcome');
  //  echo "<h3>Coming soon</h3>";
    return view("pronto");
});

Route::get('/front-test', function () {
    //return view('welcome');
    return view("welcome");
});

Route::post("/register", "RegisterController@register");
Route::get("/email/check/{hash}", "RegisterController@check");

Route::post("/login", "LoginController@login");
Route::get("/logout", "LoginController@logout");

Route::get("/profile", "ProfileController@index");
Route::post("/profile/update", "ProfileController@update");

Route::get("/forgot-password", "ForgotPasswordController@index");
Route::post("/forgot-password", "ForgotPasswordController@forgot");
Route::get("/forgot-password/check/{hash}", "ForgotPasswordController@check");
Route::post("/password/update", "ForgotPasswordController@update");

Route::get('/google/redirect', 'SocialAuthGoogleController@redirect');
Route::get('/google/login/callback', 'SocialAuthGoogleController@callback');

Route::get('/facebook/redirect', 'SocialAuthFacebookController@redirect');
Route::get('/facebook/login/callback', 'SocialAuthFacebookController@callback');

Route::get("/home/fetch", "HomeController@fetch");
Route::get("/product/{slug}", "ProductController@show");

Route::get("/cart/index", "CartController@index");
Route::post("/cart/store", "CartController@store");
Route::get("/cart/fetch", "CartController@fetch");
Route::post("/cart/guest/fetch", "CartController@guestFetch");
Route::post("/cart/delete", "CartController@delete");
Route::post("/cart/amount/update", "CartController@updateCartAmount");

Route::get("checkout", "CheckoutController@index");

Route::get("/shopping/index", "ShoppingController@index");
Route::get("/shopping/fetch/{page}", "ShoppingController@fetch");