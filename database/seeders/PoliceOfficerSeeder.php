<?php

namespace Database\Seeders;

use App\Models\PoliceOfficer;
use App\Models\Rank;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PoliceOfficerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $policeUsers = User::whereHas('roles', function ($query) {
            $query->where('roles.name', 'police');
        })->get();

        $ranks = Rank::all();
        $units = Unit::all();

        foreach ($policeUsers as $user) {
            PoliceOfficer::updateOrCreate(
                [
                    'user_id' => $user->id,
                ],
                [
                    'rank_id' => $ranks->random()->id,
                    'unit_id' => $units->random()->id,
                    'nrp' => 'NRP-' . str_pad($user->id, 6, '0', STR_PAD_LEFT),
                    'phone' => $user->phone,
                    'address' => fake()->address(),
                    'status' => 'Active',
                ]
            );
        }
    }
}
