<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Complaint;
use App\Models\ComplaintAttachment;

class ComplaintAttachmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ComplaintAttachment::factory()->count(10)->create();
    }
}
