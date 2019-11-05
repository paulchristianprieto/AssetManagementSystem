<?php

use Illuminate\Database\Seeder;

class VendorsTableSeeder extends Seeder
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

        DB::table('vendors')->insert([
        	'name'=> 'HP',
        	'vendor_sku' => 'HP',
        	'address' => 'Intellectual Property Center, Upper Mc Kinley Road, ,McKinley Hill Cyberpark, Taguig, 1634 Metro Manila',
        	'company_email' => 'helpdesk@hp.com',
        	'description' => "At HP we don't just believe in the power of technology. We believe in the power of people when technology works for them."
        ]);
    }
}
