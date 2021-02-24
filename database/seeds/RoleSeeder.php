<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'id' => config('roles.manager'),
            'role' => "Manager",
        ]);

        DB::table('roles')->insert([
            'id' => config('roles.cashier'),
            'role' => "Cashier",
        ]);

        DB::table('roles')->insert([
            'id' => config('roles.kitchen'),
            'role' => "Kitchen",
        ]);
    }
}
