<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactQueryResource\Pages;
use App\Models\ContactQuery;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class ContactQueryResource extends Resource
{
    protected static ?string $model = ContactQuery::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $navigationLabel = 'Contact Form Queries';
    protected static ?string $navigationGroup = 'Applications';

    // Disable create — queries come from the public contact form
    public static function canCreate(): bool
    {
        return false;
    }

    // Show "new" count badge in sidebar
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'new')->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    // -------------------------------------------------------------------------
    // FORM (Edit page — visitor fields disabled, admin fields editable)
    // -------------------------------------------------------------------------
    public static function form(Form $form): Form
    {
        return $form->schema([

            Forms\Components\Section::make('Query Info')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->disabled(),

                    Forms\Components\TextInput::make('phone')
                        ->disabled(),

                    Forms\Components\TextInput::make('email')
                        ->disabled(),

                    Forms\Components\TextInput::make('subject')
                        ->disabled(),

                    Forms\Components\TextInput::make('language')
                        ->disabled(),

                    Forms\Components\TextInput::make('ip_address')
                        ->label('IP Address')
                        ->disabled(),

                    Forms\Components\Textarea::make('message')
                        ->disabled()
                        ->columnSpanFull(),
                ]),

            Forms\Components\Section::make('Admin Actions')
                ->columns(2)
                ->schema([
                    Forms\Components\Select::make('status')
                        ->options([
                            'new'         => 'New',
                            'in_progress' => 'In Progress',
                            'resolved'    => 'Resolved',
                        ])
                        ->required()
                        ->native(false),

                    Forms\Components\DateTimePicker::make('replied_at')
                        ->label('Replied At'),
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
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('phone')
                    ->searchable()
                    ->copyable(),

                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('subject')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        'application_status' => 'Application Status',
                        'document_help'      => 'Document Assistance',
                        'service_info'       => 'Service Information',
                        'fees_payment'       => 'Fees & Payment',
                        'complaint'          => 'Complaint / Feedback',
                        'other'              => 'Other',
                        default              => ucfirst(str_replace('_', ' ', $state)),
                    }),

                Tables\Columns\TextColumn::make('language')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        'en' => 'English',
                        'hi' => 'Hindi',
                        'pa' => 'Punjabi',
                        default => strtoupper($state),
                    }),

                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'new',
                        'info'    => 'in_progress',
                        'success' => 'resolved',
                    ])
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        'new'         => 'New',
                        'in_progress' => 'In Progress',
                        'resolved'    => 'Resolved',
                        default       => ucfirst($state),
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Submitted')
                    ->dateTime('d M Y, h:i A')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'new'         => 'New',
                        'in_progress' => 'In Progress',
                        'resolved'    => 'Resolved',
                    ]),

                Tables\Filters\SelectFilter::make('subject')
                    ->options([
                        'application_status' => 'Application Status',
                        'document_help'      => 'Document Assistance',
                        'service_info'       => 'Service Information',
                        'fees_payment'       => 'Fees & Payment',
                        'complaint'          => 'Complaint / Feedback',
                        'other'              => 'Other',
                    ]),

                Tables\Filters\SelectFilter::make('language')
                    ->options([
                        'en' => 'English',
                        'hi' => 'Hindi',
                        'pa' => 'Punjabi',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),

                Tables\Actions\Action::make('markResolved')
                    ->label('Mark Resolved')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (ContactQuery $record) => $record->status !== 'resolved')
                    ->action(fn (ContactQuery $record) => $record->update([
                        'status'     => 'resolved',
                        'replied_at' => now(),
                    ]))
                    ->requiresConfirmation()
                    ->successNotificationTitle('Marked as resolved'),

                Tables\Actions\EditAction::make(),

                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    // -------------------------------------------------------------------------
    // INFOLIST (View page)
    // -------------------------------------------------------------------------
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([

            Infolists\Components\Section::make('Query Details')
                ->columns(3)
                ->schema([
                    Infolists\Components\TextEntry::make('subject')
                        ->badge()
                        ->formatStateUsing(fn (string $state) => match ($state) {
                            'application_status' => 'Application Status',
                            'document_help'      => 'Document Assistance',
                            'service_info'       => 'Service Information',
                            'fees_payment'       => 'Fees & Payment',
                            'complaint'          => 'Complaint / Feedback',
                            'other'              => 'Other',
                            default              => ucfirst(str_replace('_', ' ', $state)),
                        }),

                    Infolists\Components\TextEntry::make('language')
                        ->formatStateUsing(fn (string $state) => match ($state) {
                            'en' => 'English',
                            'hi' => 'Hindi',
                            'pa' => 'Punjabi',
                            default => strtoupper($state),
                        }),

                    Infolists\Components\TextEntry::make('status')
                        ->badge()
                        ->color(fn (string $state) => match ($state) {
                            'new'         => 'warning',
                            'in_progress' => 'info',
                            'resolved'    => 'success',
                            default       => 'secondary',
                        }),
                ]),

            Infolists\Components\Section::make('Contact Information')
                ->columns(2)
                ->schema([
                    Infolists\Components\TextEntry::make('name'),
                    Infolists\Components\TextEntry::make('phone')->copyable(),
                    Infolists\Components\TextEntry::make('email')->copyable(),
                    Infolists\Components\TextEntry::make('ip_address')->label('IP Address'),
                    Infolists\Components\TextEntry::make('message')->columnSpanFull(),
                ]),

            Infolists\Components\Section::make('Timestamps')
                ->columns(3)
                ->collapsed()
                ->schema([
                    Infolists\Components\TextEntry::make('created_at')->dateTime('d M Y, h:i A'),
                    Infolists\Components\TextEntry::make('replied_at')->dateTime('d M Y, h:i A'),
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
            'index' => Pages\ListContactQueries::route('/'),
            'view'  => Pages\ViewContactQuery::route('/{record}'),
            'edit'  => Pages\EditContactQuery::route('/{record}/edit'),
        ];
    }
}