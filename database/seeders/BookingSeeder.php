<?php

namespace Database\Seeders;

use App\Models\Booking;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Booking::create([
            'request_id' => 1,
            'asset_id' => 1,
            'asset_category_id' => 1,
        ]);

        Booking::create([
            'request_id' => 1,
            'asset_id' => 2,
            'asset_category_id' => 3,
        ]);
    }
}
