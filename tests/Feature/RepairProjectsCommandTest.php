<?php

namespace Tests\Feature;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RepairProjectsCommandTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        Storage::fake('local');
    }

    public function test_dry_run_modifies_nothing(): void
    {
        $project = Project::factory()->create();
        $this->rawUpdate($project, [
            'title' => json_encode([
                ['locale' => 'EN', 'value' => 'English'],
                ['locale' => 'RO', 'value' => 'Română'],
            ]),
            'category' => 'web_app',
        ]);
        $before = $project->newQuery()->whereKey($project->getKey())->first()->getRawOriginal();

        $this->artisan('projects:repair --dry-run')->assertSuccessful();

        $after = $project->newQuery()->whereKey($project->getKey())->first()->getRawOriginal();
        $this->assertSame($before, $after);
    }

    public function test_repair_is_idempotent(): void
    {
        $project = Project::factory()->create();
        $this->rawUpdate($project, [
            'title' => json_encode([
                ['locale' => 'EN', 'value' => 'English'],
                ['locale' => 'RO', 'value' => 'Română'],
            ]),
            'thumbnail' => '/storage/projects/one.webp',
            'category' => 'web_application',
        ]);

        $this->artisan('projects:repair')->assertSuccessful();
        $afterFirstRun = $project->newQuery()->whereKey($project->getKey())->first()->getRawOriginal();

        $this->artisan('projects:repair')->assertSuccessful();
        $afterSecondRun = $project->newQuery()->whereKey($project->getKey())->first()->getRawOriginal();

        $this->assertSame($afterFirstRun, $afterSecondRun);
        $this->assertSame(['en' => 'English', 'ro' => 'Română'], json_decode($afterFirstRun['title'], true));
        $this->assertSame('projects/one.webp', $afterFirstRun['thumbnail']);
        $this->assertSame('web_platform', $afterFirstRun['category']);
    }

    public function test_missing_locale_is_reported_but_not_invented(): void
    {
        $project = Project::factory()->create(['title' => ['en' => 'Only English']]);

        $this->artisan('projects:repair')
            ->expectsOutputToContain('missing:ro')
            ->assertSuccessful();

        $this->assertSame(
            ['en' => 'Only English'],
            $project->refresh()->getTranslationMap('title'),
        );
    }

    public function test_conflicting_duplicate_translations_are_not_destructively_repaired(): void
    {
        $project = Project::factory()->create();
        $raw = json_encode([
            ['locale' => 'en', 'value' => 'First'],
            ['locale' => 'en', 'value' => 'Second'],
        ]);
        $this->rawUpdate($project, ['title' => $raw]);

        $this->artisan('projects:repair')->assertSuccessful();

        $this->assertSame($raw, $project->refresh()->getRawOriginal('title'));
    }

    public function test_public_files_are_never_deleted(): void
    {
        Storage::disk('public')->put('projects/existing.webp', 'public-file');
        Project::factory()->create(['thumbnail' => 'projects/existing.webp']);

        $this->artisan('projects:repair')->assertSuccessful();

        Storage::disk('public')->assertExists('projects/existing.webp');
    }

    public function test_private_file_is_copied_only_with_explicit_option_and_source_is_retained(): void
    {
        Storage::disk('local')->put('projects/private.webp', 'private-file');
        Project::factory()->create(['thumbnail' => 'projects/private.webp']);

        $this->artisan('projects:repair')->assertSuccessful();
        Storage::disk('public')->assertMissing('projects/private.webp');

        $this->artisan('projects:repair --move-private-files')->assertSuccessful();
        Storage::disk('public')->assertExists('projects/private.webp');
        Storage::disk('local')->assertExists('projects/private.webp');
    }

    private function rawUpdate(Project $project, array $values): void
    {
        $project->newQuery()->whereKey($project->getKey())->update($values);
    }
}
