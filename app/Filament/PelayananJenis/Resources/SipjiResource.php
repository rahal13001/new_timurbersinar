<?php

namespace App\Filament\PelayananJenis\Resources;

use App\Filament\PelayananJenis\Resources\SipjiResource\Pages;
use App\Filament\PelayananJenis\Resources\SipjiResource\RelationManagers;
use App\Models\Sipji;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SipjiResource extends Resource
{
    protected static ?string $model = Sipji::class;
    protected static ?string $navigationGroup = 'Data Dasar';
    protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('partner_id')
                    ->label('Nama Pelaku Usaha')
                    ->relationship('partner', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('permit_number')
                    ->label('Nomor Sipji')
                    ->unique()
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('issue_date')
                    ->label('Tanggal Terbit')
                    ->required()
                    ->name('Tanggal Buat'),
                Forms\Components\DatePicker::make('expiry_date')
                    ->label('Tanggal Expire')
                    ->required()
                    ->name('Tanggal Kadaluarsa'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('partner.name')
                    ->label('Nama Pelaku Usaha')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('permit_number')
                    ->label('Nomor Sipji')
                    ->searchable(),
                Tables\Columns\TextColumn::make('issue_date')
                    ->label('Tanggal Buat')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('expiry_date')
                    ->label('Tanggal Expire')
                    ->date()
                    ->sortable(),
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
            'index' => Pages\ManageSipjis::route('/'),
        ];
    }
}
