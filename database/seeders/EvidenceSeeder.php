<?php

namespace Database\Seeders;

use App\Models\Evidence;
use App\Models\EvidenceCategory;
use App\Models\InvestigationCase;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EvidenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cases = InvestigationCase::all();

        if ($cases->isEmpty()) {
            $this->command->warn(
                'EvidenceSeeder dilewati karena belum ada InvestigationCase.'
            );

            return;
        }

        $physical = EvidenceCategory::where(
            'name',
            'Physical Evidence'
        )->firstOrFail();

        $digital = EvidenceCategory::where(
            'name',
            'Digital Evidence'
        )->firstOrFail();

        Evidence::updateOrCreate(
            [
                'evidence_code' => 'EVD-001',
            ],
            [
                'investigation_case_id' => $cases->first()->id,
                'evidence_category_id' => $physical->id,
                'name' => 'Tas Hitam',
                'description' => 'Barang bukti fisik untuk testing.',
                'storage_location' => 'Evidence Room A-01',
                'status' => 'Stored',
            ]
        );

        Evidence::updateOrCreate(
            [
                'evidence_code' => 'EVD-002',
            ],
            [
                'investigation_case_id' => $cases->first()->id,
                'evidence_category_id' => $digital->id,
                'name' => 'Smartphone',
                'description' => 'Perangkat digital untuk testing.',
                'storage_location' => 'Digital Evidence Locker D-01',
                'status' => 'Stored',
            ]
        );
    }
}
