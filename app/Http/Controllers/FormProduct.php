<?php

namespace App\Http\Controllers;

use Filament\Forms\Set;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class FormProduct extends Controller
{
    static function formProduct(): array{
        return [
            TextInput::make('name')
            ->required()
            ->maxLength(150)
            ->live(onBlur: true)
            ->afterStateUpdated(
                function (Set $set, $state) {
                    $set('slug', Str::slug($state));
                }
            ),

        TextInput::make('slug')
            ->required()
            ->readOnly()
            ->maxLength(100)
            ,
        Select::make('uom_id')
        ->searchable()
        ->label('Unit of Measure')
        ->preload()
        ->createOptionForm(FormUom::formUom())
        ->relationship('uom','name'),

        Select::make('product_brand_id')
        ->searchable()
        ->preload()
        ->createOptionForm(FormProductBrand::formProductBrand())
        ->relationship('productBrand','name'),

        Select::make('product_category_id')
        ->searchable()
        ->preload()
        ->createOptionForm(FormProductCategory::getForm())
        ->relationship('productCategory','name')
        ,
        TextInput::make('price')
        ->required()
        ->numeric()
        ->minValue(0)     ,
        TextInput::make('stock'),
        Select::make('pajak_id')
        ->relationship('pajak','name')
        ->preload()
        ->searchable()
        ->required(),
        Textarea::make('description')
        ->required()
        ->columnSpanFull(),

        Toggle::make('is_active')
            ->default(true)
            ->required(),
        ];
    }
}
