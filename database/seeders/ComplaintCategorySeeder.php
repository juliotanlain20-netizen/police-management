<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ComplaintCategory;

class ComplaintCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category=[
            ['name'=>'pencurian','description'=>'Kehilangan barang karena dicuri'],
            ['name'=>'Penipuan','description'=>'Penipuan online/offline, transaksi palsu'],
            ['name'=>'Kekerasan','description'=>'Penganiayaan atau kekerasan fisik'],
            ['name'=>'Perusakan','description'=>'Perusakan barang/properti'],
            ['name'=>'Ancaman','description'=>'Ancaman atau intimidasi'],
            ['name'=>'Kejahatan Siber','description'=>'Peretasan, akun dibajak, penipuan digital tertentu'],
            ['name'=>'Kehilangan','description'=>'Laporan barang/dokumen hilang'],
            ['name'=>'Lainnya','description'=>'Pengaduan yang tidak cocok dengan kategori lain'],
        ];//lewat model
        ComplaintCategory::insert($category);
    }
}
