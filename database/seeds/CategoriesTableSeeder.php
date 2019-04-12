<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            [
                'name' => 'Supermarket',
                'color_hex' => '467BFB',
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'Drugstore',
                'color_hex' => '63A64E',
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'Lunch',
                'color_hex' => 'EEBF2E',
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'Coffee',
                'color_hex' => '5C9FB3',
                'created_at' => Carbon::now()
            ]
        ]);
    }
}
