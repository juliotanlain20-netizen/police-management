<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $permissions = [

            // =========================
            // COMPLAINT
            // =========================
            [
                'name' => 'View All Complaints',
                'slug' => 'complaint.view_all',
                'description' => 'Melihat complaint milik pengguna lain',
            ],
            [
                'name' => 'Request More Evidence',
                'slug' => 'complaint.request_more_evidence',
                'description' => 'Meminta bukti tambahan pada complaint',
            ],
            [
                'name' => 'Reject Complaint',
                'slug' => 'complaint.reject',
                'description' => 'Menolak complaint yang masih Pending',
            ],

            // =========================
            // INVESTIGATION CASE
            // =========================
            [
                'name' => 'Create Investigation Case',
                'slug' => 'case.create',
                'description' => 'Mengubah complaint menjadi investigation case',
            ],
            [
                'name' => 'View All Investigation Cases',
                'slug' => 'case.view_all',
                'description' => 'Melihat seluruh investigation case',
            ],
            [
                'name' => 'Update Investigation Case',
                'slug' => 'case.update',
                'description' => 'Mengubah data dan status investigation case',
            ],
            [
                'name' => 'Assign Officer',
                'slug' => 'case.assign_officer',
                'description' => 'Mengatur penugasan police officer pada investigation case',
            ],

            // =========================
            // POLICE
            // =========================
            [
                'name' => 'View All Police',
                'slug' => 'police.view_all',
                'description' => 'Melihat seluruh daftar police officer',
            ],

            // =========================
            // EVIDENCE
            // =========================
            [
                'name' => 'View Evidence',
                'slug' => 'evidence.view',
                'description' => 'Melihat evidence, attachment, dan history evidence',
            ],
            [
                'name' => 'Create Evidence',
                'slug' => 'evidence.create',
                'description' => 'Menambahkan evidence ke investigation case',
            ],
            [
                'name' => 'Update Evidence',
                'slug' => 'evidence.update',
                'description' => 'Mengubah data, status, dan lokasi evidence',
            ],
            [
                'name' => 'Void Evidence',
                'slug' => 'evidence.void',
                'description' => 'Menandai record evidence sebagai Voided',
            ],
            [
                'name' => 'Manage Evidence Attachments',
                'slug' => 'evidence.manage_attachment',
                'description' => 'Menambah dan menghapus attachment evidence',
            ],

            // =========================
            // SUSPECT
            // =========================
            [
                'name' => 'View Suspect',
                'slug' => 'suspect.view',
                'description' => 'Melihat data suspect pada investigation case',
            ],
            [
                'name' => 'Create Suspect',
                'slug' => 'suspect.create',
                'description' => 'Menambahkan suspect ke investigation case',
            ],
            [
                'name' => 'Update Suspect',
                'slug' => 'suspect.update',
                'description' => 'Mengubah data dan status suspect',
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                [
                    'slug' => $permission['slug'],
                ],
                [
                    'name' => $permission['name'],
                    'description' => $permission['description'],
                ]
            );
        }
    }
}
