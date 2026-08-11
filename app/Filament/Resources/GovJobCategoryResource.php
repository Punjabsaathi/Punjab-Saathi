<?php

namespace App\Filament\Resources;

// Save as: app/Filament/Resources/GovJobCategoryResource.php

use App\Filament\Resources\GovJobCategoryResource\Pages;
use App\Models\GovJobCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class GovJobCategoryResource extends Resource
{
    protected static ?string $model = GovJobCategory::class;
    protected static ?string $navigationIcon      = 'heroicon-o-tag';
    protected static ?string $navigationGroup     = 'Jobs Module';
    protected static ?string $navigationLabel     = 'Categories';
    protected static ?int    $navigationSort       = 2;
    protected static ?string $modelLabel           = 'Job Category';
    protected static ?string $pluralModelLabel     = 'Job Categories';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Category Details')->schema([
                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(100)
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn ($state, Forms\Set $set) =>
                            $set('slug', Str::slug($state))),

                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(120),
                ]),

                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\TextInput::make('icon')
                        ->placeholder('fa-briefcase')
                        ->helperText('FontAwesome class e.g. fa-briefcase, fa-train, fa-university'),

                    Forms\Components\TextInput::make('sort_order')
                        ->numeric()
                        ->default(0),
                ]),

                Forms\Components\Textarea::make('description')
                    ->rows(2)
                    ->columnSpanFull(),

                Forms\Components\Toggle::make('is_active')
                    ->default(true)
                    ->inline(false),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sort_order')->sortable()->label('#'),
                Tables\Columns\TextColumn::make('name')->searchable()->sortable()->weight('bold'),
                Tables\Columns\TextColumn::make('slug')->searchable()->color('gray'),
                Tables\Columns\TextColumn::make('icon')->label('Icon'),
                Tables\Columns\TextColumn::make('jobs_count')
                    ->counts('jobs')
                    ->label('Jobs')
                    ->badge()
                    ->color('warning'),
                Tables\Columns\IconColumn::make('is_active')->boolean()->label('Active'),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')->label('Active'),
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
            ->defaultSort('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListGovJobCategories::route('/'),
            'create' => Pages\CreateGovJobCategory::route('/create'),
            'edit'   => Pages\EditGovJobCategory::route('/{record}/edit'),
        ];
    }
}
