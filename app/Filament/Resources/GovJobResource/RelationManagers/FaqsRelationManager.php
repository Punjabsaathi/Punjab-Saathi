<?php

namespace App\Filament\Resources\GovJobResource\RelationManagers;

// Save as: app/Filament/Resources/GovJobResource/RelationManagers/FaqsRelationManager.php

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class FaqsRelationManager extends RelationManager
{
    protected static string $relationship = 'faqs';
    protected static ?string $title = 'FAQs';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Textarea::make('question')
                ->required()->rows(2)->columnSpanFull()
                ->placeholder('e.g. What is the age limit for this recruitment?'),

            Forms\Components\Textarea::make('answer')
                ->required()->rows(3)->columnSpanFull()
                ->placeholder('The answer to the FAQ...'),

            Forms\Components\TextInput::make('sort_order')
                ->numeric()->default(0)->label('Order'),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sort_order')->label('#')->sortable(),
                Tables\Columns\TextColumn::make('question')->limit(80)->searchable()->weight('bold'),
                Tables\Columns\TextColumn::make('answer')->limit(60)->color('gray'),
            ])
            ->reorderable('sort_order')
            ->headerActions([Tables\Actions\CreateAction::make()])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }
}
