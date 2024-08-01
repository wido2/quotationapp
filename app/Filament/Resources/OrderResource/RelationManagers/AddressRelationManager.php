<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\ToggleButtons;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class AddressRelationManager extends RelationManager
{
    protected static string $relationship = 'address';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make('order_id')
                ->default(),
                Select::make('customer_id')
                ->required()
                ->preload()
                ->searchable( )
                ->relationship('customer','name'),
                TextInput::make('address')
                ->required()
                ->label('Address ')
                ->maxLength(255),
                TextInput::make('city')
                ->label('City')
                ->required(),
                TextInput::make('state')
                ->label('Provinsi')
                ->required(),
                TextInput::make('country')
                ->label('Country')
                ->required()
                ->default('Indonesia'),
                TextInput::make('zip_code')
                ->label('Zip Code')
                ->maxLength(7)
                ->required(),
                ToggleButtons::make('type')
                ->options([
                    'Home'=>'Home',
                    'Office'=>'Office',
                    'Invoice Address'=>'Invoice Address',
                    'Delivery Address' => 'Delivery Address',
                    'Other'=>'Other'
                ])
                ->required()
                ->default('Office')
                ->icons([
                    'Home' => 'heroicon-o-home',
                    'Office' => 'heroicon-o-building-office-2',
                    'Invoice Address' => 'heroicon-o-document-currency-dollar',
                    'Delivery Address' => 'heroicon-o-truck',
                    'Other'=>'heroicon-o-map-pin'

                ])
                ->colors([
                    'Home' => 'primary',
                    'Office' => 'success',
                    'Invoice Address' => 'warning',
                    'Delivery Address' => 'info',
                    'Other'=>'danger'
                    ])
                ->inline()
                ->columnSpanFull(),
                Toggle::make('is_default')
                ->label('Is Default?')
                ->required()
                ->default(false),



            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('customer.name')
                ->searchable()
                ->sortable(),
                TextColumn::make('address')
                ->searchable()
                ->limit(15)
                ->sortable(),
                TextColumn::make('city')
                ->searchable()
                ->sortable(),
                TextColumn::make('state')
                ->searchable()
                ->sortable(),
                TextColumn::make('country')
                ->searchable()
                ->sortable(),
                TextColumn::make('zip_code')
                ->searchable()
                ->sortable(),
                ToggleColumn::make('is_default')
                ->label('Default'),
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
}
