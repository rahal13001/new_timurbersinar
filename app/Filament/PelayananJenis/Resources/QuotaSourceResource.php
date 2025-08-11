<?php

namespace App\Filament\PelayananJenis\Resources;

use App\Filament\PelayananJenis\Resources\QuotaSourceResource\Pages;
use App\Filament\PelayananJenis\Resources\QuotaSourceResource\RelationManagers;
use App\Models\QuotaSource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuotaSourceResource extends Resource
{
    protected static ?string $model = QuotaSource::class;
    protected static ?string $navigationGroup = 'Data Dasar';
    protected static ?string $navigationIcon = 'phosphor-fish-fill';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Asal Kuota')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('year')
                    ->label('Tahun'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('year'),
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
            'index' => Pages\ManageQuotaSources::route('/'),
        ];
    }

    public static function getLabel(): ?string
    {
        $locale = app()->getLocale();
        if ($locale === 'id') {
            return "Sumber Kuota";
        }
        else
        {
            return "Quota Source";
        }
    }
}
