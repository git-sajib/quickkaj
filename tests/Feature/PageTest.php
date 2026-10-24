<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageTest extends TestCase
{
    use RefreshDatabase;

    public function test_about_page_renders_in_bengali_and_english(): void
    {
        $responseBn = $this->get('/bn/about');
        $responseBn->assertOk()
            ->assertSee('আমাদের সম্পর্কে')
            ->assertSee('১৮+');

        $responseEn = $this->get('/en/about');
        $responseEn->assertOk()
            ->assertSee('About Us');
    }

    public function test_contact_page_renders_in_bengali_and_english(): void
    {
        $responseBn = $this->get('/bn/contact');
        $responseBn->assertOk()
            ->assertSee('যোগাযোগ করুন');

        $responseEn = $this->get('/en/contact');
        $responseEn->assertOk()
            ->assertSee('Get in Touch');
    }

    public function test_contact_form_submits_message_successfully(): void
    {
        $data = [
            'name' => 'Rakibul Islam',
            'email' => 'rakib@example.com',
            'subject' => 'New Tool Request',
            'message' => 'Please add a PDF to Word converter tool for Bengali documents.',
        ];

        $response = $this->post('/bn/contact', $data);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('contact_messages', [
            'name' => 'Rakibul Islam',
            'email' => 'rakib@example.com',
            'subject' => 'New Tool Request',
        ]);
    }

    public function test_contact_form_validation(): void
    {
        $response = $this->post('/bn/contact', [
            'name' => '',
            'email' => 'not-an-email',
            'message' => 'short',
        ]);

        $response->assertSessionHasErrors(['name', 'email', 'message']);
        $this->assertEquals(0, ContactMessage::count());
    }

    public function test_unprefixed_about_and_contact_redirect(): void
    {
        $this->get('/about')->assertRedirect('/bn/about');
        $this->get('/contact')->assertRedirect('/bn/contact');
    }
}
