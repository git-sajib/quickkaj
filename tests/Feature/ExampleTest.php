<?php

namespace Tests\Feature;

use App\Models\JobAlert;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * Root URL redirects to the default locale (bn).
     */
    public function test_root_redirects_to_locale(): void
    {
        $response = $this->get('/');

        $response->assertStatus(302);
        $response->assertRedirectContains('bn');
    }

    /**
     * Home page renders successfully at the locale URL.
     */
    public function test_home_page_loads(): void
    {
        $response = $this->get('/bn');

        $response->assertStatus(200);
    }

    /**
     * Jobs listing page is accessible.
     */
    public function test_jobs_index_loads(): void
    {
        $response = $this->get('/bn/jobs');

        $response->assertStatus(200);
    }

    /**
     * Tools index page is accessible.
     */
    public function test_tools_index_loads(): void
    {
        $response = $this->get('/tools');

        $response->assertStatus(200);
    }

    /**
     * New tool pages are accessible (no DB dependency).
     */
    public function test_new_tools_load(): void
    {
        $tools = [
            '/tools/image-compressor',
            '/tools/image-resizer',
            '/tools/image-converter',
            '/tools/age-calculator',
            '/tools/bmi-calculator',
            '/tools/cgpa-calculator',
            '/tools/salary-calculator',
            '/tools/unit-converter',
            '/tools/cv-builder',
            '/tools/background-remover',
            '/tools/pdf-tools',
        ];

        foreach ($tools as $url) {
            $this->get($url)->assertStatus(200, "Tool page failed: {$url}");
        }
    }

    /**
     * Bilingual tool routes load in both Bengali and English.
     */
    public function test_bilingual_tools_load(): void
    {
        $this->get('/bn/tools')->assertStatus(200);
        $this->get('/en/tools')->assertStatus(200);

        // Verify English background remover loads with English text and toggle points to Bengali
        $enResponse = $this->get('/en/tools/background-remover');
        $enResponse->assertStatus(200);
        $enResponse->assertSee('AI Auto Background Remover');
        $enResponse->assertSee('/bn/tools/background-remover');

        // Verify Bengali background remover loads with Bengali text and toggle points to English
        $bnResponse = $this->get('/bn/tools/background-remover');
        $bnResponse->assertStatus(200);
        $bnResponse->assertSee('স্বয়ংক্রিয় এআই ব্যাকগ্রাউন্ড রিমুভার');
        $bnResponse->assertSee('/en/tools/background-remover');

        // Verify CV builder loads in both locales (100% English professional format)
        $this->get('/en/tools/cv-builder')->assertStatus(200)->assertSee('Professional A4 CV Builder');
        $this->get('/bn/tools/cv-builder')->assertStatus(200)->assertSee('Professional A4 CV Builder');

        // Verify PDF tools loads in English with toggle pointing to Bengali
        $enPdf = $this->get('/en/tools/pdf-tools');
        $enPdf->assertStatus(200);
        $enPdf->assertSee('All-in-One PDF & Document Tools');
        $enPdf->assertSee('/bn/tools/pdf-tools');

        // Verify PDF tools loads in Bengali with toggle pointing to English
        $bnPdf = $this->get('/bn/tools/pdf-tools');
        $bnPdf->assertStatus(200);
        $bnPdf->assertSee('পিডিএফ ও ডকুমেন্ট টুলস');
        $bnPdf->assertSee('/en/tools/pdf-tools');
    }

    /**
     * Privacy and Terms pages are accessible.
     */
    public function test_static_pages_load(): void
    {
        $this->get('/privacy-policy')->assertRedirect();
        $this->get('/terms-of-use')->assertRedirect();
        $this->get('/bn/privacy-policy')->assertStatus(200);
        $this->get('/bn/terms-of-use')->assertStatus(200);
    }

    /**
     * robots.txt is accessible (sitemap excluded — requires DB).
     */
    public function test_robots_txt_loads(): void
    {
        $this->get('/robots.txt')->assertStatus(200);
    }

    /**
     * Job alert subscribe endpoint requires valid email.
     */
    public function test_job_alert_subscribe_validates_email(): void
    {
        $response = $this->post('/job-alerts/subscribe', ['email' => 'not-an-email']);

        $response->assertSessionHasErrors('email');
    }

    /**
     * Job alert subscribe with valid email succeeds.
     */
    public function test_job_alert_subscribe_with_valid_email(): void
    {
        $email = 'test_'.uniqid().'@example.com';

        $response = $this->post('/job-alerts/subscribe', [
            'email' => $email,
            'keyword' => 'developer',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        // Cleanup
        JobAlert::where('email', $email)->delete();
    }

    /**
     * Saved jobs endpoint requires authentication.
     */
    public function test_saved_jobs_requires_auth(): void
    {
        $this->get('/saved-jobs')->assertRedirect('/login');
    }

    /**
     * Admin dashboard requires authentication.
     */
    public function test_admin_requires_auth(): void
    {
        $this->get('/admin')->assertRedirect('/login');
    }

    /**
     * Admin analytics requires authentication.
     */
    public function test_admin_analytics_requires_auth(): void
    {
        $this->get('/admin/analytics')->assertRedirect('/login');
    }
}
