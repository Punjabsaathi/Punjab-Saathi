<?php

namespace App\Filament\Resources;

// Save as: app/Filament/Resources/GovJobFormRequestResource.php

use App\Filament\Resources\GovJobFormRequestResource\Pages;
use App\Models\GovJobFormRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;

class GovJobFormRequestResource extends Resource
{
    protected static ?string $model = GovJobFormRequest::class;
    protected static ?string $navigationIcon     = 'heroicon-o-inbox';
    protected static ?string $navigationGroup    = 'Jobs Module';
    protected static ?string $navigationLabel    = 'Form Help Requests';
    protected static ?int    $navigationSort      = 3;
    protected static ?string $modelLabel          = 'Form Request';
    protected static ?string $pluralModelLabel    = 'Form Help Requests';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Request Details')->schema([
                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\TextInput::make('name')->disabled(),
                    Forms\Components\TextInput::make('phone')->disabled(),
                ]),
                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\TextInput::make('email')->disabled(),
                    Forms\Components\TextInput::make('service_type')->disabled(),
                ]),
                Forms\Components\TextInput::make('job_name')->disabled()->columnSpanFull(),
                Forms\Components\Textarea::make('message')->disabled()->rows(3)->columnSpanFull(),
            ]),

            Forms\Components\Section::make('Admin Actions')->schema([
                Forms\Components\Select::make('status')
                    ->options([
                        'pending'   => 'Pending',
                        'contacted' => 'Contacted',
                        'completed' => 'Completed',
                    ])
                    ->required(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Received')
                    ->dateTime('d M Y H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('phone')
                    ->searchable()
                    ->copyable(),

                Tables\Columns\TextColumn::make('service_type')
                    ->label('Service')
                    ->badge()
                    ->formatStateUsing(fn ($state) => str_replace('_', ' ', ucfirst($state)))
                    ->color('info'),

                Tables\Columns\TextColumn::make('job_name')
                    ->label('Job Applied For')
                    ->limit(40)
                    ->color('gray'),

                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'info'    => 'contacted',
                        'success' => 'completed',
                    ]),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(['pending' => 'Pending', 'contacted' => 'Contacted', 'completed' => 'Completed']),
                Tables\Filters\SelectFilter::make('service_type')
                    ->options(['job_form' => 'Job Form', 'admit_card' => 'Admit Card', 'result' => 'Result', 'answer_key' => 'Answer Key', 'other' => 'Other']),
            ])
            ->actions([
                Tables\Actions\Action::make('call')
                    ->label('Mark Contacted')
                    ->icon('heroicon-o-phone')
                    ->color('info')
                    ->action(function ($record) {
                        $record->update(['status' => 'contacted']);
                        Notification::make()->title('Marked as Contacted')->success()->send();
                    })
                    ->visible(fn ($record) => $record->status === 'pending'),

                Tables\Actions\Action::make('complete')
                    ->label('Mark Completed')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->action(function ($record) {
                        $record->update(['status' => 'completed']);
                        Notification::make()->title('Marked as Completed')->success()->send();
                    })
                    ->visible(fn ($record) => $record->status !== 'completed'),

                Tables\Actions\EditAction::make()->label('View'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('markContacted')
                        ->label('Mark as Contacted')
                        ->icon('heroicon-o-phone')
                        ->action(fn ($records) => $records->each->update(['status' => 'contacted']))
                        ->deselectRecordsAfterCompletion(),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGovJobFormRequests::route('/'),
            'edit'  => Pages\EditGovJobFormRequest::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::where('status', 'pending')->count();
        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }
}
