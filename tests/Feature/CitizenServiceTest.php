<?php

namespace Tests\Feature;

use Tests\TestCase;

class CitizenServiceTest extends TestCase
{
    /**
     * Test main citizen services index loads in Bengali and English.
     */
    public function test_citizen_services_index_loads(): void
    {
        $bnResponse = $this->get('/bn/services');
        $bnResponse->assertStatus(200);
        $bnResponse->assertSee('নাগরিক সেবা ও রেজাল্ট হাব');
        $bnResponse->assertSee('ই-পাসপোর্ট আবেদন ও ফি গাইড');

        $enResponse = $this->get('/en/services');
        $enResponse->assertStatus(200);
        $enResponse->assertSee('Citizen Services & Result Hub');
    }

    /**
     * Test e-Passport guide page loads.
     */
    public function test_passport_guide_page_loads(): void
    {
        $response = $this->get('/bn/services/passport-guide');
        $response->assertStatus(200);
        $response->assertSee('ই-পাসপোর্ট আবেদন');
        $response->assertSee('ফি তালিকা');
    }

    /**
     * Test NID and birth registration guide page loads.
     */
    public function test_nid_guide_page_loads(): void
    {
        $response = $this->get('/bn/services/nid-guide');
        $response->assertStatus(200);
        $response->assertSee('NID ও জন্ম নিবন্ধন সংশোধন');
    }

    /**
     * Test exam results and SMS tracker page loads.
     */
    public function test_exam_results_page_loads(): void
    {
        $response = $this->get('/bn/services/exam-results');
        $response->assertStatus(200);
        $response->assertSee('বোর্ড রেজাল্ট ও এসএমএস কোড ট্র্যাকার');
        $response->assertSee('16222');
    }

    /**
     * Test ready-to-use application and GD drafts page loads.
     */
    public function test_applications_gd_page_loads(): void
    {
        $response = $this->get('/bn/services/applications-gd');
        $response->assertStatus(200);
        $response->assertSee('জাতীয় পরিচয়পত্র (NID) হারানোর জিডি আবেদন');
        $response->assertSee('পাসপোর্ট হারানোর জিডি আবেদন');
    }

    /**
     * Test unprefixed routes redirect to localized routes.
     */
    public function test_unprefixed_services_routes_redirect(): void
    {
        $this->get('/services')->assertRedirect();
        $this->get('/services/passport-guide')->assertRedirect();
        $this->get('/services/nid-guide')->assertRedirect();
        $this->get('/services/exam-results')->assertRedirect();
        $this->get('/services/applications-gd')->assertRedirect();
    }
}
