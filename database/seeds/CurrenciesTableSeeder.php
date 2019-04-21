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
                'locale' => 'es-CL',
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'Dollars',
                'code' => 'USD',
                'locale' => 'en-US',
                'created_at' => Carbon::now()
            ],
        ]);
    }
}
