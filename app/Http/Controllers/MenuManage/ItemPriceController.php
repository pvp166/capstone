<?php

namespace App\Http\Controllers\MenuManage;

use App\Http\Controllers\Controller;
use App\Models\MenuManage\ItemPrice;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemPriceController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    |   Item Price Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling item price
    |
    */

    /**
     * Present the item price to the main screen
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \App\Models\MenuManage\ItemPrice $itemPrices
     */
    public function index()
    {
        $itemPrices = ItemPrice::all();
        return $itemPrices;
    }
    /**
     * Show the specific item price to the main screen
     * @param  int $id
     * @return \App\Models\MenuManage\ItemPrice
     */
    public function show($id)
    {
        try {
            return ItemPrice::findOrFail($id);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    /**
     * Show the specific item price with the menu item name. This function use eloquent to join 
     * two table together.
     * @param string $name
     * @return \App\Models\MenuManage\ItemPrice $itemPrices
     */
    public function showByMenuItemId($name)
    {
        try {
            $itemPrices = DB::table('menu_items')
                ->join('item_prices', 'menu_items.id', '=', 'item_prices.menu_item_id')
                ->select('menu_items.*')
                ->where('menu_items.name', $name)
                ->get();

            return $itemPrices;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    /**
     * Show the specific item price with the menu item name by its size. 
     * This function use eloquent to join
     * two table together.
     * @param string $name
     * @return \App\Models\MenuManage\ItemPrice $itemPrices
     */
    public function showSize($id)
    {
        try {
            $itemPrices = DB::table('menu_items')
                ->join('item_prices', 'menu_items.id', '=', 'item_prices.menu_item_id')
                ->select('item_prices.size', 'item_prices.id')
                ->where('menu_items.id', $id)
                ->get();

            return $itemPrices;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
