<?php

namespace App\Http\Controllers\OrderManage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderManage\Order;
use App\Models\OrderManage\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\OrderManage\CustomizePizza;
use Exception;

class ShoppingCart extends Controller
{
    /*
    |--------------------------------------------------------------------------
    |   Shopping Cart Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for managing the shopping cart page. 
    | User can add more item to the shopping cart, delete the item and update the instructions
    */
    /**
     * This function responsilbe for showing the shopping cart to the main screen.
     * @var int $id user's id
     * @var array $order get the item from the current order
     * @var array $order_topping get the topping from the current order
     * @return array $order_list all item from the order
     */
    public function index()
    {

        //Get the user's id
        $id = Auth::id();
        // Join 3 table to get in all information
        $order_list = [];
        // Return the current working on order's item
        $order = DB::table('orders')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('item_prices', 'item_prices.id', '=', 'order_items.item_price_id')
            ->join('menu_items', 'menu_items.id', '=', 'item_prices.menu_item_id')
            ->select('*', 'order_items.id')
            ->where('user_id', $id)
            ->where('orders.order_status', 'On Editing')
            ->get();

        // Return the current working on order's toppings
        $order_topping = DB::table('customize_pizzas')
            ->join('order_items', 'customize_pizzas.order_item_id', '=', 'order_items.id')
            ->join('item_prices', 'item_prices.id', '=', 'customize_pizzas.item_price_id')
            ->join('menu_items', 'menu_items.id', '=', 'item_prices.menu_item_id')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->select('*', 'order_items.id','customize_pizzas.quantity')
            ->where('user_id', $id)
            ->where('order_status', 'On Editing')
            ->get();

        $order_list = array(
            'order' => $order,
            'order_topping' => $order_topping
        );
        return $order_list;
    }

    /**
     * This function responsilbe for deleting item in the shopping cart.
     * @param int $id item in the shopping cart
     * @var array $orderItem the list of item in the order
     * @var array $topping the list of topping in the order
     */
    public function delete($id)
    {
        // Delete item
        $orderItem = OrderItem::where('id', $id)->delete();
        //Delete the topping come with this item
        $topping = CustomizePizza::where('order_item_id', $id)->delete();
    }
    /**
     * This function responsilbe for updating the special instruction for the food
     * @param int $id item in the shopping cart
     * @param Illuminate\Http\Request $request the user requirement
     */

    public function updateInstruction(Request $request, $id)
    {
        //Update the Instruction
        $order_item = OrderItem::findOrFail($id); // report 404 error if error happens
        $order_item->special_instructions = $request['requirement'];
        $order_item->save();
    }
    /**
     * This function responsilbe for storing new item if user clicked add new
     * @param int $id item in the shopping cart
     * @param Illuminate\Http\Request $request the user requirement
     */
    public function store(Request $request)
    {
        try {
            //find the order
            $orderItem = OrderItem::where('id', $request['id'])->get();
            //Add new item information and save
            $newOrderItem = new OrderItem;
            $newOrderItem->order_id = $orderItem[0]->order_id;
            $newOrderItem->item_price_id = $orderItem[0]->item_price_id;
            $newOrderItem->special_instructions = $orderItem[0]->special_instructions;
            $newOrderItem->save();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
