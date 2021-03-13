<?php

namespace App\Http\Controllers\OrderManage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderManage\OrderItem;
use Illuminate\Support\Facades\DB;
use App\Models\OrderManage\Order;
use App\Models\MenuManage\ItemPrice;
use Exception;

class OrderController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    |   OrderManage Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for managing order page. 
    | It can CRUD on the item table
    */

    /**
     * This function responsilbe for updating existed item by id
     * @return function view
     */
    public function index()
    {
        try {
            $orders = Order::all();
            return view('order', compact('orders'));
        } catch (Exception $e) {
            return $e->getMessage();
        }
        // get all the view

    }
    /**
     * This function responsilbe for showing the an order with its id to main screen.
     * @param int $id
     * @var array $order_item
     * @var array $topping
     * @var array $data
     * @return array $data
     */
    public function show($id)
    {
        try {

            $order_item = DB::table('orders')
                ->join('order_items', 'orders.id', '=', 'order_items.order_id')
                ->join('item_prices', 'item_prices.id', '=', 'order_items.item_price_id')
                ->join('menu_items', 'menu_items.id', '=', 'item_prices.menu_item_id')
                ->select('*', 'order_items.id')
                ->where('order_id', $id)
                
                ->get();
            
            // Return the current working on order's toppings
            $topping = DB::table('customize_pizzas')
                ->join('order_items', 'customize_pizzas.order_item_id', '=', 'order_items.id')
                ->join('item_prices', 'item_prices.id', '=', 'customize_pizzas.item_price_id')
                ->join('menu_items', 'menu_items.id', '=', 'item_prices.menu_item_id')
                ->join('orders', 'orders.id', '=', 'order_items.order_id')
                ->select('*', 'order_items.id', 'customize_pizzas.quantity')
                ->where('order_id', $id)
                ->get();

            //push the data to array

            $order_list = array(
                'order' => $order_item,
                'order_topping' => $topping
            );
            return $order_list;
        } catch (Exception $e) {
            return $e->getMessage();
        }
        //get list of items in order

    }
    /**
     * This function responsilbe for showing the an order with its id to main screen.
     * @param int $id
     * @var array $order_item
     * @var array $topping
     * @var array $data
     * @return array $data
     */
    public function update($id, Request $request)
    {
        try {
            $orders = Order::where('id', '=', $id)->firstOrFail();

            date_default_timezone_set('America/Toronto');
            $timestamp = time();
            $date_time = date("Y-m-d H:i:s", $timestamp);
            if ($request->orderStatus != 'On Editing') {
                $orders->updated_at = $date_time;
                $orders->order_status = $request->orderStatus;
            }

            $orders->save();
            
            // return $date_time;
        } catch (Exception $e) {
            return $e->getMessage();
        }
        //get list of items in order

    }


    /**
     * This function responsilbe for updating existed item by id
     * @return function view
     */
    public function showAll()
    {
        try {
            $orders = Order::all();
            return $orders;
        } catch (Exception $e) {
            return $e->getMessage();
        }
        // get all the view


    }
}
