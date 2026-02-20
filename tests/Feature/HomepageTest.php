<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Project;
use App\Models\BlogPost;
use App\Models\Testimonial;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomepageTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_loads()
    {
        $response = $this->get('/en');

        $response->assertStatus(200);
        $response->assertViewIs('home');
    }

    public function test_homepage_displays_projects()
    {
        Project::factory()->count(3)->create();

        $response = $this->get('/en');

        $response->assertStatus(200);
        $response->assertViewHas('projects');
    }

    public function test_homepage_displays_blog_posts()
    {
        BlogPost::factory()->count(3)->create(['is_published' => true, 'published_at' => now()]);

        $response = $this->get('/en');

        $response->assertStatus(200);
        $response->assertViewHas('blogPosts');
    }

    public function test_homepage_displays_testimonials()
    {
        Testimonial::factory()->count(3)->create(['is_active' => true]);

        $response = $this->get('/en');

        $response->assertStatus(200);
        $response->assertViewHas('testimonials');
    }

    public function test_store_testimonial()
    {
        $response = $this->post('/en/testimonials', [
            'name' => 'John Doe',
            'role' => 'Developer',
            'content' => 'Great work!',
            'rating' => 5,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('testimonials', [
            'name' => 'John Doe',
            'content' => 'Great work!',
            'is_active' => false,
        ]);
    }
}
