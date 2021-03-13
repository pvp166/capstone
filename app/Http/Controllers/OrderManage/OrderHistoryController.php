<?php

namespace App\Http\Controllers\OrderManage;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderManage\OrderItem;
use Illuminate\Support\Facades\DB;
use App\Models\OrderManage\Order;
use Exception;

class OrderHistoryController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    |   Order History Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for managing order page. 
    | It can CRUD on the item table
    */

    /**
     * This function responsilbe for showing the an order with its id to main screen.
     * @var int $id user's id
     * @var array $order get the order that finished
     * @return array $order
     */
    public function index()
    {
        try {
            $id = Auth::id();
            $order = DB::table('orders')
                ->select('*')
                ->where('user_id', $id)
                ->where('order_status', 'Finish')
                ->orWhere('order_status','On Working')
                ->get();

            return $order;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    /**
     * This function responsilbe for deleting orders
     * @param int $id user's id
     * @var array $order get the order that finished
     * @var array $orderItem get the item in this order
     */
    public function delete($id)
    {

        $order = Order::findOrFail($id); //Find or fail can report the 404 exception
        $order->delete(); // delete the order
        $orderItem = OrderItem::where('order_id', $id)->delete(); // delete the item
    }
    /**
     * This function responsilbe for deleting orders
     * @param int $id user's id
     * @var array $order get the order that user choose
     * @var array $order_items get the items from the above order
     * @return array $order_detail contain the information of order: order and order items
     */
    public function show($id)
    {
        try {
            $order_detail = [];
            $order = Order::where('id', $id)->get(); // get order
            // get order items which have the same id
            $order_items = DB::table('order_items')

                ->join('item_prices', 'item_prices.id', '=', 'order_items.item_price_id')
                ->join('menu_items', 'menu_items.id', '=', 'item_prices.menu_item_id')
                ->select('*', 'order_items.id')
                ->where('order_id', $id)

                ->get();
            array_push($order_detail, $order, $order_items); // push all items to order detail and return
            return $order_detail;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    /**
     * This function responsilbe for updating orders comments and rating to the order
     * @param Illuminate\Http\Request $request contain the comments and rating of the user
     */
    public function update(Request $request, $id)
    {
        try {
            for ($i = 0; $i < count($request['order_items']); $i++) {
                $order_item = OrderItem::findOrFail($request['order_items'][$i]['id']);
                // find the item from this order
                $order_item->rating = $request['order_items'][$i]['rating'];
                $order_item->comments = $request['order_items'][$i]['comments'];
                $order_item->save();
                // update the comment and rating to the order
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    /**
     * This function responsilbe for storing the new item from the order history to the new order
     * @param Illuminate\Http\Request $request the request contain the new item 's information
     * @var int $id get the order that user choose
     * @var array $order information of the order which is currently working on
     */
    public function store(Request $request)
    {
        try {
            $id = Auth::id();
            $order = DB::table('orders')
                ->select('*')
                ->where('order_status', 'on Editing')
                ->where('user_id', $id)
                ->get('*');
            //check if have any order is working on, if not, create a new one
            if (count($order) == 0) {
                // add new order
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
            
            // add new item
            $order_item = new OrderItem;
            $order_item->order_id = $order[0]->id;
            $order_item->item_price_id = $request['item']['item_price_id'];
            $order_item->quantity = 1;
            $order_item->save();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
