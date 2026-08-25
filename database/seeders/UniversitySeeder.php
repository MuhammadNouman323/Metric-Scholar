<?php

namespace Database\Seeders;

use App\Models\University;
use Illuminate\Database\Seeder;

class UniversitySeeder extends Seeder
{
    /**
     * Universities eligible for admin self-registration.
     * A registration email's domain must match one of these domains (case-insensitive).
     */
    public function run(): void
    {
        $universities = [
            ['name' => 'Virtual University of Pakistan', 'domain' => 'vu.edu.pk'],
            ['name' => 'Punjab University', 'domain' => 'pu.edu.pk'],
        ];

        foreach ($universities as $university) {
            University::query()->firstOrCreate(
                ['domain' => $university['domain']],
                ['name' => $university['name']]
            );
        }
    }
}
