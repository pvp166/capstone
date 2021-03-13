<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Role;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role_user')->insert([
            'id' => 4,
            'role_id' => 1,
            'user_id' => 1,
            'created_at'=> null,
            'updated_at'=> null,
        ]);
    }
}
