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
                            ->directory('projects/thumbnails') // Consider a specific directory
                            ->maxSize(2048)
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('16:9')
                            ->imageResizeTargetWidth('800')
                            ->imageResizeTargetHeight('450')
                            ->label('Thumbnail Image'),
                        // === NEW: Multiple Images Upload ===
                        FileUpload::make('images')
                            ->image()
                            ->multiple() // Allow multiple files
                            ->directory('projects/images') // Specific directory for additional images
                            ->maxSize(2048)
                            ->imageResizeMode('contain') // Or 'cover' if you prefer
                            ->imageResizeTargetWidth('1200') // Adjust as needed
                            ->imageResizeTargetHeight('900') // Adjust as needed
                            ->reorderable() // Allow reordering
                            ->label('Additional Images')
                            ->helperText('Upload additional screenshots or images for this project.')
                            ->columnSpanFull(),
                         // =============================
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
                            // Setează valori implicite pentru localele disponibile
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
                            // Setează valori implicite pentru localele disponibile
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
            // === Transformă datele din Repeater în formatul JSON așteptat de model ===
            // NOTĂ: Această parte a fost mutată în afara apelului ->schema([...])
            // și este acum o metodă separată a clasei ProjectResource.
            // ========================================================================
    }
    // === METODĂ CORECTĂ PENTRU MUTARE DATE ===
    // Aceasta este metoda care trebuie definită în clasa Resource, nu înlănțuită la form()
    // Updated to handle 'images' which is now a direct array from FileUpload::multiple()
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
            $data['title'] = $titleTranslations; // Va fi transformat în JSON de Laravel
        }
        // Transformă repeaterul 'description' într-un array asociativ JSON
        if (isset($data['description']) && is_array($data['description'])) {
            $descTranslations = [];
            foreach ($data['description'] as $item) {
                if (isset($item['locale']) && isset($item['value'])) {
                    $descTranslations[$item['locale']] = $item['value'];
                }
            }
            $data['description'] = $descTranslations; // Va fi transformat în JSON de Laravel
        }
        
        // Ensure tech is an array
        if (isset($data['tech']) && is_string($data['tech'])) {
            // If it's a JSON string, decode it
            $decoded = json_decode($data['tech'], true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $data['tech'] = $decoded;
            } else {
                // If it's a comma-separated string, split it
                $data['tech'] = array_map('trim', explode(',', $data['tech']));
            }
        }
        
        // 'images' is already an array of paths from FileUpload::multiple(), no transformation needed
        // It will be cast to JSON by Laravel automatically when saved.
        return $data;
    }
    // =========================================
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('thumbnail')
                    ->label('Thumbnail')
                    ->size(50)
                    ->circular(),
                // Afișează titlul în limba curentă (datorită accessorului din model)
                TextColumn::make('title')
                    ->label('Title')
                    // Căutare în JSON - caută în toate localele
                    ->searchable(query: function ($query, $search) {
                         return $query->whereJsonContains('title', $search);
                    })
                    ->limit(50)
                    ->tooltip(function (Project $record): string {
                        // Afișează titlul în limba curentă pentru tooltip
                        $locale = app()->getLocale();
                        $titles = $record->getRawOriginal('title'); // Obține JSON-ul brut (array)
                        if (is_array($titles)) {
                             return $titles[$locale] ?? $titles[config('app.fallback_locale', 'en')] ?? '';
                        }
                        return (string) $titles;
                    })
                    ->formatStateUsing(fn ($state, $record) => $record->title), // Utilizează accessorul pentru afișare
                TextColumn::make('tech')
                    ->label('Technologies')
                    ->badge() // Afișează ca badge-uri
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
                    })
                    ->toggleable(),
                 // === NEW: Column to show number of additional images ===
                 TextColumn::make('images')
                    ->label('Additional Images')
                    ->formatStateUsing(fn ($state): string => is_array($state) ? count($state) . ' image(s)' : '0 images')
                    ->description(fn ($record): string => 'Click to view')
                    ->url(fn ($record) => $record->image_urls[0] ?? null) // Link to first image if exists
                    ->openUrlInNewTab()
                    ->toggleable(),
                 // ========================================================
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