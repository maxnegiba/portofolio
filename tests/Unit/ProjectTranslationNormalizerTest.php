<?php

namespace Tests\Unit;

use App\Models\Project;
use App\Support\Projects\ProjectTranslationNormalizer;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class ProjectTranslationNormalizerTest extends TestCase
{
    private ProjectTranslationNormalizer $normalizer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->normalizer = app(ProjectTranslationNormalizer::class);
    }

    public function test_associative_translation_map_is_preserved(): void
    {
        $value = json_encode(['en' => 'English', 'ro' => 'Română']);

        $this->assertSame(
            ['en' => 'English', 'ro' => 'Română'],
            $this->normalizer->normalize($value),
        );
    }

    public function test_legacy_repeater_is_normalized(): void
    {
        $value = json_encode([
            ['locale' => ' EN ', 'value' => 'English'],
            ['locale' => 'RO', 'value' => 'Română'],
        ]);

        $this->assertSame(
            ['en' => 'English', 'ro' => 'Română'],
            $this->normalizer->normalize($value),
        );
    }

    public function test_plain_string_is_preserved_only_in_the_fallback_locale(): void
    {
        config()->set('app.fallback_locale', 'en');

        $this->assertSame(['en' => 'Legacy text'], $this->normalizer->normalize('Legacy text'));
    }

    public function test_double_encoded_json_is_normalized(): void
    {
        $value = json_encode(json_encode(['en' => 'English', 'ro' => 'Română']));

        $this->assertSame(
            ['en' => 'English', 'ro' => 'Română'],
            $this->normalizer->normalize($value),
        );
        $this->assertSame('double_encoded_json', $this->normalizer->inspect($value)['format']);
    }

    public function test_duplicate_locale_rows_merge_deterministically(): void
    {
        $value = [
            ['locale' => 'en', 'value' => 'First'],
            ['locale' => 'en', 'value' => 'Second'],
        ];

        $this->assertSame(['en' => 'First'], $this->normalizer->normalize($value));
        $this->assertSame(['en'], $this->normalizer->inspect($value)['conflicting_duplicates']);
    }

    public function test_empty_duplicate_does_not_overwrite_content(): void
    {
        $value = [
            ['locale' => 'en', 'value' => ''],
            ['locale' => 'en', 'value' => 'Recovered'],
            ['locale' => 'en', 'value' => ''],
        ];

        $this->assertSame(['en' => 'Recovered'], $this->normalizer->normalize($value));
    }

    public function test_valid_html_is_not_removed(): void
    {
        $html = '<p>A <strong>safe</strong> narrative.</p>';

        $this->assertSame(['en' => $html], $this->normalizer->normalize(['en' => $html]));
    }

    public function test_exact_accidental_duplication_is_removed(): void
    {
        $duplicated = 'Voucher Platform.Voucher Platform.';

        $this->assertSame(
            ['en' => 'Voucher Platform.'],
            $this->normalizer->normalize(['en' => $duplicated]),
        );
    }

    public function test_project_exposes_complete_maps_and_explicit_localized_values(): void
    {
        App::setLocale('ro');
        $project = new Project();
        $project->setRawAttributes([
            'title' => json_encode(['en' => 'English', 'ro' => 'Română']),
        ]);

        $this->assertSame(['en' => 'English', 'ro' => 'Română'], $project->getTranslationMap('title'));
        $this->assertSame('Română', $project->getLocalizedTitle());
    }
}
