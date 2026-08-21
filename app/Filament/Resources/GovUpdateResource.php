<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GovUpdateResource\Pages;
use App\Models\GovUpdate;
use App\Models\GovUpdateCategory;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class GovUpdateResource extends Resource
{
    protected static ?string $model = GovUpdate::class;
    protected static ?string $navigationIcon      = 'heroicon-o-megaphone';
    protected static ?string $navigationGroup     = 'Government Updates';
    protected static ?string $navigationLabel     = 'All Updates';
    protected static ?int    $navigationSort       = 1;
    protected static ?string $modelLabel           = 'Government Update';
    protected static ?string $pluralModelLabel     = 'Government Updates';
    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Tabs::make('Update Details')->columnSpanFull()->tabs([

                Forms\Components\Tabs\Tab::make('Content')
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, Set $set) => $set('slug', Str::slug($state))),

                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->helperText('SEO-friendly URL. Auto-generated from title.'),

                        Forms\Components\Textarea::make('short_description')
                            ->label('Short Description')
                            ->rows(3)
                            ->maxLength(300)
                            ->helperText('Shown on the listing card and used as the SEO fallback description.')
                            ->columnSpanFull(),

                        Forms\Components\RichEditor::make('content')
                            ->label('Full Update Content')
                            ->required()
                            ->columnSpanFull()
                            ->toolbarButtons([
                                'attachFiles', 'blockquote', 'bold', 'bulletList',
                                'codeBlock', 'h2', 'h3', 'italic', 'link',
                                'orderedList', 'redo', 'strike', 'underline', 'undo',
                            ]),
                    ])
                    ->columns(2),

                Forms\Components\Tabs\Tab::make('Classification & Media')
                    ->icon('heroicon-o-tag')
                    ->schema([
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\Select::make('category_id')
                                ->label('Category')
                                ->options(GovUpdateCategory::where('is_active', true)->pluck('name', 'id'))
                                ->searchable()
                                ->required(),

                            Forms\Components\Select::make('related_service_id')
                                ->label('Related Service (optional)')
                                ->helperText('Links this update to one of our own service pages, e.g. an Aadhaar update links to the Aadhaar Update service.')
                                ->options(Service::where('is_active', true)->pluck('title', 'id'))
                                ->searchable(),
                        ]),

                        Forms\Components\Toggle::make('is_important')
                            ->label('Mark as Important')
                            ->helperText('Shows an "Important" badge and surfaces this update in the sidebar highlights.')
                            ->inline(false),

                        Forms\Components\FileUpload::make('featured_image')
                            ->image()
                            ->directory('gov-updates')
                            ->maxSize(2048)
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('16:9')
                            ->imageResizeTargetWidth('1200')
                            ->imageResizeTargetHeight('630'),

                        Forms\Components\TextInput::make('image_alt')
                            ->label('Image Alt Text')
                            ->helperText('Describe the image for SEO & accessibility'),
                    ]),

                Forms\Components\Tabs\Tab::make('SEO')
                    ->icon('heroicon-o-magnifying-glass')
                    ->schema([
                        Forms\Components\Section::make('Meta Tags')->schema([
                            Forms\Components\TextInput::make('meta_title')
                                ->label('SEO Title')
                                ->maxLength(70)
                                ->helperText('Leave blank to use the update title. Max 70 characters.'),
                            Forms\Components\Textarea::make('meta_description')
                                ->label('Meta Description')
                                ->rows(2)
                                ->maxLength(160)
                                ->helperText('Leave blank to use the Short Description above.'),
                            Forms\Components\TextInput::make('meta_keywords')
                                ->label('Meta Keywords'),
                            Forms\Components\TextInput::make('canonical_url')
                                ->label('Canonical URL')
                                ->url()
                                ->helperText('Leave blank to use the default URL for this update.'),
                        ]),

                        Forms\Components\Section::make('Social Sharing (Open Graph)')->schema([
                            Forms\Components\TextInput::make('og_title')
                                ->label('OG Title')
                                ->maxLength(95)
                                ->helperText('Leave blank to reuse the SEO Title.'),
                            Forms\Components\Textarea::make('og_description')
                                ->label('OG Description')
                                ->rows(2)
                                ->helperText('Leave blank to reuse the Meta Description.'),
                            Forms\Components\FileUpload::make('og_image')
                                ->label('OG Image')
                                ->image()
                                ->directory('gov-updates')
                                ->helperText('Leave blank to reuse the Featured Image above.'),
                        ]),
                    ]),

                Forms\Components\Tabs\Tab::make('Publish')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->schema([
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\Select::make('status')
                                ->options([
                                    'draft'     => 'Draft',
                                    'published' => 'Published',
                                ])
                                ->default('draft')
                                ->required()
                                ->native(false),

                            Forms\Components\DateTimePicker::make('published_at')
                                ->label('Publish Date')
                                ->native(false)
                                ->helperText('Leave blank to publish immediately once status is set to Published.'),
                        ]),
                    ]),

            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\ImageColumn::make('featured_image')
                    ->label('')
                    ->width(60)
                    ->height(40),

                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(50)
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('category.name')
                    ->badge()
                    ->color('warning')
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'draft',
                        'success' => 'published',
                    ]),

                Tables\Columns\IconColumn::make('is_important')
                    ->label('Important')
                    ->boolean(),

                Tables\Columns\TextColumn::make('views')
                    ->sortable(),

                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(['draft' => 'Draft', 'published' => 'Published']),
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name'),
                Tables\Filters\TernaryFilter::make('is_important')->label('Important only'),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('View')
                    ->icon('heroicon-o-eye')
                    ->url(fn ($record) => url('/government-updates/' . $record->slug))
                    ->openUrlInNewTab(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('publish')
                        ->label('Publish Selected')
                        ->icon('heroicon-o-check-circle')
                        ->action(fn ($records) => $records->each->update(['status' => 'published']))
                        ->deselectRecordsAfterCompletion(),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListGovUpdates::route('/'),
            'create' => Pages\CreateGovUpdate::route('/create'),
            'edit'   => Pages\EditGovUpdate::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'published')->count() ?: null;
    }
}
