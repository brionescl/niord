<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class CurrenciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('currencies')->insert([
            [
                'name' => 'Pesos',
                'code' => 'CLP',
                'symbol' => '$',
                'decimals' => 0,
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'Dollars',
                'code' => 'USD',
                'symbol' => '$',
                'decimals' => 2,
                'created_at' => Carbon::now()
            ],
        ]);
    }
}
