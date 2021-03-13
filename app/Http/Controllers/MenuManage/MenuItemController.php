<?php



namespace App\Http\Controllers\MenuManage;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\MenuManage\ItemPrice;
use Illuminate\Http\Request;
use App\Models\MenuManage\MenuItem;
use Illuminate\Support\Facades\Auth;
use App\Models\OrderManage\Order;
use App\Models\OrderManage\OrderItem;

class MenuItemController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    |   Menu Item Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling menu item
    |
    */

    /**
     * Present all items in the list to the main screen
     *
     * @return App\Models\MenuManage\MenuItem $menuItems
     */
    public function index()
    {

        $menuItems = DB::table('menu_items')
            ->join('item_prices', 'menu_items.id', '=', 'item_prices.menu_item_id')
            ->join('item_types', 'menu_items.item_type_id', '=', 'item_types.id')
            ->select('menu_items.*', 'item_types.*', 'item_prices.*')
            ->get();
        return $menuItems;
    }
    /**
     * Present all items in the list which have the same id
     *
     * @param int $id
     * @return App\Models\MenuManage\MenuItem $menuItems
     */
    public function show($id)
    {
        try {
            $menuItems = DB::table('menu_items')
                ->join('item_prices', 'menu_items.id', '=', 'item_prices.menu_item_id')
                ->join('item_types', 'menu_items.item_type_id', '=', 'item_types.id')
                ->select('menu_items.*', 'item_types.*', 'item_prices.*')
                ->where('menu_items.id', $id)
                ->get();

            return $menuItems;
            // Closures include ->first(), ->get(), ->pluck(), etc.
        } catch (\Illuminate\Database\QueryException $ex) {
            return response()->view('errors/itemnotfound');
            // Note any method of class PDOException can be called on $ex.
        }
        // Eloquent use to join 3 tables together

    }
    /**
     * Add new item to the menu item and item price with this item
     * Add new size for the pizza
     *
     * @var App\Models\MenuManage\MenuItem $menuItem 
     * @var App\Models\MenuManage\ItemPrice $item_price
     */
    public function create(Request $request)
    {
        
        // Add a new menuitem to the database
        $menuItem = new MenuItem;
        $menuItem->name = $request['name'];
        $menuItem->description = $request['description'];
        $menuItem->item_type_id = $request['item_type_id'];
        $menuItem->save();
        //Add the default item price to the database
        $menuItem = DB::table('menu_items')->latest('id')->first();
        if (count($request['itemSizeList']) > 0) {
            for ($i = 0; $i < count($request['itemSizeList']); $i++) {

                //create a new one
                $item_price = new ItemPrice;
                $item_price->menu_item_id = $menuItem->id;
                $item_price->size = $request['itemSizeList'][$i]['size'];
                $item_price->price = $request['itemSizeList'][$i]['price'];
                $item_price->save();
            } // end for loop ($i = 0; $i < count($request['itemSizeList']); $i++)
        } //end if count > 0 
        else {
            $item_price = new ItemPrice;
            $item_price->menu_item_id = $menuItem->id;
            $item_price->size = 'Small';
            $item_price->price = '1.00';
            $item_price->save();
        } // end else
    }
    /**
     * add new item prices to the item list, help user to modify item price 
     *
     * @param int $id
     * @param  \Illuminate\Http\Request  $request
     * @var App\Models\MenuManage\ItemPrice $item_price
     * @var App\Models\MenuManage\Menuitem $menuItem
     */
    public function update(Request $request, $id)
    {
        //This for loop go through the request item list
        for ($i = 0; $i < count($request['itemSizeList']); $i++) {
            if ($request['itemSizeList'][$i]['id'] > 0) {
                //check if the id exist in the table, then update
                $item_price = ItemPrice::findOrFail($request['itemSizeList'][$i]['id']);
                $item_price->size = $request['itemSizeList'][$i]['size'];
                $item_price->price = $request['itemSizeList'][$i]['price'];
                $item_price->save();
            } //end if ($request['itemSizeList'][$i]['id'] > 0)
            else {
                //create a new one
                $item_price = new ItemPrice;
                $item_price->menu_item_id = $id;
                $item_price->size = $request['itemSizeList'][$i]['size'];
                $item_price->price = $request['itemSizeList'][$i]['price'];
                $item_price->save();
            }
        } // end for loop ($i = 0; $i < count($request['itemSizeList']); $i++)

        // Update the item information
        $menuItems = MenuItem::findOrFail($id);
        $menuItems->name = $request->name;
        $menuItems->description = $request->description;
        $menuItems->item_type_id = $request->item_type_id;

        $menuItems->save();
    }
    /**
     * This function delete the menu item which have the same id with id requested
     *
     * @var App\Models\MenuManage\ItemPrice $item_price
     * @var App\Models\MenuManage\Menuitem $menuItem
     * 
     * @return int success
     */

    public function delete($id)
    {
        $menuItems = MenuItem::findOrFail($id);
        $menuItems->delete();

        $itemPrices = ItemPrice::where('menu_item_id', $id)->delete();
    }

    /**
     * This function allow user to customize the pizza which have the same id with id requested
     * First check if the user signed in
     * Then check if there is an order open 
     * Last add new item to the order
     * @param int $id
     * @var array $data
     * 
     * @return array $data
     */
    public function customize($id)
    {   
        //This data will store all the information for the customize page
        $data = [];
        if (Auth::check()) {
            // if the user sign in
            $hasSignedIn = array('signin' => true);
            array_push($data, $hasSignedIn);
            //push user signin information to array
            $user_id = Auth::id();
            //check if there is a order existed
            $order = DB::table('orders')
                ->where('user_id', $user_id)
                ->where('order_status', 'On Editing')
                ->first();
            
            if (is_null($order)) {
                // if null create new order
                $order = new Order();
                $order->user_id = $user_id;
                date_default_timezone_set('America/Toronto');
                $timestamp = time();
                $date_time = date("Y-m-d H:i:s", $timestamp);
                $order->created_at = $date_time;
                $order->order_status = 'On Editing';
                $order->save();

            }
            // push order infor to the item list
            $order = DB::table('orders')
                ->where('user_id', $user_id)
                ->where('order_status', 'On Editing')
                ->first();
                
            // push the order item to the item list
            $order_item = new OrderItem();
            $order_item->order_id = $order->id;
            $order_item->item_price_id = $id;
            $order_item->save();
            // get the new order item
            $order_item_new = OrderItem::where('order_id', $order->id)->orderBy('id', 'desc')->first();
            
            array_push($data, $hasSignedIn);
            array_push($data, $order);
            array_push($data, array('order_item' => $order_item_new));
            return $data;
        } //end if (Auth::check())
        else {
            // if no, return false
            $hasSignedIn = array('signin' => false);
            array_push($data, $hasSignedIn);
            return $data;
        } //end else if (Auth::check())
    }
    /**
     * This function allow user to order new item from the homepage
     *
     *First check if the user signed in
     * Then check if there is an order open 
     * Last add new item to the order
     * @param Request $request
     * @var array $data
     * 
     * @return array $data
     */
    public function orderNew(Request $request)
    {
        //This data will store all the information for the information
        $data = [];
        if (Auth::check()) {
            // if the user sign in
            $hasSignedIn = array('signin' => true);
            array_push($data, $hasSignedIn);
            //push user signin information to array
            $user_id = Auth::id();
            //check if there is a order existed
            $order = DB::table('orders')
                ->where('user_id', $user_id)
                ->where('order_status', 'On Editing')
                ->first();

            if (is_null($order)) {
                // if null create a new one
                $order = new Order();
                $order->user_id = $user_id;
                date_default_timezone_set('America/Toronto');
                $timestamp = time();
                $date_time = date("Y-m-d H:i:s", $timestamp);
                $order->order_status = 'On Editing';
                $order->save();
            }
            // find the item that user need
            $item = DB::table('item_prices')
                ->where('menu_item_id', $request['id'])
                ->where('size', $request['size'])
                ->get();
            $order = DB::table('orders')
                ->where('user_id', $user_id)
                ->where('order_status', 'On Editing')
                ->first();
            //create new order item
            $order_item = new OrderItem();
            $order_item->order_id = $order->id;
            $order_item->item_price_id = $item[0]->id;
            $order_item->quantity = $request['quantity'];
            $order_item->save();
            $order_item_new = OrderItem::where('order_id', $order->id)->orderBy('id', 'desc')->first();
            // add and push
            array_push($data, $order);
            array_push($data, array('order_item' => $order_item_new));
            return $data;
        } else {
            // if no, return false
            $hasSignedIn = array('signin' => false);
            array_push($data, $hasSignedIn);
            return $data;
        }
        return $request;
    }
}
