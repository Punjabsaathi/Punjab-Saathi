<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogCommentResource\Pages;
use App\Models\BlogComment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BlogCommentResource extends Resource
{
    protected static ?string $model = BlogComment::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $navigationLabel = 'Comments';
    protected static ?string $navigationGroup = 'Blogs';
    

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'pending')->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('blog_id')
                ->relationship('blog', 'title')
                ->disabled(),

            Forms\Components\TextInput::make('name')->disabled(),
            Forms\Components\TextInput::make('email')->disabled(),

            Forms\Components\Textarea::make('comment')
                ->rows(4)
                ->disabled()
                ->columnSpanFull(),

            Forms\Components\Select::make('status')
                ->options([
                    'pending'  => 'Pending',
                    'approved' => 'Approved',
                    'rejected' => 'Rejected',
                ])
                ->required()
                ->native(false),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('blog.title')
                    ->label('Post')
                    ->limit(25)
                    ->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('comment')
                    ->label('Comment')
                    ->limit(50),

                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger'  => 'rejected',
                    ]),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Submitted')
                    ->dateTime('d M Y, h:i A')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending'  => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->visible(fn ($record) => $record->status !== 'approved')
                    ->action(fn ($record) => $record->update(['status' => 'approved'])),

                Tables\Actions\Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-mark')
                    ->color('danger')
                    ->visible(fn ($record) => $record->status !== 'rejected')
                    ->action(fn ($record) => $record->update(['status' => 'rejected'])),

                Tables\Actions\Action::make('reply')
                    ->label('Reply')
                    ->icon('heroicon-o-chat-bubble-left')
                    ->color('info')
                    ->form([
                        Forms\Components\Placeholder::make('original')
                            ->label('Replying to')
                            ->content(fn ($record) => '"' . $record->comment . '" — ' . $record->name),

                        Forms\Components\TextInput::make('name')
                            ->label('Your Name')
                            ->default('Punjab Seva Kendra')
                            ->required(),

                        Forms\Components\TextInput::make('email')
                            ->label('Your Email')
                            ->default(fn () => auth()->user()->email)
                            ->email()
                            ->required(),

                        Forms\Components\Textarea::make('comment')
                            ->label('Your Reply')
                            ->rows(4)
                            ->required(),
                    ])
                    ->action(function ($record, array $data) {
                        BlogComment::create([
                            'blog_id'    => $record->blog_id,
                            'parent_id'  => $record->id,
                            'name'       => $data['name'],
                            'email'      => $data['email'],
                            'comment'    => $data['comment'],
                            'status'     => 'approved',
                            'ip_address' => request()->ip(),
                        ]);
                    })
                    ->successNotificationTitle('Reply posted successfully'),

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
            'index' => Pages\ListBlogComments::route('/'),
            'edit'  => Pages\EditBlogComment::route('/{record}/edit'),
        ];
    }
}