<?php

use App\Models\Course;
use App\Models\Evaluation;
use App\Models\University;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function createCourseFor(User $admin, string $code): Course
{
    return Course::create([
        'title' => "Course $code",
        'code' => $code,
        'semester' => 'Fall 2026',
        'credit_hours' => 3,
        'department' => 'Computer Science',
        'university_id' => $admin->university_id,
    ]);
}

test('faculty assigned to a course are not counted as enrolled students', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $faculty = User::factory()->create(['role' => 'faculty']);
    $studentA = User::factory()->create(['role' => 'student']);
    $studentB = User::factory()->create(['role' => 'student']);

    $course = createCourseFor($admin, 'CS-101');

    // Faculty and students share the course_user pivot.
    $course->faculty()->attach($faculty->id);
    $course->users()->attach([$studentA->id, $studentB->id]);

    $response = $this->actingAs($admin)->get(route('admin.courses'));

    $response->assertOk();

    $courseRow = $response->viewData('courses')->firstWhere('id', $course->id);

    expect($courseRow->students_count)->toBe(2)
        ->and($response->viewData('totalEnrollment'))->toBe(2);
});

test('enrollment stats are tenant-wide instead of limited to the current page', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $student = User::factory()->create(['role' => 'student']);

    foreach (range(1, 55) as $i) {
        $course = createCourseFor($admin, sprintf('CS-%03d', $i));
        $course->users()->attach($student->id);
    }

    $response = $this->actingAs($admin)->get(route('admin.courses'));

    $response->assertOk();

    expect($response->viewData('activeCourses'))->toBe(55)
        ->and($response->viewData('totalEnrollment'))->toBe(55)
        ->and($response->viewData('courses')->count())->toBe(50);
});

test('pending evaluations stat counts scheduled evaluation cycles for the tenant', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    Evaluation::create([
        'title' => 'Scheduled Eval',
        'semester' => 'Fall 2026',
        'evaluation_type' => 'mid-term',
        'start_date' => now()->addDays(14),
        'end_date' => now()->addDays(21),
        'status' => 'scheduled',
        'created_by' => $admin->id,
    ]);

    Evaluation::create([
        'title' => 'Active Eval',
        'semester' => 'Fall 2026',
        'evaluation_type' => 'mid-term',
        'start_date' => now()->subDay(),
        'end_date' => now()->addDays(7),
        'status' => 'active',
        'created_by' => $admin->id,
    ]);

    $response = $this->actingAs($admin)->get(route('admin.courses'));

    $response->assertOk();

    expect($response->viewData('pendingEvaluations'))->toBe(1);
});

test('students from other universities are not counted in tenant enrollment', function () {
    $universityA = University::create(['name' => 'University A', 'domain' => 'a.edu']);
    $universityB = University::create(['name' => 'University B', 'domain' => 'b.edu']);

    $admin = User::factory()->create(['role' => 'admin', 'university_id' => $universityA->id]);
    $otherAdmin = User::factory()->create(['role' => 'admin', 'university_id' => $universityB->id]);

    $ownCourse = createCourseFor($admin, 'CS-101');
    $foreignCourse = Course::create([
        'title' => 'Foreign Course',
        'code' => 'XX-999',
        'semester' => 'Fall 2026',
        'credit_hours' => 3,
        'department' => 'Computer Science',
        'university_id' => $otherAdmin->university_id,
    ]);

    $ownStudent = User::factory()->create(['role' => 'student', 'university_id' => $universityA->id]);
    $foreignStudent = User::factory()->create(['role' => 'student', 'university_id' => $universityB->id]);

    $ownCourse->users()->attach($ownStudent->id);
    $foreignCourse->users()->attach([$ownStudent->id, $foreignStudent->id]);

    $response = $this->actingAs($admin)->get(route('admin.courses'));

    $response->assertOk();

    expect($response->viewData('totalEnrollment'))->toBe(1)
        ->and($response->viewData('activeCourses'))->toBe(1);
});
