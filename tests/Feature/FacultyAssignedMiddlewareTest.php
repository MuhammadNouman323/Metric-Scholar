<?php

use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;

uses(RefreshDatabase::class);

test('assigned faculty can access route protected by faculty.assigned middleware', function () {
    $faculty = User::factory()->create(['role' => 'faculty']);
    $other = User::factory()->create(['role' => 'faculty']);

    $course = Course::create([
        'title' => 'Test Course',
        'code' => 'TST-101',
        'semester' => 'Fall',
        'credit_hours' => 3,
        'department' => 'CS',
    ]);

    // attach faculty to course
    $course->faculty()->attach($faculty->id);

    // register temporary route for test
    Route::get('/_test/faculty/course/{course}', function (Course $course) {
        return 'ok';
    })->middleware(['web', 'auth', 'faculty', 'faculty.assigned']);

    $this->actingAs($faculty)->get('/_test/faculty/course/'.$course->id)->assertStatus(200)->assertSee('ok');
    $this->actingAs($other)->get('/_test/faculty/course/'.$course->id)->assertRedirect('/faculty/dashboard');
});
