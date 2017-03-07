<?php

use Illuminate\Database\Seeder;

class History_statusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('history_status')->insert([
            'name' => 'Requesting',
            'image'=> 'icon-request.png',
        ]);

        DB::table('history_status')->insert([
            'name' => 'Borrowed',
            'image'=> 'icon-unavailable.png',
        ]);

        DB::table('history_status')->insert([
            'name' => 'Warning',
            'image'=> 'icon-warning.png',
        ]);

        DB::table('history_status')->insert([
            'name' => 'Returned',
            'image'=> 'icon-available.png',
        ]);

        DB::table('history_status')->insert([
            'name' => 'Lost',
            'image'=> 'icon-lost.png',
        ]);

        DB::table('history_status')->insert([
            'name' => 'Canceled',
            'image'=> 'icon-remove.png',
        ]);
    }
}
