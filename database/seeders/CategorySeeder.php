<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run()
    {
        DB::table('categories')->insert([
            ['name' => 'Italian'],
            ['name' => 'Chinese'],
            ['name' => 'Mexican'],
            ['name' => 'Indian'],
            ['name' => 'Asian'],
        ]);
    }
}
