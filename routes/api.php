<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'user'], function () {
    Route::post('/login', 'UserController@login');
    Route::post('/signup', 'UserController@signup');
});

Route::group(['prefix' => 'product', 'middleware' => 'auth:api'], function () {
    //Route::group(['prefix' => 'product'], function () {
    Route::get('/', 'ProductController@getListProduct')->middleware('can:viewAny, App\Product');
    Route::get('/{id}', 'ProductController@getProductById');
    Route::post('/add', 'ProductController@addProduct');
    Route::post('/update', 'ProductController@updateProduct');
});
