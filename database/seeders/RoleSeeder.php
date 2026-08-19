<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles=[
            ['name'=>'citizen','description'=>'masyarakat/warga biasa'],
            ['name'=>'police','description'=>'polisi/investigator'],
            ['name'=>'author','description'=>'penulis berita'],
            ['name'=>'admin','description'=>'mengurus role,permission, dll'],
        ];
        Role::insert($roles);
    }
}
