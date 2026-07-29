# Project lifecycle repair implementation report

## Result

The Project lifecycle now uses one deterministic custom translation normalizer from database read through Filament editing and public rendering. Legacy records remain readable, ordinary text edits preserve unavailable image paths, and the repair command changes only losslessly recoverable data.

No database migration was added.

## Main files changed

- `app/Models/Project.php`
- `app/Casts/ProjectTranslationCast.php`
- `app/Support/Projects/ProjectTranslationNormalizer.php`
- `app/Support/Projects/ProjectImagePath.php`
- `app/Support/Projects/ProjectFormData.php`
- `app/Filament/Resources/ProjectResource.php`
- `app/Filament/Resources/ProjectResource/Pages/CreateProject.php`
- `app/Filament/Resources/ProjectResource/Pages/EditProject.php`
- `app/Http/Controllers/ProjectController.php`
- `app/Http/Controllers/ImageController.php`
- `app/Console/Commands/RepairProjects.php`
- `resources/views/components/project-card.blade.php`
- `resources/views/components/responsive-image.blade.php`
- `resources/views/projects/show.blade.php`
- `database/factories/ProjectFactory.php`
- project lifecycle and repair tests

The unsafe legacy `app:fix-project-data` command was removed.

## Data recovery behavior

`php artisan projects:repair --dry-run` reports every project and each translated field, including its detected representation, missing and empty locales, duplicate conflicts, malformed data, exact duplicate text, image path format, file location, category aliases, and proposed action.

`php artisan projects:repair` applies only deterministic normalization. It does not generate or copy translations across locales. `--move-private-files` copies recoverable private images to the public disk, verifies the copy, and retains the private original.

Conflicting translations, unknown nested structures, unknown categories, and missing files are reported for manual review.

## Validation

The repository includes tests for all 23 required scenarios, including Filament edit hooks, translation preservation, canonical JSON, image path resolution, category fallback, dry-run behavior, idempotence, and private-file copying.

Static parsing succeeded for all PHP source and test files, `git diff --check` passed, and the modified Blade directives are balanced. The current workspace does not include PHP or Composer, so PHPUnit could not run here. The Vite build also requires Composer's `vendor/livewire/flux` assets; run the deployment sequence below in the normal Laravel environment.

## Production backup

Run from the application root before the repair:

```bash
mkdir -p backups/project-repair
pg_dump --dbname="$DB_URL" --table=projects --data-only --column-inserts > backups/project-repair/projects.sql
pg_dump --dbname="$DB_URL" --table=seo --data-only --column-inserts > backups/project-repair/seo.sql
tar -czf backups/project-repair/storage-public.tar.gz storage/app/public
tar -czf backups/project-repair/storage-private.tar.gz storage/app/private
```

Adapt the `pg_dump` connection flags to the server's existing PostgreSQL configuration if `DB_URL` is not defined. Do not print `.env`.

## Deployment after `git pull`

No migration is required by this change.

```bash
composer install --no-dev --optimize-autoloader
php artisan optimize:clear
npm ci
npm run build
php artisan storage:link
php artisan test
```

`php artisan storage:link` is idempotent and is required only if `public/storage` is not already linked. If it is already correct, omit that command.

## Dry-run audit

```bash
php artisan projects:repair --dry-run
```

Review every `report only`, `conflicts`, `unexpected nested data`, and `file not found` entry before applying changes.

## Actual repair

```bash
php artisan projects:repair
php artisan projects:repair --dry-run
```

The second command verifies that canonical records are not modified again.

## Optional private-file recovery

Run only after the ordinary audit and backups:

```bash
php artisan projects:repair --dry-run --move-private-files
php artisan projects:repair --move-private-files
php artisan projects:repair --dry-run
```

Despite the compatibility option name, files are copied and verified; private originals are not deleted.

## Rollback

Deploy the previous application commit first. Restore table backups within a maintenance window using the server's normal PostgreSQL restore procedure. Restore `storage/app/public` and `storage/app/private` from the archives if required. Do not remove copied public images until record paths and restored data have been verified.
