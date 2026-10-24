<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use App\Models\PageView;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminContactMessageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Guests cannot access admin contact messages.
     */
    public function test_guests_cannot_access_contact_messages_inbox(): void
    {
        $response = $this->get('/admin/contact-messages');
        $response->assertRedirect('/login');
    }

    /**
     * Regular non-admin users cannot access admin contact messages.
     */
    public function test_non_admin_users_cannot_access_contact_messages_inbox(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)->get('/admin/contact-messages');
        $response->assertStatus(403);
    }

    /**
     * Admin can view contact messages list.
     */
    public function test_admin_can_view_contact_messages_list(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $message = ContactMessage::factory()->create([
            'name' => 'Rahim Uddin',
            'email' => 'rahim@example.com',
            'subject' => 'Website Inquiry',
            'message' => 'Hello, I have a question about job posting.',
            'is_read' => false,
        ]);

        $response = $this->actingAs($admin)->get('/admin/contact-messages');
        $response->assertStatus(200);
        $response->assertSee('Rahim Uddin');
        $response->assertSee('Website Inquiry');
    }

    /**
     * Admin viewing a message marks it as read.
     */
    public function test_admin_can_view_single_contact_message_and_it_is_marked_as_read(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $message = ContactMessage::factory()->create([
            'name' => 'Karim Hasan',
            'email' => 'karim@example.com',
            'subject' => 'Passport Photo Help',
            'message' => 'Please help me resize my passport image.',
            'is_read' => false,
        ]);

        $this->assertFalse($message->fresh()->is_read);

        $response = $this->actingAs($admin)->get("/admin/contact-messages/{$message->id}");
        $response->assertStatus(200);
        $response->assertSee('Passport Photo Help');
        $response->assertSee('Please help me resize my passport image.');

        $this->assertTrue($message->fresh()->is_read);
    }

    /**
     * Admin can toggle read and unread status.
     */
    public function test_admin_can_toggle_read_status(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $message = ContactMessage::factory()->create(['is_read' => true]);

        $response = $this->actingAs($admin)->patch("/admin/contact-messages/{$message->id}/toggle-read");
        $response->assertRedirect();
        $this->assertFalse($message->fresh()->is_read);

        $response2 = $this->actingAs($admin)->patch("/admin/contact-messages/{$message->id}/toggle-read");
        $response2->assertRedirect();
        $this->assertTrue($message->fresh()->is_read);
    }

    /**
     * Admin can delete a contact message.
     */
    public function test_admin_can_delete_contact_message(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $message = ContactMessage::factory()->create();

        $response = $this->actingAs($admin)->delete("/admin/contact-messages/{$message->id}");
        $response->assertRedirect(route('admin.contact-messages.index'));

        $this->assertDatabaseMissing('contact_messages', ['id' => $message->id]);
    }

    /**
     * Admin can filter and search messages.
     */
    public function test_admin_can_filter_and_search_messages(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        ContactMessage::factory()->create([
            'name' => 'Target Sender',
            'email' => 'target@example.com',
            'subject' => 'UniqueSubjectXYZ',
            'is_read' => false,
        ]);

        ContactMessage::factory()->create([
            'name' => 'Other Sender',
            'email' => 'other@example.com',
            'subject' => 'DifferentSubject',
            'is_read' => true,
        ]);

        // Search test
        $searchResponse = $this->actingAs($admin)->get('/admin/contact-messages?search=UniqueSubjectXYZ');
        $searchResponse->assertStatus(200);
        $searchResponse->assertSee('Target Sender');
        $searchResponse->assertDontSee('DifferentSubject');

        // Status unread filter test
        $unreadResponse = $this->actingAs($admin)->get('/admin/contact-messages?status=unread');
        $unreadResponse->assertStatus(200);
        $unreadResponse->assertSee('Target Sender');
        $unreadResponse->assertDontSee('DifferentSubject');
    }

    /**
     * Admin dashboard renders properly with top pages and all statistics.
     */
    public function test_admin_dashboard_loads_with_top_pages_and_stats(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        // Create page view records
        PageView::create([
            'url' => 'bn/jobs',
            'viewed_at' => now(),
            'device_type' => 'desktop',
        ]);
        PageView::create([
            'url' => 'bn/jobs',
            'viewed_at' => now(),
            'device_type' => 'mobile',
        ]);
        PageView::create([
            'url' => 'bn/news',
            'viewed_at' => now(),
            'device_type' => 'desktop',
        ]);

        $response = $this->actingAs($admin)->get('/admin');
        $response->assertStatus(200);
        $response->assertSee('/bn/jobs');
        $response->assertSee('Views');
        $response->assertSee('2');
    }
}
