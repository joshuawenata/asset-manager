<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Page::create([
            'name' => 'dashboard/student'
        ]);

        Page::create([
            'name' => 'dashboard/admin'
        ]);

        Page::create([
            'name' => 'superadmin/home'
        ]);

        Page::create([
            'name' => 'dashboard/approver'
        ]);
    }
}
