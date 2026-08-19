<?php

namespace Database\Factories;

use App\Models\Complaint;
use App\Models\ComplaintCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Complaint>
 */
class ComplaintFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'=>User::inRandomOrder()->value('id'),
            'category_id'=>ComplaintCategory::inRandomOrder()->value('id'),
            'title'=>fake()->sentence(5),
            'description'=>fake()->sentence(),
            'location'=>fake()->address(),
            'incident_date'=>fake()->dateTime(),
            'status'=>fake()->randomElement(['Draft','Pending','Need More Evidence','Approved','Rejected']),
        ];
    }
}
