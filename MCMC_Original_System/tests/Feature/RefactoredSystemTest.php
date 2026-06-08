<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RefactoredSystemTest extends TestCase
{
    /**
     * Test that the home page loads correctly.
     */
    public function test_home_page_loads()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    /**
     * Test that the login page loads correctly.
     */
    public function test_login_page_loads()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    /**
     * Test that admin routes are protected and redirect to login.
     */
    public function test_admin_routes_protected()
    {
        $response = $this->get('/admin/users');
        $response->assertRedirect('/login');
    }

    /**
     * Test that agency routes are protected and redirect to login.
     */
    public function test_agency_routes_protected()
    {
        $response = $this->get('/agency/profile');
        $response->assertRedirect('/login');
    }

    /**
     * Test that registration page loads correctly.
     */
    public function test_registration_page_loads()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
    }
}
