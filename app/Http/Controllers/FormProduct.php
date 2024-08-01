<?php

namespace App\Http\Controllers;

use Filament\Forms\Set;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;

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
        ->relationship('productBrand','name',
            fn (Builder $query )=> $query->where('is_active',true)

    ),

        Select::make('product_category_id')
        ->searchable()
        ->preload()
        ->createOptionForm(FormProductCategory::getForm())
        ->relationship('productCategory','name',
            fn (Builder $query )=> $query->where('is_active',true)
        )
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
        ->createOptionForm(formPajak::getFormPajak())
        ->required(),
        Textarea::make('description')
        ->required()
        ->columnSpanFull(),
        FileUpload::make('product_img')
        ->directory('product_img')
        // ->required()
        ->multiple()
        ->image()
        ->imageEditor()
        ->maxSize(2048)
        ->maxFiles(5)
        // ->disk('local')
        ->columnSpanFull(),

        Toggle::make('is_active')
            ->default(true)
            ->required(),
        ];
    }
}
