<?php

use Illuminate\Database\Seeder;
use App\Models\OrderManage\OrderItem;
class OrderItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Seed for the order item
        OrderItem::create([
            'order_id' => 1,
            'item_price_id' => 1,
            'quantity' => 2,
        ]);
        OrderItem::create([
            'order_id' => 1,
            'item_price_id' => 2,
            'comments' => 'The pizza was salty',
            'quantity' => 1,
        ]);
        OrderItem::create([
            'order_id' => 1,
            'item_price_id' => 10,
            'quantity' => 3,
            'comments' => 'They should be more creepy',
        ]);
        OrderItem::create([
            'order_id' => 2,
            'item_price_id' => 1,
            'comments' => 'Dont put too much cheese on it',
            'quantity' => 2,
        ]);
        OrderItem::create([
            'order_id' => 2,
            'item_price_id' => 3,
            'quantity' => 1,
            'comments' => 'Perfect',
        ]);
        OrderItem::create([
            'item_price_id' => 4,
            'order_id' => 2,
            'quantity' => 2,
        ]);
        OrderItem::create([
            'item_price_id' => 5,
            'order_id' => 5,   
            'quantity' => 2,
        ]);
        OrderItem::create([
            'item_price_id' => 6,
            'order_id' => 5,   
        ]);
        OrderItem::create([
            'item_price_id' => 6,
            'order_id' => 5,   
            'quantity' => 1,
        ]);
        OrderItem::create([
            'item_price_id' => 1,
            'order_id' => 5,   
        ]);
        OrderItem::create([
            'item_price_id' => 2,
            'order_id' => 6,   
        ]);
        OrderItem::create([
            'item_price_id' => 3,
            'order_id' => 6, 
            'quantity' => 2,  
        ]);
        OrderItem::create([
            'order_id' => 3,
            'item_price_id' => 2,
            'quantity' => 2,
            'comments' => 'Perfect',
        ]);
        OrderItem::create([
            'order_id' => 3,
            'item_price_id' => 3, 
            'comments' => 'Perfect',
            'quantity' => 3,
        ]);
        OrderItem::create([
            'order_id' => 3,
            'item_price_id' => 7,
            
            'comments' => 'Perfect',
        ]);
        OrderItem::create([
            'order_id' => 4,
            'item_price_id' => 7,
            'comments' => 'Perfect',
        ]);
        OrderItem::create([
            'item_price_id' => 1,
            'order_id' => 7,   
            'quantity' => 1,
        ]);
        OrderItem::create([
            'item_price_id' => 2,
            'order_id' => 8,   
            'quantity' => 1,
        ]);
        OrderItem::create([
            'item_price_id' => 3,
            'order_id' => 8,   
            'quantity' => 2,
        ]);
        
    }
}
