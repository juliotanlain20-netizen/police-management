<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Role_userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->firstOrFail();
        $policeRole = Role::where('name', 'police')->firstOrFail();
        $authorRole = Role::where('name', 'author')->firstOrFail();
        $citizenRole = Role::where('name', 'citizen')->firstOrFail();

        $users = User::orderBy('id')->get();

        $users[0]->roles()->sync([$adminRole->id]);
        $users[1]->roles()->sync([$policeRole->id]);
        $users[2]->roles()->sync([$policeRole->id]);
        $users[3]->roles()->sync([$authorRole->id]);

        foreach ($users->slice(4) as $user) {
            $user->roles()->sync([$citizenRole->id]);
        }
    }
}
