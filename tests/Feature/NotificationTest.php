<?php

namespace Tests\Feature;

use App\Models\University;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Str;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_mark_notifications_as_read(): void
    {
        $response = $this->post('/notifications/mark-read');

        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_mark_all_notifications_as_read_via_redirect(): void
    {
        $university = University::factory()->create();
        $user = User::factory()->create([
            'university_id' => $university->id,
            'role' => 'student',
        ]);

        DatabaseNotification::create([
            'id' => (string) Str::uuid(),
            'type' => 'App\Notifications\EvaluationAvailableNotification',
            'notifiable_type' => User::class,
            'notifiable_id' => $user->id,
            'data' => [
                'title' => 'New Evaluation Available',
                'message' => 'Spring 2026 evaluation is now open',
                'action_url' => '/student/dashboard',
            ],
            'read_at' => null,
        ]);

        $this->assertEquals(1, $user->unreadNotifications()->count());

        $response = $this->actingAs($user)->post('/notifications/mark-read');

        $response->assertStatus(302);
        $this->assertEquals(0, $user->fresh()->unreadNotifications()->count());
    }

    public function test_authenticated_user_can_mark_all_notifications_as_read_via_json(): void
    {
        $university = University::factory()->create();
        $user = User::factory()->create([
            'university_id' => $university->id,
            'role' => 'faculty',
        ]);

        DatabaseNotification::create([
            'id' => (string) Str::uuid(),
            'type' => 'App\Notifications\FeedbackSubmittedNotification',
            'notifiable_type' => User::class,
            'notifiable_id' => $user->id,
            'data' => [
                'title' => 'New Feedback Received',
                'message' => 'Feedback submitted for CS101',
                'action_url' => '/faculty/dashboard',
            ],
            'read_at' => null,
        ]);

        $this->assertEquals(1, $user->unreadNotifications()->count());

        $response = $this->actingAs($user)->postJson('/notifications/mark-read');

        $response->assertOk();
        $response->assertJson([
            'success' => true,
            'message' => 'All notifications marked as read',
        ]);
        $this->assertEquals(0, $user->fresh()->unreadNotifications()->count());
    }

    public function test_notification_bell_renders_in_dashboard(): void
    {
        $university = University::factory()->create();
        $user = User::factory()->create([
            'university_id' => $university->id,
            'role' => 'student',
        ]);

        DatabaseNotification::create([
            'id' => (string) Str::uuid(),
            'type' => 'App\Notifications\EvaluationAvailableNotification',
            'notifiable_type' => User::class,
            'notifiable_id' => $user->id,
            'data' => [
                'title' => 'Spring Evaluation',
                'evaluation_title' => 'Spring Evaluation',
                'message' => 'Please evaluate your courses',
                'action_url' => '/student/dashboard',
            ],
            'read_at' => null,
        ]);

        $response = $this->actingAs($user)->get('/student/dashboard');

        $response->assertOk();
        $response->assertSee('Notifications');
        $response->assertSee('Spring Evaluation');
        $response->assertSee('Please evaluate your courses');
    }
}
