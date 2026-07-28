<?php

namespace Tests\Unit;

use App\Models\Project;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    /** @test */
    public function it_removes_an_exact_accidental_title_duplication(): void
    {
        App::setLocale('en');

        $project = new Project();
        $project->setRawAttributes([
            'title' => json_encode([
                'en' => 'Voucher Management Platform.Voucher Management Platform.',
            ]),
        ]);

        $this->assertSame('Voucher Management Platform.', $project->getLocalizedTitle());
    }

    /** @test */
    public function it_preserves_a_normal_title(): void
    {
        App::setLocale('en');

        $project = new Project();
        $project->setRawAttributes([
            'title' => json_encode([
                'en' => 'Enterprise Workflow Automation',
            ]),
        ]);

        $this->assertSame('Enterprise Workflow Automation', $project->getLocalizedTitle());
    }
}
