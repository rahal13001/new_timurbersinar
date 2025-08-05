<?php

namespace App\Filament\Resources\PostResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CommentsRelationManager extends RelationManager
{
    protected static string $relationship = 'comments';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('commenter_name')
                    ->required()
                    ->label('Nama')
                    ->columnSpanFull()
                    ->maxLength(255),
                Forms\Components\Textarea::make('comment')
                    ->label('Komentar')
                    ->columnSpanFull()
                    ->required(),

                Forms\Components\Repeater::make('answers')
                    ->columnspanFull()
                    ->label('Jawaban')
                    ->relationship('answers')
                    ->schema([
                        Forms\Components\TextInput::make('answerer_name')
                            ->label('Nama Penjawab')
                            ->required(fn (Get $get): bool => (bool) $get('answer')),
                        Forms\Components\Textarea::make('answer')
                            ->label('Jawaban')
                            ->required(fn (Get $get): bool => (bool) $get('answerer_name')),
                    ])
                    ->collapsible()
                    ->itemLabel(fn (array $state): ?string => $state['answerer_name'] ?? null)
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('comment')
            ->columns([
                Tables\Columns\TextColumn::make('commenter_name')
                    ->label('Nama'),
                Tables\Columns\TextColumn::make('comment')
                    ->label('Komentar'),
                Tables\Columns\TextColumn::make('answers_count')
                    ->label('Jawaban')
                    ->counts('answers')
                    ->alignCenter()
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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

    public function isReadOnly(): bool
    {
        return false;
    }
}
