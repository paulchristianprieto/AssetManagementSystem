<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        $this->call([
        	AssetStatusesTableSeeder::class,
        	CategoriesTableSeeder::class,
        	RolesTableSeeder::class,
        	StatusesTableSeeder::class,
            VendorsTableSeeder::class
        ]);
    }
}
