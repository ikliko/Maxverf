<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
//client
Route::get('/', 'PageController@getHome');
Route::get('shop/category/{id}', 'ShopController@getCategory');
Route::resource('shop', 'ShopController');
Route::resource('cart', 'CartController');
Route::get('order/complete', function () {
    App::setLocale(Session::get('lang', 'nl'));
    return view('thank');
});
Route::get('order/error', function () {
    App::setLocale(Session::get('lang', 'nl'));
    return view('error');
});
Route::get('order/store', 'OrderController@saveOrder');
Route::resource('order', 'OrderController');
Route::get('payments/method', 'OrderController@selectPayment');
Route::post('payments/method/role', 'OrderController@setRole');
//Route::get('payments/method', 'OrderController@selectPayment');
Route::get('conditional-terms', 'PageController@getTerms');
Route::post('payments/method/ondelivery', 'OrderController@storeOnDelivery');
Route::post('payments/method/ondelivery/firm', 'OrderController@storeOnDeliveryFirm');
Route::get('new', 'ShopController@getNew');
Route::get('promo', 'ShopController@getPromo');
Route::get('lang/{lang}', function($lang) {
    Session::put('lang', $lang);

    return redirect() -> back();
});
Route::get('profile/{id}/edit', function() {
    return redirect() -> to('settings');
});
Route::get('settings', 'UserController@edit');
Route::put('profile/edit/password', 'UserController@changePassword');
Route::resource('profile', 'UserController');
Route::get('register', 'UserController@register');
Route::post('register', 'UserController@store');
Route::get('login', 'UserController@login');
Route::post('login', 'UserController@doLogin');
Route::get('logout', 'UserController@logout');

//server
Route::get('panel/products/categories/new/general', 'ProductsCategoryController@create');
Route::post('panel/products/categories/new/general', 'ProductsCategoryController@store');
Route::get('panel/products/categories/new/translation', 'ProductsCategoryController@translation');
//Route::get('panel/products/categories/{id}/general', 'ProductsCategoryController@create');
//Route::post('panel/products/categories/{id}/general', 'ProductsCategoryController@store');
//Route::get('panel/products/categories/{id}/translation', 'ProductsCategoryController@translation');
Route::post('panel/products/categories/new/translation', 'ProductsCategoryController@storeTranslation');
Route::resource('panel/products/categories', 'ProductsCategoryController');
Route::get('panel/products/categories/create', function() {
    return redirect() -> to('panel/products/categories/new/general');
});
Route::get('panel/products/categories/{id}', function($id) {
    return redirect() -> to('panel/products/categories/'. $id . '/general');
});
Route::get('panel/ProductsCategory/all', function() {
    return redirect() -> to('/panel/products/categories');
});
Route::get('panel/ProductsCategory/edit', function() {
    return redirect() -> to('/panel/products/categories/create');
});
Route::resource('panel/products/sizes', 'ProductSizeController');
Route::get('panel/ProductSize/all', function() {
    return redirect() -> to('panel/products/sizes');
});
Route::get('panel/ProductSize/edit', function() {
    return redirect() -> to('panel/products/sizes/create');
});
Route::resource('panel/products/colors', 'ProductColorController');
Route::get('panel/ProductColor/all', function() {
    return redirect() -> to('panel/products/colors');
});
Route::get('panel/ProductColor/edit', function() {
    return redirect() -> to('panel/products/colors/create');
});
Route::resource('panel/products', 'ProductController');
Route::get('panel/Product/all', function() {
    return redirect() -> to('panel/products');
});
Route::get('panel/Product/edit', function() {
    return redirect() -> to('panel/products/create');
});
Route::get('panel/Orders/all', 'OrderController@getAll');
Route::get('panel/Orders/accepted', 'OrderController@getAccepted');
Route::get('panel/Orders/declined', 'OrderController@getDeclined');
Route::resource('panel/Orders', 'OrderController');
Route::post('panel/Order/{id}/decline', 'OrderController@declineOrder');
Route::post('panel/Order/{id}/accept', 'OrderController@acceptOrder');
Route::get('panel/Order/all', function() {
    return redirect() -> to('panel/Orders');
});

//API
Route::get('api/size/{id}/colors', 'Api\SizeController@getSizeColors');
Route::resource('api/size', 'Api\SizeController');
Route::get('api/search', 'Api\SearchController@index');

//test
Route::get('test/flash', function() {
    flash('It is works');
    return view('index');
});

//specials
Route::get('get-access', function() {
    Session::put('access', 1);
    return redirect() -> to('shop');
});
Route::get('clear', function() {
    Session::flush();
    return redirect() -> to('shop');
});