<?php

namespace Tests\Feature;

use App\Models\JobAlert;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class AdminJobAlertTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Guests cannot access admin job alerts.
     */
    public function test_guests_cannot_access_job_alerts_inbox(): void
    {
        $response = $this->get('/admin/job-alerts');
        $response->assertRedirect('/login');
    }

    /**
     * Non-admin users cannot access admin job alerts.
     */
    public function test_non_admin_users_cannot_access_job_alerts(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)->get('/admin/job-alerts');
        $response->assertStatus(403);
    }

    /**
     * Admin can view subscriber list.
     */
    public function test_admin_can_view_job_alerts_list(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        JobAlert::create([
            'email' => 'candidate@example.com',
            'keyword' => 'Bank',
            'location' => 'Dhaka',
            'unsubscribe_token' => Str::random(64),
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->get('/admin/job-alerts');
        $response->assertStatus(200);
        $response->assertSee('candidate@example.com');
        $response->assertSee('Bank');
    }

    /**
     * Admin can toggle subscriber status.
     */
    public function test_admin_can_toggle_subscriber_status(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $subscriber = JobAlert::create([
            'email' => 'test@example.com',
            'unsubscribe_token' => Str::random(64),
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->patch("/admin/job-alerts/{$subscriber->id}/toggle");
        $response->assertRedirect();
        $this->assertFalse($subscriber->fresh()->is_active);

        $response2 = $this->actingAs($admin)->patch("/admin/job-alerts/{$subscriber->id}/toggle");
        $response2->assertRedirect();
        $this->assertTrue($subscriber->fresh()->is_active);
    }

    /**
     * Admin can export CSV of subscribers.
     */
    public function test_admin_can_export_subscribers_csv(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        JobAlert::create([
            'email' => 'exportme@example.com',
            'unsubscribe_token' => Str::random(64),
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->get('/admin/job-alerts/export');
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'text/csv; charset=UTF-8');
    }

    /**
     * Admin can delete a subscriber.
     */
    public function test_admin_can_delete_subscriber(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $subscriber = JobAlert::create([
            'email' => 'delete@example.com',
            'unsubscribe_token' => Str::random(64),
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->delete("/admin/job-alerts/{$subscriber->id}");
        $response->assertRedirect();
        $this->assertDatabaseMissing('job_alerts', ['id' => $subscriber->id]);
    }

    /**
     * Admin can clear cache via post request.
     */
    public function test_admin_can_clear_system_cache(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->post('/admin/clear-cache');
        $response->assertRedirect(route('admin.settings.index'));
        $response->assertSessionHas('success');
    }
}
