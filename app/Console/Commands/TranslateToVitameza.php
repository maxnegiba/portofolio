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
    protected $description = 'Translate all blog posts and projects to Vietnamese language (stored as vi) using Groq API';

    protected GroqTranslationService $translator;

    // Standardize on 'vi' key, but keep 'vitameza' awareness if needed for legacy migration
    protected string $targetLocale = 'vi';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->translator = new GroqTranslationService();

        $this->info("🚀 Starting translation to Vietnamese language ({$this->targetLocale})...");
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
                $postTitle = $this->getSafeTitle($post->title);
                $this->error("Error translating post '{$postTitle}': {$e->getMessage()}");
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
            $this->targetLocale, // 'vi'
            'Blog post title'
        );

        // Translate excerpt
        $translatedExcerpt = $this->translator->translate(
            $originalExcerpt,
            $this->targetLocale,
            'Blog post excerpt - short summary'
        );

        // Translate content (might be long, so be careful)
        $translatedContent = $this->translator->translate(
            $originalContent,
            $this->targetLocale,
            'Blog post content - preserve markdown formatting if present'
        );

        // Generate slug from translated title
        $translatedSlug = Str::slug($translatedTitle);

        // Translate meta description
        $metaDescription = $post->getTranslation('meta_description', 'en');
        $translatedMetaDesc = $this->translator->translate(
            $metaDescription,
            $this->targetLocale,
            'SEO meta description'
        );

        if (!$dryRun) {
            // Save to 'vi'
            $post->setTranslation('title', $this->targetLocale, $translatedTitle);
            $post->setTranslation('excerpt', $this->targetLocale, $translatedExcerpt);
            $post->setTranslation('content', $this->targetLocale, $translatedContent);
            $post->setTranslation('slug', $this->targetLocale, $translatedSlug);
            $post->setTranslation('meta_description', $this->targetLocale, $translatedMetaDesc);

            // OPTIONAL: Also save to 'vitameza' for backward compatibility if needed,
            // but we want to standardize. Let's just stick to 'vi' as requested.

            $post->save();
        }
    }

    /**
     * Translate all projects
     */
    protected function translateProjects(bool $dryRun = false): int
    {
        $this->info('🏗️ Translating Projects...');
        $this->newLine();

        $projects = Project::all();
        $count = 0;

        $this->withProgressBar($projects, function ($project) use ($dryRun, &$count) {
            try {
                $this->translateProject($project, $dryRun);
                $count++;
            } catch (\Exception $e) {
                $projectTitle = $this->getSafeTitle($project->title);
                $this->error("Error translating project '{$projectTitle}': {$e->getMessage()}");
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
            $this->targetLocale,
            'Project title'
        );

        $translatedDesc = $this->translator->translate(
            $originalDesc,
            $this->targetLocale,
            'Project description - preserve formatting'
        );

        $translatedSlug = Str::slug($translatedTitle);

        if (!$dryRun) {
            // Update title
            $titleData = is_string($titleArray) ? json_decode($titleArray, true) : $titleArray;
            if (!is_array($titleData)) {
                $titleData = [];
            }
            $titleData[$this->targetLocale] = $translatedTitle;
            $project->title = $titleData;

            // Update description
            $descData = is_string($descArray) ? json_decode($descArray, true) : $descArray;
            if (!is_array($descData)) {
                $descData = [];
            }
            $descData[$this->targetLocale] = $translatedDesc;
            $project->description = $descData;

            // Update slug
            $slugArray = $project->getRawOriginal('slug');
            $slugData = is_string($slugArray) ? json_decode($slugArray, true) : $slugArray;
            if (!is_array($slugData)) {
                $slugData = [];
            }
            $slugData[$this->targetLocale] = $translatedSlug;
            $project->slug = $slugData;

            $project->save();
        }
    }

    /**
     * Extract English text from localized data
     * Returns string in all cases
     */
    protected function extractTextFromLocalized($data, string $locale = 'en'): string
    {
        // If it's a JSON string
        if (is_string($data)) {
            $decoded = json_decode($data, true);
            if (is_array($decoded)) {
                // Try to get specific locale
                $value = $decoded[$locale] ?? null;
                if (is_string($value)) {
                    return $value;
                }
                
                // Fallback to first string value
                foreach ($decoded as $v) {
                    if (is_string($v)) {
                        return $v;
                    }
                }
                
                return '';
            }
            return $data;
        }

        // If it's already an array
        if (is_array($data)) {
            // Try to get specific locale
            $value = $data[$locale] ?? null;
            if (is_string($value)) {
                return $value;
            }
            
            // Fallback to first string value
            foreach ($data as $v) {
                if (is_string($v)) {
                    return $v;
                }
            }
            
            return '';
        }

        return '';
    }

    /**
     * Safely get title from post (handles both string and array)
     */
    protected function getSafeTitle($title): string
    {
        if (is_string($title)) {
            // Try to decode JSON
            $decoded = json_decode($title, true);
            if (is_array($decoded)) {
                return $decoded['en'] ?? reset($decoded) ?? 'Unknown';
            }
            return $title;
        }

        if (is_array($title)) {
            return $title['en'] ?? reset($title) ?? 'Unknown';
        }

        if (is_object($title) && isset($title->en)) {
            return $title->en;
        }

        return 'Unknown';
    }
}
