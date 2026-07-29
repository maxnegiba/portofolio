<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Models\Project;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use RalphJSmit\Filament\SEO\SEO;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $navigationGroup = 'Portfolio';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('General')
                ->schema([
                    Grid::make(2)->schema([
                        TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Select::make('category')
                            ->options([
                                'web_platform' => 'Enterprise Web Apps',
                                'automation' => 'Workflow Automations',
                            ])
                            ->required()
                            ->default('web_platform'),
                        TextInput::make('live_url')
                            ->label('Live Demo URL')
                            ->url(),
                        TextInput::make('github_url')
                            ->label('GitHub URL')
                            ->url(),
                    ]),
                    FileUpload::make('thumbnail')
                        ->image()
                        ->disk('public')
                        ->visibility('public')
                        ->directory('projects/thumbnails')
                        ->maxSize(2048)
                        ->imageResizeMode('cover')
                        ->imageCropAspectRatio('16:9')
                        ->imageResizeTargetWidth('800')
                        ->imageResizeTargetHeight('450')
                        ->label('Thumbnail Image')
                        ->helperText('Existing public images are preserved unless you remove them. Legacy or external paths require the explicit removal switch below.'),
                    Toggle::make('remove_existing_thumbnail')
                        ->label('Intentionally remove the existing thumbnail')
                        ->helperText('Use this switch when removing a thumbnail. It prevents an empty upload state from deleting an image accidentally.')
                        ->default(false)
                        ->dehydrated(),
                    FileUpload::make('images')
                        ->image()
                        ->multiple()
                        ->disk('public')
                        ->visibility('public')
                        ->directory('projects/images')
                        ->maxSize(2048)
                        ->imageResizeMode('contain')
                        ->imageResizeTargetWidth('1200')
                        ->imageResizeTargetHeight('900')
                        ->reorderable()
                        ->appendFiles()
                        ->label('Additional Images')
                        ->helperText('Reorder or remove previewed files. Unpreviewable legacy paths remain untouched unless “Remove all gallery images” is enabled.')
                        ->columnSpanFull(),
                    Toggle::make('apply_gallery_changes')
                        ->label('Apply gallery removals and reordering')
                        ->helperText('Enable after intentionally removing or reordering individual gallery files. New uploads are appended safely even when this is disabled.')
                        ->default(false)
                        ->dehydrated()
                        ->columnSpanFull(),
                    Toggle::make('remove_all_images')
                        ->label('Remove all gallery images, including unpreviewable legacy paths')
                        ->default(false)
                        ->dehydrated()
                        ->columnSpanFull(),
                ]),

            Tabs::make('Project translations')
                ->tabs(collect(config('app.available_locales', ['en', 'ro']))
                    ->map(fn (string $locale): Tab => self::translationTab($locale))
                    ->all())
                ->columnSpanFull(),

            Section::make('Tech Stack')
                ->schema([
                    TagsInput::make('tech')
                        ->label('Technologies Used')
                        ->placeholder('Add a technology')
                        ->helperText('List the main technologies used in this project.')
                        ->columnSpanFull(),
                ])
                ->collapsible(),

            Section::make('SEO')
                ->schema([SEO::make()])
                ->collapsible(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('thumbnail_url')
                    ->label('Thumbnail')
                    ->size(50),
                TextColumn::make('filament_title')
                    ->label('Title')
                    ->limit(50)
                    ->tooltip(fn (Project $record): string => $record->filament_title),
                TextColumn::make('slug')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                BadgeColumn::make('tech')
                    ->label('Technologies'),
                TextColumn::make('images')
                    ->label('Additional Images')
                    ->formatStateUsing(fn (mixed $state): string => is_array($state) ? count($state).' image(s)' : '0 images')
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }

    private static function translationTab(string $locale): Tab
    {
        $locale = strtolower(trim($locale));
        $label = config("laravellocalization.supportedLocales.{$locale}.name", strtoupper($locale));

        return Tab::make((string) $label)
            ->schema([
                TextInput::make("translations.{$locale}.title")
                    ->label('Title')
                    ->required(fn (string $operation): bool => $operation === 'create'
                        && $locale === config('app.fallback_locale', 'en'))
                    ->maxLength(255),
                Textarea::make("translations.{$locale}.description")
                    ->label('Description')
                    ->rows(4),
                RichEditor::make("translations.{$locale}.problem")
                    ->label('Problem / Challenge'),
                RichEditor::make("translations.{$locale}.solution")
                    ->label('Solution'),
                RichEditor::make("translations.{$locale}.business_result")
                    ->label('Business Result'),
            ]);
    }
}
