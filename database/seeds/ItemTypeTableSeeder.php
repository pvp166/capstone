<?php

use Illuminate\Database\Seeder;
use App\Models\MenuManage\ItemType;
class ItemTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Seed for the item type
        ItemType::truncate();
        ItemType::create(['type'=>'Meat Favorites']);
        ItemType::create(['type'=>'Veggie Favorties']);
        ItemType::create(['type'=>'Sides']);
        ItemType::create(['type'=>'Salad']);
        ItemType::create(['type'=>'Drinks']);
        ItemType::create(['type'=>'Dip']);
        ItemType::create(['type'=>'Pizza Dough']);
        ItemType::create(['type'=>'Topping']);
    }
}
