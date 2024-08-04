<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;

class formAddress extends Controller
{
    static function getFormAddress():array{
        return[


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
        ];
    }
}
