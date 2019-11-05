<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('asset_statuses')->insert([
        // 	'name'=>'Good Condition'
        // ]);

        DB::table('categories')->insert([
        	'name'=>'Laptop',
        	'category_sku' => 'LTP',
        	'description' => 'Each laptop have different specifications. Please include the specification that you need.'
        ]);
        DB::table('categories')->insert([
        	'name'=>'Projector',
        	'category_sku' => 'PJR'
        ]);
        DB::table('categories')->insert([
        	'name'=>'Keyboard',
        	'category_sku' => 'KYB'
        ]);
        DB::table('categories')->insert([
        	'name'=>'Mouse',
        	'category_sku' => 'MOS'
        ]);
        DB::table('categories')->insert([
        	'name'=>'Monitor',
        	'category_sku' => 'MON'
        ]);
        DB::table('categories')->insert([
        	'name'=>'CPU',
        	'category_sku' => 'CPU'
        ]);

    }
}
