<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GoogleReviewResource\Pages;
use App\Models\GoogleReview;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class GoogleReviewResource extends Resource
{
    protected static ?string $model = GoogleReview::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';
    protected static ?string $navigationGroup = 'Website Content';
    protected static ?string $navigationLabel = 'Google Reviews';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()->schema([
                Forms\Components\TextInput::make('reviewer_name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('city')
                    ->maxLength(255)
                    ->helperText('Optional — shown under the reviewer\'s name.'),

                Forms\Components\Select::make('rating')
                    ->options([5 => '5 stars', 4 => '4 stars', 3 => '3 stars', 2 => '2 stars', 1 => '1 star'])
                    ->default(5)
                    ->required(),

                Forms\Components\Textarea::make('review_text')
                    ->rows(3)
                    ->columnSpanFull(),

                Forms\Components\Toggle::make('is_active')->default(true)->inline(false),
                Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('reviewer_name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('city')->searchable(),
                Tables\Columns\TextColumn::make('rating')->formatStateUsing(fn (int $state) => str_repeat('⭐', $state)),
                Tables\Columns\TextColumn::make('review_text')->limit(60),
                Tables\Columns\IconColumn::make('is_active')->boolean()->label('Active'),
                Tables\Columns\TextColumn::make('sort_order')->label('Order')->sortable(),
            ])
            ->defaultSort('sort_order')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active'),
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
            'index'  => Pages\ListGoogleReviews::route('/'),
            'create' => Pages\CreateGoogleReview::route('/create'),
            'edit'   => Pages\EditGoogleReview::route('/{record}/edit'),
        ];
    }
}
