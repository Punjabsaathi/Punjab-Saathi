<?php

namespace App\Filament\Resources\GovJobResource\RelationManagers;

// Save as: app/Filament/Resources/GovJobResource/RelationManagers/AdmitCardsRelationManager.php

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class AdmitCardsRelationManager extends RelationManager
{
    protected static string $relationship = 'admitCards';
    protected static ?string $title = 'Admit Cards';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')
                ->required()
                ->maxLength(255)
                ->placeholder('e.g. PSSSB Clerk Admit Card 2025')
                ->columnSpanFull(),

            Forms\Components\Grid::make(2)->schema([
                Forms\Components\DatePicker::make('release_date')
                    ->label('Release Date')->native(false),
                Forms\Components\DatePicker::make('exam_date')
                    ->label('Exam Date')->native(false),
            ]),

            Forms\Components\TextInput::make('download_link')
                ->label('Download Link / URL')
                ->required()
                ->url()
                ->columnSpanFull(),

            Forms\Components\Textarea::make('instructions')
                ->label('Instructions')
                ->rows(2)
                ->placeholder('How to download, what to carry, etc.')
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
                Tables\Columns\TextColumn::make('exam_date')->date('d M Y')->sortable()->color('warning'),
                Tables\Columns\IconColumn::make('is_published')->boolean()->label('Live'),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->headerActions([Tables\Actions\CreateAction::make()])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }
}
