<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceCategoryResource\Pages;
use App\Models\ServiceCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ServiceCategoryResource extends Resource
{
    protected static ?string $model = ServiceCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';
    protected static ?string $navigationGroup = 'Services';
    protected static ?string $navigationLabel = 'Categories';
    protected static ?int $navigationSort = 0;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Tabs::make()->tabs([

                Forms\Components\Tabs\Tab::make('Basic Info')->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn ($set, $state) => $set('slug', Str::slug($state))),

                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(255)
                        ->helperText('Must match the "category" value used on Services for this category to group under it.'),

                    Forms\Components\TextInput::make('icon')
                        ->placeholder('fa-id-card')
                        ->helperText('Font Awesome class, e.g. fa-id-card')
                        ->maxLength(100),

                    Forms\Components\TextInput::make('color')
                        ->label('Accent Color')
                        ->placeholder('#fc5e28')
                        ->maxLength(20),

                    Forms\Components\Textarea::make('description')
                        ->label('Short Description')
                        ->helperText('Shown on the homepage category card.')
                        ->rows(2)
                        ->columnSpanFull(),

                    Forms\Components\Textarea::make('subheading')
                        ->label('Section Subheading')
                        ->helperText('Shown under the category heading on the /services page.')
                        ->rows(2)
                        ->columnSpanFull(),

                    Forms\Components\TextInput::make('button_text')
                        ->label('Button Text')
                        ->placeholder('See All Services')
                        ->maxLength(255),

                    Forms\Components\Toggle::make('is_active')->default(true)->inline(false),
                    Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
                ])->columns(2),

                Forms\Components\Tabs\Tab::make('Image')->schema([
                    Forms\Components\Placeholder::make('image_preview')
                        ->label('Category Image')
                        ->helperText('Filament\'s native upload field hangs on this environment, so this embeds the working plain-upload page directly — it\'ll refresh this page automatically once you upload.')
                        ->content(fn (?ServiceCategory $record) => $record
                            ? new \Illuminate\Support\HtmlString(
                                '<iframe src="'.route('admin.service-categories.image.edit', $record).'" '
                                .'style="width:100%;max-width:480px;height:360px;border:1px solid #e5e7eb;border-radius:8px;"></iframe>'
                            )
                            : 'Save the category first, then an upload box will appear here.'
                        )
                        ->columnSpanFull(),
                ]),

            ])->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('slug')->searchable(),
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\IconColumn::make('is_active')->boolean()->label('Active'),
                Tables\Columns\TextColumn::make('sort_order')->label('Order')->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('sort_order')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index'  => Pages\ListServiceCategories::route('/'),
            'create' => Pages\CreateServiceCategory::route('/create'),
            'edit'   => Pages\EditServiceCategory::route('/{record}/edit'),
        ];
    }
}
