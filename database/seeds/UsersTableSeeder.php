<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        DB::table('role_user')->truncate();

        $theadminRole = Role::where('name','admin')->first();
        $cashierRole = Role::where('name','cashier')->first();
        $customerRole = Role::where('name','customer')->first();

        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('adminadmin'),
            
        ]);
        $customer = User::create([
            'name' => 'customer',
            'email' => 'customer@customer.com',
            'password' => Hash::make('customercustomer'),
            
        ]);
        $cashier = User::create([
            'name' => 'cashier',
            'email' => 'cashier@cashier.com',
            'password' => Hash::make('cashiercashier'),
            
        ]);
        $admin->roles()->attach($theadminRole);
        $cashier->roles()->attach($cashierRole);
        $customer->roles()->attach($customerRole);
    }
}
