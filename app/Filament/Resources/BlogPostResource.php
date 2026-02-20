<?php

namespace App\Filament\Resources;

// === Importuri necesare pentru Tabs ===
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder; // <--- Ensure this is present for the filter
// =====================================

use App\Filament\Resources\BlogPostResource\Pages; // <--- This import is crucial
use App\Models\BlogPost;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Forms\Set;
use Filament\Forms\Get; // <--- Add Get for accessing other fields in afterStateUpdated

class BlogPostResource extends Resource
{
    protected static ?string $model = BlogPost::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationGroup = 'Content';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        // === Secțiunea de Conținut cu Tabs pentru traduceri ===
                        Forms\Components\Section::make(__('blog.form_content_section'))
                            ->schema([
                                // Tabs pentru traduceri
                                Tabs::make('Translations')
                                    ->tabs(
                                        array_map(function (string $locale) {
                                            return Tab::make(Str::upper($locale))
                                                ->schema([
                                                    Forms\Components\TextInput::make("title.{$locale}")
                                                        ->label(__('blog.title_label') . " ({$locale})")
                                                        ->required()
                                                        ->maxLength(255)
                                                        ->live(debounce: 500)
                                                        ->afterStateUpdated(function (Set $set, ?string $state, Get $get) use ($locale) {
                                                            // Generează slug doar dacă câmpul slug.$locale este gol
                                                            $currentSlug = $get("slug.{$locale}");
                                                            if (empty($currentSlug)) {
                                                                $set("slug.{$locale}", Str::slug($state));
                                                            }
                                                        }),
                                                    // === MUTA SLUG AICI ===
                                                    Forms\Components\TextInput::make("slug.{$locale}")
                                                        ->label(__('blog.slug_label') . " ({$locale})")
                                                        ->required()
                                                        ->maxLength(255)
                                                        // ->unique(ignoreRecord: true) // Unique per locale? Complex. Ensure unique manually or via custom rule.
                                                        ->helperText(__('blog.slug_helper', ['locale' => $locale])), // Add helper translation
                                                    // =====================
                                                    Forms\Components\RichEditor::make("content.{$locale}")
                                                        ->label(__('blog.content_label') . " ({$locale})")
                                                        ->required()
                                                        ->columnSpanFull()
                                                        ->fileAttachmentsDirectory('blog/images')
                                                        ->fileAttachmentsVisibility('public'),
                                                    Forms\Components\Textarea::make("excerpt.{$locale}")
                                                        ->label(__('blog.excerpt_label') . " ({$locale})")
                                                        ->maxLength(65535)
                                                        ->columnSpanFull()
                                                        ->helperText(__('blog.excerpt_helper')),
                                                ]);
                                        }, config('app.available_locales', ['en'])) // Presupune că ai 'available_locales' în config/app.php
                                    )
                                    ->columnSpanFull(),
                                // === SCOS slug de aici ===
                                // Forms\Components\TextInput::make('slug')
                                //     ->label(__('blog.slug_label'))
                                //     ->required()
                                //     ->maxLength(255)
                                //     ->unique(ignoreRecord: true) // Asigură-te că funcționează corect cu logica modelului
                                //     ->helperText('Acest slug este unic global. Dacă vrei slug-uri traduse, trebuie să modifici modelul și migrarea.'),
                                // ========================
                            ]),
                        // =====================================================
                        // === Secțiunea SEO/Meta cu Tabs pentru traduceri ===
                        Forms\Components\Section::make(__('blog.seo_meta_section'))
                            ->schema([
                                Tabs::make('Meta Translations')
                                    ->tabs(
                                        array_map(function (string $locale) {
                                            return Tab::make(Str::upper($locale) . ' Meta')
                                                ->schema([
                                                    Forms\Components\Textarea::make("meta_description.{$locale}")
                                                        ->label(__('blog.meta_description_label') . " ({$locale})")
                                                        ->maxLength(160)
                                                        ->helperText(__('blog.meta_description_helper')),
                                                    // Dacă vrei meta_keywords tradus, aplică același principiu cu Tabs aici
                                                    // Forms\Components\TagsInput::make("meta_keywords.{$locale}")
                                                    //     ->label(__('blog.meta_keywords_label') . " ({$locale})")
                                                    //     ->placeholder(__('blog.meta_keywords_placeholder'))
                                                    //     ->helperText(__('blog.meta_keywords_helper')),
                                                ]);
                                        }, config('app.available_locales', ['en']))
                                    )
                                    ->columnSpanFull(),
                                // Dacă meta_keywords NU e tradus, îl pui aici:
                                Forms\Components\TagsInput::make('meta_keywords')
                                    ->label(__('blog.meta_keywords_label'))
                                    ->placeholder(__('blog.meta_keywords_placeholder'))
                                    ->helperText(__('blog.meta_keywords_helper')),
                            ]),
                        // ====================================================
                    ])
                    ->columnSpan(['lg' => 2]),
                Forms\Components\Group::make()
                    ->schema([
                        // Secțiunea de Publicare (rămâne neschimbată)
                        Forms\Components\Section::make(__('blog.publishing_section'))
                            ->schema([
                                Forms\Components\FileUpload::make('featured_image')
                                    ->label(__('blog.featured_image_label'))
                                    ->image()
                                    ->directory('blog/featured')
                                    ->maxSize(2048)
                                    ->imageResizeMode('cover')
                                    ->imageCropAspectRatio('16:9')
                                    ->imageResizeTargetWidth('1200')
                                    ->imageResizeTargetHeight('675'),
                                Forms\Components\Toggle::make('is_published')
                                    ->label(__('blog.is_published_label'))
                                    ->helperText(__('blog.is_published_helper')),
                                Forms\Components\DateTimePicker::make('published_at')
                                    ->label(__('blog.published_at_label'))
                                    ->default(now())
                                    ->helperText(__('blog.published_at_helper')),
                            ]),
                        // Secțiunea Autor (rămâne neschimbată)
                        Forms\Components\Section::make(__('blog.author_section'))
                            ->schema([
                                Forms\Components\Select::make('user_id')
                                    ->label(__('blog.author_label'))
                                    ->relationship('user', 'name')
                                    ->default(auth()->id())
                                    ->required(),
                            ]),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('featured_image')
                    ->label(__('blog.image_column'))
                    ->circular()
                    ->size(50),
                // Modificăm pentru a afișa titlul în limba curentă
                Tables\Columns\TextColumn::make('title')
                    ->label(__('blog.title_column'))
                    // Căutare în JSON - simplificată, caută în toate localele
                    ->searchable(query: function ($query, $search) {
                         return $query->whereJsonContains('title', $search);
                    })
                    ->limit(50)
                    ->tooltip(function (BlogPost $record): string {
                        // Afișează titlul în limba curentă
                        return $record->getTranslation('title', app()->getLocale());
                    })
                    ->formatStateUsing(fn ($state, $record) => $record->getTranslation('title', app()->getLocale())), // Afișează titlul în limba curentă
                Tables\Columns\TextColumn::make('user.name')
                    ->label(__('blog.author_column'))
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\ToggleColumn::make('is_published')
                    ->label(__('blog.published_column'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('published_at')
                    ->label(__('blog.published_at_column'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('reading_time')
                    ->label(__('blog.reading_time_column'))
                    ->suffix(' min')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('blog.created_at_column'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('is_published')
                    ->label(__('blog.status_filter'))
                    ->options([
                        true => __('blog.published_option'),
                        false => __('blog.draft_option'),
                    ]),
                Tables\Filters\Filter::make('published_at')
                    ->label(__('blog.date_filter'))
                    ->form([
                        Forms\Components\DatePicker::make('published_from')
                            ->label(__('blog.from_date')),
                        Forms\Components\DatePicker::make('published_until')
                            ->label(__('blog.to_date')),
                    ])
                    // === Corectare aplicată aici ===
                    ->query(function (Builder $query, array $data): Builder { // <--- Schimbare aici
                        return $query
                            ->when($data['published_from'], fn ($query, $date) => $query->whereDate('published_at', '>=', $date))
                            ->when($data['published_until'], fn ($query, $date) => $query->whereDate('published_at', '<=', $date));
                    }),
                    // =============================
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()->label(__('blog.view_action')),
                    Tables\Actions\EditAction::make()->label(__('blog.edit_action')),
                    Tables\Actions\DeleteAction::make()->label(__('blog.delete_action')),
                    Tables\Actions\Action::make('duplicate')
                        ->label(__('blog.duplicate_action'))
                        ->icon('heroicon-o-document-duplicate')
                        ->action(function (BlogPost $record) {
                            // Replicarea necesită ajustări pentru datele traducibile
                            $newPost = $record->replicate();
                            // Ajustează titlul copiei pentru limba implicită
                            $defaultLocale = config('app.locale', 'en');
                            $originalTitleDefaultLocale = $record->getTranslation('title', $defaultLocale, false) ?? $record->title;
                            $newTitleDefaultLocale = $originalTitleDefaultLocale . ' (Copy)';
                            $newPost->setTranslation('title', $defaultLocale, $newTitleDefaultLocale);
                            // Ajustează slug-ul copiei (poate fi necesar să fie unic)
                            // Get the original slug for the default locale
                            $originalSlugDefaultLocale = $record->getTranslation('slug', $defaultLocale, false) ?? $record->slug; // Fallback to string slug if needed
                            $newPost->setTranslation('slug', $defaultLocale, $originalSlugDefaultLocale . '-copy');
                            // Resetează statusul de publicare
                            $newPost->is_published = false;
                            $newPost->published_at = null;
                            $newPost->save();
                            // Notificare
                            \Filament\Notifications\Notification::make()
                                ->title(__('blog.duplicate_success'))
                                ->success()
                                ->send();
                        }),
                    Tables\Actions\Action::make('preview')
                        ->label(__('blog.preview_action'))
                        ->icon('heroicon-o-eye')
                        ->url(fn (BlogPost $record) => route('blog.show', ['locale' => config('app.locale', 'en'), 'slug' => $record->getTranslation('slug', config('app.locale', 'en'))])) // Previzualizare în limba implicită sau curentă
                        ->openUrlInNewTab(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label(__('blog.delete_bulk')),
                    Tables\Actions\BulkAction::make('publish')
                        ->label(__('blog.publish_bulk'))
                        ->icon('heroicon-o-check')
                        ->action(function ($records) {
                            $records->each->update(['is_published' => true]);
                            \Filament\Notifications\Notification::make()
                                ->title(__('blog.publish_success'))
                                ->success()
                                ->send();
                        }),
                    Tables\Actions\BulkAction::make('unpublish')
                        ->label(__('blog.unpublish_bulk'))
                        ->icon('heroicon-o-x-mark')
                        ->action(function ($records) {
                            $records->each->update(['is_published' => false]);
                            \Filament\Notifications\Notification::make()
                                ->title(__('blog.unpublish_success'))
                                ->success()
                                ->send();
                        }),
                ]),
            ])
            ->defaultSort('published_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    // === CORECTED getPages METHOD ===
    public static function getPages(): array
    {
        // Ensure the Pages namespace alias is correctly imported at the top
        return [
            'index' => Pages\ListBlogPosts::route('/'), // Standard index route
            'create' => Pages\CreateBlogPost::route('/create'),
            'edit' => Pages\EditBlogPost::route('/{record}/edit'),
            // Removed the redundant 'list' route pointing to the same page class
            // 'list' => Pages\ListBlogPost::route('/list'),
        ];
    }
    // ================================

    public static function getModelLabel(): string
    {
        return __('blog.post');
    }

    public static function getPluralModelLabel(): string
    {
        return __('blog.posts');
    }

    public static function getNavigationLabel(): string
    {
        return __('blog.posts');
    }
}
