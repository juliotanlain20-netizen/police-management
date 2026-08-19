<?php

namespace Database\Factories;

use App\Models\ComplaintAttachment;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Complaint;
/**
 * @extends Factory<ComplaintAttachment>
 */
class ComplaintAttachmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        'complaint_id' => Complaint::inRandomOrder()->value('id'),
        'file_name'=>fake()->word().'.jpg',
        'file_path'=>'complaints/'.fake()->uuid().'.jpg',
        // 'mime_type' => fake()=>randomElement(['image/jpeg','image/png','application/pdf',]),
        'mime_type' => fake()->randomElement(['image/jpeg','image/png','application/pdf',]),
        'file_size'=>fake()->numberBetween(10000,50000),
        'uploaded_at'=>fake()->dateTimeBetween('-1 month','now')
        ];
    }
}
