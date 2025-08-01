<?php

namespace App\Filament\Resources;

// === Importuri pentru paginile Filament ===
use App\Filament\Resources\ProjectResource\Pages;
// =========================================

use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

// === Importuri pentru componente (asigură-te că sunt corecte) ===
// Acestea sunt importate de filament/forms și filament/tables, dar e bine să le ai explicite
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\TagsInput;
use Filament\Tables\Columns\BadgeColumn;
// ================================================================

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $navigationGroup = 'Portfolio';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('General')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('slug')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255),
                                TextInput::make('live_url')
                                    ->label('Live Demo URL')
                                    ->url(),
                                TextInput::make('github_url')
                                    ->label('GitHub URL')
                                    ->url(),
                            ]),
                        FileUpload::make('thumbnail')
                            ->image()
                            ->directory('projects/thumbnails')
                            ->maxSize(2048)
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('16:9')
                            ->imageResizeTargetWidth('800')
                            ->imageResizeTargetHeight('450')
                            ->label('Thumbnail Image'),
                        FileUpload::make('images')
                            ->image()
                            ->multiple()
                            ->directory('projects/images')
                            ->maxSize(2048)
                            ->imageResizeMode('contain')
                            ->imageResizeTargetWidth('1200')
                            ->imageResizeTargetHeight('900')
                            ->reorderable()
                            ->label('Additional Images')
                            ->helperText('Upload additional screenshots or images for this project.')
                            ->columnSpanFull(),
                    ]),

                Section::make('Translations')
                    ->schema([
                        Repeater::make('title')
                            ->label('Title Translations')
                            ->schema([
                                TextInput::make('locale')
                                    ->label('Language Code')
                                    ->required()
                                    ->maxLength(10),
                                TextInput::make('value')
                                    ->label('Translated Title')
                                    ->required()
                                    ->maxLength(255),
                            ])
                            ->columns(2)
                            ->columnSpanFull()
                            ->required()
                            ->default(
                                array_map(
                                    fn($loc) => ['locale' => $loc, 'value' => ''],
                                    config('app.available_locales', ['en'])
                                )
                            ),

                        Repeater::make('description')
                            ->label('Description Translations')
                            ->schema([
                                TextInput::make('locale')
                                    ->label('Language Code')
                                    ->required()
                                    ->maxLength(10),
                                Textarea::make('value')
                                    ->label('Translated Description')
                                    ->required()
                                    ->rows(3),
                            ])
                            ->columns(2)
                            ->columnSpanFull()
                            ->required()
                            ->default(
                                array_map(
                                    fn($loc) => ['locale' => $loc, 'value' => ''],
                                    config('app.available_locales', ['en'])
                                )
                            ),
                    ]),

                Section::make('Tech Stack')
                    ->schema([
                        TagsInput::make('tech')
                            ->label('Technologies Used')
                            ->placeholder('Add a technology')
                            ->helperText('List the main technologies used in this project.')
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),
            ]);
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Transformă repeaterul 'title' într-un array asociativ JSON
        if (isset($data['title']) && is_array($data['title'])) {
            $titleTranslations = [];
            foreach ($data['title'] as $item) {
                if (isset($item['locale']) && isset($item['value'])) {
                    $titleTranslations[$item['locale']] = $item['value'];
                }
            }
            $data['title'] = $titleTranslations;
        }

        // Transformă repeaterul 'description' într-un array asociativ JSON
        if (isset($data['description']) && is_array($data['description'])) {
            $descTranslations = [];
            foreach ($data['description'] as $item) {
                if (isset($item['locale']) && isset($item['value'])) {
                    $descTranslations[$item['locale']] = $item['value'];
                }
            }
            $data['description'] = $descTranslations;
        }

        // Ensure tech is an array
        if (isset($data['tech'])) {
            if (is_string($data['tech'])) {
                // If it's a JSON string, decode it
                $decoded = json_decode($data['tech'], true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $data['tech'] = $decoded;
                } else {
                    // If it's a comma-separated string, split it
                    $data['tech'] = array_map('trim', explode(',', $data['tech']));
                }
            } elseif (!is_array($data['tech'])) {
                // If it's neither string nor array, set to empty array
                $data['tech'] = [];
            }
        } else {
            // If tech is not set, set to empty array
            $data['tech'] = [];
        }

        return $data;
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Ensure tech is an array when filling the form
        if (isset($data['tech']) && is_string($data['tech'])) {
            $decoded = json_decode($data['tech'], true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $data['tech'] = $decoded;
            } else {
                $data['tech'] = array_map('trim', explode(',', $data['tech']));
            }
        }

        return $data;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('thumbnail')
                    ->label('Thumbnail')
                    ->size(50)
                    ->circular(),

                // Custom title column that uses the filament_title accessor
                TextColumn::make('filament_title')
                    ->label('Title')
                    // Ensure state always returns a string, handling potential array returns
                    ->state(function (Project $record): string {
                        $title = null;
                        try {
                            // Attempt to get the value from the accessor
                            $title = $record->filament_title;
                        } catch (\TypeError $e) {
                            // Fallback if accessor throws TypeError
                            \Log::error("TypeError in filament_title accessor for project ID {$record->id}: " . $e->getMessage());
                            $rawTitle = $record->getRawOriginal('title');
                            if (is_array($rawTitle)) {
                                $title = reset($rawTitle) ?? 'No Title (Raw Array)';
                            } elseif (is_string($rawTitle)) {
                                $title = $rawTitle;
                            } else {
                                $title = 'Title Error (Raw Data)';
                            }
                        } catch (\Exception $e) {
                            // Catch any other unexpected exception
                            \Log::error("Exception accessing filament_title for project ID {$record->id}: " . $e->getMessage());
                            $title = 'Title Error (Exception)';
                        }

                        // Final robust handling of the obtained value
                        if (is_array($title)) {
                            $first = reset($title);
                            return is_scalar($first) ? (string) $first : 'No Title (State Array)';
                        }
                        if (is_scalar($title)) {
                            return (string) $title;
                        }
                        if (is_null($title)) {
                            return 'No Title (Null)';
                        }
                        // Handle unexpected types (e.g., objects)
                        return 'Title Error (State Type)';
                    })
                    ->searchable(query: fn ($query, $search) =>
                        $query->whereJsonContains('title->' . app()->getLocale(), $search)
                    )
                    ->limit(50)
                    // Ensure tooltip always returns a string, handling potential array returns
                    ->tooltip(function (Project $record): string {
                        // Re-use the same robust logic as state
                        $title = null;
                        try {
                            $title = $record->filament_title;
                        } catch (\TypeError $e) {
                            \Log::error("TypeError in filament_title accessor for tooltip (ID {$record->id}): " . $e->getMessage());
                            $rawTitle = $record->getRawOriginal('title');
                            if (is_array($rawTitle)) {
                                $title = reset($rawTitle) ?? 'No Title (Raw Array)';
                            } elseif (is_string($rawTitle)) {
                                $title = $rawTitle;
                            } else {
                                $title = 'Title Error (Raw Data)';
                            }
                        } catch (\Exception $e) {
                            \Log::error("Exception accessing filament_title for tooltip (ID {$record->id}): " . $e->getMessage());
                            $title = 'Title Error (Exception)';
                        }

                        if (is_array($title)) {
                            $first = reset($title);
                            return is_scalar($first) ? (string) $first : 'No Title (Tooltip Array)';
                        }
                        if (is_scalar($title)) {
                            return (string) $title;
                        }
                        if (is_null($title)) {
                            return 'No Title (Null)';
                        }
                        return 'Title Error (Tooltip Type)';
                    }),

                // Custom tech column that ensures it's always an array
                BadgeColumn::make('tech')
                    ->label('Technologies')
                    ->formatStateUsing(function ($state) {
                        // Ensure we're working with an array
                        if (is_array($state)) {
                            return $state;
                        }
                        // If it's a JSON string, decode it
                        if (is_string($state)) {
                            $decoded = json_decode($state, true);
                            if (json_last_error() === JSON_ERROR_NONE) {
                                return $decoded;
                            }
                            // If it's a comma-separated string, split it
                            return array_map('trim', explode(',', $state));
                        }
                        // Default to empty array
                        return [];
                    }),

                TextColumn::make('images')
                    ->label('Additional Images')
                    ->formatStateUsing(fn ($state): string => is_array($state) ? count($state) . ' image(s)' : '0 images')
                    ->description(fn ($record): string => 'Click to view')
                    ->url(fn ($record) => $record->image_urls[0] ?? null)
                    ->openUrlInNewTab()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
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
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}