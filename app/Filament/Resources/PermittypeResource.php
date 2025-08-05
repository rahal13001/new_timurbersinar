<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PermittypeResource\Pages;
use App\Filament\Resources\PermittypeResource\RelationManagers;
use App\Models\Permittype;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PermittypeResource extends Resource
{
    protected static ?string $model = Permittype::class;
    protected static ?string $navigationGroup = 'Pelayanan Hiu Dan Pari';

    protected static ?string $navigationIcon = 'heroicon-o-document';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('permit_type')
                    ->required()
                    ->label('Nama Perizinan')
                    ->columnSpanFull()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('permit_type')
                    ->label('Nama Perizinan')
                    ->sortable()
                    ->searchable(),
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
            'index' => Pages\ManagePermittypes::route('/'),
        ];
    }
}
