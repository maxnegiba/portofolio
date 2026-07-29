<?php

namespace Tests\Feature;

use App\Filament\Resources\ProjectResource\Pages\EditProject;
use App\Models\Project;
use App\Models\User;
use App\Support\Projects\ProjectFormData;
use Filament\Forms\Components\FileUpload;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class ProjectFormLifecycleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
    }

    public function test_associative_map_loads_into_filament_locale_tabs(): void
    {
        $project = Project::factory()->create([
            'title' => ['en' => 'English', 'ro' => 'Română'],
            'description' => ['en' => 'Description', 'ro' => 'Descriere'],
        ]);

        $data = app(ProjectFormData::class)->hydrate($project, $project->attributesToArray());

        $this->assertSame('English', $data['translations']['en']['title']);
        $this->assertSame('Română', $data['translations']['ro']['title']);
    }

    public function test_repeater_map_loads_into_filament_locale_tabs(): void
    {
        $project = Project::factory()->create();
        $this->writeRawTranslation($project, 'title', [
            ['locale' => 'en', 'value' => 'English'],
            ['locale' => 'ro', 'value' => 'Română'],
        ]);
        $project->refresh();

        $data = app(ProjectFormData::class)->hydrate($project, $project->attributesToArray());

        $this->assertSame('English', $data['translations']['en']['title']);
        $this->assertSame('Română', $data['translations']['ro']['title']);
    }

    public function test_editing_english_title_preserves_romanian_title_and_saves_canonical_json(): void
    {
        $project = Project::factory()->create([
            'title' => ['en' => 'Old', 'ro' => 'Română'],
        ]);
        $data = app(ProjectFormData::class)->hydrate($project, $project->attributesToArray());
        $data['translations']['en']['title'] = 'New';

        $saved = app(ProjectFormData::class)->dehydrate($data, $project);
        $project->update($saved);
        $project->refresh();

        $this->assertSame(['en' => 'New', 'ro' => 'Română'], $project->getTranslationMap('title'));
        $this->assertSame(
            ['en' => 'New', 'ro' => 'Română'],
            json_decode($project->getRawOriginal('title'), true),
        );
    }

    public function test_editing_romanian_narrative_preserves_english_html(): void
    {
        $project = Project::factory()->create([
            'problem' => ['en' => '<p>English <strong>HTML</strong></p>', 'ro' => '<p>Vechi</p>'],
        ]);
        $data = app(ProjectFormData::class)->hydrate($project, $project->attributesToArray());
        $data['translations']['ro']['problem'] = '<p>Nou</p>';

        $project->update(app(ProjectFormData::class)->dehydrate($data, $project));
        $project->refresh();

        $this->assertSame('<p>English <strong>HTML</strong></p>', $project->getTranslationMap('problem')['en']);
        $this->assertSame('<p>Nou</p>', $project->getTranslationMap('problem')['ro']);
    }

    public function test_text_only_edit_preserves_existing_thumbnail_and_gallery(): void
    {
        Storage::disk('public')->put('projects/thumbnails/one.webp', 'thumb');
        Storage::disk('public')->put('projects/images/one.webp', 'gallery');
        $project = Project::factory()->create([
            'thumbnail' => 'projects/thumbnails/one.webp',
            'images' => ['projects/images/one.webp'],
        ]);

        $data = app(ProjectFormData::class)->hydrate($project, $project->attributesToArray());
        $data['translations']['en']['title'] = 'Edited';
        $saved = app(ProjectFormData::class)->dehydrate($data, $project);

        $this->assertSame('projects/thumbnails/one.webp', $saved['thumbnail']);
        $this->assertSame(['projects/images/one.webp'], $saved['images']);
    }

    public function test_unpreviewable_legacy_images_are_preserved_unless_explicitly_removed(): void
    {
        $project = Project::factory()->create([
            'thumbnail' => 'img/legacy.webp',
            'images' => ['https://cdn.example.org/legacy.webp'],
        ]);
        $data = app(ProjectFormData::class)->hydrate($project, $project->attributesToArray());

        $preserved = app(ProjectFormData::class)->dehydrate($data, $project);
        $this->assertSame('img/legacy.webp', $preserved['thumbnail']);
        $this->assertSame(['https://cdn.example.org/legacy.webp'], $preserved['images']);

        $data['remove_existing_thumbnail'] = true;
        $data['remove_all_images'] = true;
        $removed = app(ProjectFormData::class)->dehydrate($data, $project);
        $this->assertNull($removed['thumbnail']);
        $this->assertSame([], $removed['images']);
    }

    public function test_individual_gallery_removal_requires_explicit_confirmation(): void
    {
        Storage::disk('public')->put('projects/images/one.webp', 'one');
        Storage::disk('public')->put('projects/images/two.webp', 'two');
        $project = Project::factory()->create([
            'images' => ['projects/images/one.webp', 'projects/images/two.webp'],
        ]);
        $data = app(ProjectFormData::class)->hydrate($project, $project->attributesToArray());
        $data['images'] = ['projects/images/two.webp'];

        $protected = app(ProjectFormData::class)->dehydrate($data, $project);
        $this->assertSame(
            ['projects/images/one.webp', 'projects/images/two.webp'],
            $protected['images'],
        );

        $data['apply_gallery_changes'] = true;
        $confirmed = app(ProjectFormData::class)->dehydrate($data, $project);
        $this->assertSame(['projects/images/two.webp'], $confirmed['images']);
    }

    public function test_filament_edit_page_uses_real_lifecycle_hooks(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create([
            'title' => ['en' => 'English', 'ro' => 'Română'],
            'description' => ['en' => 'Description', 'ro' => 'Descriere'],
        ]);

        Livewire::actingAs($user)
            ->test(EditProject::class, ['record' => $project->getRouteKey()])
            ->assertFormSet([
                'translations.en.title' => 'English',
                'translations.ro.title' => 'Română',
            ])
            ->assertFormFieldExists(
                'thumbnail',
                fn (FileUpload $field): bool => $field->getDiskName() === 'public'
                    && $field->getVisibility() === 'public',
            )
            ->assertFormFieldExists(
                'images',
                fn (FileUpload $field): bool => $field->getDiskName() === 'public'
                    && $field->getVisibility() === 'public',
            )
            ->fillForm([
                'translations.en.title' => 'Changed',
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertSame(
            ['en' => 'Changed', 'ro' => 'Română'],
            $project->refresh()->getTranslationMap('title'),
        );
    }

    private function writeRawTranslation(Project $project, string $field, array $value): void
    {
        $project->newQuery()
            ->whereKey($project->getKey())
            ->update([$field => json_encode($value)]);
    }
}
