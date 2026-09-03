<?php

namespace Database\Seeders;

use App\Models\EvidenceCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EvidenceCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Physical Evidence',
                'description' => 'Barang bukti fisik yang ditemukan atau disita.',
            ],
            [
                'name' => 'Digital Evidence',
                'description' => 'Barang bukti berupa perangkat atau data digital.',
            ],
            [
                'name' => 'Document Evidence',
                'description' => 'Barang bukti berupa dokumen atau arsip.',
            ],
            [
                'name' => 'Biological Evidence',
                'description' => 'Barang bukti biologis yang berkaitan dengan pemeriksaan.',
            ],
            [
                'name' => 'Photo / Video Evidence',
                'description' => 'Barang bukti berupa foto atau rekaman video.',
            ],
        ];

        foreach ($categories as $category) {
            EvidenceCategory::updateOrCreate(
                [
                    'name' => $category['name'],
                ],
                [
                    'description' => $category['description'],
                ]
            );
        }
    }
}
