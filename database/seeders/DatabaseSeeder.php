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
        $this->call(DivisionSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(AssetCategorySeeder::class);
        $this->call(AssetSeeder::class);
        $this->call(PageSeeder::class);
        $this->call(RolePageMappingSeeder::class);
        $this->call(RequestSeeder::class);
        $this->call(BookingSeeder::class);
    }
}
