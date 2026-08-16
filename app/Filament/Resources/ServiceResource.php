<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Filament\Resources\ServiceResource\RelationManagers;
use App\Models\Service;
use App\Models\ServiceCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Services';


    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Tabs::make()->tabs([

                Forms\Components\Tabs\Tab::make('Basic Info')->schema([
                    Forms\Components\TextInput::make('title')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn ($set, $state) => $set('slug', \Illuminate\Support\Str::slug($state))),

                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(255),

                    Forms\Components\TextInput::make('tag')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\Select::make('category')
                        ->options(fn () => ServiceCategory::active()->orderBy('sort_order')->pluck('name', 'slug'))
                        ->searchable()
                        ->required()
                        ->helperText('Manage the list of categories under Services → Categories.'),

                    Forms\Components\TextInput::make('icon')
                        ->required()
                        ->maxLength(255)
                        ->default('fa-file'),

                    Forms\Components\TextInput::make('color')
                        ->required()
                        ->maxLength(255)
                        ->default('#fc5e28'),

                    Forms\Components\TextInput::make('sort_order')
                        ->required()
                        ->numeric()
                        ->default(0),

                    Forms\Components\Toggle::make('is_popular')->inline(false),
                    Forms\Components\Toggle::make('is_active')->default(true)->inline(false),
                ])->columns(2),

                Forms\Components\Tabs\Tab::make('Details')->schema([
                    Forms\Components\Textarea::make('short_desc')
                        ->required()
                        ->rows(2)
                        ->columnSpanFull(),
                    Forms\Components\Textarea::make('overview')
                        ->required()
                        ->rows(4)
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('processing_time')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('fee_range')
                        ->maxLength(255),
                    Forms\Components\Textarea::make('fee_note')
                        ->columnSpanFull(),
                    Forms\Components\Textarea::make('eligibility')
                        ->columnSpanFull(),
                ])->columns(2),

                Forms\Components\Tabs\Tab::make('Documents')->schema([
                    Forms\Components\Repeater::make('documents')
                        ->relationship('documents')
                        ->schema([
                            Forms\Components\TextInput::make('label')->required()->columnSpan(2),
                            Forms\Components\TextInput::make('note')->columnSpan(2),
                            Forms\Components\Toggle::make('is_mandatory')->default(true)->columnSpan(1),
                            Forms\Components\TextInput::make('sort_order')->numeric()->default(0)->columnSpan(1),
                        ])
                        ->columns(3)
                        ->orderColumn('sort_order')
                        ->columnSpanFull()
                        ->defaultItems(0),
                ]),

                Forms\Components\Tabs\Tab::make('FAQs')->schema([
                    Forms\Components\Repeater::make('faqs')
                        ->relationship('faqs')
                        ->schema([
                            Forms\Components\TextInput::make('question')->required()->columnSpan(2),
                            Forms\Components\Textarea::make('answer')->required()->rows(3)->columnSpan(2),
                            Forms\Components\TextInput::make('sort_order')->numeric()->default(0)->columnSpan(1),
                        ])
                        ->columns(2)
                        ->orderColumn('sort_order')
                        ->columnSpanFull()
                        ->defaultItems(0),
                ]),

                Forms\Components\Tabs\Tab::make('Image')->schema([
                    Forms\Components\Placeholder::make('og_image_preview')
                        ->label('Service Image')
                        ->helperText('Filament\'s native upload field hangs on this environment, so this embeds the working plain-upload page directly — it\'ll refresh this page automatically once you upload.')
                        ->content(fn (?Service $record) => $record
                            ? new \Illuminate\Support\HtmlString(
                                '<iframe src="'.route('admin.services.image.edit', $record).'" '
                                .'style="width:100%;max-width:480px;height:360px;border:1px solid #e5e7eb;border-radius:8px;"></iframe>'
                            )
                            : 'Save the service first, then an upload box will appear here.'
                        )
                        ->columnSpanFull(),
                ]),

                Forms\Components\Tabs\Tab::make('SEO')->schema([
                    Forms\Components\TextInput::make('meta_title')->maxLength(255),
                    Forms\Components\TextInput::make('meta_keywords')->maxLength(255),
                    Forms\Components\Textarea::make('meta_description')->columnSpanFull(),
                ])->columns(2),

            ])->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tag')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category')
                    ->searchable(),
                Tables\Columns\TextColumn::make('icon')
                    ->searchable(),
                Tables\Columns\TextColumn::make('color')
                    ->searchable(),
                Tables\Columns\TextColumn::make('processing_time')
                    ->searchable(),
                Tables\Columns\TextColumn::make('fee_range')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_popular')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('meta_title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('meta_keywords')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('og_image'),
                Tables\Columns\TextColumn::make('sort_order')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
