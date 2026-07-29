<?php

namespace Tests\Unit;

use App\Models\Project;
use PHPUnit\Framework\TestCase;

class ProjectCategoryTest extends TestCase
{
    public function test_known_legacy_categories_are_normalized(): void
    {
        $this->assertSame('web_platform', Project::normalizeCategory(' Web App '));
        $this->assertSame('web_platform', Project::normalizeCategory('web_application'));
        $this->assertSame('automation', Project::normalizeCategory('Workflow Automations'));
    }

    public function test_unknown_category_uses_visible_fallback_but_is_not_marked_canonical(): void
    {
        $this->assertNull(Project::canonicalCategory('legacy_unknown'));
        $this->assertSame('web_platform', Project::normalizeCategory('legacy_unknown'));
    }
}
