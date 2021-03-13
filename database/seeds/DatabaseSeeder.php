<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {   
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(AddressTableSeeder::class);
        $this->call(OrderTableSeeder::class);
        $this->call(OrderItemsTableSeeder::class);
        $this->call(MenuItemTableSeeder::class);
        $this->call(ItemTypeTableSeeder::class);
        $this->call(ItemPriceSeeder::class);
        $this->call(CustomizePizzaSeeder::class);
        
    }
}
