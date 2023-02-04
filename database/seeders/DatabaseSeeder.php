<?php

namespace Database\Seeders;

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
        $this->call(RoleSeeder::class);
        $this->call(DivisionSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(AssetCategorySeeder::class);
        $this->call(AssetSeeder::class);
        $this->call(AssetLocationSeeder::class);
        $this->call(PageSeeder::class);
        $this->call(RolePageMappingSeeder::class);
        $this->call(RequestSeeder::class);
        $this->call(BookingSeeder::class);
        $this->call(LocationSeeder::class);
    }
}
