<?php
use Illuminate\Database\Seeder;
use App\Models\MenuManage\ItemPrice;
class ItemPriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Seed for the item price
        ItemPrice::create([
            'menu_item_id' => 1,
            'size' => 'Small',
            'price' => 13.29
        ]);
        ItemPrice::create([
            'menu_item_id' => 1,
            'size' => 'Medium',
            'price' => 15.29
        ]);
        ItemPrice::create([
            'menu_item_id' => 1,
            'size' => 'Large',
            'price' => 17.99
        ]);
        ItemPrice::create([
            'menu_item_id' => 1,
            'size' => 'X-Large',
            'price' => 21.49
        ]);
        ItemPrice::create([
            'menu_item_id' => 2,
            'size' => 'Small',
            'price' => 12.29
        ]);
        ItemPrice::create([
            'menu_item_id' => 2,
            'size' => 'Medium',
            'price' => 14.29
        ]);
        ItemPrice::create([
            'menu_item_id' => 2,
            'size' => 'Large',
            'price' => 16.99
        ]);
        ItemPrice::create([
            'menu_item_id' => 2,
            'size' => 'X-Large',
            'price' => 20.49
        ]);
        ItemPrice::create([
            'menu_item_id' => 3,
            'size' => 'Small',
            'price' => 13.29
        ]);
        ItemPrice::create([
            'menu_item_id' => 3,
            'size' => 'Medium',
            'price' => 15.29
        ]);
        ItemPrice::create([
            'menu_item_id' => 3,
            'size' => 'Large',
            'price' => 18.99
        ]);
        ItemPrice::create([
            'menu_item_id' => 3,
            'size' => 'X-Large',
            'price' => 22.49
        ]);
        ItemPrice::create([
            'menu_item_id' => 4,
            'size' => 'Small',
            'price' => 10.29
        ]);
        ItemPrice::create([
            'menu_item_id' => 4,
            'size' => 'Medium',
            'price' => 12.29
        ]);
        ItemPrice::create([
            'menu_item_id' => 4,
            'size' => 'Large',
            'price' => 14.99
        ]);
        ItemPrice::create([
            'menu_item_id' => 4,
            'size' => 'X-Large',
            'price' => 16.49
        ]);
        ItemPrice::create([
            'menu_item_id' => 5,
            'size' => 'Small',
            'price' => 13.29
        ]);
        ItemPrice::create([
            'menu_item_id' => 5,
            'size' => 'Medium',
            'price' => 15.29
        ]);
        ItemPrice::create([
            'menu_item_id' => 5,
            'size' => 'Large',
            'price' => 17.99
        ]);
        ItemPrice::create([
            'menu_item_id' => 5,
            'size' => 'X-Large',
            'price' => 20.49
        ]);
        ItemPrice::create([
            'menu_item_id' => 6,
            'size' => 'Small',
            'price' => 14.29
        ]);
        ItemPrice::create([
            'menu_item_id' => 6,
            'size' => 'Medium',
            'price' => 17.29
        ]);
        ItemPrice::create([
            'menu_item_id' => 6,
            'size' => 'Large',
            'price' => 19.89
        ]);
        ItemPrice::create([
            'menu_item_id' => 6,
            'size' => 'X-Large',
            'price' => 24.49
        ]);
        ItemPrice::create([
            'menu_item_id' => 7,
            'size' => '6 Wings',
            'price' => 6.29
        ]);
        
        ItemPrice::create([
            'menu_item_id' => 7,
            'size' => '10 Wings',
            'price' => 9.89
        ]);
        ItemPrice::create([
            'menu_item_id' => 7,
            'size' => '20 Wings',
            'price' => 18
        ]);
        ItemPrice::create([
            'menu_item_id' => 8,
            'size' => '1 Medium Bow',
            'price' => 7.29
        ]);
        ItemPrice::create([
            'menu_item_id' => 9,
            'size' => '1 Medium Bow',
            'price' => 7.29
        ]);

        ItemPrice::create([
            'menu_item_id' => 10,
            'size' => '1 Medium Bow',
            'price' => 7.29
        ]);
        ItemPrice::create([
            'menu_item_id' => 11,
            'size' => '1 Medium Bow',
            'price' => 7.29
        ]);
        ItemPrice::create([
            'menu_item_id' => 12,
            'size' => '1 Pop Can',
            'price' => 1.29
        ]);
        ItemPrice::create([
            'menu_item_id' => 12,
            'size' => '3 Pop Can',
            'price' => 3.49
        ]);
        ItemPrice::create([
            'menu_item_id' => 12,
            'size' => '6 Pop Can',
            'price' => 4.49
        ]);
        ItemPrice::create([
            'menu_item_id' => 13,
            'size' => '1 Small Dip',
            'price' => 0.5
        ]);
        ItemPrice::create([
            'menu_item_id' => 14,
            'size' => 'Small',
            'price' => 7.99
        ]);
        ItemPrice::create([
            'menu_item_id' => 14,
            'size' => 'Medium',
            'price' => 9.49
        ]);
        ItemPrice::create([
            'menu_item_id' => 14,
            'size' => 'Large',
            'price' => 11.99
        ]);
        ItemPrice::create([
            'menu_item_id' => 14,
            'size' => 'X-Large',
            'price' => 14.19
        ]);
        ItemPrice::create([
            'menu_item_id' => 15,
            'size' => 'Small',
            'price' => 7.99
        ]);
        ItemPrice::create([
            'menu_item_id' => 15,
            'size' => 'Medium',
            'price' => 9.49
        ]);
        ItemPrice::create([
            'menu_item_id' => 15,
            'size' => 'Large',
            'price' => 11.99
        ]);
        ItemPrice::create([
            'menu_item_id' => 15,
            'size' => 'X-Large',
            'price' => 14.99
        ]);
        ItemPrice::create([
            'menu_item_id' => 16,
            'size' => 'Small',
            'price' => 7.99
        ]);
        ItemPrice::create([
            'menu_item_id' => 16,
            'size' => 'Medium',
            'price' => 9.49
        ]);
        ItemPrice::create([
            'menu_item_id' => 16,
            'size' => 'Large',
            'price' => 11.99
        ]);
        ItemPrice::create([
            'menu_item_id' => 16,
            'size' => 'X-Large',
            'price' => 14.99
        ]);
        ItemPrice::create([
            'menu_item_id' => 17,
            'size' => 'Small',
            'price' => 1.5
        ]);
        ItemPrice::create([
            'menu_item_id' => 17,
            'size' => 'Medium',
            'price' => 1.7
        ]);
        ItemPrice::create([
            'menu_item_id' => 17,
            'size' => 'Large',
            'price' => 2.0
        ]);
        ItemPrice::create([
            'menu_item_id' => 17,
            'size' => 'X-Large',
            'price' => 2.3
        ]);
        ItemPrice::create([
            'menu_item_id' => 18,
            'size' => 'Small',
            'price' => 1.5
        ]);
        ItemPrice::create([
            'menu_item_id' => 18,
            'size' => 'Medium',
            'price' => 1.7
        ]);
        ItemPrice::create([
            'menu_item_id' => 18,
            'size' => 'Large',
            'price' => 2.0
        ]);
        ItemPrice::create([
            'menu_item_id' => 18,
            'size' => 'X-Large',
            'price' => 2.3
        ]);
        ItemPrice::create([
            'menu_item_id' => 19,
            'size' => 'Small',
            'price' => 1.5
        ]);
        ItemPrice::create([
            'menu_item_id' => 19,
            'size' => 'Medium',
            'price' => 1.7
        ]);
        ItemPrice::create([
            'menu_item_id' => 19,
            'size' => 'Large',
            'price' => 2.0
        ]);
        ItemPrice::create([
            'menu_item_id' => 19,
            'size' => 'X-Large',
            'price' => 2.3
        ]);
        ItemPrice::create([
            'menu_item_id' => 20,
            'size' => 'Small',
            'price' => 1.5
        ]);
        ItemPrice::create([
            'menu_item_id' => 20,
            'size' => 'Medium',
            'price' => 1.7
        ]);
        ItemPrice::create([
            'menu_item_id' => 20,
            'size' => 'Large',
            'price' => 2.0
        ]);
        ItemPrice::create([
            'menu_item_id' => 20,
            'size' => 'X-Large',
            'price' => 2.3
        ]);
        ItemPrice::create([
            'menu_item_id' => 21,
            'size' => 'Small',
            'price' => 1.5
        ]);
        ItemPrice::create([
            'menu_item_id' => 21,
            'size' => 'Medium',
            'price' => 1.7
        ]);
        ItemPrice::create([
            'menu_item_id' => 21,
            'size' => 'Large',
            'price' => 2.0
        ]);
        ItemPrice::create([
            'menu_item_id' => 21,
            'size' => 'X-Large',
            'price' => 2.3
        ]);
    
    }
}
