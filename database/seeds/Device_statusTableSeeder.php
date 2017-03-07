<?php

use Illuminate\Database\Seeder;

class Device_statusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('device_status')->insert([
            'name' => 'Available',
            'image' => 'icon-available.png',
        ]);

        DB::table('device_status')->insert([
            'name' => 'Unavailable',
            'image' => 'icon-repair.png',
        ]);

        DB::table('device_status')->insert([
            'name' => 'Broken',
            'image' => 'icon-remove.png',
        ]);

        DB::table('device_status')->insert([
            'name' => 'Lost',
            'image' => 'icon-lost.png',
        ]);
    }
}
