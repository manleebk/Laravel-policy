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

//Route::model('product', App\Product::class);

Route::group(['prefix' => 'user'], function () {
    Route::post('/login', 'UserController@login');
    Route::post('/signup', 'UserController@signup');
});

Route::group(['prefix' => 'product', 'middleware' => 'auth:api'], function () {
    Route::get('/', 'ProductController@getListProduct')->middleware('can:viewAny, App\Product');
    Route::post('/add', 'ProductController@addProduct')->middleware('can:create, App\Product');
    Route::get('/detail/{id}', 'ProductController@detailProduct');
    Route::post('/update/{id}', 'ProductController@updateProduct');
    //Route::post('/update/{id}', 'ProductController@updateProduct')->middleware('can:update, [App\Product, id]');

});
