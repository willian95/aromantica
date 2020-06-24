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
    return view('welcome');
});

Route::post("/register", "RegisterController@register");
Route::get("/email/check/{hash}", "RegisterController@check");
Route::post("/login", "LoginController@login");
Route::get("/logout", "LoginController@logout");

Route::get('/google/redirect', 'SocialAuthGoogleController@redirect');
Route::get('/google/login/callback', 'SocialAuthGoogleController@callback');

Route::get('/facebook/redirect', 'SocialAuthFacebookController@redirect');
Route::get('/facebook/login/callback', 'SocialAuthFacebookController@callback');

Route::get("/home/fetch", "HomeController@fetch");
Route::get("/product/{slug}", "ProductController@show");

Route::get("/cart/index", "CartController@index");
Route::post("/cart/store", "CartController@store");
Route::get("/cart/fetch", "CartController@fetch");
Route::delete("/cart/delete", "CartController@delete");

Route::get("/shopping/index", "ShoppingController@index");
Route::get("/shopping/fetch/{page}", "ShoppingController@fetch");