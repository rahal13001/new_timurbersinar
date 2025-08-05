<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SpeciesResource\Pages;
use App\Filament\Resources\SpeciesResource\RelationManagers;
use App\Models\Species;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SpeciesResource extends Resource
{
    protected static ?string $model = Species::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Pelayanan Hiu Dan Pari';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('group_id')
                    ->label('Nama Kelompok')
                    ->searchable()
                    ->preload()
                    ->relationship('group', 'group_name')
                    ->required(),
                Forms\Components\Select::make('family_id')
                    ->label('Nama Famili')
                    ->searchable()
                    ->preload()
                    ->relationship('family', 'family_name')
                    ->required(),
                Forms\Components\TextInput::make('genus_name')
                    ->label('Nama Genus')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('species_name')
                    ->label('Nama Latin')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('common_name')
                    ->label('Nama Umum')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('appendix')
                    ->label('Apendiks CITES')
                    ->options([
                        true => 'Apendiks CITES',
                        false => 'Non Apendiks CITES',
                    ])
                    ->default(true)
                    ->required(),
                Forms\Components\Select::make('appendix_grade')
                    ->label('Tingkat Apendiks')
                    ->options([
                        'I' => 'Apendiks I',
                        'II' => 'Apendiks II',
                        'III' => 'Apendiks III',
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('family.family_name')
                    ->label('Nama Famili')
                    ->searchable()
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('genus_name')
                    ->label('Nama Genus')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('species_name')
                    ->label('Nama Species')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('common_name')
                    ->label('Nama Lokal')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\IconColumn::make('appendix')
                    ->label('Apendiks CITES')
                    ->alignment(Alignment::Center)
                    ->boolean(),
                Tables\Columns\TextColumn::make('appendix_grade')
                    ->searchable()
                    ->alignment(Alignment::Center)
                    ->label('Tingkat Apendiks'),
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
            'index' => Pages\ManageSpecies::route('/'),
        ];
    }
}
