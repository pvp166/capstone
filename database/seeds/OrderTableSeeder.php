<?php

use Illuminate\Database\Seeder;
use App\Models\OrderManage\Order;

class OrderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Order::truncate();
        Order::create([
            'user_id' => '1',
            'created_at' => '2020-08-06 16:20:22',
            'updated_at' => '2020-08-06 16:35:22',
            'order_status' => 'Finish',
            
        ]);
        Order::create([
            'user_id' => '1',
            'created_at' => '2020-08-06 16:20:22',
            'order_status' => 'On Editing',
            
        ]);
        
        Order::create([
            'user_id' => '3',
            'created_at' => '2020-08-09 16:20:22',
            'order_status' => 'On Working',
        ]);
        Order::create([
            'user_id' => '2',
            'created_at' => '2020-08-06 16:20:22',
            'updated_at' => '2020-08-06 16:35:22',
            'order_status' => 'Finish',
            
        ]);
        Order::create([
            'user_id' => '2',
            'created_at' => '2020-08-06 16:20:22',
            'updated_at' => '2020-08-06 16:35:22',
            'order_status' => 'Finish',
            
        ]);
        Order::create([
            'user_id' => '1',
            'created_at' => '2020-09-06 16:20:22',
            'updated_at' => '2020-09-06 16:35:22',
            'order_status' => 'Finish',
        ]);
        Order::create([
            'user_id' => '1',
            'created_at' => '2020-09-07 16:20:22',
            'updated_at' => '2020-09-07 16:35:22',
            'order_status' => 'Finish',
        ]);
        Order::create([
            'user_id' => '2',
            'created_at' => '2020-09-07 16:20:22',
            'order_status' => 'On Editing',
        ]);
    }
}
