<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InquiryResource\Pages;
use App\Models\Inquiry;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class InquiryResource extends Resource
{
    protected static ?string $model = Inquiry::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';
    protected static ?string $navigationLabel = 'Inquiries';
    protected static ?string $navigationGroup = 'Applications';


    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('first_name')->required(),
            Forms\Components\TextInput::make('last_name'),
            Forms\Components\TextInput::make('phone')->required(),
            Forms\Components\Select::make('service')
                ->options([
                    'architecture' => 'Architecture',
                    'renovation'   => 'Renovation',
                    'construction' => 'Construction',
                    'interior'     => 'Interior & Exterior',
                    'other'        => 'Other Services',
                ]),
            Forms\Components\Textarea::make('message')->columnSpanFull(),
            Forms\Components\Select::make('status')
                ->options([
                    'new'         => 'New',
                    'in_progress' => 'In Progress',
                    'resolved'    => 'Resolved',
                ])
                ->default('new')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('first_name')->searchable(),
                Tables\Columns\TextColumn::make('last_name')->searchable(),
                Tables\Columns\TextColumn::make('phone'),
                Tables\Columns\TextColumn::make('service')
                    ->badge()
                    ->color('info'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state) => match ($state) {
                        'new'         => 'warning',
                        'in_progress' => 'info',
                        'resolved'    => 'success',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Submitted At')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'new'         => 'New',
                        'in_progress' => 'In Progress',
                        'resolved'    => 'Resolved',
                    ]),
                Tables\Filters\SelectFilter::make('service')
                    ->options([
                        'architecture' => 'Architecture',
                        'renovation'   => 'Renovation',
                        'construction' => 'Construction',
                        'interior'     => 'Interior & Exterior',
                        'other'        => 'Other Services',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListInquiries::route('/'),
            'create' => Pages\CreateInquiry::route('/create'),
            'view'   => Pages\ViewInquiry::route('/{record}'),
            'edit'   => Pages\EditInquiry::route('/{record}/edit'),
        ];
    }

    // Show badge count on sidebar nav
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'new')->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }
}