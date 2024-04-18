<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return response()->json($request->user(),200);
});

Route::group(['prefix' => 'categories'], function () {
    Route::get('/', 'CategoryController@index');
    Route::get('/{category}', 'SubcategoryController@index');
    Route::get('/{category}/{subcategory}', 'ProductController@filter');
});

Route::group(['prefix' => 'products'], function () {
    Route::get('/', 'ProductController@list');
    Route::get('/all', 'ProductController@index');
    Route::get('/search/{words}', 'ProductController@search');
    Route::get('/{product}', 'ProductController@show');
    Route::delete('/{product}', 'ProductController@destroy')->middleware('admin');
    Route::put('/{product}', 'ProductController@update')->middleware('admin');
    Route::post('/{subcategory}', 'ProductController@store')->middleware('admin');
});

Route::group(['prefix' => 'orders'], function () {
    Route::get('/cart', 'OrderController@cart');
    Route::get('/handled', 'OrderController@hadnledOrders');
    Route::delete('/{productId}', 'OrderController@removeProduct');
    Route::post('/{product}', 'OrderController@store');
    Route::put('/{product}', 'OrderController@changeCount');
    Route::post('/', 'OrderController@handleOrder')->middleware('verified');
});

Route::get('/specs/{subcategory}', 'SpecController@index');
Route::get('/ads', 'AdvertisementController@index');

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::post('/addcategory', 'CategoryController@store');
    Route::delete('/categories/{category}', 'CategoryController@destroy');
    Route::delete('/categories/subcategories/{subcategory}', 'SubcategoryController@destroy');
    Route::get('/categories', 'CategoryController@index');
    Route::post('/addsubcategory/{category}', 'SubcategoryController@store');
    Route::get('/categories/{subcategory}', 'SubcategoryController@getProducts');
    Route::get('/solditems', 'OrderController@soldProducts');
    Route::put('/solditems/{order}', 'OrderController@changeStatus');

    Route::delete('/ads/{ad}', 'AdvertisementController@destroy');
    Route::get('/ads/{ad}', 'AdvertisementController@show');
    Route::post('/ads', 'AdvertisementController@store');
    Route::put('/ads/{ad}', 'AdvertisementController@update');

    Route::group(['prefix' => 'specs'], function () {
        Route::get('/{spec}', 'SpecController@show');
        Route::post('/{subcategory}', 'SpecController@store');
        Route::delete('/{spec}', 'SpecController@destroy');
        Route::put('/{spec}', 'SpecController@update');
    });
});
