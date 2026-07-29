<?php

namespace Tests\Feature;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectRenderingTest extends TestCase
{
    use RefreshDatabase;

    public function test_both_project_categories_and_legacy_fallback_render_on_index(): void
    {
        Project::factory()->create(['slug' => 'web', 'category' => 'web_platform', 'title' => ['en' => 'Web']]);
        Project::factory()->create(['slug' => 'auto', 'category' => 'automation', 'title' => ['en' => 'Automation']]);
        $legacy = Project::factory()->create(['slug' => 'legacy', 'title' => ['en' => 'Legacy']]);
        $legacy->newQuery()->whereKey($legacy->getKey())->update(['category' => 'WEB APP']);

        $response = $this->get(route('projects'));

        $response->assertSuccessful()
            ->assertSee('Web')
            ->assertSee('Automation')
            ->assertSee('Legacy');
    }

    public function test_card_description_strips_html_in_plain_text_context(): void
    {
        $project = Project::factory()->make([
            'slug' => 'html-card',
            'title' => ['en' => 'Card'],
            'description' => ['en' => '<p>Hello <strong>world</strong></p>'],
            'category' => 'web_platform',
        ]);

        $html = $this->view('components.project-card', compact('project'))->render();

        $this->assertStringContainsString('Hello world', $html);
        $this->assertStringNotContainsString('<strong>world</strong>', $html);
    }

    public function test_case_study_renders_locale_html_without_escaping(): void
    {
        $project = Project::factory()->create([
            'slug' => 'case-study',
            'title' => ['en' => 'Case Study'],
            'description' => ['en' => '<p>Rich <strong>overview</strong></p>'],
            'problem' => ['en' => '<p>Problem</p>'],
        ]);

        $this->get(route('project', $project))
            ->assertSuccessful()
            ->assertSee('<strong>overview</strong>', false)
            ->assertSee('<p>Problem</p>', false);
    }
}
