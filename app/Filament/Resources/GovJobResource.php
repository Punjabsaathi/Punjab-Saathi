<?php

namespace App\Filament\Resources;

// Save as: app/Filament/Resources/GovJobResource.php

use App\Filament\Resources\GovJobResource\Pages;
use App\Filament\Resources\GovJobResource\RelationManagers;
use App\Models\GovJob;
use App\Models\GovJobCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class GovJobResource extends Resource
{
    protected static ?string $model = GovJob::class;
    protected static ?string $navigationIcon      = 'heroicon-o-briefcase';
    protected static ?string $navigationGroup     = 'Jobs Module';
    protected static ?string $navigationLabel     = 'All Jobs';
    protected static ?int    $navigationSort       = 1;
    protected static ?string $modelLabel           = 'Government Job';
    protected static ?string $pluralModelLabel     = 'Government Jobs';
    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Tabs::make('Job Details')->tabs([

                // ── TAB 1: Basic Info ──────────────────────────
                Forms\Components\Tabs\Tab::make('Basic Info')
                    ->icon('heroicon-o-information-circle')
                    ->schema([
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\TextInput::make('title')
                                ->required()
                                ->maxLength(255)
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn ($state, Forms\Set $set) =>
                                    $set('slug', Str::slug($state))),

                            Forms\Components\TextInput::make('slug')
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->maxLength(255)
                                ->helperText('SEO-friendly URL. Auto-generated from title.'),
                        ]),

                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\Select::make('category_id')
                                ->label('Category')
                                ->options(GovJobCategory::where('is_active', true)->pluck('name', 'id'))
                                ->searchable()
                                ->required(),

                            Forms\Components\TextInput::make('department')
                                ->required()
                                ->maxLength(200)
                                ->placeholder('e.g. Punjab Subordinate Service Selection Board'),
                        ]),

                        Forms\Components\Grid::make(3)->schema([
                            Forms\Components\TextInput::make('ad_number')
                                ->label('Advertisement Number')
                                ->maxLength(100)
                                ->placeholder('e.g. PSSSB/2025/01'),

                            Forms\Components\TextInput::make('location')
                                ->maxLength(150)
                                ->placeholder('e.g. Punjab, India'),

                            Forms\Components\TextInput::make('total_posts')
                                ->label('Total Vacancies')
                                ->numeric()
                                ->required()
                                ->default(0),
                        ]),

                        Forms\Components\TextInput::make('salary_pay_scale')
                            ->label('Pay Scale / Salary')
                            ->maxLength(200)
                            ->placeholder('e.g. ₹10,300 – ₹34,800 + GP ₹3,800'),

                        Forms\Components\Textarea::make('short_description')
                            ->label('Short Description')
                            ->rows(2)
                            ->maxLength(500)
                            ->helperText('Shown on job listing cards. Keep it under 200 characters.')
                            ->columnSpanFull(),

                        Forms\Components\RichEditor::make('description')
                            ->label('Full Description')
                            ->toolbarButtons(['bold','italic','underline','bulletList','orderedList','link','h2','h3','undo','redo'])
                            ->columnSpanFull(),
                    ]),

                // ── TAB 2: Eligibility ─────────────────────────
                Forms\Components\Tabs\Tab::make('Eligibility')
                    ->icon('heroicon-o-user-circle')
                    ->schema([
                        Forms\Components\Textarea::make('qualification')
                            ->label('Education Qualification')
                            ->rows(3)
                            ->placeholder('e.g. 10+2 pass from a recognized board, or Graduation in any discipline'),

                        Forms\Components\Grid::make(3)->schema([
                            Forms\Components\TextInput::make('age_min')
                                ->label('Minimum Age')
                                ->numeric()
                                ->suffix('years'),

                            Forms\Components\TextInput::make('age_max')
                                ->label('Maximum Age')
                                ->numeric()
                                ->suffix('years'),

                            Forms\Components\TextInput::make('experience_required')
                                ->label('Experience Required')
                                ->placeholder('e.g. 2 years in relevant field'),
                        ]),

                        Forms\Components\Textarea::make('age_relaxation')
                            ->label('Age Relaxation Details')
                            ->rows(3)
                            ->placeholder('SC/ST: 5 years, OBC: 3 years, Ex-Serviceman: As per rules'),
                    ]),

                // ── TAB 3: Important Dates ─────────────────────
                Forms\Components\Tabs\Tab::make('Dates')
                    ->icon('heroicon-o-calendar')
                    ->schema([
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\DatePicker::make('publish_date')
                                ->label('Notification Date')
                                ->native(false),

                            Forms\Components\DatePicker::make('apply_start')
                                ->label('Application Start Date')
                                ->native(false),

                            Forms\Components\DatePicker::make('apply_end')
                                ->label('Last Date to Apply')
                                ->native(false),

                            Forms\Components\DatePicker::make('exam_date')
                                ->label('Exam Date')
                                ->native(false),
                        ]),
                    ]),

                // ── TAB 4: Application Process ─────────────────
                Forms\Components\Tabs\Tab::make('Application')
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        Forms\Components\Select::make('application_mode')
                            ->options(['online' => 'Online', 'offline' => 'Offline', 'both' => 'Both'])
                            ->default('online')
                            ->required(),

                        Forms\Components\TextInput::make('official_website')
                            ->label('Official Website URL')
                            ->url()
                            ->placeholder('https://sssb.punjab.gov.in'),

                        Forms\Components\Repeater::make('selection_process')
                            ->label('Selection Process Steps')
                            ->schema([
                                Forms\Components\TextInput::make('step')->required()->placeholder('e.g. Written Exam'),
                            ])
                            ->addActionLabel('Add Step')
                            ->defaultItems(0)
                            ->collapsible()
                            ->cloneable()
                            ->helperText('Add each selection stage separately'),

                        Forms\Components\Repeater::make('application_steps')
                            ->label('How to Apply — Steps')
                            ->schema([
                                Forms\Components\TextInput::make('step')->required()->placeholder('e.g. Visit official website'),
                            ])
                            ->addActionLabel('Add Step')
                            ->defaultItems(0)
                            ->collapsible()
                            ->cloneable(),

                        Forms\Components\Repeater::make('required_documents')
                            ->label('Required Documents')
                            ->schema([
                                Forms\Components\TextInput::make('document')->required()->placeholder('e.g. Aadhaar Card'),
                            ])
                            ->addActionLabel('Add Document')
                            ->defaultItems(0)
                            ->collapsible()
                            ->cloneable(),

                        Forms\Components\Section::make('Application Fee')->schema([
                            Forms\Components\Grid::make(4)->schema([
                                Forms\Components\TextInput::make('application_fee.general')
                                    ->label('General / OBC')->numeric()->prefix('₹')->default(0),
                                Forms\Components\TextInput::make('application_fee.sc_st')
                                    ->label('SC / ST')->numeric()->prefix('₹')->default(0),
                                Forms\Components\TextInput::make('application_fee.female')
                                    ->label('Female')->numeric()->prefix('₹')->default(0),
                                Forms\Components\TextInput::make('application_fee.ex_serviceman')
                                    ->label('Ex-Serviceman')->numeric()->prefix('₹')->default(0),
                            ]),
                        ]),
                    ]),

                // ── TAB 5: Syllabus & Exam Pattern ────────────
                Forms\Components\Tabs\Tab::make('Syllabus')
                    ->icon('heroicon-o-book-open')
                    ->schema([
                        Forms\Components\Section::make('Syllabus (Subject-wise)')->schema([
                            Forms\Components\KeyValue::make('syllabus')
                                ->label('Subject → Topics')
                                ->keyLabel('Subject Name')
                                ->valueLabel('Topics / Chapters')
                                ->addActionLabel('Add Subject')
                                ->helperText('e.g. Subject: "Mathematics", Topics: "Algebra, Trigonometry, Geometry"'),
                        ]),

                        Forms\Components\Section::make('Exam Pattern')->schema([
                            Forms\Components\Repeater::make('exam_pattern')
                                ->label('Exam Pattern Table')
                                ->schema([
                                    Forms\Components\Grid::make(4)->schema([
                                        Forms\Components\TextInput::make('subject')->required(),
                                        Forms\Components\TextInput::make('questions')->numeric(),
                                        Forms\Components\TextInput::make('marks')->numeric(),
                                        Forms\Components\TextInput::make('duration')->placeholder('e.g. 2 Hours'),
                                    ]),
                                ])
                                ->addActionLabel('Add Row')
                                ->defaultItems(0)
                                ->collapsible(),
                        ]),
                    ]),

                // ── TAB 6: Important Links ─────────────────────
                Forms\Components\Tabs\Tab::make('Links')
                    ->icon('heroicon-o-link')
                    ->schema([
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\TextInput::make('notification_link')
                                ->label('Notification PDF URL')->url()->placeholder('https://...'),
                            Forms\Components\TextInput::make('apply_link')
                                ->label('Apply Online URL')->url()->placeholder('https://...'),
                            Forms\Components\TextInput::make('syllabus_link')
                                ->label('Syllabus PDF URL')->url()->placeholder('https://...'),
                            Forms\Components\TextInput::make('correction_form_link')
                                ->label('Correction Form URL')->url()->placeholder('https://...'),
                            Forms\Components\TextInput::make('merit_list_link')
                                ->label('Merit List PDF URL')->url()->placeholder('https://...'),
                            Forms\Components\TextInput::make('cutoff_link')
                                ->label('Cut Off PDF URL')->url()->placeholder('https://...'),
                            Forms\Components\TextInput::make('previous_papers_link')
                                ->label('Previous Papers URL')->url()->placeholder('https://...'),
                        ]),
                    ]),

                // ── TAB 7: SEO ─────────────────────────────────
                Forms\Components\Tabs\Tab::make('SEO')
                    ->icon('heroicon-o-magnifying-glass')
                    ->schema([
                        Forms\Components\TextInput::make('meta_title')
                            ->label('Meta Title')
                            ->maxLength(70)
                            ->helperText('Leave blank to use job title. Max 70 characters.'),
                        Forms\Components\Textarea::make('meta_description')
                            ->label('Meta Description')
                            ->rows(2)
                            ->maxLength(160)
                            ->helperText('Max 160 characters.'),
                        Forms\Components\TextInput::make('meta_keywords')
                            ->label('Meta Keywords')
                            ->placeholder('psssb jobs, punjab govt jobs, clerk recruitment'),
                    ]),

                // ── TAB 8: Publish Settings ────────────────────
                Forms\Components\Tabs\Tab::make('Publish')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->schema([
                        Forms\Components\Grid::make(3)->schema([
                            Forms\Components\Select::make('status')
                                ->options([
                                    'active'   => 'Active',
                                    'upcoming' => 'Upcoming',
                                    'expired'  => 'Expired',
                                ])
                                ->default('upcoming')
                                ->required(),

                            Forms\Components\Toggle::make('is_published')
                                ->label('Published (visible on website)')
                                ->default(true)
                                ->inline(false),

                            Forms\Components\Toggle::make('is_featured')
                                ->label('Featured Job')
                                ->default(false)
                                ->inline(false),
                        ]),
                    ]),

            ])->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->limit(50)
                    ->description(fn ($record) => $record->department),

                Tables\Columns\TextColumn::make('category.name')
                    ->badge()
                    ->color('warning')
                    ->sortable(),

                Tables\Columns\TextColumn::make('total_posts')
                    ->label('Posts')
                    ->numeric()
                    ->sortable()
                    ->alignCenter(),

                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'success' => 'active',
                        'warning' => 'upcoming',
                        'danger'  => 'expired',
                    ]),

                Tables\Columns\IconColumn::make('is_published')
                    ->label('Live')
                    ->boolean(),

                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean(),

                Tables\Columns\TextColumn::make('apply_end')
                    ->label('Last Date')
                    ->date('d M Y')
                    ->sortable()
                    ->color(fn ($record) => $record->apply_end?->isPast() ? 'danger' : 'success'),

                Tables\Columns\TextColumn::make('views')
                    ->sortable()
                    ->label('Views'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name'),

                Tables\Filters\SelectFilter::make('status')
                    ->options(['active' => 'Active', 'upcoming' => 'Upcoming', 'expired' => 'Expired']),

                Tables\Filters\TernaryFilter::make('is_published')->label('Published'),
                Tables\Filters\TernaryFilter::make('is_featured')->label('Featured'),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('View')
                    ->icon('heroicon-o-eye')
                    ->url(fn ($record) => url('/jobs/' . $record->slug))
                    ->openUrlInNewTab(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('publish')
                        ->label('Publish Selected')
                        ->icon('heroicon-o-check-circle')
                        ->action(fn ($records) => $records->each->update(['is_published' => true]))
                        ->deselectRecordsAfterCompletion(),
                    Tables\Actions\BulkAction::make('unpublish')
                        ->label('Unpublish Selected')
                        ->icon('heroicon-o-x-circle')
                        ->action(fn ($records) => $records->each->update(['is_published' => false]))
                        ->deselectRecordsAfterCompletion(),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\AdmitCardsRelationManager::class,
            RelationManagers\AnswerKeysRelationManager::class,
            RelationManagers\ResultsRelationManager::class,
            RelationManagers\DocumentsRelationManager::class,
            RelationManagers\FaqsRelationManager::class,
            RelationManagers\UpdatesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListGovJobs::route('/'),
            'create' => Pages\CreateGovJob::route('/create'),
            'edit'   => Pages\EditGovJob::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('is_published', true)->where('status', 'active')->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }
}
