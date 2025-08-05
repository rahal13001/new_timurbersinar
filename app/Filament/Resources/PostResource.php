<?php

namespace App\Filament\Resources;

use AmidEsfahani\FilamentTinyEditor\TinyEditor;
use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Filament\Resources\PostResource\RelationManagers\CommentsRelationManager;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Contracts\View\View;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Columns\Layout\Grid;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Filament\Infolists\Infolist;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;
    protected static ?string $navigationGroup = 'Article';
    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                 Forms\Components\Grid::make(3) // Membuat grid dengan 3 kolom
                ->schema([
                    Forms\Components\Section::make('Informasi Penulisan')
                        ->columnSpan(2) // Mengambil 2 dari 3 kolom
                        ->schema([
                            Forms\Components\TextInput::make('post_author')
                                ->label('Penulis')
                                ->required()
                                ->columnSpanFull() // Ini akan mengambil seluruh lebar kolom di dalam section ini
                                ->maxLength(255),

                            Forms\Components\Select::make('users.name')
                                ->label('Penanggung jawab tulisan')
                                ->relationship(
                                    name : 'users',
                                    titleAttribute: 'name',
                                    modifyQueryUsing: fn ($query) => $query->where('status', 1),
                                )
                                ->required()
                                ->columnSpanFull()
                                ->default([Auth::user()->id])
                                ->searchable()
                                ->preload()
                                ->multiple(),

                            Forms\Components\TextInput::make('post_title')
                                ->label('Judul')
                                ->required()
                                ->columnSpanFull() // Ini akan mengambil seluruh lebar kolom di dalam section ini
                                ->maxLength(255),
                        ]),
                     Forms\Components\Section::make('Informasi Penayangan')
                        ->columnSpan(1) // Mengambil 1 dari 3 kolom
                        ->schema([
                             Forms\Components\Toggle::make('is_publish')
                                 ->label('Publikasikan Artikel') // Label yang lebih deskriptif
                                 ->helperText('Aktifkan agar artikel dapat dilihat publik.'),

                             Forms\Components\DatePicker::make('post_date')
                                ->label('Tanggal')
                                ->required(),

                             Forms\Components\Select::make('category.category_name')
                                 ->label('Kategori')
                                 ->relationship('category', 'category_name')
                                 ->searchable()
                                 ->preload()
                                 ->multiple()
                                 ->required(),

                        ]),
                ]),


            Forms\Components\Section::make('Artikel')
                ->schema([
                    TinyEditor::make('post_content')
                        ->label('Isi Artikel')
                        ->fileAttachmentsDisk('public')
                        ->fileAttachmentsVisibility('public')
                        ->fileAttachmentsDirectory('content_uploads')
                        ->profile('full')
                        ->columnSpan('full')
                        ->required(),

                    Forms\Components\FileUpload::make('post_image')
                        ->label('Gambar')
                        ->columnSpanFull()
                        ->image()
                        ->disk('public')
                        ->directory('post_image')
                        ->visibility('public')
                        ->required(),

                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\Layout\Stack::make([
                    Tables\Columns\ImageColumn::make('post_image')
                        ->height('100%')
                        ->width('100%'),
                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('post_title')
                            ->sortable()
                            ->label('Judul')
                            ->limit(60)
                            ->tooltip(function (TextColumn $column): ?string {
                                $state = $column->getState();

                                if (strlen($state) <= $column->getCharacterLimit()) {
                                    return null;
                                }
                                // Only render the tooltip if the column content exceeds the length limit.
                                return $state;
                            })
                            ->searchable()
                            ->weight(FontWeight::Bold),
                        Tables\Columns\TextColumn::make('post_author')
                            ->color('gray')
                            ->limit(30)
                            ->tooltip(function (TextColumn $column): ?string {
                                $state = $column->getState();

                                if (strlen($state) <= $column->getCharacterLimit()) {
                                    return null;
                                }
                                // Only render the tooltip if the column content exceeds the length limit.
                                return $state;
                            }),
                        Tables\Columns\IconColumn::make('is_publish')
                            ->label('Tayang')
                            ->boolean(),
                    ]),
                ])->space(3),
                Tables\Columns\Layout\Panel::make([
                    Tables\Columns\Layout\Split::make([
                        Tables\Columns\TextColumn::make('post_date')
                            ->label('Tanggal')
                            ->sortable()
                            ->date('d-m-Y'),


                        Tables\Columns\TextColumn::make('post_views')
                            ->label('Views')
                            ->prefix('Pembaca ')
                            ->numeric()
                            ->sortable(),
                    ]),
                ])->collapsible(),

            ])
            ->filters([
                SelectFilter::make('category_id')
                    ->label('Kategori')
                    ->multiple()
                    ->preload()
                    ->relationship('category', 'category_name'),

                SelectFilter::make('is_publish')
                    ->label('Tayang')
                    ->options([
                        '1' => 'Tayang',
                        '0' => 'Tidak',
                    ]),
                SelectFilter::make('users.name')
                    ->label('Penanggung Jawab Tulisan')
                    ->relationship(
                        name : 'users',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn ($query) => $query->where('status', 1),
                    )
                    ->multiple()
                    ->searchable()
                    ->preload(),

                Filter::make('post_date')
                    ->label('Tanggal Pembuatan')
                    ->form([
                        DatePicker::make('post_date_from')
                            ->label('Tanggal Buat Dari'),
                        DatePicker::make('post_date_until')
                            ->label('Tanggal Buat Sampai'),
                    ])
                    ->indicateUsing(function (array $data): array {
                        $post = [];

                        if ($data['post_date_from'] ?? null) {
                            $post[] = Tables\Filters\Indicator::make('Tanggal Buat Dari ' . Carbon::parse($data['post_date_from'])->toFormattedDateString())
                                ->removeField('from');
                        }

                        if ($data['post_date_until'] ?? null) {
                            $post[] = Tables\Filters\Indicator::make('Tanggal Buat Sampai ' . Carbon::parse($data['post_date_until'])->toFormattedDateString())
                                ->removeField('until');
                        }

                        return $post;
                    })
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['post_date_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('post_date', '>=', $date),
                            )
                            ->when(
                                $data['post_date_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('post_date', '<=', $date),
                            );
                    }),

            ])
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([

                Section::make('Informasi Penulisan')
                    ->schema([
                        TextEntry::make('post_title')
                        ->label('Judul')
                        ->weight(FontWeight::Bold),

                        TextEntry::make('post_author')
                            ->label('Penulis')
                            ->weight(FontWeight::Bold),

                        TextEntry::make('users.name')
                            ->listWithLineBreaks()
                            ->bulleted()
                            ->weight(FontWeight::Bold)
                            ->label('Penanggung Jawab Tulisan'),

                        TextEntry::make('post_date')
                            ->label('Tanggal')
                            ->weight(FontWeight::Bold)
                            ->date('d-m-Y'),
                    ])
                ->collapsible(),

                Section::make('Informasi Penayangan')
                    ->schema([
                        IconEntry::make('is_publish')
                            ->boolean()
                            ->trueIcon('heroicon-o-check-badge')
                            ->falseIcon('heroicon-o-x-mark')
                            ->label('Tayang'),

                        TextEntry::make('post_views')
                            ->weight(FontWeight::Bold)
                            ->label('Views'),

                        TextEntry::make('category.category_name')
                            ->listWithLineBreaks()
                            ->bulleted()
                            ->weight(FontWeight::Bold)
                            ->label('Kategori'),


                    ])
                    ->columns(2)
                    ->collapsible(),

                Section::make('Gambar Display')
                    ->schema([
                        ImageEntry::make('post_image')
                            ->label('Gambar')
                            ->width('100%')
                            ->height('100%')
                    ])
                    ->collapsible(),

                Section::make('Artikel')
                ->schema([
                    TextEntry::make('post_content')
                        ->formatStateUsing(fn (string $state): View => view(
                            'infolist.components.post_content',
                            ['state' => $state],
                        ))
                        ->label('Konten')
                ])


            ]);
    }

    public static function getRelations(): array
    {
        return [
            CommentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'view' => Pages\ViewPost::route('/{record}'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
