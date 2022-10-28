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
    return $request->user();
});

// Route::get('/customer/show/{id}',['uses' => 'CustomerController@getCustomer','as' => 'customer.getcustomer'] );
// Route::get('/customer/all',['uses' => 'CustomerController@getCustomerAll','as' => 'customer.getcustomerall'] );
Route::resource('customer', 'CustomerController');
Route::resource('item', 'ItemController');

// Route::get('getItems', 'ItemController@getItem');
// Route::get('/getItems', [
//     'uses' => 'ItemController@getItem',
//     'as' => 'getItems'
//     ]);
Route::view('/item-index', 'item.index');
Route::view('/shop', 'shop.index');

Route::post('/item/checkout',[
    'uses' => 'ItemController@postCheckout',
    'as' => 'checkout'
]);