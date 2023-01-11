<?php

namespace Database\Seeders;

use App\Models\Request;
use Illuminate\Database\Seeder;

class RequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Request::create([
            'book_date' => '2022-12-24 07:00:00',
            'return_date' => '2022-12-25 07:00:00',
            'purpose' => 'Tugas LAB',
            'lokasi' => 'Jl. Everywhere No.110',
            'user_id' => 1
        ]);
    }
}
