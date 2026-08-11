<?php

namespace App\Filament\Resources\GovJobResource\RelationManagers;

// Save as: app/Filament/Resources/GovJobResource/RelationManagers/ResultsRelationManager.php

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ResultsRelationManager extends RelationManager
{
    protected static string $relationship = 'results';
    protected static ?string $title = 'Results';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')
                ->required()->maxLength(255)
                ->placeholder('e.g. PSSSB Clerk Final Result 2025')
                ->columnSpanFull(),

            Forms\Components\DatePicker::make('result_date')
                ->label('Result Declaration Date')->native(false),

            Forms\Components\TextInput::make('cutoff_marks')
                ->label('Cut Off Marks')
                ->placeholder('e.g. General: 75, SC: 62'),

            Forms\Components\TextInput::make('download_link')
                ->label('Result PDF URL')->required()->url()->columnSpanFull(),

            Forms\Components\TextInput::make('merit_list_link')
                ->label('Merit List PDF URL')->url(),

            Forms\Components\TextInput::make('scorecard_link')
                ->label('Scorecard URL')->url(),

            Forms\Components\Textarea::make('notes')
                ->rows(2)->columnSpanFull(),

            Forms\Components\Toggle::make('is_published')->default(true)->inline(false),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable()->limit(50)->weight('bold'),
                Tables\Columns\TextColumn::make('result_date')->date('d M Y')->sortable(),
                Tables\Columns\TextColumn::make('cutoff_marks')->label('Cut Off'),
                Tables\Columns\IconColumn::make('is_published')->boolean()->label('Live'),
            ])
            ->headerActions([Tables\Actions\CreateAction::make()])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }
}
