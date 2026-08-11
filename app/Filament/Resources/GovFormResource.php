<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GovFormResource\Pages;
use App\Models\FormCategory;
use App\Models\GovForm;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class GovFormResource extends Resource
{
    protected static ?string $model = GovForm::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Forms Management';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationLabel = 'Forms';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Tabs::make()->tabs([

                Forms\Components\Tabs\Tab::make('Basic Info')->schema([
                    Forms\Components\TextInput::make('title')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn ($set, $state) => $set('slug', Str::slug($state))),

                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->unique(ignoreRecord: true),

                    Forms\Components\Select::make('category_id')
                        ->label('Category')
                        ->options(FormCategory::whereNull('parent_id')->active()->pluck('name', 'id'))
                        ->required()
                        ->live()
                        ->afterStateUpdated(fn ($set) => $set('subcategory_id', null)),

                    Forms\Components\Select::make('subcategory_id')
                        ->label('Sub-category')
                        ->options(fn ($get) =>
                            FormCategory::where('parent_id', $get('category_id'))->pluck('name', 'id')
                        )
                        ->nullable(),

                    Forms\Components\Textarea::make('short_description')->rows(2)->columnSpanFull(),
                    Forms\Components\RichEditor::make('full_description')->columnSpanFull(),

                    Forms\Components\DatePicker::make('published_date'),
                    Forms\Components\TextInput::make('sort_order')->numeric()->default(0),

                    Forms\Components\Toggle::make('is_active')->default(true)->inline(false),
                    Forms\Components\Toggle::make('is_featured')->inline(false),
                    Forms\Components\Toggle::make('is_popular')->inline(false),
                ])->columns(2),

                Forms\Components\Tabs\Tab::make('Files & Media')->schema([
                    Forms\Components\FileUpload::make('file_path')
                        ->label('PDF / Document')
                        ->required()
                        ->directory('gov-forms')
                        ->acceptedFileTypes(['application/pdf', 'application/msword',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                        ->maxSize(20480)
                        ->preserveFilenames()
                        ->afterStateUpdated(function ($set, $state) {
                            if ($state) {
                                $set('file_name', $state->getClientOriginalName());
                                $set('file_mime', $state->getMimeType());
                                $set('file_size', $state->getSize());
                            }
                        }),

                    Forms\Components\TextInput::make('file_name')->readOnly()->label('File Name'),
                    Forms\Components\TextInput::make('file_mime')->readOnly()->label('MIME Type'),
                    Forms\Components\TextInput::make('file_size')->readOnly()->label('File Size (bytes)'),

                    Forms\Components\FileUpload::make('thumbnail')
                        ->image()
                        ->directory('form-thumbnails')
                        ->imageResizeMode('cover')
                        ->imageResizeTargetWidth('400')
                        ->imageResizeTargetHeight('300'),
                ])->columns(2),

                Forms\Components\Tabs\Tab::make('Tags & Related')->schema([
                    Forms\Components\Select::make('tags')
                        ->relationship('tags', 'name')
                        ->multiple()
                        ->searchable()
                        ->createOptionForm([
                            Forms\Components\TextInput::make('name')->required(),
                            Forms\Components\TextInput::make('slug')->required(),
                        ])
                        ->columnSpanFull(),

                    Forms\Components\Select::make('relatedForms')
                        ->label('Related Forms')
                        ->relationship('relatedForms', 'title')
                        ->multiple()
                        ->searchable()
                        ->columnSpanFull(),
                ])->columns(1),

                Forms\Components\Tabs\Tab::make('FAQs')->schema([
                    Forms\Components\Repeater::make('faqs')
                        ->relationship('faqs')
                        ->schema([
                            Forms\Components\TextInput::make('question')->required()->columnSpan(2),
                            Forms\Components\Textarea::make('answer')->required()->rows(3)->columnSpan(2),
                            Forms\Components\TextInput::make('sort_order')->numeric()->default(0)->columnSpan(1),
                        ])
                        ->columns(2)
                        ->orderColumn('sort_order')
                        ->columnSpanFull(),
                ]),

                Forms\Components\Tabs\Tab::make('SEO')->schema([
                    Forms\Components\TextInput::make('seo_title')
                        ->label('SEO Title')
                        ->maxLength(70)
                        ->helperText('Recommended: 50–70 characters'),

                    Forms\Components\Textarea::make('meta_description')
                        ->rows(2)
                        ->maxLength(160)
                        ->helperText('Recommended: 120–160 characters'),

                    Forms\Components\TextInput::make('meta_keywords')
                        ->label('Keywords')
                        ->helperText('Comma separated'),

                    Forms\Components\TextInput::make('canonical_url')->url()->label('Canonical URL'),

                    Forms\Components\FileUpload::make('og_image')
                        ->image()
                        ->directory('form-og')
                        ->label('Open Graph Image')
                        ->helperText('Recommended: 1200×630 px'),
                ])->columns(2),

            ])->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable()->limit(45)->sortable(),
                Tables\Columns\TextColumn::make('category.name')->label('Category')->sortable(),
                Tables\Columns\TextColumn::make('download_count')->label('Downloads')->sortable(),
                Tables\Columns\IconColumn::make('is_featured')->boolean()->label('Featured'),
                Tables\Columns\IconColumn::make('is_popular')->boolean()->label('Popular'),
                Tables\Columns\IconColumn::make('is_active')->boolean()->label('Active'),
                Tables\Columns\TextColumn::make('published_date')->date()->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active'),
                Tables\Filters\TernaryFilter::make('is_featured'),
                Tables\Filters\TernaryFilter::make('is_popular'),
                Tables\Filters\SelectFilter::make('category_id')
                    ->label('Category')
                    ->relationship('category', 'name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('view')
                    ->icon('heroicon-o-eye')
                    ->url(fn (GovForm $record) => route('forms.show', $record->slug))
                    ->openUrlInNewTab(),
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
            'index'  => Pages\ListGovForms::route('/'),
            'create' => Pages\CreateGovForm::route('/create'),
            'edit'   => Pages\EditGovForm::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::count();
    }
}
