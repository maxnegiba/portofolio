<?php

namespace Tests\Unit;

use App\Support\Projects\ProjectImagePath;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProjectImagePathTest extends TestCase
{
    private ProjectImagePath $paths;

    protected function setUp(): void
    {
        parent::setUp();
        config()->set('app.url', 'https://portfolio.test');
        Storage::fake('public');
        $this->paths = app(ProjectImagePath::class);
    }

    public function test_relative_public_disk_path_resolves_and_can_be_optimized(): void
    {
        Storage::disk('public')->put('projects/example.webp', 'image');

        $this->assertSame('projects/example.webp', $this->paths->normalizeForStorage('projects/example.webp'));
        $this->assertSame('projects/example.webp', $this->paths->optimizerPath('projects/example.webp'));
        $this->assertStringEndsWith('/storage/projects/example.webp', $this->paths->publicUrl('projects/example.webp'));
    }

    public function test_legacy_storage_path_is_normalized(): void
    {
        $this->assertSame(
            'projects/example.webp',
            $this->paths->normalizeForStorage('/storage/projects/example.webp'),
        );
    }

    public function test_same_domain_absolute_storage_url_is_normalized(): void
    {
        $this->assertSame(
            'projects/example.webp',
            $this->paths->normalizeForStorage('https://portfolio.test/storage/projects/example.webp'),
        );
    }

    public function test_external_url_bypasses_local_optimizer(): void
    {
        $url = 'https://cdn.example.org/project.webp';

        $this->assertSame($url, $this->paths->publicUrl($url));
        $this->assertNull($this->paths->optimizerPath($url));
    }

    public function test_traversal_path_is_never_optimized(): void
    {
        $this->assertNull($this->paths->optimizerPath('../private/secret.webp'));
    }
}
