# Project data repair analysis

## Scope

This analysis covers the custom `Project` translation system, Filament create/edit lifecycle, project grouping, image storage, image rendering, and safe recovery of legacy records. The `Project` model intentionally remains independent of `spatie/laravel-translatable`.

## Confirmed root causes

### Filament lifecycle code never ran

`mutateFormDataBeforeFill()` and `mutateFormDataBeforeSave()` were defined on `ProjectResource`. In Filament 3 these record lifecycle hooks belong to the `CreateRecord` and `EditRecord` page classes. `CreateProject` and `EditProject` were empty, so translation repeaters were not reliably hydrated or converted to the canonical database representation.

### Model accessors destroyed the form's translation map

The model combined Laravel `array` casts with legacy `getTitleAttribute()` and `getDescriptionAttribute()` accessors. Depending on the access path, the same attribute could be a JSON string, an associative array, a repeater array, or a localized string. Filament sometimes received only the active locale instead of the complete translation map, and the next save could overwrite the other locale.

The narrative fields duplicated similar parsing logic and did not share one deterministic normalization rule.

### Uploads used the wrong default disk

The default filesystem disk is `local`, whose root is `storage/app/private`. Project `FileUpload` fields did not specify a disk, so new thumbnails and gallery files could be stored privately while public rendering assumed `storage/app/public`.

### Responsive image URLs were composed from already-resolved URLs

The responsive image component stripped only simple `storage/` prefixes. An absolute URL could be embedded inside `/img/cache/{width}/{path}`, generating an invalid optimizer request. Its fallback also prepended `img/` to project storage paths, producing another invalid URL.

### Category grouping hid legacy values

The controller grouped projects by the raw `category` value, while the view rendered only `web_platform` and `automation`. Null, blank, differently-cased, and older values such as `web_app` were therefore omitted from both tabs.

### The old repair command could invent translations

`app:fix-project-data` copied a plain string into every configured locale. This made missing Romanian content appear translated even though no Romanian source existed. It also had no dry-run mode, no image audit, and no idempotence report.

## Legacy formats found in code and history

Repository code and history explicitly support or produced:

- associative locale maps: `{"en":"...","ro":"..."}`;
- Filament repeater rows: `[{"locale":"en","value":"..."}]`;
- plain strings used by the project factory and earlier code;
- JSON strings decoded through overlapping model accessors and casts;
- comma-separated or JSON technology lists;
- relative image paths, `/storage/...` paths, static `img/...` paths, and absolute URLs.

Git history confirms application-code changes that introduced the repeater interface and later placed conversion hooks in the resource class. It does not contain production database rows, so it cannot recover missing production translations.

## Canonical formats

- Translations: associative JSON locale map, for example `{"en":"...","ro":"..."}`.
- Technologies: JSON list of non-empty strings.
- Categories: `web_platform` or `automation`.
- Public-disk uploads: relative paths such as `projects/thumbnails/example.webp`.
- External images: complete URL retained for backward compatibility and bypassed by the local optimizer.

The model's translated properties now always cast to complete translation maps. Localized display is available only through explicit methods such as `getLocalizedProjectValue()`.

## Recovery rules

Safe automatic repairs:

- decode JSON and double-encoded JSON;
- convert repeater rows to an associative map;
- normalize locale codes to lowercase;
- let a non-empty duplicate replace an earlier empty row;
- keep the first non-empty value when duplicate rows agree or later rows are empty;
- remove an exact two-half duplicate only when both byte sequences are identical;
- assign a plain legacy string only to the configured fallback locale;
- normalize known category aliases;
- normalize `/storage/...` and same-domain storage URLs to relative public-disk paths;
- preserve external URLs;
- preserve image order;
- copy a private file only with the explicit `--move-private-files` option, verify the public copy, and leave the private source intact.

## Unrecoverable or report-only cases

The command does not invent missing translations. It reports and preserves:

- missing locales without a source value;
- conflicting non-empty duplicate locale rows;
- unexpected nested translation structures;
- unknown category values (the frontend uses a visible `web_platform` fallback);
- missing image files;
- production content absent from the repository and backups.

Conflicting duplicate rows are not canonicalized automatically because choosing one would discard real content.

## Filesystem strategy

Filament uploads explicitly target the `public` disk with public visibility. The edit form hydrates only files that exist on that disk. Existing paths are merged back during ordinary text edits. Explicit confirmation toggles distinguish intentional thumbnail removal, gallery removal/reordering, and complete gallery clearing from an empty or partially hydrated upload state.

The frontend path resolver distinguishes:

- public-disk paths;
- `/storage/...` legacy paths;
- static public assets;
- same-domain absolute storage URLs;
- external URLs.

Only local resolvable files use the optimizer.

## Migration and rollback strategy

No schema migration is required. Existing JSON columns remain unchanged.

Before a production repair:

```bash
mkdir -p backups/project-repair
pg_dump --dbname="$DB_URL" --table=projects --data-only --column-inserts > backups/project-repair/projects.sql
pg_dump --dbname="$DB_URL" --table=seo --data-only --column-inserts > backups/project-repair/seo.sql
tar -czf backups/project-repair/storage-public.tar.gz storage/app/public
tar -czf backups/project-repair/storage-private.tar.gz storage/app/private
```

If production does not expose `DB_URL`, use the configured PostgreSQL host, port, database, and user with `pg_dump` instead of printing credentials.

Rollback consists of deploying the previous Git commit and restoring the backed-up table data and storage archives. Because private-file recovery copies rather than deletes, its source files remain available.
