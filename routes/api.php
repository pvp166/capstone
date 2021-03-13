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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('menuitems','MenuManage\MenuItemController@index');
Route::get('menuitems/{id}','MenuManage\MenuItemController@show');
Route::post('menuitems','MenuManage\MenuItemController@create');
Route::put('menuitems/{id}','MenuManage\MenuItemController@update');
Route::delete('menuitems/{id}','MenuManage\MenuItemController@delete');
Route::get('itemtypes','MenuManage\ItemTypeController@index');


// get user


Route::get('itemprice/getByMenuItem/{id}','MenuManage\ItemPriceController@showByMenuItemId');
Route::put('ordermanage/update/{id}','OrderManage\OrderController@update');
