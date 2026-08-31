<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Unit::insert([
            [
                'name' => 'Reserse Kriminal',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Intelijen',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Patroli',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
