<?php

namespace App\Console\Commands;

use App\Models\BlogPost;
use App\Models\Project;
use App\Services\GroqTranslationService;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class TranslateToVitameza extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translate:vitameza {--only-blog} {--only-projects} {--dry-run}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Translate all blog posts and projects to Vitameza language using Groq API';

    protected GroqTranslationService $translator;

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->translator = new GroqTranslationService();

        $this->info('🚀 Starting translation to Vitameza language...');
        $this->newLine();

        $onlyBlog = $this->option('only-blog');
        $onlyProjects = $this->option('only-projects');
        $dryRun = $this->option('dry-run');

        $totalTranslated = 0;

        // Translate Blog Posts
        if (!$onlyProjects) {
            $blogCount = $this->translateBlogPosts($dryRun);
            $totalTranslated += $blogCount;
        }

        // Translate Projects
        if (!$onlyBlog) {
            $projectCount = $this->translateProjects($dryRun);
            $totalTranslated += $projectCount;
        }

        $this->newLine();
        $this->info("✅ Translation complete! Total items translated: {$totalTranslated}");

        if ($dryRun) {
            $this->warn('⚠️  DRY RUN - No changes were saved to the database.');
        }

        return self::SUCCESS;
    }

    /**
     * Translate all blog posts
     */
    protected function translateBlogPosts(bool $dryRun = false): int
    {
        $this->info('📝 Translating Blog Posts...');
        $this->newLine();

        $posts = BlogPost::all();
        $count = 0;

        $this->withProgressBar($posts, function ($post) use ($dryRun, &$count) {
            try {
                $this->translateBlogPost($post, $dryRun);
                $count++;
            } catch (\Exception $e) {
                $this->error("Error translating post '{$post->title->en}': {$e->getMessage()}");
            }
        });

        $this->newLine(2);
        $this->info("✅ Translated {$count} blog posts");

        return $count;
    }

    /**
     * Translate a single blog post
     */
    protected function translateBlogPost(BlogPost $post, bool $dryRun = false): void
    {
        $originalTitle = $post->getTranslation('title', 'en');
        $originalExcerpt = $post->getTranslation('excerpt', 'en');
        $originalContent = $post->getTranslation('content', 'en');

        // Translate title
        $translatedTitle = $this->translator->translate(
            $originalTitle,
            'vitameza',
            'Blog post title'
        );

        // Translate excerpt
        $translatedExcerpt = $this->translator->translate(
            $originalExcerpt,
            'vitameza',
            'Blog post excerpt - short summary'
        );

        // Translate content (might be long, so be careful)
        $translatedContent = $this->translator->translate(
            $originalContent,
            'vitameza',
            'Blog post content - preserve markdown formatting if present'
        );

        // Generate slug from translated title
        $translatedSlug = Str::slug($translatedTitle);

        // Translate meta description
        $metaDescription = $post->getTranslation('meta_description', 'en');
        $translatedMetaDesc = $this->translator->translate(
            $metaDescription,
            'vitameza',
            'SEO meta description'
        );

        if (!$dryRun) {
            $post->setTranslation('title', 'vitameza', $translatedTitle);
            $post->setTranslation('excerpt', 'vitameza', $translatedExcerpt);
            $post->setTranslation('content', 'vitameza', $translatedContent);
            $post->setTranslation('slug', 'vitameza', $translatedSlug);
            $post->setTranslation('meta_description', 'vitameza', $translatedMetaDesc);
            $post->save();
        }
    }

    /**
     * Translate all projects
     */
    protected function translateProjects(bool $dryRun = false): int
    {
        $this->info('🎯 Translating Projects...');
        $this->newLine();

        $projects = Project::all();
        $count = 0;

        $this->withProgressBar($projects, function ($project) use ($dryRun, &$count) {
            try {
                $this->translateProject($project, $dryRun);
                $count++;
            } catch (\Exception $e) {
                $this->error("Error translating project '{$project->title}': {$e->getMessage()}");
            }
        });

        $this->newLine(2);
        $this->info("✅ Translated {$count} projects");

        return $count;
    }

    /**
     * Translate a single project
     */
    protected function translateProject(Project $project, bool $dryRun = false): void
    {
        // Get raw title and description
        $titleArray = $project->getRawOriginal('title');
        $descArray = $project->getRawOriginal('description');

        // Parse title
        $originalTitle = $this->extractTextFromLocalized($titleArray, 'en');
        $originalDesc = $this->extractTextFromLocalized($descArray, 'en');

        // Translate
        $translatedTitle = $this->translator->translate(
            $originalTitle,
            'vitameza',
            'Project title'
        );

        $translatedDesc = $this->translator->translate(
            $originalDesc,
            'vitameza',
            'Project description - preserve formatting'
        );

        $translatedSlug = Str::slug($translatedTitle);

        if (!$dryRun) {
            // Update title
            $titleData = is_string($titleArray) ? json_decode($titleArray, true) : $titleArray;
            if (!is_array($titleData)) {
                $titleData = [];
            }
            $titleData['vitameza'] = $translatedTitle;
            $project->title = $titleData;

            // Update description
            $descData = is_string($descArray) ? json_decode($descArray, true) : $descArray;
            if (!is_array($descData)) {
                $descData = [];
            }
            $descData['vitameza'] = $translatedDesc;
            $project->description = $descData;

            // Update slug
            $slugArray = $project->getRawOriginal('slug');
            $slugData = is_string($slugArray) ? json_decode($slugArray, true) : $slugArray;
            if (!is_array($slugData)) {
                $slugData = [];
            }
            $slugData['vitameza'] = $translatedSlug;
            $project->slug = $slugData;

            $project->save();
        }
    }

    /**
     * Extract English text from localized data
     */
    protected function extractTextFromLocalized($data, string $locale = 'en'): string
    {
        // If it's a JSON string
        if (is_string($data)) {
            $decoded = json_decode($data, true);
            if (is_array($decoded)) {
                return $decoded[$locale] ?? reset($decoded) ?? '';
            }
            return $data;
        }

        // If it's already an array
        if (is_array($data)) {
            return $data[$locale] ?? reset($data) ?? '';
        }

        return '';
    }
}
