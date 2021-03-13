<?php

namespace App\Http\Controllers\PizzaCustomize;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderManage\Order;
use App\Models\OrderManage\OrderItem;
use App\Models\MenuManage\MenuItem;
use App\Models\MenuManage\ItemPrice;
use App\Models\OrderManage\CustomizePizza;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;

class ModifyController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    |   Modify Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for modifying an existing item in the menu. 
    | 
    */
    /**
     * This function responsilbe for presenting this item to main screen with toppings and base.
     * @param int $id this is the id of item in the shopping cart
     * @var App\Models\OrderManage\OrderItem present all the items which have the same id with param.
     * @var array $itemPrice the price of the pizza which the usered ordered
     * @var array $topping get the topping from the current order
     * @return function view direct user to view
     */
    public function index($id)
    {
        try {
            $item = DB::table('order_items')
                ->join('item_prices', 'item_prices.id', '=', 'order_items.item_price_id')
                ->join('menu_items', 'item_prices.menu_item_id', '=', 'menu_items.id')
                ->select('*', 'order_items.id')
                ->where('order_items.id', $id)
                ->get();
            $itemPrice = ItemPrice::where('menu_item_id', $item[0]->menu_item_id)->get();
            $topping = DB::table('customize_pizzas')
                ->join('item_prices', 'item_prices.id', '=', 'customize_pizzas.item_price_id')
                ->join('menu_items', 'item_prices.menu_item_id', '=', 'menu_items.id')
                ->select('*', 'customize_pizzas.item_price_id AS id')
                ->where('customize_pizzas.order_item_id', $id)
                ->get();

            return view('modify', compact('id', 'item', 'itemPrice', 'topping'));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    /**
     * This function responsilbe for updaing the new pizza
     * @param int $id this is the id of item in the shopping cart.
     * @param Illuminate\Http\Request request inforamtion of the pizza after modify.
     * @var array $item update new item to the pizza
     * @var array $topping update the new topping for this pizza
     */
    public function update(Request $request, $id)
    {
        try {
            // find the pizza 
            $item = OrderItem::where('id', $id)->get();
            // update the requirement from customer
            $item[0]->item_price_id = $request->chosenSize['id'];
            $item[0]->quantity = $request->chosenPizza['quantity'];
            $item[0]->special_instructions = $request->specialRequirement;
            $item[0]->save();

            // delete all the old toppings
            $toppings = CustomizePizza::where('order_item_id', $id)->get();
            for ($i = 0; $i < count($toppings); $i++) {
                $toppings[$i]->delete();
            }
            // add the new toppings
            for ($i = 0; $i < count($request['listOfChosenTopping']); $i++) {

                $topping = new CustomizePizza;
                $topping->order_item_id = $id;
                $topping->item_price_id = $request['listOfChosenTopping'][$i]['item']['id'];
                $topping->quantity = $request['listOfChosenTopping'][$i]['quantity'];
                $topping->save();
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
