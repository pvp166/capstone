<?php
use App\Models\OrderManage\CustomizePizza;
use Illuminate\Database\Seeder;

class CustomizePizzaSeeder extends Seeder
{
        /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Factory for the address
        CustomizePizza::create([
            'order_item_id' => 1,
            'item_price_id' => 63,
            'quantity' => '2',
        ]);
        CustomizePizza::create([
            'order_item_id' => 2,
            'item_price_id' => 63,
            'quantity' => '1',
        ]);
        CustomizePizza::create([
            'order_item_id' => 3,
            'item_price_id' => 63,
            'quantity' => '3',
        ]);
        CustomizePizza::create([
            'order_item_id' => 4,
            'item_price_id' => 63,
            'quantity' => '1',
        ]);
        CustomizePizza::create([
            'order_item_id' => 5,
            'item_price_id' => 63,
            'quantity' => '2',
        ]);
        CustomizePizza::create([
            'order_item_id' => 6,
            'item_price_id' => 63,
            'quantity' => '1',
        ]);
        CustomizePizza::create([
            'item_price_id' => 63,
            'order_item_id' => 7,
            'quantity' => '2',
        ]);
        CustomizePizza::create([
            'item_price_id' => 63,
            'order_item_id' => 8,
            'quantity' => '1',
        ]);
        CustomizePizza::create([
            'item_price_id' => 63,
            'order_item_id' => 9,
            'quantity' => '3',
        ]);
        CustomizePizza::create([
            'item_price_id' => 63,
            'order_item_id' => 10,
            'quantity' => '1',
        ]);
        CustomizePizza::create([
            'item_price_id' => 63,
            'order_item_id' => 11,
            'quantity' => '2',
        ]);
        CustomizePizza::create([
            'item_price_id' => 63,
            'order_item_id' => 12,
            'quantity' => '3',
        ]);
        CustomizePizza::create([
            'order_item_id' => 13,
            'item_price_id' => 63,
            'quantity' => '2',
        ]);
        CustomizePizza::create([
            'order_item_id' => 14,
            'item_price_id' => 63,
            'quantity' => '2',
        ]);
        CustomizePizza::create([
            'order_item_id' => 15,
            'item_price_id' => 63,
            'quantity' => '1',
        ]);
        CustomizePizza::create([
            'order_item_id' => 16,
            'item_price_id' => 63,
            'quantity' => '3',
        ]);
    }
    
}
