<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 students with @vu.edu.pk domain
        $students = [];
        for ($i = 1; $i <= 10; $i++) {
            $students[] = User::create([
                'name' => fake()->name(),
                'email' => 'student'.str_pad($i, 2, '0', STR_PAD_LEFT).'@vu.edu.pk',
                'password' => Hash::make('123456789'),
                'role' => 'student',
                'email_verified_at' => now(),
                'is_active' => true,
            ]);
        }

        // Create 3 faculty with @vu.edu.pk domain
        $faculty = [];
        for ($i = 1; $i <= 3; $i++) {
            $faculty[] = User::create([
                'name' => fake()->name(),
                'email' => 'faculty'.str_pad($i, 2, '0', STR_PAD_LEFT).'@vu.edu.pk',
                'password' => Hash::make('123456789'),
                'role' => 'faculty',
                'department' => 'Computer Science',
                'email_verified_at' => now(),
                'is_active' => true,
            ]);
        }

        // Create 20 courses in Computer Science department
        $courses = [];
        for ($i = 1; $i <= 20; $i++) {
            $courses[] = Course::create([
                'title' => 'CS Course '.str_pad($i, 2, '0', STR_PAD_LEFT),
                'code' => 'CS'.str_pad($i, 3, '0', STR_PAD_LEFT),
                'semester' => $i % 2 === 1 ? 'Fall' : 'Spring',
                'credit_hours' => rand(3, 4),
                'department' => 'Computer Science',
            ]);
        }

        // Assign courses to students
        foreach ($students as $student) {
            $randomCourses = collect($courses)->random(rand(3, 8))->pluck('id');
            $student->courses()->attach($randomCourses, ['term' => '2026-01']);
        }

        // Assign courses to faculty
        foreach ($faculty as $facultyMember) {
            $randomCourses = collect($courses)->random(rand(4, 10))->pluck('id');
            $facultyMember->courses()->attach($randomCourses, ['term' => '2026-01']);
        }
    }
}
