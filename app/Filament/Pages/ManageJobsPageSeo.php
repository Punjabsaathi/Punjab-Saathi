<?php

namespace App\Filament\Pages;

use App\Models\JobsPageSetting;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ManageJobsPageSeo extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon  = 'heroicon-o-magnifying-glass';
    protected static ?string $navigationGroup = 'Jobs Module';
    protected static ?string $navigationLabel = 'Jobs Page SEO';
    protected static ?int    $navigationSort  = 10;
    protected static ?string $title           = 'Jobs Page — SEO & Content';

    protected static string $view = 'filament.pages.manage-jobs-page-seo';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(JobsPageSetting::current()->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Jobs Page Settings')->columnSpanFull()->tabs([

                    Forms\Components\Tabs\Tab::make('Meta Tags')
                        ->icon('heroicon-o-tag')
                        ->schema([
                            Forms\Components\TextInput::make('meta_title')
                                ->label('Meta Title')
                                ->maxLength(255)
                                ->helperText('Shown as the browser tab title and Google search result title for /jobs.'),
                            Forms\Components\Textarea::make('meta_description')
                                ->label('Meta Description')
                                ->rows(2)
                                ->maxLength(320),
                            Forms\Components\TextInput::make('meta_keywords')
                                ->label('Meta Keywords'),
                        ]),

                    Forms\Components\Tabs\Tab::make('Headings')
                        ->icon('heroicon-o-bars-3-bottom-left')
                        ->schema([
                            Forms\Components\TextInput::make('h1')
                                ->label('Page H1')
                                ->maxLength(255)
                                ->helperText('The main heading shown at the top of the page.'),
                            Forms\Components\TextInput::make('hero_subtitle')
                                ->label('Hero Subtitle')
                                ->maxLength(255),
                        ]),

                    Forms\Components\Tabs\Tab::make('Content Blocks')
                        ->icon('heroicon-o-document-text')
                        ->schema([
                            Forms\Components\RichEditor::make('intro_content')
                                ->label('Intro Content (shown above the job listings)')
                                ->helperText('Keep this short — 2 to 3 sentences. Long text here pushes the actual job listings down the page.')
                                ->toolbarButtons(['bold', 'italic', 'link'])
                                ->columnSpanFull(),
                            Forms\Components\RichEditor::make('how_to_apply_content')
                                ->label('"How to Apply" Content (shown below the listings)')
                                ->toolbarButtons(['bold', 'italic', 'bulletList', 'orderedList', 'link', 'h3'])
                                ->columnSpanFull(),
                            Forms\Components\RichEditor::make('eligibility_content')
                                ->label('"Eligibility" Content (shown below the listings)')
                                ->toolbarButtons(['bold', 'italic', 'bulletList', 'orderedList', 'link', 'h3'])
                                ->columnSpanFull(),
                        ]),

                    Forms\Components\Tabs\Tab::make('FAQs')
                        ->icon('heroicon-o-question-mark-circle')
                        ->schema([
                            Forms\Components\Repeater::make('faqs')
                                ->label('Frequently Asked Questions')
                                ->schema([
                                    Forms\Components\TextInput::make('question')->required()->columnSpanFull(),
                                    Forms\Components\Textarea::make('answer')->required()->rows(2)->columnSpanFull(),
                                ])
                                ->addActionLabel('Add FAQ')
                                ->collapsible()
                                ->reorderable()
                                ->defaultItems(0)
                                ->columnSpanFull(),
                        ]),

                    Forms\Components\Tabs\Tab::make('Schema')
                        ->icon('heroicon-o-code-bracket')
                        ->schema([
                            Forms\Components\Toggle::make('schema_enabled')
                                ->label('Emit structured data (Breadcrumb / ItemList / FAQ) on this page')
                                ->default(true)
                                ->inline(false),
                        ]),

                ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        JobsPageSetting::current()->update($this->form->getState());

        Notification::make()
            ->title('Jobs page settings saved')
            ->success()
            ->send();
    }
}
