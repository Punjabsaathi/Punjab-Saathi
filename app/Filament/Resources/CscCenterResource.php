<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CscCenterResource\Pages;
use App\Models\CscCenter;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Illuminate\Database\Eloquent\Builder;

class CscCenterResource extends Resource
{
    protected static ?string $model = CscCenter::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?string $navigationLabel = 'CSC Centers';

    protected static ?string $modelLabel = 'CSC Center / Agent';

    protected static ?string $pluralModelLabel = 'CSC Centers & Agents';

    protected static ?string $navigationGroup = 'CSC Management';

    protected static ?int $navigationSort = 1;

    // ── Form ──────────────────────────────────────────────────────────────────

    public static function form(Form $form): Form
    {
        return $form->schema([

            Forms\Components\Section::make('Identity')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('csc_id')
                        ->label('CSC ID')
                        ->placeholder('e.g. 110136780019')
                        ->maxLength(30)
                        ->unique(ignoreRecord: true),

                    Forms\Components\TextInput::make('vle_name')
                        ->label('VLE / Operator Name')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('kiosk_name')
                        ->label('Kiosk / Center Name')
                        ->maxLength(255),

                    Forms\Components\TextInput::make('mobile')
                        ->label('Mobile Number')
                        ->tel()
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(15)
                        ->helperText('Used to prevent duplicate registrations.'),

                    Forms\Components\TextInput::make('email')
                        ->email()
                        ->maxLength(255),
                ]),

            Forms\Components\Section::make('Location')
                ->columns(2)
                ->schema([
                    Forms\Components\Textarea::make('address')
                        ->rows(2)
                        ->columnSpanFull(),

                    Forms\Components\TextInput::make('sub_district')
                        ->label('Sub-District / Block'),

                    Forms\Components\TextInput::make('district')
                        ->required(),

                    Forms\Components\TextInput::make('state')
                        ->default('Punjab'),

                    Forms\Components\TextInput::make('pincode')
                        ->maxLength(10),

                    Forms\Components\TextInput::make('latitude')
                        ->numeric()
                        ->step(0.0000001),

                    Forms\Components\TextInput::make('longitude')
                        ->numeric()
                        ->step(0.0000001),
                ]),

            Forms\Components\Section::make('Status')
                ->columns(3)
                ->schema([
                    Forms\Components\DatePicker::make('registered_on')
                        ->label('Registered On (Portal)'),

                    Forms\Components\Select::make('source')
                        ->options([
                            'locator.csccloud.in' => 'CSC Cloud Portal',
                            'self-registered'     => 'Self-Registered',
                            'admin'               => 'Added by Admin',
                        ])
                        ->default('self-registered')
                        ->required(),

                    Forms\Components\Toggle::make('is_verified')
                        ->label('Verified')
                        ->helperText('Mark after manual verification.'),

                    Forms\Components\Toggle::make('is_active')
                        ->label('Active')
                        ->default(true),

                    Forms\Components\Textarea::make('notes')
                        ->label('Admin Notes')
                        ->rows(2)
                        ->columnSpanFull(),
                ]),
        ]);
    }

    // ── Table ─────────────────────────────────────────────────────────────────

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('csc_id')
                    ->label('CSC ID')
                    ->searchable()
                    ->copyable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('vle_name')
                    ->label('VLE / Operator')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('kiosk_name')
                    ->label('Kiosk Name')
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('mobile')
                    ->label('Mobile')
                    ->searchable()
                    ->copyable()
                    ->icon('heroicon-m-phone'),

                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->copyable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('district')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('sub_district')
                    ->label('Sub-District')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('pincode')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('source')
                    ->badge()
                    ->color(fn(string $state): string => match($state) {
                        'self-registered'     => 'success',
                        'locator.csccloud.in' => 'info',
                        'admin'               => 'warning',
                        default               => 'gray',
                    }),

                Tables\Columns\IconColumn::make('is_verified')
                    ->label('Verified')
                    ->boolean(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('district')
                    ->options(fn() => CscCenter::distinct()->orderBy('district')->pluck('district', 'district'))
                    ->searchable(),

                SelectFilter::make('sub_district')
                    ->label('Sub-District')
                    ->options(fn() => CscCenter::distinct()->orderBy('sub_district')->pluck('sub_district', 'sub_district'))
                    ->searchable(),

                SelectFilter::make('source')
                    ->options([
                        'locator.csccloud.in' => 'CSC Cloud Portal',
                        'self-registered'     => 'Self-Registered',
                        'admin'               => 'Added by Admin',
                    ]),

                TernaryFilter::make('is_verified')->label('Verified'),
                TernaryFilter::make('is_active')->label('Active'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('verify')
                    ->label('Verify')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->visible(fn(CscCenter $r) => !$r->is_verified)
                    ->requiresConfirmation()
                    ->action(fn(CscCenter $r) => $r->update(['is_verified' => true])),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('markVerified')
                        ->label('Mark as Verified')
                        ->icon('heroicon-o-check-badge')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(fn($records) => $records->each->update(['is_verified' => true])),
                    Tables\Actions\BulkAction::make('markActive')
                        ->label('Set Active')
                        ->icon('heroicon-o-check-circle')
                        ->action(fn($records) => $records->each->update(['is_active' => true])),
                    Tables\Actions\BulkAction::make('markInactive')
                        ->label('Set Inactive')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->action(fn($records) => $records->each->update(['is_active' => false])),
                ]),
            ])
            ->defaultSort('id', 'desc')
            ->searchable()
            ->persistFiltersInSession()
            ->striped();
    }

    // ── Pages ─────────────────────────────────────────────────────────────────

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListCscCenters::route('/'),
            'create' => Pages\CreateCscCenter::route('/create'),
            'view'   => Pages\ViewCscCenter::route('/{record}'),
            'edit'   => Pages\EditCscCenter::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
