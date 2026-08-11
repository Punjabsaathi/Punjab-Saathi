<?php

namespace App\Filament\Resources\GovJobResource\RelationManagers;

// Save as: app/Filament/Resources/GovJobResource/RelationManagers/UpdatesRelationManager.php

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class UpdatesRelationManager extends RelationManager
{
    protected static string $relationship = 'updates';
    protected static ?string $title = 'Updates / Timeline';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')
                ->required()->maxLength(255)->columnSpanFull()
                ->placeholder('e.g. Notification Released, Admit Card Available, Result Declared'),

            Forms\Components\Grid::make(2)->schema([
                Forms\Components\DatePicker::make('update_date')
                    ->required()->native(false)->default(now()),

                Forms\Components\Select::make('type')
                    ->options([
                        'notification'  => 'Notification Released',
                        'admit_card'    => 'Admit Card Released',
                        'answer_key'    => 'Answer Key Released',
                        'result'        => 'Result Declared',
                        'date_extended' => 'Last Date Extended',
                        'correction'    => 'Correction Window',
                        'general'       => 'General Update',
                    ])
                    ->required()
                    ->default('general'),
            ]),

            Forms\Components\Textarea::make('description')
                ->rows(2)->columnSpanFull()
                ->placeholder('Additional details about this update...'),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('update_date')->date('d M Y')->sortable()->label('Date'),
                Tables\Columns\TextColumn::make('title')->searchable()->limit(60)->weight('bold'),
                Tables\Columns\BadgeColumn::make('type')
                    ->colors([
                        'info'    => 'notification',
                        'warning' => 'admit_card',
                        'primary' => 'answer_key',
                        'success' => 'result',
                        'danger'  => 'date_extended',
                        'gray'    => 'general',
                    ]),
            ])
            ->defaultSort('update_date', 'desc')
            ->headerActions([Tables\Actions\CreateAction::make()])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }
}
