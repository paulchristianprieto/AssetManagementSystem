<?php

use Illuminate\Database\Seeder;

class StatusesTableSeeder extends Seeder
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

        DB::table('statuses')->insert([
        	'name'=>'Pending'
        ]);	
        DB::table('statuses')->insert([
        	'name'=>'Approved'
        ]);	
        DB::table('statuses')->insert([
        	'name'=>'Completed'
        ]);	
    }
}
