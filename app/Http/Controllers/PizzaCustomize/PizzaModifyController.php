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

class PizzaModifyController extends Controller
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
     * This function responsilbe for presenting all the pizza base, toppings to the screen.
     * @var App\Models\MenuManage\MenuItem present all the items which have the same id with param.
     * @var array $itemPrice the price of the pizza which the usered ordered
     * @var array $topping get the topping from the current order
     * @return function view direct user to view
     */
    public function index()
    {
        $data = [];
        $item_pizza_curst = MenuItem::where('item_type_id', 7)->get();
        $item_pizza_meat_favorites = MenuItem::where('item_type_id', 1)->get();
        $item_pizza_veggie_favorites = MenuItem::where('item_type_id', 2)->get();
        array_push($data, $item_pizza_curst, $item_pizza_meat_favorites, $item_pizza_veggie_favorites);

        return $data;
    }
    /**
     * This function responsilbe for presenting all the pizza base, toppings to the screen.
     * @param int $id present all the items price with its id.
     * @var App\Models\MenuManage\ItemPrice $item_price the price of the pizza which the user ordered
     * @return  App\Models\MenuManage\ItemPrice $item_price the price of item
     */
    public function show($id)
    {
        try {
            $item_price = ItemPrice::where('menu_item_id', $id)->get();
            return $item_price;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    /**
     * This function responsible for presenting showing by size.
     * @param int $id present all the items price with this id_size.
     * @var App\Models\MenuManage\ItemPrice $item_price the price of the pizza which the user ordered
     * @return  App\Models\MenuManage\ItemPrice $item_price the price of item
     */

    public function showBySize($id)
    {
        try {
            $item_price = DB::table('item_prices')
                ->join('menu_items', 'item_prices.menu_item_id', '=', 'menu_items.id')
                ->select('*', 'item_prices.id')
                ->where('size', $id)
                ->where('menu_items.item_type_id', 8)
                ->get();
            return $item_price;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * This function responsible for saving the new customized pizza with topping
     * @param int $id present all the items price with this id_size.
     * @var int $id get the user's id
     * @var Illuminate\Http\Request $request the price of the pizza which the user ordered
     * @return  App\Models\MenuManage\ItemPrice $item_price the price of item
     */
    public function store(Request $request)
    {
        
        try {
            //get user id 
            $id = Auth::id();
            // get the order by id
            $order = DB::table('orders')
                ->select('*')
                ->where('order_status', 'On Editing')
                ->where('user_id', $id)
                ->get('*');

            if (count($order) == 0) {
                //if there is no order match with the criteria, create a new one
                $order = new Order();
                $order->user_id = $id;
                date_default_timezone_set('America/Toronto');
                $timestamp = time();
                $date_time = date("Y-m-d H:i:s", $timestamp);
                $order->created_at = $date_time;
                $order->order_status = 'On Editing';
                $order->save();
                $order = DB::table('orders')
                    ->select('*')
                    ->where('order_status', 'On Editing')
                    ->where('user_id', $id)
                    ->get('*');
            }
            // add new pizza
            $order_item = new OrderItem;
            $order_item->order_id = $order[0]->id;
            $order_item->item_price_id = $request['chosenSize']['id'];
            $order_item->quantity = $request['quantity'];
            $order_item->special_instructions = $request['specialRequirement'];
            $order_item->save();
            // add the topping for pizza
            $order_item = OrderItem::where('order_id', $order[0]->id)->get()->last();
            for ($i = 0; $i < count($request['listOfChosenTopping']); $i++) {
                $topping = new CustomizePizza;
                $topping->order_item_id = $order_item->id;
                $topping->item_price_id = $request['listOfChosenTopping'][$i]['item']['id'];
                $topping->quantity = $request['listOfChosenTopping'][$i]['quantity'];
                $topping->save();
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
