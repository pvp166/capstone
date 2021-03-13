<?php

namespace App\Http\Controllers\OrderManage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderManage\Order;
use App\Models\CustomerManage\Address;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Stripe;
use Exception;

class CheckoutController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    |   Checkout Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for checking out page
    |
    */

    /**
     * This function responsilbe for respenting the shopping cart to main screen
     * @param int $addressId
     * @var Illuminate\Support\Facades\Auth $id
     * @var App\Models\CustomerManage\Address $addressId
     * @var Order $orders
     * @var Topping $topping
     * @return function view
     */
    public function index($addressId)
    {
        // Return $id
        $id = Auth::id(); // if not redirect to the login page
        // Return array of orders
        try {
            $user = Auth::user()->email;
            $orders = DB::table('orders')
                ->join('order_items', 'orders.id', '=', 'order_items.order_id')
                ->join('item_prices', 'item_prices.id', '=', 'order_items.item_price_id')
                ->join('menu_items', 'menu_items.id', '=', 'item_prices.menu_item_id')
                ->select('*','order_items.id')
                ->where('orders.user_id', $id)
                ->where('order_status', 'On Editing')
                ->get();
            // Return array of orders
            $order_topping = DB::table('customize_pizzas')
                ->join('order_items', 'customize_pizzas.order_item_id', '=', 'order_items.id')
                ->join('item_prices', 'item_prices.id', '=', 'customize_pizzas.item_price_id')
                ->join('menu_items', 'menu_items.id', '=', 'item_prices.menu_item_id')
                ->join('orders', 'orders.id', '=', 'order_items.order_id')
                ->select('*', 'order_items.id','customize_pizzas.quantity')
                ->where('user_id', $id)
                ->where('order_status', 'On Editing')
                ->get();
            // Return array of address
            $address = Address::findOrFail($addressId);
            return view('checkout', compact('orders', 'address', 'user', 'order_topping'));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    /**
     * This function responsilbe for processing the payment
     * @param Illuminate\Http\Request $request
     * @var array $source
     * @var array $amount
     * @var Order $orders
     * @return int $id
     */
    public function charge(Request $request)
    {
        // Return $id
        $id = Auth::id(); // if not redirect to the login page
        // Return array of orders
        try {
            $id = Auth::id();
            // source 
            $source = $request->charge['source'];
            // amount of money
            $amount = $request->charge['amount'];
            Stripe\Stripe::setApiKey('sk_test_51Hdi2EENFBiXe6rcxiaNpUn4nAxAhgKqA498bSGAggHTqS59LrrKFhRX86tugwN6hvopP4CDzrUNyaicl7Tgq0BW00YlzZlDJI');
            Stripe\Charge::create([
                "amount" => $amount * 100,
                "currency" => "cad",
                "source" => $source,
                "description" => "Test payment from codehunger.in."
            ]);
            // save the new information
            $order = Order::where('orders.user_id', $id)
                ->where('order_status', 'On Editing')
                ->first();

            $order->order_status = 'On Working';
            $order->save();
            return view('paymentsuccess');
        } catch (Exception $e) {
            return $e->getMessage();
        }
        //get id of the current user

    }
}
