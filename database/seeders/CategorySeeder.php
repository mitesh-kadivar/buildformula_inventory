<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name'       => 'Car',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name'       => 'Mobile',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name'       => 'Software/Hardware',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
