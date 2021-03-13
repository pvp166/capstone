<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

Auth::routes(['verify' => true]);

Route::get('/',  function () {
    return view('welcome');
})->name('home');

Route::namespace('Admin')->prefix('admin')->name('admin.')->middleware('can:manage-users')->group(function(){
    Route::resource('/users', 'UsersController', ['except'=>['show','create','store']]);
    Route::get('users/{users}/destroy', ['as' => 'users.destroy', 'uses' => 'UsersController@destroy']);
    Route::post('users/filter', ['as' => 'users.filter', 'uses' => 'UsersController@filter']);
});
Route::get('/admin/users/filter');
Route::get('/order', 'OrderManage\OrderController@index')->name('order')->middleware('auth');
Route::get('/menu', function () {
    return view('menu');
})->middleware('can:manage-users')->name('menu');
//Customize Page
Route::get('/customize', function () {
   return view('customize');
})->middleware('auth')->name('pizzacustomize');


Route::get('api/customize/', 'PizzaCustomize\PizzaModifyController@index')->middleware('auth');
Route::get('api/customize/{id}', 'PizzaCustomize\PizzaModifyController@show')->middleware('auth');
Route::get('api/customize/size/{id}', 'PizzaCustomize\PizzaModifyController@showBySize')->middleware('auth');
Route::post('api/customize/add','PizzaCustomize\PizzaModifyController@store')->middleware('auth');


//PizzaModify
Route::get('/modify/{id}','PizzaCustomize\ModifyController@index')->middleware('auth');
Route::put('api/modify/{id}','PizzaCustomize\ModifyController@update')->middleware('auth');

Route::get('/paymentsuccess', function () {
    return view('paymentsuccess');
})->middleware('auth')->name('paymentsuccess');


Route::get('/shoppingcart', function () {
    return view('shoppingcart');
})->middleware('auth')->name('shoppingcart');

Route::get('/checkout/{addressId}', 'OrderManage\CheckoutController@index')->middleware('auth');
Route::post('api/shoppingcart/checkout', 'OrderManage\CheckoutController@charge')->middleware('auth');
//shopping cart
Route::get('api/shoppingcart', 'OrderManage\ShoppingCart@index')->middleware('auth');
Route::delete('api/shoppingcart/{id}','OrderManage\ShoppingCart@delete')->middleware('auth');
Route::put('api/shoppingcart/update/instructions/{id}','OrderManage\ShoppingCart@updateInstruction')->middleware('auth');
Route::post('api/shoppingcart/add', 'OrderManage\ShoppingCart@store')->middleware('auth');

//address
Route::get('api/address', 'OrderManage\AddressController@index')->middleware('auth');
Route::get('api/address/{id}', 'OrderManage\AddressController@show')->middleware('auth');
Route::put('api/address/{id}', 'OrderManage\AddressController@update')->middleware('auth');
Route::POST('api/address', 'OrderManage\AddressController@store')->middleware('auth');
Route::delete('api/address/{id}', 'OrderManage\AddressController@delete')->middleware('auth');
Route::get('/address', function () {
    return view('address');
})->middleware('auth')->name('address');


//Order Manage
Route::get('api/ordermanage/{id}','OrderManage\OrderController@show')->middleware('auth');
Route::put('api/ordermanage/{id}','OrderManage\OrderController@update')->middleware('auth');
Route::delete('api/ordermanage/{id}','OrderManage\OrderController@delete')->middleware('auth');
Route::get('api/ordermanage/','OrderManage\OrderController@showAll')->middleware('auth');

//Order History
Route::get('api/orderhistory','OrderManage\OrderHistoryController@index')->middleware('auth');
Route::delete('api/orderhistory/{id}','OrderManage\OrderHistoryController@delete')->middleware('auth');
Route::get('api/orderhistory/{id}','OrderManage\OrderHistoryController@show')->middleware('auth');
Route::put('api/orderhistory/{id}','OrderManage\OrderHistoryController@update')->middleware('auth');
Route::post('api/orderhistory/add','OrderManage\OrderHistoryController@store')->middleware('auth');


Route::get('/orderhistory', function () {
    return view('orderhistory');
})->middleware('auth')->name('orderhistory');

//Homepage
Route::get('api/menuitems/homepage','MenuManage\MenuItemController@index');
Route::post('api/menuitems/homepage/createNew/{id}','MenuManage\MenuItemController@customize');
Route::post('api/menuitems/newItem/orderNew','MenuManage\MenuItemController@orderNew');