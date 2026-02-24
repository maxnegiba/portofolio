<?php

namespace Tests\Unit;

use App\Models\BlogPost;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class BlogPostTest extends TestCase
{
    /** @test */
    public function it_calculates_reading_time_correctly()
    {
        $post = new BlogPost();

        // 200 words -> 1 min
        $content = str_repeat('word ', 200);
        $post->setTranslation('content', 'en', $content);
        App::setLocale('en');

        $this->assertEquals('1 min read', $post->reading_time);

        // 401 words -> 3 min (ceil(401/200) = 3)
        $content = str_repeat('word ', 401);
        $post->setTranslation('content', 'en', $content);
        $this->assertEquals('3 min read', $post->reading_time);

        // 50 words -> 1 min (min)
        $content = str_repeat('word ', 50);
        $post->setTranslation('content', 'en', $content);
        $this->assertEquals('1 min read', $post->reading_time);
    }

    /** @test */
    public function it_calculates_reading_time_for_current_locale()
    {
        $post = new BlogPost();

        // English: 200 words -> 1 min
        $post->setTranslation('content', 'en', str_repeat('word ', 200));

        // Romanian: 600 words -> 3 min
        $post->setTranslation('content', 'ro', str_repeat('cuvant ', 600));

        App::setLocale('en');
        $this->assertEquals('1 min read', $post->reading_time);

        App::setLocale('ro');
        $this->assertEquals('3 min read', $post->reading_time);
    }
}
