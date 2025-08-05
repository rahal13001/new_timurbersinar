<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PermitResource\Pages;
use App\Filament\Resources\PermitResource\RelationManagers;
use App\Models\City;
use App\Models\Permit;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PermitResource extends Resource
{
    protected static ?string $model = Permit::class;

    protected static ?string $navigationGroup = 'Pelayanan Hiu Dan Pari';

    protected static ?string $navigationIcon = 'heroicon-o-document-check';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Perizinan')
                    ->label('Informasi Perizinan')
                    ->collapsible()
                    ->schema([
                        Forms\Components\Select::make('permittype_id')
                            ->label('Jenis Perizinan')
                            ->relationship('permittype', 'permit_type')
                            ->required(),
                        Forms\Components\TextInput::make('permit_number')
                            ->label('Nomor Perizinan')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\DatePicker::make('permit_date')
                            ->label('Tanggal Perizinan')
                            ->required(),
                        Forms\Components\DatePicker::make('permit_expiry_date')
                            ->label('Berlaku Sampai')
                            ->required(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Informasi Pengiriman')
                    ->label('Informasi Pengiriman')
                    ->collapsible()
                    ->schema([
                        Forms\Components\Grid::make('Pengiriman')
                            ->columns(2)
                            ->schema([
                                Forms\Components\DatePicker::make('sending_date')
                                    ->label('Tanggal Pengiriman')
                                    ->required(),
                                Forms\Components\TextInput::make('applicant_name')
                                    ->label('Nama Pengirim')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\Select::make('hometown')
                                    ->label('Kota Asal')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->options(City::query()->pluck('city_name', 'city_name')->toArray()),
                                Forms\Components\TextInput::make('mode_of_transportation')
                                    ->label('Moda Transportasi')
                                    ->required()
                                    ->maxLength(255),
                            ]),

                        Forms\Components\Textarea::make('applicant_address')
                            ->label('Alamat Pengirim')
                            ->required()
                            ->columnSpanFull(),

                    ]),


                Forms\Components\Section::make('Informasi Penerima')
                    ->label('Informasi Penerima')
                    ->collapsible()
                    ->schema([
                        Forms\Components\Grid::make('Penerima')
                            ->columns(2)
                            ->schema([
                                Forms\Components\TextInput::make('recipient_name')
                                    ->label('Nama Penerima')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\Select::make('destination_city')
                                    ->label('Kota Tujuan')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->options(City::query()->pluck('city_name', 'city_name')->toArray()),
                                Forms\Components\TextInput::make('port_of_departure')
                                    ->label('Port Asal')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('port_of_arrival')
                                    ->label('Port Tujuan')
                                    ->required()
                                    ->maxLength(255),

                            ]),

                        Forms\Components\Textarea::make('recipient_address')
                            ->label('Alamat Penerima')
                            ->required()
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Repeater::make('species')
                    ->relationship('permitdetail')
                    ->columnSpanFull()
                    ->schema([
                        Forms\Components\Grid::make('Informasi Hewan')
                            ->columns(2)
                            ->schema([
                                Forms\Components\Select::make('species_id')
                                    ->label('Nama Latin')
                                    ->relationship('species', 'species_name')
                                    ->required()
                                    ->searchable(),
                                Forms\Components\Select::make('product_id')
                                    ->label('Produk')
                                    ->relationship('product', 'product_name')
                                    ->required()
                                    ->searchable()
                                    ->preload(),
                            ]),
                        Forms\Components\Grid::make('Jumlah')
                            ->columns(2)
                            ->schema([
                                Forms\Components\TextInput::make('quantity')
                                    ->label('Jumlah')
                                    ->numeric()
                                    ->required(),
                                Forms\Components\Select::make('unit')
                                    ->label('Satuan')
                                    ->options([
                                        'Kg' => 'Kg',
                                        'Liter' => 'Liter',
                                        'Ekor' => 'Ekor',
                                    ])
                                    ->required(),
                            ]),
                    ])
                    ->itemLabel(fn (array $state): ?string => $state['species.species_name'] ?? null),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('index')
                    ->label('#')
                    ->alignment(Alignment::Center)
                    ->rowIndex(),
                Tables\Columns\TextColumn::make('permittype.permit_type')
                    ->label('Jenis Perizinan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('permit_number')
                    ->label('Nomor Perizinan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('permit_date')
                    ->label('Tanggal Perizinan')
                    ->date('d-m-Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('permit_expiry_date')
                    ->label('Berlaku Sampai')
                    ->date('d-m-Y')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('sending_date')
                    ->label('Tanggal Pengiriman')
                    ->date('d-m-Y')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('applicant_name')
                    ->label('Nama Pengirim')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mode_of_transportation')
                    ->label('Moda Transportasi')
                    ->alignment(Alignment::Center)
                    ->searchable(),
                Tables\Columns\TextColumn::make('hometown')
                    ->label('Kota Asal')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('destination_city')
                    ->label('Kota Tujuan')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('port_of_departure')
                    ->label('Port Asal')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('port_of_arrival')
                    ->label('Port Tujuan')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('recipient_name')
                    ->label('Nama Penerima')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
            ])
            ->filters([
                //
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPermits::route('/'),
            'create' => Pages\CreatePermit::route('/create'),
            'view' => Pages\ViewPermit::route('/{record}'),
            'edit' => Pages\EditPermit::route('/{record}/edit'),
        ];
    }
}
