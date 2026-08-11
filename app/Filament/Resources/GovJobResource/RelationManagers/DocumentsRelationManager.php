<?php

namespace App\Filament\Resources\GovJobResource\RelationManagers;

// Save as: app/Filament/Resources/GovJobResource/RelationManagers/DocumentsRelationManager.php

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class DocumentsRelationManager extends RelationManager
{
    protected static string $relationship = 'documents';
    protected static ?string $title = 'Documents & Downloads';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')
                ->required()->maxLength(200)
                ->placeholder('e.g. Official Notification PDF')
                ->columnSpanFull(),

            Forms\Components\Grid::make(2)->schema([
                Forms\Components\Select::make('type')
                    ->options([
                        'notification'   => 'Notification',
                        'syllabus'       => 'Syllabus',
                        'admit_card'     => 'Admit Card',
                        'answer_key'     => 'Answer Key',
                        'result'         => 'Result',
                        'merit_list'     => 'Merit List',
                        'cutoff'         => 'Cut Off',
                        'previous_paper' => 'Previous Paper',
                        'correction_form'=> 'Correction Form',
                        'other'          => 'Other',
                    ])
                    ->required()
                    ->default('other'),

                Forms\Components\TextInput::make('file_size')
                    ->label('File Size')
                    ->placeholder('e.g. 2.4 MB'),
            ]),

            Forms\Components\TextInput::make('file_url')
                ->label('File URL / Download Link')
                ->required()->url()->columnSpanFull(),

            Forms\Components\Grid::make(2)->schema([
                Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
                Forms\Components\Toggle::make('is_published')->default(true)->inline(false),
            ]),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sort_order')->label('#')->sortable(),
                Tables\Columns\TextColumn::make('title')->searchable()->weight('bold'),
                Tables\Columns\BadgeColumn::make('type')
                    ->colors([
                        'danger'  => 'notification',
                        'warning' => 'syllabus',
                        'info'    => 'admit_card',
                        'success' => 'result',
                    ]),
                Tables\Columns\TextColumn::make('file_size'),
                Tables\Columns\IconColumn::make('is_published')->boolean()->label('Live'),
            ])
            ->reorderable('sort_order')
            ->headerActions([Tables\Actions\CreateAction::make()])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }
}
