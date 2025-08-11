<?php

namespace App\Filament\PelayananJenis\Resources;

use App\Filament\PelayananJenis\Resources\PartnerResource\Pages;
use App\Filament\PelayananJenis\Resources\PartnerResource\RelationManagers;
use App\Models\Partner;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PartnerResource extends Resource
{
    protected static ?string $model = Partner::class;

    protected static ?string $navigationGroup = 'Data Dasar';
    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->label('Nama Pelaku Usaha')
                    ->maxLength(255),
                Forms\Components\Select::make('type')
                    ->label('Bentuk Usaha')
                    ->required()
                    ->options([
                            'Perseorangan' => 'Perseorangan',
                            'Perusahaan' => 'Perusahaan',
                     ]
                    ),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Bentuk Usaha')
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
            'index' => Pages\ManagePartners::route('/'),
        ];
    }

    public static function getLabel(): ?string
    {
        $locale = app()->getLocale();
        if ($locale === 'id') {
            return "Pelaku Usaha";
        }
        else
        {
            return "Partner";
        }
    }
}
