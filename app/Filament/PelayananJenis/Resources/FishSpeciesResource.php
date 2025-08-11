<?php

namespace App\Filament\PelayananJenis\Resources;

use App\Filament\PelayananJenis\Resources\FishSpeciesResource\Pages;
use App\Filament\PelayananJenis\Resources\FishSpeciesResource\RelationManagers;
use App\Models\FishSpecies;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FishSpeciesResource extends Resource
{
    protected static ?string $model = FishSpecies::class;

    protected static ?string $navigationGroup = 'Data Dasar';
    protected static ?string $navigationIcon = 'phosphor-fish-bold';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('scientific_name')
                    ->label('Nama Ilmiah')
                    ->unique()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('common_name')
                    ->label('Nama Lokal')
                    ->maxLength(255),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('scientific_name')
                    ->label('Nama Ilmiah')
                    ->searchable(),
                Tables\Columns\TextColumn::make('common_name')
                    ->label('Nama Lokal')
                    ->searchable(),
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
            'index' => Pages\ManageFishSpecies::route('/'),
        ];
    }

    public static function getLabel(): ?string
    {
        $locale = app()->getLocale();
        if ($locale === 'id') {
            return "Jenis Ikan";
        }
        else
        {
            return "Fish Species";
        }
    }
}
