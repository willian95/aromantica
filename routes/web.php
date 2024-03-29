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



Route::get('/', "IndexController@index");

Route::get("/offline", function(){

  return view('vendor/laravelpwa/offline');

});

/*Route::get('/front-test', function () {
  //return view('welcome');
  return view("welcome");
});*/

Route::get('/tienda', "StoreSiteController@index");
Route::post('/tienda/fetch', "StoreSiteController@fetch");
Route::get('/tienda/fetch/categories', "StoreSiteController@fetchCategoriesCount");
Route::get('/tienda/fetch/brands', "StoreSiteController@fetchBrands");
Route::get("/tienda/producto/{id}", "StoreSiteController@showProductDetail");

Route::post("/register", "RegisterController@register");
Route::get("/email/check/{hash}", "RegisterController@check");

Route::post("/login", "LoginController@login");
Route::get("/logout", "LoginController@logout");
Route::get("/check/login", "LoginController@checkAuth");

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
Route::post("/cart/single-product/discount", "CartController@singleProductDiscount");
Route::post("/cart/full-cart/discount", "CartController@fullCartDiscount");
Route::get("/cart/fetch", "CartController@fetch");
Route::post("/cart/guest/fetch", "CartController@guestFetch");
Route::post("/cart/delete", "CartController@delete");
Route::post("/cart/amount/update", "CartController@updateCartAmount");

Route::get("/type/fetchAll", "TypeController@fetchAll");
Route::get("/size/fetchAll", "SizeController@fetchAll");

Route::get("/search", "SearchController@index");
Route::post("/search", "SearchController@search");
Route::post("/words", "SearchController@words");

Route::post("/newsletter", "PromotionController@store");

/*Route::get("/test/purchase/mail", function () {

  $to_name = "Felipe";
  $to_email = "info@myass.co";
  //$data = ["user" => $user, "hash" => $hash];

  \Mail::send("emails.purchase", [], function ($message) use ($to_name, $to_email) {

    $message->to($to_email, $to_name)->subject("¡Tu compra se ha realizado con éxito!");
    $message->from("ventas@aromantica.co", "Aromantica");
  });
});*/

Route::get("/test/admin/mail", function () {

  $to_name = "Felipe";
  $to_email = "rodriguezwillian95@gmail.co";
  $data = ["user" => App\User::where("email", "rodriguezwillian95@gmail.com")->first(), "hash" => "aadasdfgfd"];

  \Mail::send("emails.register", $data, function ($message) use ($to_name, $to_email) {

    $message->to($to_email, $to_name)->subject("¡Un cliente ha realizado una compra!");
    $message->from("ventas@aromantica.co", "Aromantica");
  });
});


/*Route::get("/test/forget/mail", function(){

  $hash = Str::random(32).uniqid();
  $user = App\User::where("role_id", 2)->first();

  $data = ["user" => $user, "hash" => $hash];
  $to_name = $user->name;
  $to_email = $user->email;

  \Mail::send("emails.forgotPassword", $data, function($message) use ($to_name, $to_email) {

      $message->to($to_email, $to_name)->subject("¡Recuperar contraseña!");
      $message->from("ventas@aromantica.co", "Aromantica");

  });

});*/

Route::get("checkout", "CheckoutController@index");
Route::post("checkout/signature", "CheckoutController@signature");
Route::get("checkout/response", "CheckoutController@response");
Route::post("checkout/confirm/payment", "CheckoutController@confirmation");

Route::get("/shopping/index", "ShoppingController@index");
Route::get("/shopping/fetch/{page}", "ShoppingController@fetch");

Route::get("/category/{slug}", "CategoryController@show");
Route::get("/category/products/{page}/category/{id}", "CategoryController@productsCategory");