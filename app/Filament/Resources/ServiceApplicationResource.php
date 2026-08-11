<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceApplicationResource\Pages;
use App\Models\ServiceApplication;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Illuminate\Database\Eloquent\Builder;

class ServiceApplicationResource extends Resource
{
    protected static ?string $model = ServiceApplication::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Applications';
    protected static ?string $navigationGroup = 'Applications';

    // Disable create — applications come from public website
    public static function canCreate(): bool
    {
        return false;
    }

    // Show pending count badge in sidebar
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'pending')->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    // -------------------------------------------------------------------------
    // FORM (Edit page — applicant fields disabled, admin fields editable)
    // -------------------------------------------------------------------------
    public static function form(Form $form): Form
    {
        return $form->schema([

            Forms\Components\Section::make('Application Info')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('reference_no')
                        ->label('Reference No.')
                        ->disabled(),

                    Forms\Components\Select::make('service_id')
                        ->label('Service')
                        ->relationship('service', 'title')
                        ->disabled(),

                    Forms\Components\TextInput::make('name')
                        ->disabled(),

                    Forms\Components\TextInput::make('phone')
                        ->disabled(),

                    Forms\Components\TextInput::make('email')
                        ->disabled(),

                    Forms\Components\TextInput::make('ip_address')
                        ->label('IP Address')
                        ->disabled(),

                    Forms\Components\Textarea::make('address')
                        ->disabled()
                        ->columnSpanFull(),

                    Forms\Components\Textarea::make('message')
                        ->disabled()
                        ->columnSpanFull(),
                ]),

            Forms\Components\Section::make('Admin Actions')
                ->columns(2)
                ->schema([
                    Forms\Components\Select::make('status')
                        ->options([
                            'pending'    => 'Pending',
                            'in_review'  => 'In Review',
                            'processing' => 'Processing',
                            'completed'  => 'Completed',
                            'rejected'   => 'Rejected',
                        ])
                        ->required()
                        ->native(false),
                ]),
        ]);
    }

    // -------------------------------------------------------------------------
    // TABLE
    // -------------------------------------------------------------------------
    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('reference_no')
                    ->label('Reference')
                    ->searchable()
                    ->copyable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('service.title')
                    ->label('Service')
                    ->sortable(),

                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),

                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'info'    => 'in_review',
                        'primary' => 'processing',
                        'success' => 'completed',
                        'danger'  => 'rejected',
                    ])
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        'pending'    => 'Pending',
                        'in_review'  => 'In Review',
                        'processing' => 'Processing',
                        'completed'  => 'Completed',
                        'rejected'   => 'Rejected',
                        default      => ucfirst($state),
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Submitted')
                    ->dateTime('d M Y, h:i A')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending'    => 'Pending',
                        'in_review'  => 'In Review',
                        'processing' => 'Processing',
                        'completed'  => 'Completed',
                        'rejected'   => 'Rejected',
                    ]),

                Tables\Filters\SelectFilter::make('service')
                    ->relationship('service', 'title')
                    ->label('Service'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),

                Tables\Actions\Action::make('updateStatus')
                    ->label('Update Status')
                    ->icon('heroicon-o-arrow-path')
                    ->color('warning')
                    ->fillForm(fn (ServiceApplication $record) => [
                        'status' => $record->status,
                    ])
                    ->form([
                        Forms\Components\Select::make('status')
                            ->options([
                                'pending'    => 'Pending',
                                'in_review'  => 'In Review',
                                'processing' => 'Processing',
                                'completed'  => 'Completed',
                                'rejected'   => 'Rejected',
                            ])
                            ->required()
                            ->native(false),

                        Forms\Components\Textarea::make('note')
                            ->label('Tracking Note (visible to applicant)')
                            ->placeholder('e.g. Your documents are under review...')
                            ->rows(4)
                            ->required(),
                    ])
                    ->action(function (ServiceApplication $record, array $data) {
                        $existingNotes = $record->admin_notes ?? [];

                        $existingNotes[] = [
                            'status'     => $data['status'],
                            'note'       => $data['note'],
                            'updated_by' => auth()->user()->name,
                            'at'         => now()->format('d M Y, h:i A'),
                        ];

                        $record->update([
                            'status'      => $data['status'],
                            'admin_notes' => $existingNotes,
                        ]);
                    })
                    ->successNotificationTitle('Status updated & note saved'),

                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    // -------------------------------------------------------------------------
    // INFOLIST (View page — full detail + tracking history timeline)
    // -------------------------------------------------------------------------
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([

            Infolists\Components\Section::make('Application Details')
                ->columns(3)
                ->schema([
                    Infolists\Components\TextEntry::make('reference_no')
                        ->label('Reference No.')
                        ->copyable()
                        ->weight('bold'),

                    Infolists\Components\TextEntry::make('service.title')
                        ->label('Service'),

                    Infolists\Components\TextEntry::make('status')
                        ->badge()
                        ->color(fn (string $state) => match ($state) {
                            'pending'    => 'warning',
                            'in_review'  => 'info',
                            'processing' => 'primary',
                            'completed'  => 'success',
                            'rejected'   => 'danger',
                            default      => 'secondary',
                        }),
                ]),

            Infolists\Components\Section::make('Applicant Information')
                ->columns(2)
                ->schema([
                    Infolists\Components\TextEntry::make('name'),
                    Infolists\Components\TextEntry::make('phone'),
                    Infolists\Components\TextEntry::make('email'),
                    Infolists\Components\TextEntry::make('ip_address')->label('IP Address'),
                    Infolists\Components\TextEntry::make('address')->columnSpanFull(),
                    Infolists\Components\TextEntry::make('message')->columnSpanFull(),
                ]),

            Infolists\Components\Section::make('Tracking History')
                ->schema([
                    Infolists\Components\RepeatableEntry::make('admin_notes')
                        ->label('')
                        ->schema([
                            Infolists\Components\TextEntry::make('status')
                                ->badge()
                                ->color(fn (string $state) => match ($state) {
                                    'pending'    => 'warning',
                                    'in_review'  => 'info',
                                    'processing' => 'primary',
                                    'completed'  => 'success',
                                    'rejected'   => 'danger',
                                    default      => 'secondary',
                                }),

                            Infolists\Components\TextEntry::make('note')
                                ->label('Note'),

                            Infolists\Components\TextEntry::make('updated_by')
                                ->label('Updated By'),

                            Infolists\Components\TextEntry::make('at')
                                ->label('Date & Time'),
                        ])
                        ->columns(4),
                ]),

            Infolists\Components\Section::make('Timestamps')
                ->columns(2)
                ->collapsed()
                ->schema([
                    Infolists\Components\TextEntry::make('created_at')->dateTime('d M Y, h:i A'),
                    Infolists\Components\TextEntry::make('updated_at')->dateTime('d M Y, h:i A'),
                ]),
        ]);
    }

    // -------------------------------------------------------------------------
    // PAGES — no create page
    // -------------------------------------------------------------------------
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListServiceApplications::route('/'),
            'view'  => Pages\ViewServiceApplication::route('/{record}'),
            'edit'  => Pages\EditServiceApplication::route('/{record}/edit'),
        ];
    }
}