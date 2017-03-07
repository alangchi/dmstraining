<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name' => 'admin',
            'alias' => 'admin_master',
        ]);
        DB::table('roles')->insert([
            'name' => 'member',
            'alias' => 'user_member',
        ]);
        DB::table('roles')->insert([
            'name' => 'manager',
            'alias' => 'user_manager',
        ]);
    }
}
