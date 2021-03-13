<?php
use App\Models\CustomerManage\Address;
use Illuminate\Database\Seeder;

class AddressTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Factory for the address
        Address::create([
            'full_name' => 'Drocula',
            'address_line_1' => '17th West1st',
            'city' => 'Hamilton',
            'province' => 'Ontario',
            'customer_phone' => '289-466-1516',
            'postal_code' => 'L1T 3C9',
            'user_id' => 1
        ]);
        Address::create([
            'full_name' => 'Crazy N',
            'address_line_1' => '177th Queenston',
            'city' => 'Hamilton',
            'province' => 'Ontario',
            'customer_phone' => '289-466-1516',
            'postal_code' => 'L2F 3C9',
            'user_id' => 2
        ]);
    }
}
