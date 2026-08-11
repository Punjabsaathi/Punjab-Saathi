<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogResource\Pages;
use App\Models\Blog;
use App\Models\BlogCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class BlogResource extends Resource
{
    protected static ?string $model = Blog::class;

    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';

    protected static ?string $navigationLabel = 'Blog Posts';
    protected static ?string $navigationGroup = 'Blogs';

    public static function form(Form $form): Form
    {
        return $form->schema([

            Forms\Components\Tabs::make('Blog')
                ->tabs([

                    Forms\Components\Tabs\Tab::make('Content')
                        ->schema([
                            Forms\Components\TextInput::make('title')
                                ->required()
                                ->maxLength(255)
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn (Set $set, ?string $state) =>
                                    $set('slug', Str::slug($state))
                                ),

                            Forms\Components\TextInput::make('slug')
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->maxLength(255),

                            Forms\Components\Textarea::make('excerpt')
                                ->rows(3)
                                ->maxLength(300)
                                ->helperText('Short summary shown on listing page'),

                            Forms\Components\RichEditor::make('content')
                                ->required()
                                ->columnSpanFull()
                                ->toolbarButtons([
                                    'attachFiles', 'blockquote', 'bold', 'bulletList',
                                    'codeBlock', 'h2', 'h3', 'italic', 'link',
                                    'orderedList', 'redo', 'strike', 'underline', 'undo',
                                ]),
                        ])
                        ->columns(2),

                    Forms\Components\Tabs\Tab::make('Featured Image')
                        ->schema([
                            Forms\Components\FileUpload::make('featured_image')
                                ->image()
                                ->directory('blogs')
                                ->maxSize(2048)
                                ->imageResizeMode('cover')
                                ->imageCropAspectRatio('16:9')
                                ->imageResizeTargetWidth('1200')
                                ->imageResizeTargetHeight('630'),

                            Forms\Components\TextInput::make('image_alt')
                                ->label('Image Alt Text')
                                ->helperText('Describe the image for SEO & accessibility'),
                        ]),

                    Forms\Components\Tabs\Tab::make('Publishing')
                        ->schema([
                            Forms\Components\Select::make('status')
                                ->options([
                                    'draft'     => 'Draft',
                                    'published' => 'Published',
                                    'scheduled' => 'Scheduled',
                                ])
                                ->default('draft')
                                ->required()
                                ->native(false),

                            Forms\Components\DateTimePicker::make('published_at')
                                ->label('Publish Date')
                                ->native(false),

                            Forms\Components\Toggle::make('is_featured')
                                ->label('Featured Post'),

                            Forms\Components\Toggle::make('allow_comments')
                                ->label('Allow Comments')
                                ->default(true),

                            Forms\Components\Select::make('category_id')
                                ->label('Category')
                                ->options(BlogCategory::pluck('name', 'id'))
                                ->searchable()
                                ->createOptionForm([
                                    Forms\Components\TextInput::make('name')
                                        ->required()
                                        ->live(onBlur: true)
                                        ->afterStateUpdated(fn (Set $set, ?string $state) =>
                                            $set('slug', Str::slug($state))
                                        ),
                                    Forms\Components\TextInput::make('slug')->required(),
                                ])
                                ->createOptionUsing(fn (array $data) => BlogCategory::create($data)->id),

                            Forms\Components\Select::make('author_id')
                                ->label('Author')
                                ->relationship('author', 'name')
                                ->searchable()
                                ->default(fn () => auth()->id()),

                            Forms\Components\TagsInput::make('tags')
                                ->label('Tags')
                                ->separator(',')
                                ->helperText('Press Enter or comma to add tags'),
                        ])
                        ->columns(2),

                    Forms\Components\Tabs\Tab::make('SEO')
                        ->schema([
                            Forms\Components\TextInput::make('meta_title')
                                ->label('Meta Title')
                                ->maxLength(70)
                                ->helperText('Recommended: 50-70 characters'),

                            Forms\Components\Textarea::make('meta_description')
                                ->label('Meta Description')
                                ->rows(3)
                                ->maxLength(160)
                                ->helperText('Recommended: 120-160 characters'),

                            Forms\Components\TextInput::make('canonical_url')
                                ->label('Canonical URL')
                                ->url()
                                ->helperText('Leave blank to use default URL'),

                            Forms\Components\TextInput::make('focus_keyword')
                                ->label('Focus Keyword')
                                ->helperText('Main keyword you want this post to rank for'),
                        ])
                        ->columns(2),

                    Forms\Components\Tabs\Tab::make('FAQ Schema')
                        ->schema([
                            Forms\Components\Repeater::make('schema_faq')
                                ->label('FAQ Items (adds JSON-LD structured data to the page)')
                                ->schema([
                                    Forms\Components\TextInput::make('question')->required(),
                                    Forms\Components\Textarea::make('answer')->required()->rows(3),
                                ])
                                ->columns(1)
                                ->addActionLabel('Add FAQ Item')
                                ->collapsible(),
                        ]),

                ])
                ->columnSpanFull(),
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
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'draft',
                        'success' => 'published',
                        'info'    => 'scheduled',
                    ]),

                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean(),

                Tables\Columns\TextColumn::make('views')
                    ->sortable(),

                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(['draft' => 'Draft', 'published' => 'Published', 'scheduled' => 'Scheduled']),
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name'),
                Tables\Filters\TernaryFilter::make('is_featured')->label('Featured only'),
            ])
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
            'index'  => Pages\ListBlogs::route('/'),
            'create' => Pages\CreateBlog::route('/create'),
            'edit'   => Pages\EditBlog::route('/{record}/edit'),
        ];
    }
}
