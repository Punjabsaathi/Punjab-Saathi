<?php

namespace App\Filament\Resources\GovJobResource\RelationManagers;

// Save as: app/Filament/Resources/GovJobResource/RelationManagers/AnswerKeysRelationManager.php

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class AnswerKeysRelationManager extends RelationManager
{
    protected static string $relationship = 'answerKeys';
    protected static ?string $title = 'Answer Keys';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')
                ->required()->maxLength(255)
                ->placeholder('e.g. PSSSB Clerk Answer Key 2025')
                ->columnSpanFull(),

            Forms\Components\Grid::make(2)->schema([
                Forms\Components\DatePicker::make('release_date')
                    ->label('Release Date')->native(false),
                Forms\Components\DatePicker::make('objection_end_date')
                    ->label('Objection Last Date')->native(false),
            ]),

            Forms\Components\TextInput::make('download_link')
                ->label('Download Link / URL')
                ->required()->url()->columnSpanFull(),

            Forms\Components\Textarea::make('objection_details')
                ->label('Objection Details')
                ->rows(2)
                ->placeholder('How to raise objection, fee, link, etc.')
                ->columnSpanFull(),

            Forms\Components\Toggle::make('is_published')->default(true)->inline(false),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable()->limit(50)->weight('bold'),
                Tables\Columns\TextColumn::make('release_date')->date('d M Y')->sortable(),
                Tables\Columns\TextColumn::make('objection_end_date')->date('d M Y')->label('Objection Deadline')->color('danger'),
                Tables\Columns\IconColumn::make('is_published')->boolean()->label('Live'),
            ])
            ->headerActions([Tables\Actions\CreateAction::make()])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }
}
