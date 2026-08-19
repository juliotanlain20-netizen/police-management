<?php

namespace Database\Seeders;

use App\Models\Rank;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ranks = [
            ['name' => 'Bripda', 'description' => 'Brigadir Polisi Dua'],
            ['name' => 'Briptu', 'description' => 'Brigadir Polisi Satu'],
            ['name' => 'Brigadir', 'description' => 'Brigadir Polisi'],
            ['name' => 'Bripka', 'description' => 'Brigadir Polisi Kepala'],
            ['name' => 'Aipda', 'description' => 'Ajun Inspektur Polisi Dua'],
            ['name' => 'Aiptu', 'description' => 'Ajun Inspektur Polisi Satu'],
            ['name' => 'Ipda', 'description' => 'Inspektur Polisi Dua'],
            ['name' => 'Iptu', 'description' => 'Inspektur Polisi Satu'],
            ['name' => 'AKP', 'description' => 'Ajun Komisaris Polisi'],
            ['name' => 'Kompol', 'description' => 'Komisaris Polisi'],
        ];
        Rank::insert($ranks);
    }
}
