<?php

namespace App\Filament\Resources;

use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Toggle;

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
                                    ->unique(ignoreRecord: true),
                                TextInput::make('live_url')
                                    ->label('Live Demo URL')
                                    ->url(),
                                TextInput::make('github_url')
                                    ->label('GitHub URL')
                                    ->url(),
                            ]),
                        FileUpload::make('thumbnail')
                            ->image()
                            ->directory('projects')
                            ->required(),
                    ]),

                Section::make('Translations')
                    ->schema([
                        Repeater::make('title')
                            ->schema([
                                TextInput::make('locale')
                                    ->label('Language')
                                    ->required(),
                                TextInput::make('value')
                                    ->label('Title')
                                    ->required(),
                            ])
                            ->columns(2)
                            ->columnSpanFull(),

                        Repeater::make('description')
                            ->schema([
                                TextInput::make('locale')
                                    ->label('Language')
                                    ->required(),
                                Textarea::make('value')
                                    ->label('Description')
                                    ->rows(3)
                                    ->required(),
                            ])
                            ->columns(2)
                            ->columnSpanFull(),

                        Repeater::make('tech')
                            ->label('Tech Stack')
                            ->schema([
                                TextInput::make('value')
                                    ->label('Technology')
                                    ->required(),
                            ])
                            ->columns(1),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('thumbnail')->circular(),
                TextColumn::make('title')
                    ->formatStateUsing(fn ($state) => $state[app()->getLocale()] ?? '-')
                    ->label('Title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('tech')
                    ->badge()
                    ->formatStateUsing(fn ($state) => collect($state)->join(', ')),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

  public static function getPages(): array
{
    return [
        'index'  => \App\Filament\Resources\ProjectResource\Pages\ListProjects::route('/'),
        'create' => \App\Filament\Resources\ProjectResource\Pages\CreateProject::route('/create'),
        'edit'   => \App\Filament\Resources\ProjectResource\Pages\EditProject::route('/{record}/edit'),
    ];
}
}