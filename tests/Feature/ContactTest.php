<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Config;

class ContactTest extends TestCase
{
    /**
     * Test that the contact form can be submitted successfully.
     *
     * @return void
     */
    public function test_contact_form_submission()
    {
        // Ensure mail driver is log so we don't actually send emails but still render the view
        Config::set('mail.default', 'log');

        $response = $this->post('/ro/contact', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'subject' => 'Test Subject',
            'message' => 'This is a test message with at least 10 chars.'
        ]);

        $response->assertStatus(302);

        // If view rendering fails, controller catches exception and redirects back with 'error'
        if (session('error')) {
            $this->fail('Contact form submission failed with error: ' . session('error'));
        }

        $response->assertSessionHas('success', 'Mesajul a fost trimis cu succes!');
    }
}
