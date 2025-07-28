<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogPostResource\Pages;
use App\Models\BlogPost;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Forms\Set;
use Filament\Forms\Get;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Notifications\Notification;

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
                Group::make()
                    ->schema([
                        Section::make('Content')
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(debounce: 500)
                                    ->afterStateUpdated(function (Set $set, ?string $state) {
                                        $set('slug', Str::slug($state));
                                    }),
                                    
                                Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true),
                                    
                                Forms\Components\RichEditor::make('content')
                                    ->required()
                                    ->columnSpanFull()
                                    ->fileAttachmentsDirectory('blog/images')
                                    ->fileAttachmentsVisibility('public'),
                                    
                                Forms\Components\Textarea::make('excerpt')
                                    ->maxLength(65535)
                                    ->columnSpanFull()
                                    ->helperText('A brief summary of the post for SEO and previews.'),
                            ]),
                            
                        Section::make('SEO & Meta')
                            ->schema([
                                Forms\Components\Textarea::make('meta_description')
                                    ->maxLength(160)
                                    ->helperText('Recommended: 150-160 characters for optimal SEO.'),
                                    
                                Forms\Components\TagsInput::make('meta_keywords')
                                    ->placeholder('Add keywords')
                                    ->helperText('Keywords for SEO optimization.'),
                            ]),
                    ])
                    ->columnSpan(['lg' => 2]),
                    
                Group::make()
                    ->schema([
                        Section::make('Publishing')
                            ->schema([
                                Forms\Components\FileUpload::make('featured_image')
                                    ->image()
                                    ->directory('blog/featured')
                                    ->maxSize(2048)
                                    ->imageResizeMode('cover')
                                    ->imageCropAspectRatio('16:9')
                                    ->imageResizeTargetWidth('1200')
                                    ->imageResizeTargetHeight('675'),
                                    
                                Forms\Components\Toggle::make('is_published')
                                    ->label('Published')
                                    ->helperText('Make this post visible to visitors.'),
                                    
                                Forms\Components\DateTimePicker::make('published_at')
                                    ->label('Publish Date')
                                    ->default(now())
                                    ->helperText('When should this post be published?'),
                            ]),
                            
                        Section::make('Author')
                            ->schema([
                                Forms\Components\Select::make('user_id')
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
                ImageColumn::make('featured_image')
                    ->label('Image')
                    ->circular()
                    ->size(50),
                    
                TextColumn::make('title')
                    ->searchable()
                    ->limit(50)
                    ->tooltip(function (BlogPost $record): string {
                        return $record->title;
                    }),
                    
                TextColumn::make('user.name')
                    ->label('Author')
                    ->sortable()
                    ->toggleable(),
                    
                ToggleColumn::make('is_published')
                    ->label('Published')
                    ->sortable(),
                    
                TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                    
                TextColumn::make('reading_time')
                    ->label('Read Time')
                    ->suffix(' min')
                    ->toggleable(),
                    
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('is_published')
                    ->options([
                        true => 'Published',
                        false => 'Draft',
                    ]),
                    
                Filter::make('published_at')
                    ->form([
                        Forms\Components\DatePicker::make('published_from'),
                        Forms\Components\DatePicker::make('published_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['published_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('published_at', '>=', $date),
                            )
                            ->when(
                                $data['published_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('published_at', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    
                    Action::make('duplicate')
                        ->icon('heroicon-o-document-duplicate')
                        ->action(function (BlogPost $record) {
                            $newPost = $record->replicate();
                            $newPost->title = $record->title . ' (Copy)';
                            $newPost->slug = $record->slug . '-copy';
                            $newPost->is_published = false;
                            $newPost->published_at = null;
                            $newPost->save();
                            
                            Notification::make()
                                ->title('Post duplicated successfully')
                                ->success()
                                ->send();
                        }),
                        
                    Action::make('preview')
                        ->icon('heroicon-o-eye')
                        ->url(fn (BlogPost $record) => route('blog.show', $record->slug))
                        ->openUrlInNewTab(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('publish')
                        ->icon('heroicon-o-check')
                        ->action(function (Collection $records) {
                            $records->each->update(['is_published' => true]);
                            
                            Notification::make()
                                ->title('Posts published successfully')
                                ->success()
                                ->send();
                        }),
                    Tables\Actions\BulkAction::make('unpublish')
                        ->icon('heroicon-o-x-mark')
                        ->action(function (Collection $records) {
                            $records->each->update(['is_published' => false]);
                            
                            Notification::make()
                                ->title('Posts unpublished successfully')
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBlogPosts::route('/'),
            'create' => Pages\CreateBlogPost::route('/create'),
            'view' => Pages\ViewBlogPost::route('/{record}'),
            'edit' => Pages\EditBlogPost::route('/{record}/edit'),
        ];
    }
}