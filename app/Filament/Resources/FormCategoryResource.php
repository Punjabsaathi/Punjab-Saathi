<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FormCategoryResource\Pages;
use App\Models\FormCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class FormCategoryResource extends Resource
{
    protected static ?string $model = FormCategory::class;
    protected static ?string $navigationIcon = 'heroicon-o-folder';
    protected static ?string $navigationGroup = 'Forms Management';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationLabel = 'Categories';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Basic Information')->schema([
                Forms\Components\Select::make('parent_id')
                    ->label('Parent Category')
                    ->relationship('parent', 'name', fn ($query) => $query->whereNull('parent_id')->orderBy('name'))
                    ->searchable()
                    ->placeholder('None (top-level category)')
                    ->nullable(),

                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($set, $state) => $set('slug', Str::slug($state))),

                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),

                Forms\Components\TextInput::make('icon')
                    ->placeholder('heroicon-o-document')
                    ->helperText('Heroicon name, e.g. heroicon-o-identification')
                    ->maxLength(100),

                Forms\Components\ColorPicker::make('color')
                    ->label('Accent Color')
                    ->default('#3B82F6'),

                Forms\Components\Textarea::make('description')
                    ->rows(3)
                    ->columnSpanFull(),

                Forms\Components\Toggle::make('is_active')->default(true)->inline(false),
                Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
            ])->columns(2),

            Forms\Components\Section::make('SEO')->schema([
                Forms\Components\TextInput::make('meta_title')->maxLength(70)->label('SEO Title'),
                Forms\Components\Textarea::make('meta_description')->rows(2)->maxLength(160),
                Forms\Components\FileUpload::make('og_image')
                    ->image()
                    ->directory('category-og')
                    ->label('OG Image'),
            ])->columns(1)->collapsed(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('parent.name')->label('Parent')->placeholder('—'),
                Tables\Columns\TextColumn::make('forms_count')->label('Forms')->sortable(),
                Tables\Columns\IconColumn::make('is_active')->boolean()->label('Active'),
                Tables\Columns\TextColumn::make('sort_order')->label('Order')->sortable(),
                Tables\Columns\TextColumn::make('created_at')->date()->sortable(),
            ])
            ->defaultSort('sort_order')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active'),
                Tables\Filters\SelectFilter::make('parent_id')
                    ->label('Parent')
                    ->relationship('parent', 'name'),
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
            'index'  => Pages\ListFormCategories::route('/'),
            'create' => Pages\CreateFormCategory::route('/create'),
            'edit'   => Pages\EditFormCategory::route('/{record}/edit'),
        ];
    }
}
