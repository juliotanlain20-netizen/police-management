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
        $permissions=[
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
        ];
        //biar tidak double saat di jalankan ulang
        foreach($permissions as $permission){
            Permission::updateOrCreate(
                ['slug'=>$permission['slug']],
                $permission
            );
        }

    }
}
