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
        // DB::table('asset_statuses')->insert([
        // 	'name'=>'Good Condition'
        // ]);

        DB::table('roles')->insert([
        	'name'=>'admin'
        ]);
        DB::table('roles')->insert([
        	'name'=>'user'
        ]);

    }
}
