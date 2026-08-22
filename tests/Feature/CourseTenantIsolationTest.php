<?php

use App\Models\Course;
use App\Models\University;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;

uses(RefreshDatabase::class);

test('admin only sees courses from their university', function () {
    $uni1 = University::create(['name' => 'Uni A', 'domain' => 'a.edu']);
    $uni2 = University::create(['name' => 'Uni B', 'domain' => 'b.edu']);

    $admin1 = User::factory()->create(['role' => 'admin', 'university_id' => $uni1->id]);
    $admin2 = User::factory()->create(['role' => 'admin', 'university_id' => $uni2->id]);

    Course::create([
        'title' => 'CS 101',
        'code' => 'CS101',
        'semester' => 'Fall 2026',
        'credit_hours' => 3,
        'department' => 'Computer Science',
        'university_id' => $uni1->id,
    ]);

    Course::create([
        'title' => 'Math 201',
        'code' => 'MATH201',
        'semester' => 'Fall 2026',
        'credit_hours' => 4,
        'department' => 'Mathematics',
        'university_id' => $uni2->id,
    ]);

    $response1 = $this->actingAs($admin1)->get(route('admin.courses'));
    $response1->assertSee('CS 101');
    $response1->assertDontSee('Math 201');

    $response2 = $this->actingAs($admin2)->get(route('admin.courses'));
    $response2->assertSee('Math 201');
    $response2->assertDontSee('CS 101');
});

test('admin only sees their university courses on courses page', function () {
    $uni1 = University::create(['name' => 'Uni A', 'domain' => 'a.edu']);
    $uni2 = University::create(['name' => 'Uni B', 'domain' => 'b.edu']);

    $admin1 = User::factory()->create(['role' => 'admin', 'university_id' => $uni1->id]);

    Course::create([
        'title' => 'CS 101',
        'code' => 'CS101',
        'semester' => 'Fall 2026',
        'credit_hours' => 3,
        'department' => 'Computer Science',
        'university_id' => $uni1->id,
    ]);

    Course::create([
        'title' => 'Math 201',
        'code' => 'MATH201',
        'semester' => 'Fall 2026',
        'credit_hours' => 4,
        'department' => 'Mathematics',
        'university_id' => $uni2->id,
    ]);

    $this->actingAs($admin1)->get(route('admin.courses'));

    expect(Course::where('university_id', $uni1->id)->count())->toBe(1);
    expect(Course::where('university_id', $uni2->id)->count())->toBe(1);
});

test('course creation assigns university_id from admin', function () {
    $uni = University::create(['name' => 'Uni A', 'domain' => 'a.edu']);
    $admin = User::factory()->create(['role' => 'admin', 'university_id' => $uni->id]);

    $response = $this->actingAs($admin)->post(route('admin.courses.store'), [
        'title' => 'Physics 101',
        'code' => 'PHY101',
        'semester' => 'Spring 2027',
        'credit_hours' => 3,
        'department' => 'Physics',
    ]);

    $response->assertRedirect(route('admin.courses'));

    $this->assertDatabaseHas('courses', [
        'code' => 'PHY101',
        'university_id' => $uni->id,
    ]);
});

test('admin cannot see course from another university via direct URL', function () {
    $uni1 = University::create(['name' => 'Uni A', 'domain' => 'a.edu']);
    $uni2 = University::create(['name' => 'Uni B', 'domain' => 'b.edu']);

    $admin1 = User::factory()->create(['role' => 'admin', 'university_id' => $uni1->id]);

    $course = Course::create([
        'title' => 'Math 201',
        'code' => 'MATH201',
        'semester' => 'Fall 2026',
        'credit_hours' => 4,
        'department' => 'Mathematics',
        'university_id' => $uni2->id,
    ]);

    $response = $this->actingAs($admin1)->get(route('admin.departments.courses.edit', [
        'department' => Str::slug('Mathematics'),
        'course' => $course->id,
    ]));

    $response->assertNotFound();
});

test('two universities can create courses with the same code', function () {
    $uni1 = University::create(['name' => 'Uni A', 'domain' => 'a.edu']);
    $uni2 = University::create(['name' => 'Uni B', 'domain' => 'b.edu']);

    $admin1 = User::factory()->create(['role' => 'admin', 'university_id' => $uni1->id]);
    $admin2 = User::factory()->create(['role' => 'admin', 'university_id' => $uni2->id]);

    $payload = [
        'title' => 'Physics 101',
        'code' => 'PHY101',
        'semester' => 'Spring 2027',
        'credit_hours' => 3,
        'department' => 'Physics',
    ];

    $this->actingAs($admin1)->post(route('admin.courses.store'), $payload)->assertSessionHasNoErrors();
    $this->actingAs($admin2)->post(route('admin.courses.store'), $payload)->assertSessionHasNoErrors();

    expect(Course::where('code', 'PHY101')->count())->toBe(2);
});

test('duplicate course code is rejected within the same university', function () {
    $uni = University::create(['name' => 'Uni A', 'domain' => 'a.edu']);
    $admin = User::factory()->create(['role' => 'admin', 'university_id' => $uni->id]);

    Course::create([
        'title' => 'Physics 101',
        'code' => 'PHY101',
        'semester' => 'Spring 2027',
        'credit_hours' => 3,
        'department' => 'Physics',
        'university_id' => $uni->id,
    ]);

    $response = $this->actingAs($admin)->post(route('admin.courses.store'), [
        'title' => 'Physics 102',
        'code' => 'PHY101',
        'semester' => 'Spring 2027',
        'credit_hours' => 3,
        'department' => 'Physics',
    ]);

    $response->assertSessionHasErrors('code');
    expect(Course::where('code', 'PHY101')->count())->toBe(1);
});

test('department course can be updated while another university uses the same code', function () {
    $uni1 = University::create(['name' => 'Uni A', 'domain' => 'a.edu']);
    $uni2 = University::create(['name' => 'Uni B', 'domain' => 'b.edu']);

    $admin1 = User::factory()->create(['role' => 'admin', 'university_id' => $uni1->id]);
    User::factory()->create(['role' => 'faculty', 'university_id' => $uni1->id, 'department' => 'Physics']);

    Course::create([
        'title' => 'Physics 101',
        'code' => 'PHY101',
        'semester' => 'Spring 2027',
        'credit_hours' => 3,
        'department' => 'Physics',
        'university_id' => $uni1->id,
    ]);

    Course::create([
        'title' => 'Physics 101 B',
        'code' => 'PHY101',
        'semester' => 'Spring 2027',
        'credit_hours' => 3,
        'department' => 'Physics',
        'university_id' => $uni2->id,
    ]);

    $course = Course::where('university_id', $uni1->id)->where('code', 'PHY101')->first();

    $response = $this->actingAs($admin1)->put(route('admin.departments.courses.update', [
        'department' => Str::slug('Physics'),
        'course' => $course->id,
    ]), [
        'title' => 'Physics 101 Updated',
        'code' => 'PHY101',
        'semester' => 'Fall 2026',
        'credit_hours' => 4,
    ]);

    $response->assertSessionHasNoErrors();

    expect($course->fresh()->title)->toBe('Physics 101 Updated');
});
