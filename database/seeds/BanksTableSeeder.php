<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class BanksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('banks')->insert([
            'name' => 'Scotiabank',
            'created_at' => Carbon::now()
        ]);
    }
}
